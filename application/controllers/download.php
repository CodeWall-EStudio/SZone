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

    protected $user = array();

    function __construct()
    {
        parent::__construct();
        $this->set_user();
    }

    protected function set_user()
    {
        $this->user['uid'] = $this->session->userdata('uid');
        if (!empty($this->user['uid']))
        {
            $this->load->model('User_model');
            $this->user = $this->User_model->get_by_id($this->user['uid']);
        }
        else
        {
            $this->session->sess_destroy();
            redirect('/');
        }
    }

    public function index()
    {
        $id = $this->input->get('id');
        $this->load->model('File_model');
        $file = $this->File_model->get_by_id($id);
        if (empty($file))
        {
            show_error('文件不存在');
        }

        $gid = $this->input->get('gid');
        $mid = $this->input->get('mid');
        $review = $this->input->get('rv');

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

        $path = '/file/'.substr($file['md5'],0,2).'/'.substr($file['md5'],2,2).'/'.$file['md5'];
        $mimes = $file['mimes'];
        $size = $file['size'];
        $filaname = $auth['name'];
        if($review){
            $path .= '.swf';
            $filaname = 'review.swf';
            $mimes = 'application/x-shockwave-flash';
            $size = filesize($file['path'].'.swf');
        }

        header('Content-type: '.$mimes);
        header('Content-Disposition: attachment; filename='.$filaname);
        header('Content-Length: '.$size);
        header('X-Accel-Redirect: '.$path);
        // header('Content-type: '.$file['mimes']);
        // header('Content-Disposition: attachment; filename='.$auth['name']);
        // header('Content-Length: '.$file['size']);
        // header('X-Accel-Redirect: /file/'.substr($file['md5'],0,2).'/'.substr($file['md5'],2,2).'/'.$file['md5']);
    }

    public function batch()
    {
        $ids = $this->input->post('ids');

        $this->load->model('File_model');
        $files = $this->File_model->get_by_ids($ids);
        if (empty($files))
        {
            show_error('文件不存在');
        }

        $gid = $this->input->post('gid');

        if (empty($gid))
        {
            $auth = $this->File_model->get_by_uid_ids($ids, $this->user['uid']);
            if (empty($auth))
            {
                show_error('用户没有查看此文件的权限');
            }
        }
        else
        {
            $auth = $this->File_model->get_by_gid_ids($ids, $gid);
            if (empty($auth))
            {
                show_error('用户没有查看此文件的权限');
            }
        }

        //创建目录
        $filename = rand(100000, 999999).'.zip';
        $filepath = '/file/zip/'.date("Y-m-d").'/'.$filename;
        $path = directory_zip($this->config->item('upload-path'), $err).$filename;

        //开始zip
        $zip = new ZipArchive();
        if($zip->open($path,ZIPARCHIVE::CREATE)!==TRUE){
            show_error('无法打开文件，或者文件创建失败');
        }
        for($i=0;$i<count($files);$i++){
            if(file_exists($files[$i]['path'])){
                if (empty($gid)) {
                    $realname = $auth[$i]['name'];
                } else {
                    $realname = $auth[$i]['fname'];
                }
                $zip->addFile($files[$i]['path'], $realname);
            }
        }
        $zip->close();//关闭
        if(!file_exists($path)){
            show_error('无法找到文件');           //即使创建，仍有可能失败
        }

        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename=files.zip');
        header('Content-Length: '.filesize($path));
        header('X-Accel-Redirect: '.$filepath);
    }
}

// END Controller class

/* End of file download.php */
/* Location: ./application/controllers/download.php */