<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/market-instruments.php';
$siteName = get_site_name();
$pageTitle = $siteName . ' | Institutional Asset Management & Global Liquidity';
$statsAssets = get_site_setting('stats_assets', '$4.2B+');
$statsClients = get_site_setting('stats_bots', '120+');
$statsUptime = get_site_setting('stats_uptime', '99.9%');
$statsLiquidity = get_site_setting('stats_roi', '14+');

$execImg = '/uploads/images/evergren_cmarket.png';
$wealthImg = '/uploads/images/wallet_image3.png';
$heroBgImg = '/uploads/images/nasa-Q1p7bh3SHj8-unsplash.jpg';
$eduBeginner = 'https://lh3.googleusercontent.com/aida-public/AB6AXuClXum0n5B3Fys7n6VOV6KZhwxyShVM0LCSKgB8SowoEgxrXjNTakjFaTonTQVYfKAxjWY0GZbcHevK4tuOw6eXiW_-7bKuWD4lewm9wxl51RDLOHQa7vH3fDiQA6sUQeFVJvw9D8-CjyPJELlqVFFfRcZyL7MnmMiA9HA_An3Ae4jBpRn2BWE7G1Pk7VM_vdjw8YHZh7bO0EzfAj0XZ7tDSkBPaK_CKJXq6P_pa9rM1ALr5vlx69f4';
$eduIntermediate = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBAU594TAbyPKlG5KWutbMwCqXGdyxGubJNUFDO6FzVvF575dnmQkeOqmtDdTTaubPeTzJY1hR1B5vTbDoUaHWJJUe3iugxmlKGiko7VeZN03x2xTcUKkQdP1tEgbYiEt8BEVj3N4PCFw0s-sPyfeWTY3gbnQOYVLq7vV1mDxbmVgJhk_70tfiPXVKHzSxNrcWHBMC_9KjaBGAsAaAwJwMdyThozujO_EMfI6WHBxpaHgkN-_8YNJrX';
$eduAdvanced = 'https://lh3.googleusercontent.com/aida-public/AB6AXuC0RFiVG3wXTjeBaz-FYpuIcbtXW_-rbo6AcxjJgKfVR2jecI-nQ1lrSn8fWdmLi-t99OUPHZgN_NO7hSRwNbbteLmUbrMvWLAk42D9OO3H2H9QVmQ0JcGGuWnHZ99UJlAYT8_hUbJakBBvwWMCn7Ztlamrd-ccxL-ZB96l17wF8YLv9DLZsAiMDsyzLwfeAWPDNLwrkCdBcboSejRk3gMPOLOeI_1F0zlphMTW8IWVYb6VYvr-a3o2';

$orbitCoins = [];
try {
    $pdo = require __DIR__ . '/includes/db.php';
    $stmt = $pdo->query('SELECT symbol, logo FROM coins WHERE enabled = 1 AND logo IS NOT NULL AND logo != "" ORDER BY sort_order, id LIMIT 14');
    if ($stmt) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orbitCoins[] = $row;
        }
    }
} catch (Throwable $e) { /* fall through to defaults */ }
if (empty($orbitCoins)) {
    $orbitCoins = [
        ['symbol' => 'BTC', 'logo' => 'https://assets.coingecko.com/coins/images/1/large/bitcoin.png'],
        ['symbol' => 'ETH', 'logo' => 'https://assets.coingecko.com/coins/images/279/large/ethereum.png'],
        ['symbol' => 'USDT', 'logo' => 'https://assets.coingecko.com/coins/images/325/large/Tether.png'],
        ['symbol' => 'BNB', 'logo' => 'https://assets.coingecko.com/coins/images/825/large/bnb-icon2_2x.png'],
        ['symbol' => 'SOL', 'logo' => 'https://assets.coingecko.com/coins/images/4128/large/solana.png'],
        ['symbol' => 'XRP', 'logo' => 'https://assets.coingecko.com/coins/images/44/large/xrp-symbol-white-128.png'],
        ['symbol' => 'ADA', 'logo' => 'https://assets.coingecko.com/coins/images/975/large/cardano.png'],
        ['symbol' => 'DOGE', 'logo' => 'https://assets.coingecko.com/coins/images/5/large/dogecoin.png'],
        ['symbol' => 'DOT', 'logo' => 'https://assets.coingecko.com/coins/images/12171/large/polkadot.png'],
        ['symbol' => 'AVAX', 'logo' => 'https://assets.coingecko.com/coins/images/12559/large/Avalanche_Circle_RedWhite_Trans.png'],
        ['symbol' => 'LINK', 'logo' => 'https://assets.coingecko.com/coins/images/877/large/chainlink-new-logo.png'],
        ['symbol' => 'MATIC', 'logo' => 'https://assets.coingecko.com/coins/images/4713/large/polygon.png'],
        ['symbol' => 'LTC', 'logo' => 'https://assets.coingecko.com/coins/images/2/large/litecoin.png'],
        ['symbol' => 'UNI', 'logo' => 'https://assets.coingecko.com/coins/images/12504/large/uni.jpg'],
    ];
}
$orbitRing1 = array_slice($orbitCoins, 0, 6);
$orbitRing2 = array_slice($orbitCoins, 6, 4);
$orbitRing3 = array_slice($orbitCoins, 10, 4);

