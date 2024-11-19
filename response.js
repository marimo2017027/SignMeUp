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

/* コメント要素作成 */
function create_text_parts(title_class, title_value) {
    const divTitlePartialParts = document.createElement("div"); // div (子)を生成
    divTitlePartialParts.classList.add(title_class); // classの追加
    const child = document.createElement("p"); // p (孫)を生成
    child.appendChild(document.createTextNode(title_value)); //孫要素として Text ノードを生成
    divTitlePartialParts.appendChild(child); // div (子要素) の末尾に child を追加
    return divTitlePartialParts; // create_name_parts() で生成した divTitlePartialParts を return
}