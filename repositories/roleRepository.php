<?php

function getAllRoles(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT id, name FROM roles ORDER BY id');

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function roleExists(PDO $pdo, int $roleId): bool
{
    $stmt = $pdo->prepare('SELECT id FROM roles WHERE id = ?');
    $stmt->execute([$roleId]);

    return (bool) $stmt->fetch();
}

function getUserRoleName(PDO $pdo, int $userId): ?string
{
    $stmt = $pdo->prepare(
        'SELECT r.name
         FROM users u
         JOIN roles r ON u.role_id = r.id
         WHERE u.id = ?'
    );
    $stmt->execute([$userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['name'] : null;
}