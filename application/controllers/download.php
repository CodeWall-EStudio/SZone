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
class Download extends SZone_Controller {

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

        if (empty($gid))
        {
            if (empty($mid))
            {
                $auth = $this->File_model->get_by_uid($id, $this->user['id']);
                if (empty($auth))
                {
                    show_error('用户没有查看此文件的权限');
                }
            }
            else
            {
                $this->load->model('Mail_model');
                $auth = $this->Mail_model->check_auth($id, $mid,$this->user['id']);
                if (empty($auth))
                {
                    show_error('用户没有查看此文件的权限');
                }
                $auth = $this->File_model->get_by_uid($id, $auth);
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
        $fname =  iconv("utf-8","gb2312//IGNORE",$auth['name']);

        header('Content-type: '.$file['mimes']);
        header('Content-Disposition: attachment; filename='.$fname);
        header('Content-Length: '.$file['size']);
        header('X-Accel-Redirect: '.str_replace($this->config->item('path','upload'), '/file/', $file['path']));
    }

    public function test()
    {
        $id = $this->input->post('id');
        $this->load->model('File_model');
        $file = $this->File_model->get_by_id($id);
        if (empty($file))
        {
            show_error('文件不存在');
        }

        $auth = $this->File_model->get_by_uid($id, $this->user['id']);
        if (empty($auth))
        {
            show_error('用户没有查看此文件的权限');
        }

        $fname =  iconv("utf-8","gb2312//IGNORE",$auth['name']);

        header('Content-type: '.$file['mimes']);
        //header('Content-Disposition: attachment; filename='.$fname);
        //header('Content-Length: '.$file['size']);
        header('X-Accel-Redirect: '.str_replace($this->config->item('path','upload'), '/file/', $file['path']));
    }

    public function media(){
        $id = $this->input->get('id');
        $this->load->model('File_model');
        $file = $this->File_model->get_by_id($id);
        if (empty($file))
        {
            show_error('文件不存在');
        }

        /*$gid = $this->input->get('gid');
        $mid = $this->input->get('mid');

        if (empty($gid))
        {
            if (empty($mid))
            {
                $auth = $this->File_model->get_by_uid($id, $this->user['id']);
                if (empty($auth))
                {
                    show_error('用户没有查看此文件的权限');
                }
            }
            else
            {
                $this->load->model('Mail_model');
                $auth = $this->Mail_model->check_auth($id, $this->user['id'], $mid);
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
        }*/

        header('Content-type: '.$file['mimes']);
        header('X-Accel-Redirect: '.str_replace($this->config->item('path','upload'), '/file/', $file['path']));
    }

    public function review(){
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
                $auth = $this->File_model->get_by_uid($id, $this->user['id']);
                if (empty($auth))
                {
                    show_error('用户没有查看此文件的权限');
                }
            }
            else
            {
                $this->load->model('Mail_model');
                $auth = $this->Mail_model->check_auth($id,$mid, $this->user['id']);
                if (!$auth)
                {
                    show_error('用户没有查看此文件的权限');
                }
                $auth = $this->File_model->get_by_uid($id, $mid);
                // if (empty($auth))
                // {
                //     show_error('用户没有查看此文件的权限');
                // }
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
        
        //$path = $file['path'].'.swf';
        // $handle = fopen ($path, "r");
        // $data = "";
        // while (!feof($handle)) {
        //   $data .= fread($handle, 8192);
        // }
        // fclose($handle);
        // $this->load->helper('download');
        // force_download('review.swf', $data); 


        header('Content-type: application/x-shockwave-flash');
        // header('Content-Disposition: attachment; filename=review.swf');
        // header('Content-Length: '.$file['size']);
        header('X-Accel-Redirect: '.str_replace($this->config->item('path','upload'), '/file/', $file['path']).'.swf');

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
            $auth = $this->File_model->get_by_uid_ids($ids, $this->user['id']);
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
        $path = directory_zip($this->config->item('path', 'upload'), $err).$filename;

        //开始zip
        $zip = new ZipArchive();
        if($zip->open($path,ZIPARCHIVE::CREATE)!==TRUE){
            show_error('无法打开文件，或者文件创建失败');
        }
        for($i=0;$i<count($files);$i++){
            if(file_exists($files[$i]['path'])){
                if (empty($gid)) {
                    $realname = $auth[$i]['name'];
                    $realname =  iconv("utf-8","gb2312//IGNORE",$realname); 
                } else {
                    $realname = $auth[$i]['fname'];
                    $realname =  iconv("utf-8","gb2312//IGNORE",$realname); 
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