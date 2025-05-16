<?php
session_start(); // セッションを開始する

function session_login($user_id)
{
    //ログイン情報をセッションに記録
    $_SESSION["login"] = array("user_id" => $user_id); //セッションIDとしてユーザーIDを保存
}

function session_part_01($script)
{ //リダイレクト先のindex.phpで呼び出し
    if (isset($_SESSION['login'])) {
        if (isset($_POST['logout'])) {
            unset($_SESSION['login']);
            header("Location: $script"); // ログアウト後にページをリダイレクト（これが無いとリロードすると何も表示されなくなる）
            exit();
        }
        echo 'SessionID: ' . $_SESSION["login"]["user_id"] . '<br>'; // セッションIDとユーザーIDがリンクしているかを表示して確認
        echo '<p>ログイン中です</p>';
        echo <<<_logout_
        <form action='$script' method="POST">
            <input type="hidden" name="logout"><br>
            <input type="submit" value="ログアウトする">
        </form>
        _logout_;
        return true; //return 文は特定の条件が満たされた場合や処理を終了したい場合に使用。これがなければログアウトしたときに下記のif文も実行されてしまい、両方とも表示される
    }

    if (isset($_SESSION['logout'])) { //ログアウト状態（セッション変数にlogoutの値が入っている場合の表示）
        unset($_SESSION['login']);
        echo '<p>ログインしていません。</p>'; // ログインしていない場合の表示
        echo '<a href="form.php">ログインする</a>';
        return false; //明示的な値を指定する場合の違いが明確でない場合や、関数の戻り値を利用しない場合には、特に false や true を指定する必要ない
    }

    // ログアウト状態（セッション変数になにも入っていない場合の表示）＝新規ユーザー向け
    echo '<p>ログインしていません。</p>';
    echo '<a href="register_form.php">新規登録する</a><br>';
    echo '<a href="login_form.php">ログインする</a>';
}

$script = $_SERVER["SCRIPT_NAME"]; // このPHPファイルのパス
