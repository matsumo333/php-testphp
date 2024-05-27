<?php
require_once('env.php');

//このコードがあれば、エラーの内容が表示されるらしい
ini_set('display_errors', true);
//

function connect()
{
    $host = DB_HOST;
    $db = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // GPTに従い以下の二行を修正しました。
        error_log('データベース接続失敗: ' . $e->getMessage()); // エラーログにメッセージを記録
        exit('データベース接続失敗'); // エラーメッセージを表示してスクリプトを停止
    }
}
