</div>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.glass-panel, .glass-card').forEach(function (card) {
    card.addEventListener('mouseenter', function () { card.style.borderColor = 'rgba(255, 92, 26, 0.35)'; });
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
