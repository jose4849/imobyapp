<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('validated')) {
            redirect('login');
        }
    }

    public function index() {
  
        $data = array();
        $data['activeMenu'] = "";
        $this->load->library('pagination');
        $config['base_url'] = base_url() . "backend/page/";
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $this->db->count_all('page');
        $config['per_page'] = 20;
        $config["uri_segment"] = 5;
        $config['next_link'] = '';
        $config['next_tag_open'] = '';
        $config['next_tag_close'] = '';
        $config['prev_link'] = '';
        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';
        $config['display_pages'] = True;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $this->load->model('page_model', 'page_model');
        $data['results'] = $this->page_model->all_page_show($config['per_page'], $this->uri->segment(4));
        $data['content'] = $this->load->view('backend/pages/pages_show', $data, true);
        $data['header'] = $this->load->view('backend/layout/header', $data, true);
        $data['menu'] = $this->load->view('backend/layout/menu', $data, true);
        $data['footer'] = $this->load->view('backend/layout/footer', $data, true);
        $this->load->view('backend/home', $data);

    }

    public function add() {
        $data = array();
        $data['content'] = $this->load->view('backend/pages/pages_add', $data, true);
        $data['header'] = $this->load->view('backend/layout/header', $data, true);
        $data['menu'] = $this->load->view('backend/layout/menu', $data, true);
        $data['footer'] = $this->load->view('backend/layout/footer', $data, true);
        $this->load->view('backend/home', $data);
    }

    public function save_page() {
        $data['page_title'] = $this->input->post('page_title');
        $data['page_content'] = $this->input->post('page_content');
        $data['author_id'] = $this->session->userdata('userid');
        $slugmain=strtolower(str_replace(' ', '-', $data['page_title']));       
        $check=$this->slugcheck($slugmain);
        $x=1;
        if($check==2){
          $slug=  $slugmain;
        }
        while($check==1){
            $slug=$slugmain."-".$x;
            $check=$this->slugcheck($slug);
            $x++;
        }
        $data['slug']=$slug;
        //print_r($data);
        $this->load->model('page_model', 'page_model');
        $this->page_model->page_save($data);
        echo "Successfully Save";
    }
    public function slugcheck($slug){     
      $ql = $this->db->select('*')->from('page')->where('slug', $slug)->get();
      $result=$ql->result();      
      if ($ql->num_rows() > 0) {
        return 1;        
      }
      else{
         return 2;
      }
      
    }
    public function pagedelete(){
        $id=$this->input->post('page_id');
        $this->db->delete('page', array('page_id' => $id));
        echo "Page is successfully Deleted.";
    }
    public function edit(){
        $data=array();
        $page_id=$this->uri->segment(4);
        $ql = $this->db->select('*')->from('page')->where('page_id',$page_id)->get();
        $result=$ql->result();
        $data['result']=$result[0];
        $data['content'] = $this->load->view('backend/pages/pages_edit', $data, true);
        $data['header'] = $this->load->view('backend/layout/header', $data, true);
        $data['menu'] = $this->load->view('backend/layout/menu', $data, true);
        $data['footer'] = $this->load->view('backend/layout/footer', $data, true);
        $this->load->view('backend/home', $data);
    }
    public function update_page() {
        $data['page_title'] = $this->input->post('page_title');
        $data['page_id'] = $this->input->post('page_id');
        $data['page_content'] = $this->input->post('page_content');
        $data['author_id'] = $this->session->userdata('userid');
       /* $slugmain=strtolower(str_replace(' ', '-', $data['page_title']));       
        $check=$this->slugcheck($slugmain);
        $x=1;
        if($check==2){
          $slug=  $slugmain;
        }
        while($check==1){
            $slug=$slugmain."-".$x;
            $check=$this->slugcheck($slug);
            $x++;
        }
        $data['slug']=$slug;
        //print_r($data); */
        
        $this->load->model('page_model', 'page_model');
        $this->page_model->page_update($data);
        echo "Page Update successfully";
    }

}
