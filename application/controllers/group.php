<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends SZone_Controller {

	public function index(){
		$this->config->load('szone');
		$pagenum = $this->config->item('pagenum');
		$page = (int) $this->input->get('page');
		$gid = (int) $this->input->get('id');

		$type = (int) $this->input->get('type');

		$fid = (int) $this->input->get('fid');

		$data = array(
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist
			)
		);


		$key = $this->input->post('key');

		$sql = 'select id,name,mark,createtime,pid from groupfolds where gid = '.$gid;
		$query = $this->db->query($sql);
		$fold = array();
		if($this->db->affected_rows()>0){
			foreach($query->reuslt() as $row){
				$fold[$row->id] = array(
						'id' => $row->id,
						'name' => $row->name,
						'mark' => $row->mark,
						'time' => $row->createtime,
						'pid' => $row->pid
				);
			}
		}

		$file = array();
		$sql = 'SELECT a.id,a.fid,a.fname,a.content,a.createtime,b.size,b.path,b.type FROM groupfile a,files b WHERE a.fid = b.id AND a.del !=1 and gid='.$gid;

		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0){
			foreach($query->result() as $row){
				$file[$row->id] = array(
						'id' => $row->id,
						'fid' => $row->fid,
						'name' => $row->fname,
						'mark' => $row->content,
						'time' => $row->createtime,
						'size' => get_file_size($row->size),
						'type' => $row->type,
						'path' => $row->path
				);
			}
		}

		$data['fold'] = $fold;
		$data['file'] = $file;
		$data['gid'] = $gid;
		$data['fid'] = $fid;
		$data['type'] = $type;
		$data['coll'] = array();
		if(isset($this->grouplist[$gid])){
			$data['glist'] = $this->grouplist[$gid];
		}

		$this->load->view('group.php',$data);
	}
}
