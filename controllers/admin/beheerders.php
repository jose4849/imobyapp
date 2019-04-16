<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Beheerders extends CI_Controller {

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
        $superadmin = $this->ion_auth->in_group('superadmin');
        $this->load->library('pagination');
        $this->load->model('administrator_model');
        $data['administrators'] = $this->administrator_model->getAdministrators($superadmin);
        // searching

        if (count($_POST)) {
            if (($_POST['userid'] == null) && ($_POST['Naam'] == null) && ($_POST['organization'] == null) && ($_POST['Telefoonnummer'] == null) && ($_POST['email'] == null)) {
                redirect('admin/beheerders/', 'refresh');
            };
            $data['administrators'] = $this->administrator_model->searchAdministrators($superadmin);
        } else {
            // for pagination
            $config['base_url'] = base_url('admin/beheerders/index');
            $config['total_rows'] = count($data['administrators']);
            $config['per_page'] = PERPAGE;
            // $config['per_page'] = 1;
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
            $data['administrators'] = $this->administrator_model->getAdministratorsWithLimit($config['per_page'], $this->uri->segment(4), $superadmin);
        }
        $data['superadmin'] = $superadmin;
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "administrator";
        $this->load->view('admin/administrator/home', $data);
    }

    public function add() {
        $data['user'] = $this->ion_auth->user()->row();
        $data['superadmin'] = $this->ion_auth->in_group('superadmin');
        //var_dump($this->db->last_query());
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "administrator";
        $this->load->view('admin/administrator/newAdministrator', $data);
    }

    public function insert() {

        $this->load->library('form_validation');
        //validate form input
        $this->form_validation->set_rules('Achternaam', 'Achternaam', 'required|xss_clean');
        $this->form_validation->set_rules('Voornaam', 'Voornaam', 'required|xss_clean');
        //$this->form_validation->set_rules('Tussenvoegsel', 'Tussenvoegsel', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[users.email]');
        //$this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_rules('Telefoonnummer', 'Telefoonnummer', 'required|xss_clean');
        $this->form_validation->set_rules('lock', 'lock', 'required|xss_clean');
        // set error message
        $this->form_validation->set_message('is_unique', 'Email Address has already been taken.');
        if ($this->form_validation->run() == true) {
            $username = $this->input->post('email');
            $email = $this->input->post('email');
            $password = $this->input->post('lock');
            $additional_data = array(
                'salutation' => $this->input->post('aanhef'),
                'firstName' => $this->input->post('Voornaam'),
                'middleName' => $this->input->post('Tussenvoegsel'),
                'lastName' => $this->input->post('Achternaam'),
                'phoneNumber1' => $this->input->post('Telefoonnummer'),
                'organization' => $this->input->post('organization'),
                'function' => $this->input->post('function'),
            );
            $id = $this->ion_auth->register($username, $password, $email, $additional_data);
            if ($this->input->post('actief2') == "1") {
                $data = array(
                    'user' => $id,
                    'group' => '1',
                );
                $this->db->insert('users2groups', $data);
            }
            if ($this->input->post('actief1') == "1") {
                $data = array(
                    'user' => $id,
                    'group' => '2',
                );
                $this->db->insert('users2groups', $data);
            }
            $actief = $this->input->post('actief');
            $actief2 = $this->input->post('actief2');
            if (($actief == 0) && ($actief == 0)) {
                $data = array(
                    'user' => $id,
                    'group' => '4',
                );
                $this->db->insert('users2groups', $data);
            }
            echo 'success';
        } else {
            $data = array(
                'Achternaam' => form_error('Achternaam'),
                'Voornaam' => form_error('Voornaam'),
                'Tussenvoegsel' => form_error('Tussenvoegsel'),
                'email' => form_error('email'),
                'Telefoonnummer' => form_error('Telefoonnummer'),
                'lock' => form_error('lock'),
            );

            echo json_encode($data);
        }
    }

    public function edit($id) {
        $superadmin = $this->ion_auth->in_group('superadmin');
        $data['superadmin'] = $superadmin;
        $current = $this->ion_auth->get_user_id();
        if ($current == $id) {
            $data['current'] = 1;
        } else {
            $data['current'] = 0;
        }
        $data['users'] = $this->ion_auth->user($id)->row();
        $data['user'] = $this->ion_auth->user($current)->row();

        $data['superadmin'] = $this->ion_auth->in_group('superadmin');
        $data['is_superadmin'] = $this->ion_auth->in_group('superadmin', $id);
        $data['is_admin'] = $this->ion_auth->in_group('admin', $id);
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "administrator";
        $this->load->view('admin/administrator/editAdministrator', $data);
    }

    function instellingen($id) {
        $superadmin = $this->ion_auth->in_group('superadmin');
        $data['superadmin'] = $superadmin;
        $current = $this->ion_auth->get_user_id();
        if ($current == $id) {
            $data['current'] = 1;
        } else {
            $data['current'] = 0;
        }
        $data['users'] = $this->ion_auth->user($id)->row();
        $data['user'] = $this->ion_auth->user($current)->row();

        $data['superadmin'] = $this->ion_auth->in_group('superadmin');
        $data['is_superadmin'] = $this->ion_auth->in_group('superadmin', $id);
        $data['is_admin'] = $this->ion_auth->in_group('admin', $id);
        $data['pagetitle'] = "Gebruikers";
        $data['activeTab'] = "instellingen";
        $this->load->view('admin/administrator/editAdministrator', $data);
    }

    public function update($id) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('Voornaam', 'Voornaam', 'required|xss_clean');
        // $this->form_validation->set_rules('Tussenvoegsel', 'Tussenvoegsel', 'required|xss_clean');
        $this->form_validation->set_rules('Achternaam', 'Achternaam', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|edit_unique[users.email.' . $id . ']');
        $this->form_validation->set_rules('Telefoonnummer', 'Telefoonnummer', 'required|xss_clean');
        // $this->form_validation->set_rules('lock', 'lock', 'required|xss_clean');
        // set error message

        $this->form_validation->set_message('is_unique', 'Email Address has already been taken.');

        if ($this->form_validation->run() == true) {
            try {
                /* try start */
                $password = $this->input->post('lock');

                if ($password == null) {
                    $data = array(
                        'salutation' => $this->input->post('aanhef'),
                        'firstName' => $this->input->post('Voornaam'),
                        'middleName' => $this->input->post('Tussenvoegsel'),
                        'lastName' => $this->input->post('Achternaam'),
                        'organization' => $this->input->post('organization'),
                        'function' => $this->input->post('function'),
                        'phoneNumber1' => $this->input->post('Telefoonnummer'),
                        'email' => $this->input->post('email')
                    );
                    $upstatus = $this->ion_auth->update($id, $data);
                    if ($upstatus) {
                        $error = array(
                            'success' => true
                        );
                        echo json_encode($error);
                    }
                } else {
                    /* else start */
                    $superadmin = $this->ion_auth->in_group('superadmin');
                    if ($superadmin) {
                        $data = array(
                            'salutation' => $this->input->post('aanhef'),
                            'firstName' => $this->input->post('Voornaam'),
                            'middleName' => $this->input->post('Tussenvoegsel'),
                            'lastName' => $this->input->post('Achternaam'),
                            'organization' => $this->input->post('organization'),
                            'function' => $this->input->post('function'),
                            'phoneNumber1' => $this->input->post('Telefoonnummer'),
                            'email' => $this->input->post('email'),
                            'password' => $this->input->post('lock')
                        );
                        $this->ion_auth->update($id, $data);
                    } else {
                        /* if not super admin start */

                        $old_password = $this->input->post('old_password');
                        $password_matches = $this->ion_auth->hash_password_db($id, $old_password);
                        if ($password_matches) {
                            $data = array(
                                'salutation' => $this->input->post('aanhef'),
                                'firstName' => $this->input->post('Voornaam'),
                                'middleName' => $this->input->post('Tussenvoegsel'),
                                'lastName' => $this->input->post('Achternaam'),
                                'organization' => $this->input->post('organization'),
                                'function' => $this->input->post('function'),
                                'phoneNumber1' => $this->input->post('Telefoonnummer'),
                                'email' => $this->input->post('email'),
                                'password' => $this->input->post('lock')
                            );
                            $this->ion_auth->update($id, $data);
                            if ($upstatus) {
                                $error = array(
                                    'success' => true
                                );
                                echo json_encode($error);
                            }
                        } else {
                            $error = array(
                                'passnotmatch' => 'Password not match'
                            );
                            echo json_encode($error);
                        }
                        /* else start */
                        /* if not super admin end */
                    }
                }

                /* account rule update */
                $superadmin = $this->ion_auth->in_group('superadmin');
                if ($superadmin) {
                    if ($this->ion_auth->update($id, $data)) {
                        // delete from 'user2group' table
                        $query = $this->db->where('user', $id);
                        $query = $this->db->delete('users2groups');


                        if ($this->input->post('actief2') == "1") {
                            $data = array(
                                'user' => $id,
                                'group' => '1',
                            );
                            $this->db->insert('users2groups', $data);
                        }
                        if ($this->input->post('actief') == "1") {
                            $data = array(
                                'user' => $id,
                                'group' => '2',
                            );
                            $this->db->insert('users2groups', $data);
                        }
                        $actief = $this->input->post('actief');
                        $actief2 = $this->input->post('actief2');
                        if (($actief == 0) && ($actief == 0)) {
                            $data = array(
                                'user' => $id,
                                'group' => '4',
                            );
                            $this->db->insert('users2groups', $data);
                        }
                    }
                }
                /* account rule update */


                /* try end */
            } catch (Exception $e) {
                /* catch start */
                $error = array(
                    'success' => FALSE,
                    'message' => $e->getMessage()
                );
                echo json_encode($error);
                /* catch end */
            }
        } else {
            /* validation false start */
            $data = array(
                'success' => FALSE,
                'Achternaam' => form_error('Achternaam'),
                'Voornaam' => form_error('Voornaam'),
                'Tussenvoegsel' => form_error('Tussenvoegsel'),
                'email' => form_error('email'),
                'Telefoonnummer' => form_error('Telefoonnummer'),
                    // 'lock' => form_error('lock'),
            );
            echo json_encode($data);
            /* validation false end */
        }



        /*

          if ($this->form_validation->run() == true) {
          try {

          } else {
          $data = array(
          'success' => FALSE,
          'Achternaam' => form_error('Achternaam'),
          'Voornaam' => form_error('Voornaam'),
          'Tussenvoegsel' => form_error('Tussenvoegsel'),
          'email' => form_error('email'),
          'Telefoonnummer' => form_error('Telefoonnummer'),
          // 'lock' => form_error('lock'),
          );
          echo json_encode($data);
          //echo $form_validation->error_array();
          //echo form_error('email');
          }

















          $superadmin = $this->ion_auth->in_group('superadmin');
          if ($superadmin) {



          if ($this->ion_auth->update($id, $data)) {
          // delete from 'user2group' table
          $query = $this->db->where('user', $id);
          $query = $this->db->delete('users2groups');


          if ($this->input->post('actief2') == "1") {
          $data = array(
          'user' => $id,
          'group' => '1',
          );
          $this->db->insert('users2groups', $data);
          }
          if ($this->input->post('actief') == "1") {
          $data = array(
          'user' => $id,
          'group' => '2',
          );
          $this->db->insert('users2groups', $data);
          }
          $actief = $this->input->post('actief');
          $actief2 = $this->input->post('actief2');
          if (($actief == 0) && ($actief == 0)) {
          $data = array(
          'user' => $id,
          'group' => '4',
          );
          $this->db->insert('users2groups', $data);
          }


          $success = array(
          'success' => TRUE,
          'message' => 'success'
          );
          echo json_encode($success);
          }
          }
          } catch (Exception $e) {
          $error = array(
          'success' => FALSE,
          'message' => $e->getMessage()
          );
          echo json_encode($error);
          }
         */
    }

    function delete_user() {
        if ($this->ion_auth->in_group('superadmin')) {
            $id = $this->input->post('user_id');
            $this->db->where('id', $id);
            $this->db->delete('users');
            if ($this->db->affected_rows() >= 0) {
                echo 'Successfully deleted. Thank you.';
            } else {
                echo 'Cannnot deleted Try later';
            }
        } else {
            echo 'Cannnot deleted Try later';
        }
    }

    

}
