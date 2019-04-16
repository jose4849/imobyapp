<?php

class Informatie_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    /* use for getting user  information */
    public function getUserInformatie($user_id) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $query = $this->db->get();        
        return $query->result();
    }
    /* use for getting dealer information */  
    public function getInformatie($dealer_id) {
        $this->db->select('*');
        $this->db->from('dealers');
        $this->db->join('dealers2addresses', 'dealers2addresses.dealer = dealers.id');
        $this->db->join('addresses', 'addresses.id = dealers2addresses.address');
        $this->db->where('dealers.id', $dealer_id);
        $query = $this->db->get();        
        return $query->result();
    }
    public function checkStockPage($klantnummer){
        $this->db->select('*');
        $this->db->from('dealers');
        $this->db->where('klantnummer', $klantnummer);
        $query = $this->db->get();        
        return $query->result();
    }
    public function checkService($dealer_id){
        $this->db->select('*');
        $this->db->from('dealers2dealerfunctions');
        $this->db->where('dealer', $dealer_id);
        $query = $this->db->get();        
        return $query->result();
    }
    public function aanbodBydealer($dealer){
        $query=$this->db->query("select * from dealers where id = $dealer");
        $result=$query->result();
        return $aanbod=$result[0]->aanbod;
    }
    public function dealerByaanbod($aanbod){
        $query=$this->db->query("select * from dealers where aanbod = $aanbod");
        $result=$query->result();
        return $result;
    }
    public function userInfoBydealer($dealer){
         $this->db->select('*');
         $this->db->from('users2dealers'); 
         $this->db->join('users', 'users.id = users2dealers.user');
         $this->db->where('users2dealers.dealer', $dealer);
         $query = $this->db->get();        
         return $query->result(); 
    }

}
