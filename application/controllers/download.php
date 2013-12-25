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
class Download extends CI_Controller {

    public function index()
    {
        $this->user['uid'] = intval($this->session->userdata('uid'));
        if ($this->user['uid'] != 0)
        {
            $this->load->model('User_model');
            $this->user = $this->User_model->get_by_id($this->user['uid']);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }

        $id = $this->input->get('id');
        $this->load->model('File_model');
        $file = $this->File_model->get_by_id($id);
        if (empty($file))
        {
            show_error('文件不存在');
        }

        $gid = $this->input->get('gid');
        $mid = $this->input->get('mid');

        if (empty($gid))
        {
            if (empty($mid))
            {
                $auth = $this->File_model->get_by_uid($id, $this->user['uid']);
                if (empty($auth))
                {
                    show_error('用户没有查看此文件的权限');
                }
            }
            else
            {
                $this->load->model('Mail_model');
                $auth = $this->Mail_model->check_auth($id, $this->user['uid'], $mid);
                if (empty($auth))
                {
                    show_error('用户没有查看此文件的权限');
                }
                $auth = $this->File_model->get_by_uid($id, $mid);
                if (empty($auth))
                {
                    show_error('用户没有查看此文件的权限');
                }
            }
        }
        else
        {
            $auth = $this->File_model->get_by_gid($id, $gid);
            if (empty($auth))
            {
                show_error('用户没有查看此文件的权限');
            }
            $auth['name'] = $auth['fname'];
        }


        header('Content-type: '.$file['mimes']);
        header('Content-Disposition: attachment; filename='.$auth['name']);
        header('Content-Length: '.filesize($file['size']));
        header('X-Accel-Redirect: /file/'.substr($file['md5'],0,2).'/'.substr($file['md5'],2,2).'/'.$file['md5']);

    }

    public function batch()
    {
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename=download.zip');
        header('Content-Length: '.filesize($file['size']));
        header('X-Accel-Redirect: /file/'.substr($file['md5'],0,2).'/'.substr($file['md5'],2,2).'/'.$file['md5']);
    }
}

// END Controller class

/* End of file download.php */
/* Location: ./application/controllers/download.php */