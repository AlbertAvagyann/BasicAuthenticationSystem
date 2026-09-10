<?php

function setPasswordResetToken(PDO $pdo, int $userId, string $tokenHash, string $tokenExpiresAt): void
{
    $stmt = $pdo->prepare(
        'UPDATE users
         SET password_reset_token = ?,
             password_reset_token_expires_at = ?,
             last_password_reset_request_at = NOW()
         WHERE id = ?'
    );
    $stmt->execute([$tokenHash, $tokenExpiresAt, $userId]);
}

function findUserByPasswordResetTokenHash(PDO $pdo, string $tokenHash): ?array
{
    $stmt = $pdo->prepare(
        'SELECT id, name, email, password_reset_token_expires_at
         FROM users
         WHERE password_reset_token = ?'
    );
    $stmt->execute([$tokenHash]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ?: null;
}

function updateUserPassword(PDO $pdo, int $userId, string $hashedPassword): void
{
    $stmt = $pdo->prepare(
        'UPDATE users
         SET password = ?,
             password_reset_token = NULL,
             password_reset_token_expires_at = NULL
         WHERE id = ?'
    );
    $stmt->execute([$hashedPassword, $userId]);
}