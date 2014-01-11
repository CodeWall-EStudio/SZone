<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SZone Application Model Class
 *
 * This class object extends from the CodeIgniter super class CI_Model.
 *
 * @package		SZone
 * @subpackage	application
 * @category	models
 * @author		Code Wall-E Studio
 * @link		http://codewalle.com
 */
class Fold_model extends CI_Model {

    protected $utable = 'userfolds';
    protected $ftable = 'groupfile';
    protected $gtable = 'groupfolds';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }	

    function del_group_fold($id,$gid){
        if(!$id && !$gid){
            return false;
        }

        $this->db->where('gid',$gid);
        $this->db->where_in('fdid',$id);
        $this->db->delete($this->ftable);    

        $this->db->where_in('pid',$id);
        $this->db->delete($this->gtable);

        $this->db->where_in('id',$id);
        $this->db->delete($this->gtable); 

        return $this->db->affected_rows();
        //return true;       

    }    

    function get_user_normal_folds($uid,$fid,$key,$od,$on){
    	$fid = (int) $fid;
    	$uid = (int) $uid;

    	$folds = array();
    	$flist = array();
    	$thisfold = array(
    		'id' => 0,
    		'pid' => 0
    	);
    	if($uid){
    		$sql = 'select id,name,mark,createtime,pid,tid,idpath from '.$this->utable.' where prid=0 and uid = '.$uid;
			if($key){
				$sql .= ' and name like "%'.$key.'%"';
			}	
			if($od && $on !=2 && $on != 3){
				$sql .= ' order by '.$odname.' '.$desc;
			}

    		$query = $this->db->query($sql);

    		foreach($query->result() as $row){
				if($row->id == $fid){
					$thisfold = array(
						'id' => $row->id,
						'pid' => $row->pid,
						'name' => $row->name,
						'tid' => $row->tid,
						'idpath' => explode(',',$row->idpath)
					);
				}
				if($row->pid == 0){
					if(isset($folds[$row->id])){
						$folds[$row->id]['id'] = $row->id;
						$folds[$row->id]['name'] = $row->name;
						$folds[$row->id]['mark'] = $row->mark;
						$folds[$row->id]['pid'] = (int) $row->pid;
						$folds[$row->id]['tid'] = (int) $row->tid;
						$folds[$row->id]['time'] = date('Y-m-d',$row->createtime);
					}else{
						$folds[$row->id] = array(
							'id' => $row->id,
							'name' => $row->name,
							'mark' => $row->mark,
							'pid' => (int) $row->pid,
							'tid' => (int) $row->tid,
							'time' => date('Y-m-d',$row->createtime)
						);	
					}			
				}else{
					if($row->pid = $fid){
						$flist[$row->id] = array(
							'id' => $row->id,
							'name' => $row->name,
							'mark' => $row->mark,
							'pid' => (int) $row->pid,
							'tid' => (int) $row->tid,
							'time' => date('Y-m-d',$row->createtime)
						);	
					}
					if(isset($folds[$row->pid])){
						$folds[$row->pid]['child'] = 1;
					}
				}
    		}
    	}
    	$fold = array(
    		'this' => $thisfold,
    		'list' => $folds,
    		'nowlist' => $flist,
    		'allnum' => $query->num_rows()
    	);
    	return $fold;
    }

    function get_prep_byid($id,$gid,$fdid = 0){
        $this->db->select('id, name, mark, createtime, pid, tid, idpath');
        $this->db->where('uid',$id);
        $this->db->where('gid',$gid);
        $this->db->where('pid',$fdid);
        $this->db->or_where('id',$fdid);

        $query = $this->db->get($this->gtable);

        $fl = array();
        $tf = array(
            'id' => 0,
            'pid' => 0            
        );
        foreach($query->result() as $row){
            if($row->id == $fdid){
                $tf = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'mark' => $row->mark,
                    'pid' => (int) $row->pid,
                    'tid' => (int) $row->tid,
                    'idpath' => $row->idpath,
                    'time' => date('Y-m-d',$row->createtime)                
                );
            }else{
                $fl[$row->id] = array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'mark' => $row->mark,
                    'pid' => (int) $row->pid,
                    'tid' => (int) $row->tid,
                    'time' => date('Y-m-d',$row->createtime)                
                );
            }
        }
        return array('this' => $tf,'list' => $fl);
    }

    function get_prep_bypid($id,$gid,$fdid = 0){
        $this->db->select('id, name, mark, createtime, pid, tid, idpath');
        $this->db->where('uid',$id);
        $this->db->where('gid',$gid);
        $this->db->where('id',$fdid);

        $query = $this->db->get($this->gtable);

        $fl = array();
        foreach($query->result() as $row){
            $fl[$row->id] = array(
                'id' => $row->id,
                'name' => $row->name,
                'mark' => $row->mark,
                'pid' => (int) $row->pid,
                'tid' => (int) $row->tid,
                'idpath' => $row->idpath,
                'time' => date('Y-m-d',$row->createtime)                
            );
        }
        return $fl;
    }    

    function update_prep_byid($id,$name){
    	$data = array(
    		'name' => $name
    	);

        $this->db->update($this->utable, $data, array('prid' => $id,'pid' => 0));    	
    }

    function get_child_prep($pid,$uid){
    	$this->db->where('pid',$pid);
    	$this->db->where('uid',$uid);
    	$query = $this->db->get($this->utable);
    	return  $query->num_rows();
    }

    function get_prep_fold($pid,$uid){
    	$this->db->where('prid',$pid);
    	$this->db->where('pid',0);
    	$this->db->where('uid',$uid);
    	$query = $this->db->get($this->utable);
    	$row = $query->row();
    	if($row){
	    	$id = $row->id;
	    	$child = $this->get_child_prep($id,$uid);
	    	return array(
	    			'id' => $id,
	    			'child' => $child
	    		);
    	}else{
    		return false;
    	}
    }

    function check_fold_limit($name){
        $limit = $this->config->item('userfold');
        if(in_array($name,$limit)){
            return true;
        }else{
            return false;
        }
    }

    function check_user_folds_limit($id,$uid){
        $limit = $this->config->item('userfold');
        $this->db->select('id,name');
        $this->db->where('uid',$uid);
        $this->db->where_in('id',$id);
        $query = $this->db->get($this->utable);

        $ids = array();
        foreach($query->result() as $row){
            if(!in_array($row->name,$limit)){
                array_push($ids,$row->id);
            }
        }
        return $ids;
    }

    function get_user_fold_by_name($uid, $name)
    {
        $query = $this->db->get_where($this->utable,array('uid' => $uid, 'name' => $name));
        return $query->result();
    }

    function insert_user_fold($fold)
    {
        $str = $this->db->insert_string($this->utable, $fold);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    function get_prepfold_user($prid, $ud = 0, $fdid=0, $gr = 0,$tag = 0){
        
    }

    function get_groupfold_byid($id,$gid,$fdid=0){
        $this->db->select('id,name,gid,pid');
        $this->db->where('uid',$id);
        $this->db->where('gid',$gid);
        $query = $this->db->get($this->gtable);

        $rl = array();

        foreach($query->result() as $row){
            if($fdid == $row->pid){
                if(!isset($rl[$row->id])){
                    $rl[$row->id] = array(
                        'id' => $row->id,
                        'name' => $row->name,
                        'gid' => $row->gid
                    );           
                }else{
                    $rl[$row->id]['id'] = $row->id;
                    $rl[$row->id]['name'] = $row->name;
                    $rl[$row->id]['gid'] = $row->gid;
                }
            }else{
                if(!isset($rl[$row->pid])){
                    $rl[$row->pid] = array(
                        'child' => 1
                    );
                }else{
                    $rl[$row->pid]['child'] = 1;
                }
            }
        }
        return $rl;
    }
}
