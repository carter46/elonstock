<?php
/**
 * Homepage market preview card — delayed replay chart + View Market CTA.
 * Expects $instrument from market-instruments registry.
 */
if (empty($instrument) || !is_array($instrument)) return;

$slug = $instrument['slug'];
$href = '/markets/' . htmlspecialchars($slug);
$label = htmlspecialchars($instrument['name']);
$category = $instrument['category'];
$pairLabel = htmlspecialchars($instrument['pair_label'] ?? '');
?>
<div class="market-card-link relative bg-white p-6 rounded-xl shadow-sm border border-gray-100 group hover:shadow-md transition-shadow flex flex-col">
<div class="market-card-preview flex-1 min-h-0">
<?php
$replayChartHeight = 240;
$replayChartLazy = true;
$replayChartShowStatus = false;
$replayChartTheme = 'light';
require __DIR__ . '/market-replay-chart.php';
?>
</div>
<a href="<?php echo $href; ?>" class="market-view-btn mt-4 w-full text-center">View Market</a>
</div>
