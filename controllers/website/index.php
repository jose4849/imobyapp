<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('mobile/dealer_model', 'dealer');
        if (!$this->dealer->chkDealer($this->uri->segment(1))) {
            redirect('/register/login');
        }
    }

    public function index() {
        die();
        $uri = $this->uri->segment(1) . '/website/';
        redirect($uri);
    }

}
