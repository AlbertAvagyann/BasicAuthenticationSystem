<?php

require_once __DIR__ . '/csrf.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax',
    ]);
    session_start();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /features/auth/login.php');
        exit;
    }
}

function requireVerifiedUser(PDO $pdo): array
{
    requireLogin();

    $stmt = $pdo->prepare('SELECT id, name, email, email_verified_at FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        session_destroy();
        header('Location: /features/auth/login.php');
        exit;
    }

    if ($user['email_verified_at'] === null) {
        header('Location: /features/verification/verify_notice.php');
        exit;
    }

    return $user;
}