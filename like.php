<?php
// functions.phpをインクルード
include_once('functions.php');

// POSTIDを取得
if (isset($_GET['id'])) {
    $postId = $_GET['id'];  // 文字列のまま取得

    // posts.jsonファイルを読み込み
    $jsonFile = 'data/posts.json';
    $posts = read_json_file($jsonFile);

    // 投稿IDが一致する投稿を探して「likes」をインクリメント
    $postFound = false;
    foreach ($posts as &$post) {
        if ($post['id'] === $postId) {  // 文字列比較
            $post['likes']++;
            $postFound = true;
            $updatedLikes = $post['likes'];
            break;
        }
    }

    // 投稿が見つかり、更新された場合
    if ($postFound) {
        // JSONデータを保存
        save_json_file($jsonFile, $posts); // writeJson → save_json_file に修正
        echo json_encode(['status' => 'success', 'likes' => $updatedLikes]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Post not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No post ID provided']);
}
?>
