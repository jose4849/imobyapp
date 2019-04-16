<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Instellingen extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in() && !$this->ion_auth->in_group('dealer'))
            redirect('login', 'refresh');
    }

    public function profiel() {

        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTabHeader'] = "setting";
        $data['activeTab'] = "profile";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_id']=$data['dealer'][0]->dealer_id;
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $this->load->view('backoffice/settings/profile', $data);
    }

    public function saveProfile() {
        $this->load->model('backoffice_model');

        $user = $this->ion_auth->user()->row();
        $id = $user->id;
        $dealer_id = $this->backoffice_model->getDealerId($id);
        $address_id = $this->backoffice_model->getAddressId($dealer_id[0]->dealer_id);

        $this->load->library('form_validation');
        //validate form input
        $this->form_validation->set_rules('Bedrijfsnaam', 'Bedrijfsnaam', 'required|xss_clean');
        $this->form_validation->set_rules('Postcode', 'Postcode', 'required|xss_clean');
        $this->form_validation->set_rules('KvKnr', 'KvKnr', 'required|xss_clean');
        $this->form_validation->set_rules('BTWnr', 'BTWnr', 'required|xss_clean');
        $this->form_validation->set_rules('Telefoonnummer', 'Telefoonnummer', 'required|xss_clean');
        $this->form_validation->set_rules('Telefoonnummer2', 'Telefoonnummer2', 'required|xss_clean');
        $this->form_validation->set_rules('Faxnummer', 'Faxnummer', 'required|xss_clean');
        $this->form_validation->set_rules('Voornaam', 'Voornaam', 'required|xss_clean');
        $this->form_validation->set_rules('Tussenvoegsel', 'Tussenvoegsel', 'required|xss_clean');
        $this->form_validation->set_rules('Achternaam', 'Achternaam', 'required|xss_clean');
        $this->form_validation->set_rules('userEmail', 'userEmail', 'required|valid_email|edit_unique[users.email.' . $id . ']');
        $this->form_validation->set_rules('Website', 'Website', 'required|xss_clean');
        // set error message
        $this->form_validation->set_message('is_unique', 'Email Address has already been taken.');

        if ($this->form_validation->run() == true) {
            
            try {
  
                $data = array(
                    'firstName' => $this->input->post('Voornaam'),
                    'middleName' => $this->input->post('Tussenvoegsel'),
                    'lastName' => $this->input->post('Achternaam'),
                    'phoneNumber1' => $this->input->post('Telefoonnummer2'),
                    'email' => $this->input->post('useremail'),
                );
                if ($this->ion_auth->update($id, $data)) {
                    // dealer table update
                    
                    /* password update start */
                        $old_password = $this->input->post('old_password');
                        $new_password = $this->input->post('new_password');
                        if(($old_password!=null)&&($new_password!=null)){                       
                            $password_matches = $this->ion_auth->hash_password_db($id,$old_password);
                            if ($password_matches) {
                                $pass_update=array(
                                    'password' => $new_password
                                );
                               if($this->ion_auth->update($id, $pass_update)){
                                   echo 'Successfully changed.';
                               };
                            }
                            else{
                                echo 'Password not match';
                            }
                        }
                    
                    
                    /* password update end */
                    
                    $dealer = array(
                        'name' => $this->input->post('Bedrijfsnaam'),
                        'phoneNumber1' => $this->input->post('Telefoonnummer'),
                        'website' => $this->input->post('Website'),
                        'email' => $this->input->post('comEmail'),
                        'chamberOfCommerce' => $this->input->post('KvKnr'),
                        'Taxcode' => $this->input->post('BTWnr'),
                        'faxNumber' => $this->input->post('Faxnummer'),
                    );
                    $this->db->where('id', $id);
                    $this->db->update('dealers', $dealer);

                    // address table update
                    $address = array(
                        'type' => 'post',
                        'street' => $this->input->post('Adres'),
                        'house_num' => $this->input->post('house_num'),
                        'house_num_addition' => $this->input->post('house_num_addition'),
                        'postal_code' => $this->input->post('Postcode'),
                    );
                    $this->db->where('id', $address_id[0]->address_id);
                    $this->db->update('addresses', $address);
                    echo 'Successfully saved. Thank you.';
                }
                
            } catch (Exception $e) {
                echo $e;
            }
        } else {
            $data = array(
                'Bedrijfsnaam' => form_error('Bedrijfsnaam'),
                'Postcode' => form_error('Postcode'),
                'KvKnr' => form_error('KvKnr'),
                'BTWnr' => form_error('BTWnr'),
                'Telefoonnummer' => form_error('Telefoonnummer'),
                'Telefoonnummer2' => form_error('Telefoonnummer2'),
                'Faxnummer' => form_error('Faxnummer'),
                'Voornaam' => form_error('Voornaam'),
                'Tussenvoegsel' => form_error('Tussenvoegsel'),
                'Achternaam' => form_error('Achternaam'),
                //'password' => form_error('password'),
                //'confirmpassword' => form_error('confirmpassword'),
                
                'userEmail' => form_error('userEmail'),
                'Website' => form_error('Website'),
            );
            echo json_encode($data);
        }
    }

    public function userdashboard() {
        $data['pagetitle'] = "Gebruikers";
        $data['activeTabHeader'] = "setting";
        $this->load->view('backoffice/settings/userdashboard', $data);
    }

    public function huisstijl() {
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTabHeader'] = "setting";
        $data['activeTab'] = "identity";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $dealer_id=$data['dealer'][0]->dealer_id;
        $resultSet=$this->db->query("select * from dealersettings where dealer = $dealer_id and attribute = 'colorschrme'");
        $result=$resultSet->result();
        if(isset($result[0])){
            $data['colorschme']=$result[0]->value;
        }
        else{
            $data['colorschme']='';
        }
        

        $this->load->view('backoffice/settings/identity', $data);
    }

    function colorschrme(){
        $dealer_id = $this->input->post('dealer_id');
        $colorschrme = $this->input->post('colorschrme');
        $resultSet=$this->db->query("select * from dealersettings where dealer = $dealer_id and attribute = 'colorschrme'");
        $result=$resultSet->result();
        
        if(isset($result[0])){
            $data=array(
            
            'value'=>$colorschrme
            );
            $this->db->where('dealer',$dealer_id);
            $this->db->where('attribute','colorschrme');
            $this->db->update('dealersettings',$data);
            echo 'Update successfully.';
        }else{
           $data=array(
           'attribute'=>'colorschrme',
            'value'=>$colorschrme,
           'dealer'=>$dealer_id
           );
           $this->db->insert('dealersettings',$data); 
           echo 'Color set successfully. Thank you.';
        }
    }    
    
    
    public function socialmedia() {
        $this->load->model('backoffice_model');
        $data['user'] = $this->ion_auth->user()->row();
        $data['pagetitle'] = "Gebruikers";
        $data['activeTabHeader'] = "setting";
        $data['activeTab'] = "socialmedia";
        $data['dealer'] = $this->backoffice_model->getProfile($data['user']->id);
        $data['dealer_functions'] = $this->backoffice_model->getDealerFunctions($data['dealer'][0]->dealer_id);
        $data['social_media'] = $this->backoffice_model->getSocialMedia($data['dealer'][0]->dealer_id);
        /*
          echo "<pre>";
          print_r($data);
          echo "</pre>";
         */
        $this->load->view('backoffice/settings/socialmedia', $data);
    }

    public function changeSocialMediaStatus() {
        $this->load->model('backoffice_model');
        if ($this->input->post('status') == 'true') {
            $status = 0;
        } else {
            $status = 1;
        }
        $data = $this->backoffice_model->changeSocialMediaStatus($this->input->post('id'), $status);
        echo $data;
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
            $newFileName = "logo" . '_' . $user_id . '.png';
            $targetPath = getcwd() . "/media/dealers/$user_id/";
            $targetFile = $targetPath . $fileName;
            $NewtargetFile = $targetPath . $newFileName;
            move_uploaded_file($tempFile, $targetFile);
            if ($path_parts['extension'] != 'png') {
                imagepng(imagecreatefromstring(file_get_contents($targetFile)), $NewtargetFile);
            }
            echo $_GET['userid'];
        }
    }

    public function delete_profile_image() {
        $user_id = $_POST['user_id'];
        $fileName = "logo" . '_' . $user_id . '.' . "png";
        $targetPath = getcwd() . "/media/dealers/$user_id/$fileName";
        unlink($targetPath);
        echo "Your Profile Image is successfully Deleted";
    }

    public function socialmediaemail() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('emailaddress', 'emailaddress', 'required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            echo "Check your information there is an error.";
        } else {
            $from = $_POST['emailaddress'];
            $to = 'info@imoby.nl';
            $to = 'jose707733@gmail.com';
            $subject = 'Aanmaken social media kanalen: ' . $_POST['company_name'] . ' (' . $_POST['dealer_id'] . ') ';
            $msg = '';
            $msg.='<table>
            <tr>
            <td colspan="2">Onderstaande Imoby klant is mogelijkerwijs geïnteresseerd in het aanmaken van social media accounts. Neem a.u.b. z.s.m. contact op.<br><br></td>               
            </tr>
            <tr>
            <td>Naam:</td>
            <td>' . $_POST['gender'] . ' ' . $_POST['achternaam'] . ' ' . $_POST['mevrouw'] . ' ' . $_POST['tussenvoegsel'] . '</td>
            </tr>   
            <tr>
            <td>Telefoonnummer: </td>
            <td>' . $_POST['telefoonnummer'] . '</td>
            </tr>   
            <tr>
            <td>Emailadres: </td>
            <td>' . $_POST['emailaddress'] . '</td>
            </tr>   
            </table>';

            $this->load->library('email');
            $email_setting = array('mailtype' => 'html');
            $this->email->initialize($email_setting);
            $this->email->from($from, '');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($msg);
            $this->email->send();
            echo 'Information is send successfully.Thank you.';
        }
    }

    function newemailsearch() {

        $email_id = $this->input->post('email_id');
        $email_address = $email_id . "@imoby.com";

        $this->db->select('*');
        $this->db->where('dealer_imoby_email', $email_address);
        $query = $this->db->get('email_account');
        $result = $query->result();
        if (count($result) > 0) {
            echo "Someone already has that username. Try another?";
        } else {
            // echo '<pre>';
            // print_r($query);
        }
    }



    
    
    
}
