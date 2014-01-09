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
class File_model extends CI_Model {

    protected $table   = 'files';
    protected $utable = 'userfile';
    protected $gtable = 'groupfile';
    protected $mtable = 'message';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_by_md5($md5)
    {
        $result = array();
        $query = $this->db->get_where($this->table, array('md5' => $md5));
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $result['size'] = intval($result['size']);
        }
        return $result;
    }

    function get_by_id($id)
    {
        $result = array();
        $query = $this->db->get_where($this->table, array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $result['size'] = intval($result['size']);
        }
        return $result;
    }

    function get_by_ids($ids)
    {
        $result = array();
        $this->db->where_in('id', $ids);
        $this->db->order_by('id', "desc");
        $query = $this->db->get($this->table);
        if ($query->num_rows() == count($ids))
        {
            $result = $query->result_array();
        }
        return $result;
    }

    function check_filename_by_uid($fdid,$uid,$fn){
        $this->db->select('id');
        $this->db->where('uid',$uid);
        $this->db->where('fdid',$fdid);
        $this->db->where('name',$fn);
        $query = $this->db->get($this->utable);

        return $query->num_rows();
    }

    function check_filename_by_gid($fdid,$gid,$fn){
        $this->db->select('id');
        $this->db->where('gid',$gid);
        $this->db->where('fdid',$fdid);
        $this->db->where('name',$fn);
        $query = $this->db->get($this->gtable);

        return $query->num_rows();
    }  

    function check_fileid_by_uid($fid,$uid) {
        $this->db->select('id');
        $this->db->where('uid',$uid);
        $this->db->where('fid',$fid);

        $query = $this->db->get($this->utable);

        if($query->num_rows() == 0){
            $this->db->select('id');
            $this->db->where('tuid',$uid);
            $this->db->where('fid',$fid);

            $query = $this->db->get($this->mtable);

            if($query->num_rows() == 0){
                return false;
            }else{
                return true;
            }

        }else{
            return true;
        }
    }

    function get_by_uid($fid, $uid)
    {
        $result = array();
        $query = $this->db->get_where($this->utable, array('fid' => $fid, 'uid' => $uid));
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
        }
        return $result;
    }

    function get_by_uid_ids($ids, $uid)
    {
        $result = array();
        $this->db->where('uid', $uid);
        $this->db->where_in('fid', $ids);
        $this->db->order_by("fid", "desc");
        $query = $this->db->get($this->utable);
        if ($query->num_rows() == count($ids))
        {
            $result = $query->result_array();
        }
        return $result;
    }

    function get_by_gid($fid, $gid)
    {
        $result = array();
        $query = $this->db->get_where($this->gtable, array('fid' => $fid, 'gid' => $gid));
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
        }
        return $result;
    }

    function get_by_gid_ids($ids, $gid)
    {
        $result = array();
        $this->db->where('gid', $gid);
        $this->db->where_in('fid', $ids);
        $this->db->order_by("fid", "desc");
        $query = $this->db->get($this->gtable);
        if ($query->num_rows() == count($ids))
        {
            $result = $query->result_array();
        }
        return $result;
    }

    function insert_entry($data)
    {
        $str = $this->db->insert_string($this->table, $data);
        $query = $this->db->query($str);
        return $this->db->insert_id();
    }

    function insert_user_entry($data)
    {
        $str = $this->db->insert_string($this->utable, $data);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    function insert_group_entry($data)
    {
        $str = $this->db->insert_string($this->gtable, $data);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    function update_ref($id, $ref)
    {
        $this->db->update($this->table, array('ref' => $ref), array('id' => $id));
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

    function check_groupfile_byid($ids,$gid,$uid){
        $this->db->select('fid');
        $this->db->where_in('fid',$ids);
        $this->db->where('uid',$uid);
        $this->db->where('gid',$gid);

        $query = $this->db->get($this->gtable);

        $rl = array();
        foreach($query->result() as $row){
            array_push($rl,$row->fid);
        }
        return array_diff($ids,$rl);
    }

}
// END Model class

/* End of file file_model.php */
/* Location: ./application/controllers/file_model.php */