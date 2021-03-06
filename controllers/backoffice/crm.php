<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group('dealer'))
            redirect('login', 'refresh');
    }

    public function blank() {
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Contact";
        $data['activeTabHeader'] = "crm";
        $data['activeTab'] = "contact";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $this->load->view('backoffice/default/crm', $data);
    }

}

?>
