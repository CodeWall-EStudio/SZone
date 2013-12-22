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

}
// END Model class

/* End of file file_model.php */
/* Location: ./application/controllers/file_model.php */