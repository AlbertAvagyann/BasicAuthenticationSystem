<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($displayName) ?> - Profile</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<div class="dash-shell">
    <header class="dash-header">
        <div class="dash-mark">Basic Auth</div>
        <nav>
            <a href="/features/dashboard/dashboard.php" class="btn-ghost">Dashboard</a>
            <a href="/features/posts/posts.php" class="btn-ghost">Posts Feed</a>
            <a href="/features/profile/view_profile.php" class="btn-ghost">My Profile</a>
            <form method="POST" action="/features/auth/logout.php" style="display: inline;">
                <?= csrfField() ?>
                <button type="submit" class="btn-ghost">Log out</button>
            </form>
        </nav>
    </header>

    <main class="page-shell">

        <?php if (isset($_GET['updated'])): ?>
            <div class="notice notice-success">Profile updated successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['picture_updated'])): ?>
            <div class="notice notice-success">Profile picture updated successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['picture_removed'])): ?>
            <div class="notice notice-success">Profile picture removed.</div>
        <?php endif; ?>

        <div class="profile-header">
            <?php if ($pictureUrl): ?>
                <img class="profile-avatar" src="<?= htmlspecialchars($pictureUrl) ?>" alt="<?= htmlspecialchars($displayName) ?>'s profile picture">
            <?php else: ?>
                <div class="profile-avatar-placeholder"><?= htmlspecialchars($initial) ?></div>
            <?php endif; ?>

            <div class="profile-name">
                <h1><?= htmlspecialchars($displayName) ?></h1>
                <div class="profile-meta"><?= htmlspecialchars($profileUser['email']) ?></div>
                <?php if (!empty($profile['location'])): ?>
                    <div class="profile-meta"><?= htmlspecialchars($profile['location']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($isOwnProfile): ?>
            <div class="profile-actions">
                <a href="/features/profile/edit_profile.php" class="btn-ghost">Edit profile</a>
                <a href="/features/posts/create_post.php" class="btn-ghost">New post</a>
            </div>
        <?php endif; ?>

        <div class="profile-details">
            <?php if (!empty($profile['phone'])): ?>
                <div class="profile-meta">Phone: <?= htmlspecialchars($profile['phone']) ?></div>
            <?php endif; ?>
            <?php if (!empty($profile['date_of_birth'])): ?>
                <div class="profile-meta">Date of birth: <?= htmlspecialchars($profile['date_of_birth']) ?></div>
            <?php endif; ?>
        </div>

        <?php if (!empty($profile['bio'])): ?>
            <p class="profile-bio"><?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
        <?php endif; ?>

        <h2><?= htmlspecialchars($displayName) ?>'s Posts</h2>

        <?php if (empty($posts)): ?>
            <p class="profile-meta">No posts yet.</p>
        <?php else: ?>
            <?php $showAuthor = false; ?>
            <?php $canManagePost = $isOwnProfile; ?>
            <?php $redirectTo = '/features/profile/view_profile.php?id=' . $targetUserId; ?>
            <?php foreach ($posts as $post): ?>
                <?php require __DIR__ . '/../posts/post_card_view.php'; ?>
                <?php require __DIR__ . '/../posts/post_actions_view.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </main>
</div>
</body>
</html>