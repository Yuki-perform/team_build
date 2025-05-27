<?php
// functions.phpをインクルード
include_once('functions.php');

// 投稿内容を受け取る
if (isset($_POST['content'])) {
    $content = sanitize($_POST['content']);
    
    // 現在の投稿データを読み込む
    $posts = readJson('data/posts.json');
    
    // 新しい投稿IDを決定
    $newId = max(array_column($posts, 'id')) + 1;  // 最大のID+1
    
    // 新しい投稿を追加
    $posts[] = [
        'id' => $newId,
        'content' => $content,
        'likes' => 0
    ];
    
    // JSONデータを保存
    writeJson('data/posts.json', $posts);
    
    // 投稿後、投稿一覧ページにリダイレクト
    header('Location: index.php');
    exit;
}
?>
