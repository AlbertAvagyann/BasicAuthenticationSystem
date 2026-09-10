<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/tokens.php';
require __DIR__ . '/../../includes/mailer.php';
require __DIR__ . '/../../repositories/verificationRepository.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /features/verification/verify_notice.php');
    exit;
}

requireCsrf();

$user = findUserById($pdo, (int) $_SESSION['user_id']);

if ($user['email_verified_at'] !== null) {
    header('Location: /features/dashboard/dashboard.php');
    exit;
}

if (isThrottled($user['last_verification_request_at'])) {
    $seconds = throttleRemainingSeconds($user['last_verification_request_at']);
    header('Location: /features/verification/verify_notice.php?throttled=' . $seconds);
    exit;
}

$token = generateToken();
$tokenExpiresAt = expiresInMinutes(60);

setVerificationToken($pdo, $user['id'], $token['hash'], $tokenExpiresAt);

sendVerificationEmail($user['email'], $user['name'], $token['raw']);

header('Location: /features/verification/verify_notice.php?sent=1');
exit;