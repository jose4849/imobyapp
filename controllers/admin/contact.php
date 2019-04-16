<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->ion_auth->logged_in();
        $this->ion_auth->in_group('admin');
       
    }

    public function index() {		
    
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Contact";
        $data['activeTab'] = "contact";
        $this->load->view('admin/layout/contact', $data);        
        
    }
}
