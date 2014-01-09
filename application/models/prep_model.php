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
class Prep_model extends CI_Model {

    protected $table   = 'user';
    protected $gtable   = 'groupuser';
    protected $ftable   = 'files';
    protected $gptable = 'groups';
    protected $gotable = 'groupfolds';
    protected $gftable = 'groupfile';

    function get_prepinfo_byid($prid,$gr =0 ,$tag = 0){
    	$this->db->select('parent');
    	$this->db->where('id',$prid);
    	$query = $this->db->get($this->gptable);

    	$row = $query->row();
    	if($row->parent > 0){
    		return false;
    	}else{
    		$this->db->select('id');
    		$this->db->where('parent',$prid);
    		if($gr){
    			$this->db->where('grade',$gr);
    		}
    		if($tag){
    			$this->db->where('tag',$tag);
    		}
    		$query = $this->db->get($this->gptable);
    		$rl = array();
    		foreach($query->result() as $row){
    			array_push($rl,$row->id);
    		}
    		return $rl;
    	}
    	
    }

    function get_prep_bypid($prid, $gr = 0,$tag = 0, $ud = 0){
    	$this->db->select('groups.id, groups.name, user.nick, user.id as uid');
    	$this->db->from($this->gptable);
        $this->db->join($this->gtable,'groupuser.gid=groups.id');
        $this->db->join($this->table,'user.id=groupuser.uid');  
        //没有选年级和科目   	
   		$this->db->where_in($this->gptable.'.id',$prid);

        $this->db->where('groups.type',3);
        if($ud){
        	$this->db->where($this->table.'.id',$ud);
        }
        $query = $this->db->get();

        $rl = array();

        foreach($query->result() as $row){
            array_push($rl,array(
                'gid' => $row->id,
                'name' => $row->name,
                'nick' => $row->nick,
                'uid' => $row->uid,
                'pid' => -1,
                'fdid' => 0
            ));
        }       
        return $rl;	        
    }

    function get_prepfold_byid($id,$gid,$fdid=0){
        $this->db->select('nick');
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        $row = $query->row();
        $nick = $row->nick;

    	$this->db->select('groupfolds.id, groupfolds.name, groupfolds.createtime, groupfolds.pid');
    	$this->db->from($this->gotable);
    	$this->db->join($this->gptable,'groupfolds.gid=groups.id');
    	$this->db->where('groups.id',$gid);
    	$this->db->where('groupfolds.gid',$gid);
    	$this->db->where('groupfolds.uid',$id);
    	$this->db->where('groupfolds.pid',$fdid);
    	$query = $this->db->get();

    	$rl = array();

    	foreach($query->result() as $row){
    		$rl[$row->id] = array(
    			'fdid' => $row->id,
                'pid' => $row->pid,
    			'gid' => $gid,
    			'uid' => $id,
                'nick' => $nick,
    			'name' => $row->name,
    			'createtime' => $row->createtime
    		);
    	}
    	return $rl;
    }

    function get_prepfile_byid($id,$gid,$fdid=0,$key = 0){
        $this->db->select('groupfile.id, groupfile.fname, groupfile.createtime, groupfile.content, files.type, files.size, files.id as fid');
        $this->db->from($this->gftable);
        $this->db->join($this->ftable,'files.id=groupfile.fid');
        $this->db->where('groupfile.gid',$gid);
        $this->db->where('groupfile.uid',$id);
        $this->db->where('groupfile.fdid',$fdid);
        if($key){
            $this->db->like('groupfile.fname',$key);
        }
        $query = $this->db->get();

        $rl = array();

        foreach($query->result() as $row){
            $rl[$row->id] = array(
                'id' => $row->id,
                'fid' => $row->fid,
                'gid' => $gid,
                'uid' => $id,
                'name' => $row->fname,
                'mark' => $row->content,
                'type' => $row->type,
                'size' => format_size($row->size),
                'createtime' => $row->createtime
            );
        }
        return $rl;
    }    

	function get_prep_user(){
        $this->db->select('groups.id, groups.name, user.nick, user.id as uid');
        $this->db->from($this->gptable);
        $this->db->join($this->gtable,'groupuser.gid=groups.id');
        $this->db->join($this->table,'user.id=groupuser.uid');
        $this->db->where('groups.type',3);

        $query = $this->db->get(); 

        $rl = array();
        foreach($query->result() as $row){
            array_push($rl,array(
                'gid' => $row->id,
                'name' => $row->name,
                'nick' => $row->nick,
                'uid' => $row->uid,
                'fdid' => 0
            ));
        }       

        return $rl;		
	}


    function get_userprep_byuid($id){

    }

    function get_prep_group_byid($id){
        $this->db->select('id, name');
        $this->db->where('type',3);
        $this->db->where('parent',0);
        $query = $this->db->get($this->gptable);

        $pl = array();
        foreach($query->result() as $row){
            $pl[$row->id] = array(
                'id' => $row->id,
                'name' => $row->name
            );
        }

        $this->db->select('groups.id,groups.name,groups.parent');
        $this->db->from($this->gptable);
        $this->db->join($this->gtable, $this->gtable.'.gid='.$this->gptable.'.id');
        $this->db->where($this->gtable.'.uid',$id);
        $this->db->where($this->gptable.'.type',3);

        $query = $this->db->get();

        $rl = array();
        $pids = array();
        foreach($query->result() as $row){
            if(!isset($rl[$row->parent])){
                $rl[$row->parent] = array(
                    'id' => $pl[$row->parent]['id'],
                    'name' => $pl[$row->parent]['name'],
                    'list' => array()
                );
            }
            array_push($pids,$row->id);
            $rl[$row->parent]['list'][$row->id] = array(
                'id' => $row->id,
                'name' => $row->name
            );            
        }

        $this->db->select('gid');
        $this->db->where_in('gid',$pids);
        $this->db->where('uid',$id);

        $query = $this->db->get($this->gotable);
        $fids = array();
        foreach($query->result() as $row){
            array_push($fids,$row->gid);
        }

        foreach($rl as &$row){
            if(isset($row['list'])){
                foreach($row['list'] as &$k){
                    if(in_array($k['id'],$fids)){
                        $k['child'] = 1;
                    }
                }
            }
        }

        return $rl;
    }   
    
    function get_prepchild_byid($id,$gid){
        $this->db->select('id,name');
        $this->db->where('gid',$gid);
        $this->db->where('uid',$uid);
    }
}