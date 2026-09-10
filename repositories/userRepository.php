<?php

function findUserById(PDO $pdo, int $userId): ?array
{
    $stmt = $pdo->prepare(
        'SELECT id, name, email, password, email_verified_at, role_id,
                failed_login_attempts, locked_until,
                last_verification_request_at, last_password_reset_request_at,
                created_at
         FROM users
         WHERE id = ?'
    );
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ?: null;
}

function findUserByEmail(PDO $pdo, string $email): ?array
{
    $stmt = $pdo->prepare(
        'SELECT id, name, email, password, email_verified_at, role_id,
                failed_login_attempts, locked_until,
                last_verification_request_at, last_password_reset_request_at,
                created_at
         FROM users
         WHERE email = ?'
    );
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ?: null;
}

function emailExists(PDO $pdo, string $email): bool
{
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);

    return (bool) $stmt->fetch();
}

function createUser(PDO $pdo, string $name, string $email, string $hashedPassword): int
{
    $stmt = $pdo->prepare(
        'INSERT INTO users (name, email, password)
         VALUES (?, ?, ?)'
    );
    $stmt->execute([$name, $email, $hashedPassword]);

    return (int) $pdo->lastInsertId();
}

function getAllUsersWithRoles(PDO $pdo): array
{
    $stmt = $pdo->query(
        'SELECT u.id, u.name, u.email, u.email_verified_at, u.created_at, r.id AS role_id, r.name AS role_name
         FROM users u
         JOIN roles r ON u.role_id = r.id
         ORDER BY u.id'
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function userExists(PDO $pdo, int $userId): bool
{
    $stmt = $pdo->prepare('SELECT id FROM users WHERE id = ?');
    $stmt->execute([$userId]);

    return (bool) $stmt->fetch();
}

function updateUserRole(PDO $pdo, int $userId, int $roleId): void
{
    $stmt = $pdo->prepare('UPDATE users SET role_id = ? WHERE id = ?');
    $stmt->execute([$roleId, $userId]);
}

function deleteUserById(PDO $pdo, int $userId): void
{
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$userId]);
}

function updateFailedLoginAttempts(PDO $pdo, int $userId, int $attempts, ?string $lockedUntil): void
{
    if ($lockedUntil !== null) {
        $stmt = $pdo->prepare('UPDATE users SET failed_login_attempts = ?, locked_until = ? WHERE id = ?');
        $stmt->execute([$attempts, $lockedUntil, $userId]);
    } else {
        $stmt = $pdo->prepare('UPDATE users SET failed_login_attempts = ? WHERE id = ?');
        $stmt->execute([$attempts, $userId]);
    }
}

function resetFailedLogins(PDO $pdo, int $userId): void
{
    $stmt = $pdo->prepare('UPDATE users SET failed_login_attempts = 0, locked_until = NULL WHERE id = ?');
    $stmt->execute([$userId]);
}
function updateUser(
    PDO $pdo,
    int $userId,
    string $name,
    string $email,
    ?string $emailVerifiedAt,
    string $createdAt,
    int $roleId
): void {
    $stmt = $pdo->prepare(
        'UPDATE users
         SET name = ?, email = ?, email_verified_at = ?, created_at = ?, role_id = ?
         WHERE id = ?'
    );
    $stmt->execute([$name, $email, $emailVerifiedAt, $createdAt, $roleId, $userId]);
}

function emailExistsForOtherUser(PDO $pdo, string $email, int $excludeUserId): bool
{
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
    $stmt->execute([$email, $excludeUserId]);

    return (bool) $stmt->fetch();
}