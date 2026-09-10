<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';

requireLogin();

$user = findUserById($pdo, (int) $_SESSION['user_id']);

if ($user['email_verified_at'] !== null) {
    header('Location: /features/dashboard/dashboard.php');
    exit;
}
$resent = isset($_GET['sent']);
require __DIR__ . '/../../views/verification/verify_notice_view.php';