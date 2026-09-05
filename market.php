<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/market-instruments.php';

$siteName = get_site_name();
$slug = isset($_GET['slug']) ? strtolower(trim((string) $_GET['slug'])) : '';
$instrument = $slug !== '' ? get_market_instrument($slug) : null;

if (!$instrument) {
    http_response_code(404);
    $pageTitle = 'Market Not Found | ' . $siteName;
    ?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require_once __DIR__ . '/includes/marketing-head.php'; ?>
</head>
<body class="marketing-page font-body-md text-body-md overflow-x-hidden">
<?php $currentPage = 'markets'; require_once __DIR__ . '/includes/marketing-header.php'; ?>
<section class="py-32 text-center">
<div class="max-w-xl mx-auto px-4">
<h1 class="font-display text-4xl mb-4 text-on-surface">Market Not Found</h1>
<p class="text-on-secondary-container mb-8">The market you are looking for does not exist or may have been moved.</p>
<a href="/#markets" class="gradient-button inline-flex items-center gap-2 px-8 py-4 font-bold text-label-sm">Browse Markets</a>
</div>
</section>
<?php require_once __DIR__ . '/includes/marketing-footer.php'; ?>
</body>
</html>
    <?php
    exit;
}

$illustration = market_illustration_src($instrument);
$illustrationAlt = market_illustration_alt_src($instrument);
$heroSlides = market_hero_slides($instrument);
$related = get_related_markets($slug);
$benefits = market_benefits_cards();
$snapshot = $instrument['snapshot'] ?? [];
$h1Title = $instrument['name'];
if ($instrument['category'] === 'stock' && preg_match('/\(([A-Z]+)\)/', $instrument['name'], $m)) {
    $h1Title = preg_replace('/\s*\([A-Z]+\)/', '', $instrument['name']) . ' (' . $m[1] . ')';
} elseif ($instrument['category'] === 'stock' && strpos($instrument['pair_label'], '/') !== false) {
    $ticker = trim(explode('/', $instrument['pair_label'])[0]);
    $h1Title = $instrument['name'] . ' (' . $ticker . ')';
}
$isCrypto = $instrument['category'] === 'crypto';
$coingeckoId = $instrument['coingecko_id'] ?? '';
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php
$pageTitle = $instrument['seo']['title'] ?? ($instrument['name'] . ' | ' . $siteName);
$skipDefaultSocialMeta = true;
require_once __DIR__ . '/includes/marketing-head.php';
output_market_seo_tags($instrument);
?>
</head>
<body class="marketing-page font-body-md text-body-md overflow-x-hidden market-detail-page">
<?php $currentPage = 'markets'; require_once __DIR__ . '/includes/marketing-header.php'; ?>

<!-- Hero -->
<section class="market-hero relative pt-32 pb-16 md:pb-24 overflow-hidden"<?php echo !empty($heroSlides) ? ' data-hero-slider' : ''; ?>>
<?php if (!empty($heroSlides)): ?>
<?php foreach ($heroSlides as $i => $slideSrc): ?>
<div class="absolute inset-0 hero-bg hero-slide<?php echo $i === 0 ? ' is-active' : ''; ?>" style="background-image: url('<?php echo htmlspecialchars($slideSrc); ?>');"></div>
<?php endforeach; ?>
<div class="absolute inset-0 hero-bg-overlay"></div>
<?php else: ?>
<div class="absolute inset-0 market-hero-glow opacity-40"></div>
<?php endif; ?>
<div class="relative z-10 max-w-[1440px] mx-auto px-4 md:px-margin-desktop">
<div class="max-w-3xl">
<span class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-high/80 rounded-full mb-6 border border-border-low text-label-xs text-on-secondary-container uppercase tracking-wide">
<span class="material-symbols-outlined text-primary-container text-sm">candlestick_chart</span>
<?php echo htmlspecialchars($snapshot['market_type'] ?? ucfirst($instrument['category'])); ?>
</span>
<h1 class="font-display text-4xl sm:text-5xl lg:text-display mb-6 text-white leading-tight"><?php echo htmlspecialchars($h1Title); ?></h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-2xl"><?php echo htmlspecialchars($instrument['intro']); ?></p>
<a href="/dashboard" class="gradient-button inline-flex items-center gap-2 px-8 py-4 font-bold text-label-sm hover:scale-105 transition-transform">
Get Started Now <span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
</div>
</section>

