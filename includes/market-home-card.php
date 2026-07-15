<?php
/**
 * Homepage market preview card — dark Live Execution Terminal style.
 * Expects $instrument from market-instruments registry.
 */
if (empty($instrument) || !is_array($instrument)) return;

$slug = $instrument['slug'];
$href = '/markets/' . htmlspecialchars($slug);
$label = htmlspecialchars($instrument['name']);
$category = $instrument['category'] ?? '';
$pairLabel = htmlspecialchars($instrument['pair_label'] ?? '');
$symbol = htmlspecialchars($instrument['symbol'] ?? '');
$iconTint = 'bg-primary/10';
if ($category === 'crypto') {
    $iconTint = 'bg-orange-500/10';
} elseif ($category === 'forex') {
    $iconTint = 'bg-blue-500/10';
} elseif ($category === 'stock') {
    $iconTint = 'bg-yellow-500/10';
}
?>
<div class="trading-card p-6 market-card-link flex flex-col">
<?php if ($category === 'crypto'): ?>
<div class="market-card-preview crypto-market-card flex-1" data-coin="<?php echo htmlspecialchars($instrument['coingecko_id'] ?? $slug); ?>">
<div class="flex justify-between items-start mb-4">
<div class="flex items-center gap-3 min-w-0">
<div class="w-10 h-10 rounded-full <?php echo $iconTint; ?> flex items-center justify-center shrink-0 overflow-hidden">
<img class="crypto-logo w-6 h-6 object-contain" src="" alt="<?php echo $label; ?>"/>
</div>
<div class="min-w-0">
<div class="font-headline-md text-white truncate crypto-symbol"><?php echo $pairLabel ?: $label; ?></div>
<div class="text-[10px] text-on-surface-variant uppercase tracking-widest truncate crypto-name"><?php echo $label; ?></div>
</div>
</div>
<div class="text-right shrink-0">
<div class="crypto-change font-bold font-data-mono text-on-surface-variant">--</div>
</div>
</div>
<div class="text-2xl font-bold text-white mb-4 font-data-mono crypto-price">--</div>
</div>
<?php else: ?>
<div class="market-card-preview flex-1 <?php echo $category === 'forex' ? 'forex-market-card' : 'stock-market-card'; ?>">
<div class="flex justify-between items-start mb-3">
<div class="flex items-center gap-3 min-w-0">
<div class="w-10 h-10 rounded-full <?php echo $iconTint; ?> flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary text-[20px]"><?php echo $category === 'forex' ? 'currency_exchange' : 'trending_up'; ?></span>
</div>
<div class="min-w-0">
<div class="font-headline-md text-white truncate"><?php echo $pairLabel ?: $label; ?></div>
<div class="text-[10px] text-on-surface-variant uppercase tracking-widest truncate"><?php echo $label; ?></div>
</div>
</div>
</div>
<div class="rounded-lg overflow-hidden institutional-border bg-surface-container-lowest/40">
<tv-mini-chart symbol="<?php echo $symbol; ?>" style="width: 100%; height: 120px"></tv-mini-chart>
</div>
</div>
<?php endif; ?>
<a href="<?php echo $href; ?>" class="market-view-btn mt-4">Trade Now</a>
</div>
