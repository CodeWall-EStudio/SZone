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
		$key = $this->input->get_post('key');
		$st = (int) $this->input->get('st');
		$ud = (int) $this->input->get('ud');

		if(isset($this->depinfolist[$gid]) && $this->depinfolist[$gid]['pt']){
			redirect('/group/prep');
			return;
		}

		$od = (int) $this->input->get('od');
		$on = $this->input->get('on');

		$desc = '';
		$odname = 'name';
		if($od == 2){
			$desc = 'desc';
		}
		switch($on){
			case 1:
				$odname = 'a.fname';
				$odname1 = 'name';
				break;
			case 2:
				$odname = 'b.type';
				break;
			case 3:
				$odname = 'b.size';
				break;
			case 4:
				$odname = 'a.createtime';
				$odname1 = 'createtime';
				break;			
		}


		$allnum = 0;
		$page = array(
			'prev' => 0,
			'next' => 0
			);

		$inGroup = true;
        if ($this->user['uid'] != 0){
            $this->load->model('User_model');
           	$inGroup = $this->User_model->get_in_group($this->user['uid'],$gid);
        }		
		$fold = array();
		$file = array();
		$blist = array();
		$foldlist = array();
		$ulist = array();
		$fname = '';
		$thisfold = array(
			'id' => 0,
			'pid' => 0
		);		

		$data = array(
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist,
				'school' => $this->school
			)
		);

		if($inGroup || $this->user['auth'] > 10){

			$wsql = '';
			//if($fid){
				$wsql .= ' and a.fdid ='.$fid;
			//}
			if($type){
				$wsql .= ' and b.type ='.$type;
			}	
			if($ud){
				$wsql .= ' and a.uid ='.$ud;
			}
			if($st){
				$wsql .= ' and a.status='.($st-1);
			}

			$key = $this->input->get_post('key');
			if(!$fid){
			  	$sql = 'select id,name,mark,createtime,pid,tid,idpath from groupfolds where gid = '.$gid;
			}else{
				$sql = 'select id,name,mark,createtime,pid,tid,idpath from groupfolds where gid = '.$gid.' or pid='.$fid;
			}
			$query = $this->db->query($sql);
			
			$fname = '';
			$fold = array();
			$foldlist = array();
			
			foreach($query->result() as $row){
				if($row->id == $fid){
					$thisfold = array(
						'id' => $row->id,
						'pid' => $row->pid,
						'name' => $row->name,
						'tid' => $row->tid,
						'idpath' => explode(',',$row->idpath)
					);
					$fname = $row->name;
					$pid = $row->pid;
				}
				$fold[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name,
					'mark' => $row->mark,
					'pid' => (int) $row->pid,
					'tid' => (int) $row->tid,
					'idpath' => $row->idpath,
					'time' => date('Y-m-d',$row->createtime)
				);
				if($row->pid == 0){
					$foldlist[$row->id] = array(
						'id' => $row->id,
						'name' => $row->name,
						'mark' => $row->mark,
						'pid' => (int) $row->pid,
						'tid' => (int) $row->tid,
						'time' => date('Y-m-d',$row->createtime)
					);				
				}else{
					if(isset($fold[$row->pid])){
						$fold[$row->pid]['child'] = 1;
					}
				}
			}
			$foldnum = count($fold);

			foreach($fold as $row){
				if($row['pid'] == 0){
					$foldlist[$row['id']] = $row;
				}else if($row['pid'] == $row['tid']){
					if(!isset($foldlist[$row['pid']]['list'])){
						$foldlist[$row['pid']]['list'] = array();
					}
					$foldlist[$row['pid']]['list'][$row['id']] = $row;
				}
			}
			
			// if($this->db->affected_rows()>0){
			// 	foreach($query->result() as $row){
			// 		$fold[$row->id] = array(
			// 				'id' => $row->id,
			// 				'name' => $row->name,
			// 				'mark' => $row->mark,
			// 				'time' => $row->createtime,
			// 				'pid' => $row->pid
			// 		);
			// 	}
			// }

			$sql = 'SELECT count(a.id) AS anum FROM groupfile a';
			$sql .= ' LEFT JOIN files b ON b.id = a.fid';
			$sql .= ' LEFT JOIN user c ON c.id = a.uid';
			$sql .= ' LEFT JOIN groups d ON d.id = a.fgid';
			$sql .= ' WHERE a.del =0  and a.fid = b.id and gid='.$gid;
			$sql .= $wsql;
			if($key){
				$sql .= ' and a.fname like "%'.$key.'%"';
			}

			$query = $this->db->query($sql);
			$row = $query->row();

			$allnum = $row->anum;

			
			$sql = 'SELECT a.id,a.uid,a.fgid,a.fid,a.fname,a.content,a.createtime,a.status,b.size,b.path,b.type,c.name as uname,d.name AS gname,f.id as cid FROM groupfile a';
			$sql .= ' LEFT JOIN files b ON b.id = a.fid';
			$sql .= ' LEFT JOIN user c ON c.id = a.uid';
			$sql .= ' LEFT JOIN groups d ON d.id = a.fgid';
			$sql .= ' left join usercollection f on f.fid = a.fid';
			$sql .= ' WHERE a.del =0 and a.fid = b.id and gid='.$gid;
			$sql .= $wsql;
			if($key){
				$sql .= ' and a.fname like "%'.$key.'%"';
			}

			$page = get_page_status($nowpage,$pagenum,$allnum);

			if($od){
				$sql .= ' order by '.$odname.' '.$desc;
			}

			$sql .= ' limit '.$page['start'].','.$pagenum;		
			//echo $wsql;
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
							'cancopy' => (int) $row->uid==$this->user['uid']?0:1,
							'coll' => $row->cid?true:false,
							'status' => $row->status//,
							//'path' => 0,//$row->path
					);
				}
			}

			$sql = 'select id,name,mark,createtime,pid,tid,idpath from groupfolds where gid = '.$gid;
			if($key){
				$sql .= ' and name like "%'.$key.'%"';
			}	
			if($od && $on !=2 && $on != 3){
				$sql .= ' order by '.$odname1.' '.$desc;
			}
			$query = $this->db->query($sql);
			$fold = array();
			foreach($query->result() as $row){
				$fold[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name,
					'mark' => $row->mark,
					'pid' => (int) $row->pid,
					'tid' => (int) $row->tid,
					'idpath' => $row->idpath,
					'time' => date('Y-m-d',$row->createtime)
				);
			}

			// $sql = 'select fid from groupcollection where gid='.$gid;
			// $query = $this->db->query($sql);
			// $idlist = array();
			// foreach($query->result() as $row){
			// 	array_push($idlist,$row->fid);
			// }

			
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

			$sql = 'select a.uid,b.name from groupuser a,user b where gid='.$gid.' and a.uid = b.id';
			$query = $this->db->query($sql);

			foreach($query->result() as $row){
				$ulist[$row->uid] = array(
					'id' => $row->uid,
					'name' => $row->name
				);
			}
		}

		$data['allnum'] = $allnum;
		$data['page'] = $page;
		$data['blist'] = $blist;
		$data['fold'] = $fold;
		$data['flist'] = $foldlist;
		$data['foldname'] = $fname;
		$data['file'] = $file;
		$data['gid'] = $gid;
		$data['fid'] = $fid;
		$data['type'] = $type;
		$data['ingroup'] = $inGroup;
		$data['key'] = $key;
		$data['od'] = $od;
		$data['on'] = $on;
		$data['ulist'] = $ulist;
		$data['thisfold'] = $thisfold;

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
		$sql = 'select id,name from user where id !='.(int) $this->user['id'];
		$query = $this->db->query($sql);

		$ul = array();
		foreach($query->result() as $row){
			$ul[$row->id] = array(
				'id' => $row->id,
				'name' => $row->name
			);
		}
		$data['ul'] = $ul;

		$this->load->view('group/newgroup',$data);	
	}


	//移动文件
	function movefile(){
		$id = (int) $this->input->get('fid');
		$fdid = (int) $this->input->get('fdid');
		$gid = (int) $this->input->get('gid');

		$il = explode(',',$id);
		$sql = 'select id,pid,name,tid,idpath from groupfolds where gid='.$gid;

		if($fdid){
			$sql .= ' and id !='.$fdid;
		}
		$query = $this->db->query($sql);

		$folds = array();
		foreach($query->result() as $row){
			$folds[$row->id] = array(
				'id' => $row->id,
				'pid' => $row->pid,
				'name' => $row->name,
				'tid' => $row->tid,
				'idpath' => $row->idpath
			);					
		}

		function psort($a,$b){
			if($a['pid'] == 0){
				return -1;
			// }else if( $a['pid'] < $b['pid']){
			// 	return -1;
			}else if($a['pid'] = $b['pid']){
			// return 0;
				$an = count(explode(',',$a['idpath']));
				$bn = count(explode(',',$b['idpath']));
				if( $an < $bn){
					return -1;
				}else if($an == $bn){
					return 0;
				}else{
					return 1;
				}				
			}else{
				return 1;
			}
		}

		$id = $this->input->get('fid');

		$il = explode(',',$id);
		$kl = array();
		foreach($il as $k){
			array_push($kl,' id='.$k);
		}		
		$str = implode(' or ',$kl);
		$sql = 'select id,name from userfile where '.$str;		
		$query = $this->db->query($sql);

		$nl = array();
		foreach($query->result() as $row){
			array_push($nl,array(
					'id' => $row->id,
					'name' => $row->name
				));
		}	
		$data = array(
			'fl' => $nl,
			'flist' => $folds,
			'gid' => $gid
			);	

		//echo json_encode($folds);

		$this->load->view('share/copyfile.php',$data);		
		// echo '<hr>';
		// echo json_encode($flist);
	}	

	public function prep(){

		$prid = (int) $this->input->get('prid');
		$gr = (int) $this->input->get('gr');
		$tag = $this->input->get('tag');
		$ud = (int) $this->input->get('ud');
		$fdid = (int) $this->input->get('fdid');

		$key = $this->input->post('key');

		$sql = 'select id from groups where pt=1';
		$query = $this->db->query($sql);

		$row = $query->row();
		$gid = $row->id;

		$sql = 'select id,name,parent,tag,grade from groups where type=3 and parent=0 order by parent';
		$query = $this->db->query($sql);

		$plist = array();
		$kp = array();

		$pfname = '';
		$pname = '';

		$first = 0;
		$pids = array();
		$pls = array();
		//选择备课目录
		foreach($query->result() as $row){
			$plist[$row->id] = array(
				'id' => $row->id,
				'name' => $row->name,
				'list' => array()
			);
			array_push($kp,$row->id);
			if($row->id == $prid){
				$plist[$row->id]['selected'] = 1;
				$first = 1;
			}
		};

  		$this->db->where_in('parent',$kp);
		if($gr){
			$this->db->where('grade',$gr);
		}
		if($tag){
			$this->db->where('tag',$tag);
		}
		$query = $this->db->get('groups');
		foreach($query->result() as $row){
			array_push($pids,' b.gid='.$row->id);
			array_push($pls,' a.prid='.$row->id);
		}

		$sql = 'select a.id,a.name from user a,groupuser b where a.id = b.uid  ';
		if($prid){
			$sql .= 'and b.gid='.$prid;	
		}else{
			if(count($pids)>0){
				$sql .= 'and ('.implode(' or ',$pids).')';
			}
		}	
		$query = $this->db->query($sql);

		$ulist = array();
		foreach($query->result() as $row){
			$ulist[$row->id] = array(
				'id' => $row->id,
				'name' => $row->name
			);
		}

		$sql = 'select a.id,a.name,a.pid,a.prid,b.name as uname,b.id as uid from userfolds a,user b where ';
		if($ud){
			$sql .= ' b.id = '.$ud.' and';
		}
		if($first){
			if(count($pls)>0){
				$sql .= ' ('.implode(' or ',$pls).') and a.uid = b.id';
			}else{
				$sql .= ' a.prid =-1 and a.uid = b.id';
			}
		}else{
			if($prid){
				$sql .= ' a.prid = '.$prid.' and a.uid = b.id';
			}else{
				if(count($pls)>0){
					$sql .= ' ('.implode(' or ',$pls).') and a.uid = b.id';	
				}else{
					$sql .= ' a.prid =-1 and a.uid = b.id';
				}
			}		
		}
		$query = $this->db->query($sql);

		$fold = array();
		foreach($query->result() as $row){
			$fold[$row->id] = array(
				'id' => $row->id,
				'name' => $row->uname .' '.$row->name,
				'fname' => $row->name,
				'uid' => $row->uid,
				'prid' => $row->prid,
				'uname' => $row->uname
			);
		}

		$flist = array();
		if($fdid && count($fold)>0 ){
			$fold = array();
			$sql = 'select a.id,a.name,a.pid,a.prid,b.name as uname,b.id as uid from userfolds a,user b where b.id='.$ud.' and a.pid='.$fdid;
			$query = $this->db->query($sql);
			// $this->db->where('pid',$fdid);
			// $query = $this->db->get('userfolds');
			foreach($query->result() as $row){
				$fold[$row->id] = array(
					'id' => $row->id,
					'name' => $row->uname .' '.$row->name,
					'fname' => $row->name,
					'uid' => $row->uid,
					'prid' => $row->prid,
					'uname' => $row->uname
				);
			}

			$sql = 'select a.id,a.name,a.fid,a.mark,b.size,b.type from userfile a,files b where a.fdid='.$fdid.' and a.fid = b.id';
			if($key && $key != '' && $key != '搜索文件'){
				$sql .= ' and a.name like "%'.$key.'%"';
			}
			$query = $this->db->query($sql);

			foreach($query->result() as $row){
				$flist[$row->id] = array(
					'id' => $row->id,
					'fid' => $row->fid,
					'name' => $row->name,
					'mark' => $row->mark,
					'size' => format_size($row->size),
					'type' => $row->type
				);
			}
		}

		$data = array(
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist,
				'school' => $this->school
			)
		);	
		$data['prid'] = $prid;
		$data['fdid'] = $fdid;
		$data['ud'] = $ud;
		$data['plist'] = $plist;
		$data['ulist'] = $ulist;
		$data['fold'] = $fold;
		$data['gr'] = $gr;
		$data['tag'] = $tag;
		$data['flist'] = $flist;

		$this->load->view('group/prep.php',$data);	
	}
}
