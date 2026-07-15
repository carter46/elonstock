<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/market-instruments.php';
$siteName = get_site_name();
$pageTitle = $siteName . ' | Institutional Asset Management & Global Liquidity';
$heroBadge = get_site_setting('hero_badge', 'Global Asset Intelligence V4.0');
$statsAssets = get_site_setting('stats_assets', '$4.2B+');
$statsClients = get_site_setting('stats_bots', '120+');
$statsUptime = get_site_setting('stats_uptime', '99.9%');
$statsLiquidity = get_site_setting('stats_roi', '14+');

$heroTerminalImg = '/uploads/images/evergren_cmarket.png';
$execImg = '/uploads/images/evergren_cmarket.png';
$wealthImg = '/uploads/images/wallet_image3.png';
$heroBgImg = '/uploads/images/nasa-Q1p7bh3SHj8-unsplash.jpg';

$featuredMarkets = [];
foreach (['crypto', 'stock', 'forex'] as $cat) {
    foreach (get_markets_by_category($cat) as $item) {
        $featuredMarkets[] = $item;
        if (count($featuredMarkets) >= 4) break 2;
    }
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require_once __DIR__ . '/includes/marketing-head.php'; ?>
</head>
<body class="marketing-page font-body-md selection:bg-primary selection:text-on-primary">
<?php $currentPage = 'home'; require_once __DIR__ . '/includes/marketing-header.php'; ?>

<main class="relative pt-20">

<!-- Hero -->
<section class="relative min-h-screen w-full flex items-center justify-center overflow-hidden refined-gradient">
<div class="absolute inset-0 hero-bg opacity-30 img-institutional" style="background-image: url('<?php echo htmlspecialchars($heroBgImg); ?>');"></div>
<div class="absolute inset-0 hero-bg-overlay"></div>
<div class="absolute inset-0 atmosphere-grid opacity-40 pointer-events-none"></div>
<div class="absolute inset-0 atmosphere-noise pointer-events-none"></div>
<div class="relative z-10 text-center max-w-5xl px-margin-mobile py-24 pb-56 md:pb-72">
<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 mb-unit-lg reveal-up">
<span class="glow-dot"></span>
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest"><?php echo htmlspecialchars($heroBadge); ?></span>
</div>
<h1 class="font-display-lg text-display-lg text-white mb-6 tracking-tight leading-[1.05] reveal-up">
Secure Capital. <br/> <span class="italic font-normal text-on-surface-variant">Intelligent Growth.</span>
</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-unit-xl reveal-up">
Strategic Wealth Management Limited provides institutional-grade access to global markets. We leverage advanced technical precision and deep liquidity to preserve and grow sovereign and private capital.
</p>
<div class="flex flex-col md:flex-row items-center justify-center gap-unit-md reveal-up">
<a href="/register" class="gradient-button px-10 py-5 rounded-full font-label-md text-label-md uppercase tracking-widest group inline-flex items-center gap-2 text-white">
Open Institutional Account
<span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">arrow_forward</span>
</a>
<a href="/plans" class="btn-secondary px-10 py-5 rounded-full font-label-md text-label-md uppercase tracking-widest text-on-surface-variant">
Investor Presentation
</a>
</div>
</div>
<div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full max-w-6xl px-margin-mobile md:px-margin-desktop opacity-60 z-10">
<div class="rounded-t-3xl border-t border-x border-white/10 overflow-hidden shadow-2xl">
<img alt="Institutional Terminal" class="w-full img-institutional" src="<?php echo htmlspecialchars($heroTerminalImg); ?>"/>
</div>
</div>
</section>

<!-- Live Execution Terminal -->
<section id="markets" class="section-medium bg-surface-container-lowest/50 border-y border-white/5 relative">
<div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-background/40 to-transparent pointer-events-none"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8 reveal-up">
<div>
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Market Monitor</span>
<h2 class="font-display-sm text-display-sm text-white">Live Execution Terminal</h2>
</div>
<a href="/trading_signals" class="btn-secondary px-8 py-3 rounded-full font-label-sm text-label-sm uppercase tracking-widest inline-flex items-center justify-center">View Full Market</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
<?php foreach ($featuredMarkets as $instrument): ?>
<?php require __DIR__ . '/includes/market-home-card.php'; ?>
<?php endforeach; ?>
</div>
</div>
</section>

<!-- Multi-Asset Global Exposure -->
<section id="portfolio" class="section-large bg-surface-container-lowest/50 border-y border-white/5 relative">
<div class="absolute inset-0 refined-gradient pointer-events-none"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
<div class="max-w-2xl reveal-up">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Core Portfolio Sectors</span>
<h2 class="font-display-sm text-display-sm text-white">Multi-Asset Global Exposure</h2>
<p class="mt-4 text-on-surface-variant font-body-md max-w-[42rem]"><?php echo htmlspecialchars($siteName); ?> manages a high-conviction portfolio spanning traditional and alternative asset classes, ensuring resilience through market cycles.</p>
</div>
<a href="/plans" class="btn-secondary px-8 py-3 rounded-full font-label-sm text-label-sm uppercase tracking-widest inline-flex items-center justify-center shrink-0">Sector Analysis</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<div class="trading-card p-8 reveal-up">
<span class="material-symbols-outlined text-primary mb-4 text-3xl">apartment</span>
<h3 class="font-headline-md text-white mb-2">Real Estate Brokerage</h3>
<p class="text-on-surface-variant text-sm">Direct access to prime commercial real estate and high-yield residential developments across European and Asian markets.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.05s">
<span class="material-symbols-outlined text-primary mb-4 text-3xl">oil_barrel</span>
<h3 class="font-headline-md text-white mb-2">Oil &amp; Gas</h3>
<p class="text-on-surface-variant text-sm">Strategic investments in energy infrastructure and production, focusing on supply chain stability and long-term energy security.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.1s">
<span class="material-symbols-outlined text-primary mb-4 text-3xl">currency_bitcoin</span>
<h3 class="font-headline-md text-white mb-2">Cryptocurrency</h3>
<p class="text-on-surface-variant text-sm">Institutional-grade digital asset custody and algorithmic trading in major liquid tokens and emerging blockchain protocols.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.15s">
<span class="material-symbols-outlined text-primary mb-4 text-3xl">trending_up</span>
<h3 class="font-headline-md text-white mb-2">Commercial Stocks</h3>
<p class="text-on-surface-variant text-sm">Active management of blue-chip equities and mid-cap growth stocks leveraging proprietary fundamental analysis.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.2s">
<span class="material-symbols-outlined text-primary mb-4 text-3xl">account_balance</span>
<h3 class="font-headline-md text-white mb-2">Alternative Assets</h3>
<p class="text-on-surface-variant text-sm">Venture capital, private credit, and specialized commodities providing non-correlated returns for sophisticated portfolios.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.25s">
<span class="material-symbols-outlined text-primary mb-4 text-3xl">public</span>
<h3 class="font-headline-md text-white mb-2">Sovereign Bonds</h3>
<p class="text-on-surface-variant text-sm">Fixed income strategies focused on capital preservation through high-rated government and corporate debt instruments.</p>
</div>
</div>
</div>
</section>

<!-- Authoritative Execution -->
<section class="section-large relative overflow-hidden">
<div class="absolute right-0 top-1/2 -translate-y-1/2 w-96 h-96 bg-primary/5 blur-[100px] rounded-full pointer-events-none"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
<div class="reveal-up">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Technical Standards</span>
<h2 class="font-display-sm text-display-sm text-white leading-tight mb-8">Authoritative Execution <br/>Infrastructure.</h2>
<div class="space-y-12">
<div class="flex gap-6">
<div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary">speed</span>
</div>
<div>
<h3 class="font-headline-md text-white mb-2">Low-Latency Order Routing</h3>
<p class="font-body-md text-on-surface-variant max-w-[42rem]">Utilizing Tier-1 connectivity through Equinix LD4, ensuring order execution with minimal slippage and maximum price efficiency.</p>
</div>
</div>
<div class="flex gap-6">
<div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary">analytics</span>
</div>
<div>
<h3 class="font-headline-md text-white mb-2">Quantitative Risk Modeling</h3>
<p class="font-body-md text-on-surface-variant max-w-[42rem]">Real-time exposure monitoring and Monte Carlo simulations integrated into every trade workflow for rigorous capital protection.</p>
</div>
</div>
<div class="flex gap-6">
<div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary">security</span>
</div>
<div>
<h3 class="font-headline-md text-white mb-2">Institutional Custody</h3>
<p class="font-body-md text-on-surface-variant max-w-[42rem]">Assets are secured in segregated, bankruptcy-remote accounts with multi-layered insurance and jurisdictional regulatory oversight.</p>
</div>
</div>
</div>
</div>
<div class="relative reveal-up">
<div class="relative rounded-3xl overflow-hidden institutional-border">
<img alt="Execution Terminal Dashboard" class="w-full img-institutional" src="<?php echo htmlspecialchars($execImg); ?>"/>
</div>
<div class="absolute -bottom-10 -right-10 w-48 h-48 bg-primary/10 blur-[60px] rounded-full pointer-events-none"></div>
</div>
</div>
</section>

<!-- Quantitative Engine -->
<section class="section-large bg-surface-container-low/30 relative">
<div class="absolute inset-0 atmosphere-grid opacity-20 pointer-events-none"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative">
<div class="text-center mb-24 reveal-up">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Quantitative Engine</span>
<h2 class="font-display-sm text-display-sm text-white">Technical Precision in Market Analysis</h2>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<div class="p-10 rounded-2xl bg-surface border border-white/5 reveal-up">
<div class="mb-8">
<span class="material-symbols-outlined text-primary text-4xl">psychology</span>
</div>
<h3 class="font-headline-md text-white mb-4">Sentiment Synthesis</h3>
<p class="font-body-md text-on-surface-variant mb-8 max-w-[42rem]">Aggregated data processing of institutional news cycles and macroeconomic signals to identify early-stage capital rotations.</p>
<div class="h-24 bg-white/5 rounded-lg overflow-hidden flex items-end px-2 gap-1">
<div class="flex-1 bg-primary/40 h-[20%] rounded-t-sm"></div>
<div class="flex-1 bg-primary/40 h-[45%] rounded-t-sm"></div>
<div class="flex-1 bg-primary h-[85%] rounded-t-sm"></div>
<div class="flex-1 bg-primary/60 h-[60%] rounded-t-sm"></div>
<div class="flex-1 bg-primary/40 h-[30%] rounded-t-sm"></div>
</div>
</div>
<div class="p-10 rounded-2xl bg-surface border border-white/5 reveal-up" style="transition-delay:0.1s">
<div class="mb-8">
<span class="material-symbols-outlined text-primary text-4xl">route</span>
</div>
<h3 class="font-headline-md text-white mb-4">Liquidity Aggregation</h3>
<p class="font-body-md text-on-surface-variant mb-8 max-w-[42rem]">Proprietary routing technology that sources liquidity from 14+ global providers, ensuring zero-impact entry for large-scale orders.</p>
<div class="flex flex-col gap-2">
<div class="h-1 bg-white/10 w-full rounded-full overflow-hidden">
<div class="h-full bg-primary w-4/5"></div>
</div>
<div class="flex justify-between text-[10px] text-on-surface-variant">
<span>EXECUTION EFFICIENCY</span>
<span>99.8%</span>
</div>
</div>
</div>
<div class="p-10 rounded-2xl bg-surface border border-white/5 reveal-up" style="transition-delay:0.2s">
<div class="mb-8">
<span class="material-symbols-outlined text-primary text-4xl">grid_view</span>
</div>
<h3 class="font-headline-md text-white mb-4">Risk Heatmaps</h3>
<p class="font-body-md text-on-surface-variant mb-8 max-w-[42rem]">Visual intelligence tools providing real-time data on sector volatility and correlation risks across the global portfolio.</p>
<div class="grid grid-cols-3 grid-rows-2 gap-1 h-24">
<div class="bg-green-500/20 rounded"></div>
<div class="bg-green-500/40 rounded"></div>
<div class="bg-red-500/10 rounded"></div>
<div class="bg-green-500/10 rounded"></div>
<div class="bg-red-500/30 rounded"></div>
<div class="bg-green-500/60 rounded"></div>
</div>
</div>
</div>
</div>
</section>

<!-- Bespoke Wealth -->
<section id="wealth" class="section-large relative">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
<div class="order-2 lg:order-1 relative reveal-up">
<img alt="Bespoke Wealth Management" class="w-full max-w-lg mx-auto img-institutional rounded-3xl institutional-border" src="<?php echo htmlspecialchars($wealthImg); ?>"/>
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primary/5 blur-[100px] rounded-full pointer-events-none"></div>
</div>
<div class="order-1 lg:order-2 reveal-up">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Private Client Advisory</span>
<h2 class="font-display-sm text-display-sm text-white leading-tight mb-8">Bespoke Wealth <br/>Management.</h2>
<div class="space-y-6 mb-12">
<div class="flex items-start gap-4 group">
<div class="w-6 h-6 rounded-full border border-primary/30 flex items-center justify-center shrink-0 group-hover:bg-primary/20 transition-all mt-1">
<span class="material-symbols-outlined text-[14px] text-primary">check</span>
</div>
<div>
<span class="font-body-lg text-white block">Tailored Portfolio Construction</span>
<p class="text-sm text-on-surface-variant mt-1 max-w-[42rem]">Custom investment mandates aligned with specific risk tolerances and multi-generational wealth objectives.</p>
</div>
</div>
<div class="flex items-start gap-4 group">
<div class="w-6 h-6 rounded-full border border-primary/30 flex items-center justify-center shrink-0 group-hover:bg-primary/20 transition-all mt-1">
<span class="material-symbols-outlined text-[14px] text-primary">check</span>
</div>
<div>
<span class="font-body-lg text-white block">Tax-Optimized Rebalancing</span>
<p class="text-sm text-on-surface-variant mt-1 max-w-[42rem]">Automated portfolio adjustments designed to capture market alpha while minimizing tax liabilities across global jurisdictions.</p>
</div>
</div>
<div class="flex items-start gap-4 group">
<div class="w-6 h-6 rounded-full border border-primary/30 flex items-center justify-center shrink-0 group-hover:bg-primary/20 transition-all mt-1">
<span class="material-symbols-outlined text-[14px] text-primary">check</span>
</div>
<div>
<span class="font-body-lg text-white block">Dedicated Relationship Directors</span>
<p class="text-sm text-on-surface-variant mt-1 max-w-[42rem]">Direct access to senior wealth consultants for strategic planning, estate management, and venture capital access.</p>
</div>
</div>
</div>
<p class="font-body-md text-on-surface-variant max-w-lg mb-10">
Our Bespoke Wealth Management division specializes in serving Ultra-High-Net-Worth Individuals and Family Offices, offering a level of discretion and strategic oversight synonymous with top-tier global private banks.
</p>
<a href="/live_chat" class="btn-secondary px-12 py-5 rounded-full font-label-md text-label-md uppercase tracking-widest text-white inline-flex items-center justify-center">Schedule Private Consultation</a>
</div>
</div>
</section>

<!-- Stats Wall -->
<section class="section-medium border-y border-white/5 relative">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-2 md:grid-cols-4 gap-12">
<div class="text-center reveal-up">
<div class="font-display-lg text-display-lg text-white mb-2 stat-counter" data-stat="<?php echo htmlspecialchars($statsAssets); ?>"><?php echo htmlspecialchars($statsAssets); ?></div>
<div class="font-label-sm text-on-surface-variant uppercase tracking-[0.2em]">Managed Assets</div>
</div>
<div class="text-center reveal-up" style="transition-delay:0.1s">
<div class="font-display-lg text-display-lg text-white mb-2 stat-counter" data-stat="<?php echo htmlspecialchars($statsClients); ?>"><?php echo htmlspecialchars($statsClients); ?></div>
<div class="font-label-sm text-on-surface-variant uppercase tracking-[0.2em]">Institutional Clients</div>
</div>
<div class="text-center reveal-up" style="transition-delay:0.2s">
<div class="font-display-lg text-display-lg text-white mb-2 stat-counter" data-stat="<?php echo htmlspecialchars($statsUptime); ?>"><?php echo htmlspecialchars($statsUptime); ?></div>
<div class="font-label-sm text-on-surface-variant uppercase tracking-[0.2em]">Platform Uptime</div>
</div>
<div class="text-center reveal-up" style="transition-delay:0.3s">
<div class="font-display-lg text-display-lg text-white mb-2 stat-counter" data-stat="<?php echo htmlspecialchars($statsLiquidity); ?>"><?php echo htmlspecialchars($statsLiquidity); ?></div>
<div class="font-label-sm text-on-surface-variant uppercase tracking-[0.2em]">Liquidity Providers</div>
</div>
</div>
</section>

<!-- Trust & Compliance -->
<section class="section-small bg-surface-container-lowest/50">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex flex-wrap justify-center items-center gap-16 opacity-40 grayscale hover:grayscale-0 transition-all duration-700 reveal-up">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-4xl">verified_user</span>
<div class="font-bold text-xl uppercase tracking-tighter">FINRA MEMBER</div>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-4xl">policy</span>
<div class="font-bold text-xl uppercase tracking-tighter">ISO 27001 SECURE</div>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-4xl">gavel</span>
<div class="font-bold text-xl uppercase tracking-tighter">SEC REGISTERED</div>
</div>
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-4xl">key</span>
<div class="font-bold text-xl uppercase tracking-tighter">MULTI-SIG VAULTS</div>
</div>
</div>
</div>
</section>

<!-- Immersive CTA -->
<section class="section-large relative overflow-hidden bg-background">
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[140px] pointer-events-none"></div>
<div class="relative z-10 text-center px-margin-mobile reveal-up">
<h2 class="font-display-lg text-display-lg text-white mb-unit-xl tracking-tight leading-none">Global Capital <br/><span class="italic font-normal text-on-surface-variant">Simplified.</span></h2>
<div class="flex flex-col items-center gap-8">
<a href="/register" class="gradient-button px-20 py-6 rounded-full font-headline-md text-headline-md uppercase tracking-widest inline-flex items-center justify-center text-white">
Begin Institutional Onboarding
</a>
<p class="font-body-md text-on-surface-variant max-w-xl mx-auto opacity-60">
Join an elite network of hedge funds, sovereign wealth managers, and private family offices who trust <?php echo htmlspecialchars($siteName); ?> for capital growth.
</p>
</div>
</div>
</section>

</main>

<?php require_once __DIR__ . '/includes/marketing-footer.php'; ?>
<script src="/js/crypto-config.js"></script>
<script src="/js/crypto-prices.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (window.BloombitCryptoPrices) {
    window.BloombitCryptoPrices.init('.crypto-market-card');
  }

  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
        if (entry.target.classList.contains('stat-counter') || entry.target.querySelector('.stat-counter')) {
          var el = entry.target.classList.contains('stat-counter') ? entry.target : entry.target.querySelector('.stat-counter');
          if (el && !el.dataset.animated) {
            el.dataset.animated = '1';
            animateStat(el);
          }
        }
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

  document.querySelectorAll('.reveal-up').forEach(function (el) { observer.observe(el); });

  function animateStat(el) {
    var raw = el.getAttribute('data-stat') || el.textContent.trim();
    var match = raw.match(/^([^0-9]*)([0-9]+(?:\.[0-9]+)?)(.*)$/);
    if (!match) return;
    var prefix = match[1];
    var num = parseFloat(match[2]);
    var suffix = match[3];
    var isFloat = match[2].indexOf('.') !== -1;
    var start = 0;
    var duration = 1200;
    var t0 = null;
    function frame(ts) {
      if (!t0) t0 = ts;
      var p = Math.min((ts - t0) / duration, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      var val = start + (num - start) * eased;
      el.textContent = prefix + (isFloat ? val.toFixed(1) : Math.round(val)) + suffix;
      if (p < 1) requestAnimationFrame(frame);
      else el.textContent = raw;
    }
    requestAnimationFrame(frame);
  }
});
</script>
</body>
</html>
