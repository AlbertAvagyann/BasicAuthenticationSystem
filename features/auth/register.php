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

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors[] = 'This email is already registered.';
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare(
                'INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)'
            );

            $stmt->execute([
                $name,
                $email,
                $hashedPassword
            ]);

            $userId = $pdo->lastInsertId();

            session_regenerate_id(true);
            $_SESSION['pending_verification_user_id'] = $userId;

            header('Location: ../../features/auth/registration_success.php');
            exit;
        } catch (PDOException $e) {
            // Catches the race condition where two requests pass the
            // uniqueness check above at the same time. Requires a
            // UNIQUE constraint on users.email at the database level.
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