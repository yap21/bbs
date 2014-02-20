<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 게시판 메인 컨트롤러
 */
class Board extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('board_m');
    }

    /**
     * 주소에서 메서드가 생략되었을 때 실행되는 기본 메서드
     */
    public function index()
    {
        $this->lists();
    }

    /**
     * 사이트 헤더, 푸터가 자동으로 추가된다.
     */
    public function _remap($method)
    {
        //헤더 include
        $this->load->view('header_v');

        if(method_exists($this, $method))
        {
            $this->{"{$method}"}();
        }

        //푸터 include
        $this->load->view('footer_v');
    }

    /**
     * 목록 불러오기
     */
    public function lists()
    {
        $this->output->enable_profiler(TRUE);
        //검색어 초기화
        $search_word = $page_url = '';
        $uri_segment = 5;

        //주소 중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
        $uri_array = $this->segment_explode($this->uri->uri_string());

        if(in_array('q', $uri_array)){
            //주소에 검색어가 있을 경우의 처리. 즉 검색 시
            $search_word = urldecode($this->url_explode($uri_array, 'q'));

            //페이지네이션용 주소
            $page_url = '/q/'.$search_word;
            $uri_segment = 7;
        }

        //페이지네이션 라이브러리 로딩 추가
        $this->load->library('pagination');

        //페이지네이션 설정
        $config['base_url'] = '/bbs/board/lists/ci_board'.$page_url.'/page/'; //페이징 주소
        //게시물의 전체 개수
        $config['total_rows'] = $this->board_m->get_list($this->uri->segment(3), 'count', '', '', $search_word);
        $config['per_page'] = 5;    //한 페이지 표시할 게시물 수
        $config['uri_segment'] = $uri_segment; //페이지 번호가 위치한 세그먼트

        //페이지네이션 초기화
        $this->pagination->initialize($config);
        //페이징 링크를 생서하여 view에서 사용할 변수에 할당
        $data['pagination'] = $this->pagination->create_links();

        //게시판 목록을 불러오기 위한 offset, limit 값 가져오기
        $data['page'] = $page = $this->uri->segment($uri_segment, 1);

        if( $page > 1 )
        {
            $start = (($page/$config['per_page'])) * $config['per_page'];
        }else{
            $start = ($page-1) * $config['per_page'];
        }
        $limit = $config['per_page'];

        $data['list'] = $this->board_m->get_list($this->uri->segment(3), '', $start, $limit, $search_word);
        $this->load->view('board/list_v', $data);
    }

    /**
     * 게시물 보기
     */
    function view()
    {
        $table = $this->uri->segment(3);
        $board_id = $this->uri->segment(5);

        //게시판 이름과 게시물 번호에 해당하는 게시물 가져오기
        $data['views'] = $this->board_m->get_view($table, $board_id);

        // view 호출
        $this->load->view('board/view_v', $data);
    }

    /**
     * url 중 키값을 구분하여 값을 가져오도록
     *
     * @param Array $url : segment_explode 한 url 값
     * @param String $key : 가져오려는 값의 key
     * @return String $url[$k] : 리턴값
     */

    function url_explode($url, $key)
    {
        $cnt = count($url);
        for($i=0; $cnt>$i; $i++)
        {
            if($url[$i] == $key)
            {
                $k = $i+1;
                return $url[$k];
            }
        }
    }

    /**
     * HTTP의 URL을 "/"를 Delimiter로 사용하여 배열로 바꿔 리턴한다.
     *
     * @param string 대상이 되는 문자열
     * @return string[]
     */
    function segment_explode($seg)
    {
        //세크먼트 앞뒤 '/' 제거 후 uri를 배열로 반화
        $len = strlen($seg);
        if(substr($seg, 0, 1) == '/')
        {
            $seg = substr($seg, 1, $len);
        }
        $len = strlen($seg);
        if(substr($seg, -1) == '/')
        {
            $seg = substr($seg, 0, $len-1);
        }
        $seg_exp = explode("/", $seg);
        return $seg_exp;
    }
}

/* End of file board.php */
/* Location: ./application/controllers/board.php */