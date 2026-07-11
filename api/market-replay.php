<?php
/**
 * Delayed market replay API.
 * GET /api/market-replay.php?slug=bitcoin
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

require_once dirname(__DIR__) . '/includes/market-instruments.php';
require_once dirname(__DIR__) . '/includes/replay/ReplayEngine.php';

header('Content-Type: application/json');

$slug = isset($_GET['slug']) ? strtolower(trim((string) $_GET['slug'])) : '';
if ($slug === '') {
    http_response_code(400);
    echo json_encode(['error' => 'slug required']);
    exit;
}

$instrument = get_market_instrument($slug);
if (!$instrument) {
    http_response_code(404);
    echo json_encode(['error' => 'instrument not found']);
    exit;
}

$replay = market_instrument_replay_config($instrument);
if (!$replay) {
    http_response_code(404);
    echo json_encode(['error' => 'replay not enabled for this instrument']);
    exit;
}

$chartWindow = isset($_GET['window']) ? (int) $_GET['window'] : MarketReplayEngine::DEFAULT_CHART_WINDOW;
$chartWindow = max(300, min(7200, $chartWindow));

$serverTime = time();
$cacheKey = 'replay:' . $slug . ':' . (int) floor($serverTime / 5);

$cached = MarketReplayEngine::cacheGet($cacheKey);
if (is_array($cached)) {
    $cached = MarketReplayEngine::refreshCachedPayload($cached);
    header('Cache-Control: public, max-age=3');
    echo json_encode($cached);
    exit;
}

try {
    $pdo = require dirname(__DIR__) . '/includes/db.php';
} catch (Throwable $e) {
    http_response_code(503);
    echo json_encode(['error' => 'database unavailable']);
    exit;
}

try {
    $payload = MarketReplayEngine::getReplayPayload($pdo, $replay, $chartWindow);
    $payload['slug'] = $slug;
    $payload['name'] = $instrument['name'] ?? $slug;
    $payload['pairLabel'] = $instrument['pair_label'] ?? '';
    $payload['category'] = $instrument['category'] ?? '';

    if (($instrument['category'] ?? '') === 'stock') {
        $payload['marketOpen'] = MarketReplayEngine::isUsMarketOpen($serverTime);
    } elseif (($instrument['category'] ?? '') === 'forex') {
        $payload['marketOpen'] = true;
    } else {
        $payload['marketOpen'] = true;
    }

    if (!empty($instrument['coingecko_id'])) {
        $payload['coingeckoId'] = $instrument['coingecko_id'];
    }

    MarketReplayEngine::cacheSet($cacheKey, $payload, MarketReplayEngine::CACHE_TTL_SECONDS);

    header('Cache-Control: public, max-age=3');
    echo json_encode($payload);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'replay failed', 'detail' => $e->getMessage()]);
}
