<?php
require_once __DIR__ . '/../../includes/auth-check.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/plan-types.php';
require_once __DIR__ . '/../../includes/usd-wallet.php';
require_once __DIR__ . '/../../includes/market-instruments.php';

$currentPage = 'investment-plans';
$siteName = get_site_name();
$planSlug = isset($_GET['slug']) ? strtolower(trim((string) $_GET['slug'])) : '';

if ($planSlug === '') {
    header('Location: /dashboard/user/investment-plans');
    exit;
}

$plan = null;
$userBalance = 0.0;

try {
    $pdo = require __DIR__ . '/../../includes/db.php';
    ensure_plan_schema($pdo);
    $userId = (int) $_SESSION['user_id'];
    $userBalance = get_user_spendable_usd_balance($pdo, $userId);

    $stmt = $pdo->prepare(
        'SELECT id, name, slug, plan_type, description, logo_url, investment_risk, min_deposit, max_deposit,
                yield_min, yield_max, duration_days, min_duration_days, max_duration_days,
                min_duration_months, max_duration_months, withdrawal_days, liquidation_cost, features_json
         FROM plans WHERE slug = ? AND enabled = 1 LIMIT 1'
    );
    $stmt->execute([$planSlug]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $plan = [
            'id' => (int) $row['id'],
            'name' => $row['name'],
            'slug' => $row['slug'],
            'plan_type' => normalize_plan_type($row['plan_type'] ?? 'crypto'),
            'description' => $row['description'] ?? '',
            'logo_url' => $row['logo_url'] ?? null,
            'investment_risk' => normalize_investment_risk($row['investment_risk'] ?? 'mid'),
            'min_deposit' => (float) $row['min_deposit'],
            'max_deposit' => $row['max_deposit'] !== null ? (float) $row['max_deposit'] : null,
            'yield_min' => (float) $row['yield_min'],
            'yield_max' => (float) $row['yield_max'],
            'duration_days' => (int) $row['duration_days'],
            'min_duration_days' => isset($row['min_duration_days']) && $row['min_duration_days'] !== null
                ? (int) $row['min_duration_days']
                : (isset($row['min_duration_months']) && $row['min_duration_months'] !== null
                    ? (int) $row['min_duration_months'] * 30
                    : (int) $row['duration_days']),
            'max_duration_days' => isset($row['max_duration_days']) && $row['max_duration_days'] !== null
                ? (int) $row['max_duration_days']
                : (isset($row['max_duration_months']) && $row['max_duration_months'] !== null
                    ? (int) $row['max_duration_months'] * 30
                    : (int) $row['duration_days']),
            'withdrawal_days' => (int) $row['withdrawal_days'],
            'liquidation_cost' => isset($row['liquidation_cost']) ? (float) $row['liquidation_cost'] : 0.0,
            'features' => $row['features_json'] ? json_decode($row['features_json'], true) : [],
        ];
    }
} catch (Throwable $e) {
    $plan = null;
}

if (!$plan) {
    http_response_code(404);
    $pageTitle = $siteName . ' | Plan Not Found';
    $pageHeading = 'Plan Not Found';
    $pageSubtitle = 'This investment plan is unavailable or may have been removed.';
    require_once __DIR__ . '/../../includes/dashboard/user-layout-start.php';
    include __DIR__ . '/../../includes/dashboard/user-page-title.php';
    echo '<div class="dash-page w-full min-w-0"><div class="glass-panel rounded-xl p-8 text-center"><p class="text-text-secondary mb-6">We could not find that plan.</p><a href="/dashboard/user/investment-plans" class="inline-flex items-center gap-2 bg-primary-container text-on-primary font-bold px-6 py-3 rounded-lg">Back to Plans</a></div></div>';
    require_once __DIR__ . '/../../includes/dashboard/user-layout-end.php';
    exit;
}

$instrument = plan_market_instrument($plan);
if ($instrument === null) {
    header('Location: /dashboard/user/investment-plans');
    exit;
}

