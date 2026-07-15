<?php
/**
 * Homepage market preview card — dark institutional style with live data / TradingView.
 * Expects $instrument from market-instruments registry.
 */
if (empty($instrument) || !is_array($instrument)) return;

$slug = $instrument['slug'];
$href = '/markets/' . htmlspecialchars($slug);
$label = htmlspecialchars($instrument['name']);
$category = $instrument['category'] ?? '';
$pairLabel = htmlspecialchars($instrument['pair_label'] ?? '');
$symbol = htmlspecialchars($instrument['symbol'] ?? '');
?>
<div class="trading-card p-6 market-card-link flex flex-col h-full">
<?php if ($category === 'crypto'): ?>
<div class="market-card-preview crypto-market-card flex-1" data-coin="<?php echo htmlspecialchars($instrument['coingecko_id'] ?? $slug); ?>">
<div class="flex justify-between items-start mb-4">
<div class="flex items-center gap-3 min-w-0">
<div class="w-10 h-10 rounded-full overflow-hidden bg-primary/10 flex items-center justify-center shrink-0">
<img class="crypto-logo w-7 h-7 object-contain" src="" alt="<?php echo $label; ?>"/>
</div>
<div class="min-w-0">
<div class="font-bold text-white crypto-symbol truncate"><?php echo $pairLabel; ?></div>
<div class="text-xs text-on-surface-variant crypto-name truncate"><?php echo $label; ?></div>
</div>
</div>
<div class="crypto-change font-bold font-data-mono text-on-surface-variant shrink-0">--</div>
</div>
<div class="text-2xl font-bold text-white font-data-mono crypto-price">--</div>
<div class="mt-4 h-1 bg-white/5 rounded-full overflow-hidden">
<div class="h-full bg-primary w-[50%] market-bar"></div>
</div>
</div>
<?php else: ?>
<div class="market-card-preview flex-1 <?php echo $category === 'forex' ? 'forex-market-card' : 'stock-market-card'; ?>">
<div class="flex items-center gap-3 mb-3 min-w-0">
<div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary text-[20px]"><?php echo $category === 'forex' ? 'currency_exchange' : 'trending_up'; ?></span>
</div>
<div class="min-w-0">
<div class="font-bold text-white truncate"><?php echo $pairLabel ?: $label; ?></div>
<div class="text-xs text-on-surface-variant truncate"><?php echo $label; ?></div>
</div>
</div>
<div class="rounded-lg overflow-hidden institutional-border bg-surface-container-lowest/50">
<tv-mini-chart symbol="<?php echo $symbol; ?>" style="width: 100%; height: 220px"></tv-mini-chart>
</div>
</div>
<?php endif; ?>
<a href="<?php echo $href; ?>" class="market-view-btn mt-4">View Market</a>
</div>
