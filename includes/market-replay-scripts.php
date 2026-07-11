<?php
/**
 * Load market replay chart assets once per page.
 */
static $marketReplayScriptsLoaded = false;
if ($marketReplayScriptsLoaded) {
    return;
}
$marketReplayScriptsLoaded = true;
?>
<script src="/js/crypto-config.js"></script>
<script src="/js/market-replay-chart.js" defer></script>
<style>
.market-replay-chart { min-height: 200px; }
.market-replay-wrap { width: 100%; max-width: 100%; }
</style>
