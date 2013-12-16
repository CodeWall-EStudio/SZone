<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myspace extends SZone_Controller {

	public function index(){
		$data = array(
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist,
				'school' => $this->school
			)
		);			
		$this->load->view('home/index.php',$data);		
	} 
}