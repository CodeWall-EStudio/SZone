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
        echo 'Hello World！';
    }

    public function info()
    {
        $this->json($this->user);
    }
}
// END Controller class

/* End of file user.php */
/* Location: ./application/controllers/user.php */