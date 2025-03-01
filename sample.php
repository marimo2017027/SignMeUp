<div class="placeholder-area">
    <div class="comments-composer">コメントする</div>
    <div class="answer-text-area">
        <textarea class="input" name="text" id="text" data-length="<?php echo MAX_LENGTH::TEXT; ?>" data-minlength="<?php echo MIN_LENGTH::TEXT; ?>" placeholder="荒らし行為や誹謗中傷や著作権の侵害はご遠慮ください"></textarea>
    </div>
</div>
<div class="board_respond" id="js_board_respond">
    <div id="input_area">
        <form name="answer_Input_form" onSubmit="AddInfo()">
            <input type="hidden" name="unique_id" value="<?php echo $unique_id; ?>">
            <input type="hidden" name="submitdate">
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
            <!-- <div class="answer-text-area">
                <div class="parts">
                    <textarea class="input" name="text" id="text" data-length="<?php echo MAX_LENGTH::TEXT; ?>" data-minlength="<?php echo MIN_LENGTH::TEXT; ?>" placeholder="荒らし行為や誹謗中傷や著作権の侵害はご遠慮ください"></textarea>
                    <div></div>
                </div>
            </div> -->
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

            <div class="filesize-restriction-area">
                <span class="xxxxxxxx">動画・画像をアップロード(Upload video・image)</span>
                <span class="required">※ファイルサイズ15MB以内、JPG/GIF/PNG/MP4</span>
            </div>
            <div class="post-button"><!-- ボタンを押せなくする -->
                <button type="button" id="cansel_button" name="" value="">キャンセル</button>
                <button type="button" id="submit_button" name="mode" value="confirm">確認画面へ進む</button>
            </div>
            <!-- type、name、id、valueの順番 -->
        </form>
    </div>
    <div id="confirm_area"></div>
    <div id="result_area"></div>
</div>

<script>
    // 返信フォームの表示・非表示切り替え
    $(function() {
        // eachでreplyの中から1つずつ値を取り出しビューで定義したid名に付与
        // $.each(reply, function(index, value) {
        // 入力フォームは初め隠しておく
        $("#js_board_respond").hide();
        // 返信ボタンをクリックしたら入力フォームを表示
        $(".answer-text-area").on("click", function() {
            $("#js_board_respond").show();
        });
        // Canselボタンをクリックしたら入力フォームを非表示に
        // 返信のキャンセルボタンのクラス名は replycansel_button にする
        $("#cansel_button").on("click", function() {
            $("#js_board_respond").hide();
        });
        // });
    });
</script>