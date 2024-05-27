<?php
require_once '../dbconnect.php';

class UserLogic
{
    /**
     * ユーザーを登録する
     * @param array $userData
     * @return bool $result
     */
    public static function createUser($userData)
    {
        error_log('createUser started'); // 開始時にログを記録
        error_log('Received userData: ' . print_r($userData, true));


        $result = false;
        $sql = 'INSERT INTO users(name,email,password) VALUES(?,?,?)';
        $arr = [];
        $arr[] = $userData['username'];
        $arr[] = $userData['email'];
        $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

        try {
            $stmt = connect()->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Statement preparation failed');
            }
            $result = $stmt->execute($arr);
            if ($result === false) {
                throw new Exception('Statement execution failed');
            }
            error_log('createUser succeeded'); // 成功時にログを記録
            return $result;
        } catch (\Exception $e) {
            error_log('createUser failed: ' . $e->getMessage()); // 失敗時にログを記録
            error_log('SQL State: ' . $stmt->errorCode()); // SQLステートコードを記録
            error_log('SQL Error Info: ' . implode(', ', $stmt->errorInfo())); // 詳細なエラー情報を記録
            return $result;
        }
    }
    /**
     * ログイン処理
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function login($email, $password)
    {
        //結果
        $result = false;
        $user = self::getUserByEmail($email);
        if (!$user) {
            $_SESSION['msg'] = 'emailが一致しません。';
            return false;
        }
        var_dump($user);
        //パスワードの照会
        if (password_verify($password, $user['password'])) {
            //ログイン成功
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }
        $_SESSION['msg'] = 'パスワードが一致しません。';
        return false;
    }
    /**
     * ユーザーを登録する
     * @param string $email
     * @return array | bool @user |false
     */
    public static function getUserByEmail($email)
    {
        //SQLの準備
        $sql = 'SELECT * FROM users WHERE email =?';
        $arr = [];
        $arr[] = $email;
        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);
            //SQLの結果を返す
            $user = $stmt->fetch();
            return $user;
        } catch (\Exception $e) {
            return false;
        }
        //SQLの実行


        $result = false;
        $user = self::getUserByEmail($email);
    }

    /**
     * ログインチェック
     * @param void
     * @return bool $result
     */
    public static function checklogin()
    {
        $result = false;
        //セッションにログインユーザーが入っていなかったらfalse
        if (isset($_SESSION['login_user']) && isset($_SESSION['login_user']['id']) && $_SESSION['login_user']['id'] > 0) {
            $result = true;
        }
        return $result;
    }
    /**
     * ログアウト処理
     */
    public static function logout()
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
}
