<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/tokens.php';

if (isLoggedIn()) {
    header('Location: ../../features/dashboard/dashboard.php');
    exit;
}

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $errors[] = 'All fields are required.';
    }

    if ($name !== '' && (str_contains($name, '@') || filter_var($name, FILTER_VALIDATE_EMAIL))) {
        $errors[] = 'Name cannot be an email address.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }

    if (empty($errors) && emailExists($pdo, $email)) {
        $errors[] = 'This email is already registered.';
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $userId = createUser($pdo, $name, $email, $hashedPassword);

            session_regenerate_id(true);
            $_SESSION['pending_verification_user_id'] = $userId;

            header('Location: ../../features/auth/registration_success.php');
            exit;
        } catch (PDOException $e) {
            if ((int) $e->getCode() === 23000 || str_contains($e->getMessage(), 'Duplicate entry')) {
                $errors[] = 'This email is already registered.';
            } else {
                error_log('Registration failed: ' . $e->getMessage());
                $errors[] = 'Something went wrong. Please try again.';
            }
        }
    }
}

require __DIR__ . '/../../views/auth/register_view.php';