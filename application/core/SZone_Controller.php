<?php

	class SZone_Controller extends CI_Controller {

		protected $user = array();  
		protected $controller_name;  
        protected $action_name; 		

	    public function __construct(){
	        parent::__construct();
	        $this->set_user();
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
	    
	}
?>