$planDays = plan_duration_days($plan);
$riskBadge = plan_investment_risk_badge($plan['investment_risk']);
$periodReturn = format_plan_period_return($plan['yield_min'], $planDays);
$categoryLabel = plan_type_label($plan['plan_type']);
$liquidationFeeAttr = htmlspecialchars(number_format($plan['liquidation_cost'], 2, '.', ''), ENT_QUOTES, 'UTF-8');
$autoOpenInvest = isset($_GET['invest']) && $_GET['invest'] === '1';
$isCrypto = ($instrument['category'] ?? '') === 'crypto';
$coingeckoId = $instrument['coingecko_id'] ?? '';
$snapshot = $instrument['snapshot'] ?? [];
$marketTypeLabel = $snapshot['market_type'] ?? ucfirst($instrument['category'] ?? 'Market');
$heroIntro = $instrument['intro'] ?? $plan['description'];
$displayName = $instrument['name'] ?? $plan['name'];

$pageTitle = $siteName . ' | ' . $displayName;
$pageHeading = '';
$pageSubtitle = '';
$pageExtraStyles = <<<'CSS'
<script type="module" src="https://widgets.tradingview-widget.com/w/en/tv-mini-chart.js"></script>
<style>
.plan-market-hero {
  position: relative;
  overflow: hidden;
}
.plan-market-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(145deg, rgba(255, 195, 92, 0.08) 0%, transparent 55%);
  pointer-events: none;
}
.plan-market-hero > * { position: relative; z-index: 1; }
.plan-market-chart-wrap tv-mini-chart {
  display: block;
  width: 100% !important;
  max-width: 100%;
  min-height: 360px;
}
.pulse-live {
  animation: plan-pulse-live 1.5s ease-in-out infinite;
}
@keyframes plan-pulse-live {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.45; }
}
.market-chart-disclaimer { color: #6b7280; }
.dark .market-chart-disclaimer { color: #9ca3af; }
</style>
CSS;

require_once __DIR__ . '/../../includes/dashboard/user-layout-start.php';
?>

<div class="dash-page w-full min-w-0 space-y-6 md:space-y-8">
<!-- Hero: market identity first -->
<section class="plan-market-hero glass-panel rounded-xl p-6 md:p-8">
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
<div class="flex flex-wrap items-center gap-2">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-high border border-low text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">
<span class="material-symbols-outlined text-primary-container text-sm">candlestick_chart</span>
<?php echo htmlspecialchars($marketTypeLabel); ?>
</span>
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-500/10 border border-red-500/20 text-[10px] font-bold uppercase tracking-wider text-red-400">
<span class="w-2 h-2 bg-red-500 rounded-full pulse-live"></span> Live
</span>
<span class="<?php echo $riskBadge['class']; ?> px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"><?php echo htmlspecialchars($riskBadge['label']); ?></span>
<span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant bg-surface-container-high px-2 py-0.5 rounded"><?php echo htmlspecialchars($categoryLabel); ?></span>
</div>
<a href="/dashboard/user/investment-plans" class="inline-flex items-center gap-1.5 text-xs text-text-secondary hover:text-primary-container transition-colors shrink-0">
<span class="material-symbols-outlined text-sm">arrow_back</span> All plans
</a>
</div>
<h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-text-primary leading-tight mb-2"><?php echo htmlspecialchars($displayName); ?></h1>
<p class="text-lg font-semibold text-primary-container mb-3"><?php echo htmlspecialchars($instrument['pair_label']); ?></p>
<p class="text-sm md:text-base text-text-secondary max-w-3xl"><?php echo htmlspecialchars($heroIntro); ?></p>
</section>

<?php
$marketChartCompact = true;
require __DIR__ . '/../../includes/dashboard/market-live-chart-panel.php';
?>

<!-- Plan terms + invest -->
<div class="glass-panel rounded-xl p-5 md:p-6">
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-6">
<div class="min-w-0">
<h2 class="text-lg font-bold text-text-primary mb-1">Investment Plan</h2>
<p class="text-sm text-text-secondary"><?php echo htmlspecialchars($plan['description']); ?></p>
</div>
<button type="button"
  data-plan-id="<?php echo $plan['id']; ?>"
  data-plan-name="<?php echo htmlspecialchars($plan['name']); ?>"
  data-plan-min="<?php echo $plan['min_deposit']; ?>"
  data-plan-max="<?php echo $plan['max_deposit'] ?? 0; ?>"
  data-plan-days="<?php echo (int) $planDays; ?>"
  data-plan-liquidation-fee="<?php echo $liquidationFeeAttr; ?>"
  data-auto-open="<?php echo $autoOpenInvest ? '1' : '0'; ?>"
  class="subscribe-plan-btn w-full lg:w-auto shrink-0 bg-primary-container hover:bg-primary-container/90 text-on-primary font-bold py-3 px-8 rounded-xl transition-all flex items-center justify-center gap-2">
<span>Invest Now</span>
<span class="material-symbols-outlined text-sm">trending_up</span>
</button>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 pt-6 border-t border-low">
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Expected Return</p>
<p class="text-lg font-bold text-primary-container mt-1"><?php echo htmlspecialchars($periodReturn); ?></p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Min. Investment</p>
<p class="text-lg font-bold text-text-primary mt-1">USD <?php echo format_usd_amount($plan['min_deposit']); ?></p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Max. Investment</p>
<p class="text-lg font-bold text-text-primary mt-1"><?php echo $plan['max_deposit'] ? 'USD ' . format_usd_amount($plan['max_deposit']) : 'Unlimited'; ?></p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Duration</p>
<p class="text-lg font-bold text-text-primary mt-1"><?php echo (int) $planDays; ?> Days</p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Early Exit Fee</p>
<p class="text-lg font-bold <?php echo $plan['liquidation_cost'] > 0 ? 'text-amber-500' : 'text-text-primary'; ?> mt-1"><?php echo $plan['liquidation_cost'] > 0 ? 'USD ' . format_usd_amount($plan['liquidation_cost']) : 'None'; ?></p>
</div>
</div>
<?php if (!empty($plan['features']) && is_array($plan['features'])): ?>
<ul class="mt-6 pt-6 border-t border-low grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-text-secondary">
<?php foreach ($plan['features'] as $feature): ?>
<li class="flex items-center gap-2"><span class="material-symbols-outlined text-primary-container text-base">check_circle</span><?php echo htmlspecialchars((string) $feature); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>
</div>

<?php
require_once __DIR__ . '/../../includes/dashboard/user-layout-end.php';
require_once __DIR__ . '/../../includes/dashboard/subscribe-plan-modal.php';
require_once __DIR__ . '/../../includes/app-script.php';
require_once __DIR__ . '/../../includes/dashboard/subscribe-plan-script.php';
?>
<script src="/js/crypto-config.js"></script>
<script src="/js/crypto-prices.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
<?php if ($isCrypto && $coingeckoId): ?>
  if (window.BloombitCryptoPrices) {
    var coinId = <?php echo json_encode($coingeckoId); ?>;
    window.BloombitCryptoPrices.init([coinId], { refreshInterval: 120000 }).then(function(prices) {
      var header = document.querySelector('.crypto-detail-header');
      if (!header) return;
      var p = prices[coinId];
      var cfg = window.BloombitCryptoConfig || {};
      var logo = cfg.getLogo ? cfg.getLogo(coinId) : '';
      var img = header.querySelector('.crypto-logo');
      if (img && logo) { img.src = logo; img.alt = <?php echo json_encode($instrument['name']); ?>; }
      var priceEl = header.querySelector('.crypto-price');
      var changeEl = header.querySelector('.crypto-change');
      if (p && priceEl) priceEl.textContent = window.BloombitCryptoPrices.formatPrice(p.usd);
      if (p && changeEl && p.usd_24h_change != null) {
        changeEl.textContent = window.BloombitCryptoPrices.formatChange(p.usd_24h_change);
        changeEl.className = 'crypto-change font-data-mono text-sm ' + (p.usd_24h_change >= 0 ? 'text-success' : 'text-critical');
      }
    });
  }
<?php endif; ?>
});
</script>
</body></html>
