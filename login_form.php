   <div class="wrap">
       <form action="login.php" method="GET">
           <!--送信エラー時に入力値が消えないようにvalueを設定-->
           <input type="text" name="user_mail" placeholder="メールアドレス"
               value="<?php echo isset($_GET['user_mail']) ? htmlspecialchars($_GET['user_mail']) : ''; ?>"><br>
           <?php
            if (isset($_GET["error_message"])) {
                $error_message = $_GET["error_message"];
                if ($error_message === "メールアドレスが違います") {
                    echo '<div style="color: red;">メールアドレスが違います</div>';
                }
            }
            ?>
           <?php
            if (isset($_GET["error_message"])) {
                $error_message = $_GET["error_message"];
                if ($error_message === "メールアドレスを入力してください") {
                    echo '<div style="color: red;">メールアドレスを入力してください</div>';
                }
            }
            ?>
           <input type="text" name="user_pass" placeholder="パスワード"><br>
           <?php
            if (isset($_GET["error_message"])) {
                $error_message = $_GET["error_message"];
                if ($error_message === "パスワードが違います") {
                    echo '<div style="color: red;">パスワードが違います</div>';
                }
            }
            ?>
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