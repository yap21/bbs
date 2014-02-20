<article id="board_area">
    <header>
        <h1></h1>
    </header>
    <table cellspaCodeIgniterng="0" cellpadding="0" class="table table-striped">
        <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">제목</th>
                <th scope="col">작성자</th>
                <th scope="col">조회수</th>
                <th scope="col">작성일</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($list as $lt)
        {
        ?>
            <tr>
                <th scope="row">
                    <?php echo $lt->board_id;?>
                </th>
                <td><a rel="external" href="/bbs/<?php echo $this->uri->segment(1);?>/view/<?php echo $this->uri->segment(3);?>/board_id/<?php echo $lt->board_id;?>/page/<?php echo $page;?>"><?php echo $lt->subject;?></a>
                <td><?php echo $lt->user_name;?></td>
                <td><?php echo $lt->hits;?></td>
                <td><time datetime="<?php echo $lt->reg_date;?>"><?php echo $lt->reg_date;?></time></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5"><?php echo $pagination;?></th>
            </tr>
        </tfoot>
    </table>
    <div>
        <p><a href="/bbs/board/write/<?php echo $this->uri->segment(3);?>/page/<?php echo $this->uri->segment(5);?>" class="btn btn-success">쓰기</a></p>
    </div>
    <div>
        <form id="bd_search" method="post">
            <input type="text" name="search_word" id="q" onkeypress="board_search_enter(document.q);" />
            <input type="button" value="검색" id="search_btn" />
        </form>
    </div>
</article>