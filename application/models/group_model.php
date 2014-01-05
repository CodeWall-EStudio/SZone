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
class Group_model extends CI_Model {

    protected $table   = 'groups';
    protected $user_table   = 'groupuser';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_groupnum_byname($name){
        $this->db->where('name',$name);
        $this->db->where('type',1);
        $query = $this->db->get($this->table);

        return $query->num_rows();
    }

    function get_user_group_ids($id)
    {
        $this->db->where('uid', $id);
        //$this->db->where('auth >', 0);
        $query = $this->db->get($this->user_table);
        $gidlist = array();

        foreach($query->result() as $row){
            array_push($gidlist,$row->gid);
        }
        return $gidlist;
    }

    function get_prep_group_ids($id){
        $sql = 'select gid from groupuser a,groups b where b.type=3 and a.uid='.$id.' and a.gid = b.id ';
        $query = $this->db->query($sql);
        $gidlist = array();

        foreach($query->result() as $row){
            array_push($gidlist,$row->gid);
        }
        return $gidlist;
    }

    function get_school_info(){
        $this->db->where('type',0);
        $query = $this->db->get($this->table);

        $row = $query->row();
        $result =  array(
            'id' => $row->id,
            'type' => $row->type,
            'pt' => $row->pt,
            'name' => $row->name,
            'content' => $row->content
        );     
        return $result;   
    }

    function get_user_group_auth($id){
        $this->db->where('uid', $id);
        $this->db->where('auth >', 0);
        $query = $this->db->get($this->user_table);
        $gidlist = array();

        foreach($query->result() as $row){
            array_push($gidlist,$row->gid);
        }
        return $gidlist;
    }

    function get_group_auth_byid($gid,$id){
        $this->db->where('uid', $id);
        $this->db->where('gid', $id);
        $this->db->where('auth >', 0);
        $query = $this->db->get($this->user_table);

        return $query->num_rows();
    }

    //更新群公告
    function set_group_desc($gid,$str){
        $data = array(
            'content' => $str
        );

        $this->db->update($table, $data, array('id' => $gid));
    }

    function get_group_info($ids,$authid)
    {
        $gidlist = $ids;
        $authlist = $authid;
        if(count($ids)>0){
            $this->db->where_in('id', $ids);
        }
        $query = $this->db->get($this->table);

        $result = array(
            'flist' => array(),
            'glist' => array(),
            'deplist' => array(),
            'depinfolist' => array(),
            'school' => array(),
            'prelist' => array()
        );
        foreach($query->result() as $row){
            if($row->type == 1){
                //if($row->parent == 0){
                    $result['flist'][$row->id] = array(
                        'id' => $row->id,
                        'name' => $row->name,
                        'parent' => $row->parent,
                        'content' => $row->content,
                        'auth' => in_array($row->id,$authlist),
                        'pt' => $row->pt,
                        'list' => array()
                    );
                // }else{
                //     $result['glist'][$row->id] = array(
                //         'id' => $row->id,
                //         'name' => $row->name,
                //         'parent' => $row->parent,
                //         'content' => $row->content,
                //         'auth' => in_array($row->id,$gidlist)
                //     );
                //     $result['flist'][$row->id] = array(
                //         'type' => 1,
                //         'id' => $row->id,
                //         'name' => $row->name,
                //         'parent' => $row->parent,
                //         'content' => $row->content,
                //         'auth' => in_array($row->id,$gidlist)
                //     );
                // }
            }elseif($row->type == 2){
                array_push($result['deplist'],array(
                    'id' => $row->id,
                    'pt' => $row->pt,
                    'name' => $row->name
                ));
                $result['depinfolist'][$row->id] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'parent' => $row->parent,
                    'pt' => $row->pt,
                    'content' => $row->content,
                    'auth' => in_array($row->id,$authlist)
                );
            }elseif($row->type == 3){
                $result['prelist'][$row->id] = $row->name;
            }elseif($row->type == 0){
                $result['school'] =  array(
                    'id' => $row->id,
                    'type' => $row->type,
                    'pt' => $row->pt,
                    'name' => $row->name,
                    'content' => $row->content
                );
            };
        };

        foreach($result['glist'] as $k => $r){
            array_push($result['flist'][$r['parent']]['list'],$r);

        }

        return $result;
    }
}
// END Model class

/* End of file group_model.php */
/* Location: ./application/controllers/group_model.php */