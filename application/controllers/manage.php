<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends SZone_Controller {

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

	protected $data;
	public function __construct(){
	    parent::__construct();

		if($user['auth'] = 0){
			redirect('/');
		}

		$this->data = array(
			'userinfo' => $this->user
		);	
	}

	//默认用户
	public function index(){
		//var_dump($this->user);
		$this->data['index'] = 'index';
		$this->data['data'] = array();

		$this->load->view('manage',$this->data);
	}

	//小组设置
	public function group(){
		$this->data['index'] = 'group';
		//$this->data['data'] = array();

		$sql = 'SELECT a.id,a.name,b.name AS uname,b.id AS uid FROM groups AS a,user AS b WHERE a.create = b.id AND type=1';
		$query = $this->db->query($sql);
		$group = array();
		foreach ($query->result() as $row){
			$group[$row->id] = array(
				'id' => $row->id,
				'name' => $row->name,
				'uname' => $row->uname,
				'uid' => $row->uid
			);
		}
		$this->data['data'] = $group;
		$this->load->view('manage',$this->data);
	}

	//小组设置
	public function dep(){
		$this->data['index'] = 'dep';
		$this->data['data'] = array();

		$this->load->view('manage',$this->data);
	}	

	//设置空间
	public function space(){
		$this->data['index'] = 'space';
		$this->data['data'] = array();

		$this->load->view('manage',$this->data);
	}


	public function addgroup(){
		$this->load->library('form_validation');
		$this->load->helper('form');		

		$auth = $this->data['userinfo']['auth'];

		$act = $this->input->get('act');
		if($act == ''){
			$act = 'group';
		}
		$this->data['data'] = array(
			'act' => $act
		);

		if($act == 'group'){
			$type = 1;
		}else{
			$type = 2;
		}

		$grouplist = array(
			0 => '一级分组'
		);
		//取组名
		$sql = 'SELECT * FROM groups WHERE type = '.$type.' and parent =0';
		$query = $this->db->query($sql);
		foreach ($query->result() as $row){
			$grouplist[$row->id] = $row->name;
		}

		$this->form_validation->set_rules('groupname', 'groupname', 'required|min_length[2]|max_length[40]|callback_checkgroupname');

		$this->data['index'] = 'addgroup';
		$this->data['data']['group'] = $grouplist;
		
		//表单验证失败
		if ($this->form_validation->run() == FALSE){
			$this->data['data']['ret'] = 0;
		}else{
			$this->data['data']['ret'] = 1;

			$manage = $this->input->post('manage');

			$manage = preg_replace('/;$/e','',$manage);
			$ul = explode(';',$manage);
			foreach($ul as $key => $item){
				$ul[$key] = ' name="'.$item.'" ';
			}
			$where = implode('or',$ul);

			$sql = 'SELECT id FROM `user` where '.$where;
			$query = $this->db->query($sql);

			$idlist = array();
			$idqlist = array();
			foreach ($query->result() as $row){
				array_push($idlist,(int) $row->id);
				array_push($idqlist,'userid='.(int) $row->id);
			}


			//echo $sql;

			// $query = $this->db->query($sql);
			// foreach ($query->result() as $row){
			// 	echo $row->id;
			// }

			//return;

			$data = array(
				'name' => $this->input->post('groupname'),
				'parent' => $this->input->post('parent'),
				'type' => $type,
				'create' => $this->user['userid']
			);

			$str = $this->db->insert_string('groups', $data); 
			$query = $this->db->query($str);
			//取分组id
			$id = $this->db->insert_id();
			//echo $id;

			$where = implode(' or ',$idqlist);
			$sql = 'SELECT id,userid FROM `group-user` where groupid='.$id.' and ('.$where.')';

			$query = $this->db->query($sql);
			$guid = array();
			$insertid = array();
			foreach ($query->result() as $row){
				if(in_array((int) $row->userid,$idlist)){
					array_push($guid,(int) $row->userid);
					array_push($insertid,(int) $row->id);

					$data = array('auth' => 1);
					$where = 'id='.(int) $row->id;
					$str = $this->db->update_string('group-user',$data,$where);

					$query = $this->db->query($str);
				};
			}

			$idlist = array_diff_assoc($idlist, $guid);
			foreach($idlist as $item){
				$data = array('groupid' => $id,'userid'=>$item,'auth' => 1);
				$str = $this->db->insert_string('group-user',$data);
				$query = $this->db->query($str);				
			}

			$num = $this->db->affected_rows();
			if(!$num){
				$this->data['data']['ret'] = 0;
			}
		}

		$this->load->view('manage',$this->data);
	}

	public function checkgroupname($str){
		$sql = 'SELECT id FROM groups where name="'.$str.'"';
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			$this->form_validation->set_message('checkgroupname', '小组名: '.$str.' 已经存在了.请换个名字');
			return FALSE;			
		}else{
			return true;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */