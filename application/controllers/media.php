<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends SZone_Controller {

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
     * @see http://codeigniter.comuploser_guide/general/urls.html
     */


    public function index() {

        $fold_name = $this->config->item('name', 'media');
        $this->load->model('Fold_model');
        $fold = $this->Fold_model->get_user_fold_by_name($this->user['id'], $fold_name);

        if (count($fold) == 0) {
            $fold = array(
                'pid' => 0,
                'name' => $fold_name,
                'uid' => $this->user['id'],
                'mark' => '特殊目录',
                'createtime' => time(),
                'type' => 1
            );
            $fold_id = $this->Fold_model->insert_user_fold($fold);
        } else {
            $fold_id = $fold[0]->id;
        }

        $this->load->model('Uf_model');
        $data = $this->Uf_model->get_user_file_by_group($this->user['id'], $fold_id);

        $this->json($data, 200, 'ok');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
