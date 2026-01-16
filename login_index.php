<?php
/*
Template Name: login_index
固定ページ: ログイン画面　文字列チェック
*/
?>



<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
// REST API やフォーム送信などユーザー入力に関係する処理には入れておくべき
header('X-FRAME-OPTIONS: SAMEORIGIN');

// session_start();

// エラーメッセージ
// $error_mes = "";

// ユーザーからPOSTされた情報を受け取る（仮登録）
// ?? '' は、null 合体演算子 $_POST['name'] が「存在していて、かつ null ではない」なら、その値を $name に入れる
// もし「存在しない」または「null だった」ら、代わりに ''（空文字）を $name に代入する
// フォームから name が送られてきたらその値を使う、送られてこなかったら（例えば入力されなかったとか、そもそも name というキーがないとか）、空文字にする
// $name = $_POST['name'] ?? '';
// $email = $_POST['email'] ?? '';
// $name = $_POST['name'];
// $mail = $_POST['mail'];

/* 危険文字列置換ファンクション */
function Chk_StrMode($str)
{
    $str = strip_tags($str);
    $str = mb_ereg_replace('^(　){0,}', '', $str);
    $str = mb_ereg_replace('(　){0,}$', '', $str);
    $str = trim($str);
    $str = htmlspecialchars($str);
    return $str;
}

/* 未入力チェックファンクション */
function Chk_InputMode($str, $mes)
{
    $errmes = '';
    if ('' == $str) {
        $errmes .= "{$mes}<br>\n";
    }
    return $errmes;
}

// 32バイトの安全なランダムバイナリデータを生成。バイナリデータを Base64 に変換。Base64 の「+」「/」を、URLで安全な「-」「_」に変換（Base64URL形式）。末尾の =（パディング）を削除。
function token_urlsafe($length = 32)
{
    return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
}

// 変数 $csrf_token が設定されているかどうかを確認し、その値をHTMLエスケープして $csrf_token に代入する（確認画面に表示する場合に必要）
// $csrf_token = isset($csrf_token) ? htmlspecialchars($csrf_token, ENT_QUOTES) : '';

