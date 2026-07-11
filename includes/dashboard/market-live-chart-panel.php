<?php
/**
 * Live TradingView chart panel — same widget as /markets/{slug} detail pages.
 * Expects $instrument from market-instruments registry.
 * Optional: $marketChartLead (bool), $marketChartLeadTitle, $marketChartLeadPair, $marketChartLeadType, $marketChartBackUrl
 */
if (empty($instrument) || !is_array($instrument)) {
    return;
}

$snapshot = $instrument['snapshot'] ?? [];
$isCrypto = ($instrument['category'] ?? '') === 'crypto';
$coingeckoId = $instrument['coingecko_id'] ?? '';
$chartSymbol = htmlspecialchars($instrument['symbol'] ?? '', ENT_QUOTES, 'UTF-8');
$pairLabel = htmlspecialchars($instrument['pair_label'] ?? $instrument['name'] ?? '', ENT_QUOTES, 'UTF-8');
$instrumentName = htmlspecialchars($instrument['name'] ?? '', ENT_QUOTES, 'UTF-8');
$chartLead = !empty($marketChartLead);
$leadTitle = htmlspecialchars((string) ($marketChartLeadTitle ?? $instrument['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$leadPair = htmlspecialchars((string) ($marketChartLeadPair ?? $instrument['pair_label'] ?? ''), ENT_QUOTES, 'UTF-8');
$leadType = htmlspecialchars((string) ($marketChartLeadType ?? ($snapshot['market_type'] ?? ucfirst($instrument['category'] ?? 'Market'))), ENT_QUOTES, 'UTF-8');
$backUrl = htmlspecialchars((string) ($marketChartBackUrl ?? '/dashboard/user/investment-plans'), ENT_QUOTES, 'UTF-8');
?>
<div class="glass-panel rounded-xl overflow-hidden min-w-0">
<?php if ($chartLead): ?>
<div class="p-4 md:p-5 border-b border-low flex items-center gap-3 min-w-0">
<a href="<?php echo $backUrl; ?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-text-secondary hover:text-primary-container transition-colors shrink-0" aria-label="Back to all plans">
<span class="material-symbols-outlined text-lg">arrow_back</span>
</a>
<div class="min-w-0 flex-1">
<h1 class="text-xl sm:text-2xl font-bold text-text-primary leading-tight truncate"><?php echo $leadTitle; ?></h1>
<p class="text-sm text-primary-container font-semibold truncate"><?php echo $leadPair; ?><span class="text-text-secondary font-normal"> · <?php echo $leadType; ?></span></p>
</div>
<span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-red-500/10 border border-red-500/20 text-[10px] font-bold uppercase tracking-wider text-red-400 shrink-0">
<span class="w-1.5 h-1.5 bg-red-500 rounded-full pulse-live"></span> Live
</span>
</div>
<?php else: ?>
<div class="p-5 md:p-6 border-b border-low">
<h3 class="text-lg font-bold text-text-primary">Live Price Chart</h3>
<p class="text-sm text-text-secondary mt-1"><?php echo $pairLabel; ?> — same live feed as our public market page.</p>
</div>
<?php endif; ?>
<div class="p-4 md:p-6">
<div class="market-detail-chart-wrap plan-market-chart-wrap rounded-xl border border-low bg-[#F7F8FA] dark:bg-surface-container p-4 md:p-6 min-w-0">
<?php if ($isCrypto && $coingeckoId): ?>
<div class="crypto-detail-header mb-4 flex flex-wrap items-center <?php echo $chartLead ? 'justify-end' : 'justify-between'; ?> gap-4" data-coin="<?php echo htmlspecialchars($coingeckoId); ?>">
<?php if (!$chartLead): ?>
<div class="flex items-center gap-3 min-w-0">
<img class="crypto-logo w-10 h-10 rounded-full shrink-0" src="" alt=""/>
<div class="min-w-0">
<div class="font-bold text-surface-container-lowest dark:text-text-primary crypto-symbol truncate"><?php echo $pairLabel; ?></div>
<div class="text-sm text-gray-500 dark:text-text-secondary crypto-name truncate"><?php echo $instrumentName; ?></div>
</div>
</div>
<?php endif; ?>
<div class="text-right shrink-0">
<div class="text-2xl font-bold font-data-mono text-surface-container-lowest dark:text-text-primary crypto-price">--</div>
<div class="crypto-change font-data-mono text-sm text-gray-400">--</div>
</div>
</div>
<?php elseif (!$chartLead): ?>
<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
<div>
<div class="font-bold text-surface-container-lowest dark:text-text-primary text-lg"><?php echo $instrumentName; ?></div>
<div class="text-sm text-gray-500 dark:text-text-secondary"><?php echo $pairLabel; ?></div>
</div>
<span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-red-400">
<span class="w-2 h-2 bg-red-500 rounded-full pulse-live"></span> Live
</span>
</div>
<?php endif; ?>

<?php if ($chartSymbol !== ''): ?>
<tv-mini-chart symbol="<?php echo $chartSymbol; ?>" style="width: 100%; height: 360px; max-width: 100%;"></tv-mini-chart>
<?php else: ?>
<p class="text-sm text-text-secondary text-center py-12">Chart unavailable for this market.</p>
<?php endif; ?>

<?php require __DIR__ . '/../market-chart-disclaimer.php'; ?>
</div>

<?php if (!empty($snapshot)): ?>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mt-6 pt-6 border-t border-low">
<div>
<div class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Market Type</div>
<div class="text-sm font-semibold text-text-primary"><?php echo htmlspecialchars($snapshot['market_type'] ?? '—'); ?></div>
</div>
<?php if (!empty($snapshot['sector'])): ?>
<div>
<div class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Sector</div>
<div class="text-sm font-semibold text-text-primary"><?php echo htmlspecialchars($snapshot['sector']); ?></div>
</div>
<?php endif; ?>
<div>
<div class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Exchange</div>
<div class="text-sm font-semibold text-text-primary"><?php echo htmlspecialchars($snapshot['exchange'] ?? '—'); ?></div>
</div>
<div>
<div class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Trading Hours</div>
<div class="text-sm font-semibold text-text-primary"><?php echo htmlspecialchars($snapshot['hours'] ?? '—'); ?></div>
</div>
<div>
<div class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Volatility</div>
<div class="text-sm font-semibold text-text-primary"><?php echo htmlspecialchars($snapshot['volatility'] ?? '—'); ?></div>
</div>
<div class="col-span-2 md:col-span-1">
<div class="text-[10px] font-bold text-on-surface-variant uppercase mb-1">Suitable For</div>
<div class="text-sm font-semibold text-text-primary leading-snug"><?php echo htmlspecialchars($snapshot['suitable_for'] ?? '—'); ?></div>
</div>
</div>
<?php endif; ?>
</div>
</div>
