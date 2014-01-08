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
class Uf_model extends CI_Model {

    protected $table = 'userfile';
    protected $ftable = 'files';
    protected $ctable = 'usercollection';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }	

    function get_filenum_byid($id,$uid){
    	$this->db->where_in('id',$id);
    	$this->db->where('uid',$uid);
    	$query = $this->db->get($this->table);
    	if($query->num_rows()){
            return $query->row();
        }else{
            return false;
        };
    }

    function get_file_byid($id,$uid){
        $this->db->where_in('id',$id);
        $this->db->where('uid',$uid);
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0){
            $list = array();
            foreach($query->result_array() as $row){
                $list[$row['id']] = $row;
            };
            return $list;
        }else{
            return false;
        };
    }

    function get_by_uid_ids($uid, $ids)
    {
        $this->db->select('id, fid, name');
        $this->db->where('uid',$uid);
        $this->db->where_in('id',$ids);
        $query = $this->db->get($this->table);

        $rl = array();

        foreach($query->result() as $row){
            array_push($rl,array(
                'id' => $row->id,
                'fid' => $row->fid,
                'name' => $row->name
            ));
        }
        return $rl;
    }

    function get_by_ids($id,$ids)
    {
        $this->db->select('id, fid, name');
        $this->db->where('uid',$id);
        $this->db->where_in('id',$ids);
        $query = $this->db->get($this->table);
        $result = array();
        foreach($query->result() as $row){
            array_push($result,array(
                'id' => $row->id,
                'fid' => $row->fid,
                'name' => $row->name
            ));
        }

        return $result;
    }

    function get_all_filenum($id,$fdid=0,$key=0,$type=0){
        $this->db->select('userfile.id');
        $this->db->from($this->table);
        $this->db->where('userfile.uid',$id);
        $this->db->join($this->ftable,'files.id=userfile.fid');
        //if($fdid){
            $this->db->where('userfile.fdid',$fdid);
        //}
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

    function get_fileinfo($id,$fdid=0,$key=0,$type=0,$on=0,$desc=0,$start=0,$pagenum=10){
        $this->db->select('userfile.id,userfile.fid,userfile.name,userfile.createtime,userfile.content,files.type,files.size');
        $this->db->from($this->table);
        $this->db->join($this->ftable,'files.id=userfile.fid');
        $this->db->where('uid',$id);
        $this->db->where('userfile.del',0);
        // $this->db->where('userfile.prid',0);
        //if($fdid){
            $this->db->where('fdid',$fdid);
        //}
        if($type){
            $this->db->where('files.type',$type);
        }
        if($key){
            $this->db->like('userfile.name',$key);
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
                'name' => $row->name,
                'time' => substr($row->createtime,0,10),
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

    function get_prep_byid($id,$fdid,$key=0,$type=0,$on=0,$desc=0,$start=0,$pagenum=10){
        if(!$fdid){
            return array();
        }
        //$sql = 'select a.id,a.fid,a.name,a.createtime,b.type,b.size from userfile a,files b where a.del = 0 and a.prid = b.id and uid = '.$this->user['id'];
        $this->db->select('userfile.id, userfile.fid, userfile.name, userfile.createtime, userfile.content, files.type, files.size');
        $this->db->from($this->table);
        $this->db->join($this->ftable,'files.id=userfile.fid');        
        $this->db->where('userfile.uid',$id);
        $this->db->where('userfile.prid',$fdid);
        $this->db->where('userfile.del',0);
        if($type){
            $this->db->where('files.type',$type);
        }
        if($key){
            $this->db->like('userfile.name',$key);
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
                'name' => $row->name,
                'time' => substr($row->createtime,0,10),
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

    function get_allprep_num($id,$fdid=0,$key=0,$type=0){
        $this->db->select('count(id) as allnum');
        $this->db->where('uid',$id);
        $this->db->where('prid',$fdid);
        $query = $this->db->get($this->table);
        $row = $query->row();

        if($this->db->affected_rows() > 0){
            return $row->allnum;
        }else{
            return 0;
        }
    }

    function get_user_file_by_group($uid, $fdid)
    {
        $query = $this->db->get_where($this->table, array('uid' => $uid, 'fdid' => $fdid));
        return $query->result();
    }
}