<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';
require_once __DIR__ . '/../../repositories/postRepository.php';
require_once __DIR__ . '/../../repositories/postImageRepository.php';

$currentUser = requireVerifiedUser($pdo);

const POSTS_PER_PAGE = 3;

$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($currentPage < 1) {
    $currentPage = 1;
}

$totalPosts = countAllPosts($pdo);
$totalPages = (int) max(1, ceil($totalPosts / POSTS_PER_PAGE));

if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

$offset = ($currentPage - 1) * POSTS_PER_PAGE;

$posts = getPostsPageWithAuthor($pdo, POSTS_PER_PAGE, $offset);

$postIds = array_column($posts, 'id');
$postImages = getImagesForPosts($pdo, $postIds);

require __DIR__ . '/../../views/posts/posts_view.php';