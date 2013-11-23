<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Share extends SZone_Controller {

		public function other(){
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
				$sql = 'select fid,fname as name from groupfile where '.$str;
			}else{
				$sql = 'select fid,name from userfile where '.$str;	
			}
			

			$query = $this->db->query($sql);

			$nl = array();
			foreach($query->result() as $row){
				array_push($nl,array(
						'id' => $row->fid,
						'name' => $row->name
					));
			}
			$data = array('fl' => $nl,'type' => 0,'gid' => $gid);
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
				$sql = 'select fid,fname as name from groupfile where '.$str;
			}else{
				$sql = 'select fid,name from userfile where '.$str;	
			}
			$query = $this->db->query($sql);

			$nl = array();
			foreach($query->result() as $row){
				array_push($nl,array(
						'id' => $row->fid,
						'name' => $row->name
					));
			}
			$data = array('fl' => $nl,'type' => 1,'gid' => $gid);
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
				$sql = 'select fid,fname as name from groupfile where '.$str;
			}else{
				$sql = 'select fid,name from userfile where '.$str;	
			}
			$query = $this->db->query($sql);

			$nl = array();
			foreach($query->result() as $row){
				array_push($nl,array(
						'id' => $row->fid,
						'name' => $row->name
					));
			}
			$data = array('fl' => $nl,'type' => 2,'gid' => $gid);
			$this->load->view('share/dep.php',$data);			
		}



	}