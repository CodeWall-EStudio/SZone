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

    public function redis()
    {
        $redis = new redis();
        $result = $redis->connect('127.0.0.1', 6379);
        var_dump($result); //结果：bool(true)
    }

    public function mongo()
    {
        $this->load->library('szmongo', array());
        $this->szmongo->dump();
    }

    public function cas1()
    {
        $this->load->library('phpCAS');

        // Enable debugging
        phpCAS::setDebug();

        // Initialize phpCAS
        phpCAS::client(CAS_VERSION_2_0, "dand.71xiaoxue.com", 80, "sso.web");

        //phpCAS::setFixedServiceURL('http://szone.codewalle.com/test/cas');

        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        // phpCAS::setCasServerCACert($cas_server_ca_cert_path);

        // For quick testing you can disable SSL validation of the CAS server.
        // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
        // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
        phpCAS::setNoCasServerValidation();

        var_dump(phpCAS::isAuthenticated());
    }

    public function cas()
    {
        $this->load->library('phpCAS');

        // Enable debugging
        phpCAS::setDebug();

        // Initialize phpCAS
        //phpCAS::proxy(CAS_VERSION_2_0, "dand.71xiaoxue.com", 80, "sso.web", FALSE);
        phpCAS::client(CAS_VERSION_2_0, "dand.71xiaoxue.com", 80, "sso.web");

        //phpCAS::setFixedServiceURL('http://szone.codewalle.com/test/cas');

        // For production use set the CA certificate that is the issuer of the cert
        // on the CAS server and uncomment the line below
        // phpCAS::setCasServerCACert($cas_server_ca_cert_path);

        // For quick testing you can disable SSL validation of the CAS server.
        // THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
        // VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
        phpCAS::setNoCasServerValidation();




        // force CAS authentication
        phpCAS::forceAuthentication();

        // at this step, the user has been authenticated by the CAS server
        // and the user's login name can be read with phpCAS::getUser().

        // logout if desired
        if (isset($_REQUEST['logout'])) {
            phpCAS::logout();
        }


        var_dump(phpCAS::getUser());

        var_dump(phpCAS::getAttributes());


    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./application/controllers/test.php */