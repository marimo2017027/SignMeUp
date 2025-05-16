
<div class="form_item">
                    <!-- 入力された情報をサーバのAPIにPOSTで送信 -->
                    <!-- <div id="input_form"> -->
                    <!-- <div class="login-inputWrapper"></div> -->
                    <!-- hiddenで生成したトークンを埋め込む -->
                    <!-- oninputプロパティは一定時間操作が無かったら処理を実行させる関数 -->
                    <!-- <input type="hidden" id="input-email" name="csrf_token" maxlength="255" value="'.$csrf_token.'" placeholder="メールアドレスを入力してください"> -->
                    <input type="text" id="input-email" name="csrf_token" maxlength="255" placeholder="メールアドレスを入力してください">

                    <div class="login-email_vertical-line"></div>

                    <!-- エラーメッセージを表示する -->
                    <div id="error-msg-email" class="error-msg" style="display: none;"></div>

                    <!-- 認証コードを取得するボタン -->
                    <div class="login-email-send">
                        <span style="vertical-align: inherit;">認証コードを取得する</span>
                    </div>
                </div>

<div class="form_item">
            <div>
                <span style="vertical-align: inherit;">
                    <span style="vertical-align: inherit;">ハンドルネーム</span>
                </span>
            </div><input type="text" id="input-name" placeholder="ハンドルネームを入力してください" maxlength="6">
        </div>

        <!-- ハンドルネームとパスワードの間 -->
        <div class="form_delimiter-line"></div>
        <div class="form_item">
            <div>
                <span style="vertical-align: inherit;">
                    <span style="vertical-align: inherit;">ワンタイムパスワード</span>
                </span>
            </div><input type="password" id="input-password" placeholder="ワンタイムパスワードを入力してください" maxlength="6">
        </div>