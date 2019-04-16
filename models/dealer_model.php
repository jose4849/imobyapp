<?php

/**
 * Description of dealer Model
 *
 * @author Cre8it
 */
class Dealer_model extends CI_Model {

    private $tableDealers;

    public function __construct() {
        parent::__construct();
    }

    public function getDealers() {
        $this->db->select('*, GROUP_CONCAT(`dealers2dealerfunctions`.`dealerfunction`) AS dealerFunctions');
        $this->db->from('users');
        $this->db->join('users2dealers', 'users2dealers.user=users.id');
        $this->db->join('dealers', 'dealers.id=users2dealers.dealer');
        $this->db->join('dealers2dealerfunctions', 'dealers.id=dealers2dealerfunctions.dealer', 'left outer');

        $this->db->join('dealers2addresses', 'dealers2addresses.dealer=dealers.id');
        $this->db->join('addresses', 'addresses.id=dealers2addresses.address');
        $this->db->group_by('users.id');

        $query = $this->db->get();
        return $query->result();
    }

    public function singleDealer($id) {
        $this->db->select('users.*, users.id AS users_id, dealers.*, dealers.id AS dealer_id, addresses.*, addresses.id AS addresses_id, users.phoneNumber1 AS user_phoneNumber1, users.phoneNumber2 AS user_phoneNumber2, dealers.phoneNumber1 AS dealer_phoneNumber1, dealers.phoneNumber2 AS dealer_phoneNumber2, dealers.email AS dealer_email, , users.email AS user_email');
        $this->db->from('users');
        $this->db->join('users2dealers', 'users2dealers.user=users.id');
        $this->db->join('dealers', 'dealers.id=users2dealers.dealer');
        $this->db->join('dealers2addresses', 'dealers2addresses.dealer=dealers.id');
        $this->db->join('addresses', 'addresses.id=dealers2addresses.address');
        $this->db->where('users.id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function dealer_note($id,$perpage,$start){
        $this->db->select('*');
        $this->db->from('notes');
        $this->db->join('users', 'notes.admin_id=users.id');
        $this->db->order_by("note_date", "desc"); 
        $this->db->limit($perpage,$start);
        $query=$this->db->get();
        return $query->result();
    }
    public function singleDealerFunction($dealer_id) {
        $this->db->select('*, GROUP_CONCAT(dealers2dealerfunctions.`dealerfunction`) AS functions');
        $this->db->from('dealers2dealerfunctions');
        $this->db->where('dealers2dealerfunctions.dealer',$dealer_id);
        $this->db->group_by('dealers2dealerfunctions.dealer');

        $query = $this->db->get();
        return $query->result();
    }

    public function getDealerWithLimit($x, $y) {

        // $this->db->select('*');
        // $this->db->from('users');
        // $this->db->join('users2dealers', 'users2dealers.user=users.id');
        // $this->db->join('dealers', 'dealers.id=users2dealers.dealer');
        // $this->db->join('dealers2addresses', 'dealers2addresses.dealer=dealers.id');
        // $this->db->join('addresses', 'addresses.id=dealers2addresses.address');
        $this->db->select('*, GROUP_CONCAT(`dealers2dealerfunctions`.`dealerfunction`) AS dealerFunctions');
        $this->db->from('users');
        $this->db->join('users2dealers', 'users2dealers.user=users.id');
        $this->db->join('dealers', 'dealers.id=users2dealers.dealer');

        $this->db->join('dealers2dealerfunctions', 'dealers.id=dealers2dealerfunctions.dealer', 'left outer');

        $this->db->join('dealers2addresses', 'dealers2addresses.dealer=dealers.id');
        $this->db->join('addresses', 'addresses.id=dealers2addresses.address');
        $this->db->group_by('users.id');

        $this->db->limit($x, $y);
        $query = $this->db->get();
        return $query->result();
    }

    public function searchDealers() {
        $id = $this->input->post('userid');
        $dealerName = $this->input->post('dealerName');
        $dealerAddress = $this->input->post('dealerAddress');
        $dealerName = (empty($dealerName) ? '' : $dealerName . '%');
        $dealerAddress = (empty($dealerAddress) ? '' : $dealerAddress . '%');

        $this->db->select('*, GROUP_CONCAT(`dealers2dealerfunctions`.`dealerfunction`) AS dealerFunctions');
        $this->db->from('users');
        $this->db->join('users2dealers', 'users2dealers.user=users.id');
        $this->db->join('dealers', 'dealers.id=users2dealers.dealer');

        $this->db->join('dealers2dealerfunctions', 'dealers.id=dealers2dealerfunctions.dealer', 'left outer');

        $this->db->join('dealers2addresses', 'dealers2addresses.dealer=dealers.id');
        $this->db->join('addresses', 'addresses.id=dealers2addresses.address');
        $this->db->where('users.id', $this->input->post('userid'));
        $this->db->or_where("`street` LIKE '$dealerAddress'");
        $this->db->or_where("`house_num` LIKE '$dealerAddress'");
        $mob=$this->input->post('mob');
        $crm=$this->input->post('crm');
      
        if(($mob ==1) && ($crm==1)){
            $this->db->where("dealers2dealerfunctions.dealerfunction = ", 1);
            $this->db->where("dealers2dealerfunctions.dealerfunction = ", 2);
        }
        else{
         if($mob)
             $this->db->or_where("dealers2dealerfunctions.dealerfunction = ", 1);
         if( $crm)
             $this->db->or_where("dealers2dealerfunctions.dealerfunction = ", 2);
        }
        $this->db->or_where("`name` LIKE '$dealerName'");
        $this->db->group_by('users.id');

        $query = $this->db->get();
        $reuslts=$query->result();
       // echo '<pre>';
      //  print_r($reuslts);
       // die();
        return $query->result();
    }

    public function searchimobycode() {
        $id = $this->input->post('userid');
        $dealerName = $this->input->post('dealerName');
        $dealerAddress = $this->input->post('dealerAddress');
        $dealerName = (empty($dealerName) ? '' : $dealerName . '%');
        $dealerAddress = (empty($dealerAddress) ? '' : $dealerAddress . '%');

        $this->db->select('*, GROUP_CONCAT(`dealers2dealerfunctions`.`dealerfunction`) AS dealerFunctions');
        $this->db->from('users');
        $this->db->join('users2dealers', 'users2dealers.user=users.id');
        $this->db->join('dealers', 'dealers.id=users2dealers.dealer');

        $this->db->join('dealers2dealerfunctions', 'dealers.id=dealers2dealerfunctions.dealer', 'left outer');

        $this->db->join('dealers2addresses', 'dealers2addresses.dealer=dealers.id');
        $this->db->join('addresses', 'addresses.id=dealers2addresses.address');
        $this->db->where('dealers.homePageId', $this->input->post('userid'));
        $this->db->or_where("`street` LIKE '$dealerAddress'");
        $this->db->or_where("`house_num` LIKE '$dealerAddress'");
        $mob=$this->input->post('mob');
        $crm=$this->input->post('crm');
      
        if(($mob ==1) && ($crm==1)){
            $this->db->where("dealers2dealerfunctions.dealerfunction = ", 1);
            $this->db->where("dealers2dealerfunctions.dealerfunction = ", 2);
        }
        else{
         if($mob)
             $this->db->or_where("dealers2dealerfunctions.dealerfunction = ", 1);
         if( $crm)
             $this->db->or_where("dealers2dealerfunctions.dealerfunction = ", 2);
        }
        $this->db->or_where("`name` LIKE '$dealerName'");
        $this->db->group_by('users.id');

        $query = $this->db->get();
        $reuslts=$query->result();
       // echo '<pre>';
      //  print_r($reuslts);
       // die();
        return $query->result();
    }    
    
    
    
}
