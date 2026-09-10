<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/login_throttle.php';

if (isLoggedIn()) {
    header('Location: ../../features/dashboard/dashboard.php');
    exit;
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email and password are required.';
    }

    if (empty($errors)) {
        $user = findUserByEmail($pdo, $email);

        if ($user && isAccountLocked($user)) {
            $minutes = (int) ceil(lockoutRemainingSeconds($user) / 60);
            $errors[] = "Too many failed attempts. Please try again in {$minutes} minute(s).";
        } elseif (!$user || !password_verify($password, $user['password'])) {
            if ($user) {
                registerFailedLogin($pdo, (int) $user['id'], (int) $user['failed_login_attempts']);
            }
            $errors[] = 'Incorrect email or password.';
        } else {
            resetFailedLogins($pdo, (int) $user['id']);
            session_regenerate_id(true);

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            if ($user['email_verified_at'] === null) {
                header('Location: ../../features/verification/verify_notice.php');
                exit;
            }

            header('Location: ../../features/dashboard/dashboard.php');
            exit;
        }
    }
}

require __DIR__ . '/../../views/auth/login_view.php';