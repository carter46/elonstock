</div>
<footer class="mt-auto w-full flex flex-col md:flex-row justify-between items-center px-4 md:px-8 py-8 border-t border-white/5 bg-surface-container-lowest gap-4">
<div class="flex flex-col items-center md:items-start gap-1">
<p class="font-label-sm text-label-sm text-on-surface-variant opacity-60 text-center md:text-left">
© <?php echo date('Y'); ?> <?php echo htmlspecialchars($siteName ?? get_site_name()); ?>. Institutional trading terminal.
</p>
<p class="text-[10px] text-on-surface-variant opacity-40">
Precision Terminal Version 2.4.11-stable
</p>
</div>
<div class="flex flex-wrap justify-center gap-6 md:gap-8">
<a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="/legal_centre#privacy">Privacy Policy</a>
<a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="/legal_centre#terms">Terms of Service</a>
<a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="/legal_centre#risk-disclosure">Regulatory Disclosure</a>
<a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="/live_chat">Contact Support</a>
</div>
</footer>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.glass-panel, .glass-card').forEach(function (card) {
    card.addEventListener('mouseenter', function () { card.style.borderColor = 'rgba(75, 142, 255, 0.28)'; });
    card.addEventListener('mouseleave', function () { card.style.borderColor = 'rgba(255, 255, 255, 0.08)'; });
  });

  (function initUserSocialProof() {
    var dataEl = document.getElementById('user-social-proof-data');
    var toast = document.getElementById('live-notification') || document.getElementById('user-social-proof-toast');
    var textEl = document.getElementById('user-social-proof-text');
    if (!dataEl || !toast || !textEl) return;
    if (toast.dataset.socialInit === '1') return;
    toast.dataset.socialInit = '1';

    var messages;
    try { messages = JSON.parse(dataEl.textContent || '[]'); } catch (e) { return; }
    if (!messages.length) return;

    var idx = 0;
    var fadeMs = 500;
    var holdMs = 4500;

    function highlightAmount(msg) {
      return String(msg).replace(
        /([A-Za-z][A-Za-z\s.'-]+)\s+from\s+([A-Za-z\s]+)\s+(.*?)(\$[\d,]+(?:\.\d{2})?)/,
        '<span class="font-bold text-on-surface">$1</span> from $2 $3<span class="text-primary font-mono">$4</span>'
      ).replace(/(\$[\d,]+(?:\.\d{2})?)/, '<span class="text-primary font-mono">$1</span>');
    }

    function setMessage() {
      textEl.innerHTML = highlightAmount(messages[idx % messages.length]);
      idx += 1;
    }

    function showToast() {
      setMessage();
      requestAnimationFrame(function () { toast.classList.add('is-visible'); });
    }

    function hideThenShow() {
      toast.classList.remove('is-visible');
      setTimeout(showToast, fadeMs);
    }

    setTimeout(showToast, 400);
    setInterval(hideThenShow, fadeMs + holdMs + fadeMs);
  })();
});
</script>
