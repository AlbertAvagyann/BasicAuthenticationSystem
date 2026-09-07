<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
requirePermission($pdo, 'view_dashboard');

$user = requireVerifiedUser($pdo);

$stmt = $pdo->prepare('SELECT id, name, email, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

require __DIR__ . '/../../views/dashboard/dashboard_view.php';