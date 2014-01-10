<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends SZone_Controller {

        /**
         * Index Page for this controller.
         *
         * Maps to the following URL
         *                 http://example.com/index.php/welcome
         *        - or -  
         *                 http://example.com/index.php/welcome/index
         *        - or -
         * Since this controller is set as the default controller in 
         * config/routes.php, it's displayed at http://example.com/
         *
         * So any other public methods not prefixed with an underscore will
         * map to /index.php/welcome/<method_name>
         * @see http://codeigniter.com/user_guide/general/urls.html
         */


        public function index(){

        $this->set_group();

        $pagenum = $this->config->item('pagenum');
                $nowpage = (int) $this->input->get('page');

                $od = (int) $this->input->get('od');
                $on = (int) $this->input->get('on');

                if(!$od){
                        $od = 2;
                }
                if(!$on){
                        $on = 4;
                }

                $desc = '';
                $odname = 'name';
                if($od == 2){
                        $desc = 'desc';
                }
                switch($on){
                        case 1:
                                $odname = 'name';
                                break;
                        case 2:
                                $odname = 'type';
                                break;
                        case 3:
                                $odname = 'size';
                                break;
                        case 4:
                                $odname = 'createtime';
                                break;                        
                }
                $type = (int) $this->input->get('type');
                $fid = (int) $this->input->get('fid');
                $fname = '';
                $pid = 0;
                $foldnum = 0;
                $data = array(
                        'nav' => array(
                                'userinfo' => $this->user,
                                'group' => $this->grouplist,
                                'dep' => $this->deplist,
                                'school' => $this->school
                        )
                );

                $key = db_escape_string($this->input->get_post('key'));
                if($key){
                        $fid = (int) $this->input->post('fid');
                }

                $sql = 'select id,name,mark,createtime,pid,tid,idpath from userfolds where prid=0 and uid = '.$this->user['id'];
                // if($key){
                //         $sql .= ' and name like "%'.$key.'%"';
                // }

                $query = $this->db->query($sql);

                $fold = array();
                $foldlist = array();
                $thisfold = array(
                        'id' => 0,
                        'pid' => 0
                );
                foreach($query->result() as $row){
                        if($row->id == $fid){
                                $thisfold = array(
                                        'id' => $row->id,
                                        'pid' => $row->pid,
                                        'name' => $row->name,
                                        'tid' => $row->tid,
                                        'idpath' => explode(',',$row->idpath)
                                );
                                $fname = $row->name;
                                $pid = $row->pid;
                        }
                        $fold[$row->id] = array(
                                'id' => $row->id,
                                'name' => $row->name,
                                'mark' => $row->mark,
                                'pid' => (int) $row->pid,
                                'tid' => (int) $row->tid,
                                'idpath' => $row->idpath,
                                'time' => date('Y-m-d',$row->createtime)
                        );
                        if($row->pid == 0){
                                $foldlist[$row->id] = array(
                                        'id' => $row->id,
                                        'name' => $row->name,
                                        'mark' => $row->mark,
                                        'pid' => (int) $row->pid,
                                        'tid' => (int) $row->tid,
                                        'time' => date('Y-m-d',$row->createtime)
                                );                                
                        }else{
                                if(isset($foldlist[$row->pid])){
                                        $foldlist[$row->pid]['child'] = 1;
                                }
                        }
                }
                $foldnum = count($fold);

                // foreach($fold as $row){
                //         if($row['pid'] == 0){
                //                 $foldlist[$row['id']] = $row;
                //         }else if($row['pid'] == $row['tid']){
                //                 if(!isset($foldlist[$row['pid']]['list'])){
                //                         $foldlist[$row['pid']]['list'] = array();
                //                 }
                //                 $foldlist[$row['pid']]['list'][$row['id']] = $row;
                //         }
                // }

                // $sql = 'select count(a.id) as anum from userfile a left join files b on b.id = a.fid where a.del =0 and a.uid='.$this->user['id'];
                // //if($fid){
                //         $sql.=' and a.fdid='.$fid;
                // //}
                // if($type){
                //         $sql .= ' and b.type='.$type;
                // }
                // if($key){
                //         $sql .= ' and a.name like "%'.$key.'%"';
                // }

                // $query = $this->db->query($sql);
                // $row = $query->row();                
                // $allnum = $row->anum;
        

                // if($fid){
                //         $sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = '.$fid.' and a.del = 0 and a.uid='.$this->user['id'];
                // }else{
                //         $sql = 'select a.id,a.fid,a.name,a.createtime,a.content,a.del,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.fdid = 0 and a.del = 0  and a.uid='.$this->user['id'];
                // }
                // if($type){
                //         $sql .= ' and b.type='.$type;
                // }
                // if($key){
                //         $sql .= ' and a.name like "%'.$key.'%"';
                // }
                // if($od){
                //         $sql .= ' order by '.$odname.' '.$desc;
                // }

                // $page = get_page_status($nowpage,$pagenum,$allnum);
                // $sql .= ' limit '.$page['start'].','.$pagenum;

                // //$sql .= ' limit '.$page.','.($page+$pagenum);        
                // //echo $sql;
                // $query = $this->db->query($sql);
                // $file = array();
                // $idlist = array();

                // foreach($query->result() as $row){
                //         $file[$row->id] = array(
                //                 'id' => $row->id,
                //                 'fid' => $row->fid,
                //                 'name' => $row->name,
                //                 'time' => substr($row->createtime,0,10),
                //                 'content' => $row->content,
                //                 'path' => $row->path,
                //                 'size' => format_size($row->size),
                //                 'type' => $row->type
                //         );
                // }

                // $sql = 'select fid from usercollection where uid='.$this->user['id'];
                // $query = $this->db->query($sql);

                // foreach($query->result() as $row){
                //         array_push($idlist,$row->fid);
                // }


				$this->load->model('Uf_model');
				$allnum = $this->Uf_model->get_all_filenum($this->user['id'],$fid,$key,$type);

				$page = get_page_status($nowpage,$pagenum,$allnum);

				if($od){
					$file = $this->Uf_model->get_fileinfo($this->user['id'],$fid,$key,$type,$odname,$desc,$page['start'],$pagenum);		
				}else{
					$file = $this->Uf_model->get_fileinfo($this->user['id'],$fid,$key,$type,0,0,$page['start'],$pagenum);
				}                

                $sql = 'select id,name,mark,createtime,pid,tid,idpath from userfolds where prid=0 and uid = '.$this->user['id'];
                if($key){
                        $sql .= ' and name like "%'.$key.'%"';
                }        
                if($od && $on !=2 && $on != 3){
                        $sql .= ' order by '.$odname.' '.$desc;
                }        
                $query = $this->db->query($sql);
                $fold = array();
                foreach($query->result() as $row){
                        $fold[$row->id] = array(
                                'id' => $row->id,
                                'name' => $row->name,
                                'mark' => $row->mark,
                                'pid' => (int) $row->pid,
                                'tid' => (int) $row->tid,
                                'idpath' => $row->idpath,
                                'time' => date('Y-m-d',$row->createtime)
                        );
                }


                $this->load->model('Mail_model');
                $newmail = $this->Mail_model->get_user_new_mail($this->user['id']);
                $postmail = $this->Mail_model->get_user_post_mail($this->user['id']);


                $data['allnum'] = $allnum;
                $data['fold'] = $fold;
                $data['flist'] = $foldlist;
                $data['thisfold'] = $thisfold;
                $data['fname'] = $fname;
                $data['fid'] = $fid;
                $data['file'] = $file;
                $data['type'] = $type;
                $data['pid'] = $pid;
                //$data['coll'] = $idlist;
                $data['foldnum'] = $foldnum;
                $data['page'] = $page;
                $data['key'] = $key;
                $data['od'] = $od;
                $data['on'] = $on;

                $data['newmail'] = $newmail;
                $data['postmail'] = $postmail;

        // 文件上传
        $data['upload_url'] = $this->config->item('url','upload');
        $data['upload_chunk'] = $this->config->item('chunk','upload');

                $this->load->view('home',$data);        
        }

        //移动文件
        function movefile(){
                $id = (int) $this->input->get('fid');
                $fdid = (int) $this->input->get('fdid');
                $gid = (int) $this->input->get('gid');

                $il = explode(',',$id);
                $tablename = 'userfolds';
                if($gid){
                        $tablename = 'groupfolds';
                }
                $sql = 'select id,pid,name,tid,idpath from '.$tablename;
                if(!$gid){
                        $sql .= ' where prid=0 and uid='.$this->user['id'];
                }else{
                        $sql .= ' where gid='.$gid.' and pid = 0';
                }
                if($fdid){
                        $sql .= ' and id !='.$fdid;
                }
                $query = $this->db->query($sql);

                $folds = array();
                foreach($query->result() as $row){
                        if($row->pid == 0){
                                if(isset($folds[$row->id])){
                                        $folds[$row->id]['id'] = $row->id;
                                        $folds[$row->id]['pid'] = $row->pid;
                                        $folds[$row->id]['name'] = $row->name;
                                        $folds[$row->id]['tid'] = $row->tid;
                                        $folds[$row->id]['idpath'] = $row->idpath;
                                }else{
                                        $folds[$row->id] = array(
                                                'id' => $row->id,
                                                'pid' => $row->pid,
                                                'name' => $row->name,
                                                'tid' => $row->tid,
                                                'idpath' => $row->idpath
                                        );
                                }
                        }else{
                                $folds[$row->tid]['child'] = 1;
                        }
                }

                function psort($a,$b){
                        if($a['pid'] == 0){
                                return -1;
                        }else if($a['pid'] = $b['pid']){
                        // return 0;
                                $an = count(explode(',',$a['idpath']));
                                $bn = count(explode(',',$b['idpath']));
                                if( $an < $bn){
                                        return -1;
                                }else if($an == $bn){
                                        return 0;
                                }else{
                                        return 1;
                                }                                
                        }else{
                                return 1;
                        }
                }

                $id = $this->input->get('fid');

                $il = explode(',',$id);
                $kl = array();
                foreach($il as $k){
                        array_push($kl,' id='.$k);
                }                
                $str = implode(' or ',$kl);

                if($gid){
                        $sql = 'select id,fname as name from groupfile where '.$str;        
                }else{
                        $sql = 'select id,name from userfile where '.$str;        
                }                
                $query = $this->db->query($sql);

                $nl = array();
                foreach($query->result() as $row){
                        array_push($nl,array(
                                        'id' => $row->id,
                                        'name' => $row->name
                                ));
                }        
                $data = array(
                        'fl' => $nl,
                        'flist' => $folds,
                        'gid' => $gid
                        );        
                $this->load->view('share/movefile.php',$data);                
        }


        function sendmail(){
                $this->load->helper('util');
                $m = (int) $this->input->get('m'); // m= 0 发件箱  m = 1 收件箱

                $this->load->model('Mail_model');

                if($m){
                        $this->Mail_model->look_all_mail($this->user['id']);
                }else{
                        $this->Mail_model->look_all_post($this->user['id']);
                }

                $type = (int) $this->input->get('type');
                $uid = (int) $this->input->get('uid');
                $key = db_escape_string($this->input->post('key'));

                
                $od = (int) $this->input->get('od');
                $on = db_escape_string($this->input->get('on'));        

                if(!$od){
                        $od = 2;
                }
                if(!$on){
                        $on = 4;
                }

                $desc = '';
                $odname = 'fname';
                if($od == 2){
                        $desc = 'desc';
                }
                switch($on){
                        case 1:
                                $odname = 'fname';
                                break;
                        case 2:
                                $odname = 'type';
                                break;
                        case 3:
                                $odname = 'size';
                                break;
                        case 4:
                                $odname = 'createtime';
                                break;                        
                }        

                if($m){
                        $sql = 'SELECT a.id,a.fuid as uid,a.content,a.saved,a.createtime,a.fid,b.name AS uname,c.name AS fname,d.path,d.size,d.type FROM message a LEFT JOIN `user` b ON a.fuid = b.`id` LEFT JOIN `userfile` c ON c.fid = a.fid                LEFT JOIN `files` d ON d.id = a.fid        WHERE a.tuid = '.$this->user['id'];
                }else{
                        $sql = 'SELECT a.id,a.tuid as uid,a.content,a.saved,a.createtime,a.fid,b.name AS uname,c.name AS fname,d.path,d.size,d.type FROM message a LEFT JOIN `user` b ON a.tuid = b.`id` LEFT JOIN `userfile` c ON c.fid = a.fid                LEFT JOIN `files` d ON d.id = a.fid        WHERE a.fuid = '.$this->user['id'];
                }

                if($key && $key != '搜索文件'){
                        $sql .= ' and c.name like "%'.$key.'%"';
                }else{
                        if($type){
                                $sql .= ' and d.type='.$type;
                        }
                        if($uid){
                                if($m){
                                        $sql .= ' and a.fuid='.$uid;
                                }else{
                                        $sql .= ' and a.tuid='.$uid;
                                }
                        }
                }

                if($od){
                        $sql .= ' order by '.$odname.' '.$desc;
                }                

                $query = $this->db->query($sql);
                $mlist = array();
                $tlist = array();
                foreach($query->result() as $row){
                        $mlist[$row->id] = array(
                                'id' => $row->id,
                                'uid' => $row->uid,
                                'ctime' => $row->createtime,
                                'content' => $row->content,
                                'fid' => $row->fid,
                                'uname' => $row->uname,
                                'fname' => $row->fname,
                                'save' => $row->saved,
                                'path' => $row->path,
                                'size' => format_size($row->size),
                                'type' => $row->type
                        );
                        $tlist[$row->uid] = array(
                                'id' => $row->uid,
                                'name' => $row->uname
                                );
                }

                if(!$m){
                        $sql = 'SELECT DISTINCT a.tuid as id,b.name FROM message a,user b WHERE b.id = a.tuid AND a.fuid = '.$this->user['id'];
                        $query = $this->db->query($sql);
                        if ($query->num_rows() > 0){
                                $tlist = array();
                                foreach($query->result() as $row){
                                        $tlist[$row->id] = array(
                                                'id' => $row->id,
                                                'name' => $row->name
                                                );                                
                                }
                        }                        
                }

                $data['m'] = $m;
                $data['type'] = $type;
                $data['uid'] = $uid;
                $data['mail'] = $mlist;
                $data['ulist'] = $tlist;
                $data['od'] = $od;
                $data['on'] = $on;        
                $data['key'] = $key;

                $this->load->view('home/mail.php',$data);
        }

        function groupmail(){
                $this->load->helper('util');
                $type = (int) $this->input->get('type');
                $gid = (int) $this->input->get('gid');
                $key = db_escape_string($this->input->post('key'));

                
                $od = (int) $this->input->get('od');
                $on = $this->input->get('on');        

                if(!$od){
                        $od = 2;
                }
                if(!$on){
                        $on = 4;
                }


                $desc = '';
                $odname = 'name';
                if($od == 2){
                        $desc = 'desc';
                }
                switch($on){
                        case 1:
                                $odname = 'a.fname';
                                break;
                        case 2:
                                $odname = 'type';
                                break;
                        case 3:
                                $odname = 'size';
                                break;
                        case 4:
                                $odname = 'createtime';
                                break;                        
                }        

                $sql = 'SELECT a.id,a.fname,a.fid,a.createtime,a.gid,b.name AS gname,c.path,c.size,c.type,d.name AS fdname FROM groupfile a LEFT JOIN groups b ON b.id = a.gid        LEFT JOIN files c ON c.id = a.fid LEFT JOIN groupfolds d ON a.fdid = d.id WHERE a.uid ='.$this->user['id'];

                if($key && $key != '搜索文件'){
                        $sql .= ' and a.fname like "%'.$key.'%"';
                }else{
                        if($type){
                                $sql .= ' and c.type='.$type;
                        }
                        if($gid){
                                $sql .= ' and a.gid='.$gid;
                        }
                }

                if($od){
                        $sql .= ' order by '.$odname.' '.$desc;
                }


                $query = $this->db->query($sql);
                $mlist = array();
                $tlist = array();
                foreach($query->result() as $row){
                        $mlist[$row->id] = array(
                                'id' => $row->id,
                                'fid' => $row->fid,
                                'gname' => $row->gname,
                                'fname' => $row->fname,
                                'fdname' => $row->fdname,
                                'path' => $row->path,
                                'size' => format_size($row->size),
                                'ctime' => $row->createtime,
                                'type' => $row->type
                        );
                        $tlist[$row->gid] = array(
                                'id' => $row->gid,
                                'name' => $row->gname
                                );
                }

                if($gid){
                        $sql = 'SELECT DISTINCT a.gid as id,b.name FROM groupfile a,groups b WHERE a.gid = b.id AND a.uid='.$this->user['id'];
                        $query = $this->db->query($sql);
                        if ($query->num_rows() > 0){
                                $tlist = array();
                                foreach($query->result() as $row){
                                        $tlist[$row->id] = array(
                                                'id' => $row->id,
                                                'name' => $row->name
                                                );                                
                                }
                        }
                }


                $data['type'] = $type;
                $data['gid'] = $gid;
                $data['mail'] = $mlist;
                $data['glist'] = $tlist;
                $data['od'] = $od;
                $data['on'] = $on;
                $data['key'] = $key;

                $this->load->view('home/gmail.php',$data);
        }        

        //复制文件到备课
        function copyfile(){
            $id = $this->input->get('fid');

            $il = explode(',',$id);
            $kl = array();

            foreach($il as $k){
                    array_push($kl,' id='.$k);
            }                
            $str = implode(' or ',$kl);

            // $this->load->model('Group_model');
            // $gidlist = $this->Group_model->get_prep_group_ids($this->user['id']);    
            
            $this->load->model('Prep_model');
            $plist = $this->Prep_model->get_prep_group_byid($this->user['id']);

            $pids = array();
            foreach($plist as $row){
                array_push($pids,$row['id']);
            }

            $sql = 'select id,name from userfile where '.$str;                
            $query = $this->db->query($sql);

            $nl = array();
            foreach($query->result() as $row){
                array_push($nl,array(
                    'id' => $row->id,
                    'name' => $row->name
                ));
            }        
            $data = array('fl' => $nl);        

            // $sql = 'select id,name,parent from groups where type=3';
            // $query = $this->db->query($sql);
            //$plist = array();
            // $pplist = array();
            // $pids = array();

            // $this->load->model('Fold_model');
            // //选择备课目录
            // foreach($query->result() as $row){
            //         if($row->parent == 0){
            //                 $pplist[$row->id] = array(
            //                         'id' => $row->id,
            //                         'name' => $row->name
            //                 );
            //         }

            //         if(in_array($row->id,$gidlist)){
            //                 if($row->parent == 0){
            //                         if(isset($plist[$row->id])){
            //                                 $plist[$row->id] = $row->id;
            //                                 $plist[$row->id] = $row->name;
            //                         }else{
            //                                 $plist[$row->id] = array(
            //                                         'id' => $row->id,
            //                                         'name' => $row->name,
            //                                         'list' => array()
            //                                 );
            //                         }
            //                 }else{
            //                         $child = $this->Fold_model->get_prep_fold($row->id,$this->user['id']);
            //                         if(isset($plist[$row->parent])){
            //                                 $plist[$row->parent]['list'][$row->id]['id'] = $row->id;
            //                                 $plist[$row->parent]['list'][$row->id]['name'] = $row->name;
            //                         }else{
            //                                 $plist[$row->parent] = array(
            //                                         'id' => $row->parent,
            //                                         'list' => array()
            //                                 );
            //                                 $plist[$row->parent]['list'][$row->id] = array(
            //                                         'id' => $row->id,
            //                                         'name' => $row->name
            //                                 );
            //                         }
            //                         if($child){
            //                                 $plist[$row->parent]['list'][$row->id]['child'] = $child;
            //                         }                                        
            //                 }
            //         }
            // }

            //echo json_encode($plist);

            foreach($plist as &$row){
                    if(!isset($row['name'])){
                            //echo json_encode($pplist[$row['id']]);
                            $row['name'] = $pplist[$row['id']]['name'];
                    }
            }
            $data['plist'] = $plist;

            $this->load->view('share/copyfile.php',$data);
        }        


        function prepare(){
                $this->set_group();
                $this->load->helper('util');

                $key = db_escape_string($this->input->get_post('key'));
                $pagenum = $this->config->item('pagenum');
                $nowpage = (int) $this->input->get('page');
                $type = (int) $this->input->get('type');
                $fid = (int) $this->input->get('fid');        
                $allnum = 0;        

                $wh = '';

                $od = (int) $this->input->get('od');
                $on = $this->input->get('on');

                if(!$od){
                        $od = 2;
                }
                if(!$on){
                        $on = 4;
                }                

                $desc = '';
                $odname = 'name';
                if($od == 2){
                        $desc = 'desc';
                }

                switch($on){
                        case 1:
                                $odname = 'name';
                                break;
                        case 2:
                                $odname = 'b.type';
                                break;
                        case 3:
                                $odname = 'size';
                                break;
                        case 4:
                                $odname = 'createtime';
                                break;                        
                }

                $prid = (int) $this->input->get('prid');
                $pid = (int) $this->input->get('pid');
                $fdid = (int) $this->input->get('fdid');

                // $this->load->model('Group_model');
                // $gidlist = $this->Group_model->get_prep_group_ids($this->user['id']);
                
                
                // $sql = 'select id,name,parent from groups where';  
                // if(count($gidlist)>0){
                //         $gidstr = '('.implode(',',$gidlist).')';        
                //         $sql .= '(id in '.$gidstr.' or parent = 0) and type=3 order by parent';
                // }else{
                //         $sql .= ' type=3 and parent<0 order by parent';
                // }

                // $query = $this->db->query($sql);

                // $plist = array();
                // $kp = array();

                // $pfname = '';
                // $pname = '';
                //选择备课目录
                // foreach($query->result() as $row){
                //         array_push($kp,' prid='.$row->id);
                //         if($row->id == $prid){
                //                 $pfname = $row->name;
                //                 if($row->parent){
                //                         $pname = $plist[$row->parent]['name'];
                //                 }
                //         }
                //         if($row->parent == 0){
                //                 if(isset($plist[$row->id])){
                //                         $plist[$row->id] = $row->id;
                //                         $plist[$row->id] = $row->name;
                //                 }else{
                //                         $plist[$row->id] = array(
                //                                 'id' => $row->id,
                //                                 'name' => $row->name,
                //                                 'list' => array()
                //                         );
                //                 }
                //         }else{
                //                 if(isset($plist[$row->parent])){
                //                         $plist[$row->parent]['list'][$row->id]['id'] = $row->id;
                //                         $plist[$row->parent]['list'][$row->id]['name'] = $row->name;
                //                 }else{
                //                         $plist[$row->parent] = array(
                //                                 'list' => array()
                //                         );
                //                         $plist[$row->parent]['list'][$row->id] = array(
                //                                 'id' => $row->id,
                //                                 'name' => $row->name
                //                         );
                //                 }
                //         }
                // };

                $file = array();
                $kfc = array();
                $fold = array();
                $foldlist = array();        
                $thisfold = array(
                    'id' => 0,
                    'pid' => 0
                );
                $pfname = '';
                $pname = '';
                $plist = array();

                $this->load->model('Group_model');
                $plist = $this->Group_model->get_prep_group_byid($this->user['id']);

                if(count($plist)>0){
                    $tp = array_slice($plist,0,1);
                }

                $this->load->model('Fold_model');
                $fold = $this->Fold_model->get_prep_byid($this->user['id'],$prid,$fid);

                $this->load->model('Uf_model');
                $allnum = $this->Uf_model->get_allprep_num($this->user['id'],$prid,$fid,$key,$type);

                $page = get_page_status($nowpage,$pagenum,$allnum);

                if($od){
                    $file = $this->Uf_model->get_prep_byid($this->user['id'],$prid,$fid,$key,$type,$odname,$desc,$page['start'],$pagenum);     
                }else{
                    $file = $this->Uf_model->get_prep_byid($this->user['id'],$prid,$fid,$key,$type,0,0,$page['start'],$pagenum);
                }                 

                // if(count($plist)>0){
                //         if(!$prid && !$fid){
                //                 //取对应的文件夹
                //                 $sql = 'select id,prid from userfolds where uid='.(int) $this->user['id'].' and '.implode(' or ',$kp);
                //                 $query = $this->db->query($sql);

                //                 $kpf = array();
                //                 foreach($query->result() as $row){
                //                         array_push($kpf,' fdid='.$row->id);
                //                 }
                //                 if(count($kpf) > 0){
                //                         $wh .= ' and ('.implode(' or ',$kpf).')';
                //                 }else{
                //                         $fid = 0;
                //                 }
                //         }else{
                //                 if($fid){
                //                         $wh .= ' and fdid='.$fid;
                //                 }else{
                //                         $sql = 'select id from userfolds where uid='.(int) $this->user['id'].' and pid=0 and prid='.$prid;
                //                         $query = $this->db->query($sql);

                //                         if($query->num_rows() > 0){
                //                                 $row = $query->row();
                //                                 $fid = $row->id;
                //                                 $wh .= ' and fdid='.$fid;
                //                         //还没有目录,新建目录
                //                         }else{
                //                                 $data = array(
                //                                         'pid' => 0,
                //                                         'name' => $pfname,
                //                                         'uid' => $this->user['id'],
                //                                         'mark' => '',
                //                                         'createtime' => time(),
                //                                         'type' => 0,
                //                                         'prid' => $prid
                //                                 );
                //                                 $sql = $this->db->insert_string('userfolds',$data);
                //                                 $query = $this->db->query($sql);
                //                                 $fid = $this->db->insert_id();

                //                         }
                //                         $wh .= ' and fdid='.$fid;
                //                 }
                //         }

                //         if($type){
                //                 $wh .= ' and b.type='.$type;
                //         }
                //         if($key){
                //                 $wh .= ' and a.name like "%'.$key.'%"';
                //         }
                //         if($od){
                //                 $wh .= ' order by '.$odname.' '.$desc;
                //         }                

                //         if($fid){

                //             $this->load->model('Uf_model');
                //             $allnum = $this->Uf_model->get_allprep_num($this->user['id'],$fid,$key,$type);

                //             $page = get_page_status($nowpage,$pagenum,$allnum);

                //             if($od){
                //                 $file = $this->Uf_model->get_prep_byid($this->user['id'],$fid,$key,$type,$odname,$desc,$page['start'],$pagenum);     
                //             }else{
                //                 $file = $this->Uf_model->get_prep_byid($this->user['id'],$fid,$key,$type,0,0,$page['start'],$pagenum);
                //             }                            
                //                 // $sql = 'select count(a.id) as allnum from userfile a,files b where a.del=0 and a.prid=b.id and uid='.$this->user['id'];
                //                 // $sql .= $wh;

                //                 // $query = $this->db->query($sql);
                //                 // $row = $query->row();

                //                 // $allnum = $row->allnum;

                //                 // //选择文件
                //                 // $sql = 'select a.id,a.fid,a.name,a.createtime,b.type,b.size from userfile a,files b where a.del = 0 and a.prid = b.id and uid = '.$this->user['id'];
                //                 // $sql .= $wh;
                //                 // $page = get_page_status($nowpage,$pagenum,$allnum);

                //                 // $query = $this->db->query($sql);

                //                 // foreach($query->result() as $row){
                //                 //         array_push($kfc,' a.fid='.$row->fid);
                //                 //         $flist[$row->id] = array(
                //                 //                 'id' => $row->id,
                //                 //                 'fid' => $row->fid,
                //                 //                 'name' => $row->name,
                //                 //                 'type' => $row->type,
                //                 //                 'size' => format_size($row->size),
                //                 //                 'time' => substr($row->createtime,0,10)
                //                 //         );
                //                 // }

                //                 // $sql = 'select a.id from userfile a,usercollection b where a.prid=b.fid and b.uid='.$this->user['id'];
                //                 // if(count($kfc)>0){
                //                 // $sql .=' and ('.implode(' or ',$kfc).')';
                //                 // }
                //                 // $query = $this->db->query($sql);

                //                 // foreach($query->result() as $row){
                //                 //         if(isset($flist[$row->id])){
                //                 //                 $flist[$row->id]['iscoll'] = 1;
                //                 //         }
                //                 // }
                //         }

                //         if(!$prid && !$fid){
                //                 $sql = 'select id,name,mark,createtime,pid,tid,idpath,prid from userfolds where pid='.$fid.' and prid !=0 and uid='.$this->user['id'];
                //         }else{
                //                 $sql = 'select id,name,mark,createtime,pid,tid,idpath,prid from userfolds where pid='.$fid.' and uid='.$this->user['id'];
                //         }
                //         $query = $this->db->query($sql);
                //         foreach($query->result() as $row){
                //                 if($row->id == $fid){
                //                         $thisfold = array(
                //                                 'id' => $row->id,
                //                                 'pid' => $row->pid,
                //                                 'name' => $row->name,
                //                                 'tid' => $row->tid,
                //                                 'idpath' => explode(',',$row->idpath)
                //                         );
                //                         $fname = $row->name;
                //                         $pid = $row->pid;
                //                 }
                //                 $fold[$row->id] = array(
                //                         'id' => $row->id,
                //                         'name' => $row->name,
                //                         'mark' => $row->mark,
                //                         'pid' => (int) $row->pid,
                //                         'prid' => (int) $row->prid,
                //                         'tid' => (int) $row->tid,
                //                         'idpath' => $row->idpath,
                //                         'time' => date('Y-m-d',$row->createtime)
                //                 );
                //                 if($row->pid == 0){
                //                         $foldlist[$row->id] = array(
                //                                 'id' => $row->id,
                //                                 'name' => $row->name,
                //                                 'mark' => $row->mark,
                //                                 'pid' => (int) $row->pid,
                //                                 'tid' => (int) $row->tid,
                //                                 'prid' => (int) $row->prid,
                //                                 'time' => date('Y-m-d',$row->createtime)
                //                         );                                
                //                 }else{
                //                         if(isset($foldlist[$row->pid])){
                //                                 $foldlist[$row->pid]['child'] = 1;
                //                         }
                //                 }
                //         }                        
                // }


                $data = array(
                        'nav' => array(
                                'userinfo' => $this->user,
                                'group' => $this->grouplist,
                                'dep' => $this->deplist,
                                'school' => $this->school
                        )
                );        

                $data['thisfold'] = $thisfold;
                $data['type'] = 0;
                $data['pfname'] = $pfname;
                $data['fid'] = $fid;
                $data['prid'] = $prid;
                $data['pid'] = $pid;
                $data['plist']  = $plist;
                $data['flist'] = $file;
                $data['pname'] = $pname;
                $data['on'] = $on;
                $data['od'] = $od;
                $data['key'] = $key;
                $data['thisfold'] = $thisfold;
                $data['fold'] = $fold;

        $data['upload_url'] = $this->config->item('url','upload');
        $data['upload_chunk'] = $this->config->item('chunk','upload');

                $this->load->view('home/prep.php',$data);
        }

        public function coll(){
                $this->load->helper('util');

                $page = $this->input->get('page');
                $type = (int) $this->input->get('type');
                $key = db_escape_string($this->input->post('key'));

                $od = (int) $this->input->get('od');
                $on = $this->input->get('on');                

                if(!$od){
                        $od = 2;
                }
                if(!$on){
                        $on = 4;
                }
                                
                $desc = '';
                $odname = 'name';
                if($od == 2){
                        $desc = 'desc';
                }
                switch($on){
                        case 1:
                                $odname = 'name';
                                break;
                        case 2:
                                $odname = 'type';
                                break;
                        case 3:
                                $odname = 'size';
                                break;
                        case 4:
                                $odname = 'createtime';
                                break;                        
                }                

                $sql = 'SELECT a.id,a.fid,a.remark,a.time,b.name,c.size,c.path,c.type FROM usercollection a LEFT JOIN userfile b ON a.fid = b.fid LEFT JOIN files c ON a.fid = c.id WHERE a.uid ='.$this->user['id'];

                if($od){
                        $sql .= ' order by '.$odname.' '.$desc;
                }

                if($type){
                        $sql .= ' and c.type='.$type;
                }
                if($key){
                        $sql .= ' and b.name like "%'.$key.'%"';
                }

                $query = $this->db->query($sql);

                $flist = array();
                foreach($query->result() as $row){
                        $flist[$row->id] = array(
                                'id' => $row->id,
                                'fid' => $row->fid,
                                'name' => $row->name,
                                'remark' => $row->remark,
                                'time' => $row->time,
                                'size' => format_size($row->size),
                                'path' => $row->path,
                                'type' => $row->type
                         );
                }

                $data['flist'] = $flist;
                $data['type'] = $type;
                $data['key'] = $key;
                $data['od'] = $od;
                $data['on'] = $on;
                $this->load->view('home/coll.php',$data);
        }

        public function recy(){
                $this->load->helper('util');

                $type = (int) $this->input->get('type');
                $key = db_escape_string($this->input->get_post('key'));

                $pagenum = $this->config->item('pagenum');
                $nowpage = (int) $this->input->get('page');                

                $sql = 'select count(a.id) as anum from userfile a,files b where a.fid = b.id and a.del = 1 and a.uid='.$this->user['id'];
                if($type){
                        $sql .= ' and b.type='.$type;
                }
                if($key){
                        $sql .= ' and a.name like "%'.$key.'%"';
                }
                $query = $this->db->query($sql);
                $row = $query->row();
                $allnum = $row->anum;                

                $page = get_page_status($nowpage,$pagenum,$allnum);

                $sql = 'select a.id,a.fid,a.name,a.createtime,b.path,b.size,b.type from userfile a,files b where a.fid = b.id and a.del = 1 and a.uid='.$this->user['id'];
                if($type){
                        $sql .= ' and b.type='.$type;
                }
                if($key){
                        $sql .= ' and a.name like "%'.$key.'%"';
                }

                $sql .= ' limit '.$page['start'].','.$pagenum;        

                $query = $this->db->query($sql);
                $dlist = array();
                foreach($query->result() as $row){
                        $dlist[$row->id] = array(
                                'id' => $row->id,
                                'fid' => $row->fid,
                                'name' => $row->name,
                                'time' => $row->createtime,
                                'size' => format_size($row->size),
                                'path' => $row->path,
                                'type' => $row->type
                         );
                }

                $data['dlist'] = $dlist;
                $data['type'] = $type;
                $data['key'] = $key;
                $data['page'] = $page;
                $this->load->view('home/recy.php',$data);
        }

        public function my(){
                $data = array(
                        'nav' => array(
                                'userinfo' => $this->user,
                                'group' => $this->grouplist,
                                'dep' => $this->deplist,
                                'school' => $this->school
                        )
                );                        
                $this->load->view('home/index.php',$data);        
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */