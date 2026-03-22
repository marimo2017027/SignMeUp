<?php
/*
Template Name: login_input
固定ページ: ログイン画面
*/
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
        .dialog__mask {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 9999;
        }

        .dialog__outline {
            width: min(92%, 420px);
            margin: 100px auto 0;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.18);
        }

        .dialog__body {
            padding: 24px;
        }

        .body__title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 16px;
            text-align: center;
        }

        .body__captcha-img_wp {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .captcha-img__img {
            flex: 1;
            min-height: 90px;
            background: #f7f7f7;
            border-radius: 10px;
        }

        .captcha-img__btn {
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

        .body__captcha-input {
            width: 100%;
            height: 46px;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 16px;
        }

        .dialog__footer {
            display: flex;
            border-top: 1px solid #eeeeee;
        }

        .dialog__footer>div {
            flex: 1;
            min-height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            cursor: pointer;
        }

        .footer__submit_disabled {
            background: #e52d77;
            color: #fff;
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
    </style>

    <form method="post" class="register_form">

        <!-- メールアドレス -->
        <div class="form_item">
            <div class="form_label">アカウント</div>

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
            <div class="form_label">検証コード</div>

            <div class="form_control">
                <input
                    type="text"
                    id="verification-code"
                    name="verification_code"
                    maxlength="32"
                    placeholder="認証コードを入力してください">
            </div>
        </div>

        <input type="hidden" name="csrf_token" value="<?php echo esc_attr($csrf_token); ?>">

    </form>

    <!-- 下部ボタン -->
    <div class="btn_wp">
        <button type="submit" class="btn_primary">登録/ログイン</button>
    </div>

    <!-- ダイアログ -->
    <div class="dialog__mask" style="display: none;">
        <div class="dialog__outline">
            <div class="dialog__body">
                <div class="body__title">二次検証</div>

                <div class="body__captcha-img_wp">
                    <div class="captcha-img__img"></div>
                    <div class="captcha-img__btn">1つ変更</div>
                </div>

                <input
                    type="text"
                    placeholder="画像の内容を入力してください"
                    maxlength="5"
                    class="body__captcha-input">
            </div>

            <div class="dialog__footer">
                <div>キャンセル</div>
                <div class="footer__submit_disabled">もちろん</div>
            </div>
        </div>
    </div>

</div>