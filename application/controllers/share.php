<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Share extends SZone_Controller {

    public function other(){
        //$type = $this->input->get('type');
        $gid = (int) $this->input->get('gid');
        $id = $this->input->get('id');

        $il = explode(',',$id);
        $kl = array();
        foreach($il as $k){
            array_push($kl,$k);
        }

        if($gid){
            $this->load->model('Gf_model');
            $nl = $this->Gf_model->get_by_gid_ids($gid, $kl);
        }else{
            $this->load->model('Uf_model');
            $nl = $this->Uf_model->get_by_uid_ids($this->user['id'], $kl);
        }

        $this->load->model('User_model');
        $ul = $this->User_model->get_other($this->user['id']);

        $data = array('fl' => $nl,'type' => 0,'gid' => $gid,'ul' => $ul);
        $this->load->view('share/other.php',$data);
    }


    public function group(){
        //$type = $this->input->get('type');
        $gid = (int) $this->input->get('gid');
        $id = $this->input->get('id');

        $il = explode(',',$id);
        $kl = array();
        foreach($il as $k){
            array_push($kl,$k);
        }

        if($gid){
            $this->load->model('Gf_model');
            $nl = $this->Gf_model->get_by_ids($kl,$gid);
        }else{
            $this->load->model('Uf_model');
            $nl = $this->Uf_model->get_by_ids($this->user['id'], $kl);
        }

        $sql = 'select a.id,a.name from groups a,groupuser b where a.id = b.gid and a.type = 1 and a.id != '.$gid.' and b.uid='.$this->user['id'];
        $query = $this->db->query($sql);
        $gl = array();
        foreach($query->result() as $row){
            $gl[$row->id] = array(
                'id' => $row->id,
                'name' => $row->name
            );
        }

        $data = array('fl' => $nl,'type' => 1,'gid' => $gid,'gl' => $gl);
        $this->load->view('share/group.php',$data);
    }


    public function dep(){
        //$type = $this->input->get('type');
        $gid = (int) $this->input->get('gid');
        $id = $this->input->get('id');

        $il = explode(',',$id);
        $kl = array();
        foreach($il as $k){
            array_push($kl,$k);
        }

        if($gid){
            $this->load->model('Gf_model');
            $nl = $this->Gf_model->get_by_ids($kl,$gid);
        }else{
            $this->load->model('Uf_model');
            $nl = $this->Uf_model->get_by_ids($this->user['id'], $kl);
        }


        $sql = 'select a.id,a.name from groups a,groupuser b where a.id = b.gid and a.type = 2 and a.id != '.$gid.'  and a.pt=0 and b.uid='.$this->user['id'];
        $query = $this->db->query($sql);
        $gl = array();
        foreach($query->result() as $row){
            $gl[$row->id] = array(
                'id' => $row->id,
                'name' => $row->name
            );
        }
        $data = array('fl' => $nl,'type' => 2,'gid' => $gid,'gl' => $gl);
        $this->load->view('share/dep.php',$data);
    }



}