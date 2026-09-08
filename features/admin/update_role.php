<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
requirePermission($pdo, 'manage_users');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /features/admin/users.php');
    exit;
}

requireCsrf();

$targetUserId = (int) ($_POST['user_id'] ?? 0);
$newRoleId = (int) ($_POST['role_id'] ?? 0);
if ($targetUserId <= 0 || $newRoleId <= 0) {
    http_response_code(400);
    exit('Invalid request.');
}

if ($targetUserId === (int) $_SESSION['user_id']) {
    http_response_code(400);
    exit('You cannot change your own role.');
}

$stmt = $pdo->prepare('SELECT id FROM users WHERE id = ?');
$stmt->execute([$targetUserId]);
if (!$stmt->fetch()) {
    http_response_code(404);
    exit('User not found.');
}
$stmt = $pdo->prepare('SELECT id FROM roles WHERE id = ?');
$stmt->execute([$newRoleId]);
if (!$stmt->fetch()) {
    http_response_code(400);
    exit('Invalid role.');
}
$stmt = $pdo->prepare('UPDATE users SET role_id = ? WHERE id = ?');
$stmt->execute([$newRoleId, $targetUserId]);

header('Location: /features/admin/users.php');
exit;