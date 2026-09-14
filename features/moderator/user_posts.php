<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';
require_once __DIR__ . '/../../repositories/postRepository.php';
require_once __DIR__ . '/../../repositories/postImageRepository.php';

requirePermission($pdo, 'view_posts');

$currentUser = requireVerifiedUser($pdo);

$userId = isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0;

if ($userId <= 0 || !userExists($pdo, $userId)) {
    renderErrorPage(404, '404 Not Found');
}

$viewedUser = findUserById($pdo, $userId);

$posts = getPostsByUserId($pdo, $userId);

$postIds = array_column($posts, 'id');
$postImages = getImagesForPosts($pdo, $postIds);

require __DIR__ . '/../../views/moderator/user_posts_view.php';