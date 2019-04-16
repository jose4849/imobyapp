<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatie extends CI_Controller {

    public function __construct() {
        parent::__construct();
         /*
          if ($this->session->userdata('logged_in')) {

          }
          else{

          $return=$_POST['return'];
          redirect($return, 'refresh');
          }
         */
    }

    public function index() {
        redirect(base_url('relatie/voertuigen'), 'refresh');
    }

    public function voertuigen() {

        $this->load->model('crm_klanten');
        $this->load->model('crm_autos');
        $this->load->model('crm_note_files');
        $this->load->model('crm_onderhoud');
        $this->load->model('crm_marketing');
        $this->load->model('crm_facturen');
        $session_data = $this->session->userdata('logged_in');
        $klant_id = ($session_data['klant_info']->klant_id);
        $klant_dealerId = ($session_data['klant_info']->klant_dealerId);
        $autos = $this->crm_autos->autosByKlant($klant_id);
        $auto_ids = array();
        $auto_name = array();
        // echo '<pre>'; print_r($autos); die();
        foreach ($autos as $auto) {
            $auto_ids[] = $auto->auto_id;
            $auto_name[] = $auto->auto_type . " | " . $auto->auto_kenteken;
            $data['auto'] = $auto;
        }
        $auto_id = $this->uri->segment(3);
        if ($auto_id == null) {
            $auto_id = $auto_ids[0];
        } else {
            $auto_id = $this->uri->segment(3);
        }

        foreach ($autos as $auto) {
            $id = $auto->auto_id;
            if ($auto_id == $id) {
                $data['auto'] = $auto;
            }
        }


        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where dealers.id = $klant_dealerId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $data['DealerInfo'] = $queryresult;
        }
        /* coloer schame start */
        $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $klant_dealerId and attribute = 'colorschrme'");
        $colorschme = $colorschmes->result();
                if (isset($colorschme[0])) {
                    $data['colorschme'] = $colorschme[0]->value;
                } else {
                    $data['colorschme'] = 'nocolor';
                }
        /* coloer schame start */
        
        $data['onderhoud'] = $this->crm_onderhoud->getOnderhoud($auto_id);
        $data['bestanden'] = $this->crm_note_files->getDocumenten('bestand', 'auto', $auto_id);
        $data['opmerkingen'] = $this->crm_note_files->getNotes($auto_id);
        $data['facturen'] = $this->crm_facturen->getAutoFacturen($klant_dealerId, $auto_id);
        $data['marketingActies'] = $this->crm_marketing->getDealerActiesAndSettings($klant_dealerId, 'auto', $auto_id);
        $data['auto_ids'] = $auto_ids;
        $data['auto_name'] = $auto_name;
        $data['active'] = 'voertuigen';
        $data['menu'] = $this->load->view('website/relatie/nav_menu', $data, true);
        $data['header'] = $this->load->view('website/relatie/header', $data, true);
        $this->load->view('website/relatie/voertuigen', $data);
    }

    public function instellingen() {
        $this->load->model('crm_klanten');
        $this->load->model('crm_autos');
        $this->load->model('crm_note_files');
        $this->load->model('crm_onderhoud');
        $this->load->model('crm_marketing');
        $this->load->model('crm_facturen');
        $data['active'] = 'instellingen';
        $session_data = $this->session->userdata('logged_in');
        $klant_id = ($session_data['klant_info']->klant_id);
        $klant_dealerId = ($session_data['klant_info']->klant_dealerId);

        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where dealers.id = $klant_dealerId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $data['DealerInfo'] = $queryresult;
        }


        $klant = $this->crm_klanten->getKlant($klant_id, $klant_dealerId);
        $data['klant'] = $klant;
        $data['marketingActies'] = $this->crm_marketing->getDealerActiesAndSettings($klant_dealerId, 'klant', $klant_id);

/* coloer schame start */
        $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $klant_dealerId and attribute = 'colorschrme'");
        $colorschme = $colorschmes->result();
                if (isset($colorschme[0])) {
                    $data['colorschme'] = $colorschme[0]->value;
                } else {
                    $data['colorschme'] = 'nocolor';
                }
        /* coloer schame start */		

        // die();
        $data['menu'] = $this->load->view('website/relatie/nav_menu', $data, true);
        $data['header'] = $this->load->view('website/relatie/header', $data, true);
        $this->load->view('website/relatie/instellingen', $data);
    }

    public function afspraken() {
        $data['active'] = 'afspraken';
        $session_data = $this->session->userdata('logged_in');
        $klant_id = ($session_data['klant_info']->klant_id);
        $klant_dealerId = ($session_data['klant_info']->klant_dealerId);
        
        
        
        $query = $this->db->query("select * from dealers 
                join users2dealers on dealers.id = users2dealers.dealer 
                join users on users.id = users2dealers.user 
                join dealers2addresses on users2dealers.dealer = dealers2addresses.dealer
                join addresses on dealers2addresses.address = addresses.id
                where dealers.id = $klant_dealerId");
        $queryresult = $query->result();
        if (isset($queryresult[0])) {
            $data['DealerInfo'] = $queryresult;
        }
/* coloer schame start */
        $colorschmes = $this->db->query("SELECT value FROM `dealersettings` where dealer = $klant_dealerId and attribute = 'colorschrme'");
        $colorschme = $colorschmes->result();
                if (isset($colorschme[0])) {
                    $data['colorschme'] = $colorschme[0]->value;
                } else {
                    $data['colorschme'] = 'nocolor';
                }
        /* coloer schame start */
        $data['menu'] = $this->load->view('website/relatie/nav_menu', $data, true);
        $data['header'] = $this->load->view('website/relatie/header', $data, true);
        $this->load->view('website/relatie/afspraken', $data);
    }

    /*
      function logincheck() {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $resultset = $this->db->query("select * from crm_klanten where klant_email = '$email'");
      $result = $resultset->result();
      if (isset($result[0])) {
      $this->load->library('session');
      $result[0]->login_client = 'log';
      $result[0]->return = $_POST['return'];
      $this->session->set_userdata($result[0]);
      redirect(base_url('relatie/voertuigen'), 'refresh');
      } else {
      $return = $_POST['return'];
      redirect($return, 'refresh');
      }
      }
     */

    function login() {
        $username = $_POST['email'];
        $password = $_POST['password'];
        $this->db->select('*');
        $this->db->from('crm_klanten');
        $this->db->where('klant_email', $username);
        //$this->db->where('password',($password));
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function logincheck() {

        $username = $this->input->post('email');
        $return = $this->input->post('return');
        $result = $this->login();
        if ($result) {
            $sess_array = array();
            $sess_array = array(
                'klant_info' => $result[0],
                'return' => $return
            );
            $this->session->set_userdata('logged_in', $sess_array);
            redirect(base_url('relatie/index'), 'refresh');
            // print_r($session_data = $this->session->userdata('logged_in'));
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            // echo 'hello';
        }
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect($return, 'refresh');
    }

}
