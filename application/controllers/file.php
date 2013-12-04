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

			$sql = 'select id,name,mark,createtime,pid from userfolds where uid = '.(int) $this->user['uid'];
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
				$sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = '.$fid.' and a.del = 0 and a.uid='.(int) $this->user['uid'];
			}else{
				$sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = 0 and a.del = 0  and a.uid='.(int) $this->user['uid'];
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

			$data = array(
				'code' => 0,
				'data' => array(
					'fold' => array(
						'total' => $foldnum,
						'list' => $fold
					),
					'file' => array(
						'total' => $filenum,
						'list' => $file
 					)
				)
			);

			$this->output
			    ->set_content_type('application/json')
			    ->set_output(json_encode($data));	

		}
	}