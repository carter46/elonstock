<?php
require_once __DIR__ . '/../../includes/auth-check.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/plan-types.php';
require_once __DIR__ . '/../../includes/usd-wallet.php';
$currentPage = 'dashboard';
$siteName = get_site_name();
$userBalance = 0;
$userBalanceUpdatedAt = null;
$totalProfit = 0;
$activeCapital = 0;
$dailyEarning = 0;
$referralBonus = 0;
$referralBonusLast24h = 0;
$activeInvestments = [];
$chartData = [];
$period = $_GET['period'] ?? '1M';
$plansByTypeForTrades = [];
$activePlanTypesForTrades = [];
$defaultTradeTab = 'crypto';
$showTradeTabs = false;
$planTypes = get_plan_types();
$days = match($period) {
    '1D' => 1,
    '1W' => 7,
    '1M' => 30,
    '1Y' => 365,
    default => 30
};
try {
    $pdo = require __DIR__ . '/../../includes/db.php';
    $userId = $_SESSION['user_id'];
    $userBalance = get_user_spendable_usd_balance($pdo, (int) $userId);
    try {
        $bc = $pdo->query("SHOW COLUMNS FROM users LIKE 'last_balance_usd_updated_at'");
        if ($bc && $bc->rowCount() > 0) {
            $s = $pdo->prepare('SELECT last_balance_usd_updated_at FROM users WHERE id = ?');
            $s->execute([(int) $userId]);
            $userBalanceUpdatedAt = $s->fetchColumn() ?: null;
        }
    } catch (Throwable $e) {}

    ensure_plan_schema($pdo);
    $stmtPlans = $pdo->query('SELECT name, plan_type FROM plans WHERE enabled = 1 ORDER BY sort_order, id');
    while ($row = $stmtPlans->fetch(PDO::FETCH_ASSOC)) {
        $typeKey = normalize_plan_type($row['plan_type'] ?? 'crypto');
        if (!isset($plansByTypeForTrades[$typeKey])) {
            $plansByTypeForTrades[$typeKey] = [];
        }
        $plansByTypeForTrades[$typeKey][] = $row['name'];
    }
    foreach ($planTypes as $typeKey => $typeLabel) {
        if (!empty($plansByTypeForTrades[$typeKey])) {
            $activePlanTypesForTrades[$typeKey] = $typeLabel;
        }
    }
    $defaultTradeTab = array_key_first($activePlanTypesForTrades) ?: 'crypto';
    $showTradeTabs = count($activePlanTypesForTrades) > 1;

    $r = $pdo->prepare("SELECT COALESCE(SUM(amount), 0) FROM user_investments WHERE user_id = ? AND status = 'active'");
    $r->execute([$userId]); $activeCapital = (float)$r->fetchColumn();
    $totalProfit = get_user_realized_profit($pdo, (int) $userId);
    $stmt = $pdo->prepare('SELECT ui.id, ui.plan_id, ui.amount, ui.start_date, ui.status, ui.duration_days as investment_duration_days, p.name as plan_name, p.yield_min, p.yield_max, p.duration_days as plan_duration_days FROM user_investments ui JOIN plans p ON p.id = ui.plan_id WHERE ui.user_id = ? AND ui.status = ? ORDER BY ui.created_at DESC LIMIT 5');
    $stmt->execute([$userId, 'active']);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $activeInvestments[] = $row;
        $yieldMin = (float)($row['yield_min'] ?? 0);
        $yieldMax = (float)($row['yield_max'] ?? 0);
        $avgYield = ($yieldMin + $yieldMax) / 2;
        if ($avgYield <= 0) $avgYield = $yieldMin;
        $dailyEarning += (float)$row['amount'] * ($avgYield / 100);
    }
    $referralBonus = get_user_total_referral_bonus($pdo, (int) $userId);
    $referralBonusLast24h = get_user_total_referral_bonus($pdo, (int) $userId, null, 24);
    $stmt = $pdo->prepare("SELECT DATE(created_at) as date, type, SUM(amount) as total FROM transactions WHERE user_id = ? AND type IN ('deposit', 'withdrawal') AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) GROUP BY DATE(created_at), type ORDER BY date ASC");
    $stmt->execute([$userId, $days]);
    $dailyData = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $date = $row['date'];
        if (!isset($dailyData[$date])) $dailyData[$date] = ['deposit' => 0, 'withdrawal' => 0];
        $dailyData[$date][$row['type']] = (float)$row['total'];
    }
    $cumulative = 0;
    foreach ($dailyData as $date => $amounts) {
        $cumulative += $amounts['deposit'] - $amounts['withdrawal'];
        $chartData[] = ['date' => $date, 'value' => $cumulative];
    }
} catch (Throwable $e) { }
$profileUser = get_current_user_data() ?? [];
$dashboardUserName = $profileUser['name'] ?? 'User';
$isVerified = !empty($profileUser['verified']) || (($profileUser['kyc_status'] ?? '') === 'approved');
$pageTitle = $siteName . ' | Dashboard';
$hour = (int) date('G');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
$growthPct = $userBalance > 0 ? min(99.9, ($totalProfit / max(1, $userBalance)) * 100) : 0;
$capitalRatio = ($userBalance + $activeCapital) > 0 ? min(100, ($activeCapital / max(0.01, $userBalance + $activeCapital)) * 100) : 0;
$scaleCtaBg = '/uploads/images/banner_bg.jpg';
require_once __DIR__ . '/../../includes/dashboard/user-layout-start.php';
require_once __DIR__ . '/../../includes/dashboard/user-social-proof-data.php';
$socialProofMessages = user_dashboard_social_proof_messages();
$chartBtnActive = 'px-4 py-1.5 text-label-sm rounded-md bg-primary text-on-primary-container shadow-lg';
$chartBtnIdle = 'px-4 py-1.5 text-label-sm rounded-md hover:bg-surface-bright transition-colors';
$axisMax = !empty($chartData) ? max(array_column($chartData, 'value')) : max($userBalance, 100);
$axisMin = !empty($chartData) ? min(array_column($chartData, 'value')) : 0;
if ($axisMax <= $axisMin) { $axisMax = $axisMin + 100; }
$axisMidHigh = $axisMin + ($axisMax - $axisMin) * 0.66;
$axisMidLow = $axisMin + ($axisMax - $axisMin) * 0.33;
?>
<div class="dash-page w-full min-w-0 space-y-8">

