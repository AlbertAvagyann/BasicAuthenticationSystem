<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';

requirePermission($pdo, 'access_admin_page');
$user = requireVerifiedUser($pdo);
require __DIR__ . '/../../views/admin/admin_view.php';