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

        if ($this->user['uid'] == 0)
        {
            $this->load->view('blank');
            return;
        }

		$pagenum = $this->config->item('pagenum');
		$nowpage = (int) $this->input->get('page');

		$od = (int) $this->input->get('od');
		$on = $this->input->get('on');


		$desc = '';
		$odname = 'name';
		if($od == 2){
			$desc = 'desc';
		}
		switch($on){
			case 1:
				$odname = 'name';
				break;
			case 2:
				$odname = 'type';
				break;
			case 3:
				$odname = 'size';
				break;
			case 4:
				$odname = 'createtime';
				break;			
		}
		// echo json_encode($this->user);
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
				'dep' => $this->deplist,
				'school' => $this->school
			)
		);

		$key = $this->input->get_post('key');

		$sql = 'select id,name,mark,createtime,pid,tid,idpath from userfolds where uid = '.(int) $this->user['uid'];
		// if($key){
		// 	$sql .= ' and name like "%'.$key.'%"';
		// }

		$query = $this->db->query($sql);

		$fold = array();
		$foldlist = array();
		$thisfold = array(
			'id' => 0,
			'pid' => 0
		);
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

		$sql = 'select count(a.id) as anum from userfile a left join files b on b.id = a.fid where a.del =0 and a.uid='.(int) $this->user['uid'];
		//if($fid){
			$sql.=' and a.fdid='.$fid;
		//}
		if($type){
			$sql .= ' and b.type='.$type;
		}
		if($key){
			$sql .= ' and a.name like "%'.$key.'%"';
		}

		$query = $this->db->query($sql);
		$row = $query->row();		
		$allnum = $row->anum;
	

		if($fid){
			$sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = '.$fid.' and a.del = 0 and a.uid='.(int) $this->user['uid'];
		}else{
			$sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = 0 and a.del = 0  and a.uid='.(int) $this->user['uid'];			
		}
		if($type){
			$sql .= ' and b.type='.$type;
		}
		if($key){
			$sql .= ' and a.name like "%'.$key.'%"';
		}
		if($od){
			$sql .= ' order by '.$odname.' '.$desc;
		}

		$page = get_page_status($nowpage,$pagenum,$allnum);
		$sql .= ' limit '.$page['start'].','.$pagenum;

		//$sql .= ' limit '.$page.','.($page+$pagenum);	
		//echo $sql;
		$query = $this->db->query($sql);
		$file = array();
		$idlist = array();

		foreach($query->result() as $row){
			$file[$row->id] = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'name' => $row->name,
				'time' => substr($row->createtime,0,10),
				'content' => $row->content,
				'path' => $row->path,
				'size' => format_size($row->size),
				'type' => $row->type
			);
		}

		$sql = 'select fid from usercollection where uid='.(int) $this->user['uid'];
		$query = $this->db->query($sql);

		foreach($query->result() as $row){
			array_push($idlist,$row->fid);
		}

		$sql = 'select id,name,mark,createtime,pid,tid,idpath from userfolds where uid = '.(int) $this->user['uid'];
		if($key){
			$sql .= ' and name like "%'.$key.'%"';
		}	
		if($od && $on !=2 && $on != 3){
			$sql .= ' order by '.$odname.' '.$desc;
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

		$data['allnum'] = $allnum;
		$data['fold'] = $fold;
		$data['flist'] = $foldlist;
		$data['thisfold'] = $thisfold;
		$data['fname'] = $fname;
		$data['fid'] = $fid;
		$data['file'] = $file;
		$data['type'] = $type;
		$data['pid'] = $pid;
		$data['coll'] = $idlist;
		$data['foldnum'] = $foldnum;
		$data['page'] = $page;
		$data['key'] = $key;
		$data['od'] = $od;
		$data['on'] = $on;


		$this->load->view('home',$data);	
	}

	//移动文件
	function movefile(){
		$id = (int) $this->input->get('fid');
		$fdid = (int) $this->input->get('fdid');
		$gid = (int) $this->input->get('gid');

		$il = explode(',',$id);
		$tablename = 'userfolds';
		if($gid){
			$tablename = 'groupfolds';
		}
		$sql = 'select id,pid,name,tid,idpath from '.$tablename;
		if(!$gid){
			$sql .= ' where uid='.(int) $this->user['uid'];
		}else{
			$sql .= ' where gid='.$gid;
		}
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


		//usort($folds,'psort');
		// foreach($folds as $row){
		// 	echo json_encode($row).'<br>';	
		// }


		// $flist = array();
		// foreach($folds as $row){
			
		// 	if($row['pid'] == 0){
		// 		$flist[$row['id']] = $row;
		// 		$flist[$row['id']]['list'] = array();

		// 	}else if($row['pid'] == $row['tid']){
		// 		$flist[$row['pid']]['list'][$row['id']] = $row;
		// 		$flist[$row['pid']]['list'][$row['id']]['list'] = array();
		// 	}else{
		// 		$l = explode(',',$row['idpath']);
				
		// 		// $td = $flist[$row['tid']]['list'][$row['pid']]['list'];
		// 		// // $len = count($l);
		// 		// for($i=1;$i<$l;$i++){
		// 		//  	$td = parseData($td,$i,$row);
		// 		// }
		// 		// // echo json_encode($row).'<br>';	
		// 	}
		// }
		//$data['flist'] = $folds;


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

	//复制文件到备课
	function copyfile(){
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
		$data = array('fl' => $nl);	

		$sql = 'select id,name from groups where type=3';
		$query = $this->db->query($sql);
		$plist = array();
		foreach($query->result() as $row){
			$plist[$row->id] = array(
				'id' => $row->id,
				'name' => $row->name,
				'list' => array()
			);
		}

		$sql = 'select id,name,pid,sid,gid from prepare';
		$query = $this->db->query($sql);

		$gradelist = array();
		// echo json_encode($query->result());
		foreach($query->result() as $row){
			if($row->pid == 0){
				$plist[$row->gid]['list'][$row->id] = array(
				//$gradelist[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name,
					'pid' => $row->pid,
					'sid' => $row->sid,
					'gid' => $row->gid
				);
					//echo $row->id.json_encode($plist[$row->gid]['list']);
					//echo '<hr>';				
			}else{

				if($row->sid == 0){
					if(!isset($plist[$row->gid]['list'][$row->pid]['list'])){
						$plist[$row->gid]['list'][$row->pid]['list'] = array();
					}

					$plist[$row->gid]['list'][$row->pid]['list'][$row->id] = array(
						'id' => $row->id,
						'name' => $row->name,
						'pid' => $row->pid,
						'sid' => $row->sid,
						'gid' => $row->gid						
					);
					//echo $row->id.json_encode($plist[$row->gid]['list']);
					//echo '<hr>';
				}else{

					if(!isset($plist[$row->gid]['list'][$row->pid]['list'][$row->sid]['list'])){
						$plist[$row->gid]['list'][$row->pid]['list'][$row->sid]['list'] = array();
					}
					if($row->sid == 13){
						//var_dump($plist[$row->gid]['list'][$row->pid]['list'][$row->sid]);
						//echo json_encode($plist[$row->gid]['list'][$row->pid]['list'][$row->sid]);
					}

					$plist[$row->gid]['list'][$row->pid]['list'][$row->sid]['list'][$row->id] = array(
							'id' => $row->id,
							'name' => $row->name,
							'pid' => $row->pid,
							'sid' => $row->sid,
							'gid' => $row->gid						
						);				
				}
			}
		}
		//echo json_encode($plist);
		$data['plist'] = $plist;

		$this->load->view('share/movefile.php',$data);
	}	

	function sendmail(){
		$this->load->helper('util');
		$m = (int) $this->input->get('m'); // m= 0 发件箱  m = 1 收件箱

		$type = (int) $this->input->get('type');
		$uid = (int) $this->input->get('uid');
		$key = $this->input->post('key');

		
		$od = (int) $this->input->get('od');
		$on = $this->input->get('on');		
		$desc = '';
		$odname = 'fname';
		if($od == 2){
			$desc = 'desc';
		}
		switch($on){
			case 1:
				$odname = 'fname';
				break;
			case 2:
				$odname = 'type';
				break;
			case 3:
				$odname = 'size';
				break;
			case 4:
				$odname = 'createtime';
				break;			
		}			

		if($m){
			$sql = 'SELECT a.id,a.fuid as uid,a.content,a.createtime,a.fid,b.name AS uname,c.name AS fname,d.path,d.size,d.type FROM message a LEFT JOIN `user` b ON a.fuid = b.`id` LEFT JOIN `userfile` c ON c.fid = a.fid		LEFT JOIN `files` d ON d.id = a.fid	WHERE a.tuid = '.$this->user['uid'];
		}else{
			$sql = 'SELECT a.id,a.tuid as uid,a.content,a.createtime,a.fid,b.name AS uname,c.name AS fname,d.path,d.size,d.type FROM message a LEFT JOIN `user` b ON a.tuid = b.`id` LEFT JOIN `userfile` c ON c.fid = a.fid		LEFT JOIN `files` d ON d.id = a.fid	WHERE a.fuid = '.$this->user['uid'];
		}

		if($key && $key != '搜索文件'){
			$sql .= ' and c.name like "%'.$key.'%"';
		}else{
			if($type){
				$sql .= ' and d.type='.$type;
			}
			if($uid){
				if($m){
					$sql .= ' and a.fuid='.$uid;
				}else{
					$sql .= ' and a.tuid='.$uid;
				}
			}
		}

		if($od){
			$sql .= ' order by '.$odname.' '.$desc;
		}		

		$query = $this->db->query($sql);
		$mlist = array();
		$tlist = array();
		foreach($query->result() as $row){
			$mlist[$row->id] = array(
				'id' => $row->id,
				'uid' => $row->uid,
				'ctime' => $row->createtime,
				'content' => $row->content,
				'fid' => $row->fid,
				'uname' => $row->uname,
				'fname' => $row->fname,
				'path' => $row->path,
				'size' => format_size($row->size),
				'type' => $row->type
			);
			$tlist[$row->uid] = array(
				'id' => $row->uid,
				'name' => $row->uname
				);
		}

		if(!$m){
			$sql = 'SELECT DISTINCT a.tuid as id,b.name FROM message a,user b WHERE b.id = a.tuid AND a.fuid = '.(int) $this->user['uid'];	
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$tlist = array();
				foreach($query->result() as $row){
					$tlist[$row->id] = array(
						'id' => $row->id,
						'name' => $row->name
						);				
				}
			}			
		}

		$data['m'] = $m;
		$data['type'] = $type;
		$data['uid'] = $uid;
		$data['mail'] = $mlist;
		$data['ulist'] = $tlist;
		$data['od'] = $od;
		$data['on'] = $on;		

		$this->load->view('home/mail.php',$data);
	}

	function groupmail(){
		$this->load->helper('util');
		$type = (int) $this->input->get('type');
		$gid = (int) $this->input->get('gid');
		$key = $this->input->post('key');

		
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
				break;
			case 2:
				$odname = 'type';
				break;
			case 3:
				$odname = 'size';
				break;
			case 4:
				$odname = 'createtime';
				break;			
		}	

		$sql = 'SELECT a.id,a.fname,a.fid,a.createtime,a.gid,b.name AS gname,c.path,c.size,c.type,d.name AS fdname FROM groupfile a LEFT JOIN groups b ON b.id = a.gid	LEFT JOIN files c ON c.id = a.fid LEFT JOIN groupfolds d ON a.fdid = d.id WHERE a.uid ='.(int) $this->user['uid'];

		if($key && $key != '搜索文件'){
			$sql .= ' and a.fname like "%'.$key.'%"';
		}else{
			if($type){
				$sql .= ' and c.type='.$type;
			}
			if($gid){
				$sql .= ' and a.gid='.$gid;
			}
		}

		if($od){
			$sql .= ' order by '.$odname.' '.$desc;
		}


		$query = $this->db->query($sql);
		$mlist = array();
		$tlist = array();
		foreach($query->result() as $row){
			$mlist[$row->id] = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'gname' => $row->gname,
				'fname' => $row->fname,
				'fdname' => $row->fdname,
				'path' => $row->path,
				'size' => format_size($row->size),
				'ctime' => $row->createtime,
				'type' => $row->type
			);
			$tlist[$row->gid] = array(
				'id' => $row->gid,
				'name' => $row->gname
				);
		}

		if($gid){
			$sql = 'SELECT DISTINCT a.gid as id,b.name FROM groupfile a,groups b WHERE a.gid = b.id AND a.uid='.(int) $this->user['uid'];
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$tlist = array();
				foreach($query->result() as $row){
					$tlist[$row->id] = array(
						'id' => $row->id,
						'name' => $row->name
						);				
				}
			}
		}


		$data['type'] = $type;
		$data['gid'] = $gid;
		$data['mail'] = $mlist;
		$data['glist'] = $tlist;
		$data['od'] = $od;
		$data['on'] = $on;

		$this->load->view('home/gmail.php',$data);
	}	

	function prepare(){
		$this->load->helper('util');
// SELECT a.id,
// 	a.content,
// 	a.createtime,
// 	a.fid,
// 	b.name AS uname,
// 	c.name AS fname,
// 	d.path
//  FROM message a 
// LEFT JOIN `user` b ON a.tuid = b.`id`
// LEFT JOIN `userfile` c ON c.fid = a.fid
// LEFT JOIN `files` d ON d.id = a.fid
// WHERE a.fuid = 2;		
		$pid = (int) $this->input->get('pid');
		$type = (int) $this->input->get('type');
		$key = $this->input->post('key');
		$sql = 'SELECT a.id,a.pid,a.fid,b.name,b.createtime,b.content,c.size,c.path,c.type FROM preparefile a LEFT JOIN userfile b ON b.fid = a.fid LEFT JOIN files c ON c.id = a.fid WHERE a.uid ='.(int) $this->user['uid'];
		//类型选择
		if($type){
			$sql .= ' and c.type='.$type;
		}
		if($pid){
			$sql .= ' and a.pid='.$pid;
		}
		if($key){
			$sql .= ' and b.name like "%'.$key.'%"';
		}

		$query = $this->db->query($sql);

		$plist = array();
		foreach($query->result() as $row){
			$plist[$row->id] = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'name' => $row->name,
				'ctime' => $row->createtime,
				'content' => $row->content,
				'size' => format_size($row->size),
				'path' => $row->path,
				'type' => $row->type
			);
		}
		$prelist = $this->prelist;

		$gradelist = array();
		foreach($prelist as $k => $row){
			$gradelist[$k] = array(
					'id' => $k,
					'name' => $row
				);
		}

		$sql = 'select id,name,pid,sid,gid from prepare';
		$query = $this->db->query($sql);
	
		foreach($query->result() as $row){
			if($row->pid == 0){
				if(!isset($gradelist[$row->gid]['list'])){
					$gradelist[$row->gid]['list'] = array();
				}

				$gradelist[$row->gid]['list'][$row->id] = array(
					'id' => $row->id,
					'name' => $row->name,
					'pid' => $row->pid,
					'sid' => $row->sid,
					'gid' => $row->gid
				);

			}else{
				if($row->sid == 0){
					if(!isset($gradelist[$row->gid]['list'][$row->pid]['list'])){
						$gradelist[$row->gid]['list'][$row->pid]['list'] = array();
					}					
					$gradelist[$row->gid]['list'][$row->pid]['list'][$row->id] = array(
						'id' => $row->id,
						'name' => $row->name,
						'pid' => $row->pid,
						'sid' => $row->sid,
						'gid' => $row->gid						
					);
				}else{
					if(!isset($gradelist[$row->gid]['list'][$row->pid]['list'][$row->sid]['list'])){
						$gradelist[$row->gid]['list'][$row->pid]['list'][$row->sid]['list'] = array();
					}
					$gradelist[$row->gid]['list'][$row->pid]['list'][$row->sid]['list'][$row->id] = array(
						'id' => $row->id,
						'name' => $row->name,
						'pid' => $row->pid,
						'sid' => $row->sid,
						'gid' => $row->gid						
					);						
										
				}
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
		$data['type'] = 0;
		$data['fid'] = 0;
		$data['plist']  = $plist;
		$data['glist'] = $gradelist;
		//$data['nav']['userinfo'] = $this->user;
		// echo json_encode($plist);
	

		$this->load->view('home/prep.php',$data);
	}

	public function coll(){
		$this->load->helper('util');

		$page = $this->input->get('page');
		$type = $this->input->get('type');
		$key = $this->input->post('key');

		$od = (int) $this->input->get('od');
		$on = $this->input->get('on');		
		$desc = '';
		$odname = 'name';
		if($od == 2){
			$desc = 'desc';
		}
		switch($on){
			case 1:
				$odname = 'name';
				break;
			case 2:
				$odname = 'type';
				break;
			case 3:
				$odname = 'size';
				break;
			case 4:
				$odname = 'createtime';
				break;			
		}		

		$sql = 'SELECT a.id,a.fid,a.remark,a.time,b.name,c.size,c.path,c.type FROM usercollection a LEFT JOIN userfile b ON a.fid = b.fid LEFT JOIN files c ON a.fid = c.id WHERE a.uid ='.$this->user['uid'];

		if($od){
			$sql .= ' order by '.$odname.' '.$desc;
		}

		if($type){
			$sql .= ' and c.type='.$type;
		}
		if($key){
			$sql .= ' and b.name like "%'.$key.'%"';
		}

		$query = $this->db->query($sql);

		$flist = array();
		foreach($query->result() as $row){
			$flist[$row->id] = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'name' => $row->name,
				'remark' => $row->remark,
				'time' => $row->time,
				'size' => format_size($row->size),
				'path' => $row->path,
				'type' => $row->type
 			);
		}

		$data['flist'] = $flist;
		$data['type'] = $type;
		$data['key'] = $key;
		$data['od'] = $od;
		$data['on'] = $on;
		$this->load->view('home/coll.php',$data);
	}

	public function recy(){
		$this->load->helper('util');

		$type = (int) $this->input->get('type');
		$key = $this->input->get_post('key');

		$pagenum = $this->config->item('pagenum');
		$nowpage = (int) $this->input->get('page');		

		$sql = 'select count(a.id) as anum from userfile a,files b where a.fid = b.id and a.del = 1 and a.uid='.(int) $this->user['uid'];
		if($type){
			$sql .= ' and b.type='.$type;
		}
		if($key){
			$sql .= ' and a.name like "%'.$key.'%"';
		}
		$query = $this->db->query($sql);
		$row = $query->row();
		$allnum = $row->anum;		

		$page = get_page_status($nowpage,$pagenum,$allnum);

		$sql = 'select a.id,a.fid,a.name,a.createtime,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.del = 1 and a.uid='.(int) $this->user['uid'];
		if($type){
			$sql .= ' and b.type='.$type;
		}
		if($key){
			$sql .= ' and a.name like "%'.$key.'%"';
		}

		$sql .= ' limit '.$page['start'].','.$pagenum;	

		$query = $this->db->query($sql);
		$dlist = array();
		foreach($query->result() as $row){
			$dlist[$row->id] = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'name' => $row->name,
				'time' => $row->createtime,
				'size' => format_size($row->size),
				'path' => $row->path,
				'type' => $row->type
 			);
		}

		$data['dlist'] = $dlist;
		$data['type'] = $type;
		$data['key'] = $key;
		$data['page'] = $page;
		$this->load->view('home/recy.php',$data);
	}

	public function my(){
		$data = array(
			'nav' => array(
				'userinfo' => $this->user,
				'group' => $this->grouplist,
				'dep' => $this->deplist,
				'school' => $this->school
			)
		);			
		$this->load->view('home/index.php',$data);	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */