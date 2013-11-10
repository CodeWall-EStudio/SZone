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
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist
			)
		);
	}

	//默认用户
	public function index(){
		//var_dump($this->user);
		$this->data['index'] = 'index';
		$this->data['data'] = array();

		$sql = 'select * from user';

		$query = $this->db->query($sql);
		$ulist = array();
		foreach($query->result() as $row){
			array_push($ulist,array(
				'id' => $row->id,
				'name' => $row->name,
				'nick' => $row->nick,
				'auth' => $row->auth,
				'size' => $row->size,
				'used' => $row->used,
			));
		}
		$this->data['data']['ulist'] = $ulist;

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

		$sql = 'SELECT a.id,a.name,b.name AS uname,b.id AS uid FROM groups AS a,user AS b WHERE a.create = b.id AND type=2';
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

	//设置空间
	public function space(){
		$this->data['index'] = 'space';
		$this->data['data'] = array();

		$this->load->view('manage',$this->data);
	}


	public function addgroup(){
		$this->load->library('form_validation');
		$this->load->helper('form');		

		$auth = $this->user['auth'];

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
				array_push($idqlist,'uid='.(int) $row->id);
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
			$sql = 'SELECT id,uid FROM groupuser where gid='.$id.' and ('.$where.')';

			$query = $this->db->query($sql);
			$guid = array();
			$insertid = array();
			foreach ($query->result() as $row){
				if(in_array((int) $row->uid,$idlist)){
					array_push($guid,(int) $row->uid);
					array_push($insertid,(int) $row->id);

					$data = array('auth' => 1);
					$where = 'id='.(int) $row->id;
					$str = $this->db->update_string('groupuser',$data,$where);

					$query = $this->db->query($str);
				};
			}

			$idlist = array_diff_assoc($idlist, $guid);
			foreach($idlist as $item){
				$data = array('gid' => $id,'uid'=>$item,'auth' => 1);
				$str = $this->db->insert_string('groupuser',$data);
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

	public function editgroup(){
		$this->load->library('form_validation');
		$this->load->helper('form');	
		
		//$this->data['index'] = 'editgroup';	
		$id = $this->input->get('id');
		if($this->user['auth'] & 0x8){

			$grouplist = array(
				0 => '一级分组'
			);

			$sql = 'SELECT * FROM groups WHERE type = 1 and parent =0';
			$query = $this->db->query($sql);
			foreach ($query->result() as $row){
				$grouplist[$row->id] = $row->name;
			}
			$this->data['group'] = $grouplist;

			$this->form_validation->set_rules('groupname', 'groupname', 'required|min_length[2]|max_length[40]');

			if ($this->form_validation->run() == FALSE && $this->input->post('groupname')){

					$sql = 'SELECT g.*,u.name as uname,u.id as uid FROM groups g,`user` u,groupuser gu WHERE  gu.uid = u.id AND gu.auth = 1 AND gu.gid = g.id AND g.id = '.$id;

					$query = $this->db->query($sql);
					$ulist = array();

					foreach ($query->result() as $row){
						$gid= $row->id;
						$gname = $row->name;
						$gparent = $row->parent;
						$type = $row->type;
						array_push($ulist,$row->uname);
					};

					$this->data['manage'] = implode(';',$ulist);
					$this->data['gname'] = $gname;
					$this->data['gid'] = $gid;
					$this->data['parent'] = $gparent;
					$this->data['type'] = $type;

					$this->data['data']['ret'] = 0;

					$this->load->view('manage/editgroup',$this->data);

			}else{
				if(!$this->input->post('groupname')){
					$sql = 'SELECT g.*,u.name as uname,u.id as uid FROM groups g,`user` u,groupuser gu WHERE  gu.uid = u.id AND gu.auth = 1 AND gu.gid = g.id AND g.id = '.$id;

					$query = $this->db->query($sql);
					$ulist = array();

					foreach ($query->result() as $row){
						$gid= $row->id;
						$gname = $row->name;
						$gparent = $row->parent;
						$type = $row->type;
						array_push($ulist,$row->uname);
					};

					$this->data['manage'] = implode(';',$ulist);
					$this->data['gname'] = $gname;
					$this->data['gid'] = $gid;
					$this->data['parent'] = $gparent;
					$this->data['type'] = $type;

					$this->data['data']['ret'] = 0;

					$this->load->view('manage/editgroup',$this->data);
				}else{

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
					$wlist = array();
					foreach ($query->result() as $row){
						array_push($idlist,(int) $row->id);
						array_push($wlist,'gu.uid='.(int) $row->id);
					}				

					$where = implode(' or ',$wlist);
					$sql = 'SELECT gu.id,gu.uid FROM groupuser gu where gid='.$id.' and ('.$where.')';

					$query = $this->db->query($sql);
					$guid = array();
					$insertid = array();
					foreach ($query->result() as $row){
						if(in_array((int) $row->uid,$idlist)){
							array_push($guid,(int) $row->uid);
							array_push($insertid,(int) $row->id);

							// $data = array('auth' => 1);
							// $where = 'id='.(int) $row->id;
							// $str = $this->db->update_string('groupuser',$data,$where);

						$sql = 'UPDATE groupuser gu,`user` u SET gu.auth = 1,u.auth = 1 WHERE gu.uid = u.id AND u.id = '.(int) $row->uid.' AND gu.gid = '.$id;
						
							$query = $this->db->query($sql);
						};
					}

					$idlist = array_diff_assoc($idlist, $guid);
					foreach($idlist as $item){
						$data = array('gid' => $id,'uid'=>$item,'auth' => 1);


						$str = $this->db->insert_string('groupuser',$data);
						//$query = $this->db->query($sql);				
					}

					//UPDATE `groups` g,groupuser gu SET g.name = '食堂5', g.parent = '0' , gu.auth = 1 WHERE gu.gid = g.id AND g.id = 10 AND (gu.uid = 3 OR gu.uid = 4);
					$data = array(
						'name' => $this->input->post('groupname'),
						'parent' => $this->input->post('parent')
					);
					$where = 'id = '.$id;					
					$str = $this->db->update_string('groups', $data, $where); 
					$query = $this->db->query($str);
					$num = $this->db->affected_rows();
					if(!$num){
						$this->data['ret'] = 1;
					}
					$this->data['ret'] =0;
					$this->data['msg'] = '修改成功!';
					$this->load->view('manage/retmsg',$this->data);						
				}
				
			}		
		}else{
			$this->data['ret'] =1;
			$this->data['msg'] = '对不起,出错了!';			
			$this->load->view('manage/retmsg',$this->data);
		}
		//
		
	}

	public function delgroup(){
		$id = $this->input->get('id');
		$this->data['index'] = 'ret';
		if($this->user['auth'] & 0x8){
			$sql = 'DELETE g,gu FROM `groups` g,groupuser gu WHERE gu.gid = g.id AND g.id ='.$id;

			$query = $this->db->query($sql);
			if($this->db->affected_rows()>0){
				$this->data['data'] = array(
					'ret' => 0,
					'msg' => '删除记录成功!'
				);	
			}else{
				$this->data['data'] = array(
					'ret' => 2,
					'msg' => '删除记录失败!'
				);				
			}
		}else{
			$this->data['data'] = array(
				'ret' => 1,
				'msg' => '权限不够!'
			);
		}

		$this->load->view('manage',$this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */