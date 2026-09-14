<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/error_page.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';
require_once __DIR__ . '/../../repositories/postRepository.php';
require_once __DIR__ . '/../../repositories/postImageRepository.php';

$currentUser = requireVerifiedUser($pdo);

$postId = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if ($postId <= 0) {
    renderErrorPage(400, 'Invalid post.');
}

$post = findPostById($pdo, $postId);

if (!$post) {
    renderErrorPage(404, 'Post not found.');
}

if ((int) $post['user_id'] !== (int) $currentUser['id'] && !can($pdo, $currentUser['id'], 'manage_posts')) {
    renderErrorPage(403, 'You can only edit your own posts.');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();

    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $errors[] = 'Title and content are required.';
    }

    if (strlen($title) > 255) {
        $errors[] = 'Title must be under 255 characters.';
    }

    if (empty($errors) && !empty($_FILES['images'])) {
        $result = handlePostImagesUpload($_FILES['images'], $postId);

        if (!$result['success']) {
            $errors[] = $result['error'];
        } elseif (!empty($result['filenames'])) {
            insertPostImages($pdo, $postId, $result['filenames']);
        }
    }

    if (empty($errors)) {
        updatePost($pdo, $postId, $title, $content);
        header('Location: /features/posts/view_post.php?id=' . $postId . '&updated=1');
        exit;
    }

    $post['title'] = $title;
    $post['content'] = $content;
}

$images = getImagesByPostId($pdo, $postId);

require __DIR__ . '/../../views/posts/edit_post_view.php';