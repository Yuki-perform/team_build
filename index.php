<?php
// functions.phpをインクルード
include_once('functions.php');

// posts.jsonファイルを読み込む
$posts = readJson('data/posts.json');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿一覧</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js" defer></script>
</head>
<body>
    <h1>投稿一覧</h1>

    <div id="posts">
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <p><?= htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') ?></p>
                <button class="like-button" data-post-id="<?= $post['id'] ?>">いいね</button>
                <span id="likes-count-<?= $post['id'] ?>"><?= $post['likes'] ?></span> いいね
            </div>
        <?php endforeach; ?>
    </div>

    <h2>新しい投稿</h2>
    <form action="post.php" method="POST">
        <textarea name="content" placeholder="投稿内容"></textarea><br>
        <button type="submit">投稿</button>
    </form>
</body>
</html>
