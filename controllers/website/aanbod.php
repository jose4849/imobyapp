<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aanbod extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('mobile/dealer_model', 'dealer');
        if (!$this->dealer->chkDealer($this->uri->segment(1))) {
            redirect('/register/login');
        }
    }

    public function index() {
        $data = array();

        $this->load->view('website/aanbod', $data);
    }

    public function test($val = "") {
        echo 'website-aanbod-test-' . $val;
    }

}
