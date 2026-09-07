<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderator Panel</title>
</head>
<body>
<h1>Moderator Panel</h1>
<p>Welcome, <?= htmlspecialchars($user['name']) ?>!</p>
<p>This page is accessible to Moderators and Admins.</p>

<a href="/features/admin/users.php">View Users</a>
</body>
</html>