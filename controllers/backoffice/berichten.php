<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Berichten extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library("pagination");
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group('dealer'))
            redirect('login', 'refresh');
    }

    public function postvakin() {
        $this->load->helper('text');
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Dashboard";
        $data['activeTabHeader'] = "posts";
        $data['activeTab'] = "postvakin";
        if (($this->uri->segment(4)) != null) {
            $lim = $this->uri->segment(4);
            $pagi = "LIMIT " . $lim . " , 2";
        } else {
            $pagi = 'LIMIT 0 , 15';
        }
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $dealer_id = ($data['dealer'][0]->dealer_id);
        $emails = $this->db->query("select * from email where dealer_id = $dealer_id and box = 'inbox'");
        $data['count'] = $emails->num_rows();
        $emails = $this->db->query("select * from email where dealer_id = $dealer_id and box = 'inbox' $pagi ");
        $data['email'] = $emails->result();
        $config = array();
        $config["base_url"] = base_url() . "backoffice/berichten/postvakin";
        $config["total_rows"] = $data['count'];
        $config["per_page"] = 15;
        $config["uri_segment"] = 4;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['display_pages'] = FALSE;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['cur_pag'] = floor(($this->uri->segment(n) / $config['per_page']) + 1);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $this->load->view('backoffice/posts/posts', $data);
    }

    public function verwijderd() {
        $this->load->helper('text');
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Dashboard";
        $data['activeTabHeader'] = "posts";
        $data['activeTab'] = "verwijderd";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $dealer_id = ($data['dealer'][0]->dealer_id);
        $emails = $this->db->query("select * from email where dealer_id = $dealer_id and box = 'debox' ");
        $data['count'] = $emails->num_rows();
        $data['email'] = $emails->result();
        $this->load->view('backoffice/posts/verwijderd', $data);
    }

    public function verzonden() {
        $this->load->helper('text');
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Dashboard";
        $data['activeTabHeader'] = "posts";
        $data['activeTab'] = "verzonden";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $dealer_id = ($data['dealer'][0]->dealer_id);
        $emails = $this->db->query("select * from email where dealer_id = $dealer_id and box = 'sebox' ");
        $data['count'] = $emails->num_rows();
        $data['email'] = $emails->result();
        $this->load->view('backoffice/posts/verzonden', $data);
    }

    public function aanbod() {
        $this->load->helper('text');
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Dashboard";
        $data['activeTabHeader'] = "posts";
        $data['activeTab'] = "aanbod";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $dealer_id = ($data['dealer'][0]->dealer_id);
        $emails = $this->db->query("select * from email where dealer_id = $dealer_id and box = 'anbox' limit 0, 10 ");
        $data['count'] = $emails->num_rows();
        $data['email'] = $emails->result();
        $this->load->view('backoffice/posts/annbod', $data);
    }

    public function nieuw() {
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Dashboard";
        $data['activeTabHeader'] = "posts";
        $data['activeTab'] = "posts";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $data['dealer_id'] = $data['dealer'][0]->dealer_id;
        $this->load->view('backoffice/posts/nieuw', $data);
    }

    public function view($email_id) {
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Dashboard";
        $data['activeTabHeader'] = "posts";
        $data['activeTab'] = "posts";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $data['dealer_id'] = $data['dealer'][0]->dealer_id;
        $emails = $this->db->query("select * from email where email_id = $email_id");
        $data['email'] = $emails->result();
        $this->load->view('backoffice/posts/berichten_view', $data);
    }

    function emailmove() {
        $check_ids = $_POST['check_ids'];
        $box = $_POST['box'];
        foreach ($check_ids as $id) {
            $email_id = $id['value'];
            $update = array(
                'box' => $box
            );
            $this->db->where('email_id', $email_id);
            $this->db->update('email', $update);
        }
    }

    function emaildelete() {
        $check_ids = $_POST['check_ids'];
        $box = $_POST['box'];
        foreach ($check_ids as $id) {
            $email_id = $id['value'];
            $update = array(
                'box' => $box
            );
            $this->db->where('email_id', $email_id);
            $this->db->delete('email');
        }
    }

    public function emailsend() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('reciver', 'Email', 'required');
        if ($this->form_validation->run() == FALSE) {
            //fail
            echo 'fail';
        } else {

            if (isset($_GET['dealer'])) {
                $dealer = $_GET['dealer'];
                $query = $this->db->query("select * from email_account where dealer_id = $dealer");
                $result = $query->result();
                $cc = $_POST['cc'];
                $bcc = $_POST['bcc'];

                if (isset($result[0])) {
                    $dealer_imoby_email = $result[0]->dealer_imoby_email;
                    $this->load->library('email');
                    $this->email->from($dealer_imoby_email, '');
                    $this->email->to($_POST['reciver']);
                    $this->email->cc($cc);
                    $this->email->bcc($bcc);
                    $this->email->subject($_POST['subject']);
                    $this->email->message($_POST['message']);
                    $this->email->attach('C:\mobileScreen.jpg');
                    $this->email->send();
                    echo 'success';
                    $sendmail = array(
                        'subject' => $_POST['subject'],
                        'to' => $_POST['reciver'],
                        'from' => $dealer_imoby_email,
                        'body' => $_POST['message'],
                        'dealer_id' => $_GET['dealer'],
                        'box' => 'sebox'
                    );
                    $this->db->insert('email', $sendmail);
                } else {
                    echo 'fail';
                }
            }
        }
    }

}
