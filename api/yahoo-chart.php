<?php
/**
 * Yahoo Finance v8 chart proxy (free, unofficial).
 * Usage: /api/yahoo-chart.php?symbol=TSLA&interval=1m&period1=...&period2=...
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

$symbol = isset($_GET['symbol']) ? trim((string) $_GET['symbol']) : '';
if ($symbol === '' || !preg_match('/^[A-Za-z0-9^=\.\-]+$/', $symbol)) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'symbol required']);
    exit;
}

$interval = isset($_GET['interval']) ? (string) $_GET['interval'] : '1m';
$allowedIntervals = ['1m', '2m', '5m', '15m', '30m', '60m', '1h', '1d'];
if (!in_array($interval, $allowedIntervals, true)) {
    $interval = '1m';
}

$query = ['interval' => $interval];
if (isset($_GET['range'])) {
    $query['range'] = (string) $_GET['range'];
}
if (isset($_GET['period1'])) {
    $query['period1'] = (int) $_GET['period1'];
}
if (isset($_GET['period2'])) {
    $query['period2'] = (int) $_GET['period2'];
}

$url = 'https://query1.finance.yahoo.com/v8/finance/chart/' . rawurlencode($symbol) . '?' . http_build_query($query);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 20,
    CURLOPT_HTTPHEADER => [
        'Accept: application/json',
        'User-Agent: Mozilla/5.0 (compatible; BloombitProxy/1.0)',
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
