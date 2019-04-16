<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
    }

    public function index() {
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $this->load->view('user/home', $data);
    }
}
