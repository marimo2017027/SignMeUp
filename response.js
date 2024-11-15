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