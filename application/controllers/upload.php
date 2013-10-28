<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ftp');
		$upload_config = array(
		);
  		$this->load->library('upload', $config);		
		
	}

	public function index(){
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */