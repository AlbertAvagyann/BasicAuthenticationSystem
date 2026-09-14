<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/uploads.php';
require_once __DIR__ . '/../../repositories/profileRepository.php';
require_once __DIR__ . '/../../repositories/postRepository.php';
require_once __DIR__ . '/../../repositories/postImageRepository.php';
require_once __DIR__ . '/../../includes/postImageUploads.php';

$currentUser = requireVerifiedUser($pdo);

$targetUserId = isset($_GET['id']) ? (int) $_GET['id'] : (int) $currentUser['id'];

if ($targetUserId <= 0) {
    renderErrorPage(400, 'Invalid user.');
}

$profileUser = findUserById($pdo, $targetUserId);

if (!$profileUser) {
    renderErrorPage(404, 'User not found.');
}
$profile = findProfileByUserId($pdo, $targetUserId);
$posts = getPostsByUserId($pdo, $targetUserId);
$postIds = array_column($posts, 'id');
$postImages = getImagesForPosts($pdo, $postIds);
$isOwnProfile = $targetUserId === (int) $currentUser['id'];

$fullName = trim(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? ''));
$displayName = $fullName !== '' ? $fullName : $profileUser['name'];
$initial = strtoupper(substr($profileUser['name'], 0, 1));
$pictureUrl = profilePictureUrl($profile['profile_picture'] ?? null);

require __DIR__ . '/../../views/profile/profile_view.php';