<!-- Welcome Header -->
<section class="flex flex-col lg:flex-row lg:justify-between lg:items-end gap-4">
<div>
<h2 class="font-display-sm text-[28px] leading-9 md:text-display-sm text-on-surface tracking-tight mb-1 flex flex-wrap items-center gap-3">
<?php echo htmlspecialchars($greeting); ?>, <?php echo htmlspecialchars($dashboardUserName); ?>.
<?php if ($isVerified): ?>
<span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">verified</span>
<?php endif; ?>
</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant opacity-80">Welcome back to your institutional trading hub.</p>
</div>
<div class="glass-card px-6 py-3 rounded-xl flex items-center gap-4 max-w-md w-full lg:w-auto animate-fade-in" id="live-notification">
<div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary text-sm">bolt</span>
</div>
<p id="user-social-proof-text" class="text-label-md text-on-surface-variant"></p>
</div>
<script type="application/json" id="user-social-proof-data"><?php echo json_encode($socialProofMessages, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
</section>

<!-- Key Metrics Row -->
<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
<div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-5xl">payments</span>
</div>
<p class="text-label-sm text-on-surface-variant uppercase tracking-widest font-bold mb-2">Total Balance</p>
<h3 class="text-3xl font-display-sm text-white">$<?php echo number_format((float) $userBalance, 2, '.', ','); ?></h3>
<div class="mt-4 flex items-center gap-2">
<?php if ($growthPct > 0): ?>
<span class="status-pill-green text-[10px] px-2 py-0.5 rounded-full">+<?php echo number_format($growthPct, 1); ?>% realized</span>
<?php else: ?>
<span class="status-pill-green text-[10px] px-2 py-0.5 rounded-full">Spendable USD</span>
<?php endif; ?>
</div>
</div>
<div class="glass-card p-6 rounded-2xl relative overflow-hidden group">
<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
<span class="material-symbols-outlined text-5xl">trending_up</span>
</div>
<p class="text-label-sm text-on-surface-variant uppercase tracking-widest font-bold mb-2">Total Profit</p>
<h3 class="text-3xl font-display-sm text-primary">+$<?php echo format_usd_amount($totalProfit); ?></h3>
<p class="text-[12px] text-primary/80 mt-2 font-medium"><?php echo $growthPct > 0 ? '+' . number_format($growthPct, 1) . '% Realized Growth' : 'Settled plans only'; ?></p>
</div>
<div class="glass-card p-6 rounded-2xl">
<p class="text-label-sm text-on-surface-variant uppercase tracking-widest font-bold mb-2">Active Capital</p>
<h3 class="text-3xl font-display-sm text-white">$<?php echo format_usd_amount($activeCapital); ?></h3>
<div class="w-full bg-white/5 h-1 rounded-full mt-6 overflow-hidden">
<div class="bg-primary h-full" style="width:<?php echo number_format($capitalRatio, 1); ?>%"></div>
</div>
</div>
<div class="glass-card p-6 rounded-2xl">
<p class="text-label-sm text-on-surface-variant uppercase tracking-widest font-bold mb-2">Daily Earning</p>
<h3 class="text-3xl font-display-sm text-white">$<?php echo format_usd_amount($dailyEarning); ?></h3>
<p class="text-[12px] text-on-surface-variant mt-2 font-mono">EST. NEXT PAYOUT: 08:00 UTC</p>
</div>
<div class="glass-card p-6 rounded-2xl">
<p class="text-label-sm text-on-surface-variant uppercase tracking-widest font-bold mb-2">Referral Bonus</p>
<h3 class="text-3xl font-display-sm text-white">$<?php echo format_usd_amount($referralBonus); ?></h3>
<p class="text-[12px] text-on-surface-variant mt-2">Last 24h: +$<?php echo format_usd_amount($referralBonusLast24h); ?></p>
</div>
</section>

<!-- Main Data & Sidebar Grid -->
<div class="grid grid-cols-12 gap-8">
<div class="col-span-12 lg:col-span-8 space-y-8">
<!-- Portfolio Growth -->
<div class="glass-card rounded-2xl p-6 md:p-8 relative min-h-[450px] flex flex-col">
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
<div>
<h4 class="font-headline-md text-headline-md text-on-surface">Portfolio Growth</h4>
<p class="text-label-md text-on-surface-variant opacity-60">AI Engine Yield Analysis</p>
</div>
<div class="flex bg-surface-container p-1 rounded-lg border border-white/5 w-fit">
<button type="button" data-period="1D" class="chart-filter-btn <?php echo $period === '1D' ? $chartBtnActive : $chartBtnIdle; ?>">1D</button>
<button type="button" data-period="1W" class="chart-filter-btn <?php echo $period === '1W' ? $chartBtnActive : $chartBtnIdle; ?>">1W</button>
<button type="button" data-period="1M" class="chart-filter-btn <?php echo $period === '1M' ? $chartBtnActive : $chartBtnIdle; ?>">1M</button>
<button type="button" data-period="1Y" class="chart-filter-btn <?php echo $period === '1Y' ? $chartBtnActive : $chartBtnIdle; ?>">1Y</button>
</div>
</div>
<div class="flex-grow relative mt-4 min-h-[260px]" id="performance-chart-wrap">
<div class="absolute inset-0 flex flex-col justify-between pointer-events-none border-l border-b border-white/5 pb-6" id="chart-axis">
<div class="flex justify-between w-full text-[10px] text-on-surface-variant font-mono">
<span>$<?php echo number_format($axisMax, 0); ?></span><div class="h-px bg-white/5 flex-grow mx-4 self-center"></div>
</div>
<div class="flex justify-between w-full text-[10px] text-on-surface-variant font-mono">
<span>$<?php echo number_format($axisMidHigh, 0); ?></span><div class="h-px bg-white/5 flex-grow mx-4 self-center"></div>
</div>
<div class="flex justify-between w-full text-[10px] text-on-surface-variant font-mono">
<span>$<?php echo number_format($axisMidLow, 0); ?></span><div class="h-px bg-white/5 flex-grow mx-4 self-center"></div>
</div>
<div class="flex justify-between w-full text-[10px] text-on-surface-variant font-mono">
<span>$<?php echo number_format($axisMin, 0); ?></span><div class="h-px bg-white/5 flex-grow mx-4 self-center"></div>
</div>
</div>
<div class="absolute inset-0" id="performance-chart">
<?php
$dates = [];
if (!empty($chartData)) {
    $maxVal = max(array_column($chartData, 'value'));
    $minVal = min(array_column($chartData, 'value'));
    $range = $maxVal - $minVal;
    if ($range == 0) $range = 1;
    $svgPts = [];
    $count = count($chartData);
    foreach ($chartData as $i => $point) {
        $x = $count > 1 ? ($i / ($count - 1)) * 1000 : 500;
        $y = 250 - (($point['value'] - $minVal) / $range) * 200;
        $svgPts[] = round($x, 1) . ',' . round($y, 1);
        if ($i === 0 || $i === floor($count / 4) || $i === floor($count / 2) || $i === floor($count * 3 / 4) || $i === $count - 1) {
            $dates[] = date('M j', strtotime($point['date']));
        }
    }
    $pathD = 'M' . implode(' L', $svgPts);
?>
<svg class="absolute inset-0 w-full h-full" preserveAspectRatio="none" viewBox="0 0 1000 300">
<path class="glow-line" d="<?php echo htmlspecialchars($pathD); ?>" fill="none" stroke="#adc6ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
</svg>
<?php } else { ?>
<div class="absolute inset-0 flex items-center justify-center text-on-surface-variant text-sm">No data available</div>
<?php } ?>
</div>
</div>
</div>

<!-- Live AI Trades -->
<div class="glass-card rounded-2xl overflow-hidden">
<div class="px-8 py-6 border-b border-white/5 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
<h4 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
<span class="material-symbols-outlined text-primary">dynamic_feed</span>
Live AI Execution Logs
</h4>
<span class="text-label-sm text-on-surface-variant animate-pulse">Scanning Global Markets...</span>
</div>
<?php if (!empty($showTradeTabs)): ?>
<nav class="flex gap-3 overflow-x-auto px-8 pt-4 dash-trade-tabs" aria-label="Plan categories">
<?php foreach ($activePlanTypesForTrades as $typeKey => $typeLabel): ?>
<button type="button" class="dash-trade-tab shrink-0 pb-3 text-[11px] font-bold uppercase tracking-wide text-on-surface-variant border-b-2 border-transparent whitespace-nowrap<?php echo $typeKey === $defaultTradeTab ? ' is-active' : ''; ?>" data-trade-tab="<?php echo htmlspecialchars($typeKey); ?>"><?php echo htmlspecialchars($typeLabel); ?></button>
<?php endforeach; ?>
</nav>
<?php endif; ?>
<div class="divide-y divide-white/5" id="live-trades-panel">
<?php
$initialTradePlans = $plansByTypeForTrades[$defaultTradeTab] ?? ['Growth Plan', 'Premium Plan', 'Core Plan'];
$tradeSamples = array_slice($initialTradePlans, 0, 3);
$execLabels = ['Execution: Grid Algorithm V4.2', 'Execution: Sentiment Analysis', 'Awaiting Liquidity Re-entry'];
foreach ($tradeSamples as $ti => $planName):
    $isLong = ($ti < 2);
    $tradeMins = max(1, ($ti + 1) * 7 + ($ti * 3));
    $tradeAmountVal = $isLong ? max(0, (($ti + 1) * 57.5) + fmod(crc32($planName . (string) $ti), 120)) : 0;
    $tradeAmountStr = ($isLong ? '+' : '+') . '$' . number_format($tradeAmountVal, 2);
    $pairCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $planName) ?: 'PLAN', 0, 4));
    $pairLabel = $pairCode . '/USDT';
