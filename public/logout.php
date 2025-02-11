<?php
session_start();
require_once '../classes/UserLogic.php';

if (!isset($_POST['logout'])) {
    exit('不正なリクエストです');
}

$result = UserLogic::checkLogin();

if (!$result) {
    exit('セッションが切れましたので、ログインし直してください。');
}

UserLogic::logout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
</head>

<body>
    <h2>ログアウト完了</h2>
    <p>ログアウトしました！</p>
    <a href="login_form.php">ログイン画面</a>
</body>

</html>