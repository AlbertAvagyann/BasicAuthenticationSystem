<?php

function userHasPermission(PDO $pdo, int $userId, string $permissionName): bool
{
    $stmt = $pdo->prepare(
        'SELECT p.name
         FROM users u
         JOIN role_permissions rp ON u.role_id = rp.role_id
         JOIN permissions p ON rp.permission_id = p.id
         WHERE u.id = ? AND p.name = ?'
    );
    $stmt->execute([$userId, $permissionName]);

    return (bool) $stmt->fetch();
}