<!-- Market Snapshot -->
<section class="py-10 md:py-12 bg-surface border-b border-white/5">
<div class="max-w-[1440px] mx-auto px-4 md:px-margin-desktop">
<h2 class="sr-only">Market Snapshot</h2>
<div class="market-snapshot-card trading-card p-6 md:p-8">
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
<div>
<div class="text-xs font-bold text-on-surface-variant uppercase mb-1">Market Type</div>
<div class="font-semibold text-on-surface"><?php echo htmlspecialchars($snapshot['market_type'] ?? '—'); ?></div>
</div>
<?php if (!empty($snapshot['sector'])): ?>
<div>
<div class="text-xs font-bold text-on-surface-variant uppercase mb-1">Sector</div>
<div class="font-semibold text-on-surface"><?php echo htmlspecialchars($snapshot['sector']); ?></div>
</div>
<?php endif; ?>
<div>
<div class="text-xs font-bold text-on-surface-variant uppercase mb-1">Exchange</div>
<div class="font-semibold text-on-surface"><?php echo htmlspecialchars($snapshot['exchange'] ?? '—'); ?></div>
</div>
<div>
<div class="text-xs font-bold text-on-surface-variant uppercase mb-1">Trading Hours</div>
<div class="font-semibold text-on-surface"><?php echo htmlspecialchars($snapshot['hours'] ?? '—'); ?></div>
</div>
<div>
<div class="text-xs font-bold text-on-surface-variant uppercase mb-1">Volatility</div>
<div class="font-semibold text-on-surface"><?php echo htmlspecialchars($snapshot['volatility'] ?? '—'); ?></div>
</div>
<div>
<div class="text-xs font-bold text-on-surface-variant uppercase mb-1">Suitable For</div>
<div class="font-semibold text-on-surface text-sm leading-snug"><?php echo htmlspecialchars($snapshot['suitable_for'] ?? '—'); ?></div>
</div>
</div>
</div>
</div>
</section>

<!-- Live Chart -->
<section class="py-12 md:py-16 bg-surface-container-lowest">
<div class="max-w-[1440px] mx-auto px-4 md:px-margin-desktop">
<h2 class="font-headline-md text-headline-md text-on-surface mb-6">Live Price Chart</h2>
<div class="market-detail-chart-wrap rounded-2xl bg-surface-container border border-white/5 p-4 md:p-6">
<?php if ($isCrypto && $coingeckoId): ?>
<div class="crypto-detail-header mb-4 flex flex-wrap items-center justify-between gap-4" data-coin="<?php echo htmlspecialchars($coingeckoId); ?>">
<div class="flex items-center gap-3">
<img class="crypto-logo w-10 h-10 rounded-full" src="" alt=""/>
<div>
<div class="font-bold text-on-surface crypto-symbol"><?php echo htmlspecialchars($instrument['pair_label']); ?></div>
<div class="text-sm text-on-surface-variant crypto-name"><?php echo htmlspecialchars($instrument['name']); ?></div>
</div>
</div>
<div class="text-right">
<div class="text-2xl font-bold font-data-mono text-on-surface crypto-price">--</div>
<div class="crypto-change font-data-mono text-sm text-on-surface-variant">--</div>
</div>
</div>
<?php endif; ?>
<tv-mini-chart symbol="<?php echo htmlspecialchars($instrument['symbol']); ?>" style="width: 100%; height: 360px; max-width: 100%;"></tv-mini-chart>
<?php require_once __DIR__ . '/includes/market-chart-disclaimer.php'; ?>
</div>
</div>
</section>

