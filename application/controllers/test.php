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
class Test extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        show_error('test');
        //var_dump($this->config);
        //$this->load->helper('directory');
        //directory_acquire(ROOTPATH.'file');
    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./application/controllers/test.php */