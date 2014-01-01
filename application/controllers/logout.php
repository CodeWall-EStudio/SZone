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
class Logout extends CI_Controller {

    public function index(){
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

        phpCAS::forceAuthentication();

        phpCAS::logout();
    }

}

// END Controller class

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */