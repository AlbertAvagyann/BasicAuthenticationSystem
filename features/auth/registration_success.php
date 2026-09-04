<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';

if (isLoggedIn()) {
    header('Location: ../../features/dashboard/dashboard.php');
    exit;
}

if (!isset($_SESSION['pending_verification_user_id'])) {
    header('Location: ../../features/auth/register.php');
    exit;
}

require __DIR__ . '/../../views/auth/registration_success_view.php';