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
        'SELECT id, name, slug, plan_type, description, logo_url, investment_risk, tv_symbol, tv_embed, chart_pair_label,
                chart_market_type, chart_exchange, chart_hours, chart_volatility, chart_suitable_for,
                min_deposit, max_deposit,
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
            'tv_symbol' => trim((string) ($row['tv_symbol'] ?? '')),
            'tv_embed' => normalize_plan_tv_embed($row['tv_embed'] ?? null),
            'chart_pair_label' => trim((string) ($row['chart_pair_label'] ?? '')) ?: null,
            'chart_market_type' => trim((string) ($row['chart_market_type'] ?? '')) ?: null,
            'chart_exchange' => trim((string) ($row['chart_exchange'] ?? '')) ?: null,
            'chart_hours' => trim((string) ($row['chart_hours'] ?? '')) ?: null,
            'chart_volatility' => trim((string) ($row['chart_volatility'] ?? '')) ?: null,
            'chart_suitable_for' => trim((string) ($row['chart_suitable_for'] ?? '')) ?: null,
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
$planDays = plan_duration_days($plan);
$riskBadge = plan_investment_risk_badge($plan['investment_risk']);
$periodReturn = format_plan_period_return($plan['yield_min'], $planDays);
$categoryLabel = plan_type_label($plan['plan_type']);
$liquidationFeeAttr = htmlspecialchars(number_format($plan['liquidation_cost'], 2, '.', ''), ENT_QUOTES, 'UTF-8');
$autoOpenInvest = isset($_GET['invest']) && $_GET['invest'] === '1';
$isCrypto = ($instrument['category'] ?? '') === 'crypto';
$coingeckoId = $instrument['coingecko_id'] ?? '';
$snapshot = $instrument['snapshot'] ?? [];
$marketTypeLabel = $snapshot['market_type'] ?? plan_type_label($plan['plan_type']);
$heroIntro = $plan['description'] ?: '';
$displayName = plan_chart_display_name($plan);
$displayFeatures = plan_display_features($plan);

$pageTitle = $siteName . ' | ' . $displayName;
$pageHeading = '';
$pageSubtitle = '';
$pageExtraStyles = <<<'CSS'
<script type="module" src="https://widgets.tradingview-widget.com/w/en/tv-mini-chart.js"></script>
<style>
.plan-trading-page { margin-top: -0.25rem; }
.plan-trading-page .user-dash-content,
.plan-trading-page.dash-page {
  overflow: visible;
}
.plan-market-chart-wrap tv-mini-chart {
  display: block;
  width: 100% !important;
  max-width: 100%;
  height: 360px !important;
  min-height: 360px;
  margin-bottom: -32px;
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

<div class="dash-page plan-trading-page w-full min-w-0 space-y-6 md:space-y-8">
<?php
$marketChartLead = true;
$marketChartLeadTitle = $displayName;
$marketChartLeadPair = $instrument['pair_label'] ?? '';
$marketChartLeadType = $marketTypeLabel;
$marketChartBackUrl = '/dashboard/user/investment-plans';
require __DIR__ . '/../../includes/dashboard/market-live-chart-panel.php';
?>

<!-- Plan terms + invest -->
<div class="glass-panel rounded-xl p-5 md:p-6">
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-6">
<div class="min-w-0">
<h2 class="text-lg font-bold text-text-primary mb-1">Investment Plan</h2>
<p class="text-sm text-text-secondary"><?php echo htmlspecialchars($plan['description']); ?></p>
<?php if (!empty($heroIntro) && $heroIntro !== $plan['description']): ?>
<p class="text-xs text-on-surface-variant mt-2 leading-relaxed"><?php echo htmlspecialchars($heroIntro); ?></p>
<?php endif; ?>
<div class="flex flex-wrap items-center gap-2 mt-3">
<span class="<?php echo $riskBadge['class']; ?> px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"><?php echo htmlspecialchars($riskBadge['label']); ?></span>
<span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant bg-surface-container-high px-2 py-0.5 rounded"><?php echo htmlspecialchars($categoryLabel); ?></span>
</div>
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
<ul class="mt-6 pt-6 border-t border-low grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-text-secondary">
<?php foreach ($displayFeatures as $feature): ?>
<li class="flex items-center gap-2"><span class="material-symbols-outlined text-primary-container text-base">check_circle</span><?php echo htmlspecialchars((string) $feature); ?></li>
<?php endforeach; ?>
</ul>
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
