<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posts Feed</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<div class="dash-shell">
    <header class="dash-header">
        <div class="dash-mark">Basic Auth</div>
        <nav>
            <a href="/features/dashboard/dashboard.php" class="btn-ghost">Dashboard</a>
            <a href="/features/profile/view_profile.php" class="btn-ghost">My Profile</a>
            <a href="/features/posts/create_post.php" class="btn-ghost">New Post</a>
        </nav>
    </header>

    <main class="page-shell">
        <h1>Posts Feed</h1>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="notice notice-success">Post deleted successfully.</div>
        <?php endif; ?>

        <?php if (empty($posts)): ?>
            <p class="profile-meta">No posts yet. <a href="/features/posts/create_post.php">Be the first to write one.</a></p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <?php require __DIR__ . '/post_card_view.php'; ?>
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
    </main>
</div>
</body>
</html>