<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<h1>Edit User</h1>
<p><a href="/features/admin/users.php">&larr; Back to Users</a></p>

<form method="POST" action="/features/admin/edit_user.php">
    <?= csrfField() ?>
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($targetUser['id']) ?>">

    <p>
        <label>Name<br>
            <input type="text" name="name" value="<?= htmlspecialchars($targetUser['name']) ?>" required>
        </label>
    </p>

    <p>
        <label>Email<br>
            <input type="email" name="email" value="<?= htmlspecialchars($targetUser['email']) ?>" required>
        </label>
    </p>

    <p>
        <label>Role<br>
            <select name="role_id">
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>"
                        <?= $r['id'] == $targetUser['role_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>

    <p>
        <label>
            <input type="checkbox" name="email_verified" <?= $targetUser['email_verified_at'] !== null ? 'checked' : '' ?>>
            Email Verified
        </label>
    </p>

    <p>
        <label>Created At<br>
            <input type="datetime-local" name="created_at"
                   value="<?= date('Y-m-d\TH:i', strtotime($targetUser['created_at'])) ?>"
                   max="<?= date('Y-m-d\TH:i') ?>"
                   required>
        </label>
    </p>

    <button type="submit">Save Changes</button>
</form>

</body>
</html>