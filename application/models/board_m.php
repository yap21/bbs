<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * todo model
 */
class Board_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_list($table='ci_board',$type='',$offset='',$limit='', $search_word='')
    {
        $sword = '';

        if($search_word != '')
        {
            // 검색어가 있을 경우의 처리
            $sword = ' WHERE subject like "%'.$search_word.'%" or contents like "%'.$search_word.'%" ';
        }

        $limit_query = '';

        if( $limit != '' OR $offset != '')
        {
            //페이징이 있을 경우는 처리
            $limit_query = ' LIMIT '.$offset.', '.$limit;
        }

        $sql = "SELECT * FROM ".$table.$sword." ORDER BY board_id DESC".$limit_query;
        $query = $this->db->query($sql);

        if( $type == 'count')
        {
            //리스트를 반환하는 것이 아니라 전체 게시물의 개수를 반환
            $result = $query->num_rows();

            //$this->db->count_all($table);
        }
        else
        {
            //게시물 리스트 반환
            $result = $query->result();
        }
        return $result;
    }

    /**
     * 게시물 상세보기 가져오기
     *
     * @param string $table 게시판 테이블
     * @param string $id 게시물번호
     * @return array
     */
    function get_view($table, $id)
    {
        // 조횟수 증가
        $sql0 = "UPDATE ".$table." SET hits=hits+1 WHERE board_id='".$id."'";
        $this->db->query($sql0);

        $sql = "SELECT * FROM ".$table." WHERE board_id='".$id."'";
        $query = $this->db->query($sql);

        // 게시물 내용 반환
        $result = $query->row();

        return $result;
    }

    /**
     * 게시물 입력
     *
     * @param array $arrays 테이블명, 제목, 내용 1차 배열
     * @return boolean 입력 성공여부
     */
    function insert_board($arrays)
    {
        $insert_array = array(
            'board_pid' => 0,                   // 원글이라 0을 입력, 댓글일 경우 원글 번호 입력
            'user_id'   => $arrays['user_id'],  // 로그인 아이디
            'user_name' => '웅파',
            'subject'   => $arrays['subject'],
            'contents'  => $arrays['contents'],
            'reg_date'  => date("Y-m-d H:i:s")
        );

        $result = $this->db->insert($arrays['table'], $insert_array);

        // 결과 반환
        return $result;
    }

    /**
     * 게시물 수정
     *
     * @param array $arrays 테이블명, 게시물 번호, 제목, 내용 1차 배열
     * @return boolean 수정 성공여부
     */
    function modify_board($arrays)
    {
        $modify_array = array(
            'subject'   => $arrays['subject'],
            'contents'  => $arrays['contents']
        );

        $where = array(
            'board_id' => $arrays['board_id']
        );

        $result = $this->db->update($arrays['table'], $modify_array, $where);

        // 결과 반환
        return $result;
    }

    /**
     * 게시물 삭제
     *
     * @param string $table 테이블명
     * @param string $no 게시물 번호
     * @return boolean 삭제 성공 여부
     */
    function delete_content($table, $no)
    {
        $delete_array = array(
            'board_id' => $no
        );

        $result = $this->db->delete($table, $delete_array);

        // 결과 반환
        return $result;
    }

    /**
     * 게시물 작성자 아이디 반환
     * return string 작성자 아이디
     */
    function writer_check()
    {
        $table = $this->uri->segment(3);
        $board_id = $this->uri->segment(5);

        $sql = "SELECT user_id FROM ".$table." WHERE board_id = '".$board_id."'";
        $query = $this->db->query($sql);

        return $query->row();
    }
}

/* End of file board_m.php */
/* Location: ./application/models/board_m.php */