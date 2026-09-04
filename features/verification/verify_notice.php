<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';

requireLogin();
$stmt = $pdo->prepare('SELECT id, name, email, email_verified_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['email_verified_at'] !== null) {
    header('Location: /features/dashboard/dashboard.php');
    exit;
}
$resent = isset($_GET['sent']);
require __DIR__ . '/../../views/verification/verify_notice_view.php';