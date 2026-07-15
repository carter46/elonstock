<?php
/**
 * Opens user dashboard shell: html, body, sidebar, topbar, main.
 * Matches institutional terminal sample structure.
 */
$siteName = $siteName ?? get_site_name();
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<?php require __DIR__ . '/user-head.php'; ?>
</head>
<body class="user-dashboard font-body-md text-on-background bg-surface-dim min-h-screen overflow-x-hidden">
<div class="noise-overlay" aria-hidden="true"></div>
<?php include __DIR__ . '/user-sidebar.php'; ?>
<main class="user-dash-main relative z-10 min-h-screen w-full min-w-0 max-w-full overflow-x-clip flex flex-col lg:ml-64 lg:w-[calc(100%-16rem)]">
<?php include __DIR__ . '/user-header.php'; ?>
<div class="user-dash-content p-4 md:p-8 max-w-[1600px] w-full mx-auto flex-1 min-w-0 space-y-8">
