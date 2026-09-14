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

$postId = (int) ($_POST['id'] ?? 0);
$post = findPostById($pdo, $postId);

if (!$post) {
    renderErrorPage(404, 'Post not found.');
}

if ((int) $post['user_id'] !== (int) $currentUser['id'] && !can($pdo, $currentUser['id'], 'manage_posts')) {
    renderErrorPage(403, 'You can only delete your own posts.');
}

$filenames = deleteImagesByPostId($pdo, $postId);
foreach ($filenames as $filename) {
    deletePostImageFile($filename);
}

deletePostById($pdo, $postId);

$redirectTo = $_POST['redirect'] ?? '/features/posts/posts.php';
if (!is_string($redirectTo) || $redirectTo[0] !== '/' || str_starts_with($redirectTo, '//')) {
    $redirectTo = '/features/posts/posts.php';
}

$separator = str_contains($redirectTo, '?') ? '&' : '?';
header('Location: ' . $redirectTo . $separator . 'deleted=1');
exit;