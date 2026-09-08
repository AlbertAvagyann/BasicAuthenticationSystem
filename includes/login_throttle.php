<?php

const MAX_FAILED_ATTEMPTS = 3;
const LOCKOUT_MINUTES = 15;

function isAccountLocked(array $user): bool
{
    if (empty($user['locked_until'])) {
        return false;
    }
    return new DateTime($user['locked_until']) > new DateTime();
}

function lockoutRemainingSeconds(array $user): int
{
    if (empty($user['locked_until'])) {
        return 0;
    }
    $diff = (new DateTime($user['locked_until']))->getTimestamp() - time();
    return max(0, $diff);
}

function registerFailedLogin(PDO $pdo, int $userId, int $currentAttempts): void
{
    $attempts = $currentAttempts + 1;

    if ($attempts >= MAX_FAILED_ATTEMPTS) {
        $lockedUntil = (new DateTime("+" . LOCKOUT_MINUTES . " minutes"))->format('Y-m-d H:i:s');
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