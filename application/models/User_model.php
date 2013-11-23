<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SZone Application Controller Class
 *
 * This class object extends from the CodeIgniter super class CI_Controller.
 *
 * @package		SZone
 * @subpackage	application
 * @category	controllers
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

    function get_size($id)
    {
        $result = array('size'=>0,'used'=>0,'per'=>0);
        $this->db->select('size, used');
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        if ($query->num_rows() == 1){
            $row = $query->row();
            $result['size'] = (float) $row->size;
            $result['used'] = (float) $row->used;
            $result['per'] = round($result['used']/$result['size']*100,2);
            $result['size'] = format_size($result['size']);
            $result['used'] = format_size($result['used']);
        }
        return $result;
    }

    function get_last_ten_entries()
    {
        $query = $this->db->get('entries', 10);
        return $query->result();
    }

    function insert_entry()
    {
        $this->title   = $_POST['title']; // 请阅读下方的备注
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}
// END Controller class

/* End of file Model.php */
/* Location: ./application/controllers/User_model.php */