<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/uploads.php';
require_once __DIR__ . '/../../repositories/profileRepository.php';

$currentUser = requireVerifiedUser($pdo);
$userId = (int) $currentUser['id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /features/profile/edit_profile.php');
    exit;
}

requireCsrf();

$existingProfile = findProfileByUserId($pdo, $userId);
$oldPicture = $existingProfile['profile_picture'] ?? null;

$result = handleProfilePictureUpload($_FILES['profile_picture'] ?? [], $userId);

if (!$result['success']) {
    header('Location: /features/profile/edit_profile.php?picture_error=' . urlencode($result['error']));
    exit;
}

updateProfilePicture($pdo, $userId, $result['filename']);
deleteProfilePictureFile($oldPicture);

header('Location: /features/profile/view_profile.php?picture_updated=1');
exit;