<?php
/*
Template Name: bbs_que_answer
固定ページ: 回答画面
*/
header('X-FRAME-OPTIONS: SAMEORIGIN');
get_header();
// get_header('menu'); 必要なコードか分からない
$sql = 'SELECT * FROM sortable';
$query = $wpdb->prepare($sql);
$rows = $wpdb->get_results($query);
// アップロードディレクトリ（パス名）を取得する
$upload_dir = wp_upload_dir();
echo '<div id="questBoard">';
echo '<div>';
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
                $views[] = '<img style="height: 50px;" src="' . $attach_url . '">';
                break;
            case 'mp4':
                $views[] = '<video style="height: 50px;" src="' . $attach_url . '">';
                break;
            case 'pdf':
                $views[] = '<iframe style="height: 50px;" src="' . $attach_url . '"></iframe>';
                break;
            default:
                break;
        }
    }
    if (empty($row->usericon)) {
        $usericon_src = 'wp-content/themes/sample_theme/images/noimage.png';
    } else {
        $usericon_src = $upload_dir['baseurl'] . '/attach/' . $row->usericon;
    }
    // echo '<div><a href="'.$url.'">'.$row->unique_id.'</a></div>';
    echo '<div>' . mb_strimwidth($row->title, 0, 40, '･･･') . '</div>'; // タイトル30文字
    echo '<div><input type="radio" name="stamp" value="' . $row->stamp . '" id="stamp"><label for="stamp"></label></div>'; // スタンプ画像
    foreach ($views as $view) {
        echo '<div>' . $view . '</div>';  // アップロードファイル
    }
    echo '<div>' . mb_strimwidth($row->text, 0, 40, '･･･') . '</div>'; // 質問文
    echo '<div><img src="' . $usericon_src . '"></div>'; // アイコン画像
    echo '<div>' . mb_strimwidth($row->name, 0, 10, '･･･') . '</div>'; // 名前
}
echo '</div>';
// var_dump($attach_dir);
//ここから回答機能
//追加コード
// $upload_dir = wp_upload_dir();
$camera_url = $upload_dir['baseurl'] . '/camera.png';
$noimage_url = $upload_dir['baseurl'] . '/noimage.png';
?>
<div class="board_respond" id="js_board_respond">
    <div id="Input_area">
        <form name="answer_Input_form">
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
                <div class="contents">
                    <input class="input" type="text" name="name" id="name" data-length="<?php echo MAX_LENGTH::NAME; ?>" data-minlength="<?php echo MIN_LENGTH::NAME; ?>" placeholder="未入力の場合は、匿名で表示されます">
                    <div></div>
                </div>
            </div>
            <div class="answer-text-area">
                <div class="contents">
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
    /* function validation_submit(f) {
        const submit = document.getElementById("submit_button");
    submit.disabled = f ? false : true;
    }; */

    /* function validation_text(contents) {
    let text = contents.getElementsByClassName('input')[0];
    if (text.value.length < text.dataset.minlength) {
        return false;
    }
    if (text.value.length > text.dataset.length) {
        return false;
    }
    return true;
    }; */
    /* バリデーション条件判断部分 */
    function validation() {
        let contents = document.getElementsByClassName('contents');
        let submit = true;
        for (let i = 0; i < contents.length; i++) {
            if (validation_text(contents[i]) != true) {
                submit = false;
            }
        }
        validation_submit(submit);
    };
    const Input_area = document.getElementById("input_area");
    const confirm_area = document.getElementById("confirm_area");
    const result_area = document.getElementById("result_area");
    var name_value = "";
    var text_value = "";
    // 要素が3個の空配列を作成
    const blobType = ["", "", "", ""];
    const blobUrl = ["", "", "", ""];
    const set_attach_event = function() {
        /* カメラ画像をファイルアップロード時に非表示にする */
        /* 省略 */
        /* カメラ画像をファイルアップロード時に非表示にする */
        const attach = document.querySelectorAll('.attach');
        const clear = document.querySelectorAll('.attachclear');
        const viewer = document.querySelectorAll('.viewer');
        const changeImg = document.querySelectorAll('.changeImg'); // 入力されたら消す画像
        // .usericon-uploads → .user-icon に変更
        const fileArea = document.querySelectorAll('.uploadfile-camera-icon,.user-icon');
        const set_attach_image = function(i) {
            //HTML要素の中身を変更するときに使われるプロパティ
            if (i == 0) {
                maxsize = 5;
                height = "85px";
                width = "85px";
            } else {
                maxsize = 15;
                height = "350px";
                width = "530px";
            }
            if (attach[i].files[0].size > maxsize * 1024 * 1024) {
                alert('ファイルサイズが ' + maxsize + 'MBバイトを超えています');
                return;
            }
            viewer[i].innerHTML = "";
            //新コード
            blobType[i] = "";
            blobUrl[i] = "";
            if (attach[i].files.length !== 0) {
                //オブジェクトのURLを作成する
                blobUrl[i] = window.URL.createObjectURL(attach[i].files[0]);
                //ファイルの内容を読み込む FileReaderオブジェクト を生成し、ファイルの内容を非同期で取得
                const reader = new FileReader();
                reader.onload = () => {
                    var child = null;
                    //result プロパティは、ファイルの内容を返す
                    if (reader.result.indexOf("data:image/jpeg;base64,") === 0 ||
                        reader.result.indexOf("data:image/png;base64,") === 0) {
                        blobType[i] = "img";
                        child = document.createElement("img");
                    } else if (reader.result.indexOf("data:video/mp4;base64,") === 0) {
                        blobType[i] = "video";
                        child = document.createElement("video");
                        child.setAttribute("controls", null);
                    } else if (reader.result.indexOf("data:application/pdf;base64,") === 0) {
                        blobType[i] = "iframe";
                        child = document.createElement("iframe");
                    } else {
                        alert("対象外のファイルです");
                        attach[i].value = "";
                    }
                    if (child !== null) {
                        child.style.height = height;
                        child.style.width = width;
                        child.src = blobUrl[i];
                        //戻り値は追加した子要素 viewer[i]
                        viewer[i].appendChild(child);
                        viewer[i].style.display = "block";
                        //fileArea[i].style.display = "none";
                        //旧コード
                        //changeImg[i].classList.add('hideItems'); // もともとの画像を消す
                        fileArea[i].classList.add('hideItems'); // もともとの画像を消す
                    }
                };
                //指定されたBlob または File の内容を読み込む
                reader.readAsDataURL(attach[i].files[0]);
            }
        };
        for (let i = 0; i < attach.length; i++) {
            attach[i].addEventListener('change', () => {
                set_attach_image(i);
            });
            clear[i].addEventListener('click', () => {
                blobType[i] = "";
                blobUrl[i] = "";
                attach[i].value = "";
                viewer[i].innerHTML = "";
                viewer[i].style.display = "none";
                //fileArea[i].style.display = "block";
                //changeImg[i].classList.remove('hideItems');
                fileArea[i].classList.remove('hideItems');
            });
            // ドラッグオーバー時の処理
            fileArea[i].addEventListener('dragover', function(e) {
                e.preventDefault();
                fileArea[i].classList.add('dragover');
            });
            // ドラッグアウト時の処理	
            fileArea[i].addEventListener('dragleave', function(e) {
                e.preventDefault();
                fileArea[i].classList.remove('dragover');
            });
            // ドロップ時の処理	
            fileArea[i].addEventListener('drop', function(e) {
                e.preventDefault();
                fileArea[i].classList.remove('dragover');
                // ドロップしたファイルの取得	
                var files = e.dataTransfer.files;
                // 取得したファイルをinput[type=file]へ	
                attach[i].files = files;
                if (typeof files[0] !== 'undefined') {
                    //ファイルが正常に受け取れた際の処理	
                    set_attach_image(i);
                }
            });
        };
    }
    const init = function() {
        set_attach_event();
        document.getElementById("submit_button").addEventListener("click", submit_button_click);
        // change1();
        /* 文字数表示 */
        document.addEventListener('input', e => {
            if (!['name', 'text'].includes(e.target.id)) return;
            const
                t = e.target,
                m = t.nextElementSibling,
                n = t.value.length - (t.dataset.length | 0),
                c = document.createElement('strong');
            //絶対値が欲しい時
            c.append(Math.abs(n));
            //classを設定
            m.className = 'msg_partial';
            m.style.color = n > 0 ? 'red' : 'black';
            m.replaceChildren(n > 0 ? '' : '残り', c,
                `文字${n > 0 ? '超過してい' : '入力でき'}ます。`);
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
                /* ファイルアップロード要素作成 */
                const image_area = document.createElement("div");
                var image_count = 0;
                const divImagePartial = document.createElement("div"); // div (子)を生成
                divImagePartial.classList.add("uploadfile-area"); // classの追加
                var usericonImg;
                for (let i = 0; i < blobType.length; i++) {
                    if (i == 0) {
                        usericonImg = document.createElement("img");
                        usericonImg.style.maxHeight = "85px";
                        usericonImg.style.maxWidth = "85px";
                        if (blobType[i] == "") {
                            usericonImg.src = "<?php echo $noimage_url; ?>";
                        } else {
                            usericonImg.src = blobUrl[i];
                        }
                    } else {
                        var changeImg = null;
                        if (blobType[i] == "img") {
                            changeImg = document.createElement("img");
                        } else if (blobType[i] == "video") {
                            changeImg = document.createElement("video");
                            changeImg.setAttribute("controls", null);
                        } else if (blobType[i] == "iframe") {
                            changeImg = document.createElement("iframe");
                        }
                        if (changeImg !== null) {
                            image_count++;
                            changeImg.classList.add("changeImg");
                            changeImg.style.height = "350px";
                            changeImg.style.width = "530px";
                            changeImg.src = blobUrl[i];
                            const divImageCameraIcon = document.createElement("div"); // div (孫)を生成
                            divImageCameraIcon.classList.add("image-camera-icon"); // classの追加
                            divImageCameraIcon.appendChild(changeImg); // image_camera_icon (子要素) の末尾に changeImg を追加
                            divImagePartial.appendChild(divImageCameraIcon); // uploadfile_area (親要素) の末尾に image_camera_icon を追加
                        }
                    }
                }
                image_area.appendChild(divImagePartial); // image_area (親要素) の末尾に div を追加
                /* 名前要素作成 */
                const comment_area = document.createElement("div"); // const image_area の下から移動
                const divNamePartialParts = document.createElement("div"); // div (子)を生成
                divNamePartialParts.classList.add("answer-name-area"); // classの追加
                child = document.createElement("p"); // p (孫)を生成
                child.appendChild(document.createTextNode(name_value)); //孫要素として Text ノードを生成
                child.style.display = "inline-block";
                // divNamePartialParts.appendChild(usericonImg);
                divNamePartialParts.appendChild(child); // div (子要素) の末尾に child を追加
                comment_area.appendChild(divNamePartialParts); // comment_area (親要素) の末尾に div を追加
                /* コメント要素作成 */
                const divBodyPartialParts = document.createElement("div"); // div (子)を生成
                divBodyPartialParts.classList.add("answer-text-area"); // classの追加
                child = document.createElement("p"); // p (孫)を生成
                child.appendChild(document.createTextNode(text_value)); //孫要素として Text ノードを生成
                divBodyPartialParts.appendChild(child); // div (子要素) の末尾に child を追加
                comment_area.appendChild(divBodyPartialParts); // comment_area (親要素) の末尾に div を追加
                divBodyPartialParts.style.fontSize = "150%"; //コメントの文字のサイズ
                /* アイコン画像要素作成 */
                const divUserArea = document.createElement("div"); // div (子)を生成
                const divUserIcon = document.createElement("div"); // div (子)を生成
                divUserArea.classList.add("user-area"); // classの追加
                divUserIcon.classList.add("user-icon"); // classの追加
                // child = document.createElement("p"); と child.appendChild(document.createTextNode(○○○_value)); で 1セット
                // divUserIcon.appendChild(child); // div (子要素) の末尾に child を追加
                divUserIcon.appendChild(child); // div (子要素) の末尾に child を追加
                divUserArea.appendChild(divUserIcon); // div (子要素) の末尾に div を追加
                comment_area.appendChild(divUserArea); // comment_area (親要素) の末尾に div を追加
                /* アップロードファイルサイズ制限事項要素作成 */
                const divFilesizeRestrictionArea = document.createElement("div"); // div (子)を生成
                divFilesizeRestrictionArea.classList.add("filesize-restriction-area"); // classの追加
                comment_area.appendChild(divFilesizeRestrictionArea); // comment_area (親要素) の末尾に filesize-restriction-area を追加
                /* 確認画面送信ボタン要素作成 */
                const divPostButton = document.createElement("div"); // div (子)を生成
                divPostButton.classList.add("post-button"); // classの追加
                child = document.createElement("button"); // button (孫)を生成
                child.type = "button";
                child.innerText = "入力画面へ戻る";
                child.addEventListener("click", () => {
                    // change1();
                    input_area.style.display = "block";
                    // 空文字を入れることで要素内を空にできる
                    confirm_area.textContent = '';
                    confirm_area.style.display = "none";
                });
                divPostButton.appendChild(child); // div (子要素) の末尾に child を追加
                child = document.createElement("button"); // button (孫)を生成
                child.type = "button";
                //name属性の追加・変更
                child.setAttribute("name", "output");
                child.innerText = "結果画面へ進む";
                child.addEventListener("click", confirm_button_click);
                divPostButton.appendChild(child); // div (子要素) の末尾に child を追加
                comment_area.appendChild(divPostButton); // comment_area (親要素) の末尾に div を追加
                confirm_area.appendChild(image_area);
                confirm_area.appendChild(comment_area);
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
        formData.append("action", "bbs_quest_confirm");
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