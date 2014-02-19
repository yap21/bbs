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
}

/* End of file board_m.php */
/* Location: ./application/models/board_m.php */