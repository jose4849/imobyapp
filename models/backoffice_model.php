<?php

/**
 * Description of dealer Model
 *
 * @author Cre8it
 */
class Backoffice_model extends CI_Model {

    private $tableDealers;

    public function __construct() {
        parent::__construct();
    }

    public function getProfile($user_id) {

        $this->db->select('users.*, dealers.*, dealers.id AS dealer_id, addresses.*, users.phoneNumber1 AS user_phoneNumber1, users.phoneNumber2 AS user_phoneNumber2, dealers.phoneNumber1 AS dealer_phoneNumber1, dealers.phoneNumber2 AS dealer_phoneNumber2, dealers.email AS dealer_email, , users.email AS user_email');
        $this->db->from('users');
        $this->db->join('users2dealers', 'users2dealers.user=users.id');
        $this->db->join('dealers', 'dealers.id=users2dealers.dealer');
        $this->db->join('dealers2addresses', 'dealers2addresses.dealer=dealers.id');
        $this->db->join('addresses', 'addresses.id=dealers2addresses.address');
        $this->db->where('users.id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDealerId($user_id) {

        $this->db->select('users2dealers.dealer AS dealer_id');
        $this->db->from('users2dealers');
        $this->db->where('users2dealers.user', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAddressId($dealer_id) {

        $this->db->select('dealers2addresses.address AS address_id');
        $this->db->from('dealers2addresses');
        $this->db->where('dealers2addresses.dealer', $dealer_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDealerFunctions($dealer_id) {

        $this->db->select('*, group_concat(`dealerfunction`) as `functions`');
        $this->db->select('group_concat(`serviceStatus`) as `service`');
        $this->db->from('dealers2dealerfunctions');
        $this->db->where('dealers2dealerfunctions.dealer', $dealer_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSocialMedia($dealerId) {
        $query = $this->db->get_where('social_media', array('dealer' => $dealerId));
        return $query->result();
    }

    public function addSocialMedia() {
        $data = array(
            'dealer' => $this->input->post('dealarId'),
            'social_userid' => $this->input->post('userId'),
            'screen_name' => $this->input->post('dealarName'),
            'social_post' => $this->input->post('social_post'),
            'added_status' => 1,
            'updated_status' => 0,
            'social_type' => $this->input->post('socialType')
        );
        return $this->db->insert('social_media', $data);
    }

    public function changeSocialMediaStatus($id, $status) {
        $data = array(
            'updated_status' => $status
        );
        $this->db->where('id', $id);
        return $this->db->update('social_media', $data);
    }

    public function getCarDetails($user_id, $dealer_id){

            $this->db->select('*');
           // $this->db->select('GROUP_CONCAT(DISTINCT(remoteFile) SEPARATOR ",") as remoteFile',false);    
           // $this->db->select('GROUP_CONCAT(DISTINCT(localFile) SEPARATOR ",") as localFile',false);
            $this->db->distinct();
            $this->db->from('cars');
            $this->db->join('car_ads', 'car_ads.car = cars.id');
            $this->db->join('cars_licenseinfo', 'cars_licenseinfo.car = cars.id');
            $this->db->join('cars2specsdefault', 'cars2specsdefault.car = cars.id');
            $this->db->join('cars2specsfabric', 'cars2specsfabric.car = cars.id');
            $this->db->join('car_specsdefault', 'car_specsdefault.id = cars2specsdefault.specDefault');
            $this->db->join('car_specsfabric', 'car_specsfabric.id = cars2specsfabric.specFabric');
            $this->db->where('cars.dealer', $dealer_id);
            //$this->db->where('car_ads.active', 1);
            $this->db->group_by('cars.id');
            $query = $this->db->get();
            $car_info=$query->result();        
            $numberofcar=count($car_info)-1;
            for($i=0;$i<=$numberofcar;$i++){                
             if(isset($car_info[$i])){  
                 
                         $car_id=$car_info[$i]->car;                       
                         $carmedias=$this->db->query("select * from car_media where car = $car_id");
                         $carmedia= $carmedias->result();                
                         $media=array();
                         foreach($carmedia as $files){
                            $media[]= $files->remoteFile;
                         }
                         
                         $car_info[$i]->remoteFile=implode(',',$media);
                         $car_infoo=$this->db->query("select attribute,valueText from car_info where car = $car_id");
                         $car_info_result=$car_infoo->result(); 
                        // print_r($car_info_result);
                         if(isset($car_info_result)){
                            foreach($car_info_result as $car_result){
                               $attribute=$car_result->attribute;
                               $valueText=$car_result->valueText;
                               $car_info[$i]->$attribute = $valueText;
                          }
                          }
                          /* car specFabric start */                       
                           $cars2specsdefaults=$this->db->query("
                                   select  * from `cars2specsdefault` 
                                   join car_specsfabric on `cars2specsdefault`. specDefault  = car_specsfabric.id
                                   where car = $car_id");
                           $specsdefaults='';
                           $cars2specsdefault=$cars2specsdefaults->result();
                           foreach($cars2specsdefault as $specsdefault){
                                   $specsdefaults=$specsdefaults.", ".$specsdefault->translation;
                           } 
                           $car_info[0]->specsdefault = $specsdefaults;    
                           
                          /* car specFabric end */ 
                 }                
             }     
        return $car_info;    
    }

    public function changeCarStatus() {
        $data = array(
            'active' => $this->input->post('active')
        );
        $this->db->where('car', $this->input->post('car'));
        return $this->db->update('car_ads', $data);
             
    }

}
