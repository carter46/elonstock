<?php
$pageTitle = $pageTitle ?? (get_site_name() . ' | Admin');
?>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="theme-color" content="#081422"/>
<title><?php echo htmlspecialchars($pageTitle); ?></title>
<?php if (function_exists('output_favicon_tags')) { output_favicon_tags(); } ?>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet"/>
<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "on-background": "#d7e3f7",
        "surface-dim": "#081422",
        "primary-container": "#c41e0a",
        "on-surface": "#d7e3f7",
        "text-secondary": "#c1c6d7",
        "text-primary": "#FFFFFF",
        "on-surface-variant": "#c1c6d7",
        "surface-container-low": "#111c2b",
        "surface-container-high": "#1f2b3a",
        "surface-container": "#15202f",
        "surface-container-highest": "#2a3645",
        "surface-container-lowest": "#040f1d",
        "border-low": "rgba(255, 255, 255, 0.08)",
        "primary": "#ff8a5c",
        "on-primary": "#ffffff",
        "on-primary-container": "#ffffff",
        "success": "#20B26C",
        "critical": "#EF454A",
        "bg-subtle": "#111c2b",
        "surface": "#081422",
        "surface-bright": "#2f3a49",
        "error-container": "#93000a",
        "on-error": "#690005",
        "error": "#ffb4ab",
        "outline": "#8b90a0"
      },
      borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
      spacing: {
        "margin-desktop": "32px",
        "margin-mobile": "16px",
        "gutter": "16px",
        "container-max": "1440px",
        "section-padding": "96px"
      },
      fontFamily: {
        "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
        "headline-md": ["Plus Jakarta Sans", "sans-serif"],
        "body-md": ["Inter", "sans-serif"],
        "body-lg": ["Inter", "sans-serif"],
        "label-xs": ["Inter", "sans-serif"],
        "label-sm": ["Inter", "sans-serif"],
        "data-mono": ["Inter", "sans-serif"],
        "display": ["Plus Jakarta Sans", "sans-serif"]
      },
      fontSize: {
        "headline-lg": ["32px", {"lineHeight": "1.2", "fontWeight": "700"}],
        "headline-md": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}],
        "body-md": ["16px", {"lineHeight": "1.5", "fontWeight": "400"}],
        "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
        "label-xs": ["12px", {"lineHeight": "1", "letterSpacing": "0.1em", "fontWeight": "800"}],
        "label-sm": ["14px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "700"}],
        "data-mono": ["16px", {"lineHeight": "1", "letterSpacing": "-0.02em", "fontWeight": "500"}],
        "display": ["64px", {"lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "800"}]
      }
    }
  }
};
</script>
<style>
body.admin-dashboard {
  background-color: #071321;
  color: #d7e3f7;
  font-family: 'Inter', sans-serif;
  -webkit-font-smoothing: antialiased;
}
.glass-panel {
  background: rgba(16, 27, 51, 0.4);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
}
.material-symbols-outlined {
  font-family: 'Material Symbols Outlined';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-smoothing: antialiased;
  font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
  vertical-align: middle;
}
.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-smoothing: antialiased;
  vertical-align: middle;
}
.material-icons-round {
  font-family: 'Material Icons Round';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-smoothing: antialiased;
  vertical-align: middle;
}
.admin-dash-main {
  padding-top: calc(5rem + env(safe-area-inset-top, 0px));
  box-sizing: border-box;
}
.admin-dash-content {
  max-width: 1440px;
  margin-left: auto;
  margin-right: auto;
  width: 100%;
}
.admin-topbar {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  z-index: 50;
  padding-top: env(safe-area-inset-top, 0px);
  min-height: calc(4rem + env(safe-area-inset-top, 0px));
  height: calc(4rem + env(safe-area-inset-top, 0px));
}
@media (min-width: 1024px) {
  .admin-topbar {
    left: 16rem;
  }
}
.admin-scrollbar::-webkit-scrollbar { width: 4px; }
.admin-scrollbar::-webkit-scrollbar-track { background: #081422; }
.admin-scrollbar::-webkit-scrollbar-thumb { background: #2a3645; border-radius: 10px; }
.admin-dashboard input:not([type=checkbox]):not([type=radio]):not([type=file]),
.admin-dashboard select,
.admin-dashboard textarea {
  background-color: #111c2b;
  border-color: rgba(255, 255, 255, 0.08);
  color: #d7e3f7;
}
.admin-dashboard input::placeholder,
.admin-dashboard textarea::placeholder { color: rgba(193, 198, 215, 0.45); }
.admin-dashboard .bg-white,
.admin-dashboard .dark\:bg-zinc-900,
.admin-dashboard .bg-white.dark\:bg-white\/5 {
  background: rgba(16, 27, 51, 0.4) !important;
  backdrop-filter: blur(12px);
}
.admin-dashboard .border-slate-200,
.admin-dashboard .dark\:border-zinc-800,
.admin-dashboard .border-primary\/10,
.admin-dashboard .divide-primary\/5 > :not([hidden]) ~ :not([hidden]) {
  border-color: rgba(255, 255, 255, 0.08) !important;
}
.admin-dashboard .text-slate-500,
.admin-dashboard .dark\:text-zinc-400,
.admin-dashboard .text-slate-400 { color: #c1c6d7 !important; }
.admin-dashboard .text-slate-900,
.admin-dashboard .dark\:text-slate-100,
.admin-dashboard .text-slate-700,
.admin-dashboard .dark\:text-zinc-300 { color: #d7e3f7 !important; }
.admin-dashboard .bg-slate-50,
.admin-dashboard .dark\:bg-zinc-800,
.admin-dashboard .bg-background-light,
.admin-dashboard .dark\:bg-white\/5 { background-color: #111c2b !important; }
.admin-dashboard .bg-primary:not(.admin-sidebar-active) {
  background: linear-gradient(135deg, #ff5c1a 0%, #c41e0a 55%, #8b0000 100%) !important;
  background-color: #c41e0a !important;
  color: #ffffff !important;
}
.admin-dashboard .bg-primary.text-black,
.admin-dashboard .bg-primary.text-zinc-900,
.admin-dashboard .bg-primary.text-slate-900,
.admin-dashboard button.bg-primary,
.admin-dashboard a.bg-primary {
  color: #ffffff !important;
}
.admin-dashboard .text-amber-500,
.admin-dashboard .text-amber-400,
.admin-dashboard .text-yellow-500 { color: #ff8a5c !important; }
.admin-dashboard .bg-amber-500,
.admin-dashboard .bg-yellow-500 { background-color: #c41e0a !important; }
.admin-dashboard .border-amber-500\/30,
.admin-dashboard .border-yellow-500\/30 { border-color: rgba(255, 92, 26, 0.3) !important; }
.premium-gradient-btn,
.admin-dashboard .premium-gradient-btn {
  background: linear-gradient(135deg, #ff5c1a 0%, #c41e0a 55%, #8b0000 100%);
  box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
  color: #ffffff;
}
.text-brand-gradient,
.gradient-text {
  background: linear-gradient(135deg, #ff8a3d 0%, #ff5c1a 45%, #e03d00 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  -webkit-text-fill-color: transparent;
}
</style>
<?php if (!empty($pageExtraStyles)) { echo $pageExtraStyles; } ?>
