<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';
require_once __DIR__ . '/../../includes/userPostsPage.php';

requirePermission($pdo, 'manage_posts');

$currentUser = requireVerifiedUser($pdo);

$userId = isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0;

[$viewedUser, $posts, $postImages] = loadUserPostsPageOrFail($pdo, $userId);

require __DIR__ . '/../../views/admin/user_posts_view.php';