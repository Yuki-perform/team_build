<?php
// functions.phpをインクルード
include_once('functions.php');

// POSTIDを取得
if (isset($_GET['post_id'])) {
    $postId = (int)$_GET['post_id'];  // POST IDを整数として取得

    // posts.jsonファイルを読み込み
    $jsonFile = 'data/posts.json';
    $posts = readJson($jsonFile);

    // 投稿IDが一致する投稿を探して「likes」をインクリメント
    $postFound = false;
    foreach ($posts as &$post) {
        if ($post['id'] === $postId) {
            $post['likes']++;
            $postFound = true;
            break;
        }
    }

    // 投稿が見つかり、更新された場合
    if ($postFound) {
        // JSONデータを保存
        writeJson($jsonFile, $posts);
        echo json_encode(['status' => 'success', 'likes' => $post['likes']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Post not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No post ID provided']);
}
?>