?>
<div class="live-trade-card px-8 py-4 flex justify-between items-center hover:bg-white/[0.02] transition-colors group">
<div class="flex items-center gap-4 min-w-0">
<div class="trade-icon-container w-10 h-10 rounded-lg <?php echo $isLong ? 'bg-emerald-500/10 text-emerald-400' : 'bg-primary/10 text-primary'; ?> flex items-center justify-center shrink-0">
<span class="trade-icon material-symbols-outlined"><?php echo $isLong ? 'north_east' : 'drag_handle'; ?></span>
</div>
<div class="min-w-0">
<p class="trade-pair font-bold text-on-surface truncate"><?php echo htmlspecialchars($planName); ?> Long <span class="trade-side text-[11px] font-normal opacity-50 ml-2"><?php echo htmlspecialchars($pairLabel); ?></span></p>
<p class="trade-time text-[12px] text-on-surface-variant"><?php echo $execLabels[$ti] ?? 'Execution: Signal Engine'; ?></p>
</div>
</div>
<div class="text-right shrink-0">
<p class="live-trade-amount font-mono <?php echo $isLong ? 'text-emerald-400' : 'text-white'; ?> font-bold"><?php echo $tradeAmountStr; ?></p>
<p class="text-[11px] text-on-surface-variant trade-meta"><?php echo $isLong ? ('Closed ' . (int) $tradeMins . 'm ago') : 'Pending Closure'; ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>

