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
    protected $gptable = 'groups';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function check_auth_in_group($id,$gid){
        $this->db->select('id');
        $this->db->where('uid',$id);
        $this->db->where('auth >',0);

        $query = $this->db->get($this->gtable);
        if($query->num_rows() > 0){
            return true;
        }else{
            $this->db->select('id');
            $this->db->where('id',$gid);
            $this->db->where('create',$id);

            $query = $this->db->get($this->gptable);
            if($query->num_rows() > 0){
                return true;
            }
            return false;
        }
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
            $query = $this->db->get_where($this->gptable,array('create' => $id,'id'=>$gid));
            if($query->num_rows()>0){
                return true;
            }
            return false;
        }
    }

    function get_by_id($id)
    {
        $result = array();
        $query = $this->db->get_where($this->table, array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $result['real_size'] = $result['size'];
            $result['real_used'] = $result['used'];
            $result['per'] = round($result['real_used']/$result['real_size']*100,2);
            $result['size'] = format_size($result['real_size']);
            $result['used'] = format_size($result['real_used']);
        }
        return $result;
    }

    function get_by_name($name)
    {
        $result = array();
        $query = $this->db->get_where($this->table, array('name' => $name));
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
        }
        return $result;
    }

    function update_used($id, $used)
    {
        $this->db->update($this->table, array('used' => $used), array('id' => $id));
    }

    function get_other($id)
    {
        $this->db->select('id, name, nick');
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table);

        $rl = array();
        foreach($query->result() as $row){
            $rl[$row->id] = array(
                'id' => $row->id,
                'name' => $row->name,
                'nick' => $row->nick
            );
        }
        return $rl;
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

    function get_prep_user($gr = 0, $tag = 0){
        $this->db->select('groups.id, groups.name, user.nick, user.id as uid');
        $this->db->from($this->gptable);
        $this->db->join($this->gtable,'groupuser.gid=groups.id');
        $this->db->join($this->table,'user.id=groupuser.uid');
        $this->db->where('groups.type',3);
        if($gr){
            $this->db->where('groups.grade',$gr);
        }
        if($tag){
            $this->db->where('groups.tag',$tag);
        }
        $query = $this->db->get(); 

        $rl = array();
        foreach($query->result() as $row){
            array_push($rl,array(
                'gid' => $row->id,
                'name' => $row->name,
                'nick' => $row->nick,
                'uid' => $row->uid,
                'fdid' => 0
            ));
        }       

        return $rl;
    }

}
// END Model class

/* End of file user_model.php */
/* Location: ./application/controllers/user_model.php */