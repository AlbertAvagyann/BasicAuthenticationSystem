<?php

function insertPostImages(PDO $pdo, int $postId, array $filenames): void
{
    $stmt = $pdo->prepare(
        'INSERT INTO post_images (post_id, filename, sort_order) VALUES (?, ?, ?)'
    );

    foreach ($filenames as $order => $filename) {
        $stmt->execute([$postId, $filename, $order]);
    }
}

function getImagesByPostId(PDO $pdo, int $postId): array
{
    $stmt = $pdo->prepare(
        'SELECT id, filename, sort_order FROM post_images WHERE post_id = ? ORDER BY sort_order ASC'
    );
    $stmt->execute([$postId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getImageById(PDO $pdo, int $imageId): ?array
{
    $stmt = $pdo->prepare('SELECT id, post_id, filename FROM post_images WHERE id = ?');
    $stmt->execute([$imageId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

function deleteImageById(PDO $pdo, int $imageId): void
{
    $stmt = $pdo->prepare('DELETE FROM post_images WHERE id = ?');
    $stmt->execute([$imageId]);
}

function deleteImagesByPostId(PDO $pdo, int $postId): array
{
    $stmt = $pdo->prepare('SELECT filename FROM post_images WHERE post_id = ?');
    $stmt->execute([$postId]);
    $filenames = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'filename');

    $stmt = $pdo->prepare('DELETE FROM post_images WHERE post_id = ?');
    $stmt->execute([$postId]);

    return $filenames;
}
function getImagesForPosts(PDO $pdo, array $postIds): array
{
    if (empty($postIds)) {
        return [];
    }

    $placeholders = implode(',', array_fill(0, count($postIds), '?'));

    $stmt = $pdo->prepare(
        "SELECT post_id, filename, sort_order
         FROM post_images
         WHERE post_id IN ($placeholders)
         ORDER BY post_id ASC, sort_order ASC"
    );
    $stmt->execute($postIds);

    $result = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $result[(int) $row['post_id']][] = $row['filename'];
    }

    return $result;
}