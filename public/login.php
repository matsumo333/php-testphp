<?php
session_start();
require_once '../classes/UserLogic.php';

// エラーメッセージ
$err = [];

//バリデーション
if (!$email = filter_input(INPUT_POST, 'email')) {
    $err['email'] = 'Eメールを記入してください';
}
if (!$password = filter_input(INPUT_POST, 'password')) {
    $err['password'] = 'パスワードを記入してください';
};

if (count($err) > 0) {
    //エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location: login_form.php');
    return;
    echo 'ログインしました。';
}
//ログイン成功時の処理
$result = UserLogic::login($email, $password);
if (!$result) {
    header('Location: login_form.php');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン完了</title>
</head>

<body>
    <?php if (count($err) > 0) : ?>
        <?php foreach ($err as $e) : ?>
            <p><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></p>
            <!-- GPTに従い以下の行を上記のように修正しました。 -->
            <!-- <p><?php echo $e ?></p> -->

        <?php endforeach ?>
    <?php else : ?>
        <p>ログインしました。</p>
    <?php endif ?>

    <a href="./mypage.php">マイページへ</a>
</body>

</html>