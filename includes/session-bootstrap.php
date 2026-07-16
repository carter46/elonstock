<?php
/**
 * Bloombit - Session Bootstrap
 * Call on every page/API that uses session. Starts session and enforces 15-minute inactivity timeout for logged-in users.
 */

if (PHP_SAPI === 'cli') {
    return;
}

if (session_status() === PHP_SESSION_NONE) {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (string) $_SERVER['SERVER_PORT'] === '443')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $timeout = 900; // 15 minutes
    $last = $_SESSION['last_activity'] ?? time();
    if (time() - $last > $timeout) {
        $_SESSION = [];
        if (!headers_sent()) {
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params['path'] ?: '/', $params['domain'] ?? '', (bool) ($params['secure'] ?? false), (bool) ($params['httponly'] ?? true));
            }
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_destroy();
            }
            header('Location: /login?timeout=1');
            exit;
        }
        // Headers already sent: keep request logged out without redirect.
        return;
    }
    $_SESSION['last_activity'] = time();
}
