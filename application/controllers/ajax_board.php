<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Ajax 처리 컨트롤러
 */
class Ajax_board extends CI_Controller {
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Ajax 테스트
     */
    public function test()
    {
        $this->load->view('ajax/test_v');
    }

    public function ajax_action()
    {
        //echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $name = $this->input->post("name");
        echo $name."님 반갑습니다.";
    }

    public function ajax_comment_add()
    {
        if(@$this->session->userdata('logged_in') == TRUE)
        {
            $this->load->model('board_m');

            $table = $this->input->post("table", TRUE);
            $board_id = $this->input->post("board_id", TRUE);
            $comment_contents = $this->input->post("comment_contents", TRUE);

            if($comment_contents != '')
            {
                $write_data = array(
                    'table' => $table,          // 게시판 테이블명
                    'board_pid' => $board_id,   // 원글 번호
                    'subject' => 'comment',
                    'contents' => $comment_contents,
                    'user_id' => $this->session->userdata('username')
                );

                $result = $this->board_m->insert_comment($write_data);

                if($result)
                {
                    // 글 작성 성공 시 댓글 목록 만들어 화면 출력
                    $sql = "SELECT * FROM ".$table." WHERE board_pid = '".$board_id."' ORDER BY board_id DESC";
                    $query = $this->db->query($sql);
                    ?>
                        <table cellspacing="0" cellpadding="0" class="table table-striped">
                            <tbody>
                            <?php
                            foreach($query->result() as $lt)
                            {
                            ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $lt->user_id;?>
                                </th>
                                <td><?php echo $lt->contents;?></td>
                                <td><time datetime="<?php echo $lt->reg_date;?>"><?php echo $lt->reg_date;?></time></td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                <?php
                }
                else
                {
                    //글 실패 시
                    echo "2000";
                }
            }
            else
            {
                // 글 내용이 없을 경우
                echo "1000";
            }
        }
        else
        {
            echo "9000";    //로그인 필요 에러
        }
    }
}

/* End of file ajax_board.php */
/* Location: ./application/controllers/ajax_board.php */