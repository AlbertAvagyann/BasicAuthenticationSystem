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

$profile = findProfileByUserId($pdo, $userId);

if ($profile && $profile['profile_picture']) {
    deleteProfilePictureFile($profile['profile_picture']);
    updateProfilePicture($pdo, $userId, null);
}

header('Location: /features/profile/view_profile.php?picture_removed=1');
exit;