<?php

/**
 * Description of autos Model
 *
 * @author Cre8it
 */
class Crm_autos extends CI_Model {

    private $tableName = 'crm_autos';

    public function __construct() {
        parent::__construct();
    }

    function createAuto($data, $dealerId) {
        $this->db->insert($this->tableName, $data);
        //echo $this->db->last_query().'<br />';
        $autoId = $this->db->insert_id();
        $this->setDefaultMarketingInstellingenAuto($autoId, $dealerId);
        return $autoId;
    }

    function setDefaultMarketingInstellingenAuto($autoId, $dealerId) {
        $query = $this->db->select('marketing_id')
                ->where('marketing_dealerId', $dealerId)
                ->where('marketing_type', 'auto')
                ->get('crm_marketing_dealeracties');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $marketingData = array(
                    'marketing_inst_actieId' => $row->marketing_id,
                    'marketing_inst_actief' => 1,
                    'marketing_inst_type' => 'auto',
                    'marketing_inst_typeId' => $autoId
                );
                $this->db->insert('crm_marketing_instellingen', $marketingData);
                $this->db->last_query() . '<br />';
            }
        }
    }

    function updateAuto($autoId, $klantId, $data) {
        $return = $this->db
                ->where('auto_id', $autoId)
                ->where('auto_klantId', $klantId)
                ->set($data)
                ->update($this->tableName);
        //echo $this->db->last_query().'<br />';
        return $return;
    }

    function createSpecifications($data) {
        $return = $this->db->insert('crm_auto_specificaties', $data);
        return $return;
    }

    function updateSpecifications($specificatieId, $data) {
        $return = $this->db
                ->where('specificatie_id', $specificatieId)
                ->set($data)
                ->update('crm_auto_specificaties');
        return $return;
    }

    function autosByKlant($klantId=false, $autoId=false, $search=false) {
        if ($klantId) {
            $this->db->where('auto_klantId', $klantId);
        }
        if ($autoId) {
            $this->db->where('auto_id', $autoId);
        }
        if (($search['fieldName']) && ($search['fieldValue'])) {
            $this->db->where('auto_' . $search['fieldName'], $search['fieldValue']);
        }
        $result = $this->db->get($this->tableName)->result();
        return $result;
    }

    function autoNaarKlant($autoId) {
        $return = $this->db
                        ->where('crm_autos.auto_id', $autoId)
                        ->join('crm_klanten', 'crm_autos.auto_klantId = crm_klanten.klant_id ', 'left')
                        ->get($this->tableName)->row();
        //echo $this->db->last_query().'<br />';
        return $return;
    }

    function checkDealerAuto($autoId, $dealerId) {
        $result = $this->db
                        ->where('crm_autos.auto_id', $autoId)
                        ->where('crm_klanten.klant_dealerId', $dealerId)
                        ->join('crm_klanten', 'crm_autos.auto_klantId = crm_klanten.klant_id ', 'left')
                        ->get($this->tableName)->num_rows();
        //echo $this->db->last_query();
        return $result;
    }

    function checkDealerKenteken($dealerId, $kenteken) {
        $result = $this->db
                        ->where('crm_autos.auto_kenteken', $kenteken)
                        ->where('crm_klanten.klant_dealerId', $dealerId)
                        ->join('crm_klanten', 'crm_autos.auto_klantId = crm_klanten.klant_id ', 'left')
                        ->get($this->tableName)->num_rows();
        echo $this->db->last_query();
        return $result;
    }

    function zoekImoby($kenteken, $dealerId) {
        $this->db->select('*');
        $this->db->distinct();
        $this->db->from('cars');
        $this->db->join('car_ads', 'car_ads.car = cars.id');
        $this->db->join('cars_licenseinfo', 'cars_licenseinfo.car = cars.id');
        $this->db->join('car_media', 'car_media.car = cars.id');
        $this->db->join('cars2specsdefault', 'cars2specsdefault.car = cars.id');
        $this->db->join('cars2specsfabric', 'cars2specsfabric.car = cars.id');
        $this->db->join('car_specsdefault', 'car_specsdefault.id = cars2specsdefault.specDefault');
        $this->db->join('car_specsfabric', 'car_specsfabric.id = cars2specsfabric.specFabric');
        $this->db->where('cars.dealer', $dealerId);
        $this->db->where('cars_licenseinfo.licenseNumber', $kenteken);
        $this->db->group_by('cars.id');
        $query = $this->db->get();
        $car_info = $query->result();

        if (isset($car_info[0])) {
            $car_id = $car_info[0]->car;
            $carmedias = $this->db->query("select * from car_media where car = $car_id");
            $carmedia = $carmedias->result();
            $media = array();
            foreach ($carmedia as $files) {
                $media[] = $files->remoteFile;
            }
            $car_info[0]->remoteFile = implode(',', $media);
            $car_infoo = $this->db->query("select attribute,valueText from car_info where car = $car_id");
            $car_info_result = $car_infoo->result();
            // print_r($car_info_result);
            if (isset($car_info_result)) {
                foreach ($car_info_result as $car_result) {
                    $attribute = $car_result->attribute;
                    $valueText = $car_result->valueText;
                    $car_info[0]->$attribute = $valueText;
                }
            }
            /* car specFabric start */
            $cars2specsdefaults = $this->db->query("
                                   select  * from `cars2specsdefault` 
                                   join car_specsfabric on `cars2specsdefault`. specDefault  = car_specsfabric.id
                                   where car = $car_id");
            $specsdefaults = '';
            $cars2specsdefault = $cars2specsdefaults->result();
            foreach ($cars2specsdefault as $specsdefault) {
                $specsdefaults = $specsdefaults . ", " . $specsdefault->translation;
            }
            $car_info[0]->specsdefault = $specsdefaults;

            /* car specFabric end */
        }




        return $result = $car_info[0];
    }

    function zoekImobyAjax($kenteken, $dealerId) {
        return $this->db
                        ->select("objects.kenteken")
                        ->like('objects.kenteken', $kenteken)
                        ->where('objects.kenteken !=', '')
                        ->where('objects.NVMVestigingNR', $dealerId)
                        ->get('objects')->result();
    }

    function getAutosByDealer($dealerId) {
        $result = $this->db
                        ->select('crm_autos.auto_kenteken')
                        ->where('crm_klanten.klant_dealerId', $dealerId)
                        ->join('crm_klanten', 'crm_autos.auto_klantId = crm_klanten.klant_id ', 'left')
                        ->get($this->tableName)->result();
        return $result;
    }

    function getOngekoppeld($dealerId, $dateLimit=false) {
        $kentekens = array();
        $autos = $this->getAutosByDealer($dealerId);
        if (count($autos)) {
            foreach ($autos as $key => $auto) {
                $kentekens[] = str_replace('-', '', $auto->auto_kenteken);
            }
        }

        $dealer_id = $dealerId;
        $this->db->select('*');
        $this->db->distinct();
        $this->db->from('cars');
        $this->db->join('car_ads', 'car_ads.car = cars.id');
        $this->db->join('cars_licenseinfo', 'cars_licenseinfo.car = cars.id');
        $this->db->join('cars2specsdefault', 'cars2specsdefault.car = cars.id');
        $this->db->join('cars2specsfabric', 'cars2specsfabric.car = cars.id');
        $this->db->join('car_specsdefault', 'car_specsdefault.id = cars2specsdefault.specDefault');
        $this->db->join('car_specsfabric', 'car_specsfabric.id = cars2specsfabric.specFabric');
        $this->db->where('cars.dealer', $dealer_id);
        $this->db->where('car_ads.active', 1);
        $this->db->group_by('cars.id');
        $query = $this->db->get();
        $car_info = $query->result();
        $numberofcar = count($car_info) - 1;
        for ($i = 0; $i <= $numberofcar; $i++) {
            if (isset($car_info[$i])) {

                $car_id = $car_info[$i]->car;
                $carmedias = $this->db->query("select * from car_media where car = $car_id");
                $carmedia = $carmedias->result();
                $media = array();
                foreach ($carmedia as $files) {
                    $media[] = $files->remoteFile;
                }

                $car_info[$i]->remoteFile = implode(',', $media);
                $car_infoo = $this->db->query("select attribute,valueText from car_info where car = $car_id");
                $car_info_result = $car_infoo->result();
                // print_r($car_info_result);
                if (isset($car_info_result)) {
                    foreach ($car_info_result as $car_result) {
                        $attribute = $car_result->attribute;
                        $valueText = $car_result->valueText;
                        $car_info[$i]->$attribute = $valueText;
                    }
                }
                /* car specFabric start */
                $cars2specsdefaults = $this->db->query("
                                   select  * from `cars2specsdefault` 
                                   join car_specsfabric on `cars2specsdefault`. specDefault  = car_specsfabric.id
                                   where car = $car_id");
                $specsdefaults = '';
                $cars2specsdefault = $cars2specsdefaults->result();
                foreach ($cars2specsdefault as $specsdefault) {
                    $specsdefaults = $specsdefaults . ", " . $specsdefault->translation;
                }
                $car_info[0]->specsdefault = $specsdefaults;

                /* car specFabric end */
            }
        }
        return $car_info;
    }

    function getImobyFoto($objectId, $limit=1) {
        //$this->db->select('remote_url, media_url')
        return $this->db->select('remote_url, media_url')
                        ->get_where('objects_medialist', array('object_id' => $objectId), $limit)->result();
    }

    function getImobyFotoKenteken($kenteken, $dealerId, $limit=1) {
        $fotos = false;
        $imoby = $this->zoekImoby($kenteken, $dealerId);
        if ($imoby->ObjectTiaraID) {
            $fotos = $this->getImobyFoto($imoby->ObjectTiaraID, $limit);
            $fotos['ObjectTiaraID'] = $imoby->ObjectTiaraID;
        }
        return $fotos;
    }

    function setActive($autoId, $active) {
        $return = $this->db
                ->where('auto_id', $autoId)
                ->set(array('auto_actief' => $active))
                ->update($this->tableName);

        return $return;
    }

}