<?php
/*
Template Name: bbs_lile_count
固定ページ: いいねボタン
*/
?>
<style>
    .quest_likeButton svg {
        vertical-align: text-bottom;
    }
</style>

<button type="button" class="quest_likeButton">
    <svg class="likeButton_icon" xmlns="http://www.irasuto.cfbx.jp/wp-content/themes/sample_theme/good.svg">
    </svg>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() { // キーが押された瞬間に一度だけ発生
        //function countClickbutton() {
        // カウント用の変数
        let count = 0;
        // いいねボタンの要素を取得
        const likeButtonIcon = document.querySelector("likeButton_icon");
        // 取得したいいねボタンがクリックされた時、カウントを1つ増やして再代入する
        likeButtonIcon.addEventListener("click", function() {
            count++;
            // ボタンが押された時にいいねされた状態の見た目に変更する
            likeButtonIcon.classList.toggle('liked');
        })
        // }
    }, false);
</script>
