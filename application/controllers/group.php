<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends SZone_Controller {

	public function index(){
		//$this->config->load('szone');
		$this->load->library('pagination');

		$pagenum = $this->config->item('pagenum');
		$nowpage = (int) $this->input->get('page');
		$gid = (int) $this->input->get('id');
		$type = (int) $this->input->get('type');
		$fid = (int) $this->input->get('fid');

		$data = array(
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist,
				'school' => $this->school
			)
		);
		$wsql = '';
		if($fid){
			$wsql .= ' and a.fdid ='.$fid;
		}
		if($type){
			$wsql .= ' and b.type ='.$type;
		}		


		$key = $this->input->get_post('key');
		if(!$fid){
			$sql = 'select id,name,mark,createtime,pid from groupfolds where gid = '.$gid.' or pid='.$gid;
		}else{
			$sql = 'select id,name,mark,createtime,pid from groupfolds where gid = '.$gid.' or pid='.$fid;
		}
		$query = $this->db->query($sql);
		$fold = array();

		if($this->db->affected_rows()>0){
			foreach($query->result() as $row){
				$fold[$row->id] = array(
						'id' => $row->id,
						'name' => $row->name,
						'mark' => $row->mark,
						'time' => $row->createtime,
						'pid' => $row->pid
				);
			}
		}

		$sql = 'SELECT count(a.id) AS anum FROM groupfile a';
		$sql .= ' LEFT JOIN files b ON b.id = a.fid';
		$sql .= ' LEFT JOIN user c ON c.id = a.uid';
		$sql .= ' LEFT JOIN groups d ON d.id = a.fgid';
		$sql .= ' WHERE a.del !=1 and a.fid = b.id AND a.del =0 and gid='.$gid;
		$sql .= $wsql;

		$query = $this->db->query($sql);
		$row = $query->row();

		$allnum = $row->anum;

		$file = array();
		$sql = 'SELECT a.id,a.uid,a.fgid,a.fid,a.fname,a.content,a.createtime,a.status,b.size,b.path,b.type,c.name as uname,d.name AS gname FROM groupfile a';
		$sql .= ' LEFT JOIN files b ON b.id = a.fid';
		$sql .= ' LEFT JOIN user c ON c.id = a.uid';
		$sql .= ' LEFT JOIN groups d ON d.id = a.fgid';
		$sql .= ' WHERE a.del !=1 and a.fid = b.id AND a.del =0 and gid='.$gid;
		$sql .= $wsql;

		$page = get_page_status($nowpage,$pagenum,$allnum);
		$sql .= ' limit '.$page['start'].','.$pagenum;		

		//echo $sql;
		//$sql = 'SELECT a.id,a.fid,a.fname,a.content,a.createtime,a.status,b.size,b.path,b.type FROM groupfile a,files b WHERE a.fid = b.id AND a.del !=1 and gid='.$gid;

		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0){
			foreach($query->result() as $row){
				$file[$row->id] = array(
						'id' => $row->id,
						'fid' => $row->fid,
						'name' => $row->fname,
						'mark' => $row->content,
						'time' => $row->createtime,
						'size' => format_size($row->size),
						'type' => $row->type,
						'uname' => $row->uname,
						'gname' => $row->gname,
						'status' => $row->status//,
						//'path' => 0,//$row->path
				);
			}
		}


		$sql = 'select fid from groupcollection where gid='.$gid;
		$query = $this->db->query($sql);
		$idlist = array();
		foreach($query->result() as $row){
			array_push($idlist,$row->fid);
		}

		$blist = array();
		$sql = 'SELECT a.id,a.content,a.ctime,b.name FROM board a,user b WHERE a.uid = b.id AND a.gid = '.$gid.' limit 0,10';//AND a.status =1 
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0){
			foreach($query->result() as $row){
				$blist[$row->id] = array(
					'id' => $row->id,
					'content' => $row->content,
					'time' => $row->ctime,
					'name' => $row->name
				);
			}
		}
		$data['allnum'] = $allnum;
		$data['page'] = $page;
		$data['blist'] = $blist;
		$data['fold'] = $fold;
		$data['file'] = $file;
		$data['gid'] = $gid;
		$data['fid'] = $fid;
		$data['type'] = $type;
		$data['coll'] = $idlist;
		if(isset($this->grouplist[$gid])){
			$data['ginfo'] = $this->grouplist[$gid];
		}elseif(isset($this->depinfolist[$gid])){
			$data['ginfo'] = $this->depinfolist[$gid];
		}
		if(!isset($data['ginfo'])){
			$data['ginfo'] = $this->school;
		}

		$this->load->view('group',$data);
	}

	public function manage(){
		$gid = (int) $this->input->get('id');

		$sql = 'select id,name,content from groups where id='.$gid;
		$query = $this->db->query($sql);

		$ginfo = array();
		if($this->db->affected_rows() > 0){
			$ginfo = $query->row();
		}

		$ulist = array();
		$sql = 'select a.uid,b.name,b.auth from groupuser a,user b where a.uid = b.id and a.gid='.$gid;
		$query = $this->db->query($sql);

		foreach($query->result() as $row){
			$ulist[$row->uid] = array(
				'uid' => $row->uid,
				'name' => $row->name,
				'auth' => $row->auth
			);
		}

		$data['ulist'] = $ulist;
		$data['ginfo'] = $ginfo;

		$this->load->view('group/manage',$data);
	}

	public function newgroup(){
		$data['uinfo'] = $this->user;
		$this->load->view('group/newgroup',$data);	
	}
}
