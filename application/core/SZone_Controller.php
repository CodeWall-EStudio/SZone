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

    function __construct()
    {
        parent::__construct();
        $this->set_user();
        $this->set_group();
    }

    protected function set_user()
    {
        $this->user['uid'] = intval($this->session->userdata('uid'));

        if ($this->user['uid'] != 0)
        {
            $this->load->model('User_model');
            $this->user = $this->User_model->get_by_id($this->user['uid']);
        }
    }

    protected function set_group()
    {
        if ($this->user['uid'] != 0)
        {
            $this->load->model('Group_model');
            $gidlist = $this->Group_model->get_user_group_ids($this->user['uid']);
            $ret = $this->Group_model->get_group_info($gidlist);
            $this->grouplist = $ret['flist'];
            $this->deplist = $ret['deplist'];
            $this->depinfolist = $ret['depinfolist'];
            $this->prelist = $ret['prelist'];
            $this->school = $ret['school'];
        }
    }

    protected function set_group_bak(){

        if ($this->user['uid'] != 0)
        {
            $this->load->model('Group_model');
            $gidlist = $this->Group_model->get_user_group_ids($this->user['uid']);
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
                $this->school = array(
                    'id' => $row->id,
                    'type' => $row->type,
                    'name' => $row->name,
                    'content' => $row->content
                );//$row;
            };;
            //array_push($idlist,'gid="'.$row->id.'"');
        };

        foreach($glist as $k => $r){
            array_push($flist[$r['parent']]['list'],$r);

        }
        $this->grouplist = $flist;
    }

    /*
     * 输出JSON格式的数据结果
     */

    protected function json($data = array(), $code = 200, $msg = 'ok')
    {
        $result = array(
            'code' => $code,
            'msg' => $this->lang->line($msg),
            'data' => $data
        );
        if ($code != '200')
        {
            log_message('error', $result['msg']);
        }
        else
        {

        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

}
// END Controller class

/* End of file SZone_Controller.php */
/* Location: ./application/core/SZone_Controller.php */