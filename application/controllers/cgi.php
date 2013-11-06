<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cgi extends SZone_Controller {

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


	public function addfold(){
		$name = $this->input->post('name');

		$sql = 'select id from `folds-user` where `user-id` = '.(int) $this->user['userid'].' and name ="'.$name.'"';
		$query = $this->db->query($sql);
		if($query->num_rows() == 0){

			$data = array(
				'name' => $name,
				'user-id' => $this->user['userid'],
				'createtime' => time(),
				'type' => 0
			);
			$str = $this->db->insert_string('folds-user',$data);
			$query = $this->db->query($str);
			if($this->db->insert_id()){
				$list = array(
					'ret' => 0,
					'msg' => '插入成功!'
				);
			}else{
				$list = array(
					'ret' => 2,
					'msg' => '插入失败!'
				);
			}
			//echo $str;
		}else{
			$list = array(
				'ret' => 1,
				'msg' => '已经有记录了!'
			);
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($list));		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */