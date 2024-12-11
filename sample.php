<?php
/*
Template Name: bbs_que_answer
固定ページ: 回答画面
*/
header('X-FRAME-OPTIONS: SAMEORIGIN');
get_header();
// get_header('menu'); 必要なコードか分からない
$unique_id = substr($_SERVER['REQUEST_URI'], -36);
$sql = 'SELECT * FROM sortable WHERE unique_id = %s';
$query = $wpdb->prepare($sql, $unique_id);
$rows = $wpdb->get_results($query);
// アップロードディレクトリ（パス名）を取得する
$upload_dir = wp_upload_dir();
echo '<div id="main_container">';
echo '<div class="quest_container">';
foreach ($rows as $row) {
    $files = array_filter([$row->attach1, $row->attach2, $row->attach3]);
    $views = []; //ＨＴＭＬをため込む配列の初期化する
    foreach ($files as $file) {
        $info = pathinfo($file);
        $attach_url = $upload_dir['baseurl'] . '/attach/' . $info['basename'];
        $ext = $info['extension'];
        switch ($ext) {
            case 'jpeg':
            case 'png':
                $views[] = '<img style="height:350px;width:530px" src="' . $attach_url . '">';
                break;
            case 'mp4':
                $views[] = '<video style="height:350px;width:530px" src="' . $attach_url . '">';
                break;
            case 'pdf':
                $views[] = '<iframe style="height:350px;width:530px" src="' . $attach_url . '"></iframe>';
                break;
            default:
                break;
        }
    }
    $count = count($views);
    if ($count == 1) {
        // 1がtrueの場合
        // ここの処理が実行される
        $bmfloatLeft = 'left'; // 画像が2つの場合のみ
    } elseif ($count == 2) {
        // 1がfalseで2がtrueの場合
        // ここの処理が実行される
        $bmfloatLeft = 'left'; // 画像が2つの場合のみ
    } else {
        // それ以外（1、2ともにfalse）の場合
        // ここの処理が実行される
        $buafloatLeft = 'left'; // 画像が3つの場合のみ
    }
    if (empty($row->usericon)) {
        $usericon_src = 'wp-content/themes/sample_theme/images/noimage.png';
    } else {
        $usericon_src = $upload_dir['baseurl'] . '/attach/' . $row->usericon;
    }
    // echo '<div><a href="'.$url.'">'.$row->unique_id.'</a></div>';
    echo '<div class="quest_header_title">' . mb_strimwidth($row->title, 0, 40, '･･･') . '</div>'; // タイトル30文字
    echo '<div class="quest_usericon_img"><input type="radio" name="stamp" value="' . $row->stamp . '" id="stamp"><label for="stamp" class="quest_stamp_label"></label></div>'; // スタンプ画像

    // 全体にのみ float: left;
    echo '<div class="quest_markdown">';
    foreach ($views as $view) { // 個別にのみ float: left;
        echo '<div class="quest_item">' . $view . '</div>'; // アップロードファイル
    }
    echo '</div>';

    echo '<div class="quest_overview">' . mb_strimwidth($row->text, 0, 40, '･･･') . '</div>'; // 質問文
    echo '<div class="quest_usericon_img"><img src="' . $usericon_src . '"></div>'; // アイコン画像
    echo '<div class="quest_username">' . mb_strimwidth($row->name, 0, 10, '･･･') . '</div>'; // 名前
}
echo '</div>'; //<div class="quest_container"> の閉じタグ

// var_dump($attach_dir);
//ここから回答機能
//追加コード
// $upload_dir = wp_upload_dir();
$camera_url = $upload_dir['baseurl'] . '/camera.png';
$noimage_url = $upload_dir['baseurl'] . '/noimage.png';

