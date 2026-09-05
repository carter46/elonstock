<?php
/**
 * Bloombit - Admin-Only Access Guard
 * Include at top of admin dashboard pages. Redirects non-admins to user dashboard.
 * Depends on auth-check for login.
 * Also runs pending database auto-migrations (idempotent, once per request).
 */
require_once __DIR__ . '/auth-check.php';

if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: /dashboard/user/dashboard');
    exit;
}

try {
    require_once __DIR__ . '/database-auto-migrate.php';
    runAdminDatabaseAutoMigrations($_SESSION['user_id'] ?? null);
} catch (Throwable $migrateError) {
    $_SESSION['auto_migration_errors'] = [
        'Auto-migration runner failed: ' . $migrateError->getMessage(),
    ];
    error_log('admin-check auto-migrate error: ' . $migrateError->getMessage());
}
