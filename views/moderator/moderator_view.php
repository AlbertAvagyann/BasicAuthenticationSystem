<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderator Panel</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<h1>Moderator Panel</h1>
<p>Welcome, <?= htmlspecialchars($user['name']) ?>!</p>
<p>This page is accessible to Moderators and Admins.</p>

<a href="/features/moderator/users.php">View Users</a>
</body>
</html>