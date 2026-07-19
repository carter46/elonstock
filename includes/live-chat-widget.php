<?php
/**
 * Live chat widget loader — Smartsupp or JivoChat (only one at a time).
 * Shown on the Live Chat page only (included from marketing-footer when $currentPage === 'live_chat').
 */
require_once __DIR__ . '/helpers.php';

$provider = strtolower(trim((string) get_site_setting('live_chat_provider', '')));
$smartsuppKey = trim((string) get_site_setting('smartsupp_key', ''));
$jivoWidgetId = trim((string) get_site_setting('jivo_widget_id', ''));

// Legacy: if no provider set but Smartsupp key exists, treat Smartsupp as active.
if ($provider === '' || !in_array($provider, ['smartsupp', 'jivo', 'none'], true)) {
    $provider = $smartsuppKey !== '' ? 'smartsupp' : 'none';
}

if ($provider === 'smartsupp' && $smartsuppKey !== ''):
?>
<script>
(function() {
  if (window.__bbLiveChatLoaded) return;
  window.__bbLiveChatLoaded = true;
  window._smartsupp = window._smartsupp || {};
  window._smartsupp.key = <?php echo json_encode($smartsuppKey, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
  window._smartsupp.widget = {
    colors: {
      primary: '#4b8eff',
      secondary: '#081422'
    }
  };
  window.smartsupp || (function(d) {
    var s, c, o = window.smartsupp = function() { o._.push(arguments); };
    o._ = [];
    s = d.getElementsByTagName('script')[0];
    c = d.createElement('script');
    c.type = 'text/javascript';
    c.charset = 'utf-8';
    c.async = true;
    c.src = 'https://www.smartsuppchat.com/loader.js?';
    s.parentNode.insertBefore(c, s);
  })(document);
})();
</script>
<noscript>Powered by <a href="https://www.smartsupp.com" target="_blank" rel="noopener">Smartsupp</a></noscript>
<?php
elseif ($provider === 'jivo' && $jivoWidgetId !== ''):
    // Accept bare widget ID or a pasted Jivo install snippet/URL.
    $jivoId = $jivoWidgetId;
    if (preg_match('#code\.jivosite\.com/(?:script/)?widget/([A-Za-z0-9_-]+)#i', $jivoWidgetId, $m)) {
        $jivoId = $m[1];
    } elseif (preg_match('#(?:jv-id|data-jv-id)=[\'"]?([A-Za-z0-9_-]+)#i', $jivoWidgetId, $m)) {
        $jivoId = $m[1];
    } elseif (preg_match('#widget_id\s*=\s*[\'"]?([A-Za-z0-9_-]+)#i', $jivoWidgetId, $m)) {
        $jivoId = $m[1];
    }
    $jivoId = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $jivoId);
    if ($jivoId !== ''):
        // Official install forms use either /widget/{id} or /script/widget/{id}.
        // Current async codes prefer https://code.jivosite.com/widget/{id}
?>
<script>
(function(){
  if (window.__bbLiveChatLoaded) return;
  window.__bbLiveChatLoaded = true;
  var s = document.createElement('script');
  s.src = <?php echo json_encode('https://code.jivosite.com/widget/' . $jivoId, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
  s.async = true;
  document.getElementsByTagName('head')[0].appendChild(s);
})();
</script>
<?php
    endif;
endif;
?>
