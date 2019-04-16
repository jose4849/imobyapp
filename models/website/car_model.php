<?php

class Car_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getCarDetails($dealer_id) {
        $this->db->select('*');
        //  $this->db->select('GROUP_CONCAT(DISTINCT(remoteFile) SEPARATOR ",") as remoteFile',false);    
        //$this->db->select('GROUP_CONCAT(DISTINCT(localFile) SEPARATOR ",") as localFile',false);
        $this->db->distinct();
        $this->db->from('cars');
        $this->db->join('car_ads', 'car_ads.car = cars.id');
        $this->db->join('car_info','car_info.car = cars.id');
        $this->db->join('cars_licenseinfo', 'cars_licenseinfo.car = cars.id');
        $this->db->join('car_media', 'car_media.car = cars.id');
        $this->db->join('cars2specsdefault', 'cars2specsdefault.car = cars.id');
        $this->db->join('cars2specsfabric', 'cars2specsfabric.car = cars.id');
        $this->db->join('car_specsdefault', 'car_specsdefault.id = cars2specsdefault.specDefault');
        $this->db->join('car_specsfabric', 'car_specsfabric.id = cars2specsfabric.specFabric');
        $this->db->where('cars.dealer', $dealer_id);
        $this->db->where('car_ads.active', 1);
        $this->db->group_by('cars.id');
        $query = $this->db->get();
        return $query->result();
    }

}
