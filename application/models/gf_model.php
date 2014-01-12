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
class Gf_model extends CI_Model {

    protected $table = 'groupfile';
    protected $gtable = 'groupfolds';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }	

    function get_all_filenum($id,$fdid=array(),$key=0,$type=0){
        $this->db->select('userfile.id');
        $this->db->from($this->table);
        $this->db->where('userfile.uid',$id);
        $this->db->join($this->ftable,'files.id=userfile.fid');
        //if($fdid){.
        if(count($fdid)>0){
            $this->db->where_in('userfile.fdid',$fdid);
        }
        $this->db->where('userfile.del',0);
        if($type){
            
            $this->db->where('files.type',$type);
        } 
        if($key){
            $this->db->like('userfile.name',$key);
        }  

        $query = $this->db->get();
        //echo  $query->num_rows();  
        return $query->num_rows();      
    }

    function get_prep_byid($id,$prid,$fdid=0,$key=0,$type=0,$on=0,$desc=0,$start=0,$pagenum=10){
        if(!$prid){
            return array();
        }
        //$sql = 'select a.id,a.fid,a.name,a.createtime,b.type,b.size from userfile a,files b where a.del = 0 and a.prid = b.id and uid = '.$this->user['id'];
        $this->db->select('groupfile.id, groupfile.fid, groupfile.fname, groupfile.createtime, groupfile.content, files.type, files.size');
        $this->db->from($this->gtable);
        $this->db->join($this->ftable,'files.id=groupfile.fid');        
        $this->db->where('groupfile.uid',$id);
        $this->db->where('groupfile.gid',$prid);
        $this->db->where('groupfile.fdid',$fdid);
        $this->db->where('groupfile.del',0);
        if($type){
            $this->db->where('files.type',$type);
        }
        if($key){
            $this->db->like('groupfile.fname',$key);
        }
        $this->db->limit($pagenum,$start);
        if($on){
            $this->db->order_by($on,$desc);
        }

        $query = $this->db->get();

        $file = array();
        $ids = array();

        foreach($query->result() as $row){
            array_push($ids,$row->fid);
            $file[$row->id] = array(
                'id' => $row->id,
                'fid' => $row->fid,
                'name' => $row->fname,
                'time' => date('Y-m-d',$row->createtime),
                'content' => $row->content,
                'size' => format_size($row->size),
                'type' => $row->type,
                'coll' => 0
            );            
        }

        $this->db->select('fid');
        $this->db->where_in($ids);
        $query = $this->db->get($this->ctable);

        $ids = array();
        foreach($query->result() as $row){
            array_push($ids,$row->fid);
        }

        //echo json_encode($ids);

        foreach($file as &$row){
            if(in_array($row['fid'],$ids)){
                $row['coll'] = 1;
            }
        }

        return $file;        
    }        

    function get_filenum_byfid($fid,$gid){
    	$this->db->where('gid',$gid);
    	$this->db->where_in('fid',$fid);
    	$query = $this->db->get($this->table);

    	$ids = array();
    	foreach($query->result() as $row){
    		array_push($ids,$row->fid);
    	}
    	return $ids;
    }

    function get_by_gid_ids($gid, $ids)
    {
        $this->db->select('id, fid, fname');
        $this->db->where('gid',$gid);
        $this->db->where_in('id',$ids);
        $query = $this->db->get($this->table);

        $result = array();
        foreach($query->result() as $row){
            array_push($result,array(
                'id' => $row->id,
                'fid' => $row->fid,
                'name' => $row->fname
            ));
        }
        return $result;
    }

    function get_by_ids($ids,$gid)
    {
        $this->db->select('id, fid, fname');
        $this->db->where_in('id',$ids);
        $this->db->where('gid',$gid);
        $query = $this->db->get($this->table);

        $result = array();
        foreach($query->result() as $row){
            array_push($result,array(
                'id' => $row->id,
                'fid' => $row->fid,
                'name' => $row->fname
            ));
        }
        return $result;
    }

    function check_auth_byid($fid,$gid,$uid){
        $this->db->select('id');
        $this->db->select('uid',$uid);
        $this->db->select('gid',$gid);
        $this->db->select('id',$fid);

        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

}