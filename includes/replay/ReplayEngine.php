<?php
/**
 * Market replay engine — rolling delayed buffer, ingest, and API payloads.
 */

require_once __DIR__ . '/ProviderInterface.php';
require_once __DIR__ . '/providers/BinanceProvider.php';
require_once __DIR__ . '/providers/YahooProvider.php';

class MarketReplayEngine
{
    public const RETENTION_SECONDS = 86400; // 24 hours
    public const INGEST_LOOKBACK_SECONDS = 300; // 5 minutes
    public const DEFAULT_CHART_WINDOW = 1800; // 30 minutes
    public const CACHE_TTL_SECONDS = 3;
    public const HEALTH_WINDOW_SECONDS = 1800; // 30 min for health calc

    /** @var array<string, MarketReplayProviderInterface> */
    private static $providers = [];

    public static function provider(string $name): MarketReplayProviderInterface
    {
        if (!isset(self::$providers[$name])) {
            switch ($name) {
                case 'yahoo':
                    self::$providers[$name] = new YahooReplayProvider();
                    break;
                case 'binance':
                default:
                    self::$providers[$name] = new BinanceReplayProvider();
                    break;
            }
        }
        return self::$providers[$name];
    }

    public static function ensureSchema(PDO $pdo): void
    {
        static $done = false;
        if ($done) {
            return;
        }
        $done = true;

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS market_replay_candles (
              provider VARCHAR(16) NOT NULL,
              symbol VARCHAR(32) NOT NULL,
              ts INT UNSIGNED NOT NULL,
              open DECIMAL(20,8) NOT NULL,
              high DECIMAL(20,8) NOT NULL,
              low DECIMAL(20,8) NOT NULL,
              close DECIMAL(20,8) NOT NULL,
              volume DECIMAL(24,8) NOT NULL DEFAULT 0,
              PRIMARY KEY (provider, symbol, ts),
              KEY idx_symbol_ts (symbol, ts)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS market_replay_meta (
              provider VARCHAR(16) NOT NULL,
              symbol VARCHAR(32) NOT NULL,
              last_ingest_at INT UNSIGNED NOT NULL DEFAULT 0,
              last_candle_ts INT UNSIGNED NOT NULL DEFAULT 0,
              buffer_health_pct TINYINT UNSIGNED NOT NULL DEFAULT 100,
              PRIMARY KEY (provider, symbol)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );
    }

    /**
     * @param array{provider:string,symbol:string,interval?:string,delay_seconds?:int,enabled?:bool} $replay
     */
    public static function ingestInstrument(PDO $pdo, array $replay): int
    {
        self::ensureSchema($pdo);

        $providerName = $replay['provider'] ?? 'binance';
        $symbol = $replay['symbol'] ?? '';
        $interval = $replay['interval'] ?? ($providerName === 'binance' ? '1s' : '1m');
        if ($symbol === '') {
            return 0;
        }

        $now = time();
        $fromTs = $now - self::INGEST_LOOKBACK_SECONDS;
        $provider = self::provider($providerName);
        $candles = $provider->fetchCandles($symbol, $interval, $fromTs, $now);
        $upserted = self::upsertCandles($pdo, $providerName, $symbol, $candles);

        $health = self::computeBufferHealth($pdo, $providerName, $symbol, $interval, $now);
        $lastCandleTs = 0;
        if ($candles !== []) {
            $lastCandleTs = (int) end($candles)['time'];
        }

        $stmt = $pdo->prepare(
            'INSERT INTO market_replay_meta (provider, symbol, last_ingest_at, last_candle_ts, buffer_health_pct)
             VALUES (?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
               last_ingest_at = VALUES(last_ingest_at),
               last_candle_ts = GREATEST(last_candle_ts, VALUES(last_candle_ts)),
               buffer_health_pct = VALUES(buffer_health_pct)'
        );
        $stmt->execute([$providerName, $symbol, $now, $lastCandleTs, $health]);

        self::pruneOldCandles($pdo, $providerName, $symbol, $now - self::RETENTION_SECONDS);

        return $upserted;
    }

    public static function runIngestAll(PDO $pdo): array
    {
        require_once dirname(__DIR__) . '/market-instruments.php';

        $results = [];
        foreach (market_replay_enabled_instruments() as $instrument) {
            $replay = $instrument['replay'];
            $key = ($replay['provider'] ?? '') . ':' . ($replay['symbol'] ?? '');
            try {
                $results[$key] = self::ingestInstrument($pdo, $replay);
            } catch (Throwable $e) {
                $results[$key] = 'error: ' . $e->getMessage();
            }
            usleep(250000);
        }
        return $results;
    }

    /**
     * @param array<int, array{time:int,open:float,high:float,low:float,close:float,volume:float}> $candles
     */
    public static function upsertCandles(PDO $pdo, string $provider, string $symbol, array $candles): int
    {
        if ($candles === []) {
            return 0;
        }

        $sql = 'INSERT INTO market_replay_candles (provider, symbol, ts, open, high, low, close, volume)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                  open = VALUES(open),
                  high = VALUES(high),
                  low = VALUES(low),
                  close = VALUES(close),
                  volume = VALUES(volume)';
        $stmt = $pdo->prepare($sql);
        $count = 0;

        foreach ($candles as $c) {
            $stmt->execute([
                $provider,
                $symbol,
                (int) $c['time'],
                $c['open'],
                $c['high'],
                $c['low'],
                $c['close'],
                $c['volume'],
            ]);
            $count++;
        }

        return $count;
    }

    public static function pruneOldCandles(PDO $pdo, string $provider, string $symbol, int $beforeTs): void
    {
        $stmt = $pdo->prepare(
            'DELETE FROM market_replay_candles WHERE provider = ? AND symbol = ? AND ts < ?'
        );
        $stmt->execute([$provider, $symbol, max(0, $beforeTs)]);
    }

    public static function computeBufferHealth(PDO $pdo, string $provider, string $symbol, string $interval, int $now): int
    {
        $step = ($interval === '1s') ? 1 : 60;
        $fromTs = $now - self::HEALTH_WINDOW_SECONDS;
        $expected = (int) max(1, floor(self::HEALTH_WINDOW_SECONDS / $step));

        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM market_replay_candles
             WHERE provider = ? AND symbol = ? AND ts >= ? AND ts <= ?'
        );
        $stmt->execute([$provider, $symbol, $fromTs, $now]);
        $actual = (int) $stmt->fetchColumn();

        return (int) max(0, min(100, round(($actual / $expected) * 100)));
    }

    /**
     * @param array{provider:string,symbol:string,interval?:string,delay_seconds?:int} $replay
     */
    public static function backfill(PDO $pdo, array $replay, int $fromTs, int $toTs): int
    {
        $providerName = $replay['provider'] ?? 'binance';
        $symbol = $replay['symbol'] ?? '';
        $interval = $replay['interval'] ?? ($providerName === 'binance' ? '1s' : '1m');
        if ($symbol === '') {
            return 0;
        }

        $provider = self::provider($providerName);
        $candles = $provider->fetchCandles($symbol, $interval, $fromTs, $toTs);
        return self::upsertCandles($pdo, $providerName, $symbol, $candles);
    }

    /**
     * @param array{provider:string,symbol:string,interval?:string,delay_seconds?:int} $replay
     */
    public static function getReplayPayload(PDO $pdo, array $replay, int $chartWindow = self::DEFAULT_CHART_WINDOW): array
    {
        self::ensureSchema($pdo);

        $providerName = $replay['provider'] ?? 'binance';
        $symbol = $replay['symbol'] ?? '';
        $interval = $replay['interval'] ?? ($providerName === 'binance' ? '1s' : '1m');
        $delay = (int) ($replay['delay_seconds'] ?? 900);

        $serverTime = time();
        $displayTime = $serverTime - $delay;
        $fromTs = max(0, $displayTime - $chartWindow);

        $stmt = $pdo->prepare(
            'SELECT ts, open, high, low, close, volume FROM market_replay_candles
             WHERE provider = ? AND symbol = ? AND ts >= ? AND ts <= ?
             ORDER BY ts ASC'
        );
        $stmt->execute([$providerName, $symbol, $fromTs, $displayTime]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $minExpected = ($interval === '1s') ? 60 : 5;
        if (count($rows) < $minExpected) {
            $backfillFrom = max(0, $displayTime - $chartWindow - 600);
            self::backfill($pdo, $replay, $backfillFrom, $displayTime);
            $stmt->execute([$providerName, $symbol, $fromTs, $displayTime]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $candles = [];
        foreach ($rows as $row) {
            $candles[] = [
                'time' => (int) $row['ts'],
                'open' => (float) $row['open'],
                'high' => (float) $row['high'],
                'low' => (float) $row['low'],
                'close' => (float) $row['close'],
                'volume' => (float) $row['volume'],
            ];
        }

        $metaStmt = $pdo->prepare(
            'SELECT last_ingest_at, buffer_health_pct FROM market_replay_meta WHERE provider = ? AND symbol = ? LIMIT 1'
        );
        $metaStmt->execute([$providerName, $symbol]);
        $meta = $metaStmt->fetch(PDO::FETCH_ASSOC) ?: [];

        $health = isset($meta['buffer_health_pct']) ? (int) $meta['buffer_health_pct'] : 100;
        $lastSync = isset($meta['last_ingest_at']) ? (int) $meta['last_ingest_at'] : 0;
        $lastClose = $candles !== [] ? (float) end($candles)['close'] : null;

        $delayLabel = self::formatDelayLabel($delay);
        $synced = $health >= 85 && ($serverTime - $lastSync) < 180;

        return [
            'serverTime' => $serverTime,
            'delaySeconds' => $delay,
            'displayTime' => $displayTime,
            'interval' => $interval,
            'candles' => $candles,
            'price' => ['close' => $lastClose],
            'status' => [
                'synced' => $synced,
                'state' => $synced ? 'synced' : ($health >= 50 ? 'resyncing' : 'degraded'),
                'lastServerSync' => $lastSync,
                'delayLabel' => $delayLabel,
                'bufferHealthPct' => $health,
            ],
        ];
    }

    public static function formatDelayLabel(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . ' seconds';
        }
        if ($seconds % 60 === 0) {
            $mins = (int) ($seconds / 60);
            return $mins . ' minute' . ($mins === 1 ? '' : 's');
        }
        return (int) round($seconds / 60) . ' minutes';
    }

    /** Recompute rolling display clock on short-lived API cache hits. */
    public static function refreshCachedPayload(array $cached): array
    {
        $delay = (int) ($cached['delaySeconds'] ?? 900);
        $now = time();
        $displayTime = $now - $delay;
        $cached['serverTime'] = $now;
        $cached['displayTime'] = $displayTime;

        if (!empty($cached['candles']) && is_array($cached['candles'])) {
            $filtered = [];
            foreach ($cached['candles'] as $candle) {
                if (!is_array($candle) || !isset($candle['time'])) {
                    continue;
                }
                if ((int) $candle['time'] <= $displayTime) {
                    $filtered[] = $candle;
                }
            }
            $cached['candles'] = $filtered;
            if ($filtered !== []) {
                $last = end($filtered);
                $cached['price'] = ['close' => (float) $last['close']];
            }
        }

        return $cached;
    }

    public static function cacheGet(string $key): ?array
    {
        if (function_exists('apcu_fetch')) {
            $success = false;
            $val = apcu_fetch($key, $success);
            if ($success && is_string($val)) {
                $decoded = json_decode($val, true);
                if (is_array($decoded)) {
                    return $decoded;
                }
            }
        }

        $path = self::cachePath($key);
        if (!is_file($path)) {
            return null;
        }
        $raw = @file_get_contents($path);
        if ($raw === false) {
            return null;
        }
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            return null;
        }
        if (isset($decoded['_expires']) && time() > (int) $decoded['_expires']) {
            @unlink($path);
            return null;
        }
        unset($decoded['_expires']);
        return $decoded;
    }

    public static function cacheSet(string $key, array $payload, int $ttl = self::CACHE_TTL_SECONDS): void
    {
        $encoded = json_encode($payload);
        if ($encoded === false) {
            return;
        }

        if (function_exists('apcu_store')) {
            apcu_store($key, $encoded, $ttl);
        }

        $dir = dirname(__DIR__, 2) . '/storage/cache/market-replay';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        $payload['_expires'] = time() + $ttl;
        @file_put_contents(self::cachePath($key), json_encode($payload), LOCK_EX);
    }

    private static function cachePath(string $key): string
    {
        $safe = preg_replace('/[^a-zA-Z0-9_-]/', '_', $key);
        return dirname(__DIR__, 2) . '/storage/cache/market-replay/' . $safe . '.json';
    }

    public static function isUsMarketOpen(?int $ts = null): bool
    {
        $ts = $ts ?? time();
        try {
            $tz = new DateTimeZone('America/New_York');
            $dt = (new DateTimeImmutable('@' . $ts))->setTimezone($tz);
        } catch (Throwable $e) {
            return true;
        }

        $dow = (int) $dt->format('N');
        if ($dow >= 6) {
            return false;
        }

        $minutes = ((int) $dt->format('H')) * 60 + (int) $dt->format('i');
        $open = 9 * 60 + 30;
        $close = 16 * 60;
        return $minutes >= $open && $minutes < $close;
    }
}
