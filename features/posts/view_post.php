<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/error_page.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';
require_once __DIR__ . '/../../repositories/postRepository.php';
require_once __DIR__ . '/../../repositories/postImageRepository.php';

$currentUser = requireVerifiedUser($pdo);

$postId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($postId <= 0) {
    renderErrorPage(400, 'Invalid post.');
}

$post = findPostById($pdo, $postId);

if (!$post) {
    renderErrorPage(404, 'Post not found.');
}

$isOwner = (int) $post['user_id'] === (int) $currentUser['id'];
$canManagePost = $isOwner || can($pdo, $currentUser['id'], 'manage_posts');
$images = getImagesByPostId($pdo, $postId);

require __DIR__ . '/../../views/posts/view_post_view.php';