<!-- About (image right) -->
<section class="py-16 md:py-20 bg-surface-container-lowest">
<div class="max-w-[1440px] mx-auto px-4 md:px-margin-desktop grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
<div class="order-2 lg:order-1">
<h2 class="font-headline-md text-headline-md text-on-surface mb-6">About This Market</h2>
<div class="space-y-4 text-on-secondary-container text-body-md">
<?php foreach ($instrument['about_paragraphs'] as $para): ?>
<p><?php echo htmlspecialchars($para); ?></p>
<?php endforeach; ?>
</div>
</div>
<div class="order-1 lg:order-2 flex justify-center">
<img src="<?php echo htmlspecialchars($illustration); ?>" alt="<?php echo htmlspecialchars($instrument['name']); ?> illustration" class="market-illustration rounded-2xl shadow-xl max-w-md w-full object-cover" loading="lazy"/>
</div>
</div>
</section>

<!-- Why Investors Watch (image left) -->
<section class="py-16 md:py-20 bg-surface border-y border-white/5">
<div class="max-w-[1440px] mx-auto px-4 md:px-margin-desktop grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
<div class="flex justify-center order-1">
<img src="<?php echo htmlspecialchars($illustrationAlt); ?>" alt="" class="market-illustration market-illustration-alt rounded-2xl shadow-lg max-w-sm w-full object-cover opacity-90 img-institutional" loading="lazy" aria-hidden="true"/>
</div>
<div class="order-2">
<h2 class="font-headline-md text-headline-md text-on-surface mb-4">Why Investors Watch This Market</h2>
<?php if (!empty($instrument['why_watch_intro'])): ?>
<p class="text-on-surface-variant mb-6"><?php echo htmlspecialchars($instrument['why_watch_intro']); ?></p>
<?php endif; ?>
<ul class="space-y-4">
<?php foreach ($instrument['why_watch'] as $bullet): ?>
<li class="flex gap-3 text-on-surface">
<span class="material-symbols-outlined text-primary-container shrink-0 text-xl">check_circle</span>
<span><?php echo htmlspecialchars($bullet); ?></span>
</li>
<?php endforeach; ?>
</ul>
</div>
</div>
</section>

<!-- How site helps (dark) -->
<section class="py-16 md:py-20 bg-surface-container-low border-y border-border-low">
<div class="max-w-[1440px] mx-auto px-4 md:px-margin-desktop grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
<div>
<h2 class="font-headline-md text-headline-md text-on-surface mb-6">How <?php echo htmlspecialchars($siteName); ?> Helps</h2>
<div class="space-y-4 text-on-secondary-container mb-8">
<?php foreach ($instrument['ai_help'] as $para): ?>
<p><?php echo htmlspecialchars($para); ?></p>
<?php endforeach; ?>
</div>
<ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
<?php foreach ($instrument['ai_help_bullets'] as $bullet): ?>
<li class="flex items-center gap-2 text-on-surface text-sm">
<span class="material-symbols-outlined text-primary-container text-lg">auto_awesome</span>
<?php echo htmlspecialchars($bullet); ?>
</li>
<?php endforeach; ?>
</ul>
</div>
<div class="bg-surface-container-high rounded-2xl p-8 border border-border-low">
<div class="flex items-center gap-3 mb-4">
<span class="material-symbols-outlined text-primary-container text-3xl">smart_toy</span>
<span class="font-bold text-on-surface text-lg">Market Monitoring</span>
</div>
<p class="text-on-secondary-container text-sm leading-relaxed">Our neural engine continuously analyzes market conditions for <?php echo htmlspecialchars($instrument['name']); ?> — surfacing context, not hype.</p>
</div>
</div>
</section>

<!-- Benefits -->
<section class="py-16 md:py-20 bg-surface-container-lowest">
<div class="max-w-[1440px] mx-auto px-4 md:px-margin-desktop">
<h2 class="font-headline-md text-headline-md text-on-surface mb-10 text-center">Platform Benefits</h2>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
<?php foreach ($benefits as $card): ?>
<div class="bg-surface-container-high border border-border-low rounded-xl p-6 hover:border-primary-container/30 transition-colors">
<span class="material-symbols-outlined text-primary-container text-3xl mb-4"><?php echo htmlspecialchars($card['icon']); ?></span>
<h3 class="font-bold text-on-surface mb-2"><?php echo htmlspecialchars($card['title']); ?></h3>
<p class="text-on-secondary-container text-sm"><?php echo htmlspecialchars($card['text']); ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<!-- Highlight banner -->
<section class="py-10 bg-primary-container/10 border-y border-primary-container/20">
<div class="max-w-[1440px] mx-auto px-4 md:px-margin-desktop text-center">
<p class="text-on-surface font-semibold text-lg md:text-xl">
<span class="material-symbols-outlined align-middle text-primary-container mr-2">insights</span>
Live market monitoring for <?php echo htmlspecialchars($instrument['name']); ?> — available 24/7 on <?php echo htmlspecialchars($siteName); ?>.
</p>
</div>
</section>