<!-- Sidebar Widgets -->
<div class="col-span-12 lg:col-span-4 space-y-6">
<div class="glass-card p-6 rounded-2xl border-l-4 border-primary">
<h5 class="text-label-sm font-bold uppercase tracking-widest text-on-surface-variant mb-6">Market Health</h5>
<div class="space-y-6">
<div>
<div class="flex justify-between items-center mb-2">
<span class="text-label-md text-on-surface">Volatility Index</span>
<span class="text-[12px] font-bold text-emerald-400">Low Risk Profile</span>
</div>
<div class="w-full bg-white/5 h-1.5 rounded-full">
<div class="bg-emerald-400 h-full w-[15%] shadow-[0_0_8px_rgba(52,211,153,0.4)]"></div>
</div>
</div>
<div>
<div class="flex justify-between items-center mb-2">
<span class="text-label-md text-on-surface">Cold Wallet Status</span>
<span class="text-[12px] font-bold text-primary">99.8% Segregated</span>
</div>
<div class="w-full bg-white/5 h-1.5 rounded-full">
<div class="bg-primary h-full w-[99.8%] shadow-[0_0_8px_rgba(173,198,255,0.4)]"></div>
</div>
</div>
</div>
</div>

<div class="glass-card p-6 rounded-2xl">
<h5 class="text-label-sm font-bold uppercase tracking-widest text-on-surface-variant mb-4">Current Exposure</h5>
<?php if (empty($activeInvestments)): ?>
<div class="p-4 bg-white/5 rounded-xl border border-white/5 text-center">
<div class="w-10 h-10 mx-auto mb-3 rounded-full bg-white flex items-center justify-center">
<span class="material-symbols-outlined text-surface-dim text-[20px]">inventory_2</span>
</div>
<p class="text-sm text-on-surface-variant">No active investments yet.</p>
</div>
<?php else: ?>
<?php
$featured = $activeInvestments[0];
$startDate = new DateTime($featured['start_date']);
$now = new DateTime();
$daysElapsed = $now->diff($startDate)->days;
$durationDays = (int)($featured['investment_duration_days'] ?? $featured['plan_duration_days'] ?? 30);
$daysLeft = max(0, $durationDays - $daysElapsed);
$avgYield = (($featured['yield_min'] ?? 0) + ($featured['yield_max'] ?? 0)) / 2;
$accrued = (float)$featured['amount'] * ($avgYield / 100) * min($daysElapsed, $durationDays);
$planInitial = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $featured['plan_name']) ?: 'P', 0, 1));
?>
<div class="p-4 bg-white/5 rounded-xl border border-white/5">
<div class="flex justify-between items-start mb-4 gap-3">
<div class="flex items-center gap-3 min-w-0">
<div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0">
<span class="text-surface-dim font-bold text-sm"><?php echo htmlspecialchars($planInitial); ?></span>
</div>
<div class="min-w-0">
<p class="font-bold text-on-surface truncate"><?php echo htmlspecialchars($featured['plan_name']); ?></p>
<p class="text-[12px] text-on-surface-variant">$<?php echo format_usd_amount($featured['amount']); ?> Capital</p>
</div>
</div>
<span class="status-pill-green text-[10px] px-2 py-0.5 rounded-full shrink-0">+<?php echo number_format($avgYield, 1); ?>% ROI</span>
</div>
<div class="space-y-2">
<div class="flex justify-between text-[11px]">
<span class="text-on-surface-variant">Accrued Yield</span>
<span class="text-primary font-bold">+$<?php echo format_usd_amount($accrued); ?></span>
</div>
<div class="flex justify-between text-[11px]">
<span class="text-on-surface-variant">Duration Remaining</span>
<span class="text-white"><?php echo (int) $daysLeft; ?> Days</span>
</div>
</div>
</div>
<?php endif; ?>
<a href="/dashboard/user/investment-plans" class="w-full mt-4 border border-primary/30 hover:border-primary text-primary font-label-md text-label-md py-3 rounded-lg transition-all active:scale-[0.98] text-center block">
Manage Plan
</a>
</div>

