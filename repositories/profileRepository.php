<?php

function findProfileByUserId(PDO $pdo, int $userId): ?array
{
    $stmt = $pdo->prepare(
        'SELECT id, user_id, first_name, last_name, phone, location, date_of_birth, bio, profile_picture, created_at, updated_at
         FROM profiles
         WHERE user_id = ?'
    );
    $stmt->execute([$userId]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    return $profile ?: null;
}

function saveProfile(
    PDO $pdo,
    int $userId,
    string $firstName,
    string $lastName,
    string $phone,
    string $location,
    ?string $dateOfBirth,
    string $bio
): void {
    $stmt = $pdo->prepare(
        'INSERT INTO profiles (user_id, first_name, last_name, phone, location, date_of_birth, bio)
         VALUES (?, ?, ?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE
            first_name = VALUES(first_name),
            last_name = VALUES(last_name),
            phone = VALUES(phone),
            location = VALUES(location),
            date_of_birth = VALUES(date_of_birth),
            bio = VALUES(bio)'
    );
    $stmt->execute([
        $userId,
        $firstName,
        $lastName,
        $phone,
        $location,
        $dateOfBirth,
        $bio,
    ]);
}

function updateProfilePicture(PDO $pdo, int $userId, ?string $filename): void
{
    $stmt = $pdo->prepare(
        'INSERT INTO profiles (user_id, profile_picture)
         VALUES (?, ?)
         ON DUPLICATE KEY UPDATE profile_picture = VALUES(profile_picture)'
    );
    $stmt->execute([$userId, $filename]);
}