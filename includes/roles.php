<?php

function hasRole(PDO $pdo, int $userId, string $roleName): bool
{
    $stmt = $pdo->prepare(
        'SELECT r.name
         FROM users u
         JOIN roles r ON u.role_id = r.id
         WHERE u.id = ?'
    );
    $stmt->execute([$userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row && $row['name'] === $roleName;
}

function can(PDO $pdo, int $userId, string $permissionName): bool
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

function requireRole(PDO $pdo, string $roleName): void
{
    requireLogin();
    if (!hasRole($pdo, $_SESSION['user_id'], $roleName)) {
        http_response_code(403);
        exit('403 Forbidden');
    }
}

function requirePermission(PDO $pdo, string $permissionName): void
{
    requireLogin();
    if (!can($pdo, $_SESSION['user_id'], $permissionName)) {
        http_response_code(403);
        exit('403 Forbidden');
    }
}