<a href="/dashboard/user/investment-plans" class="relative rounded-2xl overflow-hidden h-64 group cursor-pointer block">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('<?php echo htmlspecialchars($scaleCtaBg); ?>');"></div>
<div class="absolute inset-0 bg-gradient-to-t from-surface-dim via-surface-dim/40 to-transparent"></div>
<div class="absolute inset-0 p-8 flex flex-col justify-end">
<h4 class="font-headline-md text-headline-md text-white mb-2">Ready to Scale?</h4>
<p class="text-label-md text-on-surface-variant mb-6">Unlock higher yield tiers and exclusive institutional pools.</p>
<span class="premium-gradient-btn text-white font-bold py-3 px-6 rounded-lg shadow-2xl flex items-center justify-center gap-2">
Subscribe to New Investment Plan
<span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
</span>
</div>
</a>
</div>
</div>
</div>

<?php require_once __DIR__ . '/../../includes/dashboard/user-layout-end.php'; ?>
<?php require_once __DIR__ . '/../../includes/app-script.php'; ?>
<script>window.BLOOMBIT_API_BASE = '';</script>
<script src="/js/crypto-config.js"></script>
<script src="/js/crypto-prices.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.BloombitCryptoPrices) {
        window.BloombitCryptoPrices.init(['bitcoin'], { refreshInterval: 300000 });
    }

    var tradePlansByType = <?php echo json_encode($plansByTypeForTrades, JSON_UNESCAPED_UNICODE); ?>;
    var activeTradeTab = <?php echo json_encode($defaultTradeTab); ?>;

    function getTradePlanNames() {
        var names = tradePlansByType[activeTradeTab] || [];
        if (!names.length) names = ['Basic Plan', 'Growth Plan', 'Premium Plan'];
        return names;
    }

    document.querySelectorAll('.dash-trade-tab').forEach(function(tab) {
        tab.addEventListener('click', function () {
            activeTradeTab = tab.getAttribute('data-trade-tab');
            document.querySelectorAll('.dash-trade-tab').forEach(function (t) { t.classList.remove('is-active'); });
            tab.classList.add('is-active');
            document.querySelectorAll('.live-trade-card').forEach(function (card) { updateTrade(card); });
        });
    });

    function animateTradeAmount(el) {
        var current = parseFloat(el.textContent.replace(/[^0-9.-]/g, '')) || 0;
        var change = (Math.random() * 200 - 100);
        var newVal = Math.max(0, current + change);
        var absVal = Math.abs(newVal);
        el.className = 'live-trade-amount font-mono font-bold ' + (absVal >= 50 ? 'text-emerald-400' : 'text-white');
        el.textContent = (newVal >= 0 ? '+' : '-') + '$' + absVal.toFixed(2);
    }

    function updateTrade(el) {
        if (!el) return;
        var pairEl = el.querySelector('.trade-pair');
        var timeEl = el.querySelector('.trade-time');
        var metaEl = el.querySelector('.trade-meta');
        var iconEl = el.querySelector('.trade-icon');
        var amountEl = el.querySelector('.live-trade-amount');
        var iconContainer = el.querySelector('.trade-icon-container');
        if (!pairEl || !timeEl || !iconEl || !iconContainer) return;
        var planNames = getTradePlanNames();
        var planName = planNames[Math.floor(Math.random() * planNames.length)];
        var isLong = Math.random() > 0.35;
        var mins = Math.floor(Math.random() * 30) + 1;
        var pairCode = String(planName).replace(/[^A-Za-z0-9]/g, '').slice(0, 4).toUpperCase() || 'PLAN';
        pairEl.innerHTML = planName + ' Long <span class="trade-side text-[11px] font-normal opacity-50 ml-2">' + pairCode + '/USDT</span>';
        timeEl.textContent = isLong ? 'Execution: Grid Algorithm V4.2' : 'Awaiting Liquidity Re-entry';
        if (metaEl) metaEl.textContent = isLong ? ('Closed ' + mins + 'm ago') : 'Pending Closure';
        if (isLong) {
            iconContainer.className = 'trade-icon-container w-10 h-10 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0';
            iconEl.textContent = 'north_east';
        } else {
            iconContainer.className = 'trade-icon-container w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0';
            iconEl.textContent = 'drag_handle';
        }
        if (amountEl) {
            if (isLong) animateTradeAmount(amountEl);
            else {
                amountEl.className = 'live-trade-amount font-mono font-bold text-white';
                amountEl.textContent = '+$0.00';
            }
        }
    }

    document.querySelectorAll('.live-trade-card').forEach(function(card, i) {
        setInterval(function () {
            var cards = document.querySelectorAll('.live-trade-card');
            var c = cards && cards.length > i ? cards[i] : null;
            if (!c) return;
            var amountEl = c.querySelector('.live-trade-amount');
            if (amountEl) animateTradeAmount(amountEl);
        }, 3000 + (i * 500));
        setInterval(function () {
            var cards = document.querySelectorAll('.live-trade-card');
            var c = cards && cards.length > i ? cards[i] : null;
            if (c) updateTrade(c);
        }, 8000 + (i * 1000));
    });

    var chartContainer = document.getElementById('performance-chart');
    var chartAxis = document.getElementById('chart-axis');
    var currentPeriod = '<?php echo htmlspecialchars($period); ?>';

    function updateChart(data) {
        if (!chartContainer) return;
        if (!data || data.length === 0) {
            chartContainer.innerHTML = '<div class="absolute inset-0 flex items-center justify-center text-on-surface-variant text-sm">No data available</div>';
            return;
        }
        var maxVal = Math.max.apply(null, data.map(function(d){ return d.value; }));
        var minVal = Math.min.apply(null, data.map(function(d){ return d.value; }));
        if (maxVal <= minVal) maxVal = minVal + 100;
        var midHigh = minVal + (maxVal - minVal) * 0.66;
        var midLow = minVal + (maxVal - minVal) * 0.33;
        if (chartAxis) {
            var labels = chartAxis.querySelectorAll('span');
            if (labels[0]) labels[0].textContent = '$' + Math.round(maxVal).toLocaleString();
            if (labels[1]) labels[1].textContent = '$' + Math.round(midHigh).toLocaleString();
            if (labels[2]) labels[2].textContent = '$' + Math.round(midLow).toLocaleString();
            if (labels[3]) labels[3].textContent = '$' + Math.round(minVal).toLocaleString();
        }
        var range = maxVal - minVal;
        var count = data.length;
        var points = [];
        data.forEach(function(point, i) {
            var x = count > 1 ? (i / (count - 1)) * 1000 : 500;
            var y = 250 - ((point.value - minVal) / range) * 200;
            points.push(x.toFixed(1) + ',' + y.toFixed(1));
        });
        chartContainer.innerHTML = '<svg class="absolute inset-0 w-full h-full" preserveAspectRatio="none" viewBox="0 0 1000 300"><path class="glow-line" d="M' + points.join(' L') + '" fill="none" stroke="#adc6ff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path></svg>';
    }

    function setChartBtnActive(btn) {
        document.querySelectorAll('.chart-filter-btn').forEach(function (b) {
            b.className = 'chart-filter-btn px-4 py-1.5 text-label-sm rounded-md hover:bg-surface-bright transition-colors';
        });
        btn.className = 'chart-filter-btn px-4 py-1.5 text-label-sm rounded-md bg-primary text-on-primary-container shadow-lg';
    }

    document.querySelectorAll('.chart-filter-btn').forEach(function(btn) {
        var p = btn.getAttribute('data-period');
        if (p === currentPeriod) setChartBtnActive(btn);
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            setChartBtnActive(this);
            var period = this.getAttribute('data-period');
            fetch('/api/user/chart-data.php?period=' + period, { credentials: 'same-origin' }).then(function(r){ return r.json(); }).then(function(res){
                if (res.success && res.data) updateChart(res.data);
            }).catch(function(){ if (chartContainer) chartContainer.innerHTML = '<div class="absolute inset-0 flex items-center justify-center text-on-surface-variant text-sm">Failed to load chart</div>'; });
        });
    });
});
</script>
</body></html>
