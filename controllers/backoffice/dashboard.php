<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group('dealer'))
           redirect('login', 'refresh');
    }

    public function index() {
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Dashboard";
        $data['activeTabHeader'] = "dashboard";
        $data['activeTab'] = "dashboard";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $dealer_id = $data['dealer'][0]->dealer_id;
        $emails = $this->db->query("select * from email where dealer_id = $dealer_id and box = 'inbox' LIMIT 0 , 3 ");
        $data['count'] = $emails->num_rows();
        $data['email'] = $emails->result();
        $emails = $this->db->query("select * from email where dealer_id = $dealer_id and box = 'anbox' LIMIT 0 , 3 ");
        $data['count'] = $emails->num_rows();
        $data['annbod'] = $emails->result();
        $this->load->view('backoffice/dashboard/dashboard', $data);
    }

}
