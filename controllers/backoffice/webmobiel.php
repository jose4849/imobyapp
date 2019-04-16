<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Webmobiel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group('dealer'))
            redirect('login', 'refresh');
    }

    public function homepagina() {

        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Web en Mobiel";
        $data['activeTabHeader'] = "mobileapp";
        $data['activeTab'] = "mobileapp";
        $user_id = $data['user']->id;
        $data['dealer'] = $this->backoffice_model->getProfile($user_id);
        $resultset = $this->db->query("
          select * from users2dealers
          join dealers on dealers.id = users2dealers.dealer
          where user =  $user_id");
        $users2dealers = $resultset->result();
        if ($users2dealers[0]) {
            $data['homePageId'] = $users2dealers[0]->homePageId;
            $data['mobileapp'] = $users2dealers[0]->homePageEnabled;
        }
        $data['dealer_id'] = $users2dealers[0]->dealer;
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($users2dealers[0]->dealer);
        $functions = $data['dealer_functions'];
        
        $imobycode = $users2dealers[0]->homePageId;
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $lastyear = date("Y") - 1;
        $from = $lastyear . "-" . $month . "-" . $day;
        $to = $year . "-" . $month . "-" . $day;
        $item = $data['dealer'][0]->klantnummer;
        $res = $this->uri->segment(4);
        $this->load->helper('form');

        $data['options'] = $options;
       
        if ($res == '') {
            $from = date("Y-m-d", strtotime("-1 week"));
            $to = date("Y-m-d");
            $data['selected'] = 1;
        }
        if ($res == 1) {
            $from = date("Y-m-d", strtotime("-1 week"));
            $to = date("Y-m-d");
            $data['selected'] = 1;
        }        
        if ($res == 2) {
            $from = date("Y-m-d", strtotime("-1 month"));
            $to = date("Y-m-d");
            $data['selected'] = 2;
        }        
        if ($res == 3) {
            $from = $from;
            $to = $to;
            $data['selected'] = 3;
        }

        $sql = "SELECT * , COUNT(*) as eachdate FROM `statistics` where 
        ( `view_dt` >='" . $from . "' and `view_dt` <='" . $to . "' ) AND
        ( `item_id` = $imobycode ) group by `view_dt` ";
       
        $resultgraph = $this->db->query($sql);
        $data['graph'] = $resultgraph->result();
        $this->load->view('backoffice/mobile_app/mobile_app', $data);
    }

    public function updateStatus() {
        $data = array(
            'homePageEnabled' => $_POST['serviceStatus'],
        );
        $this->db->where('id', $_POST['dealer']);
        $this->db->update('dealers', $data);
    }

    public function updateStatusAanbod() {
        $data = array(
            'stockPageEnabled' => $_POST['stockPageEnabled'],
        );
        $this->db->where('id', $_POST['id']);
        $this->db->update('dealers', $data);
    }

    public function aanbodpagina() {

        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Web en Mobiel";
        $data['activeTabHeader'] = "mobileapp";
        $data['activeTab'] = "aanbodpagin";
        $user_id = $data['user']->id;
        $data['dealer'] = $this->backoffice_model->getProfile($user_id);
        $resultset = $this->db->query("
          select * from users2dealers
          join dealers on dealers.id = users2dealers.dealer
          where user =  $user_id");
        $users2dealers = $resultset->result();
        if ($users2dealers[0]) {
            $stockPageId = $data['stockPageId'] = $users2dealers[0]->stockPageId;
            $stockPageEnabled = $data['stockPageEnabled'] = $users2dealers[0]->stockPageEnabled;
        }


        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($users2dealers[0]->dealer);
        $data['aanbod'] = $stockPageId;
        $data['aanbodStatus'] = $stockPageEnabled;
        $data['dealer_id'] = $users2dealers[0]->dealer;
        
        
        $imobycode=$stockPageId;
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $lastyear = date("Y") - 1;
        $from = $lastyear . "-" . $month . "-" . $day;
        $to = $year . "-" . $month . "-" . $day;
        $item = $data['dealer'][0]->klantnummer;
        $res = $this->uri->segment(4);
        $this->load->helper('form');

        $data['options'] = $options;
       
        if ($res == '') {
            $from = date("Y-m-d", strtotime("-1 week"));
            $to = date("Y-m-d");
            $data['selected'] = 1;
        }
        if ($res == 1) {
            $from = date("Y-m-d", strtotime("-1 week"));
            $to = date("Y-m-d");
            $data['selected'] = 1;
        }        
        if ($res == 2) {
            $from = date("Y-m-d", strtotime("-1 month"));
            $to = date("Y-m-d");
            $data['selected'] = 2;
        }        
        if ($res == 3) {
            $from = $from;
            $to = $to;
            $data['selected'] = 3;
        }

        $sql = "SELECT * , COUNT(*) as eachdate FROM `statistics` where 
        ( `view_dt` >='" . $from . "' and `view_dt` <='" . $to . "' ) AND
        ( `item_id` = $imobycode ) group by `view_dt` ";
       
        $resultgraph = $this->db->query($sql);
        $data['graph'] = $resultgraph->result();

        $this->load->view('backoffice/mobile_app/aanbodpagin', $data);
    }

    public function presentaties() {
        $this->load->model('backoffice_model');
        $data['user'] = $user = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Web en Mobiel";
        $data['activeTabHeader'] = "mobileapp";
        $data['activeTab'] = "presentaties";
        $user_id = $user->id;
        /* get user and dealer information start */
        $query = $this->db->query("
                select * from users2dealers
                join dealers on users2dealers.dealer = dealers.id
                where user = $user_id"
        );
        $resultset = $query->result();
        if (isset($resultset[0])) {
            $dealer_id = $resultset[0]->dealer;
        }
        /* get user and dealer information end */
        $data['dealer'] = $this->backoffice_model->getProfile($user_id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($dealer_id);
        $data['car_details'] = $this->backoffice_model->getCarDetails($user_id, $dealer_id);
        $this->load->view('backoffice/mobile_app/presentaties', $data);
    }

    public function website() {
        $this->load->model('backoffice_model');
        $data['user'] = $user = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Web en Mobiel";
        $data['activeTabHeader'] = "mobileapp";
        $data['activeTab'] = "website";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_id'] = $data['dealer'][0]->dealer_id;
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $data['car_details'] = $this->backoffice_model->getCarDetails($data['user']->id, $data['dealer'][0]->dealer_id);
        /* website_information start */
        $dealer_id = $data['dealer'][0]->dealer_id;
        $this->db->where('dealer_id', $dealer_id);
        $results = $this->db->query("select * from website where dealer_id = $dealer_id");
        $result = $results->result();

        $page_list = array();
        foreach ($result as $res) {




            $page_slug = $res->page_slug;



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
                $data['info'][$page_slug] = $res;
            }
        }

        $data['pages'] = $page_list;
        /* website_information start */



        $this->load->view('backoffice/mobile_app/website', $data);
    }

    public function updatepage() {
        $data = array(
            'page_status' => $this->input->post('pagestatus'),
            'page_title' => $this->input->post('page_title'),
            'page_content' => $this->input->post('page_content')
        );
        $this->db->where('page_id', $this->input->post('page_id'));
        $this->db->update('website', $data);
        $affected_rows = $this->db->affected_rows();
        if ($affected_rows == 1) {
            echo "Update successfully. Thank you.";
        } else {
            echo "Cann't Update. Please try again.";
        }
    }

    public function pagestatuschange() {

        $data = array(
            'page_status' => $this->input->post('page_status'),
        );
        $this->db->where('dealer_id', $this->input->post('dealer_id'));
        $this->db->where('page_slug', $this->input->post('page_slug'));
        $this->db->update('website', $data);
        $affected_rows = $this->db->affected_rows();
        if ($affected_rows == 1) {
            echo "Update successfully. Thank you.";
        } else {
            echo "Cann't Update. Please try again.";
        }
    }

    public function bannerupload() {
        $dealer_id = $_GET['dealerid'];
        if (!empty($_FILES)) {
            $targetPath2 = getcwd() . "/media/dealers/$dealer_id";
            if (!file_exists($targetPath2)) {
                mkdir($targetPath2, 0777, true);
            }
            $tempFile = $_FILES['file']['tmp_name'];
            $path_parts = pathinfo($_FILES["file"]["name"]);
            $fileName = "home" . '_' . $dealer_id . '.' . $path_parts['extension'];
            $newFileName = "home" . '_' . $dealer_id . '.png';
            $targetPath = getcwd() . "/media/dealers/$dealer_id/";
            $targetFile = $targetPath . $fileName;
            $NewtargetFile = $targetPath . $newFileName;
            move_uploaded_file($tempFile, $targetFile);
            if ($path_parts['extension'] != 'png') {
                imagepng(imagecreatefromstring(file_get_contents($targetFile)), $NewtargetFile);
            }
            $update = array(
                'page_media' => $newFileName
            );
            $this->db->where('dealer_id', $dealer_id);
            $this->db->update('website', $update);
            echo $_GET['userid'];
        }
    }

    public function newpage() {
        $data = array();
        $dealer_id = $_GET['userid'];
        $newpagetitle = $_POST['newpagetitle'];
        $page_content = $_POST['page_content'];
        $pagestatus = $_POST['pagestatus'];
        $slugmain = strtolower(str_replace(' ', '_', $newpagetitle));
        $check = $this->slugcheck($slugmain, $dealer_id);

        $x = 1;
        if ($check == 2) {
            $slug = $slugmain;
        }
        while ($check == 1) {
            $slug = $slugmain . "_" . $x;
            $check = $this->slugcheck($slug);
            $x++;
        }
        $slug;
        $data = array(
            'dealer_id' => $dealer_id,
            'page_slug' => $slug,
            'page_title' => $newpagetitle,
            'page_content' => $page_content,
            'page_status' => $pagestatus
        );
        $this->db->insert('website', $data);
        $affected_rows = $this->db->affected_rows();
        if ($affected_rows == 1) {
            echo "New page created successfully. Thank you.";
        } else {
            echo "Page is not create yet. Please try again.";
        }
    }

    public function slugcheck($slug, $dealer_id) {

        $ql = $this->db->query('select * from website where dealer_id = "' . $dealer_id . '" AND page_slug = "' . $slug . '"');
        ;
        $result = $ql->result();



        if ($ql->num_rows() > 0) {
            return 1;
        } else {
            return 2;
        }
    }

    function pagedelete() {
        $id = $_GET['pageid'];
        $this->db->delete('website', array('page_id' => $id));
        $affected_rows = $this->db->affected_rows();
        if ($affected_rows == 1) {
            echo "Page deleted successfully. Thank you.";
        } else {
            echo "Page cannot not delete. Please try again.";
        }
    }

    public function statistieken() {
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Web en Mobiel|Web en Mobiel|Web en Mobiel";
        $data['activeTabHeader'] = "mobileapp";
        $data['activeTab'] = "statistieken";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $car_details = $this->backoffice_model->getCarDetails($data['user']->id, $data['dealer'][0]->dealer_id);
        $to = date("Y-m-d");
        $statisties;
        $i = 0;
        $device = array();
        $dealer_id=$data['dealer'][0]->dealer_id;
        foreach ($car_details as $car_detail) {
           // print_r($car_detail);

            $item = $car_detail->adNumber;
            $sql = "SELECT * , COUNT(*) as eachdate FROM `statistics` where `view_dt` = '" . $to . "' AND (`item_id` = $item ) ";
            $resultgraph = $this->db->query($sql);
            $resuls = $resultgraph->result();
            $device[] = $resuls[0]->devicename;
            $statisties[$i]['item'] = $item;
            $statisties[$i]['brand'] = $car_detail->brand;
            $statisties[$i]['model'] = $car_detail->model;
            $statisties[$i]['eachdate'] = $resuls[0]->eachdate;
            $i++;
        }
        /* Device circle cart start */
        $sql = "SELECT * , count(*) as RowAmount  FROM `statistics` where dealer_id = $dealer_id  group by devicename ";
        $circlegraphs=$this->db->query($sql);
        $results=$circlegraphs->result();
        $data['circlegraph']=$results;
        
        
        /* Device circle graph chart end */




        // die();
        //print_r($device);
        //  $data['circle'] = array_count_values($device);
        $data['circle'] = '';
        $data['statisties'] = $statisties;

//       die();
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";             
        $this->load->view('backoffice/mobile_app/statistieken', $data);
    }

    public function changeCarStatus() {
        $this->load->model('backoffice_model');
        $status = $this->backoffice_model->changeCarStatus();
        if ($status == 1) {
            echo "Update successful.Thank you";
        } else {
            echo "Problem in Update. Try agian.";
        }
    }

    public function deleteCar() {
        
    }

    public function graph() {
        $imobycode = 1234568;
        $from = date("Y-m-d", strtotime("-1 week"));
        $to = date("Y-m-d");
        echo $sql = "SELECT * , COUNT(*) as eachdate FROM `statistics` where 
        ( `view_dt` >='" . $from . "' and `view_dt` <='" . $to . "' )
        AND
        (`item_id` = $imobycode ) group by `view_dt` ";



        $resultgraph = $this->db->query($sql);
        $graph = $resultgraph->result();
        $map = "";
        $total = 0;
        $min = 0;
        $max = 0;
        if (isset($graph)) {
            $total = count($graph);
            foreach ($graph as $bar) {
                $view_dt = $bar->view_dt;
                $view_dt = date("d-m-Y", strtotime($view_dt));
                $each = $bar->eachdate;
                if ($each > $max) {
                    $max = $each;
                }
                if ($each < $min) {
                    $min = $each;
                }

                $map = $map . "&lt;set name='" . $view_dt . "' value='" . $bar->eachdate . "' color='99D2EE' showName='1' hoverText='" . $view_dt . "'/&gt";
            }
        }
        echo $map;
    }

    function qrimage() {
        $qrDataGet[0] = $this->uri->segment(4);
        $qrDataGet[1] = $this->uri->segment(5);
        $qrDataGet[2] = $this->uri->segment(6);
        //print_r($qrDataGet);
        //die();
        if (!in_array($qrDataGet[0], array(74, 148, 222, 296, 370, 481, 814, 962))) {
            echo "Sorry! We do not support this size qr images";
        } else {
            if ($qrDataGet[2] != "" && $qrDataGet[2] == 'j') {
                $img = base_url() . '/qr_images/qr.php?w=' . $qrDataGet[0] . '&c=' . $qrDataGet[1] . '&d=' . urlencode(BASE . $qrDataGet[1]) . '&t=j';
            } else {
                $img = base_url() . '/qr_images/qr.php?w=' . $qrDataGet[0] . '&c=' . $qrDataGet[1] . '&d=' . urlencode(BASE . $qrDataGet[1]);
            }

            echo '<img src="' . $img . '"/>';
        }
    }

    
     function homepaginadefault(){
         $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Contact";
        $data['activeTabHeader'] = "crm";
        $data['activeTab'] = "contact";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $this->load->view('backoffice/default/mobileapp', $data);
     }
    
    
}
