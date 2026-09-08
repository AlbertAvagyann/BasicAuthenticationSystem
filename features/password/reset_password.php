<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/mailer.php';
require __DIR__ . '/../../includes/tokens.php';
require __DIR__ . '/../../includes/auth.php';

$errors = [];
$success = false;
$rawToken = $_POST['token'] ?? $_GET['token'] ?? '';
$user = null;

if ($rawToken !== '') {
    $stmt = $pdo->prepare('SELECT id, name, email, password_reset_token_expires_at FROM users WHERE password_reset_token = ?');
    $stmt->execute([hashToken($rawToken)]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

$tokenValid = $user !== null && !isExpired($user['password_reset_token_expires_at'] ?? null);

if (!$tokenValid) {
    $errors[] = $user === null
        ? 'This password reset link is invalid or has already been used.'
        : 'This password reset link has expired.';
}

if ($tokenValid && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $update = $pdo->prepare(
            'UPDATE users SET password = ?, password_reset_token = NULL, password_reset_token_expires_at = NULL WHERE id = ?'
        );
        $update->execute([$hashedPassword, $user['id']]);
        $success = true;
    }
}

require __DIR__ . '/../../views/password/reset_password_view.php';