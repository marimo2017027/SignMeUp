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
function create_name_parts(name_class, name_value, usericonImg) {
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
function create_text_parts(text_class, text_value) {
    const divBodyPartialParts = document.createElement("div"); // div (子)を生成
    divBodyPartialParts.classList.add(text_class); // classの追加
    const child = document.createElement("p"); // p (孫)を生成
    child.appendChild(document.createTextNode(text_value)); //孫要素として Text ノードを生成
    divBodyPartialParts.appendChild(child); // div (子要素) の末尾に child を追加
    divBodyPartialParts.style.fontSize = "150%"; //コメントの文字のサイズ
    return divBodyPartialParts; // create_name_parts() で生成した divBodyPartialParts を return
}

/* タイトル要素作成 */
function create_title_parts(title_class, title_value) {
    const divTitlePartialParts = document.createElement("div"); // div (子)を生成
    divTitlePartialParts.classList.add(title_class); // classの追加
    const child = document.createElement("p"); // p (孫)を生成
    child.appendChild(document.createTextNode(title_value)); //孫要素として Text ノードを生成
    divTitlePartialParts.appendChild(child); // div (子要素) の末尾に child を追加
    return divTitlePartialParts; // create_title_parts() で生成した divTitlePartialParts を return
}

/* ファイルアップロード要素作成 */
function create_image_parts(image_class, usericonIndex, usericonImg) {
    const image_area = document.createElement("div");
    // const comment_area = document.createElement("div");
    var image_count = 0;
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
    return image_area;
}
