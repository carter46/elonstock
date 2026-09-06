</div>
</main>
<script>
window.AdminUI = window.AdminUI || {
  setButtonLoading: function (btn, loading, opts) {
    if (!btn) return;
    if (typeof opts === 'string') opts = { label: opts };
    opts = opts || {};
    if (loading) {
      if (!btn.dataset.adminLabel) btn.dataset.adminLabel = btn.innerHTML;
      btn.disabled = true;
      btn.setAttribute('aria-busy', 'true');
      btn.classList.add('is-saving');
      var label = opts.label || 'Saving…';
      btn.innerHTML = '<span class="admin-btn-spinner" aria-hidden="true"></span><span>' + label + '</span>';
    } else {
      btn.disabled = false;
      btn.removeAttribute('aria-busy');
      btn.classList.remove('is-saving');
      if (btn.dataset.adminLabel) {
        btn.innerHTML = btn.dataset.adminLabel;
        delete btn.dataset.adminLabel;
      }
    }
  },
  showMsg: function (el, text, ok) {
    if (!el) return;
    var base = el.getAttribute('data-msg-base-class') || 'text-sm mt-2';
    el.textContent = text || '';
    el.className = base + ' admin-feedback-msg ' + (ok ? 'text-green-600' : 'text-red-600');
    el.classList.remove('hidden');
    el.classList.remove('admin-feedback-pop');
    // Force reflow so repeated identical messages still animate.
    void el.offsetWidth;
    el.classList.add('admin-feedback-pop');
  }
};

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.glass-panel').forEach(function (card) {
    card.addEventListener('mouseenter', function () {
      card.style.transform = 'translateY(-2px)';
      card.style.transition = 'transform 0.2s ease-out';
    });
    card.addEventListener('mouseleave', function () {
      card.style.transform = 'translateY(0)';
    });
  });
});
</script>
