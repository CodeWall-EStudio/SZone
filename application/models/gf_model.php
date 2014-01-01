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
class Gf_model extends CI_Model {

    protected $table = 'groupfile';
    protected $gtable = 'groupfolds';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }	

    function get_filenum_byfid($fid,$gid){
    	$this->db->where('gid',$gid);
    	$this->db->where_in('fid',$fid);
    	$query = $this->db->get($this->table);

    	$ids = array();
    	foreach($query->result() as $row){
    		array_push($ids,$row->fid);
    	}
    	return $ids;
    }

    function get_by_gid_ids($gid, $ids)
    {
        $this->db->select('id, fid, fname');
        $this->db->where('gid',$gid);
        $this->db->where_in('id',$ids);
        $query = $this->db->get($this->table);

        $result = array();
        foreach($query->result() as $row){
            array_push($result,array(
                'id' => $row->id,
                'fid' => $row->fid,
                'name' => $row->fname
            ));
        }
        return $result;
    }

    function get_by_ids($ids)
    {
        $this->db->select('id, fid, fname');
        $this->db->where_in('id',$ids);
        $query = $this->db->get($this->table);

        $result = array();
        foreach($query->result() as $row){
            array_push($result,array(
                'id' => $row->id,
                'fid' => $row->fid,
                'name' => $row->fname
            ));
        }
        return $result;
    }

}