<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cgi extends SZone_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function addfold(){
		$name = $this->input->post('name');
		$pid = (int) $this->input->post('pid');
		$gid = (int) $this->input->post('gid');

		$tablename = 'userfolds';
		if($gid){
			$tablename = 'groupfolds';
		};

		// $sql = 'select id,pid,tid,idpath from '.$tablename.' where id='.$pid;
		// $query = $this->db->query($sql);
		// $row = $query->row();

		$sql = 'select id from '.$tablename.' where pid='.$pid.' and name ="'.$name.'"';
		if($gid){
			$sql .= ' and gid = '.(int) $this->user['uid'];
		}else{
			$sql .= ' and uid = '.(int) $this->user['uid'];
		}
		$query = $this->db->query($sql);
		if($query->num_rows() == 0){
			$tid = 0;
			$idpath = 0;
			if($pid){
				$sql = 'select id,pid,tid,idpath from '.$tablename.' where id='.$pid;
				$query = $this->db->query($sql);
				$row = $query->row(); 
				if($row->tid != 0){
					$tid = $row->tid;
					$idpath = $row->idpath.','.$pid;
				}else if($row->pid == 0){
					$tid = $pid;
					$idpath = $pid;
				}
			}
			if($gid){
				$data = array(
					'pid' => $pid,
					'name' => $name,
					'gid' => $gid,
					'mark' => '',
					'createtime' => time(),
					'type' => 0,
					'tid' => $tid,
					'idpath' => $idpath
				);
			}else{
				$data = array(
					'pid' => $pid,
					'name' => $name,
					'uid' => $this->user['uid'],
					'mark' => '',
					'createtime' => time(),
					'type' => 0,
					'tid' => $tid,
					'idpath' => $idpath
				);
			}
			$str = $this->db->insert_string($tablename,$data);
			$query = $this->db->query($str);
			if($this->db->insert_id()){
				$list = array(
					'ret' => 0,
					'msg' => '插入成功!'
				);
				$this->json($list,0,'插入成功!');
			}else{
				$list = array(
					'ret' => 2,
					'msg' => '插入失败!'
				);
				$this->json($list,100,'插入失败!');
			}
			//echo $str;
		}else{
			$list = array(
				'ret' => 1,
				'msg' => '已经有同名的目录了!'
			);
			$this->json($list,103,'已经有同名的目录了!');
		}
		// $this->output
		//     ->set_content_type('application/json')
		//     ->set_output(json_encode($list));		
	}

    public function gupload(){
        $field_name = "file";

        $fdid = (int) $this->input->get('fid');
        //$this->config->load('szone');
        $gid = (int) $this->input->get('gid');
        $ft = $this->config->item('filetype');
        $md5 =  md5_file($_FILES['file']['tmp_name']);
        $nowdir = $this->getDir($md5);

        $allowed = array();
        foreach($ft as $k => $item){
            array_push($allowed,$k);
        }

		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

		if($chunks>1){
			$oname = $this->input->post('name');
			$config['chunks'] = 1;
			if($this->session->userdata('user_upload_file') && $oname == $this->session->userdata('user_upload_file_name')){
				$nowdir = $this->session->userdata('user_upload_file_tmp');
			}else{
				$this->session->set_userdata('user_upload_file_name',$oname);
				$this->session->set_userdata('user_upload_file',$nowdir);	
				$nowdir .='/tmp/';
				$this->session->set_userdata('user_upload_file_tmp',$nowdir);	
			}
		}
        $config['upload_path'] = $nowdir;
        $config['allowed_types'] = implode('|',$allowed);//;'gif|jpg|png';
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        $this->load->library('szupload', $config);

        if ( ! $this->szupload->do_upload($field_name)){
            $ret = array(
                'jsonrpc' => '2.0',
                'error' => array(
                    'code' => 100,
                    'message' => '上传失败'
                ),
            );
            $this->json($ret,100,'上传失败');
            return;
            // $this->output
            //     ->set_content_type('application/json')
            //     ->set_output(json_encode($list));
        }else{

            $sql = 'select size,used from user where id='.(int) $this->user['uid'];
            $query = $this->db->query($sql);
            $size = 0;
            $used = 0;
            if ($query->num_rows() > 0){
                $row = $query->row();

                $size = $row->size;
                $used = $row->used;
            }
            //$filedata = $this->upload->data();
            $filedata = $this->szupload->data();

            //判断是否存在相同的文件
            $sql = 'select id,size from files where md5="'.$md5.'"';
            $query = $this->db->query($sql);

            //有同名
            if ($query->num_rows() > 0){
                $row = $query->row();
                $fid = $row->id;
                $used += $row->size;
            }else{
                $data = array(
                    'path' => $filedata['full_path'],
                    'size' => $filedata['file_size']*1024,
                    'md5' => $md5,
                    //'type' => $filedata['is_image'],
                    'mimes' => $filedata['file_type'],
                    'del' => 0
                );
                if($filedata['is_image']){
                    $data['type'] = 1;
                }else{
                    $type =  substr($filedata['file_ext'],1);
                    $data['type'] = $ft[$type];
                }

                //echo $filedata['file_type'].'&&'.$filedata['image_type'];

                if($size < $used + $filedata['file_size']){
                    $ret = array(
                        'ret' => 103,
                        'msg' => '空间已经用完!'
                    );
                    $this->json($ret,103,'空间已经用完!');
                    // $this->output
                    //     ->set_content_type('application/json')
                    //     ->set_output(json_encode($ret));
                    return;
                }

                $sql = $this->db->insert_string('files',$data);
                //把文件写入数据库
                $query = $this->db->query($sql);
                $fid = $this->db->insert_id();
                $used += $filedata['file_size'];
            }

            $gd = array(
                'fid' => $fid,
                'fdid' => $fdid,
                'gid' => $gid,
                'fname' => $filedata['raw_name'],
                'createtime' => time(),
                'del' => 0,
                'uid' => (int) $this->user['uid'],
                'status' => 0
            );

            $sql = $this->db->insert_string('groupfile',$gd);
            $query = $this->db->query($sql);
            if($this->db->affected_rows() == 0){
                $ret = array(
                    'jsonrpc' => '2.0',
                    'error' => array(
                        'code' => 102,
                        'message' => '上传失败!'
                    )
                );
                $this->json($ret,103,'空间已经用完!');
                return;
                // $this->output
                //     ->set_content_type('application/json')
                //     ->set_output(json_encode($list));
                // return;
            }


            $sql = 'select id from userfile where fid='.$fid.' and uid='.(int) $this->user['uid'];
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
                $row = $query->row();
                    $ret = array(
                        'jsonrpc' => '2.0',
                        'error' => array(
                            'code' => 0,
                            'message' => '上传成功!'
                        )
                    );
                $this->json($ret,0,'上传成功!');
                return;
            }

            $data = array(
                'fid' => (int) $fid,
                'name' => $filedata['raw_name'],
                'uid' => (int) $this->user['uid'],
                'del' => 0,
                'fdid' => $fdid
            );
            $sql = $this->db->insert_string('userfile',$data);
            $query = $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $data = array(
                    'used' => $used
                );
                $sql = $this->db->update_string('user',$data,' id='.(int) $this->user['uid']);
                $query = $this->db->query($sql);
                if($this->db->affected_rows() > 0){
                    $ret = array(
                        'jsonrpc' => '2.0',
                        'error' => array(
                            'code' => 0,
                            'message' => '上传成功!'
                        )
                    );
	                $this->json($ret,0,'上传成功!');
	                return;                    
                }else{
                    $ret = array(
                        'jsonrpc' => '2.0',
                        'error' => array(
                            'code' => 102,
                            'message' => '上传失败!'
                        )
                    );
	                $this->json($ret,102,'上传失败!');
	                return;                      
                }

            }else{
                $ret = array(
                    'jsonrpc' => '2.0',
                    'error' => array(
                        'code' => 102,
                        'message' => '上传失败!'
                    )
                );
	                $this->json($ret,102,'上传失败!');
	                return;                                     
            }
            // $this->output
            //     ->set_content_type('application/json')
            //     ->set_output(json_encode($list));
        }
    }

	public function upload(){

		$field_name = "file";

        $fdid = (int) $this->input->get('fid');
        //$this->config->load('szone');
        $ft = $this->config->item('filetype');
        $md5 =  md5_file($_FILES['file']['tmp_name']);
        $nowdir = $this->getDir($md5);

        $allowed = array();
        foreach($ft as $k => $item){
            array_push($allowed,$k);
        }

		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

		if($chunks>1){
			$oname = $this->input->post('name');
			$config['chunks'] = 1;
			if($this->session->userdata('user_upload_file') && $oname == $this->session->userdata('user_upload_file_name')){
				$nowdir = $this->session->userdata('user_upload_file_tmp');
			}else{
				$this->session->set_userdata('user_upload_file_name',$oname);
				$this->session->set_userdata('user_upload_file',$nowdir);	
				$nowdir .='/tmp';
				$this->session->set_userdata('user_upload_file_tmp',$nowdir);	
			}
		}

        $config['upload_path'] = $nowdir;
        $config['allowed_types'] = implode('|',$allowed);//;'gif|jpg|png';
        $config['overwrite'] = true;
        $this->load->library('upload', $config);

        $this->load->library('szupload', $config);

		//if ( ! $this->upload->do_upload($field_name)){
		if ( ! $this->szupload->do_upload($field_name)){			
			$ret = array(
				'jsonrpc' => '2.0',
				'error' => array(
					'code' => 100,
					'message' => '上传失败'
				),
			);
			$this->json($ret,100,'上传失败');
			return;
			// $this->output
			//     ->set_content_type('application/json')
			//     ->set_output(json_encode($list));			
		}else{

            $sql = 'select size,used from user where id='.(int) $this->user['uid'];
            $query = $this->db->query($sql);
            $size = 0;
            $used = 0;
            if ($query->num_rows() > 0){
                $row = $query->row();

                $size = $row->size;
                $used = $row->used;
            }

            //$filedata = $this->upload->data();
            $filedata = $this->szupload->data();

			//判断是否存在相同的文件
			$sql = 'select id,size from files where md5="'.$md5.'"';
			$query = $this->db->query($sql);

			if ($query->num_rows() > 0){
				$row = $query->row();
				$fid = $row->id;
				$used += $row->size;
			}else{
				$data = array(
					'path' => $filedata['full_path'],
					'size' => $filedata['file_size'],
					'md5' => $md5,
					//'type' => $filedata['is_image'],
					'mimes' => $filedata['file_type'],
					'del' => 0
				);
				if($filedata['is_image']){
					$data['type'] = 1;
				}else{
					$type =  substr($filedata['file_ext'],1);
					$data['type'] = $ft[$type];					
				}

				//echo $filedata['file_type'].'&&'.$filedata['image_type'];
				if($size < $used + $filedata['file_size']){
					$ret = array(
						'ret' => 103,
						'msg' => '空间已经用完!'
					);

					$this->json($ret,103,'空间已经用完!');
					return;
				}

				$sql = $this->db->insert_string('files',$data);
				//把文件写入数据库
				$query = $this->db->query($sql);
				$fid = $this->db->insert_id();
				$used += $filedata['file_size'];
			}
			

			$sql = 'select id from userfile where fid='.$fid.' and uid='.(int) $this->user['uid'];
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0){
				$row = $query->row();
				$ret = array(
					'jsonrpc' => '2.0',
					'error' => array(
						'code' => 101,
						'message' => '上传失败,已经有重名文件'
					),
					'id' => $row->id
				);
					$this->json($ret,101,'上传失败,已经有重名文件!');
					return;
			}

			$data = array(
				'fid' => (int) $fid,
				'name' => $filedata['raw_name'],
				'uid' => (int) $this->user['uid'],
				'del' => 0,
				'fdid' => $fdid
			);
			$sql = $this->db->insert_string('userfile',$data);
			$query = $this->db->query($sql);

			if($this->db->affected_rows() > 0){
				$data = array(
					'used' => $used
				);
				$sql = $this->db->update_string('user',$data,' id='.(int) $this->user['uid']);
				$query = $this->db->query($sql);
				if($this->db->affected_rows() > 0){
					$ret = array(
						'jsonrpc' => '2.0',
						'error' => array(
							'code' => 0,
							'message' => '上传成功!'
						)
					);
					$this->json($ret,101,'上传失败,已经有重名文件!');
					return;					
				}else{
					$ret = array(
						'jsonrpc' => '2.0',
						'error' => array(
							'code' => 102,
							'message' => '上传失败!'
						)
					);
					$this->json($ret,102,'上传失败!');
					return;
				}
							
			}else{
				$ret = array(
					'jsonrpc' => '2.0',
					'error' => array(
						'code' => 102,
						'message' => '上传失败!'
					)
				);
					$this->json($ret,102,'上传失败!');
					return;				
			}
			// $this->output
			//     ->set_content_type('application/json')
			//     ->set_output(json_encode($list));							
		}
	}

	protected function getDir($md5){
		//$this->config->load('szone');

        $uploadpath = $this->config->item('upload-path');
        if(!is_dir($uploadpath)){
            mkdir($uploadpath,DIR_WRITE_MODE);
            chmod($uploadpath,DIR_WRITE_MODE);
        }

        //echo implode('|',$allowed);
        $dirname = $uploadpath.substr($md5,0,2);
        if (!is_dir($dirname)){
            mkdir($dirname,DIR_WRITE_MODE);
            chmod($dirname,DIR_WRITE_MODE);
        }

        $dirname = $dirname.'/'.substr($md5,2,2);
        if (!is_dir($dirname)){
            mkdir($dirname,DIR_WRITE_MODE);
            chmod($dirname,DIR_WRITE_MODE);
        }

        return $dirname;
	}	

	//修改备注
	public function editmark(){
		$t = $this->input->post('t');
		$fid = $this->input->post('id');
		$info = $this->input->post('info');

		if($t == 'fold'){
			$tname = 'userfolds';
			$fname = 'mark';
		}else{
			$tname = 'userfile';
			$fname = 'content';
		};

		$data = array(
			$fname => $info
		);

		$sql = 'select id from '.$tname.' where id='.$fid.' and uid='.(int) $this->user['uid'];
		$query = $this->db->query($sql);
		if($query->num_rows() == 0){
			$ret = array(
				'ret' => 101,
				'msg' => '没有查到文件!'
			);
		}else{
			$str = $this->db->update_string($tname,$data,'id='.$fid.' and uid='.(int) $this->user['uid']);
			$query = $this->db->query($sql);
			if($this->db->affected_rows()>0){
				$ret = array(
					'ret' => 0,
					'info' => $info,
					'msg' => '修改成功!'
				);
					$this->json($ret,0,'修改成功!');
					return;				
			}else{
				$ret = array(
					'ret' => 102,
					'msg' => '修改失败!'
				);
					$this->json($ret,102,'修改失败!');
					return;				
			}
		}
	}

	//移动文件
	public function movefile(){
		$tid = $this->input->post('tid');
		$fid = $this->input->post('fid');

		$data = array(
			'fdid' => $tid
		);
		$sql = $this->db->update_string('userfile',$data,'id ='.$fid);
		$query = $this->db->query($sql);

		if($this->db->affected_rows()>0){
			$ret = array(
				'ret' => 0,
				'msg' => '更新成功!'
			);
					$this->json($ret,0,'更新成功!');
					return;				
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '更新失败!'
			);
					$this->json($ret,100,'更新失败!');
					return;				
		}
		// $this->output
		//     ->set_content_type('application/json')
		//     ->set_output(json_encode($ret));
	}

	//收藏文件
	public function addcoll(){
		$id = $this->input->post('id');
		$idlist = explode(',',$id);
		$w = array();
		foreach($idlist as $k){
			array_push($w,'fid='.(int) $k);
		};
		$wh = implode(' or ',$w);
		//echo $wh;
		$sql = 'select fid from usercollection where '.$wh .' and uid='.(int) $this->user['uid'];
		$query = $this->db->query($sql);

		//有已经收藏过的文件
		$dlist = array();
		if($this->db->affected_rows()>0){
			$fidlist = array();

			foreach($query->result() as $row){
				array_push($fidlist,$row->fid);
			}

			foreach($idlist as $k){
				if(!in_array($k,$fidlist)){
					array_push($dlist,'('.(int) $this->user['uid'].','.(int) $k.','.time().')');
				}				
			}
		}else{		
			foreach($idlist as $k){
				array_push($dlist,'('.(int) $this->user['uid'].','.(int) $k.','.time().')');
			}
		}

		if(count($dlist)==0){
			$ret = array(
				'ret' => 102,
				'msg' => '插入失败,已经有重复的记录!'
			);
			$this->json($ret,100,'插入失败,已经有重复的记录!');
			return;				
		}
		$sql = 'insert into usercollection (uid,fid,time) value '.implode(',',$dlist);
		$query = $this->db->query($sql);
			
		if($this->db->affected_rows()>0){
			$ret = array(
				'ret' => 0,
				'id' => $this->db->insert_id(),
				'msg' => '收藏成功!'
			);
					$this->json($ret,0,'收藏成功!');
					return;				
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '插入失败!'
			);
					$this->json($ret,100,'插入失败!');
					return;				
		}			
		
	}

	//取消搜藏文件
	public function uncoll(){
		$id = $this->input->post('id');
		$idlist = explode(',',$id);
		$w = array();
		foreach($idlist as $k){
			array_push($w,'fid='.(int) $k);
		};

		$wh = implode(' or ',$w);
		$sql = 'delete from usercollection where uid='.(int) $this->user['uid'].' and '.$wh;
		$query = $this->db->query($sql);

		if($this->db->affected_rows()>0){
			$ret = array(
				'ret' => 0,
				'id' => $this->db->insert_id(),
				'msg' => '收藏成功!'
			);
					$this->json($ret,0,'收藏成功!');
					return;				
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '插入失败!'
			);
					$this->json($ret,100,'插入失败!');
					return;				
		}	
		// $this->output
		//     ->set_content_type('application/json')
		//     ->set_output(json_encode($ret));
	}

	public function getgroup(){
		$key = $this->input->post('key');
		$type = (Int) $this->input->post('type');
		$gid = (int) $this->input->post('gid');


		$sql = 'select id,name,parent from groups where name like "%'.$key.'%" and id !='.$gid.' and type='.$type;
		$query = $this->db->query($sql);
		$glist = array();
		$gi = array();
		foreach($query->result() as $row){
			// if($row->parent == 0){
			// 	// $gi[$row->id] = array(
			// 	// 	'id' => $row->id,
			// 	// 	'name' => $row->name,
			// 	// 	'pid' => $row->parent
			// 	// );
			// 	$glist[$row->id] = array(
			// 		'id' => $row->id,
			// 		'name' => $row->name,
			// 		'pid' => $row->parent
			// 	);		
			// 	echo $row->name;		
			// }else if($type == 1){
				// if(!isset($glist[$row->parent]['list'])){
				// 	$glist[$row->parent]['list'] = array();
				// 	//echo json_encode($glist);
				// }
				$glist[$row->id] = array(
					'id' => $row->id,
					'name' => $row->name,
					'pid' => $row->parent
				);
			//}
		}
		// if($type ==1 ){
		// 	foreach($glist as $row){
		// 		if($row['pid']){
		// 			if(!isset($gi[$row['pid']]['list'])){
		// 				$gi[$row['pid']]['list'] = array();
		// 			}
		// 			array_push($gi[$row['pid']]['list'],$row);
		// 		}
		// 	}
		// 	$glist = $gi;			
		// }
		$ret = array(
			'ret' => 0,
			'list' => $glist
		);
					$this->json($ret,0,'ok');
					return;			
			// $this->output
			//     ->set_content_type('application/json')
			//     ->set_output(json_encode($ret));		
	}

	//取用户列表
	public function getuser(){
		$key = $this->input->post('key');
		$gid = (int) $this->input->post('gid');

		//echo json_encode($this->user);
		//if($gid){
		//	$sql = 'select a.id,a.name,a.nick from user a left join groupuser b on b.gid='.$gid.' where a.id != b.uid group by a.id';
		//}else{
			$sql = 'select id,name,nick from user where name like "%'.$key.'%" and id != '.$this->user['uid'];
		//}

		$query = $this->db->query($sql);
		$list = array();
		foreach($query->result() as $row){
			array_push($list,array(
				'id' => $row->id,
				'name' => $row->name,
				'nick' => $row->nick
			));
		}
		if(count($list) > 0){
			$ret = array(
				'ret' => 0,
				'list' => $list
			);
		}
					$this->json($ret,0,'ok');
					return;			
		// $this->output
		//     ->set_content_type('application/json')
		//     ->set_output(json_encode($ret));
	}

	public function addgroupshare(){
		$id = $this->input->post('id');  //分组id
		$fid = $this->input->post('flist'); //文件id
		$type = $this->input->post('type'); //类型 0 用户到用户 1 到小组 2到部门
		$gid = $this->input->post('gid'); //用户发起还是在小组发起
		$content = $this->input->post('content');
		

		$cache = array();

		//取id
		$kl = array();
		foreach($id as $k){		
			$cache[$k] = array();
		}
		foreach($fid as $k){
			array_push($kl,' id='.$k);			
		}
		$str = implode(' or ',$kl);
		$sql = 'select id,name from userfile where '.$str;
		$query = $this->db->query($sql);
		$nl = array();
		foreach($query->result() as $row){
			$nl[$row->id] = $row->name;
		};

		$sql = 'select fid,gid from groupfile where uid='.$this->user['uid'];
		$query = $this->db->query($sql);

		foreach($query->result() as $row){
			if(isset($cache[$row->gid])){
				array_push($cache[$row->gid],$row->fid);
			}
		}	
		$key = array();
		$time = time();		
		foreach($id as $k){
			foreach($fid as $i){
				if(!in_array($i,$cache[$k])){
	array_push($key,'('.$i.','.$k.','.$time.',"'.$nl[$i].'",'.'"'.$content.'",'.$this->user['uid'].','.$gid.')');	
				}
			}
		}
		if(count($key)>0){
			$sql = 'insert into groupfile (fid,gid,createtime,fname,content,uid,fgid) value '.implode(',',$key);
			$query = $this->db->query($sql);
			if($this->db->affected_rows()>0){
				$ret = array(
					'ret' => 0,
					'msg' => '添加成功!'
				);
					$this->json($ret,0,'添加成功!');
					return;					
			}else{
				$ret = array(
					'ret' => 101,
					'msg' => '添加失败!'
				);
					$this->json($ret,101,'添加失败!');
					return;					
			}
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '不能重复添加'
			);
					$this->json($ret,100,'不能重复添加!');
					return;					
		}
		// $this->output
		//     ->set_content_type('application/json')
		//     ->set_output(json_encode($ret));
	}

	public function addshare(){
		//date_default_timezone_set('PRC');
		$id = $this->input->post('id');  //用户id
		$fid = $this->input->post('flist'); //文件id
		$type = $this->input->post('type'); //类型 0 用户到用户 1 到小组 2到部门
		$gid = (Int) $this->input->post('gid'); //用户发起还是在小组发起
		$content = $this->input->post('content');

		$cache = array();

		foreach($id as $k){
			$cache[$k] = array();
		}

		$sql = 'select fid,tuid from message where fuid='.$this->user['uid'];
		$query = $this->db->query($sql);

		foreach($query->result() as $row){
			if(isset($cache[$row->tuid])){
				array_push($cache[$row->tuid],$row->fid);
			}
		}

		$tablename = 'message';
		$key = array();
		$time = time();
		foreach($id as $k){
			foreach($fid as $i){
				if(!in_array($i,$cache[$k])){
					array_push($key,'('.$this->user['uid'].','.$k.',"'.$content.'",'.$i.')');	
				}
			}
		}
		if(count($key)>0){
			$sql = 'insert into message (fuid,tuid,content,fid) value '.implode(',',$key);
			$query = $this->db->query($sql);

			if($this->db->affected_rows()>0){
				$ret = array(
					'ret' => 0,
					'msg' => '添加成功!'
				);
					$this->json($ret,0,'添加成功!');
					return;					
			}else{
				$ret = array(
					'ret' => 101,
					'msg' => '添加失败!'
				);
					$this->json($ret,101,'添加失败!');
					return;					
			}
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '不能重复添加'
			);
					$this->json($ret,100,'不能重复添加!');
					return;	
		}

	}

	public function test(){
		$a = array(
			'1' => array(),
			'2' => array()
 		);

		phpinfo();
	}

	public function getfile(){
		$id = $this->input->get('fid');
		$sql = 'select path from files where id='.(int) $id;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $path = $row->path;
		   $mime = get_mime_by_extension($path);


			$this->output
			    ->set_content_type($mime) // 你也可以用".jpeg"，它在查找 config/mimes.php 文件之前会移除句号
			    ->set_output(file_get_contents($path));		   
		}else{

		}

	}

	public function downfile(){
		$this->load->helper('download');
		$id = $this->input->get('fid');
		$gid = (int) $this->input->get('gid');
		$tablename = 'userfile';
		$ft = 'name';
		if($gid){
			$tablename = 'groupfile';
			$ft = 'fname';
		}
		$sql = 'select a.path,b.'.$ft.' as name from files a,'.$tablename.' b where a.id = b.fid and a.id='.(int) $id;
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $path = $row->path;

		   $fname = explode('.',$path);
		   $fname = '.'.$fname[count($fname)-1];
		   $name = $row->name;
		   $name .=$fname;

		   //$mime = get_mime_by_extension($path);
			$data = file_get_contents($path); 
			force_download($name, $data); 

		}else{

		}
	}	

	//重命名文件
	public function renamefile(){
		$fid = $this->input->post('fid');
		$fname = $this->input->post('fname');
		$gid = (int) $this->input->post('gid');


		if($gid && $this->user['auth']>1){
			$data = array(
				'fname' => $fname,
			);			
			$str = $this->db->update_string('groupfile',$data,'id='.(int) $fid.' and gid ='.$gid);
		}else{
			$data = array(
				'name' => $fname
			);			
			$str = $this->db->update_string('userfile',$data,'id='.(int) $fid.' and uid ='.(int) $this->user['uid']);
		}
		$query = $this->db->query($str);

		if ($this->db->affected_rows() > 0){
			$ret = array(
				'ret' => 0,
				'msg' => '更新成功!'
			);
			$this->json($ret,0,'ok');
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '更新失败!'
			);
			$this->json($ret,100,'ok');
		}			
	}


	//重命名文件夹
	public function renamefold(){
		$fid = $this->input->post('fid');
		$fname = $this->input->post('fname');
		$gid = (int) $this->input->post('gid');

		$data = array(
			'name' => $fname
		);
		if($gid && $this->user['auth']>1){
	
			$str = $this->db->update_string('groupfolds',$data,'id='.(int) $fid.' and gid ='.$gid);
		}else{
			
			$str = $this->db->update_string('userfolds',$data,'id='.(int) $fid.' and uid ='.(int) $this->user['uid']);
		}
		$query = $this->db->query($str);

		if ($this->db->affected_rows() > 0){


			$ret = array(
				'ret' => 0,
				'msg' => '更新成功!'
			);
			$this->json($ret,0,'ok');
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '更新失败!'
			);
			$this->json($ret,100,'error');
		}		
		// $this->output
		//     ->set_content_type('application/json')
		//     ->set_output(json_encode($ret));		

	}	

	//添加文件评论 貌似作废了.
	public function add_file_comment(){
		$fid = $this->input->post('fid');
		$comment = $this->input->post('comment');

		$data = array(
			'content' => $comment
		);

		$str = $this->db->update_string('userfile',$data,' fid='.(int) $fid.' and uid='.(int) $this->user['uid']);
		$query = $this->db->query($str);
		if ($this->db->affected_rows() > 0){
			$ret = array(
				'ret' => 0,
				'msg' => '更新成功!'
			);
					$this->json($ret,0,'更新成功!');
					return;				
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '更新失败!'
			);
					$this->json($ret,100,'更新失败!');
					return;				
		}			
	}

	//删除文件
	public function g(){
		$type = $this->input->get('type');
		$id = $this->input->post('id');
		$gid = (int) $this->input->post('gid');

		$idlist = explode(',',$id);
		$kl = array();
		foreach($idlist as $k){
			array_push($kl,'id='.(int) $k);
		};
		$where = implode(' or ',$kl);
		if($gid){
			$sql = 'update groupfile set del=1 where gid='.(int) $gid.' and '.$where;	
		}else{
			$sql = 'update userfile set del=1 where uid='.(int) $this->user['uid'].' and '.$where;	
		}

		$query = $this->db->query($sql);
		if ($this->db->affected_rows() > 0){
			$ret = array(
				'ret' => 0,
				'msg' => '删除成功!'
			);
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '删除失败!'
			);
		}		
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($ret));	
	}

	public function add_prep(){
		$fid = $this->input->post('fid');
		$pid = $this->input->post('pid');
		$fl = explode(',',$fid);
		//$pl = explode(',',$pid);
		$fw = array();
		$kv = array();

		foreach($fl as $k){
			array_push($kv,'('.(int) $pid.','.(int) $k.','.(int) $this->user['uid'].')');
			array_push($fw,'fid='.$k);
		}
			
		$wh = implode(' or ',$fw);
		$sql = 'select fid from preparefile where uid='.(int) $this->user['uid'].' and pid='.(int) $pid.' and ('.$wh.')';
		$query = $this->db->query($sql);

		if ($this->db->affected_rows() > 0){
			$fkl = array();
			$nfl = array();
			$kv = array();
			foreach($query->result() as $row){
				array_push($fkl,$row->fid);
			}
			foreach($fl as $k){
				if(!in_array($k,$fkl)){
					array_push($nfl,$k);
				}
			}
			if(count($nfl) > 0){
				foreach($nfl as $k){
					array_push($kv,'('.(int) $pid.','.(int) $k.','.(int) $this->user['uid'].')');
				}
			}

		}
		if(count($kv)>0){
			$sql = 'insert into preparefile (pid,fid,uid) value '.implode(',',$kv);
			$query = $this->db->query($sql);
			if ($this->db->affected_rows() > 0){
				$ret = array(
					'ret' => 0,
					'msg' => '复制成功!'
				);
					$this->json($ret,0,'复制成功!');
					return;					
			}else{
				$ret = array(
					'ret' => 100,
					'msg' => '复制失败!'
				);
					$this->json($ret,100,'复制失败!');
					return;					
			}		
		}else{
			$ret = array(
				'ret' => 101,
				'msg' => '复制失败!没有符合条件的记录.'
			);
					$this->json($ret,101,'复制失败!没有符合条件的记录!');
					return;				
		}	
	}

	public function group_edit_desc(){
		$gid = (int) $this->input->post('gid');
		$desc = $this->input->post('d');

		$sql = 'select auth from groupuser where uid='.(int) $this->user['uid'].' and gid='.$gid;
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0 || $this->user['auth'] > 10){
			$data = array(
				'content' => $desc
			);
			$str = $this->db->update_string('groups',$data,'id='.$gid);
			$query = $this->db->query($str);
			if($this->db->affected_rows()>0 ){
				$ret = array(
					'ret' => 0,
					'msg' => '修改成功'
				);	
					$this->json($ret,0,'修改成功!');
					return;	
			}else{
				$ret = array(
					'ret' => 100,
					'msg' => '修改失败!'
				);	
					$this->json($ret,100,'修改失败!');
					return;	
			}
		}else{
			$ret = array(
				'ret' => 190,
				'msg' => '修改失败,你不是管理员'
			);
					$this->json($ret,190,'修改失败,你不是管理员!');
					return;				
		}		
	}

	public function add_board(){
		$gid = (int) $this->input->post('gid');
		$desc = $this->input->post('d');		
		$type = (int) $this->input->post('type');
		$pid = (int) $this->input->post('pid');
		$tid = (int) $this->input->post('tid');

		$data = array(
			'content' => $desc,
			'uid' => (int) $this->user['uid'],
			'ctime' => time(),
			'status' => 0,
			'ttype' => $type,
			'pid' => $pid,
			'gid' => $gid,
			'tid' => $tid
		);

		$sql = $this->db->insert_string('board',$data);
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0 ){
			$ret = array(
				'ret' => 0,
				'msg' => '修改成功'
			);		
					$this->json($ret,0,'修改成功!');
					return;	
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '修改失败!'
			);		
					$this->json($ret,100,'修改失败!');
					return;						
		}	
	}

	public function group_edit_name(){
		$gid = (int) $this->input->post('gid');
		$name = $this->input->post('d');

		$sql = 'select auth from groupuser where uid='.(int) $this->user['uid'].' and gid='.$gid;
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0 || $this->user['auth'] > 10){
			$data = array(
				'name' => $name
			);
			$str = $this->db->update_string('groups',$data,'id='.$gid);
			$query = $this->db->query($str);
			if($this->db->affected_rows()>0 ){
				$ret = array(
					'ret' => 0,
					'msg' => '修改成功'
				);		
					$this->json($ret,0,'修改成功!');
					return;							
			}else{
				$ret = array(
					'ret' => 100,
					'msg' => '修改失败!'
				);	
					$this->json($ret,100,'修改失败!');
					return;								
			}
		}else{
			$ret = array(
				'ret' => 190,
				'msg' => '修改失败,你不是管理员'
			);
					$this->json($ret,190,'修改失败,你不是管理员!');
					return;				
		}		
	}

	public function group_edit(){
		$gid = (int) $this->input->post('gid');
		$n = $this->input->post('n');		
		$desc = $this->input->post('d');
		$nl = $this->input->post('ul');
		$il = explode(',',$nl);

		$sql = 'select auth from groupuser where uid='.(int) $this->user['uid'].' and gid='.$gid;
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0 || $this->user['auth'] > 10){
			$data = array(
				'name' => $n,
				'content' => $desc
			);
			$str = $this->db->update_string('groups',$data,'id='.$gid);
			$query = $this->db->query($str);

			$ky = array();
			foreach($il as $k){
				// echo $k;
				array_push($ky,'('.$gid.','.$k.',0)');
			}

			$sql = 'insert into groupuser (gid,uid,auth) value '.implode(',',$ky);

			$query = $this->db->query($sql);

			if($this->db->affected_rows()>0 ){
				$ret = array(
					'ret' => 0,
					'msg' => '修改成功'
				);		
					$this->json($ret,0,'修改成功!');
					return;							
			}else{
				$ret = array(
					'ret' => 100,
					'msg' => '修改失败!'
				);	
					$this->json($ret,100,'修改失败!');
					return;								
			}
		}else{
			$ret = array(
				'ret' => 190,
				'msg' => '修改失败,你不是管理员'
			);
					$this->json($ret,190,'修改失败,你不是管理员!');
					return;				
		}	
	}

	public function new_group(){
		$gid = (int) $this->input->post('gid');
		$n = $this->input->post('n');		
		$desc = $this->input->post('d');
		$nl = $this->input->post('ul');
		$il = explode(',',$nl);

		$data = array(
			'name' => $n,
			'content' => $desc,
			'type' => 1,
			'parent' => 0,
			'create' => (int) $this->user['uid'],
			'status' => 1
		);		

		$str = $this->db->insert_string('groups',$data);
		$query = $this->db->query($str);

		if($this->db->affected_rows()>0){
			$gid = $this->db->insert_id();
			$ul = array('('.$gid.','.(int) $this->user['uid'].',1)');
			foreach($il as $row){
				array_push($ul,'('.$gid.','.$row.',0)');
			}
			$sql = 'insert into groupuser (gid,uid,auth) value '.implode(',',$ul);

			$query = $this->db->query($sql);
			if($this->db->affected_rows()>0){
				$ret = array(
					'ret' => 0,
					'msg' => '添加成功!'
				);
					$this->json($ret,0,'添加成功!');
					return;					
			}else{
				$ret = array(
					'ret' => 100,
					'msg' => '添加失败!'
				);
					$this->json($ret,100,'添加失败!');
					return;					
			}			
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '添加失败!'
			);
					$this->json($ret,100,'添加失败!');
					return;				
		}		
	}

	public function refrcey(){
		$id = (int) $this->input->post('id');
		$data = array(
			'del' => 0
		);
		$sql = $this->db->update_string('userfile',$data,'id='.$id);
		$query = $this->db->query($sql);

		if($this->db->affected_rows()>0){
			$ret = array(
				'ret' => 0,
				'msg' => '恢复成功!'
			);
					$this->json($ret,0,'恢复成功!');
					return;				
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '恢复失败!'
			);
					$this->json($ret,100,'恢复失败!');
					return;				
		}		
	}

	public function compdel(){
		$id = (int) $this->input->post('id');
		$fid = (int) $this->input->post('fid');
		$uf = 0;
		$gf = 0;
		$sql = 'select count(id) as anum from userfile where fid='.$fid;
		$query = $this->db->query($sql);
		$row = $query->row();

		$uf = $row->anum;
		$sql = 'select count(id) as anum from groupfile where fid='.$fid;
		$query = $this->db->query($sql);
		$row = $query->row();	
		$gf = $row->anum;	

		$sql = 'delete from userfile where id='.$id;
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0){
			if($uf < 2 && $gf < 2){
				$sql = 'select path from files where id='.$fid;
				$query = $this->db->query($sql);
				$row = $query->row();
				$path = $row->path;

				$sql = 'delete from files where id='.$fid;
				$query = $this->db->query($sql);
				if($this->db->affected_rows()>0){
					unlink($path);
					$ret = array(
						'ret' => 0,
						'msg' => '删除成功!'
					);	
					$this->json($ret,0,'删除成功!');
					return;										
				}else{
					$ret = array(
						'ret' => 100,
						'msg' => '删除失败!'
					);	
					$this->json($ret,100,'删除失败!');
					return;										
				}
			}else{
				$ret = array(
					'ret' => 0,
					'msg' => '删除成功!'
				);	
					$this->json($ret,0,'删除成功!');
					return;					
			}			
		}else{
			$ret = array(
				'ret' => 100,
				'msg' => '删除失败!'
			);	
					$this->json($ret,0,'删除成功!');
					return;	
		}
	}

	function copy_to_my(){
		$gid = (int) $this->input->post('gid');
		$fid = (int) $this->input->post('fid');

		if($gid){
			if($fid){
				$sql = 'select id from userfile where fid='.$fid.' and uid='.$this->user['uid'];
				$query = $this->db->query($sql);
				if($this->db->affected_rows()==0){

					$sql = 'select fid,fname from groupfile where gid='.$gid.' and fid='.$fid;
					$query = $this->db->query($sql);
					if ($query->num_rows() > 0){
						$row = $query->row();

						$data = array(
							'fid' => $fid,
							'name' => $row->fname,
							'uid' => $this->user['uid'],
							'del' => 0,
							'fdid' => 0
						);

						$str = $this->db->insert_string('userfile',$data);
						$query = $this->db->query($str);
						if($this->db->insert_id()){
							$ret = array(
								'ret' => 0,
								'msg' => '添加成功!'
							);	
							$this->json($ret,0,'添加成功!');
							return;								
						}else{
							$ret = array(
								'ret' => 100,
								'msg' => '添加失败!'
							);	
							$this->json($ret,100,'添加失败!');
							return;								
						}
					}else{
						$ret = array(
							'ret' => 10002,
							'msg' => '没有指定文件id!'
						);	
							$this->json($ret,10002,'没有指定文件id!');
							return;							
					}
				}else{
					$ret = array(
						'ret' => 10004,
						'msg' => '已经保存了该文件!'
					);	
							$this->json($ret,10004,'已经保存了该文件!');
							return;	
				}
			}else{
				$ret = array(
					'ret' => 10002,
					'msg' => '没有指定文件id'
				);	
							$this->json($ret,10002,'没有指定文件id!');
							return;								
			}
		}else{
			$ret = array(
				'ret' => 10001,
				'msg' => '没有指定分组id!'
			);	
							$this->json($ret,10001,'没有指定分组id!');
							return;				
		}		
	}

	public function to_school(){
		$id = (int) $this->input->post('id');

		if($id){

			$sql = 'select name,fid from userfile where id='.$id;
			$query = $this->db->query($sql);

			if($this->db->affected_rows() > 0){

				$row = $query->row();
				$data = array(
					'fid' => $row->fid,
					'fname' => $row->name,
					'fdid' => 0,
					'gid' => 1,
	                'createtime' => time(),
	                'del' => 0,
	                'uid' => (int) $this->user['uid'],
	                'status' => 0					
				);

				$sql = 'select a.id from groupfile a,groups b where a.fid='.(int) $row->fid.' and a.gid = b.id and b.type=0 limit 0,1';
				$query = $this->db->query($sql);

				if($this->db->affected_rows() == 0){
					$str = $this->db->insert_string('groupfile',$data);
					$query = $this->db->query($str);
					if($this->db->insert_id()){
						$ret = array(
							'ret' => 0,
							'msg' => '添加成功!'
						);	
						$this->json($ret,0,'添加成功!');
						return;								
					}else{
						$ret = array(
							'ret' => 100,
							'msg' => '添加失败!'
						);	
						$this->json($ret,100,'添加失败!');
						return;
					}
				}else{
					$ret = array(
						'ret' => 10003,
						'msg' => '文件id重复!'
					);	
						$this->json($ret,10003,'文件id重复!');
						return;					
				}
			}else{
				$ret = array(
					'ret' => 10002,
					'msg' => '没有指定id!'
				);
						$this->json($ret,10002,'没有指定id!');
						return;									
			}

		}else{
			$ret = array(
				'ret' => 10001,
				'msg' => '没有指定id!'
			);
			$this->json($ret,10001,'没有指定id!');
			return;					
		}		
	}

	public function review_pass(){
		$id = (int) $this->input->post('id');

		$data = array(
			'ttime' => time(),
			'ruid' => $this->user['uid']
		);

		$sql = $this->db->update_string('groupfile',$data,' id='.$id);
		$query = $this->db->query($sql);

		if($this->db->affected_rows() > 0){
			$ret = array(
				'ret' => 0,
				'msg' => '操作成功!'
			);
			$this->json($ret,0,'操作成功!');
			return;				
		}else{
			$ret = array(
				'ret' => 10001,
				'msg' => '操作失败!'
			);	
			$this->json($ret,10001,'操作失败!');
			return;							
		}
	}

	public function review_not_pass(){
		$id = (int) $this->input->post('id');
		$tag = $this->input->post('tag');

		$data = array(
			'tag' => $tag,
			'rtag' => 1,
			'ttime' => time(),
			'ruid' => $this->user['uid']
		);	

		$sql = $this->db->update_string('groupfile',$data,' id='.$id);
		$query = $this->db->query($sql);

		if($this->db->affected_rows() > 0){
			$ret = array(
				'ret' => 0,
				'msg' => '操作成功!'
			);	
			$this->json($ret,0,'操作成功!');
			return;				
		}else{
			$ret = array(
				'ret' => 10001,
				'msg' => '操作失败!'
			);	
			$this->json($ret,10001,'操作失败!');
			return;							
		}			
	}

	public function del_file(){

		$type = $this->input->get('type');
		$id = $this->input->post('id');
		$gid = (int) $this->input->post('gid');

		$idlist = explode(',',$id);
		$kl = array();
		foreach($idlist as $k){
			array_push($kl,'id='.(int) $k);
		};
		$where = implode(' or ',$kl);
		if($gid){
			$sql = 'update groupfile set del=1 where gid='.(int) $gid.' and '.$where;	
		}else{
			$sql = 'update userfile set del=1 where uid='.(int) $this->user['uid'].' and '.$where;	
		}

		$query = $this->db->query($sql);
		$right = $this->db->affected_rows();


		if($gid){
			$sql = 'select fid from groupfile where '.implode(' or ',$kl);
		}else{
			$sql = 'select fid from userfile where '.implode(' or ',$kl);
		}
		$query = $this->db->query($sql);
		$kl1 = array();
		foreach($query->result() as $row){
			array_push($kl1,'fid='.(int) $row->fid);
		}
		$sql = 'delete from usercollection where uid ='.(int) $this->user['uid'].' and ('.implode(' or ',$kl1).')';
		$query = $this->db->query($sql);


		if($right){
			$ret = array(
				'msg' => 'ok'
			);
			$this->json($ret,0,'ok');
		}else{
			$ret = array(
				'msg' => 'error'
			);
			$this->json($ret,100,'error');
		}
	}

	public function del_fold(){
		$id = $this->input->post('id');
		$idlist = explode(',',$id);
		$kl = array();
		$sl = array();
		$pl = array();
		foreach($idlist as $r){
			array_push($kl,' id='.$r);
			array_push($sl,' fdid='.$r);
			array_push($pl,' pid='.$r);
		}

		$sql = 'delete from userfile where ('. implode(' or ',$sl).') and uid='.$this->user['uid'];
		$query = $this->db->query($sql);

		$sql = 'delete from userfolds where ('. implode(' or ',$pl).') and uid='.$this->user['uid'];
		$query = $this->db->query($sql);

		$sql = 'delete from userfolds where ('. implode(' or ',$kl).') and uid='.$this->user['uid'];
		$query = $this->db->query($sql);
		if($this->db->affected_rows()>0){
			$ret = array(
				'msg' => 'ok'
			);
			$this->json($ret,0,'ok');
		}else{
			$ret = array(
				'msg' => 'error'
			);
			$this->json($ret,100,'error');
		}
	}

	public function copymsg_to_my(){
		$id = (int) $this->input->post('id');

		//$sql = 'SELECT a.id,a.fuid as uid,a.content,a.createtime,a.fid,b.name AS uname,c.name AS fname,d.path,d.size,d.type FROM message a LEFT JOIN `user` b ON a.fuid = b.`id` LEFT JOIN `userfile` c ON c.fid = a.fid		LEFT JOIN `files` d ON d.id = a.fid	WHERE a.tuid = '.$this->user['uid'];		
		//$sql = 'select a.fid from message a,userfile b where a.id='.$id.' and a.fuid = b.id';
		$sql = 'select a.fid,b.name from message a left join userfile b ON a.fuid = b.uid where a.id='.$id;
		$query = $this->db->query($sql);
		$row = $query->row();

		$sql = 'select id from userfile where uid='.$this->user['uid'].' and fid='.$row->fid;
		$query = $this->db->query($sql);

		if($this->db->affected_rows() > 0){
			$ret = array(
				'msg' => '文件已经存在!'
			);
			$this->json($ret,100,'文件已经存在!');
		}else{
			$data = array(
				'fid' => (int) $row->fid,
				'name' => $row->name,
				'uid' => (int) $this->user['uid'],
				'del' => 0,
				'fdid' => 0			
			);
			$sql = $this->db->insert_string('userfile',$data);
			$query = $this->db->query($sql);

			if($this->db->affected_rows()>0){
				$this->json(array('msg' => '已经成功复制文件!'),0,'已经成功复制文件!');
			}else{
				$this->json(array('msg' => '复制文件失败!'),101,'复制文件失败!');
			}
		}
	}

	public  function copy_to_fold(){
		$fid = $this->input->post("fid");
		$fdid = $this->input->post("fdid");
		$gid = (int) $this->input->post("gid");

		$fl = explode(',',$fid);
		$kl = array();
		foreach($fl as $k){
			array_push($kl,' id='.$k);
		}
		$tablename = 'userfile';
		if($gid){
			$tablename = 'groupfile';
		}
		$sql = $this->db->update_string($tablename,array('fdid' => $fdid),implode(' or ',$kl));
		$query = $this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$ret = array(
				'msg' => 'ok'
			);
			$this->json($ret,0,'ok');
		}else{
			$ret = array(
				'msg' => 'error'
			);
			$this->json($ret,100,'error');			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */