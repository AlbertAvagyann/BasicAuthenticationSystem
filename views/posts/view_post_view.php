<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<div class="dash-shell">
    <header class="dash-header">
        <div class="dash-mark">Basic Auth</div>
        <nav>
            <a href="/features/posts/posts.php" class="btn-ghost">Posts Feed</a>
        </nav>
    </header>

    <main class="page-shell">

        <?php if (isset($_GET['created'])): ?>
            <div class="notice notice-success">Post published successfully.</div>
        <?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>
            <div class="notice notice-success">Post updated successfully.</div>
        <?php endif; ?>

        <article class="post-card">
            <h1><?= htmlspecialchars($post['title']) ?></h1>
            <div class="post-meta">
                By <a href="/features/profile/view_profile.php?id=<?= (int) $post['user_id'] ?>"><?= htmlspecialchars($post['author_name']) ?></a>
                &middot; <?= htmlspecialchars($post['created_at']) ?>
                <?php if ($post['updated_at'] !== $post['created_at']): ?>
                    (edited <?= htmlspecialchars($post['updated_at']) ?>)
                <?php endif; ?>
            </div>

            <?php if (!empty($images)): ?>
                <div class="post-gallery">
                    <?php foreach ($images as $image): ?>
                        <img src="<?= htmlspecialchars(postImageUrl($image['filename'])) ?>" alt="Post image" class="post-gallery-img">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></div>

            <?php require __DIR__ . '/post_actions_view.php'; ?>
        </article>
    </main>
</div>
</body>
</html>