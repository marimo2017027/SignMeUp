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