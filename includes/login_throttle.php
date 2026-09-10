<?php

require_once __DIR__ . '/../repositories/userRepository.php';

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
        updateFailedLoginAttempts($pdo, $userId, $attempts, $lockedUntil);
    } else {
        updateFailedLoginAttempts($pdo, $userId, $attempts, null);
    }
}