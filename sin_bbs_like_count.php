<?php
/*
Template Name: sin_bbs_lile_count
固定ページ: いいねボタン2
*/
?>
<!-- いいねのクリックイベント -->
<script>
    let nongood = document.getElementById("nongood");
    let kazu = code.length;
    //let kazu = count(code);

    kazu.forEach(code.length => {
        // +[]は0
        let good = +code[i];
        let iine = +code[i];
        good = document.getElementById("good" + code[i]);
        iine = document.getElementById("iine" + code[i]);
        //いいねボタンをクリックした時にイベントが発生
        good.addEventListener("click", () => {
            //good.classList.toggle('クラス名');
            //指定された文字列がリスト内にあるかどうかを示す
            if (good.classList.contains('on')) {
                //要素を削除
                good.classList.remove('on');
                //要素を追加
                good.classList.add('off');
                //取り消しでいいね数を-1して出力
                iine.textContent = g_iine[i] - 1;
                g_iine[i] = g_iine[i] - 1;
            } else {
                good.classList.remove('off');
                good.classList.add('on');
                //いいねで総数+1
                iine.textContent = g_iine[i] + 1;
                g_iine[i] = g_iine[i] + 1;
            }
            //$("#good11").on("click",function(){
            //console.log(code[0]);
            //FormData オブジェクトをインスタンス化したら append() メソッドを呼び出すことでフィールドに追加することができる
            formData.append("action", "like_dislike_button");
            //フォームの入力値を送信
            const require = {
                method: "post",
                body: formData,
                data: {
                    "post_id": code[i],
                    "unique_id": unique
                }
            }

            /*
            fetch("<?php echo home_url('wp-admin/admin-ajax.php'); ?>", require)
                .then(res => {
                    // return data.json();
                })
                .then(date => {
                    //ここにいいね機能の表示コードを書かないとリアルタイムで反映させることが出来ないのでは…？
                })

                .catch(error => {
                    console.log(error);
                });
            */
            //dataType : "json"
        });
    });
</script>

<!-- いいねをデータベースに登録 -->
<?php
//もしいいねテーブルにて質問IDといいねを押した UUID（IPアドレス）と照合させる
if (!empty($_POST["post_id"]) === true or !empty($_POST["unique_id"]) === true) {
    //and (date("w") != 6) {

    //require_once("/common.php");

    //$post = sanitize($_POST);
    $post_id = $_POST["post_id"];
    $unique_id = $_POST["unique_id"];

    // $wpdbでSQLを実行
    global $wpdb;

    // goodテーブルから k_code（質問を一意に識別する番号）と g_unique（いいねを押した UUID（IPアドレス））が一致したレコードを取得するSQL文
    $sql = "SELECT * FROM good WHERE k_code=%s AND g_unique=%s";
    // エスケープ処理されたSQL文をクエリ実行
    $query = $wpdb->prepare(
        $sql,
        $post_id,
        $unique_id
    );

    $data = array();

    //Wordpress で SELECT クエリからすべてのデータを連想行の配列として取得する
    $rec = $wpdb->get_results($query, ARRAY_A);

    //もしいいねテーブルにて質問IDといいねを押した UUID（IPアドレス）が存在しなければ
    if (!empty($rec) === true) {
        // goodテーブルから k_code（質問を一意に識別する番号）と g_unique（いいねを押した UUID（IPアドレス））が一致したレコードを取得するSQL文
        $sql = "DELETE * FROM good WHERE k_code=%s AND g_unique=%s";
        // エスケープ処理されたSQL文をクエリ実行
        $query = $wpdb->prepare($sql, $post_id, $unique_id);

        $data = array();
        //header('Content-type: application/json; charset=utf-8');
    } else {
        $sql = "INSERT INTO good(k_code, g_unique, good) VALUES(?,?,1)";
        // エスケープ処理されたSQL文をクエリ実行
        $query = $wpdb->prepare($sql, $post_id, $unique_id);

        //header('Content-type: application/json; charset=utf-8');
    }
}
?>

<!-- いいねの表示について -->
<?php
//データベース接続
global $wpdb;

//lile_countテーブルから m_w（ユーザーの回答）のレコードを取得するSQL文
$sql = "SELECT * FROM lile_count WHERE m_w = %s ORDER BY time DESC";
// エスケープ処理されたSQL文をクエリ実行
$query = $wpdb->query($wpdb->prepare($sql));
$data[] = $day;
// エスケープ処理されたSQL文をクエリ実行
$query = $wpdb->query($wpdb->prepare($data));
$data = array();
//$dbh = null;

