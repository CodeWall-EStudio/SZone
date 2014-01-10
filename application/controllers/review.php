<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Review extends SZone_Controller {
 
	public function index(){
		$gid = (int) $this->input->get('gid');
		$fdid = (int) $this->input->get('fdid');
		$fid = (int) $this->input->get('fid');
		$id = (int) $this->input->get('id');
		$mail = (int) $this->input->get('m');
		$type = (int) $this->input->get('t');  //1 上一条 2 下一条

        $this->load->model('File_model');
        $file = $this->File_model->get_by_id($fid);
        if (empty($file))
        {
            show_error('文件不存在');
        }

        if (empty($gid)){
        		if($mail){
        			$auth = $this->File_model->check_msgid_by_uid($id,$fid, $this->user['id']);

	                if (empty($auth))
	                {
	                    show_error('用户没有查看此文件的权限');
	                }
        		}else{
        			$auth = $this->File_model->check_fileid_by_uid($fid, $this->user['id']);

	                if (empty($auth))
	                {
	                    show_error('用户没有查看此文件的权限');
	                }
        		}
        	
        }else{
                //$auth = $this->File_model->get_by_gid($id, $gid);
	     	$this->load->model('User_model'); 
	     	$in = $this->User_model->get_in_group($this->user['id'],$gid);
            //if (empty($auth))
	    	if(!$in)
            {
                show_error('用户没有查看此文件的权限');
            }
            //$auth['name'] = $auth['fname'];
        }

        if($mail){
        	$this->db->select('message.fid,userfile.id,userfile.name, userfile.content,files.type, files.mimes, files.path');
        	$this->db->from('message');
        	$this->db->join('userfile','message.fuid=userfile.uid');
        	$this->db->join('files','message.fid = files.id');
        	$query = $this->db->get();
        	$tablename = 'userfile';
        }else{
			$tablename = 'userfile';
			$fnames = 'a.name';
			if($gid){
				$fnames = 'a.fname as name';
				$tablename = 'groupfile'; 
			}

			$sql = 'select a.id,a.fid,'.$fnames.',a.content,b.path,b.size,b.type,b.mimes from '.$tablename.' a, files b where a.fid = b.id and b.id = '.$fid;
			if(!$gid){
				$sql .= ' and a.uid='.$this->user['id'];
			}	
			$query = $this->db->query($sql);		
		}


		// if($type == 1){
		// 	$sql .= ' and a.id < '.$fid.' limit 0,1';
		// }elseif($type ==2){
		// 	$sql .= ' and a.id > '.$fid.' limit 0,1';
		// }else{
		// 	$sql .= ' and b.id='.$fid;
		// }
		// echo $sql;

		//$docs = array('application/vnd.ms-word','application/vnd.ms-excel','application/vnd.ms-powerpoint','application/msword');

		//echo $this->db->affected_rows();
		
		$finfo = 0;
		if($this->db->affected_rows()>0){
			$row = $query->row();

			$finfo = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'name' => $row->name,
				'content' => $row->content,
				'path' => $row->path,
				'type' => (int) $row->type,
				'mimes' => $row->mimes
			);


			if($finfo['type']==2 && $finfo['mimes'] == 'text/plain'){
				$txt =  file_get_contents($finfo['path']);
				$order = array("\r\n", "\n", "\r");
				$txt = str_replace($order,'<br>',$txt);
				$finfo['text'] = $txt;
				//$finfo->text = file_get_contents($finfo->path);
			}
		}

		$wh = '';
		if($gid){
			$wh .= ' and gid='.$gid.' order by id desc';
		}else{
			$wh .= ' and uid='.$this->user['id'].' order by id desc';
		}
		$prev = 0;
		$next = 0;
		$prevfid = 0;
		$nextfid = 0;		
		$sql = 'select id,fid from '.$tablename.' where id<'.$id.$wh;

		$query = $this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$row = $query->row();
			$prev = $row->id;
			$prevfid = $row->fid;
		}

		$sql = 'select id,fid from '.$tablename.' where id>'.$id.$wh;
		$query = $this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$row = $query->row();
			$next = $row->id;
			$nextfid = $row->fid;
		}



		$data['finfo'] = $finfo;
		$data['gid'] = $gid;
		$data['id'] = $id;
		$data['prev'] = $prev;
		$data['next'] = $next;
		$data['prevfid'] = $prevfid;
		$data['nextfid'] = $nextfid;		

		$this->load->view('review',$data);
	}

	public function rev(){
		$gid = (int) $this->input->get('gid');
		$fdid = (int) $this->input->get('fdid');
		$fid = (int) $this->input->get('fid');
		$id = (int) $this->input->get('id');
		$type = (int) $this->input->get('t');  //1 上一条 2 下一条

        $this->load->model('File_model');
        $file = $this->File_model->get_by_id($fid);
        if (empty($file))
        {
            show_error('文件不存在');
        }

        if (empty($gid)){
                $auth = $this->File_model->get_by_uid($fid, $this->user['id']);
                if (empty($auth))
                {
                    show_error('用户没有查看此文件的权限');
                }        	
        }else{
        	$auth = $this->File_model->get_by_gid($id, $gid);
            if (empty($auth))
            {
                show_error('用户没有查看此文件的权限');
            }
            $auth['name'] = $auth['fname'];
        }


		$tablename = 'userfile';
		if($gid){
			$tablename = 'groupfile';
		}

		$sql = 'select a.id,a.fid,a.name,a.content,b.path,b.size,b.type,b.mimes from '.$tablename.' a, files b where a.fid = b.id and b.id = '.$fid;
		if(!$gid){
			$sql .= ' and a.uid='.$this->user['id'];
		}
		// if($type == 1){
		// 	$sql .= ' and a.id < '.$fid.' limit 0,1';
		// }elseif($type ==2){
		// 	$sql .= ' and a.id > '.$fid.' limit 0,1';
		// }else{
		// 	$sql .= ' and b.id='.$fid;
		// }
		// echo $sql;

		//$docs = array('application/vnd.ms-word','application/vnd.ms-excel','application/vnd.ms-powerpoint','application/msword');


		$query = $this->db->query($sql);
		$finfo = 0;
		if($this->db->affected_rows()>0){
			$row = $query->row();

			$finfo = array(
				'id' => $row->id,
				'fid' => $row->fid,
				'name' => $row->name,
				'content' => $row->content,
				'path' => $row->path,
				'type' => (int) $row->type,
				'mimes' => $row->mimes
			);

			if($finfo['type']==2 && $finfo['mimes'] == 'text/plain'){
				$txt =  file_get_contents($finfo['path']);
				$order = array("\r\n", "\n", "\r");
				$txt = str_replace($order,'<br>',$txt);
				$finfo['text'] = $txt;
				//$finfo->text = file_get_contents($finfo->path);
			}
		}

		$wh = '';
		if($gid){
			$wh .= ' and gid='.$gid.' order by id desc';
		}else{
			$wh .= ' and uid='.$this->user['id'].' order by id desc';
		}
		$prev = 0;
		$next = 0;
		$prevfid = 0;
		$nextfid = 0;		
		$sql = 'select id,fid from '.$tablename.' where id<'.$id.$wh;

		$query = $this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$row = $query->row();
			$prev = $row->id;
			$prevfid = $row->fid;
		}

		$sql = 'select id,fid from '.$tablename.' where id>'.$id.$wh;
		$query = $this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$row = $query->row();
			$next = $row->id;
			$nextfid = $row->fid;
		}


		$data['finfo'] = $finfo;
		$data['gid'] = $gid;
		$data['id'] = $id;
		$data['prev'] = $prev;
		$data['next'] = $next;
		$data['prevfid'] = $prevfid;
		$data['nextfid'] = $nextfid;		

		$this->load->view('review/rev',$data);
	}
}
