<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mobile extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function counter($dealer_id) {
       // echo $dealer_id;
       $this->uri->segment(3);
        $this->load->helper('cookie');
        $check_visitor = $this->input->cookie('imoby'.$this->uri->segment(3));
        $ip = $this->input->ip_address();
        if ($check_visitor == null) {
            $cookie = array(
                "name" => 'imoby'.$this->uri->segment(3),
                "value" => time(),
                "expire" => 60 * 20,
                "secure" => false);
            $this->input->set_cookie($cookie);
            $this->load->library('user_agent');
            if ($this->agent->is_browser()) {
                $agent = $this->agent->browser() . ' ' . $this->agent->version();
            } elseif ($this->agent->is_robot()) {
                $agent = $this->agent->robot();
            } elseif ($this->agent->is_mobile()) {
                $agent = $this->agent->mobile();
            } else {
                $agent = 'Unidentified User Agent';
            }
            $item_id = $this->uri->segment(3);
            if (isset($item_id)) {
                $agent = $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)
                $data['item_id'] = $item_id;
                $data['devicename'] = $agent;
                $data['dealer_id'] = $dealer_id;
                $data['ip'] = $ip;
                $this->load->helper('date');
                $datestring = "%Y-%m-%d";
                $time = time();
                $view_dt = mdate($datestring, $time);
                $data['view_dt'] = $view_dt . " 00:00:00";
                $this->db->insert('statistics', $data);
            }
            //echo $dealer_id;
        }
    }

    public function index() {
        $data = array();
        $this->load->view('mobile/home_1', $data);
    }

    public function index3() {
        $data = array();
        $this->load->view('mobile/home', $data);
    }    
    
    public function index2() {
        $data = array();
        $this->load->view('mobile/home_1', $data);
    }

    public function searchObject() {
        $this->load->helper('url');
        $objectData = $this->input->post('search');

        $resultSet = array();
        $result = array();
        $resultSet = $this->db->query("select * from cars
        join cars_licenseinfo on cars.id=cars_licenseinfo.car
        join car_ads on car_ads.car = cars.id
        where licenseNumber = '$objectData'");
        $result = $resultSet->result();
        if ($result != null) {

            $objectData = $result[0]->adNumber;
            $url = base_url() . "mobile/object/" . $objectData;
            redirect($url, 'refresh');
        }
        $resultSet = array();
        $result = array();
        $resultSet = $this->db->query("select * from dealers where homePageId = $objectData");
        $result = $resultSet->result();
        if ($result != null) {
            $url = base_url() . "mobile/home/" . $objectData;
            redirect($url, 'refresh');
        }
        $resultSet = array();
        $result = array();
        $resultSet = $this->db->query("select * from dealers where stockPageId = $objectData");
        $result = $resultSet->result();
        if ($result != null) {
            $url = base_url() . "mobile/aanbod/" . $objectData;
            redirect($url, 'refresh');
        }

        $resultSet = array();
        $result = array();
        $resultSet = $this->db->query("select * from car_ads where adNumber = $objectData");
        $result = $resultSet->result();
        if ($result != null) {
            $url = base_url() . "mobile/object/" . $objectData;
            redirect($url, 'refresh');
        }



        $url = base_url() . "mobile/pagenotfound";
        redirect($url, 'refresh');


        /*
          $this->db->where('aanbod', $objectData);
          $q = $this->db->get('dealers');
          $result = $q->result();
          if ($result != null) {
          $url = base_url() . "mobile/aanbod/" . $objectData;
          redirect($url, 'refresh');
          }

          if (preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $objectData)) /* check licence or object id  {
          $this->load->model('mobile/car_model', 'car');
          $object = $this->car->getCarIdBylicenseNumber($objectData);
          if ($object == null) {
          $url = base_url() . "mobile/pagenotfound";
          redirect($url, 'refresh');
          } else {
          $url = base_url() . "mobile/object/" . $object;
          redirect($url, 'refresh');
          }
          }  else {


          $url = base_url() . "mobile/object/" . $objectData;
          redirect($url, 'refresh');
          } */
    }

    public function home() {

        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $homePageEnabled = $queryresult[0]->homePageEnabled;
            if ($homePageEnabled == 1) {
                $data['informatie'] = $queryresult;
                $user_id = $queryresult[0]->user;
                $dealer_id = $queryresult[0]->dealer;
                
                $this->counter($dealer_id);
                
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
                $this->load->model('mobile/dealer_model', 'dealer');
                $social_medias = $this->dealer->social_media($dealer_id);
                foreach ($social_medias as $social_media) {
                    $type = $social_media->social_type;
                    if ($type == 'facebook') {
                        $data['facebook'] = $social_media->social_post;
                    }
                    if ($type == 'twitter') {
                        $data['twitter'] = $social_media->social_post;
                    }
                }
                $data['header'] = $this->load->view('mobile/layout/header', $data, true);
                $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
                $this->load->view('mobile/home_main', $data);
            } else {
                $url = base_url() . "mobile/pagenotfound";
                redirect($url, 'refresh');
            }
        } else {
            $url = base_url() . "mobile/pagenotfound";
            redirect($url, 'refresh');
        }
        /* -------------------------------------------- */
    }

    public function aanbod() {

        $stockPageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where stockPageId = $stockPageId");
        $queryresult = $query->result();
        $data['informatie'] = $queryresult;

        if (isset($queryresult[0])) {
            /* if result found start */
            $stockPageEnabled = $queryresult[0]->stockPageEnabled;
            $data['homePageId'] = $queryresult[0]->homePageId;
            if ($stockPageEnabled == 1) {
                /* annbod page is enable start */

                $dealer = $queryresult[0]->dealer;
                $this->counter($dealer);
                /* coloer schame start */
                $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer and attribute = 'colorschrme'");
                $colorschme = $colorschmes->result();
                if (isset($colorschme[0])) {
                    $data['colorschme'] = $colorschme[0]->value;
                } else {
                    $data['colorschme'] = 'nocolor';
                }
                /* coloer schame start */


                $this->load->model('mobile/car_model', 'car');
                $aanbodID = $this->uri->segment(3);
                $base = base_url();
                $this->load->library('pagination');
                $config['base_url'] = "$base/mobile/aanbod/$stockPageId";
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

                $data['aanbod'] = $this->uri->segment(3);
                $this->load->model('mobile/informatie_model', 'informatie');
                $delerInfo = $queryresult;
                $data['DealerInfo'] = $queryresult;
                $data['userInfo'] = $queryresult;
                $data['header'] = $this->load->view('mobile/layout/header', $data, true);
                $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
                $this->load->view('mobile/aanbod', $data);


                /* annbod page is enable end */
            } else {
                /* annbod page is not enable start */
                $url = base_url() . "mobile/pagenotfound";
                redirect($url, 'refresh');
                /* annbod page is not enable end */
            }
            /* if result found */
        } else {
            $url = base_url() . "mobile/pagenotfound";
            redirect($url, 'refresh');
        }
    }

    /*  -------------------ajax in aanbod ------------------------------- */

    public function ajax_search_form() {
        $aanbodID = $this->input->post('aanbod');
        $this->load->model('mobile/car_model', 'car');
        $cars = $this->car->getCarDetailsAnnbod($aanbodID, 10000, 0);
        echo json_encode($cars);
    }

    /*  -------------------ajax in aanbod ------------------------------- */

    public function object() {





        $adNumber = $this->uri->segment(3);
        $query = $this->db->query("
                SELECT * FROM `car_ads`
                join cars on cars.id = car_ads.car
                WHERE `adNumber` = $adNumber 
                AND `active` = 1");
        $result = $query->result();
        if (isset($result[0])) {

            $car_id = $result[0]->car;
            $dealer = $result[0]->dealer;
            $this->counter($dealer);
            $query5 = $this->db->query("select * from dealers where id = $dealer");
            $queryresult5 = $query5->result();
            $data['informatie'] = $queryresult5;



            /* before car start */
            $query = $this->db->query("
                SELECT adNumber FROM `car_ads` 
                join cars on cars.id = car_ads.car 
                WHERE cars.dealer = $dealer
                AND car_ads.adNumber < $adNumber    
                AND car_ads.active = 1
                order by car_ads.adNumber desc
                LIMIT 1    
                ");
            $before_cars = $query->result();
            //print_r($before_cars);
            if (isset($before_cars[0])) {
                $before = $before_cars[0]->adNumber;
            } else {
                $before = '';
            }
            /* before car end */

            /* after car start */
            $query = $this->db->query("
                SELECT adNumber FROM `car_ads` 
                join cars on cars.id = car_ads.car 
                WHERE cars.dealer = $dealer
                AND car_ads.adNumber > $adNumber  
                AND car_ads.active = 1
                order by car_ads.adNumber asc
                limit 1
                ");
            $after_cars = $query->result();

            if (isset($after_cars[0])) {
                $after = $after_cars[0]->adNumber;
            } else {
                $after = '';
            }
            /* after car end */
            $check = True;
        } else {
            $url = base_url() . "mobile/pagenotfound";
            redirect($url, 'refresh');
        }

        //   echo "Next:".$data['next'] = $after."<br>";
        //   echo "Pre:".$data['previous'] = $before."<br>";
        //  echo "current:".$data['object'] = $adNumber."<br>";

        $data = array();
        if ($check == True) {
            $data['next'] = $after;
            $data['previous'] = $before;
            $data['object'] = $adNumber;

            /* coloer schame start */
            $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer and attribute = 'colorschrme'");
            $colorschme = $colorschmes->result();
            if (isset($colorschme[0])) {
                $data['colorschme'] = $colorschme[0]->value;
            } else {
                $data['colorschme'] = 'nocolor';
            }
            /* coloer schame start */

            /* --------------------------car information----------------------- */


            $this->db->select('*');
            // $this->db->select('GROUP_CONCAT(DISTINCT(remoteFile) SEPARATOR ",") as remoteFile',false);    
            // $this->db->select('GROUP_CONCAT(DISTINCT(localFile) SEPARATOR ",") as localFile',false);
            $this->db->distinct();
            $this->db->from('cars');
            $this->db->join('car_ads', 'car_ads.car = cars.id');
            $this->db->join('cars_licenseinfo', 'cars_licenseinfo.car = cars.id');
            //$this->db->join('car_media', 'car_media.car = cars.id');
            $this->db->join('cars2specsdefault', 'cars2specsdefault.car = cars.id');
            $this->db->join('cars2specsfabric', 'cars2specsfabric.car = cars.id');
            $this->db->join('car_specsdefault', 'car_specsdefault.id = cars2specsdefault.specDefault');
            $this->db->join('car_specsfabric', 'car_specsfabric.id = cars2specsfabric.specFabric');
            $this->db->where('cars.dealer', $dealer);
            $this->db->where('adNumber', $adNumber);
            $this->db->where('car_ads.active', 1);
            $this->db->group_by('cars.id');
            $query = $this->db->get();
            $car_info = $query->result();
            if (isset($car_info[0])) {
                $car_id = $car_info[0]->car;
                $carmedias = $this->db->query("select * from car_media where car = $car_id");
                $carmedia = $carmedias->result();
                $media = array();
                if (isset($carmedia[0])) {
                    $local = $carmedia[0]->localFile;


                    if ($local != null) {

                        foreach ($carmedia as $files) {
                            $media[] = $files->localFile;
                        }
                        $car_info[0]->mediaFile = implode(',', $media);
                    }

                    if ($local == null) {

                        foreach ($carmedia as $files) {
                            $media[] = $files->remoteFile;
                        }
                        $car_info[0]->mediaFile = implode(',', $media);
                    }
                }





                $car_infoo = $this->db->query("select attribute,valueText from car_info where car = $car_id");
                $car_info_result = $car_infoo->result();
                // print_r($car_info_result);
                if (isset($car_info_result)) {
                    foreach ($car_info_result as $car_result) {
                        $attribute = $car_result->attribute;
                        $valueText = $car_result->valueText;
                        $car_info[0]->$attribute = $valueText;
                    }
                }
                /* car specFabric start */
                $cars2specsdefaults = $this->db->query("
                                   select  * from `cars2specsdefault` 
                                   join car_specsfabric on `cars2specsdefault`. specDefault  = car_specsfabric.id
                                   where car = $car_id");
                $specsdefaults = '';
                $cars2specsdefault = $cars2specsdefaults->result();
                foreach ($cars2specsdefault as $specsdefault) {
                    $specsdefaults = $specsdefaults . ", " . $specsdefault->translation;
                }
                $car_info[0]->specsdefault = $specsdefaults;

                /* car specFabric end */
            }

            $data['car'] = $car_info[0];
            //echo '<pre>';
            //print_r($data['car']);
            //die();


            /* --------------------------car information -------------------------- */
            /* dealer information */
            $dealer_info = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where dealers.id = $dealer");
            $dealer_result = $dealer_info->result();
            $data['informatie'] = $dealer_result;
            /* dealer information start */
            $data['dealer'] = $dealer_result;
            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
            $this->load->view('mobile/objectpagina', $data);
            /* dealer information end */
        } else {
            $url = base_url() . "mobile/pagenotfound";
            redirect($url, 'refresh');
        }


    }

    public function ajax_search_object() {
        $this->load->model('mobile/car_model', 'car');
        $result = $this->car->search_object($_POST);
        echo json_encode($result);
    }

    /* object search ajax */

    public function informatie() {
        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        $data['informatie'] = $queryresult;
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {
            $data['informatie'] = $queryresult;
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
            $this->load->view('mobile/informatie', $data);
        } else {
            $url = base_url() . "mobile/pagenotfound";
            redirect($url, 'refresh');
        }
    }

    public function route() {
        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {
            $data['informatie'] = $queryresult;
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
            $this->load->view('mobile/route', $data);
        } else {
            $url = base_url() . "mobile/pagenotfound";
            redirect($url, 'refresh');
        }
    }

    public function vcard() {
        $homePageId = $this->uri->segment(3);
        $action = $this->uri->segment(4);
        $query = $this->db->query("select * , dealers.email as dealeremail from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }
        if ($chk == True) {
            $data['informatie'] = $queryresult;
            $data['homePageId'] = $homePageId;
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

            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
            $this->load->view('mobile/vcard', $data);


            $infomation = $data['informatie'];

            if (isset($action)) {
                /*  vcard download start */
                if ($action == 'download') {

                    $fullname = $infomation[0]->firstName . " " . $infomation[0]->middleName . " " . $infomation[0]->lastName;
                    $name = $infomation[0]->middleName . " " . $infomation[0]->lastName;
                    $url = $infomation[0]->website;
                    $org = $infomation[0]->name;
                    $address = $infomation[0]->street . ", " . $infomation[0]->houseNumber;
                    $postcode = $infomation[0]->postal_code;
                    $city = $infomation[0]->city;
                    $phone = $infomation[0]->phoneNumber2;
                    $office_phone = $infomation[0]->phoneNumber1;
                    $office_email = $infomation[0]->dealeremail;
                    $vcard = <<<EOD
                
BEGIN:VCARD
VERSION:3.0
CLASS:PUBLIC
PRODID:-//imoby
REV:2012-03-07
FN:{$fullname}
N:{$name},
URL;TYPE=home:{$url}
ORG:{$org}
ADR;WORK:;;{$address};{$city};{$postcode};
TEL;TYPE=work,voice:{$phone}
TEL;TYPE=work,fax:{$office_phone}
EMAIL;TYPE=internet:{$office_email}
URL;TYPE=work:{$url}
END:VCARD
EOD;

                    /* can be added LABEL;TYPE=work,postal,parcel:$address\n{$city}\n{$postcode}\n */
                    file_put_contents('fileserver/' . $dealer_id . '.vcf', $vcard);
                    $this->load->helper('download');

                    $data = file_get_contents("fileserver/$dealer_id.vcf"); // Read the file's contents
                    $name = 'vcard.vcf';

                    force_download($name, $data);
                }
                /*  vcard download end */

                /* email send */
                if ($action == 'email') {
                    if (isset($_GET['email'])) {

                        $fullname = $klantnummerInfo[0]->firstName . " " . $klantnummerInfo[0]->middleName . " " . $klantnummerInfo[0]->lastName;
                        $name = $klantnummerInfo[0]->middleName . " " . $klantnummerInfo[0]->lastName;
                        $url = $infomation[0]->website;
                        $org = $infomation[0]->name;
                        $address = $infomation[0]->street . ", " . $infomation[0]->houseNumber;
                        $postcode = $infomation[0]->city;
                        $city = $infomation[0]->city;
                        $phone = $infomation[0]->phoneNumber2;
                        $office_phone = $infomation[0]->phoneNumber1;
                        $office_email = $infomation[0]->email;
                        $vcard = <<<EOD
                
BEGIN:VCARD
VERSION:3.0
CLASS:PUBLIC
PRODID:-//imoby
REV:2012-03-07
FN:{$fullname}
N:{$name},
URL;TYPE=home:{$url}
ORG:{$org}
ADDR;TYPE=work,postal,parcel:;;{$address};{$city};{$postcode};
TEL;TYPE=work,voice:{$phone}
TEL;TYPE=work,fax:{$office_phone}
EMAIL;TYPE=internet:{$office_email}
URL;TYPE=work:{$url}
END:VCARD
EOD;


                        /* can be added LABEL;TYPE=work,postal,parcel:$address\n{$city}\n{$postcode}\n */
                        file_put_contents('fileserver/' . $klantnummer . '.vcf', $vcard);
                        $emailaddress = $_GET['email'];

                        $mail_content = '<br/><p> Beste,<br/><a href="' . base_url() . '/mobile/vcard/' . $homePageId . '/download">Klik hier</a> om de door u opgevraagde vCard te downloaden <br/>Groet,<br/> Imoby</p>';
                        $this->load->library('email');
                        $this->email->from('info@projectflick.com', 'Imoby');
                        $this->email->to($emailaddress);
                        $this->email->subject('Imoby vCard');
                        $this->email->message($mail_content);
                        $msg = "First line of text\nSecond line of text";
                        $msg = wordwrap($msg, 70);
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        mail($emailaddress, "Imoby vCard", $mail_content, $headers);
                    }
                }
                /* email send end */
            }
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function imobyInformatie() {
        $data = array();
        $data['header'] = $this->load->view('mobile/layout/header', $data, true);
        $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
        $this->load->view('mobile/imobyInformatie', $data);
    }

    public function checkStockPageId($stockPageId) {
        $this->load->model('mobile/informatie_model', 'informatie');
        $result = $this->informatie->checkStockPage($stockPageId);
        if (isset($result[0]->klantnummer)) {
            $services = $this->informatie->checkService($result[0]->id);
            foreach ($services as $service) {
                $dealerfunction = $service->dealerfunction;
                $serviceStatus = $service->serviceStatus;
                if (($dealerfunction == 1) && ($serviceStatus == 1)) {
                    $status = true;
                }
            }
            if (isset($status)) {
                if ($status == true) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function minjvoerting() {

        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }
       
        
        
        
        
        
        if ($chk == True) {
            $data['informatie'] = $queryresult;
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
            $klant = $this->uri->segment(4);
            if($klant=='klant'){
                $data['informatie'] = $queryresult;
                $data['header'] = $this->load->view('mobile/layout/header', $data, true);
                $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
                $selector = $this->uri->segment(5);
                
                if($selector=='dashboard'){
                $this->load->view('mobile/minjvoerting/dashboard', $data); 
                }
               
            }
            else{
            $data['informatie'] = $queryresult;
            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
            $this->load->view('mobile/mijn-voertuig', $data);
            }
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function clientlogincheck(){
        
    }




    public function brandstof() {

        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {
            $data['informatie'] = $queryresult;
            $dealer_id = $data['dealer_id'] = $queryresult[0]->dealer;
            $data['informatie'] = $queryresult;
            /* coloer schame start */
            $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer_id and attribute = 'colorschrme'");
            $colorschme = $colorschmes->result();
            if (isset($colorschme[0])) {
                $data['colorschme'] = $colorschme[0]->value;
            } else {
                $data['colorschme'] = 'nocolor';
            }
            /* coloer schame start */
            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
            $this->load->view('mobile/brandstof-kaart', $data);
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function parkeerhulp() {

        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {

            $data['informatie'] = $queryresult;
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


            $data['informatie'] = $queryresult;
            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);


            $this->load->view('mobile/parkeerhulp', $data);
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function parking() {
        $latlog = $_POST['latlon'];
        $marker = '';
        $json = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$latlog&radius=500&types=parking&sensor=false&key=AIzaSyAsh84py2Kj4jCi6i2t4lnK9k62l4_2cmM");
        $obj = json_decode($json);
        $results = $obj->results;
        if (!empty($results)) {
            foreach ($results as $result) {
                $geometry = $result->geometry;
                $location = $geometry->location;
                $loclat = $location->lat;
                $loclng = $location->lng;
                $marker.="&markers=color:red%7Clabel:%7C" . $loclat . "," . $loclng;
            }
        }
        echo $marker;
    }

    public function ikenteken() {

        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {

            $data['informatie'] = $queryresult;
            $dealer_id = $data['dealer_id'] = $dealerId = $queryresult[0]->dealer;
            $data['informatie'] = $queryresult;
            /* coloer schame start */
            $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer_id and attribute = 'colorschrme'");
            $colorschme = $colorschmes->result();
            if (isset($colorschme[0])) {
                $data['colorschme'] = $colorschme[0]->value;
            } else {
                $data['colorschme'] = 'nocolor';
            }
            /* coloer schame start */

            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);


            $this->load->view('mobile/ikenteken', $data);
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function onderhoud() {

        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        $data['informatie'] = $queryresult;
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {

            $data['homePageId'] = $homePageId;

            $dealer_id = $data['dealer_id'] = $queryresult[0]->dealer;
            $data['informatie'] = $queryresult;
            /* coloer schame start */
            $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer_id and attribute = 'colorschrme'");
            $colorschme = $colorschmes->result();
            if (isset($colorschme[0])) {
                $data['colorschme'] = $colorschme[0]->value;
            } else {
                $data['colorschme'] = 'nocolor';
            }
            /* coloer schame start */
            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            /* coloer schame start */
            $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer_id and attribute = 'colorschrme'");
            $colorschme = $colorschmes->result();
            if (isset($colorschme[0])) {
                $data['colorschme'] = $colorschme[0]->value;
            } else {
                $data['colorschme'] = 'nocolor';
            }
            /* coloer schame start */
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
            $view = $this->uri->segment(4);
            if ($view == '') {
                $this->load->view('mobile/onderhoud', $data);
            }
            if ($view == 'ruitenwissers') {
                $this->load->view('mobile/onderhoud/ruitenwissers', $data);
            }
            if ($view == 'verlichting') {
                $this->load->view('mobile/onderhoud/verlichting', $data);
            }
            if ($view == 'vloeistoffen') {
                $this->load->view('mobile/onderhoud/vloeistoffen ', $data);
            }
            if ($view == 'wassen') {
                $this->load->view('mobile/onderhoud/wassen', $data);
            }
            if ($view == 'winterklaar') {
                $this->load->view('mobile/onderhoud/winterklaar ', $data);
            }
            if ($view == 'airco') {
                $this->load->view('mobile/onderhoud/airco', $data);
            }
            if ($view == 'banden') {
                $this->load->view('mobile/onderhoud/banden', $data);
            }
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function dashboard() {

        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        $data['informatie'] = $queryresult;
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {

            $dealer_id = $data['dealer_id'] = $queryresult[0]->dealer;
            $data['homePageId'] = $queryresult[0]->homePageId;
            $data['informatie'] = $queryresult;
            /* coloer schame start */
            $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer_id and attribute = 'colorschrme'");
            $colorschme = $colorschmes->result();
            if (isset($colorschme[0])) {
                $data['colorschme'] = $colorschme[0]->value;
            } else {
                $data['colorschme'] = 'nocolor';
            }
            /* coloer schame start */



            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
            $view = $this->uri->segment(4);
            if ($view == '') {
                $this->load->view('mobile/dashboard', $data);
            }
            if ($view == 'accu') {
                $this->load->view('mobile/dashboard/accu', $data);
            }
            if ($view == 'airbag') {
                $this->load->view('mobile/dashboard/airbag', $data);
            }
            if ($view == 'banden') {
                $this->load->view('mobile/dashboard/banden', $data);
            }
            if ($view == 'besturing') {
                $this->load->view('mobile/dashboard/besturing', $data);
            }
            if ($view == 'koeling') {
                $this->load->view('mobile/dashboard/koeling', $data);
            }
            if ($view == 'motor') {
                $this->load->view('mobile/dashboard/motor', $data);
            }
            if ($view == 'olie') {
                $this->load->view('mobile/dashboard/olie', $data);
            }
            if ($view == 'remmen') {
                $this->load->view('mobile/dashboard/remmen', $data);
            }
            if ($view == 'roetfilter') {
                $this->load->view('mobile/dashboard/roetfilter', $data);
            }
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function pechhulp() {
        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {

            $data['informatie'] = $queryresult;
            $dealer_id = $data['dealer_id'] = $queryresult[0]->dealer;
            $data['homePageId'] = $queryresult[0]->homePageId;
            $data['informatie'] = $queryresult;
            /* coloer schame start */
            $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer_id and attribute = 'colorschrme'");
            $colorschme = $colorschmes->result();
            if (isset($colorschme[0])) {
                $data['colorschme'] = $colorschme[0]->value;
            } else {
                $data['colorschme'] = 'nocolor';
            }
            /* coloer schame start */



            $data['header'] = $this->load->view('mobile/layout/header', $data, true);

            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
            $view = $this->uri->segment(4);
            if ($view == '') {
                $this->load->view('mobile/pechhulp', $data);
            }
            if ($view == 'hulpnummers') {
                $this->load->view('mobile/pechhulp/hulpnummers', $data);
            }
            if ($view == 'lampje') {
                $this->load->view('mobile/pechhulp/lampje', $data);
            }
            if ($view == 'oververhitte') {
                $this->load->view('mobile/pechhulp/oververhitte', $data);
            }
            if ($view == 'sleutel') {
                $this->load->view('mobile/pechhulp/sleutel', $data);
            }
            if ($view == 'starthulp') {
                $this->load->view('mobile/pechhulp/starthulp', $data);
            }
            if ($view == 'wile') {
                $this->load->view('mobile/pechhulp/wiel', $data);
            }
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function schade() {
        $homePageId = $this->uri->segment(3);
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where homePageId = $homePageId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $chk = True;
        } else {
            $chk = False;
        }

        if ($chk == True) {

            $data['informatie'] = $queryresult;
            $dealer_id = $data['dealer_id'] = $queryresult[0]->dealer;
            $data['homePageId'] = $queryresult[0]->homePageId;
            $data['informatie'] = $queryresult;
            /* coloer schame start */
            $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $dealer_id and attribute = 'colorschrme'");
            $colorschme = $colorschmes->result();
            if (isset($colorschme[0])) {
                $data['colorschme'] = $colorschme[0]->value;
            } else {
                $data['colorschme'] = 'nocolor';
            }
            /* coloer schame start */

            $data['header'] = $this->load->view('mobile/layout/header', $data, true);
            $data['footer'] = $this->load->view('mobile/layout/footer', $data, true);
            $this->load->view('mobile/schade', $data);
        } else {
            echo "Invalid ID Number, Back and Try Again !";
        }
    }

    public function pagenotfound() {
        $data = array();
        $this->load->view('mobile/pagenotfound', $data);
    }

    /* email */

    public function emailsendhome() {
        /* for mobile/home contact form start */
        if ($_POST['from'] != '') {

            echo "Email is successfully Send. Thank you.";
            /* for mobile/home contact form start */
        } else {
            echo "Fill the form Correctly.";
        }
    }

    /* email */

    public function emailsendobject() {






        if (isset($_POST['from1'])) {


            if ($_POST['from1'] != '') {
                $email_name = $_POST['email_name'];
                $body = $_POST['body'];
                $subject = $_POST['subject'];
                $from = $_POST['from'];
                $dealer_id = $_POST['dealer_id'];


                /* mail save in database */

                $emaildata = array();
                $emaildata = array(
                    'from' => $from,
                    'dealer_id' => $dealer_id,
                    'subject' => $subject,
                    'body' => $body,
                    'box' => 'anbox'
                );

                $this->db->insert('email', $emaildata);
                /* mail save in database */


                echo "Email is successfully Send. Thank you.";
            } else {
                echo "Fill the form Correctly.";
            }
        }

        if (isset($_POST['from2'])) {
            if ($_POST['from2'] != '') {
                $email_name = $_POST['email_name'];
                $body = $_POST['body'];
                $subject = $_POST['subject'];
                $from = $_POST['from'];
                $dealer_id = $_POST['dealer_id'];


                /* mail save in database */

                $emaildata = array();
                $emaildata = array(
                    'from' => $from,
                    'dealer_id' => $dealer_id,
                    'subject' => $subject,
                    'body' => $body,
                    'box' => 'anbox'
                );

                $this->db->insert('email', $emaildata);
                /* mail save in database */


                echo "Email is successfully Send. Thank you.";
            } else {
                echo "Fill the form Correctly.";
            }
        }


        if (isset($_POST['from3'])) {
            if ($_POST['from3'] != '') {
                $email_name = $_POST['email_name'];
                $body = $_POST['body'];
                $subject = $_POST['subject'];
                $from = $_POST['from'];
                $dealer_id = $_POST['dealer_id'];


                /* mail save in database */

                $emaildata = array();
                $emaildata = array(
                    'from' => $from,
                    'dealer_id' => $dealer_id,
                    'subject' => $subject,
                    'body' => $body,
                    'box' => 'anbox'
                );

                $this->db->insert('email', $emaildata);
                /* mail save in database */


                echo "Email is successfully Send. Thank you.";
            } else {
                echo "Fill the form Correctly.";
            }
        }

        if (isset($_POST['from4'])) {
            if ($_POST['from4'] != '') {
                $email_name = $_POST['email_name'];
                $body = $_POST['body'];
                $subject = $_POST['subject'];
                $from = $_POST['from'];
                $dealer_id = $_POST['dealer_id'];


                /* mail save in database */

                $emaildata = array();
                $emaildata = array(
                    'from' => $from,
                    'dealer_id' => $dealer_id,
                    'subject' => $subject,
                    'body' => $body,
                    'box' => 'anbox'
                );

                $this->db->insert('email', $emaildata);
                /* mail save in database */


                echo "Email is successfully Send. Thank you.";
            } else {
                echo "Fill the form Correctly.";
            }
        }


        if (isset($_POST['from5'])) {
            if ($_POST['from5'] != '') {
                $email_name = $_POST['email_name'];
                $body = $_POST['body'];
                $subject = $_POST['subject'];
                $from = $_POST['from'];
                $dealer_id = $_POST['dealer_id'];


                /* mail save in database */

                $emaildata = array();
                $emaildata = array(
                    'from' => $from,
                    'dealer_id' => $dealer_id,
                    'subject' => $subject,
                    'body' => $body,
                    'box' => 'anbox'
                );

                $this->db->insert('email', $emaildata);
                /* mail save in database */


                echo "Email is successfully Send. Thank you.";
            } else {
                echo "Fill the form Correctly.";
            }
        }

        if (isset($_POST['from6'])) {
            if ($_POST['from6'] != '') {
                $email_name = $_POST['email_name'];
                $body = $_POST['body'];
                $subject = $_POST['subject'];
                $from = $_POST['from'];
                $dealer_id = $_POST['dealer_id'];


                /* mail save in database */

                $emaildata = array();
                $emaildata = array(
                    'from' => $from,
                    'dealer_id' => $dealer_id,
                    'subject' => $subject,
                    'body' => $body,
                    'box' => 'anbox'
                );

                $this->db->insert('email', $emaildata);
                /* mail save in database */


                echo "Email is successfully Send. Thank you.";
            } else {
                echo "Fill the form Correctly.";
            }
        }
    }

    /* mobile brandstof ajax call will be start from here */

    function brandstoflistajax() {

        /* default */
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        if (isset($_POST['brandstof'])) {
            if ($_POST['brandstof'] != '') {
                $brandstof = $_POST['brandstof'];
            } else {
                $brandstof = "Euro 95";
            }
        } else {
            $brandstof = "Euro 95";
        }
        $katensearch = $_POST['merken'];



        /* default */
           $json = file_get_contents("http://www.brandstof-zoeker.nl/stations.json?partner=imoby&latitude=$lat&longitude=$lng&radius=10");
      //  $json = file_get_contents("http://www.brandstof-zoeker.nl/stations.json?partner=imoby&latitude=52.1561113&longitude=5.3878266&radius=25");
        $obj = json_decode($json);
        $stations = $obj->station;
        
//          echo '<pre>';
//          print_r($stations);
//          die();
//         
        $data = array();

        $string = '';

        foreach ($stations as $station) {

            $arrays = (array) ($station->brandstof);
            if (array_key_exists($brandstof, $arrays)) {
                //echo $arrays[$brandstof];
                $bprice = $arrays[$brandstof];
                $keten = $station->keten;
                $latitude = $station->latitude;
                $longitude = $station->longitude;
                $address = $station->adres;

                $postcode = $station->postcode;
                $plaats = $station->plaats;
                $station->price = $bprice;

                $naam = $station->naam;
                $distance = $station->distance;
                if ($keten == $katensearch) {


                    $psorts[] = $station;


                    //  $data[]=$arrays[$brandstof].'|'.$katensearch.'|'.$naam.'|'.$distance."|".$plaats."|".$keten."|".$latitude."|".$longitude."|".$address."|".$postcode;
                }
                if ($katensearch == 'all') {
                    $psorts[] = $station;
                }
            } else {
                
            }
        }


        $sorttype = "P";
        if ($sorttype == "P") {
            foreach ($psorts as $station) {
                //echo $arrays[$brandstof];
                $keten = $station->keten;
                $latitude = $station->latitude;
                $longitude = $station->longitude;
                $address = $station->adres;
                $postcode = $station->postcode;
                $price = $station->price;
                $plaats = $station->plaats;
                $naam = $station->naam;
                $distance = $station->distance;
                if ($katensearch == 'all') {
                    $data[] = $price . '|' . $keten . '|' . $naam . '|' . $distance . "|" . $plaats . "|" . $keten . "|" . $latitude . "|" . $longitude . "|" . $address . "|" . $postcode;
                } else {
                    $data[] = $price . '|' . $katensearch . '|' . $naam . '|' . $distance . "|" . $plaats . "|" . $keten . "|" . $latitude . "|" . $longitude . "|" . $address . "|" . $postcode;
                }
            }
            echo json_encode($data);
        }
    }

    function brandstofmap() {
        alert('hello');
    }

    /* mobile brandstof ajax call will be start from here */
}
