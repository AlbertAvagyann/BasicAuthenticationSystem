<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/tokens.php';
require __DIR__ . '/../../repositories/verificationRepository.php';

$status = 'error';
$message = '';
$rawToken = $_GET['token'] ?? '';

if ($rawToken === '') {
    $message = 'Missing verification token.';
} else {
    $hashedToken = hashToken($rawToken);
    $user = getUserByVerificationTokenHash($pdo, $hashedToken);

    if (!$user) {
        $message = 'This verification link is invalid or has already been used.';
    } elseif (isExpired($user['verification_token_expires_at'])) {
        $status = 'expired';
        $message = 'This verification link has expired.';
    } else {
        markEmailAsVerified($pdo, $user['id']);
        unset($_SESSION['pending_verification_user_id']);
        $status = 'success';
        $message = 'Your email has been verified. You can now log in.';
    }
}

require __DIR__ . '/../../views/verification/verify_email_view.php';