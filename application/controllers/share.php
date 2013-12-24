<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Share extends SZone_Controller {
    
		public function other(){
			$type = $this->input->get('type');
			$gid = (int) $this->input->get('gid');
			$id = $this->input->get('id');

			$il = explode(',',$id);
			$kl = array();
			foreach($il as $k){
				array_push($kl,$k);
			}
			$str = implode(' or ',$kl);

			if($gid){
				$sql = 'select fid,fname as name from groupfile where gid='.$gid.' and '.$str;
			}else{
				$sql = 'select fid,name from userfile where uid='.$this->user['uid'].' and id in ('.implode(',',$kl).')';
			}

			$query = $this->db->query($sql);
			$nl = array();
			foreach($query->result() as $row){
				array_push($nl,array(
						'id' => $row->fid,
						'name' => $row->name
					));
			}			

			$sql = 'select id,name from user where id !='.(int) $this->user['uid'];
			$query = $this->db->query($sql);

			$ul = array();
			foreach($query->result() as $row){
				$ul[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name
				);
			}

			$data = array('fl' => $nl,'type' => 0,'gid' => $gid,'ul' => $ul);
			$this->load->view('share/other.php',$data);			
		}


		public function group(){
			$type = $this->input->get('type');
			$gid = (int) $this->input->get('gid');
			$id = $this->input->get('id');

			$il = explode(',',$id);
			$kl = array();
			foreach($il as $k){
				array_push($kl,' id='.$k);
			}
			$str = implode(' or ',$kl);
			if($gid){
				$sql = 'select id,fid,fname as name from groupfile where '.$str;
			}else{
				$sql = 'select id,fid,name from userfile where '.$str;	
			}
			$query = $this->db->query($sql);

			$nl = array();
			foreach($query->result() as $row){
				array_push($nl,array(
						'id' => $row->id,
						'fid' => $row->fid,
						'name' => $row->name
					));
			}


			$sql = 'select a.id,a.name from groups a,groupuser b where a.id = b.gid and a.type = 1 and b.uid='.$this->user['uid'];
			$query = $this->db->query($sql);
			$gl = array();
			foreach($query->result() as $row){
				$gl[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name
				);
			}

			$data = array('fl' => $nl,'type' => 1,'gid' => $gid,'gl' => $gl);
			$this->load->view('share/group.php',$data);			
		}


		public function dep(){
			$type = $this->input->get('type');
			$gid = (int) $this->input->get('gid');
			$id = $this->input->get('id');

			$il = explode(',',$id);
			$kl = array();
			foreach($il as $k){
				array_push($kl,' id='.$k);
			}
			$str = implode(' or ',$kl);
			if($gid){
				$sql = 'select id,fid,fname as name from groupfile where '.$str;
			}else{
				$sql = 'select id,fid,name from userfile where '.$str;	
			}
			$query = $this->db->query($sql);

			$nl = array();
			foreach($query->result() as $row){
				array_push($nl,array(
						'id' => $row->id,
						'fid' => $row->fid,
						'name' => $row->name
					));
			}


			$sql = 'select a.id,a.name from groups a,groupuser b where a.id = b.gid and a.type = 2 and a.pt=0 and b.uid='.$this->user['uid'];
			$query = $this->db->query($sql);
			$gl = array();
			foreach($query->result() as $row){
				$gl[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name
				);
			}		
			$data = array('fl' => $nl,'type' => 2,'gid' => $gid,'gl' => $gl);
			$this->load->view('share/dep.php',$data);			
		}



	}