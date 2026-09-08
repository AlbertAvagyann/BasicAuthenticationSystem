<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';

requirePermission($pdo, 'manage_users');

requireVerifiedUser($pdo);

requireCsrf();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /features/admin/users.php');
    exit;
}

$userId = filter_input(
    INPUT_POST,
    'user_id',
    FILTER_VALIDATE_INT
);

if (!$userId) {
    header('Location: /features/admin/users.php');
    exit;
}

if ($userId === (int) $_SESSION['user_id']) {
    exit('You cannot delete your own account.');
}

$stmt = $pdo->prepare(
    'DELETE FROM users WHERE id = ?'
);

$stmt->execute([$userId]);

header('Location: /features/admin/users.php');
exit;