<?php

require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';
require_once __DIR__ . '/../../includes/allPostsPage.php';

requirePermission($pdo, 'view_posts');

$currentUser = requireVerifiedUser($pdo);

const MODERATOR_POSTS_PER_PAGE = 3;

$requestedPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

[$posts, $postImages, $currentPage, $totalPages] = loadAllPostsPage($pdo, $requestedPage, MODERATOR_POSTS_PER_PAGE);

require __DIR__ . '/../../views/moderator/all_posts_view.php';