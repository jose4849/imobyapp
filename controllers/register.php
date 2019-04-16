<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
	
        parent::__construct();		
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
    }

    public function login() {
		
        $this->data['title'] = "Login";
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == true) {

//            $remember = (bool) $this->input->post('remember');
            $remember = TRUE;
            if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember)) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());


                if ($this->ion_auth->in_group('superadmin'))
					
                    redirect('admin', 'refresh');
                else if ($this->ion_auth->in_group('admin')){				
                    redirect('admin', 'refresh');
					}
                else if ($this->ion_auth->in_group('dealer'))
                    redirect('backoffice', 'refresh');
                else if ($this->ion_auth->in_group('member'))
                    redirect('member', 'refresh');
                else
                    redirect('/', 'refresh');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
				
                redirect('login', 'refresh');
            }
        } else {
					
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['username'] = array(
                'name' => 'username',
                'id' => 'user',
                'type' => 'text',
                'value' => $this->form_validation->set_value('username'),
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'pass',
                'type' => 'password',
            );
            $this->data['submit'] = array(
                'name' => 'sign-in',
                'id' => 'login',
                'class' => 'btn_120',
                'type' => 'submit'
            );

            $this->_render_page('common/login', $this->data);
        }
    }

    public function forgot() {

        $this->data['title'] = "Forgot";
        $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        if ($this->form_validation->run() == false) {
            
            
            //setup the input
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'user',
                'type' => 'email',
                'value' => $this->form_validation->set_value('username'),
            );
            $this->data['submit'] = array(
                'name' => 'forgot',
                'id' => 'login',
                'class' => 'btn_120',
                'type' => 'submit'
            );

            if ($this->config->item('identity', 'ion_auth') == 'username') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            //set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('common/forgot', $this->data);
        
            
        } else {
            
             
            if ($this->config->item('identity', 'ion_auth') == 'username') {
                $identity = $this->ion_auth->where('username', strtolower($this->input->post('email')))->users()->row();
            } else {
                $identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
            }
            if (empty($identity)) {
                $this->ion_auth->set_message('forgot_password_email_not_found');
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("wachtwoordvergeten", 'refresh');
            }

            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
            if ($forgotten) {
                //if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("wachtwoordvergeten", 'refresh');
            }
            
            
        }
    }

    function logout() {
        $this->data['title'] = "Logout";

        //log the user out
        $logout = $this->ion_auth->logout();

        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('login', 'refresh');
    }

    public function dealerLogin() {
        $this->form_validation->set_rules('email', 'E-Mail', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        $this->form_validation->set_message('required', 'This field is required.');
        if ($this->form_validation->run() == true) {
            $remember = TRUE;
            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember)) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());

                if ($this->ion_auth->in_group('dealer'))
                    redirect('backoffice', 'refresh');
                else
                    redirect('', 'refresh');
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('', 'refresh');
            }
        } else {
            if(validation_errors()){
                $this->data['email'] = form_error('email');
                $this->data['password'] = form_error('password');
            }else{
                $this->data['message'] = $this->session->flashdata('message');
            }

            $this->_render_page('', $this->data);
        }
    }

    function _render_page($view, $data = null, $render = false) {

        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $render);

        if (!$render)
            return $view_html;
    }

}
