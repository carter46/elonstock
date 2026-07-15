<?php
$plans = [];
require_once __DIR__ . '/includes/plan-types.php';
try {
    $pdo = require __DIR__ . '/includes/db.php';
    ensure_plan_schema($pdo);
    $stmt = $pdo->query('SELECT id, name, slug, plan_type, description, logo_url, min_deposit, max_deposit, yield_min, yield_max, withdrawal_days, features_json FROM plans WHERE enabled = 1 ORDER BY sort_order, id');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['features'] = $row['features_json'] ? json_decode($row['features_json'], true) : [];
        $row['plan_type'] = normalize_plan_type($row['plan_type'] ?? 'crypto');
        $plans[] = $row;
    }
} catch (Throwable $e) {
    // DB not configured or unavailable
}
require_once __DIR__ . '/includes/helpers.php';
$siteName = get_site_name();
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php
$pageTitle = $siteName . ' | Investment Plans Comparison';
require_once __DIR__ . '/includes/marketing-head.php';
?>
<style>
        .comparison-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            min-width: 480px;
        }
    </style>
</head>
<body class="marketing-page font-body-md text-body-md bg-background text-on-surface overflow-x-hidden">
<?php $currentPage = 'plans'; require_once __DIR__ . '/includes/marketing-header.php'; ?>
<main class="pt-20">
<!-- Hero Header -->
<header class="py-12 sm:py-16 md:py-20 px-4 sm:px-6">
<div class="max-w-4xl mx-auto text-center">
<span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-widest uppercase bg-primary-container/10 text-primary-container border border-primary-container/20 rounded-full">Maximize Your Capital</span>
<h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-6 tracking-tight text-white">Flexible Investment Plans</h1>
<p class="text-lg text-on-surface-variant max-w-2xl mx-auto leading-relaxed">
                Choose a plan tailored to your financial goals. Our AI-powered algorithms work 24/7 to optimize your returns based on your risk tolerance.
            </p>
</div>
</header>
<!-- Plan Cards -->
<section class="pb-24 px-6">
<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
<?php
$planIndex = 0;
foreach ($plans as $plan):
    $isHighlight = ($planIndex === 1 && count($plans) >= 2);
    $planIndex++;
    $minFmt = format_usd_amount($plan['min_deposit']);
    $maxFmt = $plan['max_deposit'] ? format_usd_amount($plan['max_deposit']) : null;
    $rangeStr = $maxFmt ? "\${$minFmt} - \${$maxFmt}" : "\${$minFmt}+";
    $desc = $plan['description'] ?? '';
