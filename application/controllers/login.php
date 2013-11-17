<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	public function index(){
		require_once('/application/libraries/qconnect/qqConnectAPI.php');

		$openid = $this->session->userdata('openid');
		$accessToken = $this->session->userdata('accessToken');
		$name = $this->session->userdata('name');

		if($openid && $accessToken){
			$qc = new QC($accessToken,$openid);		
		}
		echo $openid;
		echo $accessToken;
		echo $name;


	}

	public function layout(){
		$this->session->sess_destroy();
		redirect('/');
	}

	public function callback(){
		$this->load->library('qconnect');

		$this->qconnect->get_access();
		$openid = $this->qconnect->get_openid();
		$ret = $this->qconnect->get_info();
		//return;
		//$name = $ret['data']['name'];
		//$nick = $ret['data']['nick'];
		//$name = $ret['nickname'];
		$name = $ret->nickname;
		$nick = $name;

		$result = $this->db->query('SELECT * FROM user WHERE openid="'.$openid.'"');

		//已经在数据库中了.
        if ($result->num_rows() > 0){
        		
        	 $row = $result->row(); 
        	 $auth = (int) $row->auth;
        	 $size = (int) $row->size;
        	 $used = (int) $row->used;
        	 $uid = (int) $row->id;
        }else{
        	$auth = 0;
        	$data = array(
        		'name' => $name,
        		'nick' => $nick,
        		'auth' => 0,
        		'access' => $this->session->userdata('access_token'),
        		'openid' => $this->session->userdata('openid')
        	);
        	$str = $this->db->insert_string('user',$data);
        	echo $str;
        	$this->db->query($str);
        	$uid = $this->db->insert_id();
        }		


		$array = array(
			// 'accessToken' => $accessToken,
			// 'openid' => $openid,
			'auth' => $auth,
			'name' => $name,
			'nick' => $nick,
			'uid' => $uid
		);	

		//print_r($array);
		$this->session->set_userdata($array);
		redirect('/');
/*
　　获得access_token，在callback页面中使用$qc->qq_callback()返回access_token,
　　$qc->get_openid()返回openid，之后可以将access_token和openid保存（三个月有效期），
　　之后调用接口时不需要重新授权，但需要将access_token和Openid传入QC的参数中，如下：
　　$qc = new QC($access_token, $openid);
*/
	}

	public function loginout(){

		$array = array(
			'accessToken' => '',
			'openid' => '',
			'auth' => '',
			'name' => '',
			'nick' => '',
			'uid' => ''
		);	

		$this->session->unset_userdata($array);
		redirect('/');
	}

	public function getUser(){
	}	

	public function connect(){
		$this->load->library('qconnect');

		$this->qconnect->qq_login();

		return;
	}

	//APP ID：100548719
	//APP KEY：9e47324ac7fed9f8364d4982ccf3037e
}