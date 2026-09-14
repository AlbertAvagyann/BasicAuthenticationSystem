<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<div class="dash-shell">
    <header class="dash-header">
        <div class="dash-mark">Basic Auth</div>
        <nav>
            <a href="/features/profile/view_profile.php" class="btn-ghost">Back to Profile</a>
        </nav>
    </header>

    <main class="page-shell">
        <h1>Edit Profile</h1>

        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($pictureError)): ?>
            <div class="error-list"><?= htmlspecialchars($pictureError) ?></div>
        <?php endif; ?>

        <section class="profile-picture-section">
            <h2>Profile Picture</h2>

            <?php if ($pictureUrl): ?>
                <img class="profile-avatar" src="<?= htmlspecialchars($pictureUrl) ?>" alt="Current profile picture">
            <?php else: ?>
                <div class="profile-avatar-placeholder">?</div>
            <?php endif; ?>

            <form method="POST" action="/features/profile/upload_picture.php" enctype="multipart/form-data" class="field">
                <?= csrfField() ?>
                <label for="profile_picture"><?= $pictureUrl ? 'Replace picture' : 'Add picture' ?></label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/gif,image/webp">
                <button type="submit" class="btn-primary" style="width:auto; margin-top: 10px;">Upload</button>
            </form>

            <?php if ($pictureUrl): ?>
                <form method="POST" action="/features/profile/remove_picture.php" onsubmit="return confirm('Remove your profile picture?');">
                    <?= csrfField() ?>
                    <button type="submit" class="btn-ghost">Remove picture</button>
                </form>
            <?php endif; ?>
        </section>

        <h2>Profile Information</h2>

        <form method="POST" action="/features/profile/edit_profile.php">
            <?= csrfField() ?>

            <div class="field">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($profile['first_name'] ?? '') ?>">
            </div>

            <div class="field">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($profile['last_name'] ?? '') ?>">
            </div>

            <div class="field">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>">
            </div>

            <div class="field">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?= htmlspecialchars($profile['location'] ?? '') ?>">
            </div>

            <div class="field">
                <label for="date_of_birth">Date of Birth</label>
                <input
                        type="date"
                        id="date_of_birth"
                        name="date_of_birth"
                        value="<?= htmlspecialchars($profile['date_of_birth'] ?? '') ?>"
                        max="<?= date('Y-m-d') ?>"
                        required
                >
            </div>

            <div class="field">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="5"><?= htmlspecialchars($profile['bio'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn-primary">Save changes</button>
        </form>
    </main>
</div>
</body>
</html>