<?php
require_once __DIR__ . '/includes/helpers.php';
$siteName = get_site_name();
$pageTitle = 'About Us | ' . $siteName . ' - Stocks, Equities & Real Estate Investment';
$heroBg = '/uploads/images/chart_bg.jpg';
$infraBg = 'https://lh3.googleusercontent.com/aida/AP1WRLsKriSbY6BJi-Xp2Gkc7D7CVwxW2aLMAeU3vslR5SSitI_47iRoKte8OAQPNNm9SVIVAJP-rxuMAgVJSJdgU79P5g1FgzlR3L1T3iKisxILmQwUVbRBpe9jP9AcBhmn5dOT2lGX6TkC3LxSMhG_7zFbayukNlnb63bYjV8lzW6sJhcDohhWpwHwt7jiN5I_ApLCsQeZ4HaS-BEOnuPIsgpW6dVCbSLy14ewi2QOegd2_aontl0Sqgbjst8';
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php require_once __DIR__ . '/includes/marketing-head.php'; ?>
<style>
.active-dot { box-shadow: 0 0 8px #20B26C; }
.about-hero-bg {
  background-image: url('<?php echo htmlspecialchars($heroBg); ?>');
  background-size: cover;
  background-position: center;
}
.about-infra-bg {
  background-image: url('<?php echo htmlspecialchars($infraBg); ?>');
  background-size: cover;
}
</style>
</head>
<body class="marketing-page font-body-md bg-background text-on-surface selection:bg-primary selection:text-on-primary overflow-x-hidden">
<?php $currentPage = 'about_us'; require_once __DIR__ . '/includes/marketing-header.php'; ?>

<main class="pt-20">
<!-- Hero -->
<section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">
<div class="absolute inset-0 z-0 about-hero-bg opacity-30"></div>
<div class="absolute inset-0 z-10 pointer-events-none" style="background: linear-gradient(to bottom, rgba(7,12,20,0.55) 0%, rgba(7,12,20,0.72) 45%, rgba(7,12,20,0.95) 100%);"></div>
<div class="relative z-20 max-w-container-max mx-auto px-4 md:px-margin-desktop text-center py-16">
<span class="inline-block font-label-xs text-label-xs text-surface-tint tracking-[0.2em] mb-4 border border-surface-tint/30 px-4 py-1 rounded-full bg-surface-tint/5">STOCKS · EQUITIES · REAL ESTATE</span>
<h1 class="font-display text-4xl sm:text-5xl lg:text-display text-text-primary mb-6 max-w-4xl mx-auto text-glow">
The World's Leading <span class="text-primary-container">Investment Platform.</span>
</h1>
<p class="font-body-lg text-body-lg text-text-secondary max-w-2xl mx-auto mb-10">
<?php echo htmlspecialchars($siteName); ?> strives to be worthy of our clients' trust by providing services that are economically beneficial and by creating awareness of a reliable, highly profitable investment platform among clients around the globe. Sit back and watch how your profit grows on a daily basis.
</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
<a href="#company" class="gradient-button px-8 py-4 font-label-sm text-label-sm inline-flex items-center justify-center gap-2">
OUR COMPANY <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
<a href="/legal_centre" class="btn-secondary px-8 py-4 font-label-sm text-label-sm inline-flex items-center justify-center">
LEGAL &amp; COMPLIANCE
</a>
</div>
</div>
</section>

<!-- Social Proof Stats Bar -->
<section class="bg-bg-subtle py-12 border-y border-low">
<div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
<div class="flex flex-col md:flex-row items-center justify-between gap-8">
<div class="flex items-center gap-4">
<div class="flex -space-x-3">
<div class="w-10 h-10 rounded-full border-2 border-bg-subtle bg-surface-container-high flex items-center justify-center"><span class="material-symbols-outlined text-primary-container text-[16px]">person</span></div>
<div class="w-10 h-10 rounded-full border-2 border-bg-subtle bg-surface-container-high flex items-center justify-center"><span class="material-symbols-outlined text-primary-container text-[16px]">person</span></div>
<div class="w-10 h-10 rounded-full border-2 border-bg-subtle bg-surface-container-high flex items-center justify-center"><span class="material-symbols-outlined text-primary-container text-[16px]">person</span></div>
</div>
<div>
<p class="font-headline-md text-headline-md text-text-primary leading-none">Trusted Worldwide</p>
<p class="font-label-xs text-label-xs text-text-secondary mt-1 uppercase">Private &amp; Institutional Investors</p>
</div>
</div>
<div class="flex flex-wrap justify-center gap-6 opacity-60 grayscale hover:grayscale-0 transition-all">
<span class="font-label-sm text-label-sm text-text-secondary">TRANSPARENCY IS OUR NUMBER ONE PRIORITY</span>
</div>
</div>
</div>
</section>

<!-- Vision & Mission -->
<section class="py-section-padding relative">
<div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none about-infra-bg"></div>
<div class="max-w-container-max mx-auto px-4 md:px-margin-desktop grid md:grid-cols-2 gap-16 items-center">
<div class="space-y-12">
<div class="glass-panel p-8 md:p-12 rounded-xl">
<span class="text-primary-container font-label-xs text-label-xs uppercase tracking-widest mb-4 block">What We Do</span>
<h2 class="font-headline-lg text-headline-lg text-text-primary mb-6">Stocks, Equities, Real Estate &amp; Auto Trading.</h2>
<p class="font-body-md text-body-md text-text-secondary leading-relaxed">
<?php echo htmlspecialchars($siteName); ?> is involved in real estate brokerage, commercial stocks, Oil &amp; Gas, and related investment activity — generating substantial income annually. Our focus is equities, stock markets, real estate bidding and investment, and automated trading strategies that work for you.
</p>
</div>
<div class="glass-panel p-8 md:p-12 rounded-xl">
<span class="text-primary-container font-label-xs text-label-xs uppercase tracking-widest mb-4 block">Our Mission</span>
<h2 class="font-headline-lg text-headline-lg text-text-primary mb-6">Reliable Growth Clients Can Trust.</h2>
<p class="font-body-md text-body-md text-text-secondary leading-relaxed">
Our team is fully functional and transparency is our number one priority. We provide economically beneficial services and help clients worldwide understand how a structured, professionally managed investment platform can support daily profit growth.
</p>
</div>
</div>
<div class="relative group">
<div class="absolute -inset-1 bg-gradient-to-r from-primary-container/20 to-transparent rounded-xl blur-2xl group-hover:blur-3xl transition-all duration-500 opacity-50"></div>
<div class="relative glass-panel rounded-xl overflow-hidden aspect-square flex items-center justify-center p-4">
<img class="w-full h-full object-cover rounded shadow-2xl" alt="Global markets, equities and investment infrastructure" src="/uploads/images/crypto-assets.jpg" onerror="this.onerror=null;this.src='/uploads/images/chart_bg.jpg'"/>
</div>
</div>
</div>
</section>

<!-- The Standard -->
<section class="py-section-padding bg-surface-container-lowest">
<div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
<div class="text-center mb-16">
<h2 class="font-headline-lg text-headline-lg text-text-primary mb-4">The <?php echo htmlspecialchars($siteName); ?> Standard</h2>
<div class="w-24 h-1 bg-primary-container mx-auto"></div>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
<div class="trading-card p-8 hover:border-primary-container/30 transition-all group">
<div class="w-12 h-12 bg-primary-container/10 flex items-center justify-center rounded-lg mb-6 group-hover:bg-primary-container/20 transition-colors">
<span class="material-symbols-outlined text-primary-container text-[28px]">visibility</span>
</div>
<h3 class="font-headline-md text-headline-md text-text-primary mb-4">Transparency</h3>
<p class="font-body-md text-body-md text-text-secondary">Clear reporting, open communication, and accountable processes so clients always understand how their capital is managed.</p>
</div>
<div class="trading-card p-8 hover:border-primary-container/30 transition-all group">
<div class="w-12 h-12 bg-primary-container/10 flex items-center justify-center rounded-lg mb-6 group-hover:bg-primary-container/20 transition-colors">
<span class="material-symbols-outlined text-primary-container text-[28px]">apartment</span>
</div>
<h3 class="font-headline-md text-headline-md text-text-primary mb-4">Real Assets</h3>
<p class="font-body-md text-body-md text-text-secondary">Exposure across commercial stocks, real estate brokerage, and Oil &amp; Gas opportunities that underpin long-term wealth creation.</p>
</div>
<div class="trading-card p-8 hover:border-primary-container/30 transition-all group">
<div class="w-12 h-12 bg-primary-container/10 flex items-center justify-center rounded-lg mb-6 group-hover:bg-primary-container/20 transition-colors">
<span class="material-symbols-outlined text-primary-container text-[28px]">verified_user</span>
</div>
<h3 class="font-headline-md text-headline-md text-text-primary mb-4">Trust</h3>
<p class="font-body-md text-body-md text-text-secondary">We strive to earn client trust through economically beneficial services and a fully functional team focused on reliable outcomes.</p>
</div>
<div class="trading-card p-8 hover:border-primary-container/30 transition-all group">
<div class="w-12 h-12 bg-primary-container/10 flex items-center justify-center rounded-lg mb-6 group-hover:bg-primary-container/20 transition-colors">
<span class="material-symbols-outlined text-primary-container text-[28px]">auto_graph</span>
</div>
<h3 class="font-headline-md text-headline-md text-text-primary mb-4">Auto Trading</h3>
<p class="font-body-md text-body-md text-text-secondary">Structured automated trading and investment workflows so you can sit back while profits are pursued on a daily basis.</p>
</div>
</div>
</div>
</section>

<!-- Company Registration -->
<section id="company" class="py-section-padding relative overflow-hidden scroll-mt-24">
<div class="absolute inset-0 about-infra-bg bg-fixed opacity-5"></div>
<div class="max-w-container-max mx-auto px-4 md:px-margin-desktop relative z-10">
<div class="glass-panel rounded-2xl p-8 md:p-12 border border-primary-container/20">
<span class="font-label-xs text-label-xs text-primary-container tracking-widest block mb-4">COMPANY INFORMATION</span>
<h2 class="font-display text-headline-lg text-text-primary mb-6">Registered &amp; Accountable</h2>
<p class="font-body-md text-body-md text-text-secondary leading-relaxed mb-8 max-w-3xl">
<?php echo htmlspecialchars($siteName); ?> is a private limited company registered under <strong class="text-text-primary">STRATEGIC WEALTH MANAGEMENT LIMITED</strong> with Company number <strong class="text-text-primary">02205890</strong>.
</p>
<div class="grid md:grid-cols-2 gap-8">
<div class="p-6 rounded-xl bg-surface-container-high/60 border border-low">
<h3 class="font-headline-md text-headline-md text-text-primary mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-primary-container">badge</span>
Company Number
</h3>
<p class="font-data-mono text-lg text-primary-container">02205890</p>
<p class="text-sm text-text-secondary mt-2">STRATEGIC WEALTH MANAGEMENT LIMITED</p>
</div>
<div class="p-6 rounded-xl bg-surface-container-high/60 border border-low">
<h3 class="font-headline-md text-headline-md text-text-primary mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-primary-container">location_on</span>
Registered Office
</h3>
<p class="font-body-md text-body-md text-text-secondary leading-relaxed">
Lindeyer Francis Ferguson<br/>
North House, 198 High Street<br/>
Tonbridge, Kent, TN9 1BE
</p>
</div>
</div>
</div>
</div>
</section>

<!-- Founder Quote -->
<section class="py-section-padding bg-bg-subtle relative overflow-hidden">
<div class="max-w-4xl mx-auto px-4 md:px-margin-desktop text-center relative z-10">
<div class="mb-12 inline-block">
<div class="w-24 h-24 rounded-full border-2 border-primary-container p-1 mx-auto mb-6">
<div class="w-full h-full rounded-full bg-surface-container-highest flex items-center justify-center overflow-hidden">
<span class="material-symbols-outlined text-primary-container text-[48px]">person</span>
</div>
</div>
<p class="font-headline-md text-headline-md text-text-primary">Martin Harris</p>
<p class="font-label-xs text-label-xs text-primary-container tracking-widest uppercase">Founder &amp; CEO</p>
</div>
<blockquote class="font-display text-headline-lg text-text-primary italic leading-tight mb-12">
"Our goal is simple: earn our clients' trust every day through transparent, economically beneficial investment services across stocks, equities, and real estate."
</blockquote>
<div class="flex justify-center">
<div class="w-12 h-1 bg-primary-container/30"></div>
</div>
</div>
<span class="absolute top-0 left-10 text-[200px] font-display text-white/5 pointer-events-none select-none" aria-hidden="true">"</span>
<span class="absolute bottom-0 right-10 text-[200px] font-display text-white/5 pointer-events-none select-none" aria-hidden="true">"</span>
</section>

<!-- Global Stats -->
<section class="py-24 border-t border-low">
<div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
<div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
<div>
<p class="font-display text-[48px] text-primary-container mb-2">3</p>
<p class="font-label-sm text-label-sm text-text-secondary uppercase">Core Sectors</p>
</div>
<div>
<p class="font-display text-[48px] text-primary-container mb-2">Daily</p>
<p class="font-label-sm text-label-sm text-text-secondary uppercase">Profit Focus</p>
</div>
<div>
<p class="font-display text-[48px] text-primary-container mb-2">100%</p>
<p class="font-label-sm text-label-sm text-text-secondary uppercase">Transparency Priority</p>
</div>
<div>
<p class="font-display text-[48px] text-primary-container mb-2">24/7</p>
<p class="font-label-sm text-label-sm text-text-secondary uppercase">Client Support</p>
</div>
</div>
</div>
</section>

<!-- CTA -->
<section class="py-section-padding px-4 md:px-margin-desktop">
<div class="max-w-container-max mx-auto glass-panel rounded-2xl p-12 md:p-20 text-center relative overflow-hidden group">
<div class="absolute inset-0 bg-primary-container/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
<h2 class="font-display text-headline-lg text-text-primary mb-6 relative z-10">Ready to grow your capital?</h2>
<p class="font-body-lg text-body-lg text-text-secondary mb-10 max-w-xl mx-auto relative z-10">Join <?php echo htmlspecialchars($siteName); ?> for stocks, equities, real estate investment, and auto trading — with transparency as our number one priority.</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
<a href="/register" class="gradient-button px-10 py-5 font-label-sm text-label-sm inline-flex items-center justify-center">CREATE YOUR ACCOUNT</a>
<a href="/live_chat" class="btn-secondary px-10 py-5 font-label-sm text-label-sm inline-flex items-center justify-center">CONTACT SUPPORT</a>
</div>
</div>
</section>
</main>

<?php require_once __DIR__ . '/includes/marketing-footer.php'; ?>
</body>
</html>
