<?php
$siteName = $siteName ?? get_site_name();
$pageTitle = $pageTitle ?? ($siteName . ' | Command Center');
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<?php require __DIR__ . '/admin-head.php'; ?>
</head>
<body class="admin-dashboard font-body-md text-body-md min-h-screen overflow-x-hidden custom-scrollbar">
<?php include __DIR__ . '/admin-sidebar.php'; ?>
<?php include __DIR__ . '/admin-header.php'; ?>
<main class="admin-dash-main relative z-10 min-h-screen w-full lg:ml-64 lg:w-[calc(100%-16rem)] px-4 md:px-margin-desktop pb-6 md:pb-10">
<div class="admin-dash-content">
<?php if (!empty($_SESSION['auto_migration_errors'])): ?>
<div class="mb-4 rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
<strong class="font-semibold">Database update issues:</strong>
<ul class="mt-2 list-disc list-inside space-y-1">
<?php foreach ((array) $_SESSION['auto_migration_errors'] as $err): ?>
<li><?php echo htmlspecialchars((string) $err); ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php unset($_SESSION['auto_migration_errors']); endif; ?>
<?php if (!empty($_SESSION['auto_migration_success'])): ?>
<div class="mb-4 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
<strong class="font-semibold">Database updated:</strong>
<ul class="mt-2 list-disc list-inside space-y-1">
<?php foreach ((array) $_SESSION['auto_migration_success'] as $ok): ?>
<li><?php echo htmlspecialchars((string) $ok); ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php unset($_SESSION['auto_migration_success']); endif; ?>
