<?php
function send_mail($user_name, $user_mail)
{ // $user_name, $user_pass, $user_mail を使用してメールの処理を行う（引数の内容はregister.phpで呼び出されたときに定義されている）
    // 言語とエンコードをセット（お作法として覚えておく）
    mb_language("Japanese"); //日本語の文字列処理やエンコードが必要な場合には、mb_language("Japanese")を設定しておく
    mb_internal_encoding("UTF-8"); //文字エンコーディング
    //送信者を宛名をセット
    $from = "送り主のアドレス"; //送信元
    $to = $user_mail; //充て先。（register.phpで定義）
    //メールヘッダー作成
    $encodedFrom = mb_encode_mimeheader($from); //念のため送信元をエンコードしておく（特殊な文字列が使われなければ不要）
    $header = "From: $encodedFrom\n";
    $header .= "Replay-to: $encodedFrom";
    //件名や本文をチェック
    $subject = "登録メールのテスト";
    $body = "こんにちは{$user_name}さん。メールの本文（テスト）です。"; //。$user_nameはregister.phpで定義
    //日本語メール送信
    $r = mb_send_mail($to, $subject, $body, $header);
    //mb_send_mail(宛先, 件名, 本文, 追加ヘッダー); 追加ヘッダーには送信者（from）や返信先（to）が入っている
    if ($r) { //もしmb_send_mail関数が実行して成功（true）したら
        echo "メール送信成功";
    } else {
        echo "メール送信失敗";
    }
}
