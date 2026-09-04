<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';

if (isLoggedIn()) {
    header('Location: ../../features/dashboard/dashboard.php');
    exit;
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email and password are required.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, name, email, password,email_verified_at FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Incorrect email or password.';
        } else {

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
