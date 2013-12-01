<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School extends SZone_Controller {

	public function index(){

		if($this->user['auth'] < 15){
			redirect('/');
		}

		$pagenum = $this->config->item('pagenum');
		$nowpage = (int) $this->input->get('page');
		$type = (int) $this->input->get('type');
		$key = $this->input->get('key');

		$wsql = ' left join groups b on b.id = a.gid';
		$wsql .= ' left join user c on c.id = a.uid';
		$wsql .= ' left join groupfolds d on a.fdid = d.id';
		$wsql .= ' left join groupfolds e on d.pid = e.id';
		$wsql .= ' left join files f on a.fid = f.id';

		$sql = 'select count(a.id) as anum from groupfile a ';
		$sql .= $wsql;

		$query = $this->db->query($sql);
		$row = $query->row();

		$allnum = $row->anum;

		$page = get_page_status($nowpage,$pagenum,$allnum);
		//拉个人资料
		$sql = 'select a.id,a.fid,a.fname,a.gid,a.content,a.createtime,a.uid,a.status,b.name as gname,c.name as uname,d.name as fdname,e.name as fpname,f.path,f.type,f.size from groupfile a ';
		$sql .= $wsql;
		$sql .= ' limit '.$page['start'].','.$pagenum;	

		$query = $this->db->query($sql);

		$flist = array();
		foreach($query->result() as $row){
			$flist[$row->id] = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'fname' => $row->fname,
				'content' => $row->content,
				'gid' => $row->gid,
				'time' => $row->createtime,
				'uid' => $row->uid,
				'gname' => $row->gname,
				'uname' => $row->uname,
				'fdname' => $row->fdname,
				'fpname' => $row->fpname,
				'type' => $row->type,
				'size' =>  format_size($row->size),
				'path' => $row->path,
				'status' => $row->status
			);
		}

		$sql = 'select count(id) as allnum from groupfile where ttime=0';
		$query = $this->db->query($sql);

		$row = $query->row();
		$notreg = $row->allnum;


		$data = array(
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist,
				'school' => $this->school
			)
		);
		$data['allnum'] = $allnum;
		$data['page'] = $page;		
		$data['flist'] = $flist;
		$data['key'] = $key;	
		$data['nreg']	= $notreg;
		$data['type'] = $type;		

		$this->load->view('school/index',$data);	
	}

}