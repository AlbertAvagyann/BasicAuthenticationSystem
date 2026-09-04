<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/tokens.php';

$status = 'error';
$message = '';
$rawToken = $_GET['token'] ?? '';

if ($rawToken === '') {
    $message = 'Missing verification token.';
} else {
    $hashedToken = hashToken($rawToken);
    $stmt = $pdo->prepare('SELECT id, email_verified_at, verification_token_expires_at FROM users WHERE verification_token = ?');
    $stmt->execute([$hashedToken]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $message = 'This verification link is invalid or has already been used.';
    } elseif (isExpired($user['verification_token_expires_at'])) {
        $status = 'expired';
        $message = 'This verification link has expired.';
    } else {
        $update = $pdo->prepare(
            'UPDATE users SET email_verified_at = NOW(), verification_token = NULL, verification_token_expires_at = NULL WHERE id = ?'
        );
        $update->execute([$user['id']]);
        unset($_SESSION['pending_verification_user_id']);
        $status = 'success';
        $message = 'Your email has been verified. You can now log in.';
    }
}

require __DIR__ . '/../../views/verification/verify_email_view.php';