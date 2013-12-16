<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query extends SZone_Controller {
 
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function index(){
		//var_dump($this->user);
		$data = array(
			'userinfo' => $this->user
		);
	}

	public function smartuser(){
		$key = trim($this->input->get('key'));

		//log_message('debug', 'smart user '.$key);
		 log_message('debug', 'Some variable was correctly set');

		$sql = 'SELECT id,name FROM user where name like "'.$key.'%" limit 0,10';
		$query = $this->db->query($sql);

		$list = array(
			'ret' => 0,
			'list' => array()
		);
		foreach ($query->result() as $row){
			array_push($list['list'],array(
				'id' => $row->id,
				'name' => $row->name
			));
			//$grouplist[$row->id] = $row->name;
		}

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($list));		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */