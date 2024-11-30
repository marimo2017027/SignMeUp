/* 確認画面へ進むボタンの使用可不可を制御するコード */
function validation_submit(f) {
    const submit = document.getElementById("submit_button");
    /* 判定は逆なので、逆に渡す */
    submit.disabled = f ? false : true;
};

function validation_text(parts) {
    /* このpartsグループの、inputを抽出 */
    let text = parts.getElementsByClassName('input')[0];
    /* 最小チェック */
    if (text.value.length < text.dataset.minlength) {
        return false;
    }
    /* 最大チェック */
    if (text.value.length > text.dataset.length) {
        return false;
    }
    return true;
};

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

/* 文字数表示 */
function display_text_length(e) {
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
}

/* 名前要素作成 */
const create_name_parts = function (name_class, name_value, usericonImg) {
    const divNamePartialParts = document.createElement("div"); // div (子)を生成
    divNamePartialParts.classList.add(name_class); // classの追加
    const child = document.createElement("p"); // p (孫)を生成
    child.appendChild(document.createTextNode(name_value)); //孫要素として Text ノードを生成
    child.style.display = "inline-block";
    divNamePartialParts.appendChild(usericonImg);
    divNamePartialParts.appendChild(child); // div (子要素) の末尾に child を追加
    return divNamePartialParts; // create_name_parts() で生成した divNamePartialParts を return 
}

/* コメント要素作成 */
const create_text_parts = function (text_class, text_value) {
    const divBodyPartialParts = document.createElement("div"); // div (子)を生成
    divBodyPartialParts.classList.add(text_class); // classの追加
    const child = document.createElement("p"); // p (孫)を生成
    child.appendChild(document.createTextNode(text_value)); //孫要素として Text ノードを生成
    divBodyPartialParts.appendChild(child); // div (子要素) の末尾に child を追加
    divBodyPartialParts.style.fontSize = "150%"; //コメントの文字のサイズ
    return divBodyPartialParts; // create_name_parts() で生成した divBodyPartialParts を return
}

/* タイトル要素作成 */
const create_title_parts = function (title_class, title_value) {
    const divTitlePartialParts = document.createElement("div"); // div (子)を生成
    divTitlePartialParts.classList.add(title_class); // classの追加
    const child = document.createElement("p"); // p (孫)を生成
    child.appendChild(document.createTextNode(title_value)); //孫要素として Text ノードを生成
    divTitlePartialParts.appendChild(child); // div (子要素) の末尾に child を追加
    return divTitlePartialParts; // create_title_parts() で生成した divTitlePartialParts を return
}

/* ファイルアップロード要素作成 */
const create_image_parts = function (image_class, usericonIndex, usericonImg) {
    // const image_area = document.createElement("div");
    // const comment_area = document.createElement("div");
    // var image_count = 0;
    const divImagePartial = document.createElement("div"); // div (子)を生成
    divImagePartial.classList.add(image_class); // classの追加
    // var usericonImg;
    for (let i = 0; i < blobType.length; i++) {
        if (i == usericonIndex) {
            // usericonImg = document.createElement("img");
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
                // image_count++;
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
    // image_area.appendChild(divImagePartial); // image_area (親要素) の末尾に div を追加
    return divImagePartial; // create_image_parts() で生成した divImagePartial を return
}

/* 確認画面送信ボタン要素作成 */
const create_button_parts = function (formType) {
    const divPostButton = document.createElement("div"); // div (子)を生成
    divPostButton.classList.add("post-button") // classの追加

    child = document.createElement("button"); // button (孫)を生成
    child.type = "button";
    child.innerText = "入力画面へ戻る";
    child.addEventListener("click", () => {
        if (formType == 1) {
            change1();
            // } else if (formType == 2) {
            //    change1();
        }
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
    return divPostButton; // create_button_parts() で生成した divPostButton を return
}

const set_attach_event = function (fileAreaSelector, usericonIndex) {
    /* カメラ画像をファイルアップロード時に非表示にする */
    /* 省略 */
    /* カメラ画像をファイルアップロード時に非表示にする */
    const attach = document.querySelectorAll('.attach');
    const clear = document.querySelectorAll('.attachclear');
    const viewer = document.querySelectorAll('.viewer');
    const changeImg = document.querySelectorAll('.changeImg'); // 入力されたら消す画像
    const fileArea = document.querySelectorAll(fileAreaSelector);
    const set_attach_image = function (i) {
        //HTML要素の中身を変更するときに使われるプロパティ
        if (i == usericonIndex) {
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
        fileArea[i].addEventListener('dragover', function (e) {
            e.preventDefault();
            fileArea[i].classList.add('dragover');
        });
        // ドラッグアウト時の処理	
        fileArea[i].addEventListener('dragleave', function (e) {
            e.preventDefault();
            fileArea[i].classList.remove('dragover');
        });
        // ドロップ時の処理	
        fileArea[i].addEventListener('drop', function (e) {
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