<?php
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
    CheckUrl($name, '・お名前にＵＲＬは記入できません。'); // 追加
    CheckUrl($title, '・質問タイトルにＵＲＬは記入できません。'); // 追加
    CheckUrl($text, '・質問文にＵＲＬは記入できません。'); // 追加
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
add_action('wp_ajax_bbs_answer_submit', 'bbs_answer_submit');
add_action('wp_ajax_nopriv_bbs_answer_submit', 'bbs_answer_submit');

/* 質問タイトルとスタンプ画像なし（回答掲示板 */
function bbs_answer_submit()
{
    session_start();
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
    CheckUrl($name, '・お名前にＵＲＬは記入できません。'); // 追加
    //CheckUrl($title, '・質問タイトルにＵＲＬは記入できません。'); // 追加
    CheckUrl($text, '・質問文にＵＲＬは記入できません。'); // 追加
    $result = [];
    if (empty($error)) {
        $result['error'] = '';
        $result['name'] = $name;
        //$result['title'] = $title;
        $result['text'] = $text;
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
add_action('wp_ajax_bbs_quest_submit', 'bbs_quest_submit');
add_action('wp_ajax_nopriv_bbs_quest_submit', 'bbs_quest_submit');

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
function CheckUrl($checkurl, $mes)
{
    global $errors;
    if (preg_match("/[\.,:;]/u", $checkurl)) {
        $errors[] = $mes;
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
    $sql = 'SELECT unique_id FROM sortable WHERE ID = %d';
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
        $sql = 'UPDATE sortable SET attach1=%s,attach2=%s,attach3=%s,usericon=%s WHERE ID=%d';
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

function bbs_que_list_items()
{
    global $wpdb;
    $count = $_POST['count'];
    $sql = 'SELECT * FROM sortable LIMIT %d,10';
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
        $result['items'][] = ['title' => $row->title, 'img1' => $url, 'type' => $type, 'url' => home_url('質問みる?' . $row->unique_id)];
    }
    echo json_encode($result);
    exit;
}
add_action('wp_ajax_bbs_que_list_items', 'bbs_que_list_items');
add_action('wp_ajax_nopriv_bbs_que_list_items', 'bbs_que_list_items');
