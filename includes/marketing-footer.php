<?php
require_once __DIR__ . '/helpers.php';
$siteName = get_site_name();
$footerDesc = get_site_setting(
    'footer_description',
    'Focused on stocks, equities, real estate investment, and auto trading — with transparency as our number one priority.'
);
$homepageModalImage = get_site_setting('homepage_modal_image', '');
?>
<footer class="bg-surface-container-lowest border-t border-white/5 py-24">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
<div class="col-span-1 space-y-6">
<div class="max-w-[280px]">
<?php echo site_brand_markup('h-12 md:h-14 w-auto max-w-full object-contain object-left', 'font-display-sm text-headline-lg text-primary tracking-tighter'); ?>
</div>
<p class="font-body-md text-on-surface-variant leading-relaxed pr-0 md:pr-8"><?php echo htmlspecialchars($footerDesc); ?></p>
<div class="flex gap-4">
<a class="text-on-surface-variant hover:text-primary transition-colors" href="/login" aria-label="Login">
<span class="material-symbols-outlined">public</span>
</a>
<a class="text-on-surface-variant hover:text-primary transition-colors" href="/#markets" aria-label="Markets">
<span class="material-symbols-outlined">show_chart</span>
</a>
<a class="text-on-surface-variant hover:text-primary transition-colors" href="/live_chat" aria-label="Contact">
<span class="material-symbols-outlined">mail</span>
</a>
</div>
<?php if (!empty($homepageModalImage)): ?>
<button id="footer-certificate-btn" type="button" class="inline-flex items-center gap-2 text-label-sm font-label-sm text-primary hover:text-white transition-colors rounded-full px-4 py-2 border border-white/10 hover:bg-white/5">
<span class="material-symbols-outlined text-base">verified</span>
View Certificate
</button>
<?php endif; ?>
<button type="button" data-pwa-install="footer" class="hidden md:inline-flex items-center gap-2 text-label-sm font-label-sm text-on-surface-variant hover:text-primary transition-colors rounded-full px-4 py-2 border border-white/10 hover:bg-white/5">
<span class="material-symbols-outlined text-base">download</span>
<span data-pwa-label>Install App</span>
</button>
</div>
<div>
<span class="font-label-sm text-white uppercase tracking-widest block mb-6">Company</span>
<ul class="space-y-4">
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/login">About Us</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/legal_centre">Legal Centre</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/login">Our Leadership</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/plans">Investment Plans</a></li>
</ul>
</div>
<div>
<span class="font-label-sm text-white uppercase tracking-widest block mb-6">Support</span>
<ul class="space-y-4">
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/help_centre">Help Center</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/live_chat">Contact Concierge</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/live_chat">Institutional Support</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/login">Market Data</a></li>
</ul>
</div>
<div>
<span class="font-label-sm text-white uppercase tracking-widest block mb-6">Compliance</span>
<ul class="space-y-4">
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/legal_centre#privacy">Privacy Policy</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/legal_centre#terms">Terms of Service</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/legal_centre#risk-disclosure">Risk Disclosure</a></li>
<li><a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="/legal_centre#regulatory-info">Regulatory Info</a></li>
</ul>
</div>
</div>
<div class="pt-12 border-t border-white/5">
<p class="text-on-surface-variant font-label-sm text-label-sm leading-relaxed max-w-4xl">
© <?php echo date('Y'); ?> <?php echo htmlspecialchars($siteName); ?>. Operated under STRATEGIC WEALTH MANAGEMENT LIMITED (Company number 02205890). High-risk investment products may not be suitable for all investors. Investing in stocks, equities, real estate, and related markets involves significant risk. You should only invest capital you can afford to lose.
</p>
<div class="flex flex-wrap gap-6 mt-6">
<a class="text-on-surface-variant font-label-sm text-label-sm hover:text-primary underline" href="/legal_centre#privacy">Privacy Policy</a>
<a class="text-on-surface-variant font-label-sm text-label-sm hover:text-primary underline" href="/legal_centre#risk-disclosure">Risk Disclosure</a>
<a class="text-on-surface-variant font-label-sm text-label-sm hover:text-primary underline" href="/legal_centre#terms">Terms of Service</a>
<a class="text-on-surface-variant font-label-sm text-label-sm hover:text-primary underline" href="/help_centre">Help Center</a>
</div>
</div>
</div>
</footer>

<?php if (!empty($homepageModalImage)): ?>
<div id="homepage-modal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4">
<div class="relative bg-surface-container rounded-2xl shadow-2xl flex items-center justify-center max-w-[95vw] max-h-[95vh] p-4 institutional-border">
<button id="homepage-modal-close" class="absolute top-2 right-2 z-10 w-10 h-10 rounded-full bg-surface-container-high hover:bg-surface-bright flex items-center justify-center transition-colors" aria-label="Close">
<span class="material-symbols-outlined text-on-surface">close</span>
</button>
<img src="<?php echo htmlspecialchars($homepageModalImage); ?>" alt="Certificate" class="max-w-[90vw] max-h-[90vh] w-auto h-auto object-contain rounded-lg"/>
</div>
</div>
<script>
(function(){
  var btn = document.getElementById('footer-certificate-btn');
  var modal = document.getElementById('homepage-modal');
  var close = document.getElementById('homepage-modal-close');
  if (!btn || !modal || !close) return;
  btn.addEventListener('click', function(){ modal.classList.remove('hidden'); modal.classList.add('flex'); document.body.style.overflow = 'hidden'; });
  close.addEventListener('click', function(){ modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.style.overflow = ''; });
  modal.addEventListener('click', function(e){ if (e.target === modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.style.overflow = ''; } });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && !modal.classList.contains('hidden')) { modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.style.overflow = ''; } });
})();
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/pwa-install-modal.php'; ?>
<?php $pwaInstallVer = (int) @filemtime(dirname(__DIR__) . '/js/pwa-install.js'); ?>
<script src="/js/pwa-install.js?v=<?php echo $pwaInstallVer; ?>" defer></script>

<div class="gtranslate_wrapper"></div>
<?php require_once __DIR__ . '/app-script.php'; ?>
<?php require_once __DIR__ . '/translation-widget.php'; ?>
<?php if (($currentPage ?? '') === 'live_chat'): ?>
<?php require_once __DIR__ . '/live-chat-widget.php'; ?>
<?php endif; ?>
