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
        $name = $this->input->post("name");
        echo $name."님 반갑습니다.";
    }
}

/* End of file ajax_board.php */
/* Location: ./application/controllers/ajax_board.php */