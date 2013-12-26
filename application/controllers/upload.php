<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends SZone_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.comuploser_guide/general/urls.html
     */


    public function index() {

        //$fdid = (int) $this->input->get('fid');
        //$file_type = $this->config->item('filetype');
        //$allowed = array();
        //foreach($ft as $k => $item){
        //    array_push($allowed,$k);
        //}

        $file = array(
            'md5' => $this->input->post('file_md5', TRUE),
            'tmp' => $this->input->post('file_path', TRUE),
            'mimes' => $this->input->post('file_content_type', TRUE),
            'size' => intval($this->input->post('file_size', TRUE))
        );

        $file['path'] = directory_check($this->config->item('upload-path'), $file['md5'], $err);

        if (!$file['path']) {
            $ret = array(
                'jsonrpc' => '2.0',
                'error' => array(
                    'code' => 100,
                    'message' => $err
                ),
            );
            $this->json($ret,100,$err);
            return;
        } else {
            $file['path'] .= $file['md5'];
        }

        if ($this->user['id'] == 0) {
            $ret = array(
                'jsonrpc' => '2.0',
                'error' => array(
                    'code' => 100,
                    'message' => $err
                ),
            );
            $this->json($ret,100,'登录失效，请重新登录');
            return;
        }

        $size = $this->user['real_size'];
        $used = $this->user['real_used'] + $file['size'];

        //判断文件是否存在
        $this->load->model('File_model');
        $file_info = $this->File_model->get_by_md5($file['md5']);

        $file_isnew = FALSE;
        if (empty($file_info)) {

            if ($size < $used + $file['size']) {
                $ret = array(
                    'ret' => 103,
                    'msg' => '空间已经用完!'
                );
                $this->json($ret,103,'空间已经用完!');

                unlink($file['tmp']);
                return;
            }
            $file['type'] = format_type($file['mimes']);
            $file['ref'] = 1;

            rename($file['tmp'], $file['path']);
            unset($file['tmp']);
            $file['id'] = $this->File_model->insert_entry($file);
            $file_isnew = TRUE;

        } else {
            $file = $file_info;

            $user_file = $this->File_model->get_by_uid($file['id'], $this->user['uid']);

            if (!empty($user_file)) {
                $ret = array(
                    'jsonrpc' => '2.0',
                    'error' => array(
                        'code' => 101,
                        'message' => '上传失败,已经有重名文件'
                    )
                );
                $this->json($ret,101,'上传失败,已经有重名文件!');
                return;
            } else {
                $file['ref'] += 1;
            }

        }

        $file_name = $this->input->post('file_name', TRUE);

        $result = $this->File_model->insert_user_entry(array(
            'fid' => $file['id'],
            'name' => $file_name,
            'uid' => $this->user['uid'],
            'fdid' => intval($this->input->get('fid'))
        ));

        if (intval($result) > 0) {
            $this->load->model('User_model');
            $this->User_model->update_used($this->user['uid'], $used);

            if (!$file_isnew) {
                $this->File_model->update_ref($file['id'], $file['ref']);
            }
        }

        $gid = intval($this->input->get('gid'));
        if ($gid > 0 ) {
            $this->File_model->insert_group_entry(array(
                'fid' => $file['id'],
                'fdid' => intval($this->input->get('fid')),
                'gid' => $gid,
                'name' => $file_name,
                'uid' => $this->user['uid'],
                'status' => 0
            ));
        }

        $docs = array(
            'application/msword',
            'application/vnd.ms-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.openxmlformats-officedocument.presentationml.template',
            'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'application/kswps'
        );
        $pdfs = array('application/pdf');

        //判断是否为文档，如果是则加入消息队列
        if (ENVIRONMENT == 'testing') {
            if (in_array($file['mimes'],$docs))
            {
                exec('java -jar /var/run/jodconverter/lib/jodconverter-core-3.0-beta-4.jar '.$file['path'].' '.$file['path'].'.pdf');
                exec('pdf2swf '.$file['path'].'.pdf -s flashversion=9 -o '.$file['path'].'.swf');
            }
            if (in_array($file['mime'],$pdfs))
            {
                exec('pdf2swf '.$file['path'].' -s flashversion=9 -o '.$file['path'].'.swf');
            }
        }

        $ret = array(
            'jsonrpc' => '2.0',
            'error' => array(
                'code' => 0,
                'message' => '上传成功!'
            )
        );
        $this->json($ret,101,'上传成功!');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
