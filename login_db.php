<?php
session_start();

// 変数の宣言
$error_message = '';
$mail = '';
$password = '';
$password_confirm = '';

// 受け取る
$mail = $_GET['mail'];
// 追加
$code = $_GET['code'];
$password = $_GET['password'];
$password_confirm = $_GET['password_confirm'];

// エラーチェック
// 値が空の場合
if (empty($mail) || empty($code) || empty($password) || empty($password_confirm)) {
    $error_message .= '項目が入力されていません';
}

// パスワードが一致していない場合
if (strcmp($password, $password_confirm) !== 0) {
    $error_message .= 'パスワードが一致しません';
}

// エラーの①と②どちらか一つでもエラーがある場合は登録画面に戻す
if (!empty($error_message)) {
    $_SESSION['error_message'] = $error_message;
    $_SESSION['mail'] = $mail;
    header('Location: user_regist.php');
    exit;
}

// パスワードをハッシュ化
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// データベース処理
$db = new PDO('mysql:host=localhost;dbname=login', 'root', '');

try{
    // トランザクション開始
    $db->beginTransaction();

    // ユーザの複数登録チェック
    $sql = 'SELECT login_id FROM login_users 

            WHERE login_id = :login_id;';

    // 事前にSQL登録
    $sth = $db->prepare($sql);

    // 変数名にパラメーターをバインド
    $sth->bindParam(':login_id', $mail);

    // 実行
    $sth->execute();

    // 結果を取得する
    $result = $sth->fetch();

    if(!empty($result)){
        $error_message = '③すでに登録されています';
        $_SESSION['mail'] = $mail;
        $_SESSION['error_message'] = $error_message;
        header( 'Location: user_regist.php' );
        exit;
    }else{
        // ログイン情報の登録
        // SQL文実行
        $sql = 'INSERT INTO login_users ( login_id , password ) 
                VALUES( :login_id, :password);';

        // 事前にSQL登録
        $sth = $db->prepare($sql);

        // 変数名にパラメーターをバインド
        $sth->bindParam(':login_id', $mail);
        $sth->bindParam(':password', $password_hash);       

        // 実行
        $sth->execute();  

        // コミット
        $db->commit();
    } catch (Exception $e) {

    // ロールバックする
    $db->rollback();

    echo "データベースエラー" . $e->getMessage();
}

unset($_SESSION['mail']);

// テンプレートとなるhtmlファイルを読み込む
$html = file_get_contents('user_regist_complete.html');

// 変換したhtmlを表示する
print($html);
