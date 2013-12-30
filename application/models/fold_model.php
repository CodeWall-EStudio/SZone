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
    protected $gtable = 'groupfolds';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
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
}