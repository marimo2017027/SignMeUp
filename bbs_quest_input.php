<?php
/*
Template Name: bbs_quest_input
固定ページ: 質問する
*/
header('X-FRAME-OPTIONS: SAMEORIGIN');
get_header();
get_header('menu');
//追加コード
$upload_dir = wp_upload_dir();
$camera_url = $upload_dir['baseurl'] . '/camera.png';
$noimage_url = $upload_dir['baseurl'] . '/noimage.png';
?>
<style>
    .step_img {
        height: 364px;
        width: 36px;
    }
</style>
<div class="board_form_partial" id="js_board_form_partial">
    <div class="questionHeader-partial">
        <h2>
            <span class="fa-stack">
                <i class="fa fa-circle fa-stack-2x w-circle"></i>
                <i class="fa-stack-1x fa-inverse q">Q</i>
            </span>
            <span class="q-text" id="q_text"></span>
        </h2>
        <div class="other_step">
            <img id="step_img">
        </div>
    </div>
    <div id="input_area">
        <form name="input_form">
            <div class="image-partial">
                               <h2>動画・画像をアップロード(Upload video・image)<span class="required">※ファイルサイズ15MB以内、JPG/GIF/PNG/MP4</span></h2>
                <div class="image-selector-button">
                    <label>
                        <div class="image-camera-icon">
                            <img src="<?php echo $camera_url; ?>" class="changeImg" style="height:150px;width:150px">
                        </div>
                        <input type="file" class="attach" name="attach[]" accept=".png, .jpg, .jpeg, .pdf, .mp4" style="display: none;">
                    </label>
                    <div class="viewer" style="display: none;"></div>
                    <button type="button" class="attachclear">clear</button>
                </div>
                <div class="image-selector-button">
                    <label>
                        <div class="image-camera-icon"><img src="<?php echo $camera_url; ?>" class="changeImg" style="height:150px;width:150px">
                        </div>
                        <input type="file" class="attach" name="attach[]" accept=".png, .jpg, .jpeg, .pdf, .mp4" style="display: none;">
                    </label>
                    <div class="viewer" style="display: none;"></div>
                    <button type="button" class="attachclear">clear</button>
                </div>
                <div class="image-selector-button">
                    <label>
                        <div class="image-camera-icon">
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
                    display: none;
                }

                .concealItems {
                    display: none;
                }

                .wait {
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
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }
            </style>

            <div class="body-partial-parts"><!-- body-partial-parts -->
                <h2>質問文(question)<span class="required">※必須</span></h2>
                <div class="parts">
                    <textarea class="input" name="text" id="text" data-length="<?php echo MAX_LENGTH::TEXT; ?>" data-minlength="<?php echo MIN_LENGTH::TEXT; ?>" placeholder="荒らし行為や誹謗中傷や著作権の侵害はご遠慮ください"></textarea>
                    <div></div>
                </div>
            </div>

            <div class="title-partial-parts"> <!-- title-partial-parts -->
                <h2>質問タイトル(title)<span class="required">※必須</span></h2>
                <div class="parts">
                    <input class="input" type="text" name="title" id="title" data-length="<?php echo MAX_LENGTH::TITLE; ?>" data-minlength="<?php echo MIN_LENGTH::TITLE; ?>" placeholder="<?php echo MIN_LENGTH::TITLE; ?>文字以上で入力してください">
                    <div></div>
                </div>
            </div>

            <div class="stamp-partial">
                <h2>スタンプを選ぶ(必須)</h2>
                <input type="radio" name="stamp" value="1" id="stamp_1"><label for="stamp_1"></label>
                <input type="radio" name="stamp" value="2" id="stamp_2"><label for="stamp_2"></label>
                <input type="radio" name="stamp" value="3" id="stamp_3"><label for="stamp_3"></label>
                <input type="radio" name="stamp" value="4" id="stamp_4"><label for="stamp_4"></label>
                <input type="radio" name="stamp" value="5" id="stamp_5"><label for="stamp_5"></label>
                <input type="radio" name="stamp" value="6" id="stamp_6"><label for="stamp_6"></label>
                <input type="radio" name="stamp" value="7" id="stamp_7"><label for="stamp_7"></label>
                <input type="radio" name="stamp" value="8" id="stamp_8"><label for="stamp_8"></label>
            </div>

            <div class="usericon-partial">
                <h2>画像アイコン(image icon)<span class="required">※任意</span></h2>
                <div class="usericon-thumbnail-button">
                    <label>
                        <div class="usericon-uploads">
                            <img src="<?php echo $noimage_url; ?>" class="changeImg" style="height:90px;width:90px">
                        </div>
                        <input type="file" class="attach" name="attach[]" data-maxsize="5" accept=".png, .jpg, .jpeg" style="display: none;">
                    </label>
                    <div class="viewer" style="display: none;"></div>
                    <button type="button" class="attachclear">clear</button>
                </div>
            </div>

            <div class="name-partial-parts"> <!-- name-partial-parts -->
                <h2>名前(name)<span class="required">※任意</span></h2>
                <div class="parts">
                    <input class="input" type="text" name="name" id="name" data-length="<?php echo MAX_LENGTH::NAME; ?>" data-minlength="<?php echo MIN_LENGTH::NAME; ?>" placeholder="未入力の場合は、匿名で表示されます">
                    <div></div>
                </div>
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
<script>
    function change1() {
        q_text.textContent = "質問する";
        step_img.src = "http://www.irasuto.cfbx.jp/wp-content/themes/sample_theme/images/step01.png";
        step_img.alt = "STEP1 入力";
    }

    function change2() {
        q_text.textContent = "確認する";
        step_img.src = "http://www.irasuto.cfbx.jp/wp-content/themes/sample_theme/images/step02.png";
        step_img.alt = "STEP2 確認";
    }

    function change3() {
        q_text.textContent = "完了";
        step_img.src = "http://www.irasuto.cfbx.jp/wp-content/themes/sample_theme/images/step03.png";
        step_img.alt = "STEP3 完了";
    }

    /* function validation_submit(f) {
        const submit = document.getElementById("submit_button");
    submit.disabled = f ? false : true;
    };*/

    /* function validation_text(parts) {
    let text = parts.getElementsByClassName('input')[0];
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
        let parts = document.getElementsByClassName('parts');
        let submit = true;
        for (let i = 0; i < parts.length; i++) {
            if (validation_text(parts[i]) != true) {
                submit = false;
            }
        }
        validation_submit(submit);
    };

    const step_img = document.getElementById("step_img");
    const q_text = document.getElementById("q_text");
    const input_area = document.getElementById("input_area");
    const confirm_area = document.getElementById("confirm_area");
    const result_area = document.getElementById("result_area");
    var name_value = "";
    var title_value = "";
    var text_value = "";
    var stamp_value = "";
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
        const fileArea = document.querySelectorAll('.image-camera-icon,.usericon-uploads');
        const set_attach_image = function(i) {
            //HTML要素の中身を変更するときに使われるプロパティ
            if (i == 3) {
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
        change1();

        /* 文字数表示 */
        document.addEventListener('input', e => {
            if (!['name', 'title', 'text'].includes(e.target.id)) return;
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
        title_value = "";
        text_value = "";
        stamp_value = "";
        //サーバーにデータを送信する際に使用するオブジェクトを生成
        const formData = new FormData(input_form);
        //オブジェクト内の既存のキーに新しい値を追加
        formData.append("action", "bbs_quest_submit");
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
                title_value = json.title;
                const stamps = document.getElementsByName('stamp');
                for (var stamp of stamps) {
                    //checkedプロパティは、対象の要素がcheckedを持っていればtrueを、持っていなければfalseを返す
                    if (stamp.checked) {
                        stamp_value = stamp.value;
                        break;
                    }
                }
                change2();
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

                const image_area = document.createElement("div");
                const comment_area = document.createElement("div");
                var image_count = 0;
                const divImagePartial = document.createElement("div"); // div (子)を生成
                divImagePartial.classList.add("image-partial"); // classの追加
                var usericonImg;
                for (let i = 0; i < blobType.length; i++) {
                    if (i == 3) {
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
                            divImagePartial.appendChild(divImageCameraIcon); // image_partial (親要素) の末尾に image_camera_icon を追加
                        }
                    }
                }
                image_area.appendChild(divImagePartial); // image_area (親要素) の末尾に div を追加

                const divBodyPartialParts = document.createElement("div"); // div (子)を生成
                divBodyPartialParts.classList.add("body-partial-parts"); // classの追加
                child = document.createElement("p"); // p (孫)を生成
                child.appendChild(document.createTextNode(text_value)); //孫要素として Text ノードを生成
                divBodyPartialParts.appendChild(child); // div (子要素) の末尾に child を追加
                comment_area.appendChild(divBodyPartialParts); // comment_area (親要素) の末尾に div を追加
                divBodyPartialParts.style.fontSize = "150%"; //コメントの文字のサイズ

                const divTitlePartialParts = document.createElement("div"); // div (子)を生成
                divTitlePartialParts.classList.add("title-partial-parts"); // classの追加
                child = document.createElement("p"); // p (孫)を生成
                child.appendChild(document.createTextNode(title_value)); //孫要素として Text ノードを生成
                divTitlePartialParts.appendChild(child); // div (子要素) の末尾に child を追加
                comment_area.appendChild(divTitlePartialParts); // comment_area (親要素) の末尾に div を追加

                const divStampPartial = document.createElement("div"); // div (子)を生成
                divStampPartial.classList.add("stamp-partial"); // classの追加

                child = document.createElement("input"); // input (孫)を生成
                child.type = "radio";
                child.name = "stamp";
                child.id = "confirm_stamp";
                child.value = stamp_value;
                child.checked = true;
                divStampPartial.appendChild(child); // div の末尾に child を追加
                child = document.createElement("label");
                child.htmlFor = "confirm_stamp";
                divStampPartial.appendChild(child); // div (子要素) の末尾に child を追加
                comment_area.appendChild(divStampPartial); // comment_area (親要素) の末尾に div を追加

                const divNamePartialParts = document.createElement("div"); // div (子)を生成
                divNamePartialParts.classList.add("name-partial-parts"); // classの追加
                child = document.createElement("p"); // p (孫)を生成
                child.appendChild(document.createTextNode(name_value)); //孫要素として Text ノードを生成
                child.style.display = "inline-block";
                divNamePartialParts.appendChild(usericonImg);
                divNamePartialParts.appendChild(child); // div (子要素) の末尾に child を追加
                comment_area.appendChild(divNamePartialParts); // comment_area (親要素) の末尾に div を追加

                const divPostButton = document.createElement("div"); // div (子)を生成
                divPostButton.classList.add("post-button"); // classの追加

                child = document.createElement("button"); // button (孫)を生成
                child.type = "button";
                child.innerText = "入力画面へ戻る";
                child.addEventListener("click", () => {
                    change1();
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
                    divImagePartial.style.float = "left";
                } else if (image_count == 2) {
                    divImagePartial.style.float = "left";
                    divBodyPartialParts.style.height = "728px"; //コメント欄外枠
                } else if (image_count == 3) {
                    Array.from(divImagePartial.children).forEach(x => x.style.float = "left");
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
                change3();
                const buttons = document.querySelectorAll('.post-button');
                buttons.forEach(x => x.style.display = "none");
            })
            .catch(error => {
                console.log(error);
            });
    }
</script>