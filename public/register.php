<?php
// var_dump($_POST);
session_start();
require_once '../classes/UserLogic.php';
// エラーメッセージ
$err = [];
$token = filter_input(INPUT_POST, 'csrf_token');
//トークンがない、もしくは一致しない場合、処理を中止
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
    exit('不正なリクエストです');
}
unset($_SESSION['csrf_token']);

//バリデーション
if (!$username = filter_input(INPUT_POST, 'username')) {
    $err[] = 'ユーザー名を記入してください';
}
if (!$email = filter_input(INPUT_POST, 'email')) {
    $err[] = 'Eメールを記入してください';
}
$password = filter_input(INPUT_POST, 'password');
//正規表現
if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
    $err[] = 'パスワードは英数字8文字以上100文字以下にしてください。';
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
if ($password !== $password_conf) {
    $err[] = '確認用パスワードと間違っています。';
}
if (count($err) === 0) {
    //ユーザー登録をする処理
    $hasCreated = UserLogic::createUser($_POST);
    if (!$hasCreated) {
        $err[] = 'ユーザー登録に失敗しました。';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録画面</title>
</head>

<body>
    <?php if (count($err) > 0) : ?>
        <?php foreach ($err as $e) : ?>
            <p><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></p>
            <!-- GPTに従い以下の行を上記のように修正しました。 -->
            <!-- <p><?php echo $e ?></p> -->

        <?php endforeach ?>
    <?php else : ?>
        <p>ユーザー登録が完了しました。</p>
    <?php endif ?>

    <a href="./signup_form.php">戻る</a>
</body>

</html>