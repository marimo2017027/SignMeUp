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
echo '<div class="main_container">';
echo '<div class="quest_container">';
// var_dump($rows);
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
    if ($count == 1 || $count == 2) {
        $qm = 'quest_markdown';
        $qi = 'quest_item';
    } else {
        $qm = 'quest_markdown_group';
        $qi = 'quest_item_group';
    }
    if (empty($row->usericon)) {
        $usericon_src = 'wp-content/themes/sample_theme/images/noimage.png';
    } else {
        $usericon_src = $upload_dir['baseurl'] . '/attach/' . $row->usericon;
    }
    // echo '<div><a href="'.$url.'">'.$row->unique_id.'</a></div>';
    echo '<div class="quest_header_title">' . mb_strimwidth($row->title, 0, 40, '･･･') . '</div>'; // タイトル30文字
    echo '<div class="quest_feeling_stamp"><input type="radio" name="stamp" value="' . $row->stamp . '" id="stamp"><label for="stamp" class="quest_stamp_label"></label></div>'; // スタンプ画像

    // 全体にのみ float: left;
    echo '<div class="' . $qm . '">';
    foreach ($views as $view) { // 個別にのみ float: left;
        echo '<div class="' . $qi . '">' . $view . '</div>'; // アップロードファイル
    }
    echo '</div>';  // quest_markdown の閉じタグ

    echo '<div class="quest_overview">' . mb_strimwidth($row->text, 0, 40, '･･･') . '</div>'; // 質問文
    // echo '</div>';
    echo '<div class="quest_usericon_img"><img src="' . $usericon_src . '">'; // アイコン画像
    echo '<div class="quest_username">' . mb_strimwidth($row->name, 0, 10, '･･･') . '</div>'; // 名前
    echo '</div>';  // アイコン画像
}
echo '</div>'; //<div class="quest_container"> の閉じタグ
//ここから回答機能
//追加コード
// $upload_dir = wp_upload_dir();
$camera_url = $upload_dir['baseurl'] . '/camera.png';
$noimage_url = $upload_dir['baseurl'] . '/noimage.png';
?>
<div class="board_respond" id="js_board_respond">
    <div id="input_area">
        <form name="answer_Input_form">
            <input type="hidden" name="unique_id" value="<?php echo $unique_id; ?>">
            <div class="user-area">
                <label>
                    <div class="user-icon">
                        <img src="<?php echo $noimage_url; ?>" class="changeImg" style="height:90px;width:90px">
                    </div>
                    <input type="file" class="attach" name="attach[]" data-maxsize="5" accept=".png, .jpg, .jpeg" style="display: none;">
                </label>
                <div class="viewer" style="display: none;"></div>
                <button type="button" class="attachclear">clear</button>
            </div>
            <div class="answer-name-area">
                <div class="parts">
                    <input class="input" type="text" name="name" id="name" data-length="<?php echo MAX_LENGTH::NAME; ?>" data-minlength="<?php echo MIN_LENGTH::NAME; ?>" placeholder="未入力の場合は、匿名で表示されます">
                    <div></div>
                </div>
            </div>
            <div class="answer-text-area">
                <div class="parts">
                    <textarea class="input" name="text" id="text" data-length="<?php echo MAX_LENGTH::TEXT; ?>" data-minlength="<?php echo MIN_LENGTH::TEXT; ?>" placeholder="荒らし行為や誹謗中傷や著作権の侵害はご遠慮ください"></textarea>
                    <div></div>
                </div>
            </div>
            <div class="uploadfile-area">
                <div class="uploadfile-selector-button">
                    <label>
                        <div class="uploadfile-camera-icon">
                            <img src="<?php echo $camera_url; ?>" class="changeImg" style="height:150px;width:150px">
                        </div>
                        <input type="file" class="attach" name="attach[]" accept=".png, .jpg, .jpeg, .pdf, .mp4" style="display: none;">
                    </label>
                    <div class="viewer" style="display: none;"></div>
                    <button type="button" class="attachclear">clear</button>
                </div>
                <div class="uploadfile-selector-button">
                    <label>
                        <div class="uploadfile-camera-icon"><img src="<?php echo $camera_url; ?>" class="changeImg" style="height:150px;width:150px">
                        </div>
                        <input type="file" class="attach" name="attach[]" accept=".png, .jpg, .jpeg, .pdf, .mp4" style="display: none;">
                    </label>
                    <div class="viewer" style="display: none;"></div>
                    <button type="button" class="attachclear">clear</button>
                </div>
                <div class="uploadfile-selector-button">
                    <label>
                        <div class="uploadfile-camera-icon">
                            <img src="<?php echo $camera_url; ?>" class="changeImg" style="height:150px;width:150px">
                        </div>
                        <input type="file" class="attach" name="attach[]" accept=".png, .jpg, .jpeg, .pdf, .mp4" style="display: none;">
                    </label>
                    <div class="viewer" style="display: none;"></div>
                    <button type="button" class="attachclear">clear</button>
                </div>
            </div>
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
            <div class="filesize-restriction-area">
                動画・画像をアップロード(Upload video・image)<span class="required">※ファイルサイズ15MB以内、JPG/GIF/PNG/MP4</span>
            </div>
            <div class="post-button"><!-- ボタンを押せなくする -->
                <button type="button" id="submit_button" name="mode" value="confirm">確認画面へ進む</button>
            </div>
            <!-- type、name、id、valueの順番 -->
        </form>
    </div>
    <div id="confirm_area"></div>
    <div id="result_area"></div>
