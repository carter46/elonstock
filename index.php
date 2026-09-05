<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/market-instruments.php';
require_once __DIR__ . '/includes/plan-types.php';
$siteName = get_site_name();
$pageTitle = $siteName . ' | Multi-Asset Investment Platform';
$pageDescription = 'Invest across stocks, equities, and real estate with intelligent auto trading and institutional-grade portfolio management.';
$ogTitle = $siteName . ' | Multi-Asset Investment Platform';
$ogDescription = $pageDescription;
$statsAssets = get_site_setting('stats_assets', '$4.2B+');
$statsClients = get_site_setting('stats_bots', '120+');
$statsUptime = get_site_setting('stats_uptime', '99.9%');
$statsLiquidity = get_site_setting('stats_roi', '14+');

$homePlans = [];
try {
    $pdo = require __DIR__ . '/includes/db.php';
    ensure_plan_schema($pdo);
    $stmt = $pdo->query('SELECT id, name, slug, plan_type, description, logo_url, min_deposit, max_deposit, yield_min, yield_max, withdrawal_days, features_json FROM plans WHERE enabled = 1 ORDER BY sort_order, id');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row['features'] = $row['features_json'] ? json_decode($row['features_json'], true) : [];
        if (!is_array($row['features'])) $row['features'] = [];
        $row['plan_type'] = normalize_plan_type($row['plan_type'] ?? 'crypto');
        $homePlans[] = $row;
    }
} catch (Throwable $e) {
    $homePlans = [];
}
$homePlansPreview = array_slice($homePlans, 0, 3);

$heroSlides = [
    '/uploads/images/Business-Endeavors-03.jpg',
    '/uploads/images/psace_xx.jpg',
    '/uploads/images/fleets_tuk.webp',
    '/uploads/images/msjd_spadd.jpg',
];
$eduBeginner = 'https://lh3.googleusercontent.com/aida-public/AB6AXuClXum0n5B3Fys7n6VOV6KZhwxyShVM0LCSKgB8SowoEgxrXjNTakjFaTonTQVYfKAxjWY0GZbcHevK4tuOw6eXiW_-7bKuWD4lewm9wxl51RDLOHQa7vH3fDiQA6sUQeFVJvw9D8-CjyPJELlqVFFfRcZyL7MnmMiA9HA_An3Ae4jBpRn2BWE7G1Pk7VM_vdjw8YHZh7bO0EzfAj0XZ7tDSkBPaK_CKJXq6P_pa9rM1ALr5vlx69f4';
$eduIntermediate = 'https://lh3.googleusercontent.com/aida-public/AB6AXuBAU594TAbyPKlG5KWutbMwCqXGdyxGubJNUFDO6FzVvF575dnmQkeOqmtDdTTaubPeTzJY1hR1B5vTbDoUaHWJJUe3iugxmlKGiko7VeZN03x2xTcUKkQdP1tEgbYiEt8BEVj3N4PCFw0s-sPyfeWTY3gbnQOYVLq7vV1mDxbmVgJhk_70tfiPXVKHzSxNrcWHBMC_9KjaBGAsAaAwJwMdyThozujO_EMfI6WHBxpaHgkN-_8YNJrX';
$eduAdvanced = 'https://lh3.googleusercontent.com/aida-public/AB6AXuC0RFiVG3wXTjeBaz-FYpuIcbtXW_-rbo6AcxjJgKfVR2jecI-nQ1lrSn8fWdmLi-t99OUPHZgN_NO7hSRwNbbteLmUbrMvWLAk42D9OO3H2H9QVmQ0JcGGuWnHZ99UJlAYT8_hUbJakBBvwWMCn7Ztlamrd-ccxL-ZB96l17wF8YLv9DLZsAiMDsyzLwfeAWPDNLwrkCdBcboSejRk3gMPOLOeI_1F0zlphMTW8IWVYb6VYvr-a3o2';

