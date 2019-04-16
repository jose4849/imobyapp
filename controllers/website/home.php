<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->model('website/dealer_model', 'dealer');
        if (!$this->dealer->chkDealer($this->uri->segment(1))) {
            redirect('/register/login');
        }

        // Detect Mobile or PC
//        require_once(APPPATH . 'libraries/Mobile_Detect.php');
//        $detect = new Mobile_Detect;
//        if ($detect->isMobile()) {
//            $uri = $this->uri->segment(1) . '/mobile/';
//            for ($i = 3; $i <= $this->uri->total_segments(); $i++) {
//                $uri .= $this->uri->segment($i) . '/';
//            }
//            redirect($uri);
//        }
    }

    public function index() {
        $data = array();

        $this->load->model('website/car_model', 'car');
        $data['cars'] = $this->car->getCarDetails($this->uri->segment(1));

        $this->load->view('website/website', $data);
    }

    public function test($val = "") {
        echo 'website-home-test-' . $val;
    }

}
