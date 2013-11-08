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

		$sql = 'select id from userfolds where uid = '.(int) $this->user['userid'].' and name ="'.$name.'"';
		$query = $this->db->query($sql);
		if($query->num_rows() == 0){

			$data = array(
				'name' => $name,
				'uid' => $this->user['userid'],
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


		$dirname = FILE_UPLOAD_PATH.$this->user['name'];
		if (!file_exists($dirname)){
			mkdir($dirname,0700);
		}
		
		$nowdir = $this->getDir();

		$config['upload_path'] = $nowdir;
		$config['allowed_types'] = 'gif|jpg|png';
		$this->load->library('upload', $config);

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
				'del' => 0
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