echo '<div class="board_respond" id="js_board_respond">';
echo '<div id="input_area">';
echo '<form name="answer_Input_form">';
echo '<div class="user-area">';
echo '<label>';
echo '<div class="user-icon">';
echo '<img src="$noimage_url" class="changeImg" style="height:90px;width:90px">';
echo '</div>';
echo '<input type="file" class="attach" name="attach[]" data-maxsize="5" accept=".png, .jpg, .jpeg" style="display: none;">';
echo '</label>';
echo '<div class="viewer" style="display: none;"></div>';
echo '<button type="button" class="attachclear">clear</button>';
echo '</div>';
echo '<div class="answer-name-area">';
echo '<div class="parts">';
echo '<input class="input" type="text" name="name" id="name" data-length="MAX_LENGTH::NAME" data-minlength="MIN_LENGTH::NAME" placeholder="未入力の場合は、匿名で表示されます">';
echo '<div></div>';
echo '</div>';
echo '</div>';
echo '<div class="answer-text-area">';
echo '<div class="parts">';
echo '<textarea class="input" name="text" id="text" data-length="MAX_LENGTH::TEXT" data-minlength="MIN_LENGTH::TEXT" placeholder="荒らし行為や誹謗中傷や著作権の侵害はご遠慮ください"></textarea>';
echo '<div></div>';
echo '</div>';
echo '</div>';
echo '<div class="uploadfile-area">';
echo '<div class="uploadfile-selector-button">';
echo '<label>';
echo '<div class="uploadfile-camera-icon">';
echo '<img src="$camera_url" class="changeImg" style="height:150px;width:150px">';
echo '</div>';
echo '<input type="file" class="attach" name="attach[]" accept=".png, .jpg, .jpeg, .pdf, .mp4" style="display: none;">';
echo '</label>';
echo '<div class="viewer" style="display: none;"></div>';
echo '<button type="button" class="attachclear">clear</button>';
echo '</div>';
echo '<div class="uploadfile-selector-button">';
echo '<label>';
echo '<div class="uploadfile-camera-icon">';
echo '<img src="$camera_url" class="changeImg" style="height:150px;width:150px">';
echo '</div>';
echo '<input type="file" class="attach" name="attach[]" accept=".png, .jpg, .jpeg, .pdf, .mp4" style="display: none;">';
echo '</label>';
echo '<div class="viewer" style="display: none;"></div>';
echo '<button type="button" class="attachclear">clear</button>';
echo '</div>';
echo '<div class="uploadfile-selector-button">';
echo '<label>';
echo '<div class="uploadfile-camera-icon">';
echo '<img src="$camera_url" class="changeImg" style="height:150px;width:150px">';
echo '</div>';
echo '<input type="file" class="attach" name="attach[]" accept=".png, .jpg, .jpeg, .pdf, .mp4" style="display: none;">';
echo '</label>';
echo '<div class="viewer" style="display: none;"></div>';
echo '<button type="button" class="attachclear">clear</button>';
echo '</div>';
echo '</div>';

echo '<div class="filesize-restriction-area">            
    動画・画像をアップロード(Upload video・image)<span class="required">※ファイルサイズ15MB以内、JPG/GIF/PNG/MP4</span>
</div>';
echo '<div class="post-button">'; // ボタンを押せなくする
echo '<button type="button" id="submit_button" name="mode" value="confirm">確認画面へ進む</button>';
echo '</div>';
// type、name、id、valueの順番
echo '</form>';
echo '</div>';
echo '<div id="confirm_area"></div>';
echo '<div id="result_area"></div>';
echo '
</div>';
echo '</div>';
echo '</div>'; //<div id="main_container"> の閉じタグ
?>

<style>
    .quest_item {
        float: <?php echo $qifloatLeft; ?>;
    }

    .quest_markdown {
        float: <?php echo $qmfloatLeft; ?>;
    }
</style>

<style>
    .hideItems {
        /* カメラ画像 */
        display: none;
    }

    .concealItems {
        display: none;
    }

    .wait {
        /* ローディング画像 */
        height: 40px;
        width: 40px;
        border-radius: 40px;
        border: 3px solid;
        border-color: #bbbbbb;
        border-left-color: #1ECD97;
        font-size: 0;
        animation: rotating 2s 0.25s linear infinite;
    }

    @keyframes rotating {

        /* ローディング画像 */
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>