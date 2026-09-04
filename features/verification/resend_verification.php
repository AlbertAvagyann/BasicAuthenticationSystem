<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/tokens.php';
require __DIR__ . '/../../includes/mailer.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /features/verification/verify_notice.php');
    exit;
}

$stmt = $pdo->prepare('SELECT id, name, email, email_verified_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['email_verified_at'] !== null) {
    header('Location: /features/dashboard/dashboard.php');
    exit;
}

$token = generateToken();
$tokenExpiresAt = expiresInMinutes(60);

$update = $pdo->prepare('UPDATE users SET verification_token = ?, verification_token_expires_at = ? WHERE id = ?');
$update->execute([$token['hash'], $tokenExpiresAt, $user['id']]);

sendVerificationEmail($user['email'], $user['name'], $token['raw']);

header('Location: /features/verification/verify_notice.php?sent=1');
exit;