//while文とは、繰り返し処理の１つで、指定された条件式がTrueの間は処理が繰り返し実行されます。
//ユーザーの回答はトップ画面にカード形式で反映
while (true) {
    //Wordpress で SELECT クエリからすべてのデータを連想行の配列として取得する
    $rec = $wpdb->get_results($query, ARRAY_A);

    //もしデータがなければ終了する
    if (empty($rec) === true) {
        break;
    }
    //print '<div class="card">';
    //print '<div class="card-in">';
    //print '<div class="ico">';

    //userテーブルから name（名前）のレコードを取得するSQL文
    $sql = "SELECT img FROM user WHERE name=%s";
    // エスケープ処理されたSQL文をクエリ実行
    $wpdb2 = $wpdb->query($wpdb->prepare($sql));

    $data[] = $rec["name"];
    // エスケープ処理されたSQL文をクエリ実行
    $wpdb2 = $wpdb->query($wpdb->prepare($data));
    $data = array();
    //$rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    //Wordpress で SELECT クエリからすべてのデータを連想行の配列として取得する
    $rec2 = $wpdb2->get_results('SELECT * FROM user', ARRAY_A);

    /*ユーザーアイコン画像は必要ない
    //もしユーザーアイコン画像がなければ
    if (empty($rec2["img"]) === true) {
        $nanasi = "nanasi.png";
        $disp_gazou = "<img src='./img/" . $nanasi . "'>";
        //画像を出力する
        print $disp_gazou;
    } else {
        $disp_gazou = "<img src='./img/" . $rec2['img'] . "'>";
        print $disp_gazou;
    }
    print "</div>";
    print '<div class="bun">';
    print '<div class="time">';
    print date('Y年n月j日 g:i', strtotime($rec["time"]));
    print '</div>';
    print '<div class="name">';
    print $rec["name"];
    print '</div>';
    print '</div>';
    print '</div>';
    print '<div class="kaitou">';
    print $rec["comment"];
    print "</div>";
    */
    $code = $rec["code"];
    print "<div class='goodiine'>";

    //もし名前がなければ
    if (!empty($name) === true) {
        //goodテーブルから k_code（質問を一意に識別する番号）と g_unique（いいねを押した UUID（IPアドレス））のレコードを取得するSQL文
        $sql = "SELECT * FROM good WHERE k_code=%s AND g_unique=%s";
        // エスケープ処理されたSQL文をクエリ実行
        $wpdb3 = $wpdb->query($wpdb->prepare($sql));
        $data[] = $rec["code"];
        $data[] = $name;
        // エスケープ処理されたSQL文をクエリ実行
        $wpdb3 = $wpdb->query($wpdb->prepare($data));
        $data = array();
        //Wordpress で SELECT クエリからすべてのデータを連想行の配列として取得する
        $rec2 = $wpdb3->get_results('SELECT * FROM user', ARRAY_A);

        //もし名前がテーブルに存在しなければ
        if ($rec["name"] === $name) {
            print "<div class='clear'>";
            print "<form action='sakujyo.php' method='post'>";
            print "<input type='hidden' name='re' value='" . $code . "'>";
            print "<input type='submit' value='回答を削除'>";
            print "</form>";
            print "</div>";
            print "<div id='good$code'><img src='./img/ハートのマーク3.png'></div>";
            //$code = "non";
            //存在していれば
        } else if (!empty($rec3) === true) {
            //print "<div id='good$code' class='on'>&hearts;</div>";
            print "<div id='good$code' class='on'><img src='./img/ハートのマーク3.png'></div>";
        } else {
            print "<div id='good$code'><img src='./img/ハートのマーク3.png'></div>";
        }
    } else {
        print "<div id='good$code'><img src='./img/ハートのマーク3.png'></div>";
    }

    //goodテーブルから k_code（質問を一意に識別する番号）のレコードを取得するSQL文
    $sql = "SELECT * FROM good WHERE k_code=%s";
    // エスケープ処理されたSQL文をクエリ実行
    $wpdb4 = $wpdb->query($wpdb->prepare($sql));
    //回答を一意に識別する番号
    $data[] = $code;
    // エスケープ処理されたSQL文をクエリ実行
    $wpdb4 = $wpdb->query($wpdb->prepare($data));
    $data = array();
    $iine = 0;

    while (true) {
        //Wordpress で SELECT クエリからすべてのデータを連想行の配列として取得する
        $rec4 = $wpdb4->get_results('SELECT * FROM user', ARRAY_A);
        //もしいいねがなければ
        if (!empty($rec4["good"]) === true) {
            //いいねを登録する
            $g_i[] = $rec4["good"];
        } else {
            break;
        }
        //いいね数をカウントする
        $iine = count($g_i);
    }
    $g_i = array();
    print "<div id='iine$code'>$iine</div>";
    print "</div>";
    print "</div>";
    //もし名前がなければ
    if (!empty($name) === true) {
        //登録する
        if ($rec["name"] === $name) {
            $code = "non";
        }
    }
    $k_code[] = $code;
    $g_iine[] = $iine;
}
//もしいいね数がカウントされてなければ
if (!empty($g_iine) === true) {
    $g_iine = json_encode($g_iine);
}
//もし質問を一意に識別する番号がなければ
if (!empty($k_code) === true) {
    $k_code = json_encode($k_code);
}
//もし名前がなければ
if (!empty($name) === true) {
    $name = json_encode($name);
}
print "<div id='goodnon'></div>";

//$dbh = null;
?>

<div id="scrolltop" class="st">top</div>
<div id="scrollmenu" class="sm">menu</div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="main.js"></script>
<script src="anime.min.js"></script>
<script src="footerFixed.js"></script>
<script type="text/javascript">
    //let name = 
    let code = <?php echo $k_code; ?>;
    let name = <?php echo $name; ?>;
    let g_iine = <?php echo $g_iine; ?>;
</script>
<script src="sub.js"></script>
</body>

</html>