$partnerImages = [];
$partnerDir = __DIR__ . '/uploads/images/partner';
if (is_dir($partnerDir)) {
    $allowed = ['png', 'jpg', 'jpeg', 'webp', 'svg', 'gif'];
    $entries = scandir($partnerDir);
    if ($entries !== false) {
        foreach ($entries as $name) {
            if ($name === '.' || $name === '..') continue;
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed, true)) continue;
            $partnerImages[] = '/uploads/images/partner/' . $name;
        }
        natcasesort($partnerImages);
        $partnerImages = array_values($partnerImages);
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
<section class="relative min-h-[88vh] lg:min-h-screen w-full flex items-center justify-center overflow-hidden hero-section">
<div class="absolute inset-0 hero-bg" style="background-image: url('<?php echo htmlspecialchars($heroBgImg); ?>');"></div>
<div class="absolute inset-0 hero-bg-overlay"></div>
<div class="relative z-10 text-center max-w-5xl px-margin-mobile py-24 md:py-32">
<h1 class="hero-headline font-display-lg text-display-lg text-white mb-6 tracking-tight leading-[1.05] reveal-up">
Secure Capital. <br/> <span class="italic font-normal text-on-surface-variant">Intelligent Growth.</span>
</h1>
<p class="font-body-md md:font-body-lg text-on-surface-variant max-w-2xl mx-auto mb-8 md:mb-unit-xl reveal-up text-base md:text-lg">
<?php echo htmlspecialchars($siteName); ?> provides institutional-grade access to global markets. We leverage advanced technical precision and deep liquidity to preserve and grow sovereign and private capital.
</p>
<div class="flex flex-col sm:flex-row items-center justify-center gap-3 md:gap-unit-md reveal-up w-full max-w-md sm:max-w-none mx-auto">
<a href="/register" class="gradient-button w-full sm:w-auto px-6 py-3 md:px-10 md:py-4 rounded-full font-label-sm md:font-label-md text-label-sm md:text-label-md uppercase tracking-widest group inline-flex items-center justify-center gap-2 text-white">
Open an Account
<span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">arrow_forward</span>
</a>
<a href="/trading_signals" class="btn-secondary w-full sm:w-auto px-6 py-3 md:px-10 md:py-4 rounded-full font-label-sm md:font-label-md text-label-sm md:text-label-md uppercase tracking-widest text-on-surface-variant inline-flex items-center justify-center">
View Live Market
</a>
</div>
</div>
</section>

