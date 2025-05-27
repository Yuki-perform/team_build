<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'このページはPOST専用です。';
    exit;
}

$content = isset($_POST['content']) ? trim($_POST['content']) : '';

// バリデーション
if ($content === '') {
    echo '投稿内容を入力してください。';
    exit;
}
if (mb_strlen($content) > 200) {
    echo '投稿は200文字以内にしてください。';
    exit;
}

// 新しい投稿データの作成
$newPost = [
    'id' => uniqid(),
    'content' => htmlspecialchars($content, ENT_QUOTES, 'UTF-8'),
    'likes' => 0,
    'timestamp' => date('Y-m-d H:i:s')
];

// JSONファイルに保存
$file = 'data/posts.json';
$posts = loadPosts($file);
$posts[] = $newPost;
savePosts($file, $posts);

// 投稿完了後、トップページにリダイレクト
header('Location: index.php');
exit;
?>
