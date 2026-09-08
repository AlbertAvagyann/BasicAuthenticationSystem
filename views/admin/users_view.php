<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Users</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<button id="theme-toggle" class="theme-toggle" type="button" aria-label="Toggle dark mode">
    <span class="icon-light">🌙</span>
    <span class="icon-dark">☀️</span>
</button>

<h1>Users</h1>

<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Email Verified</th>
        <th>Created</th>

        <?php if ($canManage): ?>
            <th>Action</th>
        <?php endif; ?>

    </tr>
    </thead>

    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['id']) ?></td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= htmlspecialchars($u['role_name']) ?></td>
            <td><?= $u['email_verified_at'] ? 'Yes' : 'No' ?></td>
            <td><?= htmlspecialchars($u['created_at']) ?></td>

            <?php if ($canManage): ?>
                <td>

                    <form method="POST"
                          action="/features/admin/update_role.php"
                          style="display: inline;">

                        <?= csrfField() ?>

                        <input type="hidden"
                               name="user_id"
                               value="<?= htmlspecialchars($u['id']) ?>">

                        <select name="role_id">
                            <?php foreach ($roles as $r): ?>
                                <option value="<?= $r['id'] ?>"
                                        <?= $r['id'] == $u['role_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit">Update</button>
                    </form>


                    <form method="POST"
                          action="/features/admin/delete_user.php"
                          style="display: inline;"
                          onsubmit="return confirm('Are you sure you want to delete this user?');">

                        <?= csrfField() ?>

                        <input type="hidden"
                               name="user_id"
                               value="<?= htmlspecialchars($u['id']) ?>">

                        <button type="submit">Delete</button>
                    </form>

                </td>
            <?php endif; ?>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>