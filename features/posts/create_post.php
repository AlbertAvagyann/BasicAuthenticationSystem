<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';
require_once __DIR__ . '/../../repositories/postRepository.php';
require_once __DIR__ . '/../../repositories/postImageRepository.php';

$currentUser = requireVerifiedUser($pdo);

$errors = [];
$title = '';
$content = '';

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

    if (empty($errors)) {
        $postId = createPost($pdo, (int) $currentUser['id'], $title, $content);

        if (!empty($_FILES['images'])) {
            $result = handlePostImagesUpload($_FILES['images'], $postId);

            if (!$result['success']) {
                $errors[] = $result['error'];
            } elseif (!empty($result['filenames'])) {
                insertPostImages($pdo, $postId, $result['filenames']);
            }
        }

        if (empty($errors)) {
            header('Location: /features/posts/view_post.php?id=' . $postId . '&created=1');
            exit;
        }
    }
}

require __DIR__ . '/../../views/posts/create_post_view.php';