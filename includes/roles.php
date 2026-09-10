<?php

require_once __DIR__ . '/error_page.php';
require_once __DIR__ . '/../repositories/userRepository.php';
require_once __DIR__ . '/../repositories/roleRepository.php';
require_once __DIR__ . '/../repositories/permissionRepository.php';

function hasRole(PDO $pdo, int $userId, string $roleName): bool
{
    return getUserRoleName($pdo, $userId) === $roleName;
}

function can(PDO $pdo, int $userId, string $permissionName): bool
{
    return userHasPermission($pdo, $userId, $permissionName);
}

function requireRole(PDO $pdo, string $roleName): void
{
    requireLogin();
    if (!hasRole($pdo, $_SESSION['user_id'], $roleName)) {
        renderErrorPage(403, '403 Forbidden');
    }
}

function requirePermission(PDO $pdo, string $permissionName): void
{
    requireLogin();
    if (!can($pdo, $_SESSION['user_id'], $permissionName)) {
        renderErrorPage(403, '403 Forbidden');
    }
}