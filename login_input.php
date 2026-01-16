<?php
/*
Template Name: login_input
固定ページ: ログイン画面
*/
?>

<div class="bili-mini-login-right-wp">
    <div data-v-35ff7abe="" class="login-tab-wp">
        <div data-v-35ff7abe="" class="login-tab-item">
            <span style="vertical-align: inherit;">
                <span style="vertical-align: inherit;">パスワードログイン</span>
            </span>
        </div>
        <div data-v-35ff7abe="" class="login-tab-line"></div>
        <div data-v-35ff7abe="" class="login-tab-item active-tab">
            <span style="vertical-align: inherit;">
                <span style="vertical-align: inherit;">SMSログイン</span>
            </span>
        </div>


        <style>
            /* フォーカスが当たった時の青枠を表示しない */
            *:focus {
                outline: none;
            }

            /* 項目名用のラベル（今回はラベルなしデザイン）
        div.input-area label {
            display: inline-block;
            width: 8rem;
            text-align: right;
        } */

            /* エラーメッセージのスタイル */
            div.error-msg p {
                color: #e52d77;
                margin: 0 0 0 8rem;
            }

            /* 入力欄 */
            input[type="email"] {
                line-height: 2em;
            }

            /* 入力エラーがあった時のスタイル（エラーがあった時は枠の色は分かりずらいので変更せずエラー文のみ表示させる）
        .input-error {
            border: 1px solid #e52d77;
            border-radius: 3px;
            background-color: #FCC;
        }  */

            /* クリック時に枠の色を変更 */
            ○○○:hover {
                border: 2px solid #000;
            }
        </style>


        <div class="login-email">
            <form method="post" class="register_form">
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

                <div class="form_delimiter-line"></div>

                <!-- 検証コード入力欄を追加する場所 -->
                <div class="form_item optional">
                    <div>
                        <span style="vertical-align: inherit;">
                            <span style="vertical-align: inherit;">検証コード</span>
                        </span>
                    </div>
                    <input placeholder="認証コードを入力してください">
                    <button type="button" id="form_submitVerification">送信</button>
                </div>
                <!-- </div> -->
                <!-- </form> -->
            </form>
        </div>




        <div class="form_separator-line"></div>
        <div class="form_item">
            <div>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">ハンドルネーム</font>
                </font>
            </div><input placeholder="ハンドルネームを入力してください" maxlength="6" oninput="value=value.replace(/[^\d]/g, '')">
        </div>

        <div class="form_separator-line"></div>
        <div class="form_item">
            <div>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">検証コード</font>
                </font>
            </div><input placeholder="確認コードを入力してください" maxlength="32" oninput="value=value.replace(/[^\d]/g, '')">
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
        <!-- ↑追加 -->
        <!-- </div> -->
        </form>
    </div>

    <script>
        // メールアドレスの入力チェック
        var inputEmail = document.getElementById('input-email');

        /**
         * フォーカスが外れた場合のイベントハンドラ
         */
        inputEmail.addEventListener('blur', function() {
            // 入力されたメールアドレスを取得してトリム（データの不要な部分を削除し、必要な部分だけを残して値を設定し直す）して値を設定し直す
            // 通常は値の設定前に文字列の先頭と末尾の空白を削除するためにトリムする必要があります。
            inputEmail.value = inputEmail.value.trim();

            // 入力チェック
            // カスタムバリデーション名
            validate_email();
        });

        /**
         * メールアドレスの入力チェック
         */
        function validate_email() {

            var val = inputEmail.value;

            // 必須チェック
            if (val == "") {
                // エラーメッセージの作成
                var err_msg = document.createElement('p');
                err_msg.textContent = 'メールアドレスが入力されていません。';

                // エラーメッセージの表示領域
                // var err_msg_div = document.querySelectorAll('#error-msg-email');
                var err_msg_div = document.getElementById('error-msg-email');

                // エラーメッセージの表示領域を表示する
                err_msg_div.style.display = "block";

                // エラーメッセージの表示領域にエラーメッセージを追加
                err_msg_div.appendChild(err_msg);

                // 入力欄にinput-errorクラスを追加（入力フォームの色を変更）
                // input_email.setAttribute('class', 'input-error');

                return;
            }
            // メールアドレス形式チェック（RFC 5322 に準拠したメールアドレス正規表現 をベース）
            var regex = new RegExp("^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21\\x23-\\x5b\\x5d-\\x7f]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21-\\x5a\\x53-\\x7f]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])+))\\]$");;
            if (!regex.test(val)) {
                // エラーメッセージの作成
                var err_msg = document.createElement('p');
                err_msg.textContent = '無効なメールアドレスです。';

                // エラーメッセージの表示領域
                var err_msg_div = document.getElementById('error-msg-email');

                // エラーメッセージの表示領域を表示する
                err_msg_div.style.display = "block";

                // エラーメッセージの表示領域にエラーメッセージを追加
                err_msg_div.appendChild(err_msg);

                // 入力欄にinput-errorクラスを追加（入力フォームの色を変更）
                // input_email.setAttribute('class', 'input-error');

                return;
            }
        }

        /**
         * フォーカスが当たった場合のイベントハンドラ
         */
        input_email.addEventListener('focus', function() {

            // input-errorクラスを削除
            input_email.classList.remove('input-error');

            // エラーメッセージの表示領域を非表示にする
            document.getElementById('error-msg-email').style.display = "none";

            // エラーメッセージを削除
            document.getElementById('error-msg-email').children[0].remove();
        });

        const login_email_send = function() {
            const loginEmailSend = document.getElementById("login-email-send");
            // 2度押し禁止
            loginEmailSend.disabled = true;
        }

        // 取得したボタンにクリックイベントを追加します。非同期関数は、ボタンがクリックされたときに実行される処理を記述します。
        document.querySelectorAll(".login-email-send").addEventListener('click', async () => {
            // 入力フォーム生成
            /* divタグ要素作成 */
            const divFormItemOptional = document.createElement('div');
            // class属性の値を追加
            divFormItemOptional.setAttribute('class', 'form_item optional');
            /* divタグ要素作成 */
            let div = document.createElement('div');
            // 要素のスタイルを取得・設定
            // span.style.verticalAlign = 'inherit';
            /* spanタグ要素作成（<font> タグは HTML5では廃止です。） */
            span = document.createElement('span');
            // 要素のスタイルを取得・設定
            // span.style.verticalAlign = 'inherit';
            // タグにテキスト挿入
            span.textContent = "検証コード";
            /* inputタグ要素作成 */
            let input = document.createElement("input");
            input.placeholder = '認証コードを入力してください';

            /* ワンタイムトークン入力画面要素配置位置 */
            const formRegisterForm = document.querySelectorAll(".register_form");
            formRegisterForm.appendChild(divFormItemOptional); // form (親要素) の末尾に div を追加

            /* divタグ要素配置位置 */
            divFormItemOptional.appendChild(div); // div (子要素) の末尾に div を追加

            /* spanタグ要素配置位置 */
            div.appendChild(span); // div (孫要素) の末尾に span を追加

            /* inputタグ要素配置位置 */
            divFormItemOptional.appendChild(input); // div (子要素) の末尾に input を追加


            // すでにフォームがあれば削除
            divFormItemOptional = "";

            // サーバーにデータを送信する際に使用するオブジェクトを生成
            // メールアドレス以外にハンドルネームとパスワードを入力させる場合
            // const formData = new FormData(formRegisterForm);
            // メールアドレスのみ入力させる場合
            const formData = new FormData(inputEmail);
            //オブジェクト内の既存のキーに新しい値を追加
            formData.append("action", "bbs_login_input");
            const opt = {
                method: "post",
                body: formData
            }
            // 非同期通信
            // 送信先の URL（WordPress のカスタム REST API エンドポイント）
            fetch('/wp-json/custom-auth/v1/register', {
                    method: 'POST',
                    // 「送るデータは JSON 形式ですよ」とサーバーに伝える
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: 'tanaka',
                        password: 'secure_pass',
                        code: '123456'
                    })
                })
                .then(json => {
                    if (json.error != "") {
                        alert(json.error);
                        return;
                    }
                    name_value = json.name;
                    text_value = json.text;
                })
        })
    </script>



    <div data-v-327e145a="" class="btn_wp" style="justify-content: center;"><!---->
        <div data-v-327e145a="" class="btn_primary ">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">ログイン/登録</font>
            </font>
        </div>
    </div>
    <div class="dialog__mask" style="display: none;">
        <div class="dialog__outline">
            <div class="dialog__body">
                <div class="body__title">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">二次検証</font>
                    </font>
                </div>
                <div class="body__captcha-img_wp">
                    <div class="captcha-img__img"><!----></div>
                    <div class="captcha-img__btn">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">1つ変更</font>
                        </font>
                    </div>
                </div><input placeholder="画像の内容を入力してください" maxlength="5" class="body__captcha-input">
            </div>
            <div class="dialog__footer">
                <div>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">キャンセル</font>
                    </font>
                </div>
                <div class="footer__submit_disabled">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">もちろん</font>
                    </font>
                </div>
            </div>
        </div>
    </div>
</div>
</div>