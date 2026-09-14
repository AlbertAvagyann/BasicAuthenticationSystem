<?php

require_once __DIR__ . '/error_page.php';
require_once __DIR__ . '/../repositories/userRepository.php';
require_once __DIR__ . '/../repositories/postRepository.php';
require_once __DIR__ . '/../repositories/postImageRepository.php';

function loadUserPostsPageOrFail(PDO $pdo, int $userId): array
{
    if ($userId <= 0 || !userExists($pdo, $userId)) {
        renderErrorPage(404, '404 Not Found');
    }

    $viewedUser = findUserById($pdo, $userId);
    $posts = getPostsByUserId($pdo, $userId);

    $postIds = array_column($posts, 'id');
    $postImages = getImagesForPosts($pdo, $postIds);

    return [$viewedUser, $posts, $postImages];
}