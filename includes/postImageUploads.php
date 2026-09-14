<?php
require_once __DIR__ . '/error_page.php';

define('POST_IMAGE_DIR', __DIR__ . '/../assets/uploads/post_images/');
define('POST_IMAGE_URL', '/assets/uploads/post_images/');
define('POST_IMAGE_MAX_BYTES', 5 * 1024 * 1024); // 5 MB
function handlePostImagesUpload(array $filesInput, int $postId): array
{
    if (empty($filesInput['name']) || empty($filesInput['name'][0])) {
        return ['success' => true, 'filenames' => []];
    }

    $allowedMimeToExt = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    $count = count($filesInput['name']);
    $filenames = [];

    for ($i = 0; $i < $count; $i++) {
        if ($filesInput['error'][$i] === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($filesInput['error'][$i] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Upload failed. Please try again.'];
        }

        if ($filesInput['size'][$i] > POST_IMAGE_MAX_BYTES) {
            return ['success' => false, 'error' => 'Each image must be smaller than 5MB.'];
        }

        $imageInfo = @getimagesize($filesInput['tmp_name'][$i]);
        if ($imageInfo === false) {
            return ['success' => false, 'error' => 'One of the uploaded files is not a valid image.'];
        }

        $mime = $imageInfo['mime'];
        if (!isset($allowedMimeToExt[$mime])) {
            return ['success' => false, 'error' => 'Only JPG, PNG, GIF, and WEBP images are allowed.'];
        }

        if (!is_dir(POST_IMAGE_DIR)) {
            mkdir(POST_IMAGE_DIR, 0755, true);
        }

        $extension = $allowedMimeToExt[$mime];
        $filename = 'post_' . $postId . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
        $destination = POST_IMAGE_DIR . $filename;

        if (!move_uploaded_file($filesInput['tmp_name'][$i], $destination)) {
            return ['success' => false, 'error' => 'Could not save one of the uploaded files.'];
        }

        $filenames[] = $filename;
    }

    return ['success' => true, 'filenames' => $filenames];
}

function deletePostImageFile(?string $filename): void
{
    if (!$filename) {
        return;
    }

    $path = POST_IMAGE_DIR . $filename;
    if (is_file($path)) {
        unlink($path);
    }
}

function postImageUrl(string $filename): string
{
    return POST_IMAGE_URL . $filename;
}