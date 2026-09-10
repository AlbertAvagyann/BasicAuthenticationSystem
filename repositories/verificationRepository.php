<?php

function getUserByVerificationTokenHash(PDO $pdo, string $tokenHash): ?array
{
    $stmt = $pdo->prepare(
        'SELECT id, email_verified_at, verification_token_expires_at
         FROM users
         WHERE verification_token = ?'
    );
    $stmt->execute([$tokenHash]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ?: null;
}

function setVerificationToken(PDO $pdo, int $userId, string $tokenHash, string $tokenExpiresAt): void
{
    $stmt = $pdo->prepare(
        'UPDATE users
         SET verification_token = ?,
             verification_token_expires_at = ?,
             last_verification_request_at = NOW()
         WHERE id = ?'
    );
    $stmt->execute([$tokenHash, $tokenExpiresAt, $userId]);
}

function markEmailAsVerified(PDO $pdo, int $userId): void
{
    $stmt = $pdo->prepare(
        'UPDATE users
         SET email_verified_at = NOW(),
             verification_token = NULL,
             verification_token_expires_at = NULL
         WHERE id = ?'
    );
    $stmt->execute([$userId]);
}