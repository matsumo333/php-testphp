<?php
session_start();
require_once '../classes/UserLogic.php';
$result = UserLogic::checklogin();
if ($result) {
    header('Location: mypage.php');
    return;
}
$err = $_SESSION;
$_SESSION = array();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>

<body>
    <h2>ログインフォーム</h2>
    <?php if (isset($err['msg'])) : ?>
        <p><?php echo $err['msg']; ?>
        <?php endif; ?></p>
        <form action="login.php" method="POST">
            <p>
                <label for="email">メールアドレス：</label>
                <input type="email" name="email">
                <?php if (isset($err['email'])) : ?>
            <p><?php echo $err['email']; ?>
            <?php endif; ?></p>
            </p>

            <p>
                <label for="password">パスワード：</label>
                <input type="password" name="password">
                <?php if (isset($err['password'])) : ?>
            <p><?php echo $err['password']; ?>
            <?php endif; ?></p>
            </p>
            <p><input type="submit" value="ログイン"></p>
            <a href="signup_form.php">新規登録はこちら</a>

</body>

</html>