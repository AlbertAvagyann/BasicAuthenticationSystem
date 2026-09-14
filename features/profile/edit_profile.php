<?php
require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';
require_once __DIR__ . '/../../includes/uploads.php';
require_once __DIR__ . '/../../repositories/profileRepository.php';

$currentUser = requireVerifiedUser($pdo);
$userId = (int) $currentUser['id'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();

    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $dateOfBirthInput = trim($_POST['date_of_birth'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    if (strlen($firstName) > 100 || strlen($lastName) > 100) {
        $errors[] = 'First and last name must be under 100 characters.';
    }

    if ($phone !== '' && !preg_match('/^[0-9+\-\s()]{5,30}$/', $phone)) {
        $errors[] = 'Phone number format is invalid.';
    }

    $dateOfBirth = null;
    if ($dateOfBirthInput !== '') {
        $dob = DateTime::createFromFormat('Y-m-d', $dateOfBirthInput);
        if (!$dob) {
            $errors[] = 'Date of birth is invalid.';
        } elseif ($dob > new DateTime()) {
            $errors[] = 'Date of birth cannot be in the future.';
        } else {
            $dateOfBirth = $dob->format('Y-m-d');
        }
    }

    if (strlen($bio) > 2000) {
        $errors[] = 'Bio must be under 2000 characters.';
    }

    if (empty($errors)) {
        saveProfile($pdo, $userId, $firstName, $lastName, $phone, $location, $dateOfBirth, $bio);
        header('Location: /features/profile/view_profile.php?updated=1');
        exit;
    }

    $existingProfile = findProfileByUserId($pdo, $userId);
    $profile = [
        'first_name'      => $firstName,
        'last_name'       => $lastName,
        'phone'           => $phone,
        'location'        => $location,
        'date_of_birth'   => $dateOfBirthInput,
        'bio'             => $bio,
        'profile_picture' => $existingProfile['profile_picture'] ?? null,
    ];
} else {
    $profile = findProfileByUserId($pdo, $userId) ?? [
        'first_name'      => '',
        'last_name'       => '',
        'phone'           => '',
        'location'        => '',
        'date_of_birth'   => '',
        'bio'             => '',
        'profile_picture' => null,
    ];
}

$pictureError = $_GET['picture_error'] ?? null;
$pictureUrl = profilePictureUrl($profile['profile_picture'] ?? null);

require __DIR__ . '/../../views/profile/edit_profile_view.php';