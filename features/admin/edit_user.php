<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/error_page.php';

requirePermission($pdo, 'manage_users');
requireVerifiedUser($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /features/admin/users.php');
    exit;
}

requireCsrf();

$targetUserId = (int) ($_POST['user_id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$emailVerified = isset($_POST['email_verified']);
$createdAtInput = trim($_POST['created_at'] ?? '');
$roleId = (int) ($_POST['role_id'] ?? 0);

if ($targetUserId <= 0 || $name === '' || $email === '' || $createdAtInput === '' || $roleId <= 0) {
    renderErrorPage(400, 'All fields are required.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    renderErrorPage(400, 'Invalid email format.');
}

$targetUser = findUserById($pdo, $targetUserId);

if (!$targetUser) {
    renderErrorPage(404, 'User not found.');
}

if (!roleExists($pdo, $roleId)) {
    renderErrorPage(400, 'Invalid role.');
}

if ($targetUserId === (int) $_SESSION['user_id'] && $roleId !== (int) $targetUser['role_id']) {
    renderErrorPage(400, 'You cannot change your own role.');
}

if (emailExistsForOtherUser($pdo, $email, $targetUserId)) {
    renderErrorPage(400, 'This email is already used by another user.');
}

$createdAtDateTime = new DateTime($createdAtInput);

if ($createdAtDateTime > new DateTime()) {
    renderErrorPage(400, 'Created date cannot be in the future.');
}

$createdAt = $createdAtDateTime->format('Y-m-d H:i:s');

if ($emailVerified) {
    $emailVerifiedAt = $targetUser['email_verified_at'] ?? date('Y-m-d H:i:s');
} else {
    $emailVerifiedAt = null;
}

updateUser($pdo, $targetUserId, $name, $email, $emailVerifiedAt, $createdAt, $roleId);

header('Location: /features/admin/users.php?updated=1');
exit;