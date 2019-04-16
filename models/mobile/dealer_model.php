<?php

class Dealer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function chkDealer($dealer_id) {
        $this->db->where('id', $dealer_id);
        $query = $this->db->get('dealers');

        if (count($query->result()) == 1) {
            return TRUE;
        } else {

            return FALSE;
        }
    }
    public function social_media($dealer_id){
        $this->db->where('dealer', $dealer_id);
        $this->db->where('added_status',1);
        $query = $this->db->get('social_media');
        return $query->result();
    }
    public function chkAnnbod($aanbod){
        $this->db->where('aanbod',$aanbod);
        $query = $this->db->get('dealers');
        if (count($query->result()) == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
