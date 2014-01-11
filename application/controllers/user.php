<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SZone Application Controller Class
 *
 * This class object extends from the CodeIgniter super class CI_Controller.
 * 
 * @package		SZone
 * @subpackage	application
 * @category	controllers
 * @author		Code Wall-E Studio
 * @link		http://codewalle.com
 */
class User extends SZone_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->session->set_userdata('state','123345');
        //$this->session->userdata('uid');
        echo $this->session->userdata('state');
    }

    public function info()
    {
        echo $this->session->userdata('state');
        //$this->json($this->user);
    }

    public function mix()
    {
        $this->config->load('filetypes', TRUE);
        $filetype = $this->config->item('filetypes');
        $this->json($filetype);
    }
}
// END Controller class

/* End of file user.php */
/* Location: ./application/controllers/user.php */