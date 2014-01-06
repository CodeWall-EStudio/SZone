<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SZone Application Model Class
 *
 * This class object extends from the CodeIgniter super class CI_Model.
 *
 * @package		SZone
 * @subpackage	application
 * @category	models
 * @author		Code Wall-E Studio
 * @link		http://codewalle.com
 */
class Board_model extends CI_Model {

    protected $table  = 'board';
    protected $utable = 'user';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_all_nums($gid,$key=0){
    	$this->db->select('count(id) as allnum');
    	$this->db->where('gid',$gid);
        if($key){
            $this->db->like('content',$key);
        }    	
    	$query = $this->db->get($this->table);
    	$row = $query->row();

    	return $row->allnum;
    }

    function get_boards($gid,$st=0,$num=10,$key=0){
    	//$sql = 'SELECT a.id,a.content,a.ctime,b.name FROM board a,user b WHERE a.uid = b.id AND a.gid = '.$gid.' order by a.ctime desc limit 0,10 ';//AND a.status =1 

    	$this->db->select('board.id,board.content,board.ctime,user.name');
    	$this->db->from($this->table);
    	$this->db->join($this->utable,'user.id = board.uid');
    	$this->db->where('board.gid',$gid);
        if($key){
            $this->db->like('content',$key);
        }     	
    	$this->db->limit($num,$st);
    	$this->db->order_by('board.ctime','desc');

    	$query = $this->db->get();
    	$rl = array();
    	foreach($query->result() as $row){
			$rl[$row->id] = array(
				'id' => $row->id,
				'content' => $row->content,
				'time' => $row->ctime,
				'name' => $row->name
			);
    	}
    	return $rl;
    }
}
// END Model class

/* End of file file_model.php */
/* Location: ./application/controllers/file_model.php */