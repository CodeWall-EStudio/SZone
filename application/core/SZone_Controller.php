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
    protected $encodeKey = '';
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

            // 处理登录，获取encodeKey和loginName
            $user_str = phpCAS::getUser();
            $user_data = json_decode($user_str);
            if (is_null($user_data)) {
                log_message('error', 'CAS 登录返回字符串解析错误：'.$user_str);
                if ($this->uri->uri_string() === '') {
                    show_error('登录服务器不可用，请联系系统管理员', 503);
                } else {
                    $this->json_error('登录服务器不可用，请联系系统管理员', 503);
                }
            }
            $this->user['name'] = $user_data->loginName;
            $this->encodeKey = $user_data->encodeKey;
            log_message('info', '用户'.$this->user['name'].'登录：'.$this->encodeKey);


            // 使用encodeKey获取用户信息
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://mapp.71xiaoxue.com/components/getUserInfo.htm');
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'encodeKey='.$this->encodeKey);
            $user_str = curl_exec($ch);
            curl_close($ch);

            $user_data = json_decode(strstr($user_str, '{'));
            if (is_null($user_data)) {
                log_message('error', '获取用户信息返回字符串解析错误：'.$user_str);
                if ($this->uri->uri_string() === '') {
                    show_error('用户数据服务器不可用，请联系系统管理员', 503);
                } else {
                    $this->json_error('用户数据服务器不可用，请联系系统管理员', 503);
                }
            }

            if ($user_data->resultMsg != 'ok' || !$user_data->success) {
                log_message('error', '用户信息无法正确验证：'.$user_str);
                if ($this->uri->uri_string() === '') {
                    show_error('无法验证用户信息，请联系系统管理员', 403);
                } else {
                    $this->json_error('无法验证用户信息，请联系系统管理员', 403);
                }
            }

            // 检查用户是否已经登录
            $this->load->model('User_model');
            $user = $this->User_model->get_by_name($this->user['name']);

            /*
             * TODO: 获取用户姓名
             */
            if (empty($user)) {
                $user = array(
                    'name' => $this->user['name'],
                    'nick' => $user_data->userInfo->name,
                    'size' => $this->config->item('storage-limit')
                );
                $user['id'] = $this->User_model->insert_entry($user);
                $user['auth'] = 0;
                $user['used'] = 0;
                $user['lastgroup'] = 0;
            } else {
                $user['nick'] = $user_data->userInfo->name;
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
                return;
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

    /*
     * 返回JSON类型的错误结果
     */

    protected function json_error($msg = 'ok', $code = 500)
    {
        $result = array(
            'code' => $code,
            'msg' => $msg
        );
        echo json_encode($result);
        exit;
    }

}
// END Controller class

/* End of file SZone_Controller.php */
/* Location: ./application/core/SZone_Controller.php */