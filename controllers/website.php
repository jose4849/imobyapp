<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Website extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $homePageId = $this->uri->segment(1);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $data['DealerInfo'] = $queryresult;
            $homePageEnabled = $queryresult[0]->homePageEnabled;
            if ($homePageEnabled == 1) {
                $user_id = $queryresult[0]->user;
                $dealer_id = $data['dealer_id'] = $queryresult[0]->dealer;
                /* coloer schame start */
                $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer_id and attribute = 'colorschrme'");
                $colorschme = $colorschmes->result();
                if (isset($colorschme[0])) {
                    $data['colorschme'] = $colorschme[0]->value;
                } else {
                    $data['colorschme'] = 'nocolor';
                }
                /* coloer schame start */
                $data['stockPageId'] = $queryresult[0]->stockPageId;
                $data['homePageId'] = $queryresult[0]->homePageId;
                /*  --------------website_information start--------------------  */

                $results = $this->db->query("select * from website where dealer_id = $dealer_id and page_status = 1");
                $rpage = $results->result();
                $page_list = array();
                $page_title = array();
                foreach ($rpage as $res) {
                    $page_slug = $res->page_slug;
                    $pagetitle = $res->page_title;
                    if ($page_slug == 'home') {
                        $data['home'] = $res;
                    }
                    if ($page_slug == 'annbod') {
                        $data['annbod'] = $res;
                    }
                    if ($page_slug == 'contact') {
                        $data['contact'] = $res;
                    }
                    if (($page_slug != 'home') && ($page_slug != 'annbod') && ($page_slug != 'contact')) {
                        $page_list[] = $page_slug;
                        $page_title[] = $pagetitle;
                        $data['info'][$page_slug] = $res;
                    }
                }
                $data['pages'] = $page_list;
                $data['pages_title'] = $page_title;
                $data['user_id'] = $queryresult[0]->dealer;
                /* website_information start */
                $dealer = $queryresult[0]->dealer;
                $this->load->model('mobile/car_model', 'car');
                $aanbodID = $this->uri->segment(3);
                $base = base_url();
                $this->load->library('pagination');
                $config['base_url'] = "$base/mobile/aanbod/";
                $config['total_rows'] = $this->car->countCarDetailsAnnbod($dealer);
                $data['total_rows'] = $config['total_rows'];
                $config['per_page'] = 1000;
                $config["uri_segment"] = 4;
                $config['next_link'] = 'Volgende';
                $config['next_tag_open'] = '<div class="col-xs-6 gridviewimg nopad right">';
                $config['next_tag_close'] = '</div>';
                $config['prev_link'] = 'Vorige';
                $config['prev_tag_open'] = '<div class="col-xs-6 gridviewimg nopad">';
                $config['prev_tag_close'] = '</div>';
                $config['display_pages'] = FALSE;
                $config['first_link'] = FALSE;
                $config['last_link'] = FALSE;
                $this->pagination->initialize($config);
                $data['link'] = $this->pagination->create_links();
                $totalAanbod = $this->uri->segment(3);
                $data['cars'] = $this->car->getCarDetailsAnnbod($dealer, $config['per_page'], $this->uri->segment(4));
                $data['active'] = 'home';
                $data['menu'] = $this->load->view('website/nav_menu', $data, true);
                $data['header'] = $this->load->view('website/header', $data, true);

                $this->load->view('website/website', $data);
            } else {
                echo 'Site is offline';
            }
        }
    }

    public function ajaxObject() {
        $data = array();
        $car_add_number = $this->input->post('caradNumber');
        $dealer_id = $this->input->post('dealer_id');
        $this->load->model('mobile/car_model', 'car');
        $car = $this->car->getCarDetailsById($car_add_number, $dealer_id);
        echo json_encode($car);
    }

    /*

      public function home() {

      $this->load->library('user_agent');
      $stat['devicename'] = $this->agent->platform();

      $aanbodID = $this->uri->segment(3);
      $this->load->model('mobile/dealer_model', 'dealer');
      $chk = $this->dealer->chkAnnbod($aanbodID);
      if ($chk == True) {
      $this->load->model('mobile/car_model', 'car');
      $base = base_url();
      $this->load->library('pagination');
      $config['base_url'] = "$base/website/home/$aanbodID";
      $config['total_rows'] = $this->car->countCarDetailsAnnbod($aanbodID);
      $data['total_rows'] = $config['total_rows'];
      $config['per_page'] = 2;
      $config["uri_segment"] = 4;
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
      $data['link'] = $this->pagination->create_links();
      $totalAanbod = $this->uri->segment(3);
      $data['cars'] = $this->car->getCarDetailsAnnbod($aanbodID, $config['per_page'], $this->uri->segment(4));
      $data['aanbod'] = $this->uri->segment(3);
      $this->load->model('mobile/informatie_model', 'informatie');
      $delerInfo = $this->informatie->dealerByaanbod($aanbodID);
      $data['dealer_id'] = $delerInfo[0]->id;
      $data['DealerInfo'] = $this->informatie->getInformatie($delerInfo[0]->id);
      $data['userInfo'] = $this->informatie->userInfoBydealer($delerInfo[0]->id);
      $social_medias = $this->dealer->social_media($delerInfo[0]->id);
      foreach ($social_medias as $social_media) {
      $type = $social_media->social_type;
      if ($type == 'facebook') {
      $data['facebook'] = $social_media->social_post;
      }
      if ($type == 'twitter') {
      $data['twitter'] = $social_media->social_post;
      }
      if ($type == 'youtube') {
      $data['youtube'] = $social_media->social_post;
      }
      }
      $this->load->view('website/website', $data);
      } else {
      echo "No ID";
      }
      }


      public function emailsendimoby() {

      if (isset($_POST['contactmail'])) {
      if ($_POST['contactmail'] != '') {
      echo "Email is successfully Send. Thank you.";
      } else {
      echo "Fill the form Correctly.";
      }
      }
      }
     */
}
