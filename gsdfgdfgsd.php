<div class="bili-mini-login-right-wp">
    <div data-v-35ff7abe="" class="login-tab-wp">
        <div data-v-35ff7abe="" class="login-tab-item">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">パスワードログイン</font>
            </font>
        </div>
        <div data-v-35ff7abe="" class="login-tab-line"></div>
        <div data-v-35ff7abe="" class="login-tab-item active-tab">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">SMSログイン</font>
            </font>
        </div>
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

                <div class="login-inputWrapper"></div>
                <!-- hiddenで生成したトークンを埋め込む -->
                <!-- oninputプロパティは一定時間操作が無かったら処理を実行させる関数 -->
                <input type="hidden" id="input-email" name="csrf_token" maxlength="15" oninput="value=value.replace(/[^\d]/g, '')" placeholder="メールアドレスを入力してください" value="<?= $csrf_token; ?>">
                <div id="error-msg-email" class="error-msg" style="display: none;"></div>

                <div class="login-email_vertical-line"></div>
                <div class="login-email-send clickable disabled">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">認証コードを取得する</font>
                    </font>
                </div>
            </div>


            <div class="form__separator-line"></div>
            <div class="form__item">
                <div>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">検証コード</font>
                    </font>
                </div><input placeholder="確認コードを入力してください" maxlength="6" oninput="value=value.replace(/[^\d]/g, '')">
            </div>
        </form>

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
                // メールアドレス形式チェック
                var regex = new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/);
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


            ===
            ===
            ===
            ===
            ===
            ===
            ===
            ===
            ===
            ===
            === === === === === === === === === === === === === === === === === === ==


            // フォーム送信前に検証
            const formRegisterForm = document.querySelectorAll('.register_form');
            formRegisterForm.addEventListener('blur', (event) => {
                if (!validateEmail(emailInput.value)) {
                    event.preventDefault(); // フォーム送信を阻止
                    errorDiv.textContent = '有効なメールアドレスではありません。';
                } else {
                    errorDiv.textContent = '';
                }
            });
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