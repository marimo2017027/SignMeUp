    <div class="wrap">
        <form action="register.php" method="GET">
            <!--送信エラー時に入力値が消えないようにvalueを設定-->
            <!--変数がセットされているか調べる　htmlspecialcharsは特殊文字をHTMLエンティティに変換-->
            <input type="text" name="user_mail" placeholder="メールアドレス"
                value="<?php echo isset($_GET['user_mail']) ? htmlspecialchars($_GET['user_mail']) : ''; ?>"><br>
            <?php
            if (isset($_GET["error_message"])) {
                $error_message = $_GET["error_message"]; // パラメーターからエラーメッセージを取得
                if ($error_message === "メールアドレスを入力してください") {
                    echo '<div style="color: red;">メールアドレスを入力してください</div>';
                }
            }
            ?>
            <?php
            if (isset($_GET["error_message"])) {
                $error_message = $_GET["error_message"];
                if ($error_message === "既に使われているメールアドレスです") {
                    echo '<div style="color: red;">既に使われているメールアドレスです</div>';
                }
            }
            ?>
            <input type="text" name="user_name" placeholder="ユーザー名"
                value="<?php echo isset($_GET['user_name']) ? htmlspecialchars($_GET['user_name']) : ''; ?>"><br>
            <?php
            if (isset($_GET["error_message"])) {
                $error_message = $_GET["error_message"];
                if ($error_message === "ユーザー名を入力してください") {
                    echo '<div style="color: red;">ユーザー名を入力してください</div>';
                }
            }
            ?>
            <input type="text" name="user_pass" placeholder="パスワード"
                value="<?php echo isset($_GET['user_pass']) ? htmlspecialchars($_GET['user_pass']) : ''; ?>"><br>
            <?php
            if (isset($_GET["error_message"])) {
                $error_message = $_GET["error_message"];
                if ($error_message === "パスワードを入力してください") {
                    echo '<div style="color: red;">パスワードを入力してください</div>';
                }
            }
            ?>
            <input type="submit">
        </form>
    </div>