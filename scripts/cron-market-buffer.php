<?php
/**
 * Market replay buffer ingest cron.
 * Run every minute: php /path/to/scripts/cron-market-buffer.php
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI only');
}

require_once dirname(__DIR__) . '/includes/replay/ReplayEngine.php';

try {
    $pdo = require dirname(__DIR__) . '/includes/db.php';
} catch (Throwable $e) {
    echo date('Y-m-d H:i:s') . " | DB unavailable: " . $e->getMessage() . "\n";
    exit(1);
}

$results = MarketReplayEngine::runIngestAll($pdo);

echo date('Y-m-d H:i:s') . " | Market replay ingest\n";
foreach ($results as $key => $count) {
    echo "  {$key}: {$count}\n";
}
