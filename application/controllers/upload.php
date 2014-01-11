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

        // 获取文件类型信息
        $this->config->load('filetypes', TRUE);
        $filetypes = $this->config->item('filetypes');

        // 收集文件信息
        $file = array(
            'md5' => $this->input->post('file_md5', TRUE),
            'tmp' => $this->input->post('file_path', TRUE),
            'mimes' => $this->input->post('file_content_type', TRUE),
            'size' => intval($this->input->post('file_size', TRUE))
        );

        $file['path'] = directory_time($this->config->item('path', 'upload'), $err);

        // 尝试检查文件路径
        if (!$file['path']) {
            $err = '无法创建文件，请联系管理员';
            $ret = array(
                'jsonrpc' => '2.0',
                'error' => array(
                    'code' => 1,
                    'message' => $err
                ),
            );
            log_message('ERROR', '503: [Server] '.$err);
            $this->json($ret, 503, $err);
            return;
        } else {
            $file['path'] .= $file['md5'];
        }

        // 判断用户是否登录
        if (!$this->skey) {
            $err = '登录失效，请重新登录';
            $ret = array(
                'jsonrpc' => '2.0',
                'error' => array(
                    'code' => 2,
                    'message' => $err
                ),
            );
            log_message('ERROR', '403: [User] '.$err);
            $this->json($ret, 403, $err);
            return;
        }

        // 判断用户空间容量
        $size = $this->user['real_size'];
        $used = $this->user['real_used'] + $file['size'];

        //判断文件是否存在
        $this->load->model('File_model');
        $file_info = $this->File_model->get_by_md5($file['md5']);

        // 获取文件相关信息
        $file_name = $this->input->post('file_name', TRUE);
        $fdid = $this->input->get('fid');
        //$prep = $this->input->get('prep');
        $is_media = $this->input->post('media');
        $gid = $this->input->get('gid');

        // 判断是否是来自新媒体教学的上传请求
        $fdid = $this->media($is_media, $fdid);

        log_message('DEBUG', 'File upload info － mimes: '. $file['mimes'].' name: '.$file_name);

        // 尝试上传文件
        $file_isnew = FALSE;
        if (empty($file_info)) {

            // 判断用户是否有足够上传空间
            if ($size < $used) {
                $err = '空间已经用完!';
                $ret = array(
                    'jsonrpc' => '2.0',
                        'error' => array(
                        'code' => 3,
                        'message' => $err
                    )
                );
                log_message('ERROR', '413: [User] '.$err);
                $this->json($ret, 413, $err);

                unlink($file['tmp']);
                return;
            }

            // 判断文件类型
            $file['type'] = format_type($file['mimes'], $file_name, $filetypes, $ext);
            if (!$ext) {
                log_message('INFO', '[Alarm] new file found: file md5 - '.$file['md5'].' file name - '.$file_name.' file mimes - '.$file['mimes']);
            }

            // 文件引用计数
            $file['ref'] = 1;

            rename($file['tmp'], $file['path']);
            unset($file['tmp']);
            $file['id'] = $this->File_model->insert_entry($file);
            $file_isnew = TRUE;

        } else {
            $file = $file_info;
            $err = '上传失败,已经有重名文件';
            if($gid>0){
                if($this->File_model->check_filename_by_gid($fdid,$gid,$file_name)){
                    $ret = array(
                        'jsonrpc' => '2.0',
                        'error' => array(
                            'code' => 4,
                            'message' => $err
                        )
                    );
                    log_message('ERROR', '409: [User] '.$err);
                    $this->json($ret, 409, $err);
                    return;
                }else{
                    $file['ref'] += 1;  
                }
            }else{
                if($this->File_model->check_filename_by_uid($fdid,$this->user['id'],$file_name)){
                    $ret = array(
                        'jsonrpc' => '2.0',
                        'error' => array(
                            'code' => 4,
                            'message' => $err
                        )
                    );
                    log_message('ERROR', '409: [User] '.$err);
                    $this->json($ret, 409, $err);
                    return;
                }else{
                    $file['ref'] += 1;  
                }
            }

        }

        $fdata = array(
            'fid' => $file['id'],
            'name' => $is_media == 1 ? $file['md5'].'.jpeg' : $file_name,
            'mark' => '',
            'uid' => $this->user['id'],
            'fdid' => $fdid
        );

        //如果是在小组或者备课中上传文件.把个人文件中的文件夹设为-1;
        if($gid>0){
            $fdata['fdid'] = -1;
        }

        //判断是否是在备课中上传
        // if($prep > 0){
        //     $fdata['fdid'] = -1;
        //     $fdata['prid'] = $fdid;
        // }else{
        //     $fdata['fdid'] = $fdid;
        // }

        // 增加用户的文件记录
        $result = $this->File_model->insert_user_entry($fdata);

        // 增加用户的空间使用
        if (intval($result) > 0) {
            $this->load->model('User_model');
            $this->User_model->update_used($this->user['id'], $used);
        }

        // 如果小组id不为空，则增加小组的文件记录
        if ($gid > 0 ) {
            $this->File_model->insert_group_entry(array(
                'fid' => $file['id'],
                'fdid' => $fdid,
                'gid' => $gid,
                'fname' => $file_name,
                'createtime' => time(),
                'uid' => $this->user['id'],
                'status' => 0
            ));
        }

        // 如果文件不是新上传的，则增加一次引用
        if (!$file_isnew) {
            $this->File_model->update_ref($file['id'], $file['ref']);
        }

        // 进行预览处理
        $this->convert($file['path'], $file['mimes'], $file_name, $filetypes);

        $ret = array(
            'fid' => $file['id'],
            'jsonrpc' => '2.0',
            'error' => array(
                'code' => 0,
                'message' => '上传成功!'
            )
        );
        $this->json($ret, 200, '上传成功!');
    }

    protected function convert($path, $mimes, $name, $types)
    {
        //判断是否为文档，如果是则加入消息队列
        if (ENVIRONMENT == 'testing' || ENVIRONMENT == 'production') {
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            // 转换文档为swf
            if (in_array($mimes, $types['mimes']['document']) || in_array($ext, $types['suffix']['document']))
            {
                exec('java -jar '.$this->config->item('jodconverter', 'upload').' '.$path.' '.$path.'.pdf');
                exec('pdf2swf '.$path.'.pdf -s flashversion=9 -o '.$path.'.swf');
            }
            // 转换pdf为swf
            if (in_array($mimes, $types['mimes']['pdf']) || in_array($ext, $types['suffix']['pdf']))
            {
                exec('pdf2swf '.$path.' -s flashversion=9 -o '.$path.'.swf');
            }
            // 生成图片缩略图
        }
    }

    protected function media($is_media, $fdid)
    {
        if ($is_media)
        {
            $fold_name = $this->config->item('name', 'media');
            $this->load->model('Fold_model');
            $fold = $this->Fold_model->get_user_fold_by_name($this->user['id'], $fold_name);

            if (count($fold) == 0) {
                $fold = array(
                    'pid' => 0,
                    'name' => $fold_name,
                    'uid' => $this->user['id'],
                    'mark' => '特殊目录',
                    'createtime' => time(),
                    'type' => 1
                );
                $fold['id'] = $this->Fold_model->insert_user_fold($fold);
                return $fold['id'];
            } else {
                $fold = $fold[0];
                return $fold->id;
            }
        }
        return $fdid;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
