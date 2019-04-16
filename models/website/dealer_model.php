<?php

class Dealer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function chkDealer($dealer_id) {
        $this->db->where('id', $dealer_id);
        $query = $this->db->get('dealers');

        if (count($query->result()) > 0) {
            return TRUE;
        } else {

            return FALSE;
        }
    }

}
