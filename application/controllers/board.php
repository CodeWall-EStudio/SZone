<?
class Board extends SZone_Controller {
 
	public function index(){
		$gid = (int) $this->input->get('gid');
		$uid = (int) $this->input->get('uid');
		$fid = (int) $this->input->get('fid');
		$key = $this->input->get('key');

		$inGroup = false;
        if ($this->user['uid'] != 0){
            $this->load->model('User_model');
           	$inGroup = $this->User_model->get_in_group($this->user['uid'],$gid);
        }	

		$sql = 'select a.id,a.content,a.uid,a.ctime,b.name from board a,user b where a.uid = b.id and a.ttype = 1 and a.gid='.$gid;
		if($key){
			$sql .= ' and a.content like "%'.$key.'%"';
		}

		$query = $this->db->query($sql);

		$blist = array();
		foreach($query->result() as $row){
			$blist[$row->id] = array(
					'id' => $row->id,
					'content' => $row->content,
					'a.uid' => $row->uid,
					'time' => $row->ctime,
					'name' => $row->name
				);
		}

		$data['blist'] = $blist;
		$data['inGroup'] = $inGroup;
		if(isset($this->grouplist[$gid])){
			$data['ginfo'] = $this->grouplist[$gid];
		}else{
			$data['ginfo'] = array();
		}

		$this->load->view('board',$data);
	}
}