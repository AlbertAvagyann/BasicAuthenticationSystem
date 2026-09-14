<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderator - Posts by <?= htmlspecialchars($viewedUser['name']) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<h1>Posts by <?= htmlspecialchars($viewedUser['name']) ?></h1>

<p><a href="/features/moderator/users.php">&larr; Back to Users</a></p>

<?php if (empty($posts)): ?>
    <p class="profile-meta">This user hasn't created any posts yet.</p>
<?php else: ?>
    <?php $showAuthor = false; ?>
    <?php foreach ($posts as $post): ?>
        <?php require __DIR__ . '/../posts/post_card_view.php'; ?>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>