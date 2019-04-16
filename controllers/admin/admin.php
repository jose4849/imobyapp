<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        echo $this->ion_auth->logged_in();
        echo $this->ion_auth->in_group('admin');
        /*
        if (!$this->ion_auth->logged_in())
            redirect('login', 'refresh');
        if (!$this->ion_auth->in_group('superadmin') || !$this->ion_auth->in_group('admin'))
            redirect('login', 'refresh');
         // if (!$this->ion_auth->logged_in() && (!$this->ion_auth->in_group('superadmin') || !$this->ion_auth->in_group('admin')))
         //     redirect('login', 'refresh'); */
    }

    public function index() {	
        die();
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "user";
        $this->load->view('admin/home', $data);
    }
    function contact(){
        die('hello');
    }
}
