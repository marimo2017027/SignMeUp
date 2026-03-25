<?php
/*
Template Name: login_input
固定ページ: ログイン画面
*/
header('X-FRAME-OPTIONS: SAMEORIGIN'); // クリックジャッキング対策
?>

<div class="bili-mini-login-right-wp">

    <!-- タブ -->
    <div class="login-tab-wp">
        <div class="login-tab-item active-tab">新規登録</div>
        <div class="login-tab-line"></div>
        <div class="login-tab-item">ログイン</div>
    </div>

    <style>
        /* -------------------------------
       基本設定
    -------------------------------- */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        *:focus {
            outline: none;
        }

        .bili-mini-login-right-wp {
            width: 100%;
            max-width: 760px;
            margin: 40px auto;
            padding: 0 20px 40px;
            font-family: "Hiragino Sans", "Yu Gothic", "Meiryo", sans-serif;
            color: #444;
        }

        /* -------------------------------
       タブ
    -------------------------------- */
        .login-tab-wp {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 26px;
            margin: 0 auto 28px;
        }

        .login-tab-item {
            font-size: 18px;
            font-weight: 600;
            color: #d96a98;
            cursor: pointer;
            transition: color 0.2s ease, opacity 0.2s ease;
        }

        .login-tab-item.active-tab {
            color: #e52d77;
            font-weight: 700;
        }

        .login-tab-item:hover {
            opacity: 0.85;
        }

        .login-tab-line {
            width: 1px;
            height: 24px;
            background: #ead2dc;
            flex: 0 0 auto;
        }

        /* -------------------------------
       フォーム全体
    -------------------------------- */
        .register_form {
            width: 100%;
            max-width: 680px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 18px;
            overflow: hidden;
        }

        .form_item {
            display: flex;
            align-items: center;
            min-height: 76px;
            padding: 0 24px;
            background: #fff;
        }

        .form_separator-line,
        .form_delimiter-line {
            width: 100%;
            height: 1px;
            background: #e8e8e8;
        }

        .form_label {
            flex: 0 0 140px;
            max-width: 140px;
            font-size: 18px;
            font-weight: 500;
            color: #333;
            white-space: nowrap;
        }

        .form_control {
            flex: 1 1 auto;
            min-width: 0;
            display: flex;
            align-items: center;
        }

        .form_control_with_button {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .form_item input[type="text"],
        .form_item input[type="email"],
        .form_item input[type="password"],
        .form_item input {
            width: 100%;
            min-width: 0;
            height: 44px;
            border: none;
            background: transparent;
            padding: 0;
            font-size: 18px;
            color: #444;
            line-height: 44px;
        }

        .form_item input::placeholder {
            color: #c7c7c7;
        }

        /* -------------------------------
       認証コード取得ボタン
    -------------------------------- */
        .login-email-send {
            flex: 0 0 180px;
            height: 44px;
            border: none;
            border-left: 1px solid #e8e8e8;
            background: #fff;
            color: #e52d77;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s ease;
            padding: 0 0 0 16px;
            text-align: center;
        }

        .login-email-send:hover {
            opacity: 0.85;
        }

        /* -------------------------------
       エラーメッセージ
    -------------------------------- */
        .error-msg {
            display: none;
            padding: 10px 24px 14px 164px;
            background: #fff;
        }

        .error-msg p {
            margin: 0;
            color: #e52d77;
            font-size: 14px;
            line-height: 1.6;
        }

        /* -------------------------------
       下部ボタン
    -------------------------------- */
        .btn_wp {
            display: flex;
            justify-content: center;
            max-width: 680px;
            margin: 22px auto 0;
        }

        .btn_primary {
            width: 100%;
            max-width: 420px;
            height: 48px;
            border-radius: 10px;
            border: 1px solid #e52d77;
            background: #e52d77;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn_primary:hover {
            background: #cc2067;
            border-color: #cc2067;
        }

        .btn_primary:active {
            transform: scale(0.98);
        }

        /* -------------------------------
       ダイアログ
    -------------------------------- */
        .dialog_mask {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 9999;
        }

        .dialog_outline {
            width: min(92%, 420px);
            margin: 100px auto 0;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.18);
        }

        .dialog_body {
            padding: 24px;
        }

        .body_title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 16px;
            text-align: center;
        }

        .body_captcha-img_wp {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .captcha-img_img {
            flex: 1;
            min-height: 90px;
            background: #f7f7f7;
            border-radius: 10px;
        }

        .captcha-img_btn {
            flex: 0 0 90px;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff1f6;
            color: #e52d77;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .body_captcha-input {
            width: 100%;
            height: 46px;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 16px;
        }

        .dialog_footer {
            display: flex;
            border-top: 1px solid #eeeeee;
        }

        .dialog_footer>div {
            flex: 1;
            min-height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            cursor: pointer;
        }

        .footer_submit_disabled {
            background: #e52d77;
            color: #fff;
        }

        .terms_item {
            min-height: auto;
            padding: 16px 24px;
        }

        .terms_label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }

        .terms_label input {
            width: 16px;
            height: 16px;
            accent-color: #e52d77;
            /* ピンク統一 */
            cursor: pointer;
        }

        .terms_label a {
            color: #e52d77;
            text-decoration: none;
            font-weight: 500;
        }

        .terms_label a:hover {
            text-decoration: underline;
        }

        .terms_item.is-error {
            border: 1px solid #e52d77;
        }

        /* -------------------------------
       スマホ
    -------------------------------- */
        @media (max-width: 768px) {
            .bili-mini-login-right-wp {
                padding: 0 14px 32px;
                margin-top: 24px;
            }

            .login-tab-wp {
                gap: 18px;
                margin-bottom: 20px;
            }

            .login-tab-item {
                font-size: 16px;
            }

            .form_item {
                min-height: 68px;
                padding: 0 16px;
            }

            .form_label {
                flex: 0 0 108px;
                max-width: 108px;
                font-size: 16px;
            }

            .form_item input[type="text"],
            .form_item input[type="email"],
            .form_item input[type="password"],
            .form_item input {
                font-size: 16px;
            }

            .login-email-send {
                flex: 0 0 128px;
                font-size: 14px;
                padding-left: 10px;
            }

            .error-msg {
                padding: 10px 16px 14px 124px;
            }

            .btn_primary {
                max-width: 360px;
                height: 46px;
                font-size: 15px;
            }
        }

        .btn_primary:disabled,
        .login-email-send:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn_primary.wait,
        .login-email-send.wait {
            pointer-events: none;
        }
    </style>

    <form method="post" class="register_form">

        <!-- メールアドレス -->
        <div class="form_item">
            <div class="form_label">メールアドレス</div>

            <div class="form_control form_control_with_button">
                <input
                    type="text"
                    id="input-email"
                    name="email"
                    maxlength="255"
                    placeholder="メールアドレスを入力してください">

                <button type="button" id="login-email-send" class="login-email-send">
                    認証コードを取得する
                </button>
            </div>
        </div>

        <!-- エラーメッセージ -->
        <div id="error-msg-email" class="error-msg" style="display: none;"></div>

        <div class="form_delimiter-line"></div>

        <!-- 検証コード -->
        <div class="form_item optional">
            <div class="form_label">認証コード</div>

            <div class="form_control">
                <input
                    type="text"
                    id="verification-code"
                    name="verification_code"
                    maxlength="32"
                    placeholder="認証コードを入力してください">
            </div>
        </div>

        <div class="form_separator-line"></div>

        <div class="form_item terms_item">
            <label class="terms_label">
                <input type="checkbox" id="agree" name="agree">
                <span>
                    <a href="/terms" target="_blank">利用規約</a>と
                    <a href="/privacy" target="_blank">プライバシーポリシー</a>
                    に同意する
                </span>
            </label>
        </div>

        <!-- 下部ボタン -->
        <div class="btn_wp">
            <button type="submit" class="btn_primary">登録/ログイン</button>
        </div>

    </form>

    <!-- ダイアログ -->
    <div class="dialog_mask" style="display: none;">
        <div class="dialog_outline">
            <div class="dialog_body">
                <div class="body_title">二次検証</div>

                <div class="body_captcha-img_wp">
                    <div class="captcha-img_img"></div>
                    <div class="captcha-img_btn">1つ変更</div>
                </div>

                <input
                    type="text"
                    placeholder="画像の内容を入力してください"
                    maxlength="5"
                    class="body_captcha-input">
            </div>

            <div class="dialog_footer">
                <div>キャンセル</div>
                <div class="footer_submit_disabled">もちろん</div>
            </div>
        </div>
    </div>

