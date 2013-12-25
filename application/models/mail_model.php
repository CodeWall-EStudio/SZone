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
class Mail_model extends CI_Model {
    protected $table   = 'message';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }	

    function get_user_new_mail($id){
    	$this->db->where('tuid',$id);
    	$this->db->where('tlooked',0);
    	$query = $this->db->get($this->table);
    	return $query->num_rows();
    }

    function get_user_post_mail($id){
		$this->db->where('fuid',$id);
		$this->db->where('flooked',0);
		$query = $this->db->get($this->table);
		return $query->num_rows();
    }

    function look_all_mail($id){
    	$this->db->update($this->table, array('tlooked' => 1), array('tuid' => $id));
    }

    function look_all_post($id){
   		$this->db->update($this->table, array('flooked' => 1), array('fuid' => $id)); 	
    }

    function get_a_mail($id){
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    function save_a_mail($id){
        $this->db->update($this->table, array('saved' => 1), array('id' => $id));     
    }

    function check_auth($fid, $tuid, $fuid)
    {
        $result = array();
        $query = $this->db->get_where($this->table, array('fid' => $fid, 'tuid' => $tuid, 'fuid' => $fuid));
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
        }
        return $result;
    }
}