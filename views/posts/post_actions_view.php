<?php
?>
<?php if (!empty($canManagePost)): ?>
    <div class="post-actions">
        <a href="/features/posts/edit_post.php?id=<?= (int) $post['id'] ?>" class="btn-ghost">Edit</a>
        <form method="POST" action="/features/posts/delete_post.php" onsubmit="return confirm('Delete this post?');">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= (int) $post['id'] ?>">
            <?php if (!empty($redirectTo)): ?>
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirectTo) ?>">
            <?php endif; ?>
            <button type="submit" class="btn-ghost">Delete</button>
        </form>
    </div>
<?php endif; ?>