<?php require_once __DIR__ . '/includes/market-risk-disclaimer.php'; ?>

<!-- Related Markets -->
<?php if (!empty($related)): ?>
<section class="py-16 md:py-20 bg-surface-container">
<div class="max-w-[1440px] mx-auto px-4 md:px-margin-desktop">
<h2 class="font-headline-md text-headline-md text-on-surface mb-8">Related Markets</h2>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
<?php foreach ($related as $rel): ?>
<a href="/markets/<?php echo htmlspecialchars($rel['slug']); ?>" class="trading-card p-5 group block">
<div class="text-xs font-bold text-on-surface-variant uppercase mb-1"><?php echo htmlspecialchars($rel['snapshot']['market_type'] ?? ucfirst($rel['category'])); ?></div>
<div class="font-bold text-on-surface group-hover:text-primary-container transition-colors"><?php echo htmlspecialchars($rel['name']); ?></div>
<div class="text-sm text-on-surface-variant mt-1"><?php echo htmlspecialchars($rel['pair_label']); ?></div>
</a>
<?php endforeach; ?>
</div>
</div>
</section>
<?php endif; ?>

<!-- Premium CTA -->
<section class="py-20 md:py-28 bg-surface-container-lowest relative overflow-hidden">
<div class="absolute inset-0 market-cta-glow"></div>
<div class="relative z-10 max-w-3xl mx-auto px-4 text-center">
<h2 class="font-display text-3xl sm:text-4xl md:text-5xl text-on-surface mb-6"><?php echo htmlspecialchars($instrument['cta_headline'] ?? 'Ready to Explore Smarter Investing?'); ?></h2>
<p class="text-on-secondary-container text-body-lg mb-10 max-w-2xl mx-auto"><?php echo htmlspecialchars($instrument['cta_body'] ?? ''); ?></p>
<a href="/dashboard" class="gradient-button inline-flex items-center gap-2 px-10 py-4 font-bold text-label-sm text-lg hover:scale-105 transition-transform">
Get Started Now <span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
</section>

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
});
</script>
<script src="/js/crypto-config.js"></script>
<script src="/js/crypto-prices.js"></script>
<?php if ($isCrypto && $coingeckoId): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  if (!window.BloombitCryptoPrices) return;
  var coinId = '<?php echo htmlspecialchars($coingeckoId); ?>';
  window.BloombitCryptoPrices.init([coinId], { refreshInterval: 120000 }).then(function(prices) {
    var header = document.querySelector('.crypto-detail-header');
    if (!header) return;
    var p = prices[coinId];
    var cfg = window.BloombitCryptoConfig || {};
    var logo = cfg.getLogo ? cfg.getLogo(coinId) : '';
    var img = header.querySelector('.crypto-logo');
    if (img && logo) { img.src = logo; img.alt = '<?php echo htmlspecialchars(addslashes($instrument['name'])); ?>'; }
    var priceEl = header.querySelector('.crypto-price');
    var changeEl = header.querySelector('.crypto-change');
    if (p && priceEl) priceEl.textContent = window.BloombitCryptoPrices.formatPrice(p.usd);
    if (p && changeEl && p.usd_24h_change != null) {
      changeEl.textContent = window.BloombitCryptoPrices.formatChange(p.usd_24h_change);
      changeEl.className = 'crypto-change font-data-mono text-sm ' + (p.usd_24h_change >= 0 ? 'text-success' : 'text-critical');
    }
  });
});
</script>
<?php endif; ?>
</body>
</html>
