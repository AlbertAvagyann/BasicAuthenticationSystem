<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/mailer.php';
require __DIR__ . '/../../includes/tokens.php';
require __DIR__ . '/../../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /features/auth/registration_success.php');
    exit;
}

requireCsrf();

$userId = $_SESSION['pending_verification_user_id'] ?? $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: /features/auth/register.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT id, name, email, email_verified_at, last_verification_request_at
     FROM users
     WHERE id = ?'
);

$stmt->execute([$userId]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    unset($_SESSION['pending_verification_user_id']);

    header('Location: /features/auth/register.php');
    exit;
}

if ($user['email_verified_at'] !== null) {
    unset($_SESSION['pending_verification_user_id']);

    header('Location: /features/auth/login.php?verified=1');
    exit;
}

if (isThrottled($user['last_verification_request_at'])) {
    $seconds = throttleRemainingSeconds($user['last_verification_request_at']);
    //die("THROTTLED: {$seconds} seconds remaining");

    header('Location: /features/auth/registration_success.php?throttled=' . $seconds);
    exit;
}

$token = generateToken();
$tokenExpiresAt = expiresInMinutes(60);

$update = $pdo->prepare(
    'UPDATE users
     SET verification_token = ?,
         verification_token_expires_at = ?,
         last_verification_request_at = NOW()
     WHERE id = ?'
);

$update->execute([
    $token['hash'],
    $tokenExpiresAt,
    $user['id']
]);

sendVerificationEmail(
    $user['email'],
    $user['name'],
    $token['raw']
);

header('Location: /features/auth/registration_success.php?sent=1');
exit;