</div>
<?php echo '</div>'; ?>
<script>
    /*
    function NowDate() { //送信日時を取り出す関数
        with(document.form1) { //"hidden"要素に各情報を設定する
            submitdate.value = NowDate();
        }
        // 週を計算
        Date.prototype.getWeek = function() {
            var onejan = new Date(this.getFullYear(), 0, 1);
            var today = new Date(this.getFullYear(), this.getMonth(), this.getDate());
            var dayOfYear = ((today - onejan + 86400000) / 86400000);
            return Math.ceil(dayOfYear / 7)
        };
        objDate = new Date(); //現在日時を取得
        // Y = objDate.getFullYear(); //年を取得
        M = objDate.getMonth(); //月を取得
        W = objDate.getWeek(); //週を取得
        D = objDate.getDate(); //日を取得
        H = objDate.getHours(); //時間を取得
        F = objDate.getMinutes(); //分を取得
        S = objDate.getSeconds(); //秒を取得
        // we = new Array("日", "月", "火", "水", "木", "金", "土"); //配列を作成
        // W = we[objDate.getDay()];
        //曜日を0～6の数値で取得し、その数値を配列Indexに割り当てる。
        // return "送信日時：" + Y + "年" + (M + 1) + "月" + D + "日" + H + "時" + F + "分" + S + "秒";
        const sum = ((M + 1) + D + H + F + S);
        return "sum";
    }
    window.addEventListener("DOMContentLoaded", () => { //DOMツリー読み込み完了後に発火
        // 開始日と現在の時間差を計算
        // new Date() が 20250207 のように設定されるのか分からないため引き算できるのか不明
        const diff = objDate - sum;

        // 年の数値を計算
        // const year = Math.floor(diff / 1000 / 60 / 60 / 24 / 30 / 12);
        // 月の数値を計算
        const month = Math.floor(diff / 1000 / 60 / 60 / 24 / 30) % 12;
        // 週の数値を計算
        const week = Math.floor(diff / 1000 / 60 / 60 / 24 / 7);
        // 日の数値を計算
        const day = Math.floor(diff / 1000 / 60 / 60 / 24);
        // 時間の数値を計算
        const time = Math.floor(diff / 1000 / 60 / 60);

        // 文字列を格納するための変数
        let outputStr = "";

        // 年のテキストを生成(0の場合は表示しない)
        /* if (year !== 0) {
            outputStr += `${year}年`;
        } 

        // 月のテキストを生成(0の場合は表示しない)
        if (month !== 0) {
            outputStr += `${month}ヶ月`;
        }

        // 週のテキストを生成(0の場合は表示しない)
        if (week !== 0) {
            outputStr += `${week}週`;
        }

        // 日のテキストを生成(0の場合は表示しない)
        if (day !== 0) {
            outputStr += `${day}日`;
        }

        // 時間のテキストを生成(0の場合は表示しない)
        if (time !== 0) {
            outputStr += `${time}時間`;
        }

        // 完成したテキストをpタグに挿入
        // skillTextEl.innerHTML = outputStr;
        const divAnswerPubdateArea = outputStr;
        divAnswerPubdateArea = document.createElement("div"); // div (子)を生成
        divAnswerPubdateArea.classList.add("answer-pubdate-area"); // classの追加
        /* 回答要素配置 */
    // comment_area.appendChild(); // comment_area (親要素) の末尾に div を追加 
    // });
    // });
    const input_area = document.getElementById("input_area");
    const confirm_area = document.getElementById("confirm_area");
    const result_area = document.getElementById("result_area");
    var name_value = "";
    var text_value = "";
    // 要素が3個の空配列を作成
    const blobType = ["", "", "", ""];
    const blobUrl = ["", "", "", ""];

    const init = function() {
        set_attach_event('.uploadfile-camera-icon,.user-icon', 0);
        document.getElementById("submit_button").addEventListener("click", submit_button_click);
        // change1();
        /* inputイベント */
        document.addEventListener('input', e => {
            /* 文字数表示 */
            display_text_length(e);
            /* 毎回判定によるボタン制御 */
            validation();
        });
        /* 初回判定のボタン制御 */
        validation();
    } //const init = function () の終了
    //DOM構築、スタイルシート、画像、サブフレームの読み込みが完了した後に発生する
    window.addEventListener("DOMContentLoaded", init);

    const submit_button_click = function() {
        //ローディングアニメーション画像
        const submit_button = document.getElementById("submit_button");
        submit_button.disabled = true;
        submit_button.classList.add('wait');
        name_value = "";
        text_value = "";
        //サーバーにデータを送信する際に使用するオブジェクトを生成
        const formData = new FormData(answer_Input_form);
        //オブジェクト内の既存のキーに新しい値を追加
        formData.append("action", "bbs_answer_submit");
        const opt = {
            method: "post",
            body: formData
        }
        //非同期通信
        fetch("<?php echo home_url('wp-admin/admin-ajax.php'); ?>", opt)
            .then(response => {
                //ボタンを使用可にしています「非同期通信が完了して応答があった時」の処理です。
                submit_button.disabled = false;
                //ボタンのクラスからwaitを削除しています（もとのボタンに戻ります）
                submit_button.classList.remove('wait');
                return response.json();
            })
            .then(json => {
                if (json.error != "") {
                    alert(json.error);
                    return;
                }
                name_value = json.name;
                text_value = json.text;
                // const stamps = document.getElementsByName('stamp');
                /*for (var stamp of stamps) {
                  checkedプロパティは、対象の要素がcheckedを持っていればtrueを、持っていなければfalseを返す
                  if (stamp.checked) {
                    stamp_value = stamp.value;
                    break;
                  }
                }*/
                // change2(); これは恐らくステップフロー画像なので要らない
                // 空文字を入れることで要素内を空にできる
                confirm_area.textContent = '';
                var div;
                var child;
                // class
                //const divBoardFormPartial = document.createElement("div");
                // classの追加
                //divBoardFormPartial.classList.add("board_form_partial");
                // idの追加
                //divBoardFormPartial.id = 'js_board_form_partial_div';
                //confirm_area.appendChild(child); // confirm_area の末尾に child を追加
                //const divQuestionHeaderPartial = document.createElement("div");
                //divQuestionHeaderPartial.classList.add("questionHeader-partial");
                //div.appendChild(child); // div の末尾に child を追加
                /* アイコン画像要素作成 */
                const comment_area = document.createElement("div");
                const divUserArea = document.createElement("div"); // div (子)を生成
                const divUserIcon = document.createElement("div"); // div (子)を生成
                divUserArea.classList.add("user-area"); // classの追加
                divUserIcon.classList.add("user-icon"); // classの追加
                child = document.createElement("p");

                /* 名前要素作成 */
                const usericonImg = document.createElement("img");
                const divNamePartialParts = create_name_parts("answer-name-area", name_value, usericonImg);

                /* コメント要素作成 */
                const divBodyPartialParts = create_text_parts("answer-text-area", text_value);

                /* ファイルアップロード要素作成 */
                // const usericonImg = document.createElement("img");
                const divImagePartial = create_image_parts("uploadfile-area", 0, usericonImg);
                const image_area = document.createElement("div");

                /* アップロードファイルサイズ制限事項要素作成 */
                const divFilesizeRestrictionArea = document.createElement("div"); // div (子)を生成
                divFilesizeRestrictionArea.classList.add("filesize-restriction-area"); // classの追加
                divFilesizeRestrictionArea.textContent = "動画・画像をアップロード(Upload video・image)"; // 文字表示
                const spanFilesizeRestrictionArea = document.createElement("span");
                spanFilesizeRestrictionArea.classList.add("required");
                spanFilesizeRestrictionArea.textContent = "※ファイルサイズ15MB以内、JPG/GIF/PNG/MP4";

                /* アイコン画像要素配置 */
                // child = document.createElement("p"); と child.appendChild(document.createTextNode(○○○_value)); で 1セット
                // divUserIcon.appendChild(child); // div (子要素) の末尾に child を追加
                divUserIcon.appendChild(child); // div (子要素) の末尾に child を追加
                divUserArea.appendChild(divUserIcon); // div (子要素) の末尾に div を追加
                comment_area.appendChild(divUserArea); // comment_area (親要素) の末尾に div を追加

                /* 名前要素配置 */
                comment_area.appendChild(divNamePartialParts); // comment_area (親要素) の末尾に div を追加

                /* 回答要素配置 */
                comment_area.appendChild(divBodyPartialParts); // comment_area (親要素) の末尾に div を追加

                /* ファイルアップロード要素配置 */
                image_area.appendChild(divImagePartial);

                /* アップロードファイルサイズ制限事項要素配置 */
                divFilesizeRestrictionArea.appendChild(spanFilesizeRestrictionArea);

                /* 確認画面送信ボタン要素作成 */
                const divPostButton = create_button_parts(2);
                confirm_area.appendChild(comment_area);
                confirm_area.appendChild(image_area);
                confirm_area.appendChild(divPostButton); // confirm_area (親要素) の末尾に div を追加
                const image_count = image_area.getElementsByClassName("changeImg").length;
                if (image_count == 1) {
                    divUserArea.style.float = "left";
                } else if (image_count == 2) {
                    divUserArea.style.float = "left";
                    divBodyPartialParts.style.height = "728px"; //コメント欄外枠
                } else if (image_count == 3) {
                    Array.from(divUserArea.children).forEach(x => x.style.float = "left");
                }
                input_area.style.display = "none";
                confirm_area.style.display = "block";
            })
            .catch(error => {
                console.log(error);
            });
    }
    const confirm_button_click = function() {
        const formData = new FormData();
        formData.append("action", "bbs_answer_confirm");
        const opt = {
            method: "post",
            body: formData
        }
        fetch("<?php echo home_url('wp-admin/admin-ajax.php'); ?>", opt)
            .then(response => {
                return response.json();
            })
            .then(json => {
                if (json.error != "") {
                    alert(json.error);
                    return;
                }
                // change3();
                const buttons = document.querySelectorAll('.post-button');
                buttons.forEach(x => x.style.display = "none");
            })
            .catch(error => {
                console.log(error);
            });
    }
</script>


<!-- ここから回答表示 -->