<?php
// ↓ ここから追記
// rel="prev"とrel=“next"表示の削除
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

// WordPressバージョン表示の削除
remove_action('wp_head', 'wp_generator');

// 絵文字表示のための記述削除（絵文字を使用しないとき）
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// アイキャッチ画像の有効化
add_theme_support('post-thumbnails');

// 投稿固定ページを旧式のエディターに戻す
add_filter('gutenberg_can_edit_post_type', '__return_false'); //Gutenbergプラグイン用
add_filter('use_block_editor_for_post', '__return_false'); //WordPressブロックエディター用

//従来のウィジェットエディターに戻す
function example_theme_support()
{
    remove_theme_support('widgets-block-editor');
}
add_action('after_setup_theme', 'example_theme_support');

// ウィジェット追加
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'ウィジェット１',
        'id' => 'widget01',
        'before_widget' => '<div class=”widget”>',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// 自動成型削除
function my_tiny_mce_before_init($init_array)
{
    global $allowedposttags;
    $init_array['valid_elements'] = '*[*]';
    $init_array['extended_valid_elements'] = '*[*]';
    $init_array['valid_children'] = '+a[' . implode('|', array_keys($allowedposttags)) . ']';
    // $init_array['indent'] = true;
    if (is_page()) {
        $init_array['wpautop'] = false;
        $init_array['force_p_newlines'] = false;
    }
    return $init_array;
}
add_filter('tiny_mce_before_init', 'my_tiny_mce_before_init');

