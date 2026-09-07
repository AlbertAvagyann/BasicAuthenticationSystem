<?php


require __DIR__ . '/../../config/db.php';
require __DIR__ . '/../../includes/auth.php';
require __DIR__ . '/../../includes/roles.php';

requirePermission($pdo, 'access_moderator_page');

$user = requireVerifiedUser($pdo);

require __DIR__ . '/../../views/moderator/moderator_view.php';