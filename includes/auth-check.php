<?php
/**
 * Bloombit - Server-side Auth Guard
 * Include at top of protected dashboard pages. Redirects to /login if not authenticated.
 */

require_once __DIR__ . '/session-bootstrap.php';
if (!isset($_SESSION['user_id'])) {
    $redirect = '/login?redirect=' . urlencode($_SERVER['REQUEST_URI'] ?? '/dashboard');
    header('Location: ' . $redirect);
    exit;
}
