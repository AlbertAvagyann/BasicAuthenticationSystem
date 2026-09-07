<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';

requirePermission($pdo, 'view_users');

$user = requireVerifiedUser($pdo);

$stmt = $pdo->query(
    'SELECT u.id, u.name, u.email, u.email_verified_at, u.created_at, r.id AS role_id, r.name AS role_name
     FROM users u
     JOIN roles r ON u.role_id = r.id
     ORDER BY u.id'
);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rolesStmt = $pdo->query('SELECT id, name FROM roles ORDER BY id');
$roles = $rolesStmt->fetchAll(PDO::FETCH_ASSOC);

$canManage = can($pdo, $_SESSION['user_id'], 'manage_users');

require __DIR__ . '/../../views/admin/users_view.php';