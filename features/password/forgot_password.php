<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/tokens.php';
require __DIR__ . '/../../includes/mailer.php';

$errors = [];
$submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, name, email, last_password_reset_request_at FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && !isThrottled($user['last_password_reset_request_at'])) {
            $token = generateToken();
            $tokenExpiresAt = expiresInMinutes(30);
            $update = $pdo->prepare(
                'UPDATE users
                 SET password_reset_token = ?,
                     password_reset_token_expires_at = ?,
                     last_password_reset_request_at = NOW()
                 WHERE id = ?'
            );
            $update->execute([$token['hash'], $tokenExpiresAt, $user['id']]);
            sendPasswordResetEmail($user['email'], $user['name'], $token['raw']);
        }
        $submitted = true;
    }
}

require __DIR__ . '/../../views/password/forgot_password_view.php';