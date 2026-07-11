<?php
/**
 * Binance public market data proxy (no API key).
 * Usage: /api/binance.php?symbol=BTCUSDT&interval=1s&limit=300
 */

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$host = $_SERVER['HTTP_HOST'] ?? '';
$isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
$protocol = $isHttps ? 'https' : 'http';
$allowedOrigin = ($origin === $protocol . '://' . $host) ? $origin : ($protocol . '://' . $host);

header('Access-Control-Allow-Origin: ' . $allowedOrigin);
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Max-Age: 86400');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$symbol = isset($_GET['symbol']) ? strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $_GET['symbol'])) : '';
$interval = isset($_GET['interval']) ? (string) $_GET['interval'] : '1s';
$allowedIntervals = ['1s', '1m', '3m', '5m', '15m', '30m', '1h'];
if (!in_array($interval, $allowedIntervals, true)) {
    $interval = '1s';
}

$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 300;
$limit = max(1, min(1000, $limit));

if ($symbol === '') {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'symbol required']);
    exit;
}

$query = [
    'symbol' => $symbol,
    'interval' => $interval,
    'limit' => $limit,
];

if (isset($_GET['startTime'])) {
    $query['startTime'] = (int) $_GET['startTime'];
}
if (isset($_GET['endTime'])) {
    $query['endTime'] = (int) $_GET['endTime'];
}

$url = 'https://data-api.binance.vision/api/v3/klines?' . http_build_query($query);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 20,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'User-Agent: bloombit-proxy',
    ],
]);
$response = curl_exec($ch);
$status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

header('Content-Type: application/json');
http_response_code($status > 0 ? $status : 502);

if ($response && $status >= 200 && $status < 300) {
    header('Cache-Control: public, max-age=5');
    echo $response;
} else {
    echo json_encode(['error' => 'Upstream error', 'status' => $status]);
}