<!-- TradingView Ticker Tape -->
<section class="tv-ticker-strip w-full max-w-none border-y border-white/5 bg-surface-container-lowest/50 relative overflow-hidden">
<div class="absolute inset-x-0 top-0 h-10 bg-gradient-to-b from-background/40 to-transparent pointer-events-none z-[1]"></div>
<div class="tradingview-widget-container relative z-0 w-full">
<div class="tradingview-widget-container__widget"></div>
<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
{
  "symbols": [
    { "proName": "FOREXCOM:SPXUSD", "title": "S&P 500" },
    { "proName": "FOREXCOM:NSXUSD", "title": "US 100" },
    { "proName": "FOREXCOM:DJI", "title": "Dow 30" },
    { "proName": "FX:EURUSD", "title": "EUR/USD" },
    { "proName": "BITSTAMP:BTCUSD", "title": "BTC/USD" },
    { "proName": "BITSTAMP:ETHUSD", "title": "ETH/USD" },
    { "proName": "CMCMARKETS:GOLD", "title": "Gold" },
    { "proName": "CBOE:MAGS", "title": "MAGS" },
    { "proName": "NASDAQ:NVDA", "title": "NVDA" },
    { "proName": "NASDAQ:TSLA", "title": "TSLA" },
    { "proName": "NASDAQ:META", "title": "META" },
    { "proName": "NASDAQ:NFLX", "title": "NFLX" }
  ],
  "showSymbolLogo": true,
  "colorTheme": "dark",
  "isTransparent": true,
  "displayMode": "adaptive",
  "locale": "en"
}
</script>
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
<span class="material-symbols-outlined mb-4 text-3xl" style="color:#34d399">apartment</span>
<h3 class="font-headline-md text-white mb-2">Real Estate Brokerage</h3>
<p class="text-on-surface-variant text-sm">Direct access to prime commercial real estate and high-yield residential developments across European and Asian markets.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.05s">
<span class="material-symbols-outlined mb-4 text-3xl" style="color:#fbbf24">oil_barrel</span>
<h3 class="font-headline-md text-white mb-2">Oil &amp; Gas</h3>
<p class="text-on-surface-variant text-sm">Strategic investments in energy infrastructure and production, focusing on supply chain stability and long-term energy security.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.1s">
<span class="material-symbols-outlined mb-4 text-3xl" style="color:#f7931a">currency_bitcoin</span>
<h3 class="font-headline-md text-white mb-2">Cryptocurrency</h3>
<p class="text-on-surface-variant text-sm">Institutional-grade digital asset custody and algorithmic trading in major liquid tokens and emerging blockchain protocols.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.15s">
<span class="material-symbols-outlined mb-4 text-3xl" style="color:#60a5fa">trending_up</span>
<h3 class="font-headline-md text-white mb-2">Commercial Stocks</h3>
<p class="text-on-surface-variant text-sm">Active management of blue-chip equities and mid-cap growth stocks leveraging proprietary fundamental analysis.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.2s">
<span class="material-symbols-outlined mb-4 text-3xl" style="color:#a78bfa">account_balance</span>
<h3 class="font-headline-md text-white mb-2">Alternative Assets</h3>
<p class="text-on-surface-variant text-sm">Venture capital, private credit, and specialized commodities providing non-correlated returns for sophisticated portfolios.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.25s">
<span class="material-symbols-outlined mb-4 text-3xl" style="color:#2dd4bf">public</span>
<h3 class="font-headline-md text-white mb-2">Sovereign Bonds</h3>
<p class="text-on-surface-variant text-sm">Fixed income strategies focused on capital preservation through high-rated government and corporate debt instruments.</p>
</div>
</div>
</div>
</section>

<!-- Live Market Performance -->
<section id="markets" class="section-medium bg-surface-container-lowest/50 border-y border-white/5 relative">
<div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-background/50 to-transparent pointer-events-none"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative">
<div class="mb-12 reveal-up text-center md:text-left">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Market Monitor</span>
<h2 class="font-display-sm text-display-sm text-white">Live Market Performance</h2>
</div>

<div class="mb-10">
<h3 class="font-headline-md text-white mb-6">Cryptocurrency</h3>
<div class="market-slider" data-market-slider>
<div class="market-slider-track market-cards">
<?php foreach (get_markets_by_category('crypto') as $instrument): ?>
<div class="market-slider-slide">
<?php require __DIR__ . '/includes/market-home-card.php'; ?>
</div>
<?php endforeach; ?>
</div>
</div>
</div>

<div class="mb-10">
<h3 class="font-headline-md text-white mb-6">Stocks</h3>
<div class="market-slider" data-market-slider>
<div class="market-slider-track market-stocks">
<?php foreach (get_markets_by_category('stock') as $instrument): ?>
<div class="market-slider-slide">
<?php require __DIR__ . '/includes/market-home-card.php'; ?>
</div>
<?php endforeach; ?>
</div>
</div>
</div>

<div class="mb-12">
<h3 class="font-headline-md text-white mb-6">Forex</h3>
<div class="market-slider" data-market-slider>
<div class="market-slider-track market-forex">
<?php foreach (get_markets_by_category('forex') as $instrument): ?>
<div class="market-slider-slide">
<?php require __DIR__ . '/includes/market-home-card.php'; ?>
</div>
<?php endforeach; ?>
</div>
</div>
</div>

<div class="flex justify-center reveal-up">
<a href="/trading_signals" class="btn-secondary px-8 py-3 rounded-full font-label-sm text-label-sm uppercase tracking-widest inline-flex items-center justify-center">View All Markets</a>
</div>
</div>
</section>

<!-- AI Market Intelligence Orbit -->
<section class="section-large bg-surface border-y border-white/5 overflow-hidden relative">
<div class="absolute inset-0 refined-gradient pointer-events-none"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop text-center relative">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4 reveal-up">Intelligence Layer</span>
<h2 class="font-display-sm text-display-sm text-white mb-16 md:mb-20 reveal-up">AI Market Intelligence Orbit</h2>
<div class="relative flex items-center justify-center h-[340px] sm:h-[420px] md:h-[500px] reveal-up">
<div class="relative flex items-center justify-center scale-[0.68] sm:scale-[0.85] md:scale-100 origin-center">
<?php
$renderOrbitRing = function (array $coins, int $sizePx, string $spinClass, string $nodeClass, string $imgClass) {
    if (empty($coins)) return;
    $n = count($coins);
    echo '<div class="absolute border border-primary/20 rounded-full ' . $spinClass . '" style="width:' . $sizePx . 'px;height:' . $sizePx . 'px">';
    foreach ($coins as $i => $c) {
        $angle = 2 * M_PI * $i / $n - M_PI / 2;
        $x = 50 + 50 * cos($angle);
        $y = 50 + 50 * sin($angle);
        $logo = htmlspecialchars($c['logo'] ?? '');
        $sym = htmlspecialchars($c['symbol'] ?? '');
        echo '<span class="absolute ' . $nodeClass . ' rounded-full overflow-hidden bg-surface-container border-2 border-primary/30 shadow-lg flex items-center justify-center orbit-node" style="left:' . $x . '%;top:' . $y . '%;transform:translate(-50%,-50%)">';
        echo '<img src="' . $logo . '" alt="' . $sym . '" class="' . $imgClass . ' object-contain"/></span>';
    }
    echo '</div>';
};
$renderOrbitRing($orbitRing1, 450, 'orbit-spin-slow', 'w-10 h-10', 'w-7 h-7');
$renderOrbitRing($orbitRing2, 300, 'orbit-spin-mid-reverse', 'w-9 h-9', 'w-6 h-6');
$renderOrbitRing($orbitRing3, 150, 'orbit-spin-fast', 'w-8 h-8', 'w-5 h-5');
?>
<div class="relative z-10 w-32 h-32 sm:w-40 sm:h-40 bg-primary-container rounded-full flex items-center justify-center shadow-[0_0_60px_rgba(75,142,255,0.45)]">
<div class="text-on-primary-container text-center">
<div class="font-black leading-tight text-sm tracking-wide">AI CORE</div>
<div class="text-[10px] font-bold opacity-80 uppercase tracking-tighter mt-1">Intelligence<br/>Engine</div>
</div>
</div>
</div>
</div>
<p class="font-body-md text-on-surface-variant max-w-xl mx-auto mt-10 reveal-up">
<?php echo htmlspecialchars($siteName); ?> continuously monitors crypto, equities, and forex so your portfolio stays aligned with live market conditions — then turns those insights into clear next steps for your capital.
</p>
<div class="mt-8 reveal-up">
<a href="/register" class="gradient-button inline-flex items-center justify-center gap-2 px-8 py-3 rounded-full font-label-sm text-label-sm uppercase tracking-widest text-white">
Start Investing
<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</div>
</div>
</section>

