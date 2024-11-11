/* 確認画面へ進むボタンの使用可不可を制御するコード */
<script>
    function validation_submit(f) {
        const submit = document.getElementById("submit_button");
    /* 判定は逆なので、逆に渡す */
    submit.disabled = f ? false : true;
    };
</script>