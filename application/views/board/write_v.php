<article id="board_area">
    <header>
        <h1></h1>
    </header>

    <!--<form class="form-horizontal" method="post" action="" id="write_action">-->
    <?php
    $attributes = array('class' => 'form-horizontal','id' => 'write_action');
    echo form_open('bbs/board/write/ci_board', $attributes);
    ?>
        <fieldset>
            <legend>게시물 쓰기</legend>
            <div class="control-group">
                <label class="control-label" for="input01">제목</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="input01" name="subject" value="<?php echo set_value('subject'); ?>">
                    <p class="help-block">게시물의 제목을 써주세요.</p>
                </div>
                <label class="control-label" for="input02">내용</label>
                <div class="controls">
                    <textarea class="input-xlarge" id="input02" name="contents" rows="5" value="<?php echo set_value('contents'); ?>"></textarea>
                    <p class="help-block">게시물의 내용을 써주세요.</p>
                </div>

                <div class="controls">
                    <p class="help-block"><?php echo validation_errors(); ?></p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="write_btn">작성</button>
                    <button class="btn" onclick="document.location.reload()">취소</button>
                </div>
            </div>
        </fieldset>
    </form>
</article>