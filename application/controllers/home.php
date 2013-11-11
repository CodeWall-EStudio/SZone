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
		// $this->config->load('filetype');
		// $ft = $this->config->item('filetype');

		//var_dump($this->user);
		$type = (int) $this->input->get('type');
		$fid = (int) $this->input->get('fid');
		$fname = '';
		$pid = 0;
		$foldnum = 0;
		$data = array(
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist
			)
		);


		$sql = 'select id,name,mark,createtime,pid from userfolds where uid = '.(int) $this->user['userid'];
		$query = $this->db->query($sql);

		$fold = array();
		$foldlist = array();
		foreach($query->result() as $row){
			if($row->id == $fid){
				$fname = $row->name;
				$pid = $row->pid;
			}
			if($row->pid > 0 && $row->pid == $fid){
				$foldnum++;
			}
			if($row->pid == 0){
				$foldlist[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name,
					'mark' => $row->mark,
					'pid' => $row->pid,
					'time' => date('Y-m-d',$row->createtime)
				);
			}
			array_push($fold,array(
				'id' => $row->id,
				'name' => $row->name,
				'mark' => $row->mark,
				'pid' => $row->pid,
				'time' => date('Y-m-d',$row->createtime)
			));
		}

		foreach($fold as $row){
			if($row['pid']){
				if(!isset($foldlist[$row['pid']]['list'])){
					$foldlist[$row['pid']]['list'] = array();
				}
				array_push($foldlist[$row['pid']]['list'],$row);
			}
		}

		if($fid){
			$sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = '.$fid.' and a.uid='.(int) $this->user['userid'];
		}else{
			$sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = 0 and a.uid='.(int) $this->user['userid'];			
		}
		//echo $sql;
		$query = $this->db->query($sql);
		$file = array();
		$idlist = array();
		foreach($query->result() as $row){
			if((int) $row->del == 0){
				array_push($file,array(
					'id' => $row->id,
					'name' => $row->name,
					'time' => substr($row->createtime,0,10),
					'content' => $row->content,
					'path' => $row->path,
					'size' => $row->size,
					'type' => $row->type
				));
			}
		}

		$sql = 'select fid from usercollection where uid='.(int) $this->user['userid'];
		$query = $this->db->query($sql);

		foreach($query->result() as $row){
			array_push($idlist,$row->fid);
		}

		$data['fold'] = $fold;
		$data['flist'] = $foldlist;
		$data['fname'] = $fname;
		$data['fid'] = $fid;
		$data['file'] = $file;
		$data['type'] = $type;
		$data['pid'] = $pid;
		$data['coll'] = $idlist;
		$data['foldnum'] = $foldnum;

		$this->load->view('home',$data);	
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */