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

    var $table   = 'user';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_storage_by_id($id)
    {
        $result = array('size'=>0,'used'=>0,'per'=>0);
        $this->db->select('size, used');
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $result['size'] = (float) $row->size;
            $result['used'] = (float) $row->used;
            $result['per'] = round($result['used']/$result['size']*100,2);
            $result['size'] = format_size($result['size']);
            $result['used'] = format_size($result['used']);
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

    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry($data)
    {
        $this->db->insert_string($this->table, $data);
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