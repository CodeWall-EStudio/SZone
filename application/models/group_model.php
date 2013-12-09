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

    function get_group_info($ids)
    {
        $gidlist = $ids;
        //$this->db->where_in('id', $ids);
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
                if($row->parent == 0){
                    $result['flist'][$row->id] = array(
                        'id' => $row->id,
                        'name' => $row->name,
                        'parent' => $row->parent,
                        'content' => $row->content,
                        'auth' => in_array($row->id,$gidlist),
                        'list' => array()
                    );
                }else{
                    $result['glist'][$row->id] = array(
                        'id' => $row->id,
                        'name' => $row->name,
                        'parent' => $row->parent,
                        'content' => $row->content,
                        'auth' => in_array($row->id,$gidlist)
                    );
                    $result['flist'][$row->id] = array(
                        'type' => 1,
                        'id' => $row->id,
                        'name' => $row->name,
                        'parent' => $row->parent,
                        'content' => $row->content,
                        'auth' => in_array($row->id,$gidlist)
                    );
                }
            }elseif($row->type == 2){
                array_push($result['deplist'],array(
                    'id' => $row->id,
                    'name' => $row->name
                ));
                $result['depinfolist'][$row->id] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'parent' => $row->parent,
                    'content' => $row->content,
                    'auth' => in_array($row->id,$gidlist)
                );
            }elseif($row->type == 3){
                $result['prelist'][$row->id] = $row->name;
            }elseif($row->type == 0){
                $result['school'] =  array(
                    'id' => $row->id,
                    'type' => $row->type,
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