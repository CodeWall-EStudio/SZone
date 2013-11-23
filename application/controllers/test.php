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
        $err = '';
        directory_acquire(
            $this->config->item('upload-path'),
            md5($this->config->item('upload-path')),
            $this->config->item('dir-file-num'),
            $err
        );

        $this->load->model('User_model');
        $query = $this->User_model->get_where();
        //var_dump($query->results());

    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./application/controllers/test.php */