<?php
/*
Template Name: bbs_lile_count
固定ページ: いいねボタン
*/
?>
<style>
    .quest-likeButton svg {
        vertical-align: text-bottom;
    }

    .quest-likeButton {
        height: 100px;
        width: 100px;
    }
</style>

<!-- カスタムデータ属性にpostidを設置しその中に投稿IDを格納している -->
<!-- サニタイズ = 危険なコードやデータを変換または除去して無力化する処理 -->
<section class="post" data-postid="<?php echo sanitize($p_id); ?>">
    <!-- クリックした要素をquestlikeButtonで取得 -->
    <button type="button" class="quest-likeButton">
        <!-- 自分がいいねした投稿にはぐっどのスタイルを常に保持する -->
        <svg version="1.1" class="likeButton-icon" id="レイヤー_1"
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
            y="0px" viewBox="0 0 256 256" style="enable-background:new 0 0 256 256;" xml:space="preserve">
            <style type="text/css">
                .st0 {
                    fill: #FFFFFF;
                    stroke: #000000;
                    stroke-width: 8.7931;
                    stroke-linecap: round;
                    stroke-linejoin: round;
                    stroke-miterlimit: 10;
                }
            </style>
            <path class="st0" d="M101.5,175.5c3.9,5.9,16.6,9.3,16.6,9.3h58.6c13.2-4.4,5.9-17.1,5.9-17.1s7.8-1,11.2-9.3
	c3.4-8.3-3.4-12.7-3.4-12.7s10.3-1.5,10.3-11.2c0-12.2-11.7-10.3-11.7-10.3s10.7,1,10.7-11.7s-11.2-10.7-11.2-10.7h-40.1
	c0,0,2.9-8.3,3.4-14.7c0.5-6.4,2.9-18.6-7.8-28.8s-17.1-4.4-17.1-4.4v22.5c0,0,0.1,5.1-3.4,10.1l-15.3,29.7l-6.7,4.6" />
            <path class="st0" d="M101.5,120.8v59.6c0,0,0.5,7.3-4.9,7.3H65.4c0,0-6.4-0.5-6.4-4.9v-60.1c0,0,0.5-8.3,4.9-8.3h30.8
	C94.7,114.4,101.5,113.4,101.5,120.8z" />
            <?php
            if (isGood($_SESSION['unique_id'])) { //いいね押したらぐっどが塗りつぶされる
                echo ' good';
            } else { //いいねを取り消したらぐっどのスタイルが取り消される
                echo ' likeButton-icon';
            }; ?>">
        </svg>
        <!-- いいねの数 -->
        <span class="likeCount"><?php echo $dbPostGoodNum; ?></span>
    </button>
</section>

<script>
    const questlikeButton = document.querySelector('.quest-likeButton');
    const likeCount = document.querySelector('.likeCount');
    const likeButtonIcon = document.querySelector('.likeButton-icon'); //いいねボタンアイコン画像

    // ボタンが押された時に
    questLikeButton.addEventListener('click', () => {
        //FormData オブジェクトをインスタンス化したら append() メソッドを呼び出すことでフィールドに追加することができる
        formData.append("action", "like_dislike_button");
        //フォームの入力値を送信
        const require = {
            method: "post",
            body: formData
        }
        fetch("<?php echo home_url('wp-admin/admin-ajax.php'); ?>", require)
            .then(res => {
                // return data.json();
            })
            .then(date => {
                // いいねの総数を表示
                likeCount.html(data);
                //　いいね数取り消しのスタイル
                likeCount.classList.toggle('liker');
                //　いいね数押した時のスタイル
                likeCount.classList.toggle('liked');
                // いいね画像取り消しのスタイル
                likeButtonIcon.toggleClass('likeButton-icon'); //空洞いいね
                // いいね画像押した時のスタイル
                likeButtonIcon.toggleClass('good'); //塗りつぶしいいね
            })

            .catch(error => {
                console.log(error);
            });
    });
</script>

<?php
// $wpdbでSQLを実行
global $wpdb;

// goodテーブルからID（投稿ID）とユーザーID（UUID）が一致したレコードを取得するSQL文
$sql = 'SELECT * FROM good WHERE id = :p_id AND unique_id = :u_id';
// 配列はarray()関数を使って作成
$data = array(':p_id' => $p_id, 'u_id' => $_SESSION['unique_id']);
// エスケープ処理されたSQL文をクエリ実行
$query = $wpdb->query($wpdb->prepare($sql, $data));
// クエリ内の影響を受ける行を見つける
$count = $wpdb->query($sql);
// レコードが1件でもある場合
if (!empty($count)) {
    // レコードを削除する WHERE句は演算子を使って検索条件を指定
    $sql = 'DELETE FROM good WHERE id = :p_id AND unique_id = :u_id';
    $data = array(':p_id' => $p_id, ':u_id' => $_SESSION['unique_id']);
    // エスケープ処理されたSQL文をクエリ実行
    $query = $wpdb->query($wpdb->prepare(
        $sql,
        $data
    ));
    // count関数で配列の要素の数を取得
    echo count(getGood($p_id));
} else {
    // レコードを挿入する
    $sql = 'INSERT INTO good (id, unique_id, created_date) VALUES (:p_id, :u_id, :date)';
    $data = array(':p_id' => $p_id, ':u_id' => $_SESSION['unique_id'], ':date' => date('Y-m-d H:i:s'));
    // エスケープ処理されたSQL文をクエリ実行
    $query = $wpdb->query($wpdb->prepare($sql, $data));
    // count関数で配列の要素の数を取得
    echo count(getGood($p_id));
}
?>

<?php
$p_id = ''; //投稿ID
// $dbPostData = ''; //投稿内容
$dbPostGoodNum = ''; //いいねの数

// get送信がある場合
if (!empty($_GET['p_id'])) {
    // 投稿IDのGETパラメータを取得
    $p_id = $_GET['p_id'];
    // DBから投稿データを取得
    // $dbPostData = getPostData($p_id);
    // DBからいいねの数を取得
    $dbPostGoodNum = count(getGood($p_id));
}
?>