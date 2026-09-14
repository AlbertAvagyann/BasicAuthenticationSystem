<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/error_page.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';
require_once __DIR__ . '/../../repositories/postRepository.php';
require_once __DIR__ . '/../../repositories/postImageRepository.php';

$currentUser = requireVerifiedUser($pdo);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /features/posts/posts.php');
    exit;
}

requireCsrf();

$imageId = (int) ($_POST['image_id'] ?? 0);
$image = getImageById($pdo, $imageId);

if (!$image) {
    renderErrorPage(404, 'Image not found.');
}

$post = findPostById($pdo, (int) $image['post_id']);

if (!$post || ((int) $post['user_id'] !== (int) $currentUser['id'] && !can($pdo, $currentUser['id'], 'manage_posts'))) {
    renderErrorPage(403, 'You can only edit your own posts.');
}

deleteImageById($pdo, $imageId);
deletePostImageFile($image['filename']);

header('Location: /features/posts/edit_post.php?id=' . (int) $image['post_id']);
exit;