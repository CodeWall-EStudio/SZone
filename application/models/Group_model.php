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
class Group_model extends CI_Model {

    var $table   = 'groups';
    var $user_table   = 'groupuser';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_user_group_ids($id)
    {
        $this->db->where('uid', $id);
        $this->db->where('auth >', 0);
        $query = $this->db->get($this->user_table);
        $gidlist = array();

        foreach($query->result() as $row){
            array_push($gidlist,$row->gid);
        }
        return $gidlist;
    }

    function get_group($ids)
    {

    }
}
// END Controller class

/* End of file Model.php */
/* Location: ./application/controllers/Group_model.php */