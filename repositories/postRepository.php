<?php

function createPost(PDO $pdo, int $userId, string $title, string $content): int
{
    $stmt = $pdo->prepare('INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)');
    $stmt->execute([$userId, $title, $content]);

    return (int) $pdo->lastInsertId();
}
function findPostById(PDO $pdo, int $postId): ?array
{
    $stmt = $pdo->prepare(
        'SELECT p.id, p.user_id, p.title, p.content, p.created_at, p.updated_at, u.name AS author_name
         FROM posts p
         JOIN users u ON p.user_id = u.id
         WHERE p.id = ?'
    );
    $stmt->execute([$postId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    return $post ?: null;
}

function getPostsByUserId(PDO $pdo, int $userId): array
{
    $stmt = $pdo->prepare(
        'SELECT p.id, p.user_id, p.title, p.content, p.created_at, p.updated_at, u.name AS author_name
         FROM posts p
         JOIN users u ON p.user_id = u.id
         WHERE p.user_id = ?
         ORDER BY p.created_at DESC'
    );
    $stmt->execute([$userId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllPostsWithAuthor(PDO $pdo): array
{
    $stmt = $pdo->query(
        'SELECT p.id, p.user_id, p.title, p.content, p.created_at, p.updated_at, u.name AS author_name
         FROM posts p
         JOIN users u ON p.user_id = u.id
         ORDER BY p.created_at DESC'
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updatePost(PDO $pdo, int $postId, string $title, string $content): void
{
    $stmt = $pdo->prepare('UPDATE posts SET title = ?, content = ? WHERE id = ?');
    $stmt->execute([$title, $content, $postId]);
}

function deletePostById(PDO $pdo, int $postId): void
{
    $stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
    $stmt->execute([$postId]);
}
function getPostsPageWithAuthor(PDO $pdo, int $limit, int $offset): array
{
    $stmt = $pdo->prepare(
        'SELECT p.id, p.user_id, p.title, p.content, p.created_at, p.updated_at, u.name AS author_name
         FROM posts p
         JOIN users u ON p.user_id = u.id
         ORDER BY p.created_at DESC
         LIMIT ? OFFSET ?'
    );
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countAllPosts(PDO $pdo): int
{
    $stmt = $pdo->query('SELECT COUNT(*) FROM posts');

    return (int) $stmt->fetchColumn();
}