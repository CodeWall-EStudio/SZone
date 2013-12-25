<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review extends SZone_Controller {
 
	public function index(){
		$gid = (int) $this->input->get('gid');
		$fdid = (int) $this->input->get('fdid');
		$fid = (int) $this->input->get('fid');
		$id = (int) $this->input->get('id');
		$type = (int) $this->input->get('t');  //1 上一条 2 下一条

		$tablename = 'userfile';
		if($gid){
			$tablename = 'groupfile';
		}

		$sql = 'select a.id,a.fid,a.name,a.content,b.path,b.size,b.type,b.mimes from '.$tablename.' a, files b where a.fid = b.id and b.id = '.$fid;
		if(!$gid){
			$sql .= ' and a.uid='.(int) $this->user['uid'];
		}
		// if($type == 1){
		// 	$sql .= ' and a.id < '.$fid.' limit 0,1';
		// }elseif($type ==2){
		// 	$sql .= ' and a.id > '.$fid.' limit 0,1';
		// }else{
		// 	$sql .= ' and b.id='.$fid;
		// }
		// echo $sql;

		//$docs = array('application/vnd.ms-word','application/vnd.ms-excel','application/vnd.ms-powerpoint','application/msword');


		$query = $this->db->query($sql);
		$finfo = 0;
		if($this->db->affected_rows()>0){
			$row = $query->row();

			$finfo = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'name' => $row->name,
				'content' => $row->content,
				'path' => $row->path,
				'type' => (int) $row->type,
				'mimes' => $row->mimes
			);

			if($finfo['type']==2 && $finfo['mimes'] == 'text/plain'){
				$txt =  file_get_contents($finfo['path']);
				$order = array("\r\n", "\n", "\r");
				$txt = str_replace($order,'<br>',$txt);
				$finfo['text'] = $txt;
				//$finfo->text = file_get_contents($finfo->path);
			}
		}

		$prev = 0;
		$next = 0;
		$sql = 'select id from '.$tablename.' where id<'.$fid;
		$query = $this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$row = $query->row();
			$prev = $row->id;
		}

		$sql = 'select id from '.$tablename.' where id>'.$fid;
		$query = $this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$row = $query->row();
			$next = $row->id;
		}



		$data['finfo'] = $finfo;
		$data['gid'] = $gid;
		$data['id'] = $id;
		$data['prev'] = $prev;
		$data['next'] = $next;

		$this->load->view('review',$data);
	}

	public function reviewfile(){

	}
}