</div>

<script>
    // JSへ安全に値を渡す
    window.login_vars = {
        ajax_url: "<?php echo esc_js(admin_url('admin-ajax.php')); ?>",
        send_nonce: "<?php echo esc_js(wp_create_nonce('login_send_code')); ?>",
        submit_nonce: "<?php echo esc_js(wp_create_nonce('login_submit')); ?>"
    };

    document.addEventListener('DOMContentLoaded', function() {

        // =========================
        // 要素取得
        // =========================
        const inputEmail = document.getElementById('input-email'); // メール入力欄
        const inputCode = document.getElementById('verification-code'); // 認証コード入力欄
        const errDiv = document.getElementById('error-msg-email'); // エラー表示領域
        const btnSend = document.getElementById('login-email-send'); // 認証コード取得ボタン
        const agree = document.getElementById('agree'); // 利用規約チェック
        const btnSubmit = document.querySelector('.btn_primary'); // 登録/ログインボタン

        // 要素が無い場合はそこで終了
        if (!inputEmail || !inputCode || !errDiv || !btnSend || !btnSubmit) {
            return;
        }

        // 二度押し防止 / ローディング
        function toggleLoading(btn, isLoading, loadingText = '') {
            if (!btn) return;

            if (isLoading) {
                if (!btn.dataset.defaultText) {
                    btn.dataset.defaultText = btn.textContent;
                }
                btn.disabled = true;
                btn.classList.add('wait');
                btn.setAttribute('aria-busy', 'true');
                if (loadingText) {
                    btn.textContent = loadingText;
                }
            } else {
                btn.disabled = false;
                btn.classList.remove('wait');
                btn.removeAttribute('aria-busy');
                if (btn.dataset.defaultText) {
                    btn.textContent = btn.dataset.defaultText;
                }
            }
        }

        // 必要になった時用のJSエスケープ
        const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (m) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        } [m]));

        // =========================
        // エラーメッセージは1個だけ使い回す
        // =========================
        let emailErrorP = null;

        // エラー表示
        function setEmailError(message) {
            errDiv.style.display = 'block';

            if (!emailErrorP) {
                emailErrorP = document.createElement('p');
                errDiv.appendChild(emailErrorP);
            }

            emailErrorP.textContent = message;
        }

        // エラー非表示
        function clearEmailError() {
            errDiv.style.display = 'none';

            if (emailErrorP) {
                emailErrorP.textContent = '';
            }
        }

        // =========================
        // メールアドレス入力チェック
        // =========================
        function validateEmail() {
            const val = (inputEmail.value || '').trim();

            // trim後の値を入力欄へ戻す
            inputEmail.value = val;

            // 未入力チェック
            if (val === '') {
                setEmailError('メールアドレスが入力されていません。');
                return false;
            }

            // 形式チェック
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regex.test(val)) {
                setEmailError('無効なメールアドレスです。');
                return false;
            }

            clearEmailError();
            return true;
        }

        // =========================
        // 認証コード入力チェック
        // =========================
        function validateCode() {
            const val = (inputCode.value || '').trim();

            // trim後の値を入力欄へ戻す
            inputCode.value = val;

            // 未入力
            if (val === '') {
                alert('認証コードを入力してください。');
                return false;
            }

            return true;
        }

        // =========================
        // イベント
        // =========================

        // メール欄から離れた時にチェック
        inputEmail.addEventListener('blur', function() {
            validateEmail();
        });

        // メール欄に入ったらエラーを消す
        inputEmail.addEventListener('focus', function() {
            clearEmailError();
        });

        // チェックしたら赤枠戻す文字色も戻す
        if (agree) {
            agree.addEventListener('change', function() {
                const termsItem = document.querySelector('.terms_item');
                if (termsItem) {
                    termsItem.classList.remove('is-error');
                }
            });
        }

        // 認証コード取得ボタン
        btnSend.addEventListener('click', async function(e) {
            e.preventDefault();

            if (!validateEmail()) {
                return;
            }

            toggleLoading(btnSend, true, '送信中...');

            try {
                const fd = new FormData();
                fd.append('action', 'login_send_code');
                fd.append('nonce', window.login_vars?.send_nonce || '');
                fd.append('email', inputEmail.value.trim());

                const response = await fetch(window.login_vars.ajax_url, {
                    method: 'POST',
                    body: fd,
                    credentials: 'same-origin'
                });

                let data;
                try {
                    data = await response.json();
                } catch (err) {
                    throw new Error('サーバー応答の解析に失敗しました。');
                }

                if (!response.ok || !data.success) {
                    throw new Error(data?.data?.message || '認証コードの送信に失敗しました。');
                }

                alert(data.data?.message || '認証コードを送信しました。メールをご確認ください。');

            } catch (error) {
                alert(error.message || '認証コードの送信に失敗しました。');
            } finally {
                toggleLoading(btnSend, false);
            }
        });
        // });

        // ここから先は、実際の送信処理に合わせて変更
        // 例: form.submit() か fetch()
        // alert('入力チェックOKです。ここで登録/ログイン処理を呼び出します。');
        // 仮でこれだけでもOK
        btnSubmit.addEventListener('click', async function(e) {
            e.preventDefault();

            if (!validateEmail()) {
                return;
            }

            if (!validateCode()) {
                return;
            }

            toggleLoading(btnSubmit, true, '送信中...');

            try {
                const fd = new FormData();
                fd.append('action', 'login_submit');
                fd.append('nonce', window.login_vars?.submit_nonce || '');
                fd.append('email', inputEmail.value.trim());
                fd.append('verification_code', inputCode.value.trim());
                fd.append('agree', agree && agree.checked ? '1' : '0');

                const response = await fetch(window.login_vars.ajax_url, {
                    method: 'POST',
                    body: fd,
                    credentials: 'same-origin'
                });

                let data;
                try {
                    data = await response.json();
                } catch (err) {
                    throw new Error('サーバー応答の解析に失敗しました。');
                }

                if (!response.ok || !data.success) {
                    throw new Error(data?.data?.message || '登録/ログインに失敗しました。');
                }

                if (data.data?.redirect) {
                    window.location.href = data.data.redirect;
                    return;
                }

                alert(data.data?.message || '登録/ログインが完了しました。');

            } catch (error) {
                alert(error.message || '登録/ログインに失敗しました。');
                toggleLoading(btnSubmit, false);
            }
        });
    });
</script>