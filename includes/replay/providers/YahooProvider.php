<?php
/**
 * Yahoo Finance v8 chart provider (free, unofficial).
 */

require_once __DIR__ . '/../ProviderInterface.php';

class YahooReplayProvider implements MarketReplayProviderInterface
{
    private const BASE_URL = 'https://query1.finance.yahoo.com/v8/finance/chart/';

    public function getName(): string
    {
        return 'yahoo';
    }

    public function fetchCandles(string $symbol, string $interval, int $fromTs, int $toTs): array
    {
        $symbol = trim($symbol);
        if ($symbol === '') {
            return [];
        }

        $interval = $interval !== '' ? $interval : '1m';
        $allowed = ['1m', '2m', '5m', '15m', '30m', '60m', '1h', '1d'];
        if (!in_array($interval, $allowed, true)) {
            $interval = '1m';
        }

        $query = http_build_query([
            'interval' => $interval,
            'period1' => max(0, $fromTs - 60),
            'period2' => max($fromTs, $toTs + 60),
        ]);
        $url = self::BASE_URL . rawurlencode($symbol) . '?' . $query;

        $raw = $this->httpGet($url);
        if ($raw === null) {
            return [];
        }

        $data = json_decode($raw, true);
        if (!is_array($data) || !empty($data['chart']['error'])) {
            return [];
        }
        $result = $data['chart']['result'][0] ?? null;
        if (!$result) {
            return [];
        }

        $timestamps = $result['timestamp'] ?? [];
        $quote = $result['indicators']['quote'][0] ?? [];
        $opens = $quote['open'] ?? [];
        $highs = $quote['high'] ?? [];
        $lows = $quote['low'] ?? [];
        $closes = $quote['close'] ?? [];
        $volumes = $quote['volume'] ?? [];

        $candles = [];
        $count = count($timestamps);
        for ($i = 0; $i < $count; $i++) {
            $ts = isset($timestamps[$i]) ? (int) $timestamps[$i] : 0;
            if ($ts < $fromTs || $ts > $toTs) {
                continue;
            }
            $close = isset($closes[$i]) ? $closes[$i] : null;
            if ($close === null || !is_numeric($close)) {
                continue;
            }
            $open = isset($opens[$i]) && is_numeric($opens[$i]) ? (float) $opens[$i] : (float) $close;
            $high = isset($highs[$i]) && is_numeric($highs[$i]) ? (float) $highs[$i] : (float) $close;
            $low = isset($lows[$i]) && is_numeric($lows[$i]) ? (float) $lows[$i] : (float) $close;
            $vol = isset($volumes[$i]) && is_numeric($volumes[$i]) ? (float) $volumes[$i] : 0.0;

            $candles[] = [
                'time' => $ts,
                'open' => $open,
                'high' => $high,
                'low' => $low,
                'close' => (float) $close,
                'volume' => $vol,
            ];
        }

        return $candles;
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
                'User-Agent: Mozilla/5.0 (compatible; BloombitReplay/1.0)',
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
