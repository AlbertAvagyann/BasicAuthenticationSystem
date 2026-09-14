<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Post</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/theme.js"></script>
</head>
<body>

<div class="dash-shell">
    <header class="dash-header">
        <div class="dash-mark">Basic Auth</div>
        <nav>
            <a href="/features/posts/view_post.php?id=<?= (int) $post['id'] ?>" class="btn-ghost">Back to Post</a>
        </nav>
    </header>

    <main class="page-shell">
        <h1>Edit Post</h1>

        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($images)): ?>
            <div class="field">
                <label>Current Images</label>
                <div class="post-gallery">
                    <?php foreach ($images as $image): ?>
                        <div class="post-gallery-item">
                            <img src="<?= htmlspecialchars(postImageUrl($image['filename'])) ?>" alt="Post image" class="post-gallery-img">
                            <form method="POST" action="/features/posts/delete_post_image.php" onsubmit="return confirm('Remove this image?');">
                                <?= csrfField() ?>
                                <input type="hidden" name="image_id" value="<?= (int) $image['id'] ?>">
                                <button type="submit" class="btn-ghost">Remove</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="/features/posts/edit_post.php" enctype="multipart/form-data">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= (int) $post['id'] ?>">

            <div class="field">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>">
            </div>

            <div class="field">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="8"><?= htmlspecialchars($post['content']) ?></textarea>
            </div>

            <div class="field">
                <label for="images">Add Images</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
            </div>

            <button type="submit" class="btn-primary">Save changes</button>
        </form>
    </main>
</div>
</body>
</html>