<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';

requirePermission($pdo, 'view_users');

$user = requireVerifiedUser($pdo);

$users = getAllUsersWithRoles($pdo);

require __DIR__ . '/../../views/moderator/users_view.php';