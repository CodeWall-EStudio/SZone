<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class File extends SZone_Controller {
 
		public function index(){

			$type = (int) $this->input->get('type'); 
			$gid = (int) $this->input->get('gid');  //1 个人 0 小组
			$fid = (int) $this->input->get('fid');

			$tablename = 'userfile';
			$foldtable = 'userfolds';
			if($gid){
				$tablename = 'groupfile';
				$foldtable = 'groupfolds';
			}

			$sql = 'select id,name,mark,createtime,pid from userfolds where uid = '.$this->user['id'];
			$query = $this->db->query($sql);

			$query = $this->db->query($sql);

			$fold = array();
			$foldlist = array();
			$foldnum = $query->num_rows();
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
				$fold[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name,
					'mark' => $row->mark,
					'pid' => $row->pid,
					'time' => date('Y-m-d',$row->createtime)
				);
			}			

			if($fid){
				$sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = '.$fid.' and a.del = 0 and a.uid='.$this->user['id'];
			}else{
				$sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = 0 and a.del = 0  and a.uid='.$this->user['id'];
			}

			$query = $this->db->query($sql);
			$file = array();
			$filenum = $query->num_rows();
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

			$sql = 'select fid from usercollection where uid='.$this->user['id'];
			$query = $this->db->query($sql);
			$clist = array();
			foreach($query->result() as $row){
				array_push($clist,$row->fid);
			}	

			foreach($file as &$row){
				if(in_array($row['fid'],$clist)){
					$row['coll'] = 1;
				}else{
					$row['coll'] = 0;
				}
			}

			$data = array(
					'fold' => array(
						'total' => $foldnum,
						'list' => $fold
					),
					'file' => array(
						'total' => $filenum,
						'list' => $file
 					)
				);
			$this->json($data,0,'ok');
			// $this->output
			//     ->set_content_type('application/json')
			//     ->set_output(json_encode($data));	

		}

		public function collect(){
			$id = $this->input->post('id');
			$idlist = explode(',',$id);
			$w = array();
			foreach($idlist as $k){
				array_push($w,'fid='.(int) $k);
			};
			$wh = implode(' or ',$w);
			//echo $wh;
			$sql = 'select fid from usercollection where '.$wh .' and uid='.$this->user['id'];
			$query = $this->db->query($sql);

			//有已经收藏过的文件
			$dlist = array();
			if($this->db->affected_rows()>0){
				$fidlist = array();

				foreach($query->result() as $row){
					array_push($fidlist,$row->fid);
				}

				foreach($idlist as $k){
					if(!in_array($k,$fidlist)){
						array_push($dlist,'('.$this->user['id'].','.(int) $k.','.time().')');
					}				
				}
			}else{		
				foreach($idlist as $k){
					array_push($dlist,'('.$this->user['id'].','.(int) $k.','.time().')');
				}
			}

			$sql = 'insert into usercollection (uid,fid,time) value '.implode(',',$dlist);
			$query = $this->db->query($sql);
				
			if($this->db->affected_rows()>0){
				$data = array(
					'id' => $this->db->insert_id(),
				);
				$this->json($data,0,'ok');				
			}else{
				$this->json(array(),10001,'插入失败!');	
			}					
		}

		public function uncollect(){
			$id = $this->input->post('id');
			$idlist = explode(',',$id);
			$w = array();
			foreach($idlist as $k){
				array_push($w,'fid='.(int) $k);
			};

			$wh = implode(' or ',$w);
			$sql = 'delete from usercollection where uid='.$this->user['id'].' and '.$wh;
			$query = $this->db->query($sql);

			if($this->db->affected_rows()>0){
				$ret = array(
					'ret' => 0,
					'msg' => '更新成功!'
				);
				$this->json(array(),0,'更新成功!');	
			}else{
				$ret = array(
					'ret' => 100,
					'msg' => '更新失败!'
				);
				$this->json(array(),10001,'插入失败!');	
			}			
		}
	}