$orbitLogoPool = [
    ['symbol' => 'TSLA', 'logo' => '/uploads/images/tesla.png'],
    ['symbol' => 'SPCX', 'logo' => '/uploads/images/spacex.png'],
    ['symbol' => 'GOOGL', 'logo' => '/uploads/images/Alphabet.png'],
    ['symbol' => 'NRLK', 'logo' => '/uploads/images/Neuralink.png'],
];
$orbitCoins = [];
for ($i = 0; $i < 14; $i++) {
    $orbitCoins[] = $orbitLogoPool[$i % count($orbitLogoPool)];
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
<section class="relative min-h-[88vh] lg:min-h-screen w-full flex items-center justify-center overflow-hidden hero-section" data-hero-slider>
<?php foreach ($heroSlides as $i => $slideSrc): ?>
<div class="absolute inset-0 hero-bg hero-slide<?php echo $i === 0 ? ' is-active' : ''; ?>" style="background-image: url('<?php echo htmlspecialchars($slideSrc); ?>');"></div>
<?php endforeach; ?>
<div class="absolute inset-0 hero-bg-overlay"></div>
<div class="relative z-10 text-center max-w-5xl px-margin-mobile py-24 md:py-32">
<h1 class="hero-headline font-display-lg text-display-lg text-white mb-6 tracking-tight leading-[1.05] reveal-up">
Secure Capital. <br/> <span class="italic font-normal hero-orange-gradient">Intelligent Growth.</span>
</h1>
<p class="font-body-md md:font-body-lg text-on-surface-variant max-w-2xl mx-auto mb-8 md:mb-unit-xl reveal-up text-base md:text-lg">
<?php echo htmlspecialchars($siteName); ?> provides professional access to stocks, equities, real estate investment, and automated trading.
</p>
<div class="flex flex-col sm:flex-row items-center justify-center gap-3 md:gap-unit-md reveal-up w-full max-w-md sm:max-w-none mx-auto">
<a href="/register" class="gradient-button w-full sm:w-auto px-6 py-3 md:px-10 md:py-4 rounded-full font-label-sm md:font-label-md text-label-sm md:text-label-md uppercase tracking-widest group inline-flex items-center justify-center gap-2 text-white">
Open an Account
<span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">arrow_forward</span>
</a>
<a href="/login" class="btn-secondary w-full sm:w-auto px-6 py-3 md:px-10 md:py-4 rounded-full font-label-sm md:font-label-md text-label-sm md:text-label-md uppercase tracking-widest text-on-surface-variant inline-flex items-center justify-center">
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
<img src="/uploads/images/tesla.png" alt="Tesla" class="w-12 h-12 object-contain mb-4 rounded-lg"/>
<h3 class="font-headline-md text-white mb-2">Tesla, Inc. ($TSLA)</h3>
<ul class="text-on-surface-variant text-sm space-y-1.5 list-disc list-inside">
<li>Electric Vehicles (EVs)</li>
<li>Tesla Energy (Solar/Megapack)</li>
<li>Optimus Humanoid Robotics</li>
<li>Full Self-Driving (FSD) AI</li>
</ul>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.05s">
<img src="/uploads/images/spacex.png" alt="SpaceX" class="w-12 h-12 object-contain mb-4 rounded-lg"/>
<h3 class="font-headline-md text-white mb-2">SpaceX ($SPCX)</h3>
<ul class="text-on-surface-variant text-sm space-y-1.5 list-disc list-inside">
<li>Rocket Launch (Falcon 9 / Starship)</li>
<li>Starlink Satellite Internet</li>
<li>SpaceXAI (Grok AI)</li>
<li>X Corp. (formerly Twitter)</li>
</ul>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.1s">
<img src="/uploads/images/Neuralink.png" alt="Neuralink" class="w-12 h-12 object-contain mb-4 rounded-lg"/>
<h3 class="font-headline-md text-white mb-2">Neuralink</h3>
<p class="text-on-surface-variant text-sm">Musk's brain-computer interface venture. While achieving massive milestones with human implants, it is funded entirely through private venture capital.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.15s">
<span class="material-symbols-outlined mb-4 text-3xl" style="color:#60a5fa">candlestick_chart</span>
<h3 class="font-headline-md text-white mb-2">Equities &amp; Auto Trading</h3>
<p class="text-on-surface-variant text-sm">Automated trading strategies across listed equities and commercial stocks, built to pursue consistent daily growth without constant manual oversight.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.2s">
<img src="/uploads/images/Alphabet.png" alt="Alphabet" class="w-12 h-12 object-contain mb-4 rounded-lg"/>
<h3 class="font-headline-md text-white mb-2">Alphabet Inc.</h3>
<p class="text-on-surface-variant text-sm">Alphabet Inc. is an American multinational technology conglomerate and the parent holding company of Google.</p>
</div>
<div class="trading-card p-8 reveal-up" style="transition-delay:0.25s">
<span class="material-symbols-outlined mb-4 text-3xl" style="color:#a78bfa">account_balance</span>
<h3 class="font-headline-md text-white mb-2">Alternative Assets</h3>
<p class="text-on-surface-variant text-sm">Venture capital, private credit, and specialized commodities providing non-correlated returns for sophisticated portfolios.</p>
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
<h3 class="font-headline-md text-white mb-6">Stocks &amp; Equities</h3>
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
</div>
</section>

<?php if (!empty($homePlansPreview)): ?>
<!-- Investment Plans -->
<section id="investment-plans" class="section-large bg-surface border-y border-white/5 relative">
<div class="absolute inset-0 refined-gradient pointer-events-none"></div>
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative">
<div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 md:mb-16 gap-6">
<div class="max-w-2xl reveal-up">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Investment Plans</span>
<h2 class="font-display-sm text-display-sm text-white">Choose Your Plan</h2>
<p class="mt-4 text-on-surface-variant font-body-md max-w-[42rem]">Select a plan to open it in your dashboard and invest with your account balance. Your selection is kept when you sign in.</p>
</div>
<a href="/dashboard/user/investment-plans" class="btn-secondary px-8 py-3 rounded-full font-label-sm text-label-sm uppercase tracking-widest inline-flex items-center justify-center shrink-0">View All</a>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-6">
<?php
$homePlanIndex = 0;
$homePlansCount = count($homePlansPreview);
foreach ($homePlansPreview as $plan):
    $isHighlight = ($homePlanIndex === 1 && $homePlansCount >= 2);
    $homePlanIndex++;
    $minFmt = format_usd_amount($plan['min_deposit']);
    $maxFmt = !empty($plan['max_deposit']) ? format_usd_amount($plan['max_deposit']) : null;
    $rangeStr = $maxFmt ? '$' . $minFmt . ' – $' . $maxFmt : 'From $' . $minFmt;
    $planSlug = trim((string) ($plan['slug'] ?? ''));
    if ($planSlug === '') continue;
    $planUrl = '/dashboard/user/investment-plans/' . rawurlencode($planSlug);
    $features = array_values(array_filter(array_map(static function ($f) {
        return trim((string) $f);
    }, $plan['features'] ?? [])));
    $features = array_slice($features, 0, 4);
    $desc = trim((string) ($plan['description'] ?? ''));
?>
<a href="<?php echo htmlspecialchars($planUrl); ?>" class="trading-card p-6 md:p-8 flex flex-col h-full reveal-up group transition-all hover:border-primary-container/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/50 <?php echo $isHighlight ? 'border-primary-container/40 relative' : ''; ?>" style="transition-delay:<?php echo number_format(($homePlanIndex - 1) * 0.05, 2); ?>s">
<?php if ($isHighlight): ?>
<span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary-container text-on-primary text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full whitespace-nowrap">Most Popular</span>
<?php endif; ?>
<div class="flex items-start gap-3 mb-5">
<?php echo plan_logo_markup($plan['logo_url'] ?? null, $plan['name'], 'w-11 h-11', 'text-sm'); ?>
<div class="min-w-0 flex-1">
<span class="text-[10px] font-bold uppercase tracking-wider text-primary-container"><?php echo htmlspecialchars(plan_type_label($plan['plan_type'] ?? 'crypto')); ?></span>
<h3 class="text-lg md:text-xl font-bold text-white leading-snug mt-0.5 group-hover:text-primary transition-colors"><?php echo htmlspecialchars($plan['name']); ?></h3>
</div>
</div>
<?php if ($desc !== ''): ?>
<p class="text-on-surface-variant text-sm mb-5 line-clamp-2"><?php echo htmlspecialchars($desc); ?></p>
<?php endif; ?>
<div class="mb-5">
<div class="text-3xl md:text-4xl font-bold <?php echo $isHighlight ? 'text-primary-container' : 'text-white'; ?>"><?php echo number_format((float) ($plan['yield_min'] ?? 0), 1); ?><?php if ((float) ($plan['yield_max'] ?? 0) > (float) ($plan['yield_min'] ?? 0)): ?>–<?php echo number_format((float) $plan['yield_max'], 1); ?><?php endif; ?>%</div>
<div class="text-sm font-medium text-on-surface-variant mt-1">Daily ROI</div>
<p class="text-xs text-on-surface-variant mt-2"><?php echo htmlspecialchars($rangeStr); ?></p>
</div>
<?php if (!empty($features)): ?>
<ul class="space-y-2.5 mb-6 flex-grow">
<?php foreach ($features as $f): ?>
<li class="flex items-start gap-2.5 text-sm text-on-surface-variant">
<span class="material-symbols-outlined text-primary-container text-base shrink-0 mt-0.5">check_circle</span>
<span class="leading-snug"><?php echo htmlspecialchars($f); ?></span>
</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<div class="flex-grow"></div>
<?php endif; ?>
<span class="w-full py-3.5 <?php echo $isHighlight ? 'gradient-button' : 'btn-secondary'; ?> font-bold text-center inline-flex items-center justify-center gap-2 mt-auto group-hover:brightness-110">
Select Plan
<span class="material-symbols-outlined text-base transition-transform group-hover:translate-x-0.5">arrow_forward</span>
</span>
</a>
<?php endforeach; ?>
</div>
<?php if (count($homePlans) > 3): ?>
<div class="mt-10 flex justify-center reveal-up">
<a href="/dashboard/user/investment-plans" class="btn-secondary px-8 py-3 rounded-full font-label-sm text-label-sm uppercase tracking-widest inline-flex items-center justify-center gap-2">
View All
<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</div>
<?php endif; ?>
</div>
</section>
<?php endif; ?>

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
<?php echo htmlspecialchars($siteName); ?> continuously monitors equities, stocks, and global market conditions so your portfolio stays aligned — then turns those insights into clear next steps for your capital.
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
<div class="partner-slider reveal-up" data-partner-slider aria-hidden="false">
<div class="partner-slider-track">
<?php
// Two identical sets → CSS marquee loops seamlessly (translateX -50%).
foreach ([$partnerImages, $partnerImages] as $partnerSet):
    foreach ($partnerSet as $partnerSrc):
?>
<div class="partner-slider-slide">
<div class="partner-logo-wrap">
<img src="<?php echo htmlspecialchars($partnerSrc); ?>" alt="" loading="lazy" decoding="async"/>
</div>
</div>
<?php
    endforeach;
endforeach;
?>
</div>
</div>
</div>
</section>
<?php endif; ?>

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

<!-- Our Team & Management -->
<section class="section-large relative">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<div class="mb-16 reveal-up">
<span class="font-label-sm text-primary uppercase tracking-[0.4em] block mb-4">Leadership</span>
<h2 class="font-display-sm text-display-sm text-white">Our Team &amp; Management</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-12">
<div class="group reveal-up">
<div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-6 institutional-border">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110 img-institutional" style="background-image: url('<?php echo htmlspecialchars($eduBeginner); ?>')"></div>
<div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors"></div>
<div class="absolute top-4 left-4 px-3 py-1 bg-primary text-on-primary font-label-sm text-[10px] uppercase rounded">Chief Executive Officer</div>
</div>
<h3 class="font-headline-md text-white mb-3">Marcus Hale</h3>
<p class="font-body-md text-on-surface-variant">Leads overall strategy and capital growth initiatives across the platform.</p>
</div>
<div class="group reveal-up" style="transition-delay:0.1s">
<div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-6 institutional-border">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110 img-institutional" style="background-image: url('<?php echo htmlspecialchars($eduIntermediate); ?>')"></div>
<div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors"></div>
<div class="absolute top-4 left-4 px-3 py-1 bg-primary text-on-primary font-label-sm text-[10px] uppercase rounded">Chief Investment Officer</div>
</div>
<h3 class="font-headline-md text-white mb-3">Elena Vargas</h3>
<p class="font-body-md text-on-surface-variant">Oversees portfolio construction, risk allocation, and market research.</p>
</div>
<div class="group reveal-up" style="transition-delay:0.2s">
<div class="relative aspect-[4/3] rounded-2xl overflow-hidden mb-6 institutional-border">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110 img-institutional" style="background-image: url('<?php echo htmlspecialchars($eduAdvanced); ?>')"></div>
<div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors"></div>
<div class="absolute top-4 left-4 px-3 py-1 bg-primary text-on-primary font-label-sm text-[10px] uppercase rounded">Head of Trading</div>
</div>
<h3 class="font-headline-md text-white mb-3">Julian Crowe</h3>
<p class="font-body-md text-on-surface-variant">Manages execution systems and day-to-day trading operations.</p>
</div>
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
Join investors who trust <?php echo htmlspecialchars($siteName); ?> for stocks, equities, real estate investment, and auto trading.
</p>
</div>
</div>
</section>

</main>

<?php require_once __DIR__ . '/includes/marketing-footer.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  (function initHeroSlider() {
    var root = document.querySelector('[data-hero-slider]');
    if (!root) return;
    var slides = Array.prototype.slice.call(root.querySelectorAll('.hero-slide'));
    if (slides.length < 2) return;
    var index = 0;
    setInterval(function () {
      slides[index].classList.remove('is-active');
      index = (index + 1) % slides.length;
      slides[index].classList.add('is-active');
    }, 5000);
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
});
</script>
</body>
</html>
