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

<h1>Users</h1>

<?php if (isset($_GET['deleted'])): ?>
    <div class="notice notice-success">User deleted successfully.</div>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
    <div class="notice notice-success">User updated successfully.</div>
<?php endif; ?>

<p><a href="/features/admin/admin.php">&larr; Back to Admin Panel</a></p>

<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Email Verified</th>
        <th>Created</th>
        <th>Action</th>
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
            <td>
                <a href="/features/admin/edit_user_form.php?id=<?= htmlspecialchars($u['id']) ?>">Edit</a>

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
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>