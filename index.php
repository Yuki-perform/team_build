<?php
require_once __DIR__ . '/functions.php';

$posts = load_posts();

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <title>投稿フォーム</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="container">
        <h1>投稿フォーム</h1>
        <form id="postForm" method="post" action="post.php">
            <input type="text" name="name" placeholder="名前" required maxlength="50" />
            <textarea name="message" placeholder="投稿内容" required maxlength="200"></textarea>
            <button type="submit">投稿する</button>
        </form>

        <h2>投稿一覧</h2>
        <div id="posts">
            <?php if (empty($posts)): ?>
                <p>まだ投稿はありません。</p>
            <?php else: ?>
                <?php foreach (array_reverse($posts) as $post): ?>
                    <div class="post" data-id="<?= $post['id'] ?>">
                        <div class="post-header">
                            <strong><?= sanitize($post['name']) ?></strong>
                        </div>
                        <div class="post-message"><?= nl2br(sanitize($post['content'])) ?></div>
                        <div class="post-footer">
                            <button class="like-button" data-post-id="<?= (int) $post['id'] ?>">
                                いいね <span class="like-count" id="likes-count-<?= $post['id'] ?>"><?= $post['likes'] ?></span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>

</html>
