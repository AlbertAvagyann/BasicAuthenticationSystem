<?php

const EMAIL_THROTTLE_SECONDS = 60;

function generateToken(): array
{
    $raw = bin2hex(random_bytes(32));
    return ['raw' => $raw, 'hash' => hash('sha256', $raw)];
}

function hashToken(string $rawToken): string
{
    return hash('sha256', $rawToken);
}

function expiresInMinutes(int $minutes): string
{
    return (new DateTime("+{$minutes} minutes"))->format('Y-m-d H:i:s');
}

function isExpired(?string $expiresAt): bool
{
    if ($expiresAt === null) {
        return true;
    }
    return new DateTime($expiresAt) < new DateTime();
}

function secondsSinceLastRequest(?string $lastRequestAt): ?int
{
    if ($lastRequestAt === null) {
        return null;
    }
    return time() - (new DateTime($lastRequestAt))->getTimestamp();
}

function isThrottled(?string $lastRequestAt): bool
{
    $elapsed = secondsSinceLastRequest($lastRequestAt);
    return $elapsed !== null && $elapsed < EMAIL_THROTTLE_SECONDS;
}

function throttleRemainingSeconds(?string $lastRequestAt): int
{
    $elapsed = secondsSinceLastRequest($lastRequestAt);
    if ($elapsed === null) {
        return 0;
    }
    return max(0, EMAIL_THROTTLE_SECONDS - $elapsed);
}