<?php if (!empty($partnerImages)): ?>
<!-- Our Partners -->
<section class="section-medium border-y border-white/5 overflow-hidden relative">
<div class="section-photo-bg" style="background-image: url('/uploads/images/banner_bg.jpg');"></div>
<div class="section-photo-overlay"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
<div class="text-center mb-10 md:mb-12 reveal-up">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Trusted Network</span>
<h2 class="font-display-sm text-display-sm text-white">Our Partners</h2>
<p class="mt-4 font-body-md text-on-surface-variant max-w-2xl mx-auto">
We work alongside leading payment, custody, and market infrastructure partners to deliver secure, reliable access for <?php echo htmlspecialchars($siteName); ?> clients.
</p>
</div>
<div class="partner-slider reveal-up" data-partner-slider>
<div class="partner-slider-track">
<?php foreach ($partnerImages as $partnerSrc): ?>
<div class="partner-slider-slide">
<div class="partner-logo-wrap">
<img src="<?php echo htmlspecialchars($partnerSrc); ?>" alt="Partner" loading="lazy"/>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</section>
<?php endif; ?>

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
<a href="/live_chat" class="btn-secondary px-6 py-3 md:px-10 md:py-4 rounded-full font-label-sm md:font-label-md text-label-sm md:text-label-md uppercase tracking-widest text-white inline-flex items-center justify-center">Schedule Private Consultation</a>
</div>
</div>
</section>

<!-- Stats Wall -->
<section class="section-medium border-y border-white/5 relative">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-12">
<div class="text-center reveal-up">
<div class="stat-display font-display-lg text-3xl md:text-5xl lg:text-display-lg text-white mb-2 stat-counter" data-stat="<?php echo htmlspecialchars($statsAssets); ?>"><?php echo htmlspecialchars($statsAssets); ?></div>
<div class="font-label-sm text-[10px] md:text-label-sm text-on-surface-variant uppercase tracking-[0.15em] md:tracking-[0.2em]">Managed Assets</div>
</div>
<div class="text-center reveal-up" style="transition-delay:0.1s">
<div class="stat-display font-display-lg text-3xl md:text-5xl lg:text-display-lg text-white mb-2 stat-counter" data-stat="<?php echo htmlspecialchars($statsClients); ?>"><?php echo htmlspecialchars($statsClients); ?></div>
<div class="font-label-sm text-[10px] md:text-label-sm text-on-surface-variant uppercase tracking-[0.15em] md:tracking-[0.2em]">Institutional Clients</div>
</div>
<div class="text-center reveal-up" style="transition-delay:0.2s">
<div class="stat-display font-display-lg text-3xl md:text-5xl lg:text-display-lg text-white mb-2 stat-counter" data-stat="<?php echo htmlspecialchars($statsUptime); ?>"><?php echo htmlspecialchars($statsUptime); ?></div>
<div class="font-label-sm text-[10px] md:text-label-sm text-on-surface-variant uppercase tracking-[0.15em] md:tracking-[0.2em]">Platform Uptime</div>
</div>
<div class="text-center reveal-up" style="transition-delay:0.3s">
<div class="stat-display font-display-lg text-3xl md:text-5xl lg:text-display-lg text-white mb-2 stat-counter" data-stat="<?php echo htmlspecialchars($statsLiquidity); ?>"><?php echo htmlspecialchars($statsLiquidity); ?></div>
<div class="font-label-sm text-[10px] md:text-label-sm text-on-surface-variant uppercase tracking-[0.15em] md:tracking-[0.2em]">Liquidity Providers</div>
</div>
</div>
</section>

