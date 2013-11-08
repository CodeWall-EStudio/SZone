<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends SZone_Controller {

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
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist
			)
		);


		$sql = 'select id,name,createtime from userfolds where uid = '.(int) $this->user['userid'];
		$query = $this->db->query($sql);

		$fold = array();
		foreach($query->result() as $row){
			array_push($fold,array(
				'id' => $row->id,
				'name' => $row->name,
				'time' => $row->createtime
			));
		}

		$data['fold'] = $fold;

		$this->load->view('home',$data);	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */