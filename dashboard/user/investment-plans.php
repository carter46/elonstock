<?php
require_once __DIR__ . '/../../includes/auth-check.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/plan-types.php';
require_once __DIR__ . '/../../includes/usd-wallet.php';
$currentPage = 'investment-plans';
$siteName = get_site_name();
$planTypes = get_plan_types();

$plans = [];
$userBalance = 0;
try {
    $pdo = require __DIR__ . '/../../includes/db.php';
    ensure_plan_schema($pdo);
    $userId = $_SESSION['user_id'];
    $userBalance = get_user_spendable_usd_balance($pdo, (int) $userId);
    
    // Fetch enabled plans
    $stmt = $pdo->query('SELECT id, name, slug, plan_type, description, logo_url, investment_risk, min_deposit, max_deposit, yield_min, yield_max, duration_days, min_duration_days, max_duration_days, min_duration_months, max_duration_months, withdrawal_days, liquidation_cost, features_json FROM plans WHERE enabled = 1 ORDER BY sort_order, id');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $plans[] = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'slug' => $row['slug'],
            'plan_type' => normalize_plan_type($row['plan_type'] ?? 'crypto'),
            'description' => $row['description'] ?? '',
            'logo_url' => $row['logo_url'] ?? null,
            'investment_risk' => normalize_investment_risk($row['investment_risk'] ?? 'mid'),
            'min_deposit' => (float)$row['min_deposit'],
            'max_deposit' => $row['max_deposit'] !== null ? (float)$row['max_deposit'] : null,
            'yield_min' => (float)$row['yield_min'],
            'yield_max' => (float)$row['yield_max'],
            'duration_days' => (int)$row['duration_days'],
            'min_duration_days' => isset($row['min_duration_days']) && $row['min_duration_days'] !== null ? (int)$row['min_duration_days'] : (isset($row['min_duration_months']) && $row['min_duration_months'] !== null ? (int)$row['min_duration_months'] * 30 : (int)$row['duration_days']),
            'max_duration_days' => isset($row['max_duration_days']) && $row['max_duration_days'] !== null ? (int)$row['max_duration_days'] : (isset($row['max_duration_months']) && $row['max_duration_months'] !== null ? (int)$row['max_duration_months'] * 30 : (int)$row['duration_days']),
            'withdrawal_days' => (int)$row['withdrawal_days'],
            'liquidation_cost' => isset($row['liquidation_cost']) ? (float)$row['liquidation_cost'] : 0.0,
            'features' => $row['features_json'] ? json_decode($row['features_json'], true) : [],
        ];
    }
} catch (Throwable $e) { }

$plansByType = [];
foreach ($planTypes as $typeKey => $typeLabel) {
    $plansByType[$typeKey] = array_values(array_filter($plans, function ($plan) use ($typeKey) {
        return ($plan['plan_type'] ?? 'crypto') === $typeKey;
    }));
}
$activePlanTypes = [];
foreach ($planTypes as $typeKey => $typeLabel) {
    if (!empty($plansByType[$typeKey])) {
        $activePlanTypes[$typeKey] = $typeLabel;
    }
}
$defaultTab = array_key_first($activePlanTypes) ?: 'crypto';
$showPlanTabs = count($activePlanTypes) > 1;

$pageTitle = $siteName . ' | Investment Plans';
$pageHeading = 'Investments';
$pageSubtitle = 'Browse investment opportunities and invest using your available account balance.';
require_once __DIR__ . '/../../includes/dashboard/user-layout-start.php';
include __DIR__ . '/../../includes/dashboard/user-page-title.php';
?>

<style>
.plan-type-tab.is-active { color: #ffc35c; border-bottom-color: #ffc35c; font-weight: 700; }
.plan-type-panel { display: none; }
.plan-type-panel.is-active { display: grid; }
.plan-asset-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
.plan-asset-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.18); }
.plan-type-tabs-nav {
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  -ms-overflow-style: none;
  overscroll-behavior-x: contain;
}
.plan-type-tabs-nav::-webkit-scrollbar { display: none; }
.plan-type-tabs-track {
  display: inline-flex;
  gap: 1.5rem;
  min-width: 100%;
  width: max-content;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  padding-bottom: 0;
}
@media (min-width: 768px) {
  .plan-type-tabs-track { width: 100%; }
}
</style>

<div class="dash-page w-full min-w-0">
<section class="mb-8">
<div class="glass-panel rounded-xl p-4 md:p-6 flex flex-wrap justify-between items-center gap-4">
<div class="flex items-center gap-4 min-w-0">
<div class="w-12 h-12 rounded-full bg-primary-container/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary-container">account_balance_wallet</span>
</div>
<div>
<p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Available to Invest</p>
<h3 class="text-2xl md:text-3xl font-bold text-text-primary leading-none mt-1">USD <?php echo format_usd_amount($userBalance); ?></h3>
</div>
</div>
<div class="flex flex-col items-start md:items-end gap-2">
<p class="text-xs text-text-secondary flex items-center gap-1">
<span class="material-symbols-outlined text-sm">info</span>
Select a plan below to invest from your wallet balance.
</p>
<a href="/dashboard/user/wallet" class="inline-flex items-center gap-2 bg-primary-container hover:bg-primary-container/90 text-on-primary px-4 py-2 rounded-lg font-label-sm text-label-sm transition-colors">
<span class="material-symbols-outlined text-sm">add</span> Add Funds
</a>
</div>
</div>
</section>

<?php if (empty($plans)): ?>
<div class="text-center py-12 glass-panel rounded-xl">
<p class="text-text-secondary">No investment plans available at the moment.</p>
</div>
<?php else: ?>
<?php if ($showPlanTabs): ?>
<nav class="plan-type-tabs-nav mb-8 -mx-4 px-4 md:mx-0 md:px-0 overflow-x-auto" aria-label="Investment plan categories">
<div class="plan-type-tabs-track">
<?php foreach ($activePlanTypes as $typeKey => $typeLabel): ?>
<button type="button" class="plan-type-tab shrink-0 pb-3 text-sm font-label-sm text-label-sm text-on-surface-variant hover:text-primary-container transition-colors border-b-2 border-transparent whitespace-nowrap<?php echo $typeKey === $defaultTab ? ' is-active' : ''; ?>" data-plan-tab="<?php echo htmlspecialchars($typeKey); ?>">
<?php echo htmlspecialchars($typeLabel); ?>
<span class="ml-1 text-[10px] opacity-60">(<?php echo count($plansByType[$typeKey]); ?>)</span>
</button>
<?php endforeach; ?>
</div>
</nav>
<?php endif; ?>

<?php foreach ($activePlanTypes as $typeKey => $typeLabel):
    $typePlans = $plansByType[$typeKey];
?>
<div class="plan-type-panel bento-grid mb-8<?php echo ($typeKey === $defaultTab || !$showPlanTabs) ? ' is-active' : ''; ?>" data-plan-panel="<?php echo htmlspecialchars($typeKey); ?>">
<?php foreach ($typePlans as $plan):
    $planDays = plan_duration_days($plan);
    $riskBadge = plan_investment_risk_badge($plan['investment_risk'] ?? 'mid');
    $periodReturn = format_plan_period_return($plan['yield_min'] ?? 0, $planDays);
