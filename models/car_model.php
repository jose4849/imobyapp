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

    public function countCarDetailsAnnbod($dealer_id) {
        $this->db->select('*');
        // $this->db->select('GROUP_CONCAT(DISTINCT(remoteFile) SEPARATOR ",") as remoteFile',false);    
        //$this->db->select('GROUP_CONCAT(DISTINCT(localFile) SEPARATOR ",") as localFile',false);
        $this->db->distinct();
        $this->db->from('cars');
        $this->db->join('car_ads', 'car_ads.car = cars.id');
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
        $result = $query->result();
        return count($result);
        //echo  count($result);
        //die();
    }

    public function getCarDetailsAnnbod($dealer_id, $x, $y) {
        if ($y == null) {
            $y = 0;
        }
        $this->db->select('*');
        // $this->db->select('GROUP_CONCAT(DISTINCT(remoteFile) SEPARATOR ",") as remoteFile',false);    
        //$this->db->select('GROUP_CONCAT(DISTINCT(localFile) SEPARATOR ",") as localFile',false);
        $this->db->distinct();
        $this->db->from('cars');
        $this->db->join('car_ads', 'car_ads.car = cars.id');
        $this->db->join('cars_licenseinfo', 'cars_licenseinfo.car = cars.id');
        $this->db->join('car_media', 'car_media.car = cars.id');
        $this->db->join('cars2specsdefault', 'cars2specsdefault.car = cars.id');
        $this->db->join('cars2specsfabric', 'cars2specsfabric.car = cars.id');
        $this->db->join('car_specsdefault', 'car_specsdefault.id = cars2specsdefault.specDefault');
        $this->db->join('car_specsfabric', 'car_specsfabric.id = cars2specsfabric.specFabric');
        //$this->db->join('car_info', 'car_info.car = cars.id');
        $this->db->where('cars.dealer', $dealer_id);
        $this->db->where('car_ads.active', 1);
        $this->db->group_by('cars.id');
        if($x==0){}
        else{
        $this->db->limit($x, $y);
        }
        $query = $this->db->get();
        $result=$query->result();
      
      
        
        
        if(isset($result[0])){
        $car_id=$result[0]->car;
        $car_info=$this->db->query("select attribute,valueText from car_info where car = $car_id");
        $car_info_result=$car_info->result(); 
        //print_r($car_info_result);
        if(isset($car_info_result)){
            foreach($car_info_result as $car_result){
               $attribute=$car_result->attribute;
               $valueText=$car_result->valueText;
               $result[0]->$attribute=$valueText;
            }
        }

        }
     //   print_r($result);
      //  die();
         return $result;
    }

    public function search_object($data) {
        //  print_r($data);

        $query = $this->db->query("select * from dealers");
        $result = $query->result();
        $dealer_id = $result[0]->id;
        $this->db->select('*');
        // $this->db->select('GROUP_CONCAT(DISTINCT(remoteFile) SEPARATOR ",") as remoteFile',false);    
        //$this->db->select('GROUP_CONCAT(DISTINCT(localFile) SEPARATOR ",") as localFile',false);
        $this->db->distinct();        
        $this->db->from('cars');
        $this->db->join('car_ads', 'car_ads.car = cars.id');
        $this->db->join('cars_licenseinfo', 'cars_licenseinfo.car = cars.id');
        $this->db->join('car_media', 'car_media.car = cars.id');
        $this->db->join('cars2specsdefault', 'cars2specsdefault.car = cars.id');
        $this->db->join('cars2specsfabric', 'cars2specsfabric.car = cars.id');
        $this->db->join('car_specsdefault', 'car_specsdefault.id = cars2specsdefault.specDefault');
        $this->db->join('car_specsfabric', 'car_specsfabric.id = cars2specsfabric.specFabric');
        $this->db->join('car_info', 'car_info.car = cars.id');
        //$this->db->where('cars.dealer', $dealer_id);
        $this->db->where('car_ads.active', 1);
        $this->db->group_by('cars.id');

        
        if ($data['searchtext'] != '') {
            $this->db->like('cars_licenseinfo.brand', $data['searchtext']);
            $this->db->or_like('car_info.brandstof', $data['searchtext']);
            $this->db->or_like('car_info.type', $data['searchtext']);
            $this->db->or_like('car_info.versnelling', $data['searchtext']);
        }
        else{
        if ($data['brand'] != '') {
            $this->db->where('cars_licenseinfo.brand', $data['brand']);
        }
        if (($data['prijsvan'] != '') && ($data['prijstot'] != '')) {
            $this->db->where('car_info.showroomprijs >=', $data['prijsvan']);
            $this->db->where('car_info.showroomprijs <=', $data['prijstot']);
        } 
        if (($data['bouwjaarVan'] != '') && ($data['bouwjaarTot'] != '')) {
            $this->db->where('cars_licenseinfo.buildYear >=', $data['bouwjaarVan']);
            $this->db->where('cars_licenseinfo.buildYear <=', $data['bouwjaarTot']);
        }
        if ($data['type'] != '') {
            $this->db->where('car_info.type', $data['type']);
        } 
        if ($data['zitplaatsen'] != '') {
            if($data['zitplaatsen']>10){
                 $this->db->where('car_info.zitplaatsen >=', $data['zitplaatsen']);
            }
            else{
            $this->db->where('car_info.zitplaatsen', $data['zitplaatsen']);
            }
        } 
        if ($data['deuren'] != '') {
            if($data['deuren']>10){
                 $this->db->where('car_info.deuren >=', $data['deuren']);
            }
            else{
            $this->db->where('car_info.deuren', $data['deuren']);
            }
        } 
        if ($data['versnelling'] != '') {
            $this->db->where('car_info.versnelling', $data['versnelling']);
        } 
        if ($data['brandstof'] != '') {
            $this->db->where('car_info.brandstof', $data['brandstof']);
        } 
        }
       
        $this->db->limit(10); 
        $query = $this->db->get();
        return $query->result();
    }

    public function getCarIdBylicenseNumber($licenseNumber) {
        $this->db->select('car');
        $this->db->from('cars_licenseinfo');
        $this->db->where('cars_licenseinfo.licenseNumber', $licenseNumber);
        $query = $this->db->get();
        $result = $query->result();
        if ($result != null) {
            $car_id = $result[0]->car;

            $this->db->select('*');
            $this->db->from('cars');
            $this->db->where('id', $car_id);
            $query = $this->db->get();
            $voertuig = $query->result();
            return $voertuig[0]->voertuig_id;
        } else {
            return null;
        }
    }

    public function checkObjectbyVoertuig_id($voertuig_id) {
        $voertuig_id = preg_replace('#[^0-9]#', '', strip_tags($voertuig_id));
        $query = $this->db->query("select * from cars  where `voertuig_id` = $voertuig_id");
        $result = $query->result();
        if ($result) {
            return "1";
        } else {
            return "0";
        }
    }

    public function getCarDetailsById($voertuig_id) {

        $query = $this->db->query("select * from cars  where voertuig_id = $voertuig_id");
        $result = $query->result();
        $car_id = $result[0]->id;


        $this->db->select('*');
        $this->db->select('GROUP_CONCAT(DISTINCT(remoteFile) SEPARATOR ",") as remoteFile', false);
        $this->db->select('GROUP_CONCAT(DISTINCT(localFile) SEPARATOR ",") as localFile', false);


        $this->db->from('cars');

        $this->db->join('car_media', 'car = cars.id');
        $this->db->join('car_ads', 'car_ads.car = cars.id');
        $this->db->join('cars_licenseinfo', 'cars_licenseinfo.car = cars.id');
        $this->db->join('cars2specsdefault', 'cars2specsdefault.car = cars.id');
        $this->db->join('cars2specsfabric', 'cars2specsfabric.car = cars.id');
        $this->db->select('GROUP_CONCAT(DISTINCT(specFabric) SEPARATOR ",") as specFabric', false);
        $this->db->join('car_specsdefault', 'car_specsdefault.id = cars2specsdefault.specDefault');
        $this->db->join('car_specsfabric', 'car_specsfabric.id = cars2specsfabric.specFabric');
        $this->db->join('car_info', 'car_info.car = cars.id');

        $this->db->where('cars.id', $car_id);
        $query = $this->db->get();
        $result = $query->result();
        $specFabrics = $result[0]->specFabric;
        $specFabrics = explode(",", $specFabrics);
        $translation = '';
        foreach ($specFabrics as $spacefabricId) {
            $this->db->select('translation');
            $this->db->from('car_specsfabric');
            $this->db->where('car_specsfabric.id', $spacefabricId);
            $space = $this->db->get();
            $spaces = $space->result();
            $translation = $translation . $spaces[0]->translation . ",";
        }
        $result = $result[0];
        $result->specFabric = substr_replace($translation, "", strrpos($translation, ","), 1);
        return $result;
//       echo '<pre>';
//       print_r($result);
//       echo '</pre>';
//        
       die(); 
    }

}

