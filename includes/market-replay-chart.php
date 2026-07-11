<?php
/**
 * Market replay chart container (TradingView Lightweight Charts).
 *
 * Expects $instrument or set $replaySlug before include.
 * Options: $replayChartHeight, $replayChartLazy, $replayChartShowStatus, $replayChartTheme
 */
if (empty($instrument) || !is_array($instrument)) {
    if (empty($replaySlug)) {
        return;
    }
    require_once __DIR__ . '/market-instruments.php';
    $instrument = get_market_instrument($replaySlug);
    if (!$instrument) {
        return;
    }
}

if (!market_instrument_has_replay($instrument)) {
    echo '<p class="text-sm text-text-secondary text-center py-8">Chart unavailable for this market.</p>';
    return;
}

$slug = htmlspecialchars($instrument['slug'], ENT_QUOTES, 'UTF-8');
$height = (int) ($replayChartHeight ?? 360);
$lazy = !empty($replayChartLazy) ? '1' : '0';
$showStatus = !empty($replayChartShowStatus) ? '1' : '0';
$theme = ($replayChartTheme ?? 'dark') === 'light' ? 'light' : 'dark';
$pairLabel = htmlspecialchars($instrument['pair_label'] ?? '', ENT_QUOTES, 'UTF-8');
$name = htmlspecialchars($instrument['name'] ?? '', ENT_QUOTES, 'UTF-8');
$isCrypto = ($instrument['category'] ?? '') === 'crypto';
$coingeckoId = $instrument['coingecko_id'] ?? '';
?>
<div class="market-replay-wrap min-w-0"
     data-market-replay
     data-slug="<?php echo $slug; ?>"
     data-height="<?php echo $height; ?>"
     data-lazy="<?php echo $lazy; ?>"
     data-show-status="<?php echo $showStatus; ?>"
     data-theme="<?php echo $theme; ?>"
     <?php if ($coingeckoId): ?>data-coingecko-id="<?php echo htmlspecialchars($coingeckoId, ENT_QUOTES, 'UTF-8'); ?>"<?php endif; ?>>
<?php if ($isCrypto && $showStatus === '0'): ?>
<div class="market-replay-price-header mb-3 flex flex-wrap items-center justify-between gap-3">
<div class="flex items-center gap-3 min-w-0">
<img class="market-replay-logo w-8 h-8 rounded-full shrink-0" src="" alt=""/>
<div class="min-w-0">
<div class="font-bold text-sm truncate market-replay-pair"><?php echo $pairLabel; ?></div>
<div class="text-xs text-text-secondary truncate market-replay-name"><?php echo $name; ?></div>
</div>
</div>
<div class="text-right shrink-0">
<div class="text-xl font-bold font-data-mono market-replay-price">--</div>
<div class="text-xs font-data-mono market-replay-change text-text-secondary">--</div>
</div>
</div>
<?php endif; ?>
<div class="market-replay-chart rounded-lg overflow-hidden min-w-0" style="width:100%;height:<?php echo $height; ?>px"></div>
<?php if ($showStatus === '1'): ?>
<div class="market-replay-status mt-4 p-3 rounded-lg border border-low bg-surface-container-high/50 text-xs">
<div class="flex flex-wrap items-center justify-between gap-2 mb-2">
<span class="font-bold uppercase tracking-wider text-on-surface-variant">Replay Status</span>
<span class="market-replay-status-badge inline-flex items-center gap-1.5 font-semibold text-success">
<span class="w-1.5 h-1.5 rounded-full bg-success market-replay-status-dot"></span>
<span class="market-replay-status-label">Synced</span>
</span>
</div>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-text-secondary">
<div>Last server sync: <span class="market-replay-status-sync font-data-mono text-text-primary">--</span></div>
<div>Delay: <span class="market-replay-status-delay text-text-primary">--</span></div>
<div>Buffer health: <span class="market-replay-status-health font-data-mono text-text-primary">--</span></div>
</div>
<div class="market-replay-market-closed hidden mt-2 text-amber-500 font-semibold">Market closed — showing last available prices.</div>
</div>
<?php endif; ?>
</div>
