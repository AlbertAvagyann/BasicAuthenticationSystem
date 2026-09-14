<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Post</title>
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
        <h1>New Post</h1>

        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST" action="/features/posts/create_post.php" enctype="multipart/form-data">
            <?= csrfField() ?>

            <div class="field">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>">
            </div>

            <div class="field">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="8"><?= htmlspecialchars($content) ?></textarea>
            </div>

            <div class="field">
                <label for="images">Images</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
            </div>

            <button type="submit" class="btn-primary">Publish</button>
        </form>
    </main>
</div>
</body>
</html>