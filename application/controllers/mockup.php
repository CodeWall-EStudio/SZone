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
class Mockup extends SZone_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->config->load('filetypes', TRUE);
        $filetype = $this->config->item('filetypes');
        var_dump($filetype);
    }

    public function ext()
    {
        echo pathinfo('dafasdfas.jpg', PATHINFO_EXTENSION);
    }
}
// END Controller class

/* End of file mockup.php */
/* Location: ./application/controllers/mockup.php */