// 送られてきた情報をチェックする
// 現在のリクエストの情報を取得するために使用できる
function handle_register_request(WP_REST_Request $request)
{
    // リクエストに Content-type: application/json ヘッダが設定されていて、ボディに有効な JSON がある場合、 get_json_params() は解析した JSON ボディを連想配列として返します。
    $params = $request->get_json_params();

    // 入力検証とサニタイズ (エラーがあれば WP_REST_Response を返し、即終了。)
    // validate_input() は別途定義された関数で、入力内容（例：メール形式か？名前が空でないか？）をチェック。
    // $validated = validate_input($params);
    function validate_input($params)
{
    $errors = '';
    $clean = [];

// 危険文字除去（Chk_StrMode）
foreach ($params as $k => $v) {
    $clean[$k] = Chk_StrMode($v);
}

// 必須チェック（ただしメッセージは返さず、400だけ返す）
if (empty($clean['namae']) || empty($clean['email'])) {
    return new WP_REST_Response(null, 400);
}

    if ($validated instanceof WP_REST_Response) {
        return $validated;
    }

    // バリデーション済みの email と namae を取り出します。
    $email = $validated['email'];
    $name  = $validated['namae'];

    // 既にユーザーが存在するかをチェック
    if (email_exists($email)) {
        // 既存ユーザーへの案内メール送信（テキスト形式）
        $subject = '【イラスト掲示板】会員登録認証メール';
        $message = <<<EOT
「ログイン会員サービス」をご登録いただき、ありがとうございます。

このメールアドレスはすでに登録されています。
1つのメールアドレスで、複数のアカウントを登録することはできません。

IDを忘れた方:
https://example.com/forgot-id

【お問い合わせ・ご質問はこちら】
support@talk-technologies.com

■注意点
.このメールに心当たりがない場合は、メールを破棄してください。
.このメールは送信専用です。返信はできませんのでご了承ください。
EOT;
    } else {
        // トークン生成と有効期限設定
        // $token という変数をメールアドレスに送信する
        $token = token_urlsafe(32);
        // 現在の時刻から10分後の日時を、Y-m-d H:i:s という形式で文字列にして、$expires に代入する
        // トークンと有効期限をDBに保存
        $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // DBへトークン保存（例：ユーザーメタに仮登録データを保存）
        global $wpdb;
        $table_name = $wpdb->prefix . 'registration_tokens';
        $wpdb->insert($table_name, [
            'email'   => $email,
            'token'   => $token,
            'expires' => $expires,
            'name'    => $name,
            'status'  => 'pending',
            'created_at' => current_time('mysql'),
        ]);




        $subject = '【イラスト掲示板】会員登録認証メール';
        $message = <<<EOT
    認証コード: {$token}

「ログイン会員サービス」をご登録いただき、ありがとうございます。

会員登録はまだ完了していません。
以下の認証コードを入力画面に入力してください。

この認証コードの有効時間は10分間です。
期限を過ぎた場合は、会員登録をやり直してください。

【お問い合わせ・ご質問はこちら】
support@talk-technologies.com

■注意点
.このメールに心当たりがない場合は、メールを破棄してください。
.このメールは送信専用です。返信はできませんのでご了承ください。
EOT;
    }

    // メール送信（テキスト形式）
    // クライアントには**「送信しました」とだけ返す**（セキュリティ対策のため）、その裏で wp_mail() を使って、ユーザーにはきちんと通知メールを送る
    wp_mail($email, $subject, $message, [
        'Content-Type: text/plain; charset=UTF-8'
    ]);

    // クライアント側には一律同じレスポンスを返す
    return new WP_REST_Response([
        'message' => '確認メールを送信しました。'
    ], 200);
}

// string は $mail という引数が「文字列型」であることを表しています。
// : bool は「この関数は 戻り値（returnする値）として、boolean型（trueかfalse）を返しますよ」という意味です。
// 「文字列 $mail を受け取って、結果を真偽値（true または false）で返す関数」という宣言になります
function checkmail(string $mail): bool
{
    // 文字列 $mail を \`@\` を区切り文字として分割し、その結果を配列 $array に格納します。つまり、メールアドレスをユーザー名とドメインに分割します。
    $array = explode('@', $mail);
    // 配列 array の最後の要素の値を取り出して返します
    $domain_part = array_pop($array);
    // Filter 関数 の filter_var と ネットワーク関数 の checkdnsrr を利用してバリデーションを実装
    // FILTER_VALIDATE_EMAIL は RFC 822 に準拠しているメールアドレスか否かを検証します。
    // ネットワーク関数 の checkdnsrr を利用します。第二引数の DNS レコードの種類には、MX, A, AAAA を指定します。又、第二引数の既定値は MX です。
    // これで、メール送信の可不可を確認することができます。
    return filter_var($mail, FILTER_VALIDATE_EMAIL) !== false &&
        (checkdnsrr($domain_part) || checkdnsrr($domain_part, 'A') || checkdnsrr($domain_part, 'AAAA'));
}

// 先頭から末尾まで、文字（漢字・ひらがな・英字）、数字、スペース、ハイフンだけで構成されているかチェックする
if (!preg_match('/^[\p{L}\p{N}\s\-]+$/u', $name)) {
    die('不正な名前です');
}

// サニタイズ（タグ除去）
$name = strip_tags($name);

/* ======================================================================================================== */

// テンプレートとなるhtmlファイルを読み込む
// $html = file_get_contents('user_regist.html');

// htmlファイルの変更したい部分を変換する
// $html = str_replace('#error_message#', htmlspecialchars($error_message), $html);
// $html = str_replace('#mail#', htmlspecialchars($mail), $html);

// 変換したhtmlを表示する
// print($html);
?>

<script>

</script>