<!-- Learn and Earn -->
<section class="section-large relative">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 reveal-up">
<div>
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Education</span>
<h2 class="font-display-sm text-display-sm text-white">Learn and Earn</h2>
</div>
<a href="/help_centre" class="text-primary font-label-md uppercase tracking-widest inline-flex items-center gap-2 hover:gap-4 transition-all">
Explore Modules <span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-12">
<a href="/help_centre" class="group reveal-up">
<div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-6 institutional-border">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110 img-institutional" style="background-image: url('<?php echo htmlspecialchars($eduBeginner); ?>')"></div>
<div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors"></div>
<div class="absolute top-4 left-4 px-3 py-1 bg-primary text-on-primary font-label-sm text-[10px] uppercase rounded">Beginner</div>
</div>
<h3 class="font-headline-md text-white mb-3 group-hover:text-primary transition-colors">Fundamentals of Digital Assets</h3>
<p class="font-body-md text-on-surface-variant">Master the core concepts of blockchain technology and portfolio diversification.</p>
</a>
<a href="/help_centre" class="group reveal-up" style="transition-delay:0.1s">
<div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-6 institutional-border">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110 img-institutional" style="background-image: url('<?php echo htmlspecialchars($eduIntermediate); ?>')"></div>
<div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors"></div>
<div class="absolute top-4 left-4 px-3 py-1 bg-primary text-on-primary font-label-sm text-[10px] uppercase rounded">Intermediate</div>
</div>
<h3 class="font-headline-md text-white mb-3 group-hover:text-primary transition-colors">Advanced Technical Analysis</h3>
<p class="font-body-md text-on-surface-variant">Understand order flow, market depth, and institutional liquidity zones.</p>
</a>
<a href="/help_centre" class="group reveal-up" style="transition-delay:0.2s">
<div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-6 institutional-border">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110 img-institutional" style="background-image: url('<?php echo htmlspecialchars($eduAdvanced); ?>')"></div>
<div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors"></div>
<div class="absolute top-4 left-4 px-3 py-1 bg-primary text-on-primary font-label-sm text-[10px] uppercase rounded">Advanced</div>
</div>
<h3 class="font-headline-md text-white mb-3 group-hover:text-primary transition-colors">Algorithmic Strategies</h3>
<p class="font-body-md text-on-surface-variant">Learn to deploy automated trading approaches with institutional risk controls.</p>
</a>
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
<section class="section-large relative overflow-hidden">
<div class="section-photo-bg" style="background-image: url('/uploads/images/contact_bg.png'); opacity: 0.32;"></div>
<div class="section-photo-overlay"></div>
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[140px] pointer-events-none z-[1]"></div>
<div class="relative z-10 text-center px-margin-mobile reveal-up">
<h2 class="font-display-lg text-display-lg text-white mb-8 tracking-tight leading-none">Global Capital <br/><span class="italic font-normal text-on-surface-variant">Simplified.</span></h2>
<div class="flex flex-col items-center gap-6">
<a href="/register" class="gradient-button px-6 py-3 md:px-10 md:py-4 rounded-full font-label-sm md:font-label-md text-label-sm md:text-label-md uppercase tracking-widest inline-flex items-center justify-center text-white">
Get Started
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
    window.BloombitCryptoPrices.init(['bitcoin', 'ethereum', 'binancecoin', 'solana'], {
      marketCardsSelector: '.market-cards',
      refreshInterval: 120000
    });
  }

  // Mobile market carousels: peek next slide + auto-advance when in view
  (function initMarketSliders() {
    var mq = window.matchMedia('(max-width: 639px)');
    var sliders = Array.prototype.slice.call(document.querySelectorAll('[data-market-slider]'));
    if (!sliders.length) return;

    function setupSlider(root) {
      var track = root.querySelector('.market-slider-track');
      if (!track || root._marketSliderReady) return;
      root._marketSliderReady = true;
      var slides = Array.prototype.slice.call(track.querySelectorAll('.market-slider-slide'));
      if (slides.length < 2) return;
      var index = 0;
      var timer = null;
      var userPausedUntil = 0;

      function goTo(i) {
        if (!mq.matches) return;
        index = ((i % slides.length) + slides.length) % slides.length;
        var left = slides[index].offsetLeft;
        track.scrollTo({ left: left, behavior: 'smooth' });
      }

      function start() {
        stop();
        if (!mq.matches) return;
        timer = setInterval(function () {
          if (Date.now() < userPausedUntil) return;
          goTo(index + 1);
        }, 3200);
      }

      function stop() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      track.addEventListener('pointerdown', function () {
        userPausedUntil = Date.now() + 5000;
      }, { passive: true });
      track.addEventListener('scroll', function () {
        if (!mq.matches) return;
        var nearest = 0;
        var best = Infinity;
        var scrollLeft = track.scrollLeft;
        slides.forEach(function (slide, i) {
          var d = Math.abs(slide.offsetLeft - scrollLeft);
          if (d < best) { best = d; nearest = i; }
        });
        index = nearest;
      }, { passive: true });

      root._marketSliderStart = start;
      root._marketSliderStop = stop;
      root._marketSliderGo = goTo;
    }

    sliders.forEach(setupSlider);

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        var root = entry.target;
        if (entry.isIntersecting && mq.matches) {
          if (root._marketSliderStart) root._marketSliderStart();
        } else if (root._marketSliderStop) {
          root._marketSliderStop();
        }
      });
    }, { threshold: 0.35 });

    sliders.forEach(function (s) { io.observe(s); });
    mq.addEventListener('change', function () {
      sliders.forEach(function (s) {
        if (s._marketSliderStop) s._marketSliderStop();
        if (mq.matches && s._marketSliderStart) s._marketSliderStart();
      });
    });
  })();

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
  // Partner logo slider: 3 visible mobile / 5 desktop, auto-advance
  (function initPartnerSlider() {
    var root = document.querySelector('[data-partner-slider]');
    if (!root) return;
    var track = root.querySelector('.partner-slider-track');
    if (!track) return;
    var slides = Array.prototype.slice.call(track.querySelectorAll('.partner-slider-slide'));
    if (slides.length < 2) return;

    // Duplicate slides for seamless looping
    slides.forEach(function (slide) {
      track.appendChild(slide.cloneNode(true));
    });

    var index = 0;
    var timer = null;
    var animating = false;

    function visibleCount() {
      return window.matchMedia('(min-width: 768px)').matches ? 5 : 3;
    }

    function gapPx() {
      var styles = window.getComputedStyle(track);
      return parseFloat(styles.gap || styles.columnGap || '0') || 0;
    }

    function slideStep() {
      var first = track.querySelector('.partner-slider-slide');
      if (!first) return 0;
      return first.getBoundingClientRect().width + gapPx();
    }

    function goNext() {
      if (animating) return;
      animating = true;
      index += 1;
      track.style.transition = 'transform 0.55s ease';
      track.style.transform = 'translateX(' + (-index * slideStep()) + 'px)';
    }

    track.addEventListener('transitionend', function () {
      if (index >= slides.length) {
        track.style.transition = 'none';
        index = 0;
        track.style.transform = 'translateX(0)';
        track.offsetHeight; // reflow
      }
      animating = false;
    });

    function start() {
      stop();
      if (slides.length <= visibleCount()) return;
      timer = setInterval(goNext, 2800);
    }

    function stop() {
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    }

    window.addEventListener('resize', function () {
      track.style.transition = 'none';
      track.style.transform = 'translateX(' + (-index * slideStep()) + 'px)';
      start();
    });

    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);
    root.addEventListener('pointerdown', function () {
      stop();
      setTimeout(start, 4000);
    }, { passive: true });

    start();
  })();
});
</script>
</body>
</html>