function custom_print_scripts()
{
    if (!is_admin()) {
        //デフォルトjquery削除
        wp_deregister_script('jquery');

        //GoogleCDNから読み込む
        wp_enqueue_script('jquery-js', '//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
        wp_enqueue_script('archive-js', get_template_directory_uri() . '/js/archive.js');
    }
}
add_action('wp_print_scripts', 'custom_print_scripts');

//ヘッダーにCDNを読み込ませる
function fontawesome_enqueue()
{
    wp_enqueue_script('fontawesome_script', 'https://kit.fontawesome.com/82bcc49272.js');
}
add_action('wp_enqueue_scripts', 'fontawesome_enqueue');

function register_stylesheet()
{
    wp_register_style('reset', get_template_directory_uri() . '/css/destyle.css');
    wp_register_style('style', get_template_directory_uri() . '/css/style.css');
    wp_register_style('base', 'https://use.fontawesome.com/releases/v6.2.0/css/all.css');
}
function add_stylesheet()
{
    register_stylesheet();
    wp_enqueue_style('reset', '', array(), '1.0', false);
    wp_enqueue_style('style', '', array(), '1.0', false);
    wp_enqueue_style('base', '', array(), '1.0', false);
}
add_action('wp_enqueue_scripts', 'add_stylesheet');

/*---- Google Icon ----*/
function add_google_icons()
{
    wp_register_style(
        'googleFonts',
        'https://fonts.googleapis.com/icon?family=Material+Icons'
    );
    wp_enqueue_style('googleFonts');
}
add_action('wp_enqueue_scripts', 'add_google_icons');

//PHPをウィジェット追加
function widget_text_exec_php($widget_text)
{
    if (strpos($widget_text, '<' . '?') !== false) {
        ob_start();
        eval('?>' . $widget_text);
        $widget_text = ob_get_contents();
        ob_end_clean();
    }
    return $widget_text;
}
add_filter('widget_text', 'widget_text_exec_php', 99);

// カスタマイズコメントフォーム
if (!function_exists('custom_comment_form')) {
    function custom_comment_form($args)
    {
        // 「コメントを残す」を削除
        $args['title_reply'] = '';
        //コメント欄の前に表示する文字列の削除　※デフォルトではコメント
        $args['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
        //「admin としてログイン中。ログアウトしますか ? * が付いている欄は必須項目です」を削除
        $args['logged_in_as'] = '';
        // 「メールアドレスが公開されることはありません」を削除
        $args['comment_notes_before'] = '';
        return $args;
    }
}

add_filter('comment_form_defaults', 'custom_comment_form');
// カスタマイズコメントフォームフィールド
if (!function_exists('custom_comment_form_fields')) {
    function custom_comment_form_fields($arg)
    {
        // コメントからウェブサイトとEmailを削除
        $arg['url'] = '';
        $arg['email'] = '';
        return $arg;
    }
}
add_filter('comment_form_default_fields', 'custom_comment_form_fields');

// ----------------------------------------------------------------------------
// コメント欄の名前が未入力の場合の投稿者名
// ----------------------------------------------------------------------------
function default_author_name($author, $comment_ID, $comment)
{
    if ($author == __('Anonymous')) {
        $author = '名無しさん';
    }

    return $author;
}
add_filter('get_comment_author', 'default_author_name', 10, 3);

// 検索ワードファイルパス
define('SEARCH_WORDS_FILE_PATH', __DIR__ . '/test.csv');


/* 投稿と固定ページ一覧にスラッグの列を追加 */
function add_posts_columns_slug($columns)
{
    $columns['slug'] = 'スラッグ';
    echo '';
    return $columns;
}
add_filter('manage_posts_columns', 'add_posts_columns_slug');
add_filter('manage_pages_columns', 'add_posts_columns_slug');

/* スラッグを表示 */
function custom_posts_columns_slug($column_name, $post_id)
{
    if ($column_name == 'slug') {
        $post = get_post($post_id);
        $slug = $post->post_name;
        echo esc_attr($slug);
    }
}
add_action('manage_posts_custom_column', 'custom_posts_columns_slug', 10, 2);
add_action('manage_pages_custom_column', 'custom_posts_columns_slug', 10, 2);


//アイキャッチを有効化
add_theme_support('post-thumbnails');

//画像サイズ追加
add_image_size('rect', 640, 400, true);

//画像URLからIDを取得
function get_attachment_id_by_url($url)
{
    global $wpdb;
    $sql = "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s";
    preg_match('/([^\/]+?)(-e\d+)?(-\d+x\d+)?(\.\w+)?$/', $url, $matches);
    $post_name = $matches[1];
    return (int)$wpdb->get_var($wpdb->prepare($sql, $post_name));
}

//画像をサムネイルで出力
function catch_that_image()
{
    global $post;
    $first_img = '';
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img_src = $matches[1][0];
    $attachment_id = get_attachment_id_by_url($first_img_src);
    $first_img = wp_get_attachment_image($attachment_id, 'rect', false, array('class' => 'archive-thumbnail'));
    if (empty($first_img)) {
        $first_img = '<img class="attachment_post_thumbnail" src="' . get_stylesheet_directory_uri() . '/assets/img/common/no-img.jpg" alt="No image" />';
    }
    return $first_img;
}

add_filter('use_block_editor_for_post', '__return_false');
add_theme_support('post-thumbnails');

// アクセス数をカウントする
function set_post_views_days()
{
    $postID = get_the_ID();
    $key = 'pv_count_week';
    set_post_views($postID, $key);
    $key = 'pv_count_3day';
    set_post_views($postID, $key);
}
function set_post_views($postID, $key)
{
    $sum_count = (int) get_post_meta($postID, $key, true);
    update_post_meta($postID, $key, $sum_count + 1);
}

//ボットの判別
function isBot()
{
    $bot_list = array(
        'Googlebot',
        'Yahoo! Slurp',
        'Mediapartners-Google',
        'msnbot',
        'bingbot',
        'MJ12bot',
        'Ezooms',
        'pirst; MSIE 8.0;',
        'Google Web Preview',
        'ia_archiver',
        'Sogou web spider',
        'Googlebot-Mobile',
        'AhrefsBot',
        'YandexBot',
        'Purebot',
        'Baiduspider',
        'UnwindFetchor',
        'TweetmemeBot',
        'MetaURI',
        'PaperLiBot',
        'Showyoubot',
        'JS-Kit',
        'PostRank',
        'Crowsnest',
        'PycURL',
        'bitlybot',
        'Hatena',
        'facebookexternalhit',
        'NINJA bot',
        'YahooCacheSystem',
        'NHN Corp.',
        'Steeler',
        'DoCoMo',
    );
    $is_bot = false;
    foreach ($bot_list as $bot) {
        if (stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
            $is_bot = true;
            break;
        }
    }
    return $is_bot;
}

function getPostViewsBase($postID, $count_key)
{
    $count = get_post_meta($postID, $count_key, true);
    if ('' == $count) {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');

        return '0 View';
    }

    return $count . ' Views';
}
function getPostViewsWeek($postID)
{
    return getPostViewsBase($postID, 'pv_count_week');
}
function getPostViews3day($postID)
{
    return getPostViewsBase($postID, 'pv_count_3 day');
}

// 7日毎にアクセスをリセットして人気カテゴリーを表示
//クリック数をカウントする
function category_views_week()
{
    global $cat;
    $categoryID = $cat;
    $key = 'category_count_week';
    category_views($categoryID, $key);
}

function category_views($categoryID, $key)
{
    $sum_count = (int) get_term_meta($categoryID, $key, true);
    update_term_meta($categoryID, $key, $sum_count + 1);
}

function display_maintenance()
{
    echo <<<maintenance
<hr>
ただいまメンテナンス中です。<br>
しばらく時間をおいてアクセスしてください。
<hr>
maintenance;

    ini_set("display_errors", "On");
}

add_action("phpmailer_init", "send_smtp_email");
function send_smtp_email($phpmailer)
{
    $phpmailer->isSMTP();
    $phpmailer->Host       = "mail.last.cfbx.jp";
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 587;
    $phpmailer->SMTPSecure = "tls";
    $phpmailer->Username   = "test@last.cfbx.jp";
    $phpmailer->Password   = "takuya7530";
    $phpmailer->From       = "test@last.cfbx.jp";
    $phpmailer->FromName   = "test";
}

function setToken()
{
    global $_SESSION;
    if (!isset($_SESSION['csrf_token'])) {
        // bin2hexはphp7.0,openssl_random_pseudo_bytesはphp5.3
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    // スクリプト自体の実行を終了
    return;
}
function getToken()
{
    global $_SESSION;
    $token = null;
    if (isset($_SESSION['csrf_token'])) {
        $token = $_SESSION['csrf_token'];
    }

    return $token;
}

function enquiry_sample()
{
    header('Content-type: application/json; charset=UTF-8');
    $result = [];
    $result['name'] = $_POST['name'];
    $result['title'] = $_POST['title'];
    $result['text'] = $_POST['text'];
    $result['stamp'] = $_POST['stamp'];
    echo json_encode($result);
    exit;
}
add_action('wp_ajax_enquiry_sample', 'enquiry_sample');
add_action('wp_ajax_nopriv_enquiry_sample', 'enquiry_sample');

/* 質問掲示板について */
class MAX_LENGTH
{
    public const NAME = 50;
    public const TITLE = 50;
    public const TEXT = 500;
}

class MIN_LENGTH
{
    public const NAME = 0;
    public const TITLE = 5;
    public const TEXT = 1;
}

function bbs_quest_submit()
{
    session_start();
    $text = $_POST['text'];
    $name = $_POST['name'];
    $title = $_POST['title'];
    $stamp = $_POST['stamp'];
    $name = Chk_StrMode($name);
    $title = Chk_StrMode($title);
    $text = Chk_StrMode($text);
    Chk_ngword($name, '・NGワードが入力されています。', $error);
    Chk_ngword($title, '・NGワードが入力されています。', $error);
    Chk_ngword($text, '・NGワードが入力されています。', $error);
    if ($name == "") {
        $name = "匿名";
    } // 追加
    Chk_InputMode($title, '・質問タイトルをご記入ください。', $error);
    Chk_InputMode($text, '・質問文をご記入ください。', $error);
    Chk_InputMode($stamp, '・スタンプを選択してください。', $error);
    CheckUrl($name, '・お名前にＵＲＬは記入できません。', $error); // 追加
    CheckUrl($title, '・質問タイトルにＵＲＬは記入できません。', $error); // 追加
    CheckUrl($text, '・質問文にＵＲＬは記入できません。', $error); // 追加
    $result = [];
    if (empty($error)) {
        $result['error'] = '';
        $result['name'] = $name;
        $result['title'] = $title;
        $result['text'] = $text;
        $_SESSION['name'] = $name;
        $_SESSION['title'] = $title;
        $_SESSION['text'] = $text;
        $_SESSION['stamp'] = $stamp;
        $_SESSION['attach'] = $_FILES['attach'];
        foreach ($_FILES['attach']['tmp_name'] as $i => $tmp_name) {
            if (!empty($tmp_name)) {
                $_SESSION['attach']['data'][$i] = file_get_contents($tmp_name);
            }
        }
    } else {
        $result['error'] = $error;
        $_SESSION['name'] = '';
        $_SESSION['title'] = '';
        $_SESSION['text'] = '';
        $_SESSION['stamp'] = '';
        $_SESSION['attach'] = null;
    }
    header('Content-type: application/json; charset=UTF-8');
    echo json_encode($result);
    exit;
}
add_action('wp_ajax_bbs_quest_submit', 'bbs_quest_submit');
add_action('wp_ajax_nopriv_bbs_quest_submit', 'bbs_quest_submit');

/* 質問タイトルとスタンプ画像なし（回答掲示板) */
function bbs_answer_submit()
{
    session_start();
    $unique_id = $_POST['unique_id'];
    $text = $_POST['text'];
    $name = $_POST['name'];
    //$title = $_POST['title'];
    //$stamp = $_POST['stamp'];
    $name = Chk_StrMode($name);
    //$title = Chk_StrMode($title);
    $text = Chk_StrMode($text);
    Chk_ngword($name, '・NGワードが入力されています。', $error);
    //Chk_ngword($title, '・NGワードが入力されています。', $error);
    Chk_ngword($text, '・NGワードが入力されています。', $error);
    if ($name == "") {
        $name = "匿名";
    } // 追加
    //Chk_InputMode($title, '・質問タイトルをご記入ください。', $error);
    Chk_InputMode($text, '・質問文をご記入ください。', $error);
    //Chk_InputMode($stamp, '・スタンプを選択してください。', $error);
    CheckUrl($name, '・お名前にＵＲＬは記入できません。', $error); // 追加
    //CheckUrl($title, '・質問タイトルにＵＲＬは記入できません。'); // 追加
    CheckUrl($text, '・質問文にＵＲＬは記入できません。', $error); // 追加
    $result = [];
    if (empty($error)) {
        $result['error'] = '';
        $result['name'] = $name;
        //$result['title'] = $title;
        $result['text'] = $text;
        $_SESSION['unique_id'] = $unique_id;
        $_SESSION['name'] = $name;
        //$_SESSION['title'] = $title;
        $_SESSION['text'] = $text;
        //$_SESSION['stamp'] = $stamp;
        $_SESSION['attach'] = $_FILES['attach'];
        foreach ($_FILES['attach']['tmp_name'] as $i => $tmp_name) {
            if (!empty($tmp_name)) {
                $_SESSION['attach']['data'][$i] = file_get_contents($tmp_name);
            }
        }
    } else {
        $result['error'] = $error;
        $_SESSION['unique_id'] = null;
        $_SESSION['name'] = '';
        //$_SESSION['title'] = '';
        $_SESSION['text'] = '';
        //$_SESSION['stamp'] = '';
        $_SESSION['attach'] = null;
    }
    header('Content-type: application/json; charset=UTF-8');
    echo json_encode($result);
    exit;
}
add_action('wp_ajax_bbs_answer_submit', 'bbs_answer_submit');
add_action('wp_ajax_nopriv_bbs_answer_submit', 'bbs_answer_submit');

function Chk_ngword($str, $mes, &$error)
{
    // NGワードリスト配列の定義
    $ng_words = ['死ね', 'アホ', '殺す', 'バカ'];
    foreach ($ng_words as $ngWordsVal) {
        // 対象文字列にキーワードが含まれるか
        if (false !== mb_strpos($str, $ngWordsVal)) {
            $error[] = $mes;
        }
    }
}
/* $str = 名前、タイトル、質問文 */
function Chk_StrMode($str)
{
    // タグを除去
    $str = strip_tags($str);
    // 連続する空白をひとつにする
    $str = preg_replace('/[\x20\xC2\xA0]++/u', "\x20", $str);
    // 連続する改行をひとつにする
    $str = preg_replace("/(\x20*[\r\n]\x20*)++/", "\n", $str);
    // 前後の空白を除去
    $str = mb_ereg_replace('^(　){0,}', '', $str);
    $str = mb_ereg_replace('(　){0,}$', '', $str);
    $str = trim($str);
    // 特殊文字を HTML エンティティに変換する
    $str = htmlspecialchars($str);

    return $str;
}
/* 未入力チェックファンクション */
function Chk_InputMode($str, $mes, &$error)
{
    if ('' == $str) {
        $error[] = $mes;
    }
}

/* 以下追加 */
function CheckUrl($checkurl, $mes, &$error)
{
    if (preg_match("/[\.,:;]/u", $checkurl)) {
        $error[] = $mes;
    }
}

function bbs_quest_confirm()
{
    // 新しいセッションを開始、あるいは既存のセッションを再開する
    session_start();
    // 何もせず終わる処理
    if (empty($_SESSION['text']) || empty($_SESSION['title']) || empty($_SESSION['stamp'])) {
        exit;
    }
    // $wpdbでSQLを実行
    global $wpdb;
    // どのようなデータをどのテーブルに登録するか
    $sql = 'INSERT INTO sortable(text,name,title,stamp,ip) VALUES(%s,%s,%s,%d,%s)';
    // セッション変数に登録
    $text = $_SESSION['text'];
    $name = $_SESSION['name'];
    $title = $_SESSION['title'];
    $stamp = $_SESSION['stamp'];
    // ipアドレスを取得する
    $ip = $_SERVER['REMOTE_ADDR'];
    $query = $wpdb->prepare($sql, $text, $name, $title, $stamp, $ip);
    // プリペアードステートメントを用意してから、下記のようにresultsで値を取得
    $query_result = $wpdb->query($query);
    // カラム名 unique_id の質問UUID を一度そのデータを読み込んで取得する
    $sql = 'SELECT unique_id FROM sortable WHERE id = %d';
    $query = $wpdb->prepare($sql, $wpdb->insert_id);
    $rows = $wpdb->get_results($query);
    $unique_id = $rows[0]->unique_id;
    // アップロードディレクトリ（パス名）を取得する
    $upload_dir = wp_upload_dir();
    // 『filenames』を記述して配列名を記述し、それに『[]』を代入すればそれは配列として扱われます
    $filenames = [];
    foreach ($_SESSION['attach']['tmp_name'] as $i => $tmp_name) {
        if (empty($tmp_name)) {
            $filenames[$i] = '';
        } else {
            $type = explode('/', $_SESSION['attach']['type'][$i]);
            $ext = $type[1];
            if (3 == $i) { // 比較した時に3＋1以上なら
                $n = 'usericon';
            } else {
                $n = $i + 1;
            }
            $filenames[$i] = "{$unique_id}_{$n}.{$ext}";
            $attach_path = $upload_dir['basedir'] . '/attach/' . $filenames[$i];
            // 文字列をファイルに書き込む、文字列データを書き込むファイル名を指定
            file_put_contents($attach_path, $_SESSION['attach']['data'][$i]);
        }
    }
    $result = [];
    // 条件式が成り立った場合処理を実行
    if (false === $query_result) {
        $result['error'] = '登録できませんでした';
        // 条件式が成り立たなければ処理を実行
    } else { // どのテーブルの何をどう更新するか
        $sql = 'UPDATE sortable SET attach1=%s,attach2=%s,attach3=%s,usericon=%s WHERE id=%d';
        $query = $wpdb->prepare($sql, $filenames[0], $filenames[1], $filenames[2], $filenames[3], $wpdb->insert_id);
        $wpdb->query($query);
        $result['error'] = '';
    }
    header('Content-type: application/json; charset=UTF-8');
    echo json_encode($result);
    exit;
}
add_action('wp_ajax_bbs_quest_confirm', 'bbs_quest_confirm');
add_action('wp_ajax_nopriv_bbs_quest_confirm', 'bbs_quest_confirm');

/* 回答タイトルとスタンプ画像なし（回答掲示板) */
function bbs_answer_confirm()
{
    // 新しいセッションを開始、あるいは既存のセッションを再開する
    session_start();
    // 何もせず終わる処理
    if (empty($_SESSION['text'])) {
        exit;
    }
    // $wpdbでSQLを実行
    global $wpdb;
    /* ここから（１） */
    $unique_id = $_SESSION['unique_id'];
    $sql = 'SELECT * FROM sortable WHERE unique_id = %s';
    $query = $wpdb->prepare($sql, $unique_id);
    $rows = $wpdb->get_results($query);
    // rows[0]は配列の最初の要素にアクセス
    $parent_id = $rows[0]->id;
    /* ここまで（１） */
    // どのようなデータをどのテーブルに登録するか
    $sql = 'INSERT INTO sortable(parent_id,text,name,ip) VALUES(%d,%s,%s,%s)';/* （２） */
    // セッション変数に登録
    $text = $_SESSION['text'];
    $name = $_SESSION['name'];
    //$title = $_SESSION['title'];
    //$stamp = $_SESSION['stamp'];
    // ipアドレスを取得する
    $ip = $_SERVER['REMOTE_ADDR'];
    $query = $wpdb->prepare($sql, $parent_id, $text, $name, $ip);/* （２） */
    // プリペアードステートメントを用意してから、下記のようにresultsで値を取得
    $query_result = $wpdb->query($query);
    $result = [];
    // 条件式が成り立った場合処理を実行
    if (
        false === $query_result
    ) {
        $result['error'] = '登録できませんでした' . $wpdb->last_error;
        // 条件式が成り立たなければ処理を実行
    } else { // どのテーブルの何をどう更新するか
        // カラム名 unique_id の質問UUID を一度そのデータを読み込んで取得する
        $sql = 'SELECT unique_id FROM sortable WHERE id = %d';
        $query = $wpdb->prepare($sql, $wpdb->insert_id);
        $rows = $wpdb->get_results($query);
        $unique_id = $rows[0]->unique_id;

        // アップロードディレクトリ（パス名）を取得する
        $upload_dir = wp_upload_dir();
        // 『filenames』を記述して配列名を記述し、それに『[]』を代入すればそれは配列として扱われます
        $filenames = [];
        foreach ($_SESSION['attach']['tmp_name'] as $i => $tmp_name) {
            if (empty($tmp_name)) {
                $filenames[$i] = '';
            } else {
                $type = explode('/', $_SESSION['attach']['type'][$i]);
                $ext = $type[1];
                if (3 == $i) { // 比較した時に3＋1以上なら
                    $n = 'usericon';
                } else {
                    $n = $i + 1;
                }
                $filenames[$i] = "{$unique_id}_{$n}.{$ext}";
                $attach_path = $upload_dir['basedir'] . '/attach/' . $filenames[$i];
                // 文字列をファイルに書き込む、文字列データを書き込むファイル名を指定
                file_put_contents($attach_path, $_SESSION['attach']['data'][$i]);
            }
        }
        $sql = 'UPDATE sortable SET attach1=%s,attach2=%s,attach3=%s,usericon=%s WHERE id=%d';
        $query = $wpdb->prepare($sql, $filenames[0], $filenames[1], $filenames[2], $filenames[3], $wpdb->insert_id);
        $wpdb->query($query);
        $result['error'] = '';
    }
    header('Content-type: application/json; charset=UTF-8');
    echo json_encode($result);
    exit;
}
add_action('wp_ajax_bbs_answer_confirm', 'bbs_answer_confirm');
add_action('wp_ajax_nopriv_bbs_answer_confirm', 'bbs_answer_confirm');


function bbs_que_list_items()
{
    global $wpdb;
    $count = $_POST['count'];
    $sql = 'SELECT * FROM sortable WHERE parent_id IS NULL LIMIT %d,10';
    $query = $wpdb->prepare($sql, $count);
    $rows = $wpdb->get_results($query);
    $result = [];
    $result['items'] = [];
    $upload_dir = wp_upload_dir();
    foreach ($rows as $row) {
        if (empty($row->attach1)) {
            $url = '';
            $type = '';
        } else {
            $info = pathinfo($row->attach1);
            $url = $upload_dir['baseurl'] . '/attach/' . $info['basename'];
            $ext = $info['extension'];
            switch ($ext) {
                case 'jpeg':
                case 'png':
                    $type = 'img';
                    break;
                case 'mp4':
                    $type = ''; /* ダミー */
                    break;
                case 'pdf':
                    $type = ''; /* ダミー */
                    break;
                default:
                    break;
            }
        }
        $result['items'][] = ['title' => $row->title, 'img1' => $url, 'type' => $type, 'url' => home_url('質問回答画面?' . $row->unique_id)];
    }
    echo json_encode($result);
    exit;
}
add_action('wp_ajax_bbs_que_list_items', 'bbs_que_list_items');
add_action('wp_ajax_nopriv_bbs_que_list_items', 'bbs_que_list_items');

/* WordPressでJavaScriptファイルを読み込む方法 */
function my_scripts_method()
{
    wp_enqueue_script(
        'custom_script',
        get_template_directory_uri() . '/response.js',
    );
}
add_action('wp_enqueue_scripts', 'my_scripts_method');


/* WordPress の REST API が初期化されるタイミング（rest_api_init）で関数を実行するよう登録 */
add_action('rest_api_init', function () {
    // WordPress に REST API のエンドポイントを追加（/wp-json/custom-auth/v1/register）
    // POST /wp-json/custom-auth/v1/register が実行されたときに、custom_user_register() 関数が呼ばれる
    register_rest_route('custom-auth/v1', '/register', [
        'methods' => 'POST',
        // エンドポイントにアクセスがあったときに呼び出される関数名
        'callback' => 'custom_user_register',
        // エンドポイントにアクセスできるかどうかの「認可チェック関数」
        // 本番環境では __return_true を使うと 不正利用される可能性があるため注意。必要に応じて認証付きに変更することが望ましいです。
        'permission_callback' => '__return_true',
    ]);
});

/* POST /wp-json/custom-auth/v1/register に JSON データでアクセスされたときに実行される「ユーザー登録処理」*/
function custom_user_register($request)
{
    // 32バイトの安全なランダムバイナリデータを生成。バイナリデータを Base64 に変換。Base64 の「+」「/」を、URLで安全な「-」「_」に変換（Base64URL形式）。末尾の =（パディング）を削除。
    function token_urlsafe($length = 32)
    {
        return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
    }
    // 現在の時刻から10分後の日時を、Y-m-d H:i:s という形式で文字列にして、$expires に代入する
    // トークンと有効期限をDBに保存
    $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    // $token という変数をメールアドレスに送信する
    $token = token_urlsafe(32);

    function validate_input($params)
{
    $clean = [];

    // API 経由で送信された JSON データ（POST 本文）を配列として取得
    $params = $request->get_json_params();

// 1. 入力データをサニタイズ（タグ除去・空白除去・HTMLエンティティ化）
foreach ($params as $k => $v) {
    $clean[$k] = Chk_StrMode($v); // 危険文字などを除去する
}

// 2. 必須項目が空なら、エラーメッセージは返さずステータスコードだけ返す
if (empty($clean['namae']) || empty($clean['email'])) {
    return new WP_REST_Response(null, 400); // HTTP 400 Bad Request
}



    // ユーザー名を WordPress の基準に沿ってサニタイズ（不要な文字を取り除く）
    // $email = sanitize_email($params['email']);
    // $name = sanitize_user($params['name']);
    // $password = $params['password'];
    // 任意の「認証コード」（たとえばメール認証などの代替）
    // $code = $params['code'];

    // 認証コードをチェック（例：セッションやDB、ここでは仮で123456）
    /* if ($code !== '123456') {
        return new WP_REST_Response(['message' => '認証コードが正しくありません'], 400);
    } */

    // メールアドレスの形式が正しいかどうか（構文チェック）を確認
    if (!is_email($email)) {
        return new WP_REST_Response(['message' => 'メールアドレスが無効です'], 400);
    }

    // すでに同名ユーザーがいないか確認
    if (username_exists($name)) {
        return new WP_REST_Response(['message' => 'この名前は既に使われています'], 400);
    }

    // ユーザー作成
    // 指定されたユーザー名・パスワードで WordPress ユーザーを新規作成。
    $user_id = wp_create_user($name, $password);

    if (is_wp_error($user_id)) {
        return new WP_REST_Response(['message' => 'ユーザー作成に失敗しました'], 500);
    }

    return new WP_REST_Response(['message' => 'ユーザー登録に成功しました', 'user_id' => $user_id], 200);
}
