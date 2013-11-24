<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SZone Application Controller Class
 *
 * This class object extends from the CodeIgniter super class CI_Controller.
 *
 * @package		SZone
 * @subpackage	application
 * @category	core
 * @author		Code Wall-E Studio
 * @link		http://codewalle.com
 */
class SZone_Controller extends CI_Controller {

    protected $user = array();
    protected $grouplist = array();
    protected $deplist = array();
    protected $depinfolist = array();
    protected $prelist = array();

    public function __construct()
    {
        parent::__construct();
        $this->set_user();
        $this->set_group();
    }

    protected function set_user()
    {

        $this->user['uid'] = (int) $this->session->userdata('uid');

        if ($this->user['uid'] != 0)
        {
            $this->load->model('User_model');
            $this->user = $this->User_model->get_by_id($this->user['uid']);
        }
    }

    protected function set_group(){
        $sql = 'select gid from groupuser where uid='.(int) $this->user['uid'].' and auth>0';
        $query = $this->db->query($sql);
        $gidlist = array();

        foreach($query->result() as $row){
            array_push($gidlist,$row->gid);
        }
        $sql = 'select * from groups where status=0';
        $query = $this->db->query($sql);

        //gid列表
        $flist = array();
        $glist = array();
        $idlist = array();
        foreach($query->result() as $row){
            if($row->type == 1){
                if($row->parent == 0){
                    $flist[$row->id] = array(
                        'id' => $row->id,
                        'name' => $row->name,
                        'parent' => $row->parent,
                        'content' => $row->content,
                        'auth' => in_array($row->id,$gidlist),
                        'list' => array()
                    );
                }else{
                    $glist[$row->id] = array(
                        'id' => $row->id,
                        'name' => $row->name,
                        'parent' => $row->parent,
                        'content' => $row->content,
                        'auth' => in_array($row->id,$gidlist)
                    );
                    $flist[$row->id] = array(
                        'type' => 1,
                        'id' => $row->id,
                        'name' => $row->name,
                        'parent' => $row->parent,
                        'content' => $row->content,
                        'auth' => in_array($row->id,$gidlist)
                    );
                    // array_push($glist,array(
                    // 	'id' => $row->id,
                    // 	'name' => $row->name,
                    // 	'parent' => $row->parent,
                    // 	'auth' => in_array($row->id,$gidlist)
                    // ));
                }
            }elseif($row->type == 2){
                array_push($this->deplist,array(
                    'id' => $row->id,
                    'name' => $row->name
                ));
                $this->depinfolist[$row->id] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'parent' => $row->parent,
                    'content' => $row->content,
                    'auth' => in_array($row->id,$gidlist)
                );
            }elseif($row->type == 3){
                $this->prelist[$row->id] = $row->name;
                // array_push($this->prelist,array(
                // 	'id' => $row->id,
                // 	'name' => $row->name
                // ));
            }elseif($row->type == 0){
                $this->school = $row;
            };;
            //array_push($idlist,'gid="'.$row->id.'"');
        };

        foreach($glist as $k => $r){
            array_push($flist[$r['parent']]['list'],$r);

        }
        $this->grouplist = $flist;
    }

}
// END Controller class

/* End of file SZone_Controller.php */
/* Location: ./application/core/SZone_Controller.php */
