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
			$sql = 'select * from groups';
			$query = $this->db->query($sql);

			foreach($query->result() as $row){
				if($row->type == 1){
					array_push($this->grouplist,array(
						'id' => $row->id,
						'name' => $row->name,
						'parent' => $row->parent
					));
				}elseif($row->type == 2){
					array_push($this->deplist,array(
						'id' => $row->id,
						'name' => $row->name
					));
				}
			}
        }    
	    
	}
?>
