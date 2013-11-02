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

	public function callback(){
		require_once('/application/libraries/qconnect/qqConnectAPI.php');
		$openid = $this->session->userdata('openid');
		$accessToken = $this->session->userdata('accessToken');

		if(!$openid && !$accessToken){
			$qc = new QC();		
			$accessToken = $qc->qq_callback();
			$openid = $qc->get_openid();
		}else{
			$qc = new QC($accessToken,$openid);	
		}
		//$qcnew = new QC($accessToken,$openid);	
		$ret = $qc->get_user_info();
		//var_dump($ret);

		//return;
		//$name = $ret['data']['name'];
		//$nick = $ret['data']['nick'];
		$name = $ret['nickname'];
		$nick = $name;

		$result = $this->db->query('SELECT * FROM user WHERE name="'.$name.'"');
		//已经在数据库中了.
        if ($result->num_rows() > 0){
        	echo $result->num_rows();
        	 $row = $result->row(); 
        	 $auth = (int) $row->auth;
        	 $size = (int) $row->size;
        	 $used = (int) $row->used;
        	 $userid = (int) $row->id;
        }else{
        	$auth = 0;
        	$data = array(
        		'name' => $name,
        		'nick' => $nick,
        		'auth' => 0,
        		'access' => $accessToken,
        		'openid' => $openid
        	);
        	$str = $this->db->insert_string('user',$data);
        	$this->db->query($str);
        	$userid = $this->db->insert_id();
        }		


		$array = array(
			'accessToken' => $accessToken,
			'openid' => $openid,
			'auth' => $auth,
			'name' => $name,
			'nick' => $nick,
			'userid' => $userid
		);	
		$this->session->set_userdata($array);
		redirect('/');
/*
　　获得access_token，在callback页面中使用$qc->qq_callback()返回access_token,
　　$qc->get_openid()返回openid，之后可以将access_token和openid保存（三个月有效期），
　　之后调用接口时不需要重新授权，但需要将access_token和Openid传入QC的参数中，如下：
　　$qc = new QC($access_token, $openid);
*/
	}

	public function getUser(){
	}	

	public function connect(){
		require_once('/application/libraries/qconnect/qqConnectAPI.php');

		$qc = new QC();
		$qc->qq_login();
	}

	//APP ID：100548719
	//APP KEY：9e47324ac7fed9f8364d4982ccf3037e
}