?>
<div class="trading-card p-8 <?php echo $isHighlight ? 'border-primary-container/40 md:scale-105 z-10 relative' : ''; ?> flex flex-col">
<?php if ($isHighlight): ?>
<div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary-container text-on-primary text-[10px] font-bold uppercase tracking-widest px-4 py-1 rounded-full">Most Popular</div>
<?php endif; ?>
<div class="mb-8">
<div class="flex items-center gap-3 mb-2">
<?php echo plan_logo_markup($plan['logo_url'] ?? null, $plan['name'], 'w-10 h-10', 'text-sm'); ?>
<div>
<span class="text-[10px] font-bold uppercase tracking-wider text-primary-container"><?php echo htmlspecialchars(plan_type_label($plan['plan_type'] ?? 'crypto')); ?></span>
<h3 class="text-xl font-bold text-white"><?php echo htmlspecialchars($plan['name']); ?></h3>
</div>
</div>
<p class="text-on-surface-variant text-sm"><?php echo htmlspecialchars($desc); ?></p>
</div>
<div class="mb-8">
<div class="text-4xl font-bold mb-1 <?php echo $isHighlight ? 'text-primary-container' : 'text-white'; ?>"><?php echo number_format((float)($plan['yield_min'] ?? 0), 1); ?>%</div>
<div class="text-sm font-medium <?php echo $isHighlight ? 'text-on-surface-variant' : 'text-primary-container'; ?>">Daily ROI</div>
</div>
<ul class="space-y-4 mb-10 flex-grow">
<?php foreach (($plan['features'] ?? []) as $f): ?>
<li class="flex items-center gap-3 text-sm <?php echo $isHighlight && strpos($f, '$') !== false ? 'font-semibold text-white' : 'text-on-surface-variant'; ?>">
<span class="material-icons text-primary-container text-sm">check_circle</span>
<span><?php echo htmlspecialchars($f); ?></span>
</li>
<?php endforeach; ?>
</ul>
<a href="/register" class="w-full py-4 <?php echo $isHighlight ? 'gradient-button' : 'btn-secondary'; ?> font-bold block text-center">Start Investing</a>
</div>
<?php endforeach; ?>
<?php if (empty($plans)): ?>
<div class="col-span-3 text-center py-12 text-on-surface-variant">No plans available.</div>
<?php endif; ?>
</div>
</section>
<!-- Comparison Table -->
<section class="bg-surface-container-low py-24 px-6 border-y border-white/5">
<div class="max-w-6xl mx-auto">
<div class="text-center mb-16">
<h2 class="text-3xl font-bold mb-4 text-white">Compare Features</h2>
<p class="text-on-surface-variant">Dive deep into the technical specifications of each investment tier.</p>
</div>
<div class="overflow-x-auto overflow-y-hidden border border-white/5 rounded-xl -mx-2 px-2 sm:mx-0 sm:px-0">
<!-- Header -->
<div class="comparison-grid bg-surface-container border-b border-white/5 font-bold py-6 px-8 text-sm uppercase tracking-wider" style="grid-template-columns: 2fr <?php echo str_repeat('1fr ', count($plans)); ?>">
<div class="text-on-surface-variant">Feature</div>
<?php foreach ($plans as $i => $p): ?>
<div class="text-center <?php echo $i === 1 ? 'text-primary-container' : 'text-on-surface'; ?>"><?php echo htmlspecialchars($p['name']); ?></div>
<?php endforeach; ?>
</div>
<!-- Rows -->
<?php
$withdrawalLabels = ['Every 7 Days', 'Every 3 Days', 'Instant (Anytime)'];
$compoundValues = [false, true, true];
$riskValues = ['Standard SL/TP', 'Dynamic Hedging', 'Tail-Risk Insurance'];
$insightValues = ['Monthly PDF', 'Real-time Dashboard', 'Custom Reports'];
$coverageValues = ['50% Coverage', '85% Coverage', '100% Coverage'];
?>
<div class="comparison-grid border-b border-white/5 py-6 px-8 text-sm items-center" style="grid-template-columns: 2fr <?php echo str_repeat('1fr ', count($plans)); ?>">
<div class="font-medium text-on-surface">Withdrawal Rules</div>
<?php 
for ($i = 0; $i < count($plans); $i++): 
    $wd = (int)($plans[$i]['withdrawal_days'] ?? 7);
    $label = $wd === 0 ? 'Instant (Anytime)' : ($wd === 3 ? 'Every 3 Days' : 'Every ' . $wd . ' Days');
