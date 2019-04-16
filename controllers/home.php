<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function site() {

        $page_slug = $this->uri->segment(2);
        $active_nav = $this->uri->segment(2);
        $user_id = $this->uri->segment(3);
        if ($page_slug == 'annbod') {
            //echo 'annbod';
            /* ---------------------------------------start for annbod ---------------------------------------- */

            $stockPageId = $this->uri->segment(3);
            $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where stockPageId = $stockPageId");
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
                    $config['per_page'] = PERPAGE;
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

                    $data['active'] = 'annbod';
                    $data['menu'] = $this->load->view('website/nav_menu', $data, true);
                    $data['header'] = $this->load->view('website/header', $data, true);
                    $this->load->view('website/aanbod', $data);
                }
            }
            /* ---------------------------------------end for annbod ------------------------------------------ */
        } elseif ($page_slug == 'contact') {

            /* ---------------------------------------start for contact ---------------------------------------- */

            $homePageId = $this->uri->segment(3);
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
                    $data['active'] = 'contact';
                    $data['header'] = $this->load->view('website/header', $data, true);
                    $data['menu'] = $this->load->view('website/nav_menu', $data, true);
                    $this->load->view('website/contact', $data);
                }
            }

            /* ---------------------------------------end for contact ------------------------------------------ */
        } else {

//            /* ---------------------------------------Start for all page ---------------------------------------- */

            $homePageId = $this->uri->segment(3);
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



                    $query = $this->db->query("select * from website where  (dealer_id = $dealer_id) AND (`page_slug` = '$active_nav') AND page_status = 1 ");
                    $resource = $query->result();

                    if (isset($resource[0])) {
                        $data['current_page_title'] = $resource[0]->page_title;
                        $data['current_page_content'] = $resource[0]->page_content;
                    } else {
                        $data['current_page_title'] = '';
                        $data['current_page_content'] = '';
                    }





                    $data['pages'] = $page_list;
                    $data['pages_title'] = $page_title;
                    $data['user_id'] = $queryresult[0]->dealer;
                    $data['active'] = $active_nav;
                    $data['menu'] = $this->load->view('website/nav_menu', $data, true);
                    $data['header'] = $this->load->view('website/header', $data, true);
                    $this->load->view('website/page', $data);
                }
            }
        }
    }

    function resetclient() {
        $resetmail = $_POST['resetmail'];
        $this->db->select('*');
        $this->db->from('crm_klanten');
        $this->db->where('klant_email', $resetmail);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $reset = $query->result();
            $pass=$reset[0]->klant_pass;
            $this->load->library('email');
            $this->email->from('info@imoby.nl', 'Imoby Client Password');
            $this->email->to($resetmail);
            $this->email->subject('Imoby Client Password');
            $this->email->message("Password: $pass");
            $this->email->send();
            echo "Password is send to your email";
        } else {
            echo "ohh! Email is incorrect";
        }
    }
    function resetpass(){

        
        $this->db->where('klant_email',$_POST['klant_email']);
        $this->db->update('crm_klanten',$_POST);
        
        $efrow=$this->db->affected_rows();
        if($efrow>0){
            echo 'Password Reset Successfully';
        }
        else{
           echo 'Password Reset Failed'; 
        }
        
    }
}

