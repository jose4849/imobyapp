<?php

/**
 * Description of dealer Model
 *
 * @author Cre8it
 */
class Administrator_model extends CI_Model {

    private $tableDealers;

    public function __construct() {
        parent::__construct();
    }

    public function getAdministrators($superadmin) {

        $this->db->select('users.*, users.id AS new_id');
        $this->db->from('users');
        $this->db->join('users2groups', 'users2groups.user=users.id');
        $this->db->join('groups', 'groups.id=users2groups.group');
        if($superadmin)
            $this->db->where("(groups.name =  'superadmin' OR groups.name =  'admin')");
        else
            $this->db->where("groups.name =  'admin'");
        $this->db->group_by('users.id');
        $query = $this->db->get();
        return $query->result();

    }

    public function getAdministratorsWithLimit($x, $y,$superadmin) {
        if($y){}else { $y=0;}
        $result=$this->db->query("
        select * , users.id AS new_id from users
        join users2groups on users2groups.user=users.id 
        join groups on groups.id= users2groups.group
        where users2groups.group = '1' OR users2groups.group =  '2' OR users2groups.group = '4'
        GROUP BY users.id
        limit $y,$x
        ");
        $results =$result->result();
//        echo '<pre>';
//        print_r($results);
//        die();
        
        return $results;
        
    }

    public function searchAdministrators($superadmin) {
        $Naam = $this->input->post('Naam');
        $organization = $this->input->post('organization');
        $Telefoonnummer = $this->input->post('Telefoonnummer');
        $email = $this->input->post('email');
        $Naam = (empty($Naam) ? '' : $Naam . '%');
        $Organisatie = (empty($Organisatie) ? '' : $Organisatie . '%');
        $Telefoonnummer = (empty($Telefoonnummer) ? '' : $Telefoonnummer . '%');
        $email = (empty($email) ? '' : $email . '%');

        $this->db->select('users.*, users.id AS new_id');
        $this->db->from('users');
        $this->db->join('users2groups', 'users2groups.user=users.id');
        $this->db->join('groups', 'groups.id=users2groups.group');
        
        if($superadmin)
            $this->db->where("(groups.name =  'superadmin' OR groups.name =  'admin' OR groups.name =  'user')");
        else
            
        $this->db->where("groups.name =  'superadmin' OR groups.name =  'admin' OR groups.name =  'user'");
        $userid=$this->input->post('userid');  
        $this->db->where('(users.id',$userid );
        $this->db->or_where("`firstName` LIKE '$Naam'");
        $this->db->or_where("`organization` LIKE '$organization'");
        $this->db->or_where("`phoneNumber1` LIKE '$Telefoonnummer'");
        $this->db->or_where("`email` LIKE '$email')");      
        $this->db->group_by('users.id');
        $query = $this->db->get();
        return $query->result();
    }

}
