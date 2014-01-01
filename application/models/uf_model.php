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
class Uf_model extends CI_Model {

    protected $table = 'userfile';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }	

    function get_filenum_byid($id,$uid){
    	$this->db->where_in('id',$id);
    	$this->db->where('uid',$uid);
    	$query = $this->db->get($this->table);
    	if($query->num_rows()){
            return $query->row();
        }else{
            return false;
        };
    }

    function get_file_byid($id,$uid){
        $this->db->where_in('id',$id);
        $this->db->where('uid',$uid);
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0){
            $list = array();
            foreach($query->result_array() as $row){
                $list[$row['id']] = $row;
            };
            return $list;
        }else{
            return false;
        };
    }

    function get_by_uid_ids($uid, $ids)
    {
        $this->db->select('id, fid, name');
        $this->db->where('uid',$uid);
        $this->db->where_in('id',$ids);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    function get_by_ids($ids)
    {
        $this->db->select('id, fid, name');
        $this->db->where_in('id',$ids);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

}