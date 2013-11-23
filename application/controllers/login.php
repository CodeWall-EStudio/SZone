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
class Login extends CI_Controller {

    /*public function index(){
		require_once(APPPATH.'libraries/qconnect/qqConnectAPI.php');

		$openid = $this->session->userdata('openid');
		$accessToken = $this->session->userdata('accessToken');
		$name = $this->session->userdata('name');

		if($openid && $accessToken){
			new QC($accessToken,$openid);
		}
		echo $openid;
		echo $accessToken;
		echo $name;

	}

*/

    public function connect(){
        $this->load->library('qconnect');
        $this->qconnect->qq_login();
        return;
    }

	public function callback(){
		$this->load->library('qconnect');

		$this->qconnect->get_access();
		$openid = $this->qconnect->get_openid();
		$ret = $this->qconnect->get_info();

        $name = $ret->nickname;
		$nick = $name;

        $this->load->model('User_model');
        $result = $this->User_model->get_by_openid($openid);

        $data = array();

        if (count($result) == 0)
        {
        	$user = array(
        		'name' => $name,
        		'nick' => $nick,
        		'auth' => 0,
        		'size' => $this->config->item('storage-limit'),
        		'access' => $this->session->userdata('access_token'),
        		'openid' => $this->session->userdata('openid')
        	);
            $data['uid'] = $this->User_model->insert_entry($user);
            $data['auth'] = $user['auth'];
            $data['name'] = $name;
            $data['nick'] = $nick;
        }
        else
        {
            $data = $result[0];
            $data['name'] = $name;
            $data['nick'] = $nick;
        }

		$this->session->set_userdata($data);
		redirect('/');
/*
　　获得access_token，在callback页面中使用$qc->qq_callback()返回access_token,
　　$qc->get_openid()返回openid，之后可以将access_token和openid保存（三个月有效期），
　　之后调用接口时不需要重新授权，但需要将access_token和Openid传入QC的参数中，如下：
　　$qc = new QC($access_token, $openid);
*/
	}

    public function quit(){
        $this->session->sess_destroy();
        redirect('/');
    }

	//APP ID：100548719
	//APP KEY：9e47324ac7fed9f8364d4982ccf3037e
}

// END Controller class

/* End of file login.php */
/* Location: ./application/controllers/login.php */