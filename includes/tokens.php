<?php

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