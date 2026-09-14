<?php

require_once __DIR__ . '/error_page.php';

define('PROFILE_PICTURE_DIR', __DIR__ . '/../assets/uploads/profile_pictures/');
define('PROFILE_PICTURE_URL', '/assets/uploads/profile_pictures/');
define('PROFILE_PICTURE_MAX_BYTES', 3 * 1024 * 1024); // 3 MB

function handleProfilePictureUpload(array $file, int $userId): array
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'error' => 'Please choose an image to upload.'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload failed. Please try again.'];
    }

    if ($file['size'] > PROFILE_PICTURE_MAX_BYTES) {
        return ['success' => false, 'error' => 'Image must be smaller than 3MB.'];
    }

    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return ['success' => false, 'error' => 'The uploaded file is not a valid image.'];
    }

    $allowedMimeToExt = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    $mime = $imageInfo['mime'];
    if (!isset($allowedMimeToExt[$mime])) {
        return ['success' => false, 'error' => 'Only JPG, PNG, GIF, and WEBP images are allowed.'];
    }

    if (!is_dir(PROFILE_PICTURE_DIR)) {
        mkdir(PROFILE_PICTURE_DIR, 0755, true);
    }

    $extension = $allowedMimeToExt[$mime];
    $filename = 'user_' . $userId . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    $destination = PROFILE_PICTURE_DIR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => false, 'error' => 'Could not save the uploaded file.'];
    }

    return ['success' => true, 'filename' => $filename];
}

function deleteProfilePictureFile(?string $filename): void
{
    if (!$filename) {
        return;
    }

    $path = PROFILE_PICTURE_DIR . $filename;
    if (is_file($path)) {
        unlink($path);
    }
}

function profilePictureUrl(?string $filename): ?string
{
    return $filename ? PROFILE_PICTURE_URL . $filename : null;
}