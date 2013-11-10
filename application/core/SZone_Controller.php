<?php

	class SZone_Controller extends CI_Controller {

		protected $user = array();
		protected $grouplist = array();
		protected $deplist = array();  
		protected $controller_name;  
        protected $action_name; 		

	    public function __construct(){
	        parent::__construct();
	        $this->set_user();
	        $this->set_group();
	        date_default_timezone_set('PRC');
	    }

       	protected function set_user(){
	        $name = $this->session->userdata('name');
	        $nick = $this->session->userdata('nick');
	        $auth = $this->session->userdata('auth');
	        $userid = $this->session->userdata('userid');


	        $redirect = $this->uri->uri_string();

	        if ( $_SERVER['QUERY_STRING']){
				$redirect .= '?'.$_SERVER['QUERY_STRING'];
	        }
	       
	        if(!$name){
	        	redirect('/login/connect?redirect='.$redirect);
	        	return;
	        }

	        $this->user['name'] = $name;
	        $this->user['nick'] = $nick;
	        $this->user['auth'] = $auth;
	        $this->user['userid'] = $userid;
        }	

        protected function set_group(){
        	$sql = 'select gid from groupuser where uid='.(int) $this->user['userid'].' and auth>0';
        	$query = $this->db->query($sql);
        	$gidlist = array();

        	foreach($query->result() as $row){
        		array_push($gidlist,$row->gid);
        	}
			$sql = 'select * from groups';
			$query = $this->db->query($sql);

			//gid列表
			$flist = array();
			$glist = array();
			$idlist = array();
			foreach($query->result() as $row){
				if($row->type == 1){
					if($row->parent == 0){
						$flist[$row->id] = array(
							'id' => $row->id,
							'name' => $row->name,
							'parent' => $row->parent,
							'auth' => in_array($row->id,$gidlist),
							'list' => array()
						);
					}else{
						$glist[$row->id] = array(
							'id' => $row->id,
							'name' => $row->name,
							'parent' => $row->parent,
							'auth' => in_array($row->id,$gidlist)
						);						
						// array_push($glist,array(
						// 	'id' => $row->id,
						// 	'name' => $row->name,
						// 	'parent' => $row->parent,
						// 	'auth' => in_array($row->id,$gidlist)
						// ));
					}
				}elseif($row->type == 2){
					array_push($this->deplist,array(
						'id' => $row->id,
						'name' => $row->name
					));
				}
				//array_push($idlist,'gid="'.$row->id.'"');
			};

			foreach($glist as $k => $r){
				array_push($flist[$r['parent']]['list'],$r);

			}
			$this->grouplist = $flist;
        }    
	    
	}
?>