<?php
$showAuthor = $showAuthor ?? true;
?>
<article class="post-card">
    <h3><a href="/features/posts/view_post.php?id=<?= (int) $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>

    <div class="post-meta">
        <?php if ($showAuthor && isset($post['author_name'])): ?>
            By <a href="/features/profile/view_profile.php?id=<?= (int) $post['user_id'] ?>"><?= htmlspecialchars($post['author_name']) ?></a>
            &middot;
        <?php endif; ?>

        <?= htmlspecialchars($post['created_at']) ?>

        <?php if (!empty($post['updated_at']) && $post['updated_at'] !== $post['created_at']): ?>
            &middot; edited <?= htmlspecialchars($post['updated_at']) ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($postImages[$post['id']])): ?>
        <div class="post-gallery">
            <?php foreach ($postImages[$post['id']] as $filename): ?>
                <img src="<?= htmlspecialchars(postImageUrl($filename)) ?>" alt="Post image" class="post-gallery-img">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="post-content"><?= nl2br(htmlspecialchars(mb_strimwidth($post['content'], 0, 300, '...'))) ?></div>
</article>