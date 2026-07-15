<?php
require_once __DIR__ . '/../../includes/auth-check.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/plan-types.php';
require_once __DIR__ . '/../../includes/usd-wallet.php';
require_once __DIR__ . '/../../includes/market-instruments.php';
require_once __DIR__ . '/../../includes/investment-lifecycle.php';

$currentPage = 'analytics';
$siteName = get_site_name();
$investmentId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($investmentId <= 0) {
    header('Location: /dashboard/user/analytics');
    exit;
}

$investment = null;
$plan = null;
$userBalance = 0.0;
$accruedEarnings = 0.0;

try {
    $pdo = require __DIR__ . '/../../includes/db.php';
    ensure_plan_schema($pdo);
    ensure_investment_lifecycle_schema($pdo);
    $userId = (int) $_SESSION['user_id'];
    $userBalance = get_user_spendable_usd_balance($pdo, $userId);

    $stmt = $pdo->prepare(
        'SELECT ui.id, ui.amount, ui.start_date, ui.created_at, ui.status,
                ui.duration_days AS investment_duration_days,
                p.id AS plan_id, p.name, p.slug, p.plan_type, p.description, p.logo_url,
                p.investment_risk, p.tv_embed, p.chart_pair_label,
                p.chart_market_type, p.chart_exchange, p.chart_hours, p.chart_volatility, p.chart_suitable_for,
                p.yield_min, p.yield_max, p.duration_days,
                p.min_duration_days, p.max_duration_days, p.min_duration_months, p.max_duration_months,
                p.withdrawal_days, p.liquidation_cost, p.features_json
         FROM user_investments ui
         INNER JOIN plans p ON p.id = ui.plan_id
         WHERE ui.id = ? AND ui.user_id = ? AND ui.status IN (\'active\', \'paused\')
         LIMIT 1'
    );
    $stmt->execute([$investmentId, $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $plan = [
            'id' => (int) $row['plan_id'],
            'name' => $row['name'],
            'slug' => $row['slug'],
            'plan_type' => normalize_plan_type($row['plan_type'] ?? 'crypto'),
            'description' => $row['description'] ?? '',
            'logo_url' => $row['logo_url'] ?? null,
            'investment_risk' => normalize_investment_risk($row['investment_risk'] ?? 'mid'),
            'tv_embed' => normalize_plan_tv_embed($row['tv_embed'] ?? null),
            'chart_pair_label' => trim((string) ($row['chart_pair_label'] ?? '')) ?: null,
            'chart_market_type' => trim((string) ($row['chart_market_type'] ?? '')) ?: null,
            'chart_exchange' => trim((string) ($row['chart_exchange'] ?? '')) ?: null,
            'chart_hours' => trim((string) ($row['chart_hours'] ?? '')) ?: null,
            'chart_volatility' => trim((string) ($row['chart_volatility'] ?? '')) ?: null,
            'chart_suitable_for' => trim((string) ($row['chart_suitable_for'] ?? '')) ?: null,
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
        $investment = [
            'id' => (int) $row['id'],
            'amount' => (float) $row['amount'],
            'start_date' => $row['start_date'] ?? $row['created_at'],
            'created_at' => $row['created_at'],
            'status' => strtolower($row['status'] ?? 'active'),
            'investment_duration_days' => (int) ($row['investment_duration_days'] ?? $row['duration_days']),
        ];
        $accruedEarnings = get_investment_accrued_payout_usd($pdo, $investmentId);
    }
} catch (Throwable $e) {
    $investment = null;
    $plan = null;
}

if (!$investment || !$plan) {
    http_response_code(404);
    $pageTitle = $siteName . ' | Position Not Found';
    $pageHeading = 'Position Not Found';
    $pageSubtitle = 'This active investment is unavailable or may have been settled.';
    require_once __DIR__ . '/../../includes/dashboard/user-layout-start.php';
    include __DIR__ . '/../../includes/dashboard/user-page-title.php';
    echo '<div class="dash-page w-full min-w-0"><div class="glass-panel rounded-xl p-8 text-center"><p class="text-text-secondary mb-6">We could not find that active plan.</p><a href="/dashboard/user/analytics" class="inline-flex items-center gap-2 bg-primary-container text-on-primary font-bold px-6 py-3 rounded-lg">Back to Portfolio</a></div></div>';
    require_once __DIR__ . '/../../includes/dashboard/user-layout-end.php';
    exit;
}

$instrument = plan_market_instrument($plan);

$durationDays = (int) $investment['investment_duration_days'];
$startDate = $investment['start_date'] ?? $investment['created_at'] ?? null;
$endTs = $startDate ? strtotime($startDate . ' + ' . $durationDays . ' days') : null;
$daysLeft = $endTs ? max(0, (int) ceil(($endTs - time()) / 86400)) : 0;
$daysElapsed = $startDate ? max(0, (int) floor((time() - strtotime($startDate)) / 86400)) : 0;

$planDays = plan_duration_days($plan);
$riskBadge = plan_investment_risk_badge($plan['investment_risk']);
$periodReturn = format_plan_period_return($plan['yield_min'], $durationDays);
$categoryLabel = plan_type_label($plan['plan_type']);
$liquidationFeeAttr = htmlspecialchars(number_format($plan['liquidation_cost'], 2, '.', ''), ENT_QUOTES, 'UTF-8');
$isPaused = $investment['status'] === 'paused';
$isCrypto = ($instrument['category'] ?? '') === 'crypto';
$coingeckoId = $instrument['coingecko_id'] ?? '';
$snapshot = $instrument['snapshot'] ?? [];
$marketTypeLabel = $snapshot['market_type'] ?? ucfirst($instrument['category'] ?? 'Market');
$heroIntro = $instrument['intro'] ?? $plan['description'];
$displayName = $instrument['name'] ?? $plan['name'];
$investedAmount = (float) $investment['amount'];

$pageTitle = $siteName . ' | ' . $displayName;
$pageHeading = '';
$pageSubtitle = '';
$pageExtraStyles = <<<'CSS'
<script type="module" src="https://widgets.tradingview-widget.com/w/en/tv-mini-chart.js"></script>
<style>
.plan-trading-page { margin-top: -0.25rem; }
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

<div class="dash-page plan-trading-page w-full min-w-0 space-y-6 md:space-y-8">
<?php
$marketChartLead = true;
$marketChartLeadTitle = $displayName;
$marketChartLeadPair = $instrument['pair_label'];
$marketChartLeadType = $marketTypeLabel;
$marketChartBackUrl = '/dashboard/user/analytics';
require __DIR__ . '/../../includes/dashboard/market-live-chart-panel.php';
?>

<!-- Active position + liquidate -->
<div class="glass-panel rounded-xl p-5 md:p-6">
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-6">
<div class="min-w-0">
<h2 class="text-lg font-bold text-text-primary mb-1">Your Active Plan</h2>
<p class="text-sm text-text-secondary"><?php echo htmlspecialchars($plan['name']); ?> — invested <?php echo htmlspecialchars(date('M j, Y', strtotime((string) $startDate))); ?></p>
<?php if (!empty($heroIntro)): ?>
<p class="text-xs text-on-surface-variant mt-2 leading-relaxed"><?php echo htmlspecialchars($heroIntro); ?></p>
<?php endif; ?>
<div class="flex flex-wrap items-center gap-2 mt-3">
<?php if ($isPaused): ?>
<span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-500/20 text-slate-500">Paused</span>
<?php else: ?>
<span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-primary/20 text-primary">Active</span>
<?php endif; ?>
<span class="<?php echo $riskBadge['class']; ?> px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"><?php echo htmlspecialchars($riskBadge['label']); ?></span>
<span class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant bg-surface-container-high px-2 py-0.5 rounded"><?php echo htmlspecialchars($categoryLabel); ?></span>
</div>
</div>
<button type="button"
  class="liquidate-plan-btn w-full lg:w-auto shrink-0 border border-amber-500/50 hover:bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold py-3 px-8 rounded-xl transition-all flex items-center justify-center gap-2"
  data-investment-id="<?php echo (int) $investment['id']; ?>"
  data-plan-name="<?php echo htmlspecialchars($plan['name'], ENT_QUOTES, 'UTF-8'); ?>"
  data-amount="<?php echo htmlspecialchars(number_format($investedAmount, 2, '.', ''), ENT_QUOTES, 'UTF-8'); ?>"
  data-fee="<?php echo $liquidationFeeAttr; ?>"
  data-balance="<?php echo htmlspecialchars(number_format($userBalance, 2, '.', ''), ENT_QUOTES, 'UTF-8'); ?>">
<span>Liquidate Plan</span>
<span class="material-symbols-outlined text-sm">logout</span>
</button>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 pt-6 border-t border-low">
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Invested</p>
<p class="text-lg font-bold text-text-primary mt-1">USD <?php echo format_usd_amount($investedAmount); ?></p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Expected Return</p>
<p class="text-lg font-bold text-primary-container mt-1"><?php echo htmlspecialchars($periodReturn); ?></p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Yield Range</p>
<p class="text-lg font-bold text-emerald-500 mt-1"><?php echo number_format($plan['yield_min'], 1); ?>–<?php echo number_format($plan['yield_max'], 1); ?>%</p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Days Left</p>
<p class="text-lg font-bold text-text-primary mt-1"><?php echo (int) $daysLeft; ?> Days</p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Accrued Earnings</p>
<p class="text-lg font-bold text-emerald-500 mt-1">USD <?php echo format_usd_amount($accruedEarnings); ?></p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Early Exit Fee</p>
<p class="text-lg font-bold <?php echo $plan['liquidation_cost'] > 0 ? 'text-amber-500' : 'text-text-primary'; ?> mt-1"><?php echo $plan['liquidation_cost'] > 0 ? 'USD ' . format_usd_amount($plan['liquidation_cost']) : 'None'; ?></p>
</div>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4 pt-4 border-t border-low">
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Duration</p>
<p class="text-base font-bold text-text-primary mt-1"><?php echo (int) $durationDays; ?> Days</p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Days Elapsed</p>
<p class="text-base font-bold text-text-primary mt-1"><?php echo (int) $daysElapsed; ?> Days</p>
</div>
<div>
<p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">Maturity Date</p>
<p class="text-base font-bold text-text-primary mt-1"><?php echo $endTs ? date('M j, Y', $endTs) : '—'; ?></p>
</div>
</div>
</div>
</div>

<?php require_once __DIR__ . '/../../includes/dashboard/user-layout-end.php'; ?>
<!-- Liquidate Plan Modal -->
<div id="liquidate-modal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true" aria-labelledby="liquidate-modal-title">
<div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="liquidate-modal-backdrop"></div>
<div class="absolute inset-0 flex items-center justify-center p-4 overflow-y-auto">
<div class="bg-white dark:bg-zinc-900 rounded-xl shadow-2xl w-full max-w-md border border-slate-200 dark:border-zinc-800 my-auto">
<div class="p-6 border-b border-slate-200 dark:border-zinc-800 flex items-center justify-between">
<h2 id="liquidate-modal-title" class="text-xl font-bold">Liquidate Plan</h2>
<button type="button" id="liquidate-modal-close" class="p-2 hover:bg-slate-100 dark:hover:bg-zinc-800 rounded-full" aria-label="Close"><span class="material-symbols-outlined">close</span></button>
</div>
<div class="p-6">
<div class="mb-4 p-4 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50">
<p class="text-sm text-amber-800 dark:text-amber-200 font-semibold flex items-start gap-2">
<span class="material-symbols-outlined text-lg shrink-0">warning</span>
<span>Early liquidation attracts an operation fee, which will be deducted from your USD balance.</span>
</p>
</div>
<p class="text-sm text-slate-600 dark:text-slate-400 mb-4">You are about to liquidate <strong id="liquidate-plan-name" class="text-slate-900 dark:text-white"></strong> (<span id="liquidate-plan-amount"></span> principal).</p>
<div class="grid grid-cols-2 gap-4 mb-4 text-sm">
<div class="p-3 rounded-lg bg-slate-50 dark:bg-zinc-800">
<p class="text-xs text-slate-400 uppercase font-bold mb-1">Operation Fee</p>
<p class="font-bold text-amber-600 dark:text-amber-400" id="liquidate-fee-display">$0.00</p>
</div>
<div class="p-3 rounded-lg bg-slate-50 dark:bg-zinc-800">
<p class="text-xs text-slate-400 uppercase font-bold mb-1">Your USD Balance</p>
<p class="font-bold" id="liquidate-balance-display">$0.00</p>
</div>
</div>
<p id="liquidate-balance-note" class="text-sm mb-4"></p>
<div id="liquidate-error" class="text-sm text-red-500 hidden mb-4"></div>
<input type="hidden" id="liquidate-investment-id" value=""/>
<div class="flex gap-3">
<button type="button" id="liquidate-cancel-btn" class="flex-1 px-4 py-2 bg-slate-100 dark:bg-zinc-800 text-slate-700 dark:text-slate-300 font-bold rounded-lg">Cancel</button>
<button type="button" id="liquidate-confirm-btn" class="flex-1 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">Confirm Liquidation</button>
</div>
</div>
</div>
</div>
</div>
<?php require_once __DIR__ . '/../../includes/app-script.php'; ?>
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

  var liqModal = document.getElementById('liquidate-modal');
  var liqBackdrop = document.getElementById('liquidate-modal-backdrop');
  var liqClose = document.getElementById('liquidate-modal-close');
  var liqCancel = document.getElementById('liquidate-cancel-btn');
  var liqConfirm = document.getElementById('liquidate-confirm-btn');
  var liqError = document.getElementById('liquidate-error');
  var liqBalanceNote = document.getElementById('liquidate-balance-note');
  var liqBalanceDisplay = document.getElementById('liquidate-balance-display');
  var liqInvId = document.getElementById('liquidate-investment-id');

  function closeLiquidateModal() {
    if (liqModal) liqModal.classList.add('hidden');
    document.body.style.overflow = '';
    if (liqError) { liqError.classList.add('hidden'); liqError.textContent = ''; }
    if (liqConfirm) liqConfirm.textContent = 'Confirm Liquidation';
  }

  function openLiquidateModal(btn) {
    if (!liqModal || !btn) return;
    var fee = parseFloat(btn.getAttribute('data-fee') || '0') || 0;
    var balance = parseFloat(btn.getAttribute('data-balance') || '0') || 0;
    var canAfford = balance + 0.000001 >= fee;
    var planNameEl = document.getElementById('liquidate-plan-name');
    var planAmountEl = document.getElementById('liquidate-plan-amount');
    var feeDisplayEl = document.getElementById('liquidate-fee-display');

    if (planNameEl) planNameEl.textContent = btn.getAttribute('data-plan-name') || 'Plan';
    if (planAmountEl) planAmountEl.textContent = '$' + (parseFloat(btn.getAttribute('data-amount') || '0') || 0).toFixed(2);
    if (feeDisplayEl) feeDisplayEl.textContent = '$' + fee.toFixed(2);

    if (liqBalanceDisplay) {
      liqBalanceDisplay.textContent = '$' + balance.toFixed(2);
      liqBalanceDisplay.classList.remove('text-emerald-500', 'text-red-500');
      liqBalanceDisplay.classList.add(canAfford ? 'text-emerald-500' : 'text-red-500');
    }
    if (liqBalanceNote) {
      liqBalanceNote.classList.remove('text-emerald-600', 'text-red-500', 'hidden');
      if (canAfford) {
        liqBalanceNote.textContent = 'Your balance is enough to implement the liquidation.';
        liqBalanceNote.classList.add('text-emerald-600');
      } else {
        liqBalanceNote.textContent = 'Insufficient balance for the operation fee. Deposit funds to your wallet to continue.';
        liqBalanceNote.classList.add('text-red-500');
      }
    }
    if (liqConfirm) {
      liqConfirm.disabled = !canAfford;
      liqConfirm.textContent = 'Confirm Liquidation';
    }
    if (liqError) {
      liqError.classList.add('hidden');
      liqError.textContent = '';
    }
    if (liqInvId) liqInvId.value = btn.getAttribute('data-investment-id') || '';

    liqModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  document.addEventListener('click', function(e) {
    var btn = e.target.closest('.liquidate-plan-btn');
    if (btn) {
      e.preventDefault();
      openLiquidateModal(btn);
    }
  });
  [liqBackdrop, liqClose, liqCancel].forEach(function(el) {
    if (el) el.addEventListener('click', closeLiquidateModal);
  });

  if (liqConfirm) {
    liqConfirm.addEventListener('click', function() {
      var invId = liqInvId ? parseInt(liqInvId.value, 10) : 0;
      if (!invId) return;
      liqConfirm.disabled = true;
      liqConfirm.textContent = 'Processing…';
      if (liqError) { liqError.classList.add('hidden'); liqError.textContent = ''; }
      fetch('/api/user/liquidate-plan.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ investment_id: invId })
      }).then(function(r) { return r.json(); }).then(function(res) {
        if (res.success) {
          window.location.href = '/dashboard/user/analytics';
          return;
        }
        if (liqError) {
          liqError.textContent = res.error || 'Liquidation failed';
          liqError.classList.remove('hidden');
        }
        liqConfirm.disabled = false;
        liqConfirm.textContent = 'Confirm Liquidation';
      }).catch(function() {
        if (liqError) {
          liqError.textContent = 'Request failed. Please try again.';
          liqError.classList.remove('hidden');
        }
        liqConfirm.disabled = false;
        liqConfirm.textContent = 'Confirm Liquidation';
      });
    });
  }
});
</script>
</body></html>
