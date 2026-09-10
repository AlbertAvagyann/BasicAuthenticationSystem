<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';

requirePermission($pdo, 'manage_users');

$user = requireVerifiedUser($pdo);

$users = getAllUsersWithRoles($pdo);
$roles = getAllRoles($pdo);

require __DIR__ . '/../../views/admin/users_view.php';