<?php
$showAuthor = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderator - All Posts</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<h1>All Posts</h1>

<p><a href="/features/moderator/moderator.php">&larr; Back to Moderator Panel</a></p>

<?php if (empty($posts)): ?>
    <p class="profile-meta">No posts have been created yet.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <?php require __DIR__ . '/../posts/post_card_view.php'; ?>
    <?php endforeach; ?>

    <?php if ($totalPages > 1): ?>
        <nav class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1 ?>" class="btn-ghost">&larr; Previous</a>
            <?php endif; ?>

            <span class="pagination-status">Page <?= $currentPage ?> of <?= $totalPages ?></span>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1 ?>" class="btn-ghost">Next &rarr;</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>