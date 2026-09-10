<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/error_page.php';

requirePermission($pdo, 'manage_users');
requireVerifiedUser($pdo);

$targetUserId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$targetUserId) {
    header('Location: /features/admin/users.php');
    exit;
}

$targetUser = findUserById($pdo, $targetUserId);

if (!$targetUser) {
    renderErrorPage(404, 'User not found.');
}

$roles = getAllRoles($pdo);

require __DIR__ . '/../../views/admin/edit_user_view.php';