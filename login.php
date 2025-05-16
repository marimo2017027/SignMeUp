<?php
//-----データベースへの接続-----------------------------------------------------------------------------------------------------------------------------------------------------------
include 'login_db.php';

//-----フォームから受け取った情報を処理-----------------------------------------------------------------------------------------------------------------------------------------------------------
$user_pass = htmlspecialchars($_GET["user_pass"]); //この時点ではパスワードはハッシュ化しない
$user_mail = htmlspecialchars($_GET["user_mail"]);
// エラー時に表示する文言を配列に格納
$error_message = array(
    "error_user_mail" => "メールアドレスが違います",
    "error_user_mail_emp" => "メールアドレスを入力してください",
    "error_user_pass" => "パスワードが違います",
    "error_user_pass_emp" => "パスワードを入力してください",
);

if (!empty($user_mail) && !empty($user_pass)) { //メルアドと、名前、パスワードが空でない場合はtrue処理

    //既存ユーザー用処理。もしDBに既にあったら、insertせずにsessionIDだけ持たせる
    $check_infor = "SELECT * FROM users WHERE user_mail = :user_mail"; //sql文でメルアドの入ったカラムを指定。 {$user_name}で指定すると、「SQLインジェクション」と呼ばれるセキュリティ上の脆弱性を引き起こす
    $stmt = $db->prepare($check_infor); //上記sql文の実行準備
    $stmt->bindParam(':user_mail', $user_mail); //上記のselectのsql文では、まだ特定のユーザーを指定していないので、ここで:user_mail（プレースホルダ）を$user_mail（特定のユーザー）に指定する
    $stmt->execute(); //プレースホルダーにバインドされた値を含むクエリが実際にデータベースに送信。指定されたユーザー名と一致する行を検索し、結果セットを返す。
    if ($stmt->rowCount() > 0) { //rowCount() メソッドはデータベースクエリの結果セットに含まれる行数を取得し、その値が0より大きいかどうかを判定。
        //つまり特定のメルアド（$user_mail）の入ったカラムを検出した$stmtの行をカウント。もし$user_mail（ユニークユーザー）の入った行が１行あるか否かで条件分岐
        $user = $stmt->fetch(PDO::FETCH_ASSOC); //fetch() は結果セット（上記のメールに連なるカラム）から1行ずつデータを取得するために使用される。結果としてほしいカラムを抽出できる
        $hashed_password = $user['user_pass']; // データベースから取得したハッシュ化されたパスワード

        if (hash("sha512", $user_pass) === $hashed_password) { //ユーザーが入力したパスワードをハッシュ化し、DBに保存されているパスワードと一致するか確認
            // パスワードが一致する場合

            $user_id = $user['user_id']; //先ほどのdbをfetchした際に付随しているユーザーIDを配列操作で取得（セッションIDの引数として使う）
            include 'session.php';
            session_login($user_id);
            header("location: login_index.php"); // ページをリダイレクトする
            exit;
        } else {
            //パスワードが間違っている場合
            header("location: login_form.php?error_message=" . urlencode($error_message["error_user_pass"]) . "&user_mail=" . urlencode($user_mail));
        }
    } else { //メールアドレスが間違っている場合
        header("location: login_form.php?error_message=" . urlencode($error_message["error_user_mail"]) . "&user_mail=" . urlencode($user_mail));
        exit;
    }

    //どちらかが空の場合
} else if (empty($user_pass)) { //パスワードが空の場合
    header("location: login_form.php?error_message=" . urlencode($error_message["error_user_pass_emp"]) . "&user_mail=" . urlencode($user_mail));
    exit;
} else if (empty($user_mail)) { //メールアドレスが空の場合
    header("location: login_form.php?error_message=" . urlencode($error_message["error_user_mail_emp"]) . "&user_mail=" . urlencode($user_mail));
    exit;
}
