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

    public function cas()
    {
        $this->load->library('phpCAS');

///////////////////////////////////////
// Basic Config of the phpCAS client //
///////////////////////////////////////

// Full Hostname of your CAS Server
        $cas_host = 'dand.71xiaoxue.com';

// Context of the CAS Server
        $cas_context = '/sso.web';

// Port of your CAS server. Normally for a https server it's 443
        //$cas_port = 443;
        $cas_port = 80;

        $cas_server_ca_cert_path = '/path/to/cachain.pem';

        $curbase = 'http://' . $_SERVER['SERVER_NAME'];

        $curdir = dirname($_SERVER['REQUEST_URI']) . "/";

// CAS client nodes for rebroadcasting pgtIou/pgtId and logoutRequest
        $rebroadcast_node_1 = 'http://cas-client-1.example.com';
        $rebroadcast_node_2 = 'http://cas-client-2.example.com';

// access to a single service
        $serviceUrl = $curbase . $curdir . 'example_service.php';
// access to a second service
        $serviceUrl2 = $curbase . $curdir . 'example_service_that_proxies.php';

        $pgtBase = preg_quote(preg_replace('/^http:/', 'https:', $curbase . $curdir), '/');
        $pgtUrlRegexp = '/^' . $pgtBase . '.*$/';

        $cas_url = 'http://' . $cas_host;
        if ($cas_port != '443' && $cas_port != '80') {
            $cas_url = $cas_url . ':' . $cas_port;
        }
        $cas_url = $cas_url . $cas_context;

// Set the session-name to be unique to the current script so that the client script
// doesn't share its session with a proxied script.
// This is just useful when running the example code, but not normally.
        session_name(
            'session_for:'
            . preg_replace('/[^a-z0-9-]/i', '_', basename($_SERVER['SCRIPT_NAME']))
        );
// Set an UTF-8 encoding header for internation characters (User attributes)
        header('Content-Type: text/html; charset=utf-8');

        // Uncomment to enable debugging
        phpCAS::setDebug();



// Initialize phpCAS
        phpCAS::proxy(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

        phpCAS::setFixedServiceURL('http://szone.codewalle.com/test/cas');

// For production use set the CA certificate that is the issuer of the cert
// on the CAS server and uncomment the line below
// phpCAS::setCasServerCACert($cas_server_ca_cert_path);

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
        phpCAS::setNoCasServerValidation();
        phpCAS::setCasServerCACert($cas_server_ca_cert_path, false);

// force CAS authentication
        try {

            phpCAS::forceAuthentication();
        } catch(Exception $e) {
            var_dump($e);
        }

// at this step, the user has been authenticated by the CAS server
// and the user's login name can be read with phpCAS::getUser().

// logout if desired
        if (isset($_REQUEST['logout'])) {
            phpCAS::logout();
        }


    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./application/controllers/test.php */