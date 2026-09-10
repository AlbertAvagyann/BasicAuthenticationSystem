<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderator - Users</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<h1>Users</h1>

<p><a href="/features/moderator/moderator.php">&larr; Back to Moderator Panel</a></p>

<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Email Verified</th>
        <th>Created</th>
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
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>