?>
<div class="text-center <?php echo $i === 1 ? 'text-white font-semibold' : 'text-on-surface-variant'; ?>"><?php echo htmlspecialchars($label); ?></div>
<?php endfor; ?>
</div>
<?php for ($i = 0; $i < count($plans); $i++) { if (!isset($compoundValues[$i])) $compoundValues[$i]=$i>0; if (!isset($riskValues[$i])) $riskValues[$i]='Standard'; if (!isset($insightValues[$i])) $insightValues[$i]='Monthly'; if (!isset($coverageValues[$i])) $coverageValues[$i]='50%'; } ?>
<div class="comparison-grid bg-surface-container-low/50 border-b border-white/5 py-6 px-8 text-sm items-center" style="grid-template-columns: 2fr <?php echo str_repeat('1fr ', count($plans)); ?>">
<div class="font-medium text-on-surface">Auto-Compounding</div>
<?php for ($i = 0; $i < count($plans); $i++): ?>
<div class="text-center <?php echo $i === 1 ? 'text-white' : 'text-on-surface-variant'; ?>"><?php echo $compoundValues[$i] ? '<span class="material-icons text-primary-container">check</span>' : '<span class="material-icons text-sm text-on-surface-variant">remove</span>'; ?></div>
<?php endfor; ?>
</div>
<div class="comparison-grid border-b border-white/5 py-6 px-8 text-sm items-center" style="grid-template-columns: 2fr <?php echo str_repeat('1fr ', count($plans)); ?>">
<div class="font-medium text-on-surface">Risk Management</div>
<?php for ($i = 0; $i < count($plans); $i++): ?>
<div class="text-center text-xs <?php echo $i === 1 ? 'text-white font-semibold' : 'text-on-surface-variant'; ?>"><?php echo htmlspecialchars($riskValues[$i] ?? 'Standard'); ?></div>
<?php endfor; ?>
</div>
<div class="comparison-grid bg-surface-container-low/50 border-b border-white/5 py-6 px-8 text-sm items-center" style="grid-template-columns: 2fr <?php echo str_repeat('1fr ', count($plans)); ?>">
<div class="font-medium text-on-surface">Portfolio Insights</div>
<?php for ($i = 0; $i < count($plans); $i++): ?>
<div class="text-center <?php echo $i === 1 ? 'text-white font-semibold' : 'text-on-surface-variant'; ?>"><?php echo htmlspecialchars($insightValues[$i] ?? 'Monthly PDF'); ?></div>
<?php endfor; ?>
</div>
<div class="comparison-grid border-b border-white/5 py-6 px-8 text-sm items-center" style="grid-template-columns: 2fr <?php echo str_repeat('1fr ', count($plans)); ?>">
<div class="font-medium text-on-surface">Capital Insurance</div>
<?php for ($i = 0; $i < count($plans); $i++): ?>
<div class="text-center <?php echo $i === 1 ? 'text-white font-semibold' : 'text-on-surface-variant'; ?>"><?php echo htmlspecialchars($coverageValues[$i] ?? '50% Coverage'); ?></div>
<?php endfor; ?>
</div>
</div>
<!-- Trust Badges -->
<div class="mt-12 flex flex-wrap justify-center items-center gap-12 opacity-40 grayscale text-on-surface-variant">
<div class="flex items-center gap-2">
<span class="material-icons text-2xl">verified_user</span>
<span class="font-bold">SECURED BY SSL</span>
</div>
<div class="flex items-center gap-2">
<span class="material-icons text-2xl">account_balance</span>
<span class="font-bold">FCA REGULATED</span>
</div>
<div class="flex items-center gap-2">
<span class="material-icons text-2xl">security</span>
<span class="font-bold">PCI COMPLIANT</span>
</div>
</div>
</div>
</section>
<!-- FAQ Section -->
<section class="py-24 px-6 bg-surface">
<div class="max-w-3xl mx-auto">
<h2 class="text-4xl font-bold mb-12 text-center text-white">Frequently Asked Questions</h2>
<div class="space-y-4">
<div class="rounded-2xl bg-surface-container border border-white/5 overflow-hidden">
<button class="w-full px-6 py-5 flex items-center justify-between text-left font-semibold text-on-surface">
<span>How are the daily yields generated?</span>
<span class="material-icons text-primary-container">add</span>
</button>
<div class="px-6 pb-5 text-sm text-on-surface-variant leading-relaxed border-t border-white/5 pt-4">
                        Our AI algorithms execute thousands of micro-trades across multiple liquidity pools, arbitrage opportunities, and trend-following strategies 24/7. The yield reflects the collective performance of these automated strategies minus a small platform fee.
                    </div>
</div>
<div class="rounded-2xl bg-surface-container border border-white/5 overflow-hidden">
<button class="w-full px-6 py-5 flex items-center justify-between text-left font-semibold text-on-surface">
<span>Is my initial capital insured?</span>
<span class="material-icons text-primary-container">add</span>
</button>
<div class="hidden px-6 pb-5 text-sm text-on-surface-variant leading-relaxed">
                        Yes, depending on your plan tier, we maintain a Reserve Fund that covers between 50% and 100% of the initial principal against catastrophic market events.
                    </div>
</div>
<div class="rounded-2xl bg-surface-container border border-white/5 overflow-hidden">
<button class="w-full px-6 py-5 flex items-center justify-between text-left font-semibold text-on-surface">
<span>What is the minimum lock-up period?</span>
<span class="material-icons text-primary-container">add</span>
</button>
</div>
<div class="rounded-2xl bg-surface-container border border-white/5 overflow-hidden">
<button class="w-full px-6 py-5 flex items-center justify-between text-left font-semibold text-on-surface">
<span>Can I upgrade my plan later?</span>
<span class="material-icons text-primary-container">add</span>
</button>
</div>
</div>
</div>
</section>
<!-- Final CTA -->
<section class="py-24 px-6 relative overflow-hidden">
<div class="absolute inset-0 bg-primary-container/5"></div>
<div class="max-w-4xl mx-auto relative text-center">
<h2 class="text-4xl font-bold mb-6 text-white">Ready to grow your wealth?</h2>
<p class="text-on-surface-variant mb-10 text-lg">Join <?php $ic = get_site_setting('investors_count', '45000'); echo htmlspecialchars(is_numeric($ic) ? number_format((float)$ic) . '+' : $ic . '+'); ?> investors using <?php echo htmlspecialchars($siteName); ?> to automate their crypto growth.</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
<a href="/register" class="gradient-button px-10 py-4 font-bold text-lg inline-block text-center">Create Account</a>
<button type="button" class="btn-secondary px-10 py-4 font-bold text-lg">Contact Sales</button>
</div>
</div>
</section>
</main>
<?php require_once __DIR__ . '/includes/marketing-footer.php'; ?>
</body></html>
