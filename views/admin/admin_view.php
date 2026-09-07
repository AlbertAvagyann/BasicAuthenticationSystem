<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
</head>
<body>
<h1>Admin Panel</h1>
<p>Welcome, <?= htmlspecialchars($user['name']) ?>!</p>

<ul>
    <li><a href="/features/admin/users.php">Manage Users</a></li>
</ul>
</body>
</html>