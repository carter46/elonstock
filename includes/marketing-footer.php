<?php
require_once __DIR__ . '/helpers.php';
$siteName = get_site_name();
$footerDesc = get_site_setting(
    'footer_description',
    'A regulated institutional asset management firm providing tier-1 market access, high-conviction portfolio strategies, and secure custodial services for the global financial sector.'
);
$homepageModalImage = get_site_setting('homepage_modal_image', '');
?>
<footer class="bg-surface-container-lowest border-t border-white/5 py-24">
<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex flex-col md:flex-row justify-between items-start gap-16 mb-16">
<div class="max-w-md space-y-6">
<div class="font-display-sm text-headline-lg text-primary tracking-tighter"><?php echo htmlspecialchars($siteName); ?></div>
<p class="font-body-md text-on-surface-variant leading-relaxed"><?php echo htmlspecialchars($footerDesc); ?></p>
<div class="pt-4 space-y-2 text-xs text-on-surface-variant/70 uppercase tracking-widest">
<p>Strategic Wealth Management Limited</p>
<p>Company Number: 02205890</p>
<p>Registered Office: Tonbridge, Kent, United Kingdom</p>
</div>
<?php if (!empty($homepageModalImage)): ?>
<button id="footer-certificate-btn" type="button" class="mt-4 inline-flex items-center gap-2 text-label-sm font-label-sm text-primary hover:text-white transition-colors rounded-full px-4 py-2 border border-white/10 hover:bg-white/5">
<span class="material-symbols-outlined text-base">verified</span>
View Certificate
</button>
<?php endif; ?>
<button type="button" data-pwa-install="footer" class="hidden md:inline-flex mt-4 items-center gap-2 text-label-sm font-label-sm text-on-surface-variant hover:text-primary transition-colors rounded-full px-4 py-2 border border-white/10 hover:bg-white/5">
<span class="material-symbols-outlined text-base">download</span>
<span data-pwa-label>Install App</span>
</button>
</div>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-12">
<div class="space-y-4">
<span class="font-label-sm text-white uppercase tracking-widest block mb-6">Asset Classes</span>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/plans">Real Estate</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/plans">Oil &amp; Gas</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/trading_signals">Commercial Equities</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/trading_signals">Digital Assets</a>
</div>
<div class="space-y-4">
<span class="font-label-sm text-white uppercase tracking-widest block mb-6">Institution</span>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/about_us">Private Banking</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/about_us">Corporate Strategy</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/legal_centre">Annual Reports</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/help_centre">Media Center</a>
</div>
<div class="space-y-4">
<span class="font-label-sm text-white uppercase tracking-widest block mb-6">Advisory</span>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/help_centre">Wealth Consulting</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/help_centre">Tax Efficiency</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/about_us">Family Office</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/plans">Direct Investments</a>
</div>
<div class="space-y-4">
<span class="font-label-sm text-white uppercase tracking-widest block mb-6">Regulatory</span>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/legal_centre#terms">Terms of Business</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/legal_centre#regulatory-info">Fiduciary Duties</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/legal_centre#risk-disclosure">Risk Governance</a>
<a class="font-label-md text-on-surface-variant hover:text-primary transition-colors block" href="/legal_centre#privacy">AML/KYC Policy</a>
</div>
</div>
</div>
<div class="pt-12 border-t border-white/5 flex flex-col sm:flex-row justify-between items-center gap-6">
<span class="font-label-sm text-on-surface-variant text-center sm:text-left">© <?php echo date('Y'); ?> <?php echo htmlspecialchars($siteName); ?>. All rights reserved. Strategic Wealth Management Limited is an authorized financial entity.</span>
<div class="flex gap-8">
<a href="/about_us" class="material-symbols-outlined text-on-surface-variant hover:text-white transition-colors" aria-label="About">public</a>
<button type="button" class="material-symbols-outlined text-on-surface-variant hover:text-white transition-colors cursor-pointer bg-transparent border-0 p-0" aria-label="Language" onclick="document.querySelector('.gtranslate_wrapper')?.scrollIntoView({behavior:'smooth'});">language</button>
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
<img src="<?php echo htmlspecialchars($homepageModalImage); ?>" alt="Certificate" class="max-w-[90vw] max-h-[90vh] w-auto h-auto object-contain rounded-lg img-institutional"/>
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
<?php require_once __DIR__ . '/live-chat-widget.php'; ?>
