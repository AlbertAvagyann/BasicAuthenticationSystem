<?php
require_once __DIR__ . '/../repositories/postRepository.php';
require_once __DIR__ . '/../repositories/postImageRepository.php';
const ALL_POSTS_PER_PAGE_DEFAULT = 10;

function loadAllPostsPage(PDO $pdo, int $requestedPage, int $perPage = ALL_POSTS_PER_PAGE_DEFAULT): array
{
    $currentPage = $requestedPage < 1 ? 1 : $requestedPage;

    $totalPosts = countAllPosts($pdo);
    $totalPages = (int) max(1, ceil($totalPosts / $perPage));

    if ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    $offset = ($currentPage - 1) * $perPage;

    $posts = getPostsPageWithAuthor($pdo, $perPage, $offset);

    $postIds = array_column($posts, 'id');
    $postImages = getImagesForPosts($pdo, $postIds);

    return [$posts, $postImages, $currentPage, $totalPages];
}