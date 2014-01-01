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
        if(!isset($_SESSION)){
            session_start();
        }        
        parent::__construct();
        $this->set_user();
        $this->set_group();
    }

    protected function set_user()
    {
        // CAS Check
        $this->load->library('phpCAS');
        phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, "dand.71xiaoxue.com", 80, "sso.web");
        phpCAS::setNoCasServerValidation();
        if (phpCAS::isAuthenticated()) {
            $this->user['name'] = phpCAS::getUser();

            // 检查用户是否已经登录
            $this->load->model('User_model');
            $user = $this->User_model->get_by_name($this->user['name']);

            if (empty($user)) {
                $user = array(
                    'name' => $this->user['name'],
                    'size' => $this->config->item('storage-limit')
                );
                $user['id'] = $this->User_model->insert_entry($user);
                $user['auth'] = 0;
                $user['used'] = 0;
                $user['lastgroup'] = 0;
            }

            $this->user = $user;
            $this->user['real_size'] = $this->user['size'];
            $this->user['real_used'] = $this->user['used'];
            $this->user['per'] = round($this->user['real_used']/$this->user['real_size']*100,2);
            $this->user['size'] = format_size($this->user['real_size']);
            $this->user['used'] = format_size($this->user['real_used']);

        } else {
            if ($this->uri->uri_string() === '') {
                phpCAS::forceAuthentication();
            } else {
                $this->user['id'] = '0';
            }
        }
    }

    protected function set_group()
    {
        $this->load->model('Group_model');
        $gidlist = $this->Group_model->get_user_group_ids($this->user['id']);
        $authlist = $this->Group_model->get_user_group_auth($this->user['id']);
        $ret = $this->Group_model->get_group_info($gidlist,$authlist);
        $this->grouplist = $ret['flist'];
        $this->deplist = $ret['deplist'];
        $this->depinfolist = $ret['depinfolist'];
        $this->prelist = $ret['prelist'];
        $this->school = $this->Group_model->get_school_info();//$ret['school'];
    }

    /*
     * 输出JSON格式的数据结果
     */

    protected function json($data = array(), $code = 200, $msg = 'ok')
    {
        $result = array(
            'code' => $code,
            'msg' => $this->lang->line($msg),
            'elapsed_time' => '{elapsed_time}',
            'memory_usage' => '{memory_usage}',
            'data' => $data,
            'profiler' => '{profiler}'
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
            ->set_output($result);
    }

}
// END Controller class

/* End of file SZone_Controller.php */
/* Location: ./application/core/SZone_Controller.php */