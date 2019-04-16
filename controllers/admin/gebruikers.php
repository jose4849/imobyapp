<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gebruikers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in())
            redirect('login', 'refresh');

        $superadmin = $this->ion_auth->in_group('superadmin');
        if ($superadmin) {
            $log = 1;
        } else {
            $log = 0;
        }
        $admin = $this->ion_auth->in_group('admin');
        if ($admin) {
            $logadmin = 1;
        } else {
            $logadmin = 0;
        }
        if (($log == 0) && ($logadmin == 0)) {
            redirect('login', 'refresh');
        }
    }

    public function index() {

        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "user";
        $this->load->library('pagination');
        $this->load->model('dealer_model');
        $data['dealers'] = $this->dealer_model->getDealers();

        if (count($_POST)) {
            $data['dealers'] = $this->dealer_model->searchimobycode();
        } else {
            // for pagination
            $config['base_url'] = base_url('admin/gebruikers/index');
            $config['total_rows'] = count($data['dealers']);
            $config['per_page'] = PERPAGE;
            $config['uri_segment'] = 4;
            $config['full_tag_open'] = '<ul>';
            $config['full_tag_close'] = '</ul>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['display_pages'] = FALSE;
            $config['first_link'] = FALSE;
            $config['last_link'] = FALSE;

            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['dealers'] = $this->dealer_model->getDealerWithLimit($config['per_page'], $this->uri->segment(4));
        }
        $this->load->view('admin/user/home', $data);
    }

    public function details() {
        $resultset=$this->db->query('SELECT * FROM `dealerfunctions`');
        $data['products']=$resultset->result();
        $this->uri->segment(4);
        $this->db->where('dealer', $this->uri->segment(4));
        $note = $this->db->count_all('notes');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "user";
        $this->load->model('dealer_model');
        $userid = $this->uri->segment(4);
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/gebruikers/details/' . $userid);
        $config['per_page'] = 3;
        $data['notes'] = $this->dealer_model->dealer_note($userid, $config['per_page'], $this->uri->segment(5));
        $config['total_rows'] = $note;
        $config['uri_segment'] = 5;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['display_pages'] = FALSE;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        /* end pagignation */
        $data['dealer'] = $this->dealer_model->singleDealer($userid);
        $data['dealer_functions'] = $this->dealer_model->singleDealerFunction($data['dealer'][0]->dealer_id);
        // echo '<pre>';
        // print_r($data);
        // die();
        $this->load->view('admin/user/details', $data);
    }

    public function nieuwegebruiker() {       
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "user";
        $resultset=$this->db->query('SELECT * FROM `dealerfunctions`');
        $data['products']=$resultset->result();
        $this->load->view('admin/user/addUser', $data);
    }

    public function insert() {

       // $this->db->trans_start();
        $this->load->library('form_validation');


        $this->form_validation->set_rules('company_contact_email', 'company_contact_email', 'required|valid_email');
        $this->form_validation->set_rules('company_email', 'company_email', 'required|valid_email');
        if ($this->form_validation->run() == true) {
            try {
                $username = $this->input->post('company_email');
                $email = $this->input->post('company_email');
                $password = 'password';
                $additional_data = array(
                    'salutation' => $this->input->post('salutation'),
                    'firstName' => $this->input->post('Voornaam'),
                    'middleName' => $this->input->post('Tussenvoegsel'),
                    'lastName' => $this->input->post('Achternaam'),
                    'function' => $this->input->post('function'),
                    'phoneNumber1' => $this->input->post('phoneNumber1'),
                    'phoneNumber2' => $this->input->post('phoneNumber2'),
                );
                echo $id = $this->ion_auth->register($username, $password, $email, $additional_data);

                $data = array(
                    'user' => $id,
                    'group' => '3', /* this for dealer id 3 */
                );
                $this->db->insert('users2groups', $data);


                // dealer entry
                $dealer = array(
                    'source' => '',
                    'sourceid' => '',
                    'name' => $this->input->post('name'),
                    'phoneNumber1' => $this->input->post('phoneNumber1'),
                    'phoneNumber2' => $this->input->post('phoneNumber2'),
                    'accountnumber' => $this->input->post('accountnumber'),
                    'iban' => $this->input->post('IBAN'),
                    'website' => $this->input->post('Website'),
                    'email' => $this->input->post('company_contact_email'),
                    'chamberOfCommerce' => $this->input->post('KvKnr'),
                    'Taxcode' => $this->input->post('BTWnr'),
                    'faxNumber' => $this->input->post('faxNumber'),
                );

                $this->db->insert('dealers', $dealer);
                $dealerID = $this->db->insert_id();

                // user2dealer entry
                $user2dealer = array(
                    'user' => $id,
                    'dealer' => $dealerID
                );
                $this->db->insert('users2dealers', $user2dealer);

                // address entry
                $address = array(
                    'type' => 'post',
                    'street' => $this->input->post('street'),
                    'house_num' => $this->input->post('house_num'),
                    'house_num_addition' => $this->input->post('house_num_addition'),
                    'postal_code' => $this->input->post('postal_code'),
                    'city' => $this->input->post('city'),
                );
                $this->db->insert('addresses', $address);
                $address = $this->db->insert_id();

                // dealer2address entry
                $dealer2address = array(
                    'dealer' => $dealerID,
                    'address' => $address
                );
                $this->db->insert('dealers2addresses', $dealer2address);
                $data = array(
                    'success' => TRUE,
                    'message' => 'Success',
                    'dealer_id' => $dealerID
                );

                die();
                // echo json_encode($data);
            } catch (Exception $e) {
                $data = array(
                    'success' => FALSE,
                    'message' => $e->getMessage()
                );
                // echo json_encode($data);
            }
        } else {
            $data = array(
                'success' => FALSE,
                'message' => 'Validation error'
            );
            echo json_encode($data);
        }
        //echo $this->db->trans_complete();
    }

    public function update($user_id, $dealer_id, $address_id) {

        $this->load->library('form_validation');
        //  $this->form_validation->set_rules('company_contact_email', 'company_contact_email', 'required|valid_email');

       // print_r($_POST);
       // die();
        
        if ($this->form_validation->run() != true) {
            try {

                $additional_data = array(
                    'salutation' => $this->input->post('salutation'),
                    'firstName' => $this->input->post('Voornaam'),
                    'middleName' => $this->input->post('Tussenvoegsel'),
                    'lastName' => $this->input->post('Achternaam'),
                    'function' => $this->input->post('function'),
                    'phoneNumber1' => $this->input->post('phoneNumber1'),
                    'phoneNumber2' => $this->input->post('phoneNumber2'),
                    'username' => $this->input->post('company_email'),
                    'email' => $this->input->post('company_email'),
                   
                );

                $this->ion_auth->update($user_id, $additional_data);

                // users2groups update
                $this->db->where('user', $user_id);
                $this->db->delete('users2groups');

                $data = array(
                    'user' => $user_id,
                    'group' => '3',
                );

                $this->db->insert('users2groups', $data);

                // dealer update
                $dealer = array(
                    
                    'name' => $this->input->post('name'),
                    'phoneNumber1' => $this->input->post('phoneNumber1'),
                    'phoneNumber2' => $this->input->post('phoneNumber2'),
                    'accountnumber' => $this->input->post('accountnumber'),
                    'ibbn' => $this->input->post('IBBN'),
                    'website' => $this->input->post('Website'),
                    'email' => $this->input->post('company_contact_email'),
                    'chamberOfCommerce' => $this->input->post('KvKnr'),
                    'Taxcode' => $this->input->post('BTWnr'),
                    'faxNumber' => $this->input->post('faxNumber')
                );

                $this->db->where('id', $dealer_id);
                $this->db->update('dealers', $dealer);

                // user2dealer update
                $this->db->where('user', $user_id);
                $this->db->delete('users2dealers');

                $user2dealer = array(
                    'user' => $user_id,
                    'dealer' => $dealer_id
                );
                $this->db->insert('users2dealers', $user2dealer);

                // address update
                $address = array(
                    'type' => 'post',
                    'street' => $this->input->post('street'),
                    'house_num' => $this->input->post('house_num'),
                    'house_num_addition' => $this->input->post('house_num_addition'),
                    'postal_code' => $this->input->post('postal_code'),
                    'city' => $this->input->post('city'),
                );
                $this->db->where('id', $address_id);
                $this->db->update('addresses', $address);

                // dealer2address update
                $this->db->where('dealer', $dealer_id);
                $this->db->delete('dealers2addresses');

                $dealer2address = array(
                    'dealer' => $dealer_id,
                    'address' => $address_id
                );
                $this->db->insert('dealers2addresses', $dealer2address);

                $data = array(
                    'success' => TRUE,
                    'message' => 'Success',
                        //'dealer_id' => $dealer_id
                );
                echo json_encode($data);
            } catch (Exception $e) {
                $data = array(
                    'success' => FALSE,
                    'message' => $e->getMessage()
                );
                echo json_encode($data);
            }
        } else {
            $data = array(
                'success' => FALSE,
                'message' => 'Validation error'
            );
            echo json_encode($data);
        }
    }

  
    public function insertFunction($dealer_id) {
        try {
            if ($this->input->post('actiefm') == "1") {
                $data = array(
                    'dealer' => $dealer_id,
                    'dealerfunction' => '1',
                );
                $this->db->insert('dealers2dealerfunctions', $data);
            }
            if ($this->input->post('actiefr') == "1") {
                $data = array(
                    'dealer' => $dealer_id,
                    'dealerfunction' => '2',
                );
                $this->db->insert('dealers2dealerfunctions', $data);
            }
            if ($this->input->post('actiefi') == "1") {
                $data = array(
                    'dealer' => $dealer_id,
                    'dealerfunction' => '3',
                );
                $this->db->insert('dealers2dealerfunctions', $data);
            }
            if ($this->input->post('actiefd') == "1") {
                $data = array(
                    'dealer' => $dealer_id,
                    'dealerfunction' => '4',
                );
                $this->db->insert('dealers2dealerfunctions', $data);
            }
            $data = array(
                'success' => TRUE,
                'message' => 'success'
            );
            echo json_encode($data);
        } catch (Exception $e) {
            $data = array(
                'success' => FALSE,
                'message' => $e->getMessage()
            );
            echo json_encode($data);
        }
    }

    public function updateFunction($dealer_id) {
        //return;
        // update dealer functions
        try {

            $this->db->where('dealer', $dealer_id);
            $this->db->delete('dealers2dealerfunctions');

            if ($this->input->post('actief1') == "1") {
                $data = array(
                    'dealer' => $dealer_id,
                    'dealerfunction' => '1',
                );
                $this->db->insert('dealers2dealerfunctions', $data);
            }
            if ($this->input->post('actief2') == "1") {
                $data = array(
                    'dealer' => $dealer_id,
                    'dealerfunction' => '2',
                );
                $this->db->insert('dealers2dealerfunctions', $data);
            }
            if ($this->input->post('actief3') == "1") {
                $data = array(
                    'dealer' => $dealer_id,
                    'dealerfunction' => '3',
                );
                $this->db->insert('dealers2dealerfunctions', $data);
            }
            if ($this->input->post('actief4') == "1") {
                $data = array(
                    'dealer' => $dealer_id,
                    'dealerfunction' => '4',
                );
                $this->db->insert('dealers2dealerfunctions', $data);
            }
            $data = array(
                'success' => TRUE,
                'message' => 'success'
            );
            echo json_encode($data);
        } catch (Exception $e) {
            $data = array(
                'success' => FALSE,
                'message' => $e->getMessage()
            );
            echo json_encode($data);
        }
    }

     public function updatesource($dealer_id) {
    
        /* source id update start */
         
          $source = $_POST['source'];
          $source_id = $_POST[$source];
          $data = array(
          'source' => $source,
          'sourceId' => $source_id
          );
          $this->db->where('id', $dealer_id);
          $this->db->update('dealers', $data);


          /* source id  update end */
        /* check homepage id start */

        
        $query = $this->db->query("select * from dealers where id = $dealer_id");
        $dealer = $query->result();
        $count = $query->num_rows();
        $homepage = $this->db->query("SELECT MAX(homePageId) as maxid FROM dealers;");
        $results = $homepage->result();
        $max_id = $results[0]->maxid;
        
        if ($count > 0) {
            $homePageId = $dealer[0]->homePageId;
            $stockPageId = $dealer[0]->stockPageId;
            /* homepage id start */
            if (($homePageId == null) || ($homePageId == 0)) {
                $checkid = 0;
                while ($checkid == 0) {
                    $max_id = $max_id + 1;
                    $query = $this->db->query("SELECT * FROM dealers WHERE $max_id IN(`homePageId`, `stockPageId`)");
                    $result = $query->result();
                    if (isset($result[0])) {
                        $checkid = 0;
                    } else {
                        $data = array(
                            'homePageId' => $max_id
                        );
                        $this->db->where('id', $dealer_id);
                        $this->db->update('dealers', $data);

                        $checkid = 1;
                    }
                    
                }
            }
            /* homepage id end */
            /* stockPageId id start */
            
            $stockpage = $this->db->query("SELECT MAX(stockPageId) as maxid FROM dealers;");
            $results_stock = $stockpage->result();
            $max_id = $results_stock[0]->maxid;            
            
            if (($stockPageId == null) || ($stockPageId == 0)) {
                $checkid = 0;
                while ($checkid == 0) {
                    $max_id = $max_id + 1;
                    $query = $this->db->query("SELECT * FROM dealers WHERE $max_id IN(`homePageId`, `stockPageId`)");
                    $result = $query->result();
                    if (isset($result[0])) {
                        $checkid = 0;
                    } else {
                        $data = array(
                            'stockPageId' => $max_id
                        );
                        $this->db->where('id', $dealer_id);
                        $this->db->update('dealers', $data);

                        $checkid = 1;
                    }
                    
                }
            }
            /* homepage id end */
            
            
            
            
        }




        /* echec homepage id end */


        echo "Data is successfully Updated";
    }

   

    public function uploader() {

        $user_id = $_GET['userid'];
        if (!empty($_FILES)) {
            $targetPath2 = getcwd() . "/media/dealers/$user_id";
            if (!file_exists($targetPath2)) {
                mkdir($targetPath2, 0777, true);
            }
            $tempFile = $_FILES['file']['tmp_name'];
            $path_parts = pathinfo($_FILES["file"]["name"]);
            $fileName = "logo" . '_' . $user_id . '.' . $path_parts['extension'];
            $newFileName = "logo" . '_' . $user_id . '.jpg';
            $targetPath = getcwd() . "/media/dealers/$user_id/";
            $targetFile = $targetPath . $fileName;
            $NewtargetFile = $targetPath . $newFileName;
            move_uploaded_file($tempFile, $targetFile);
            if ($path_parts['extension'] != 'jpg') {
                imagepng(imagecreatefromstring(file_get_contents($targetFile)), $NewtargetFile);
            }
        }
    }

    function note_insert() {
        $this->db->insert('notes', $_POST);
        echo "Your note is successfully Saved.";
    }

    function note_view() {
        $note_id = $this->input->post('id');
        $this->db->select('*');
        $this->db->from('notes');
        $this->db->join('users', 'notes.admin_id=users.id');
        $this->db->where('note_id', $note_id);
        $results = $this->db->get();
        $result = $results->result();
        echo '<strong>Omschrijving:</strong>';
        echo '<p>' . $result[0]->note_title . '</p>';
        echo '<strong>Notitie:</strong>';
        echo '<p>' . $result[0]->note_description . '</p>';
        echo '<strong>Bestand(en):</strong></br></br>';
        $files = $result[0]->file;
        $dealer = $result[0]->dealer;
        $filearray = explode(",", $files);
        //print_r($filearray);
        // echo base_url()."/media/dealers/".$dealer."/"; 
        foreach ($filearray as $file) {
            //echo $file;
            if ($file != '') {
                echo "<a target='_blank' href='" . base_url() . "media/dealers/" . $dealer . "/" . $file . "'><img width='20%' alt=" . $file . " src='" . base_url() . "media/dealers/" . $dealer . "/" . $file . "' /></a>";
            }
            // echo $file;
        }
        echo '</br></br><strong>Medewerker:</strong>';
        echo " " . $result[0]->firstName . " " . $result[0]->middleName . " " . $result[0]->lastName;
    }

    function note_up() {
        $user_id = $_GET['dealer_id'];
        if (!empty($_FILES)) {
            $targetPath2 = getcwd() . "/media/dealers/$user_id";
            if (!file_exists($targetPath2)) {
                mkdir($targetPath2, 0777, true);
            }
            $now = time();
            $gmt = local_to_gmt($now);
            $tempFile = $_FILES['file']['tmp_name'];
            $path_parts = pathinfo($_FILES["file"]["name"]);
            echo $fileName = $gmt . '.' . $path_parts['extension'];
            $newFileName = $gmt . '.png';
            $targetPath = getcwd() . "/media/dealers/" . $user_id . "/";
            $targetFile = $targetPath . $fileName;
            $NewtargetFile = $targetPath . $newFileName;
            move_uploaded_file($tempFile, $targetFile);
            if ($path_parts['extension'] != 'png') {
                imagepng(imagecreatefromstring(file_get_contents($targetFile)), $NewtargetFile);
            }
        }
    }

    function delete_note() {
        $note_id = $this->input->post('note_id');
        $admin_id = $this->input->post('admin_id');
        $this->db->where('note_id', $note_id);
        $this->db->where('admin_id', $admin_id);
        $res = $this->db->delete('notes');
        if ($res == 1) {
            echo "Note is Successfully Deleted. Thank You.";
        }
    }

    public function delete_profile_image() {
        $user_id = $_POST['user_id'];
        $fileName = "logo" . '_' . $user_id . '.' . "png";
        $targetPath = getcwd() . "/media/dealers/$user_id/$fileName";
        unlink($targetPath);
        echo "Your Profile Image is successfully Deleted";
    }

    public function contact() {
        die();
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "user";
        $this->load->view('admin/layout/contact', $data);
    }

    public function defaultwebpage() {
        // $dealer_id = $_GET['id'];
        $data = array(
            'dealer_id' => 0,
            'page_slug' => 'home',
            'page_title' => 'Autobedrijf Van Doornik',
            'page_content' => 'Autobedrijf Van Doornik heeft zich gevestigd in Nijkerk. Wanneer u op zoek bent naar kwalitatief goed onderhoud tegen een laag uurtarief bent u bij ons aan het juiste adres. Dit behalen we door de vaste kosten zo laag mogelijk te houden en goede prijsafspraken te maken met onze leveranciers.',
            'page_media' => 'banner-bg.jpg',
            'page_status' => 1
        );
        $this->db->insert('website', $data);
        echo 'successfully';
    }

}