<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/tokens.php';
require __DIR__ . '/../../includes/mailer.php';
require __DIR__ . '/../../repositories/passwordResetRepository.php';

$errors = [];
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }

    if (empty($errors)) {
        $user = findUserByEmail($pdo, $email);

        if ($user && !isThrottled($user['last_password_reset_request_at'])) {
            $token = generateToken();
            $tokenExpiresAt = expiresInMinutes(30);

            setPasswordResetToken($pdo, $user['id'], $token['hash'], $tokenExpiresAt);

            sendPasswordResetEmail($user['email'], $user['name'], $token['raw']);
        }
        $submitted = true;
    }
}

require __DIR__ . '/../../views/password/forgot_password_view.php';