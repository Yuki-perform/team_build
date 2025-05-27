<?php
// 共通関数ファイル functions.php

// JSONファイルの読み込み（ファイルロックあり）
function read_json_file($filepath) {
    if (!file_exists($filepath)) {
        return [];
    }

    $fp = fopen($filepath, 'r');
    if (flock($fp, LOCK_SH)) {
        $filesize = filesize($filepath);
        $json = $filesize > 0 ? fread($fp, $filesize) : '';
        flock($fp, LOCK_UN);
        fclose($fp);

        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_json_error('JSON Decode Error: ' . json_last_error_msg());
            return [];
        }

        return is_array($data) ? $data : [];
    } else {
        fclose($fp);
        log_json_error('Could not acquire shared lock for reading.');
        return [];
    }
}

// JSONファイルへの保存（ファイルロックあり）
function save_json_file($filepath, $data) {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        log_json_error('JSON Encode Error: ' . json_last_error_msg());
        return false;
    }

    $fp = fopen($filepath, 'c+');
    if (flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, $json);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
        return true;
    } else {
        fclose($fp);
        log_json_error('Could not acquire exclusive lock for writing.');
        return false;
    }
}

// 投稿データのサニタイズ
function sanitize_post_data($post) {
    return [
        'id'      => uniqid('post_', true),
        'title'   => htmlspecialchars(trim($post['title'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'content' => nl2br(htmlspecialchars(trim($post['content'] ?? ''), ENT_QUOTES, 'UTF-8')),
        'author'  => htmlspecialchars(trim($post['author'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'date'    => date('Y-m-d H:i:s'),
        'likes'   => 0
    ];
}

// エラーログの記録
function log_json_error($message) {
    error_log('[JSON Error] ' . $message);
}

// 初期ファイル生成（空配列で初期化）
function initialize_json_file($filepath) {
    if (!file_exists($filepath)) {
        $dir = dirname($filepath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        save_json_file($filepath, []);
    }
}