?>
<div class="plan-asset-card asset-card glass-panel rounded-xl p-5 md:p-6 flex flex-col h-full">
<div class="flex justify-between items-start gap-3 mb-4">
<div class="flex items-center gap-3 min-w-0">
<?php echo plan_logo_markup($plan['logo_url'] ?? null, $plan['name'], 'w-10 h-10', 'text-sm'); ?>
<div class="min-w-0">
<h4 class="text-base md:text-lg font-bold text-text-primary leading-tight truncate"><?php echo htmlspecialchars($plan['name']); ?></h4>
<p class="text-xs text-text-secondary truncate"><?php echo htmlspecialchars($plan['description'] ?: 'Premium investment plan'); ?></p>
</div>
</div>
<span class="<?php echo $riskBadge['class']; ?> px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider shrink-0"><?php echo htmlspecialchars($riskBadge['label']); ?></span>
</div>
<div class="space-y-4 mb-6 flex-grow">
<div class="grid grid-cols-2 gap-4">
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Expected Return</p>
<p class="text-base font-bold text-primary-container mt-1"><?php echo htmlspecialchars($periodReturn); ?></p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Min. Investment</p>
<p class="text-base font-bold text-text-primary mt-1">USD <?php echo format_usd_amount($plan['min_deposit']); ?></p>
</div>
</div>
<div class="flex justify-between items-center text-sm border-t border-low pt-3">
<span class="text-text-secondary">Duration</span>
<span class="text-text-primary font-semibold"><?php echo (int) $planDays; ?> Days</span>
</div>
<?php if (!empty($plan['liquidation_cost']) && (float)$plan['liquidation_cost'] > 0): ?>
<div class="flex justify-between items-center text-sm">
<span class="text-text-secondary">Early Exit Fee</span>
<span class="text-amber-600 dark:text-amber-400 font-semibold">USD <?php echo format_usd_amount($plan['liquidation_cost']); ?></span>
</div>
<?php endif; ?>
</div>
<?php if (plan_has_live_markets($plan)): ?>
<a href="/dashboard/user/investment-plans/<?php echo htmlspecialchars($plan['slug']); ?>" class="w-full bg-primary-container hover:bg-primary-container/90 text-on-primary font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
<span>View Market</span>
<span class="material-symbols-outlined text-sm">candlestick_chart</span>
</a>
<?php else: ?>
<button type="button" data-plan-id="<?php echo $plan['id']; ?>" data-plan-name="<?php echo htmlspecialchars($plan['name']); ?>" data-plan-min="<?php echo $plan['min_deposit']; ?>" data-plan-max="<?php echo $plan['max_deposit'] ?? 0; ?>" data-plan-days="<?php echo (int) $planDays; ?>" data-plan-liquidation-fee="<?php echo htmlspecialchars(number_format((float)($plan['liquidation_cost'] ?? 0), 2, '.', ''), ENT_QUOTES, 'UTF-8'); ?>" class="subscribe-plan-btn w-full bg-primary-container hover:bg-primary-container/90 text-on-primary font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
<span>Invest Now</span>
<span class="material-symbols-outlined text-sm">trending_up</span>
</button>
<?php endif; ?>
</div>
<?php endforeach; ?>
</div>
<?php endforeach; ?>
<?php endif; ?>

<!-- Subscribe Modal -->
<?php require_once __DIR__ . '/../../includes/dashboard/subscribe-plan-modal.php'; ?>

</div>
<?php require_once __DIR__ . '/../../includes/dashboard/user-layout-end.php'; ?>
<?php require_once __DIR__ . '/../../includes/app-script.php'; ?>
<?php require_once __DIR__ . '/../../includes/dashboard/subscribe-plan-script.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.plan-type-tab').forEach(function(tab) {
        tab.addEventListener('click', function () {
            var type = tab.getAttribute('data-plan-tab');
            document.querySelectorAll('.plan-type-tab').forEach(function (t) { t.classList.remove('is-active'); });
            document.querySelectorAll('.plan-type-panel').forEach(function (p) { p.classList.remove('is-active'); });
            tab.classList.add('is-active');
            var panel = document.querySelector('.plan-type-panel[data-plan-panel="' + type + '"]');
            if (panel) panel.classList.add('is-active');
        });
    });
});
</script>
</body></html>
