<?php
/**
 * Binance public market data provider (no API key).
 */

require_once __DIR__ . '/../ProviderInterface.php';

class BinanceReplayProvider implements MarketReplayProviderInterface
{
    private const BASE_URL = 'https://data-api.binance.vision/api/v3/klines';

    public function getName(): string
    {
        return 'binance';
    }

    public function fetchCandles(string $symbol, string $interval, int $fromTs, int $toTs): array
    {
        $symbol = strtoupper(trim($symbol));
        $interval = $interval !== '' ? $interval : '1s';
        $allowedIntervals = ['1s', '1m', '3m', '5m', '15m', '30m', '1h'];
        if (!in_array($interval, $allowedIntervals, true)) {
            $interval = '1s';
        }

        $candles = [];
        $cursorMs = max(0, $fromTs) * 1000;
        $endMs = max($cursorMs, $toTs * 1000);
        $maxLoops = 10;

        while ($cursorMs <= $endMs && $maxLoops-- > 0) {
            $query = http_build_query([
                'symbol' => $symbol,
                'interval' => $interval,
                'startTime' => $cursorMs,
                'endTime' => $endMs,
                'limit' => 1000,
            ]);
            $url = self::BASE_URL . '?' . $query;

            $raw = $this->httpGet($url);
            if ($raw === null) {
                break;
            }

            $rows = json_decode($raw, true);
            if (!is_array($rows) || $rows === []) {
                break;
            }

            $lastOpenMs = null;
            foreach ($rows as $row) {
                if (!is_array($row) || count($row) < 6) {
                    continue;
                }
                $openMs = (int) $row[0];
                $candles[$openMs] = [
                    'time' => (int) floor($openMs / 1000),
                    'open' => (float) $row[1],
                    'high' => (float) $row[2],
                    'low' => (float) $row[3],
                    'close' => (float) $row[4],
                    'volume' => (float) $row[5],
                ];
                $lastOpenMs = $openMs;
            }

            if ($lastOpenMs === null) {
                break;
            }

            $stepMs = $interval === '1s' ? 1000 : 60000;
            $nextMs = $lastOpenMs + $stepMs;
            if ($nextMs <= $cursorMs) {
                break;
            }
            $cursorMs = $nextMs;

            if (count($rows) < 1000) {
                break;
            }
        }

        ksort($candles);
        return array_values($candles);
    }

    private function httpGet(string $url): ?string
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: bloombit-replay/1.0',
            ],
        ]);
        $response = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$response || $status < 200 || $status >= 300) {
            return null;
        }

        return $response;
    }
}
