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
		$pid = (int) $this->input->post('pid');

		$sql = 'select id from userfolds where uid = '.(int) $this->user['userid'].' and name ="'.$name.'"';
		$query = $this->db->query($sql);
		if($query->num_rows() == 0){

			$data = array(
				'pid' => $pid,
				'name' => $name,
				'uid' => $this->user['userid'],
				'mark' => '',
				'createtime' => time(),
				'type' => 0
			);
			$str = $this->db->insert_string('userfolds',$data);
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

	public function upload(){
		$this->config->load('filetype');
		$ft = $this->config->item('filetype');

		$allowed = array();
		foreach($ft as $k => $item){
			array_push($allowed,$k);
		}
		//echo implode('|',$allowed);
		$dirname = FILE_UPLOAD_PATH.$this->user['name'];
		if (!file_exists($dirname)){
			mkdir($dirname,0700);
		}
		
		$nowdir = $this->getDir();

		$config['upload_path'] = $nowdir;
		$config['allowed_types'] = implode('|',$allowed);//;'gif|jpg|png';
		$this->load->library('upload', $config);
		$fdid = (int) $this->input->get('fid');


		$field_name = "file";
		if ( ! $this->upload->do_upload($field_name)){
			$list = array(
				'jsonrpc' => '2.0',
				'error' => array(
					'code' => 100,
					'message' => '上传失败'
				),
				'id' => $id
			);
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($list));			
		}else{
			$filetype = $_FILES['file']['type'];
			$md5 =  md5_file($_FILES['file']['tmp_name']);
			$filedata = $this->upload->data();

			//判断是否存在相同的文件
			$sql = 'select id from files where md5="'.$md5.'"';
			$query = $this->db->query($sql);

			if ($query->num_rows() > 0){
				$row = $query->row();
				$fid = $row->id;
			}else{
				$data = array(
					'path' => $filedata['full_path'],
					'size' => $filedata['file_size'],
					'md5' => $md5,
					'type' => $filedata['is_image'],
					'del' => 0
				);
				echo $filedata['file_type'].'&&'.$filedata['image_type'];
				return;
				$sql = $this->db->insert_string('files',$data);
				//把文件写入数据库
				$query = $this->db->query($sql);

				$fid = $this->db->insert_id();
			}

			$sql = 'select id from userfile where fid='.$fid.' and uid='.(int) $this->user['userid'];
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$row = $query->row();
				$list = array(
					'jsonrpc' => '2.0',
					'error' => array(
						'code' => 101,
						'message' => '上传失败,已经有重名文件'
					),
					'id' => $row->id
				);
				$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($list));				
				return false;
			}

			$data = array(
				'fid' => (int) $fid,
				'name' => $filedata['raw_name'],
				'uid' => (int) $this->user['userid'],
				'del' => 0,
				'fdid' => $fdid
			);
			$sql = $this->db->insert_string('userfile',$data);
			$query = $this->db->query($sql);
			if($this->db->affected_rows() > 0){
				$list = array(
					'jsonrpc' => '2.0',
					'error' => array(
						'code' => 0,
						'message' => '上传成功!'
					)
				);
			}else{
				$list = array(
					'jsonrpc' => '2.0',
					'error' => array(
						'code' => 102,
						'message' => '上传失败!'
					)
				);
			}
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($list));							
			//print_r($data);
			//echo 'ok';
		}

		//@set_time_limit(5 * 60);
	}

	//修改备注
	public function editmark(){
		$t = $this->input->post('t');
		$fid = $this->input->post('id');
		$info = $this->input->post('info');

		if($t == 'fold'){
			$tname = 'userfolds';
			$fname = 'mark';
		}else{
			$tname = 'userfile';
			$fname = 'content';
		};

		$data = array(
			$fname => $info
		);

		$sql = 'select id from '.$tname.' where id='.$fid.' and uid='.(int) $this->user['userid'];
		$query = $this->db->query($sql);
		if($query->num_rows() == 0){
			$ret = array(
				'ret' => 101,
				'msg' => '没有查到文件!'
			);
		}else{
			$str = $this->db->update_string($tname,$data,'id='.$fid.' and uid='.(int) $this->user['userid']);
			$query = $this->db->query($sql);
			if($this->db->affected_rows()>0){
				$ret = array(
					'ret' => 0,
					'info' => $info,
					'msg' => '修改成功!'
				);
			}else{
				$ret = array(
					'ret' => 102,
					'msg' => '修改失败!'
				);
			}
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($ret));
	}

	//移动文件
	public function movefile(){
		$tid = $this->input->post('tid');
		$fid = $this->input->post('fid');

		$data = array(
			'fdid' => $tid
		);
		$sql = $this->db->update_string('userfile',$data,'id ='.$fid);
		$query = $this->db->query($sql);

		if($this->db->affected_rows()>0){
			$ret = array(
				'ret' => 0,
				'msg' => '更新成功!'
			);
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '更新失败!'
			);
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($ret));
	}

	//收藏文件
	public function addcoll(){
		$id = $this->input->post('id');

		$data = array(
			'uid' => $this->user['userid'],
			'fid' => $id,
			'time' => time()
		);

		$sql = $this->db->insert_string('usercollection',$data);
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0){
			$ret = array(
				'ret' => 0,
				'id' => $this->db->insert_id(),
				'msg' => '收藏成功!'
			);
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '插入失败!'
			);
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($ret));
	}

	public function getgroup(){
		$key = $this->input->post('key');
		$type = (Int) $this->input->post('type');

		$sql = 'select id,name,parent from groups where name like "%'.$key.'%" and type='.$type;
		$query = $this->db->query($sql);
		$glist = array();
		$gi = array();
		foreach($query->result() as $row){
			if($row->parent == 0){
				$gi[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name,
					'pid' => $row->parent
				);
			}
			array_push($glist,array(
				'id' => $row->id,
				'name' => $row->name,
				'pid' => $row->parent
			));
		}
		if($type ==1 ){
			foreach($glist as $row){
				if($row['pid']){
					if(!isset($gi[$row['pid']]['list'])){
						$gi[$row['pid']]['list'] = array();
					}
					array_push($gi[$row['pid']]['list'],$row);
				}
			}
			$glist = $gi;			
		}
		$ret = array(
			'ret' => 0,
			'list' => $glist
		);
			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($ret));		
	}

	//取用户列表
	public function getuser(){
		$key = $this->input->post('key');

		$sql = 'select id,name,nick from user where name like "%'.$key.'%" and id != '.$this->user['userid'];
		$query = $this->db->query($sql);
		$list = array();
		foreach($query->result() as $row){
			array_push($list,array(
				'id' => $row->id,
				'name' => $row->name,
				'nick' => $row->nick
			));
		}
		if(count($list) > 0){
			$ret = array(
				'ret' => 0,
				'list' => $list
			);
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($ret));
	}

	public function addgroupshare(){
		$id = $this->input->post('id');  //分组id
		$fid = $this->input->post('flist'); //文件id
		$type = $this->input->post('type'); //类型 0 用户到用户 1 到小组 2到部门
		$isuser = $this->input->post('isuser'); //用户发起还是在小组发起
		$content = $this->input->post('content');
		

		$cache = array();

		//取id
		$kl = array();
		foreach($id as $k){
			
			$cache[$k] = array();
		}
		foreach($fid as $k){
			array_push($kl,' id='.$k);			
		}
		$str = implode(' or ',$kl);
		$sql = 'select id,name from userfile where '.$str;
		$query = $this->db->query($sql);
		$nl = array();
		foreach($query->result() as $row){
			$nl[$row->id] = $row->name;
		};

		$sql = 'select fid,gid from groupfile where uid='.$this->user['userid'];
		$query = $this->db->query($sql);

		foreach($query->result() as $row){
			if(isset($cache[$row->gid])){
				array_push($cache[$row->gid],$row->fid);
			}
		}	
		$key = array();
		$time = time();		
		foreach($id as $k){
			foreach($fid as $i){
				if(!in_array($i,$cache[$k])){
	array_push($key,'('.$i.','.$k.','.$time.',"'.$nl[$i].'",'.'"'.$content.'",'.$this->user['userid'].')');	
				}
			}
		}
		if(count($key)>0){
			$sql = 'insert into groupfile (fid,gid,createtime,fname,content,uid) value '.implode(',',$key);
			$query = $this->db->query($sql);
			if($this->db->affected_rows()>0){
				$ret = array(
					'ret' => 0,
					'msg' => '添加成功!'
				);
			}else{
				$ret = array(
					'ret' => 101,
					'msg' => '添加失败!'
				);
			}
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '不能重复添加'
			);
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($ret));
	}

	public function addshare(){
		//date_default_timezone_set('PRC');
		$id = $this->input->post('id');  //用户id
		$fid = $this->input->post('flist'); //文件id
		$type = $this->input->post('type'); //类型 0 用户到用户 1 到小组 2到部门
		$isuser = $this->input->post('isuser'); //用户发起还是在小组发起
		$content = $this->input->post('content');

		$cache = array();

		foreach($id as $k){
			$cache[$k] = array();
		}

		$sql = 'select fid,tuid from message where fuid='.$this->user['userid'];
		$query = $this->db->query($sql);

		foreach($query->result() as $row){
			if(isset($cache[$row->tuid])){
				array_push($cache[$row->tuid],$row->fid);
			}
		}

		$tablename = 'message';
		$key = array();
		$time = time();
		foreach($id as $k){
			foreach($fid as $i){
				if(!in_array($i,$cache[$k])){
					array_push($key,'('.$this->user['userid'].','.$k.',"'.$content.'",'.$i.')');	
				}
			}
		}
		if(count($key)>0){
			$sql = 'insert into message (fuid,tuid,content,fid) value '.implode(',',$key);
			$query = $this->db->query($sql);

			if($this->db->affected_rows()>0){
				$ret = array(
					'ret' => 0,
					'msg' => '添加成功!'
				);
			}else{
				$ret = array(
					'ret' => 101,
					'msg' => '添加失败!'
				);
			}
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '不能重复添加'
			);
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($ret));
	}

	public function test(){
		$a = array(
			'1' => array(),
			'2' => array()
 		);

 		if(isset($a[3])){
 			echo 1;
 		}else{
 			echo 2;
 		}
	}

	protected function getDir(){
		$nowdir = FILE_UPLOAD_PATH.$this->user['name'];
		$map = directory_map($nowdir);
		if(count($map) == 0){
			$nowdir .= '/'.$this->user['name'].count($map);
			mkdir($nowdir,0700);
			return $nowdir;
			//return $nowdir.'\\'.count($map);
		}else{
			$nowdir .= '/'.$this->user['name'].(count($map)-1);
			$map = directory_map($nowdir,1);
			if(count($map)<DIR_FILE_NUM){
				return $nowdir;	
			}else{
				$nowdir .= '/'.$this->user['name'].count($map);
				mkdir($nowdir,0700);
				return $nowdir;	
			}
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */