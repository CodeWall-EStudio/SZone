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
class User_model extends CI_Model {

    protected $table   = 'user';
    protected $gtable   = 'groupuser';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_in_group($id,$gid){
        $result = array();
        $query = $this->db->get_where($this->gtable,array('uid' => $id));
        if ($query->num_rows() > 0){
            foreach($query->result() as $row){
                array_push($result,$row->gid);
            }
        }
        if(in_array($gid,$result)){
            return true;
        }else{
            return false;
        }
    }

    function get_by_id($id)
    {
        $result = array('uid' => $id);
        $query = $this->db->get_where($this->table, array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $result['uid'] = $id;
            $result['real_size'] = $result['size'];
            $result['real_used'] = $result['used'];
            $result['per'] = round($result['real_used']/$result['real_size']*100,2);
            $result['size'] = format_size($result['real_size']);
            $result['used'] = format_size($result['real_used']);
        }
        return $result;
    }

    function get_by_openid($openid)
    {
        $result = array();
        $query = $this->db->get_where($this->table, array('openid' => $openid));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $user['uid'] = (int) $row->id;
            $user['auth'] = (int) $row->auth;

            $result[] = $user;
        }
        return $result;
    }

    function update_used($id, $used)
    {
        $this->db->update($this->table, array('used' => $used), array('id' => $id));
    }

    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry($data)
    {
        $str = $this->db->insert_string($this->table, $data);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}
// END Model class

/* End of file user_model.php */
/* Location: ./application/controllers/user_model.php */