<?php
/**
 * Description of autos Model
 *
 * @author Cre8it
 */
class Crm_marketing extends CI_Model{
    
    private $tableDealer = 'crm_marketing_dealeracties';
    private $tableDefault = 'crm_marketing_defaultacties';
    private $tableInstellingen = 'crm_marketing_instellingen';
    private $tableKlanten  = 'crm_klanten'; 
    public function __construct(){
        parent::__construct();
    }
    
    function checkMarketingIdtoDealer($marketingId, $dealerId){
         $return = $this->db
            ->where('marketing_id',$marketingId)
            ->where('marketing_dealerId',$dealerId)
            ->get($this->tableDealer)->num_rows();
            //echo $this->db->last_query().'<br />';
        return $return ;
    }
    
    
    function getDefaultActies($notIds=false, $specificId=false){
        $this->db->select('*');
        if( is_array($notIds) && (count($notIds)>0) ){
            $this->db->where_not_in('marketing_defaultId', $notIds);
        }
        if(is_numeric($specificId)){
            $this->db->where('marketing_defaultId', $specificId);
        }
        
        $return = $this->db->get($this->tableDefault)->result();
        //echo $this->db->last_query().'<br />';
        return $return ;
    }
    
    
    // $actieType to show the klant or auto page]
    function getDealerActies($dealerId, $actieType=false){
        $this->db->select('*');
        if($actieType){
            $this->db->where('marketing_type', $actieType);   
        }
        $this->db->where('marketing_dealerId', $dealerId);
        $return = $this->db->get($this->tableDealer)->result();
        //echo $this->db->last_query().'<br />';
        return $return ;
    }
    
    function getDealerActiesAndSettings($dealerId, $actieType, $typeId){
        $marketingActies = $this->getDealerActies($dealerId, $actieType);
        foreach($marketingActies as $id => $actie){
            $marketingActies[$id]->setting = $this->getInstellingen($actie->marketing_id, $typeId);
        }
        return $marketingActies;
    }
    
    
    function getInstellingen($actieId, $typeId){
        $return = $this->db->select('*')
            ->where('marketing_inst_actieId', $actieId)
            ->where('marketing_inst_typeId', $typeId)
            ->get($this->tableInstellingen)
            ->row();
        //echo $this->db->last_query().'<br />';
        return $return ;
    }
    
    function setInstellingen($actieId, $type, $typeId, $actief) {
        if($this->getInstellingen($actieId, $typeId)){
            //echo 'heeft instellingen';
            $this->updateInstelling($actieId, $typeId, $actief);
        }
        else{
            //echo 'heeft geen instellingen<br/>';
            $this->insertInstelling($actieId, $type, $typeId, $actief);
        }
    }

    private function updateInstelling($actieId, $typeId, $actief){
        $marketingData = array('marketing_inst_actief' => $actief);
        $return = $this->db->where('marketing_inst_actieId', $actieId)->where('marketing_inst_typeId', $typeId)->update($this->tableInstellingen, $marketingData);
       // echo 'UPDATE INST: '.$this->db->last_query().'<br />';
        return $return;
    }
    
    private function insertInstelling($actieId, $type, $typeId, $actief) {
        $marketingData = array(
            'marketing_inst_actieId' => $actieId,
            'marketing_inst_actief' => $actief, 
            'marketing_inst_type' => $type, 
            'marketing_inst_typeId' => $typeId
        );
        $return = $this->db->insert($this->tableInstellingen, $marketingData); 
        //echo 'INSERT INST: '.$this->db->last_query().'<br />';
        return $return;
    }
    
    function handleMarketingActie($marketingId=false, $dealerId, $marketingData){
        $update = false;
        if($marketingId){
            $update = $this->checkMarketingIdtoDealer($marketingId, $dealerId);
        }
        
        if($update) {
            $marketingData['marketing_geupdateOp'] = date("Y-m-d H:i:s");
            return $this->updateMarketingActie($marketingId, $dealerId, $marketingData);
        }
        else{
            //echo 'insert<br />';
            $marketingData['marketing_gestartOp'] = date("Y-m-d H:i:s");
            $marketingData['marketing_geupdateOp'] = date("Y-m-d H:i:s");
            $this->insertMarketingActie($marketingData);
            $insertId = $this->db->insert_id();
            $this->setDefaultMarketingInstellingenKlanten($insertId, $dealerId, $marketingData);
            return $insertId;       
        }
    }
    
    private function setDefaultMarketingInstellingenKlanten($insertId, $dealerId, $marketingData){
       $query = $this->db
            ->select('crm_klanten.klant_id, crm_autos.auto_id')
            ->join('crm_autos', 'crm_klanten.klant_id = crm_autos.auto_klantId', 'left')
            ->where('crm_klanten.klant_dealerId', $dealerId)
            ->get('crm_klanten');
            
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if($row->auto_id){
                    $typeId = ($marketingData['marketing_type']=='klant') ? $row->klant_id : $row->auto_id; 
                    $this->setInstellingen($insertId, $marketingData['marketing_type'], $typeId, '1');
                    //echo $this->db->last_query().'<br />';
                }
            }
        } 
    }
    private function updateMarketingActie($marketingId, $dealerId, $marketingData){
        $return = $this->db->where('marketing_id', $marketingId)->where('marketing_dealerId', $dealerId)->update($this->tableDealer, $marketingData);
        //echo 'UPDATE MA: '.$this->db->last_query().'<br />';
        return $return;
    }
    
    private function insertMarketingActie($marketingData){
        $return = $this->db->insert($this->tableDealer, $marketingData); 
        //echo 'INSERT MA: '.$this->db->last_query().'<br />';
        return $return;
    }
    
///CRON ONLY FUNCTIONS
   function CRON_getDealerActies(){
         $return = $this->db->select('*')
            ->where('marketing_actief', '1')
            ->get($this->tableDealer)->result();
        
        //echo $this->db->last_query().'<br />';
        return $return;
    }
    
    function CRON_getSettings($marketingId){
         
         $return = $this->db->select('*')
            ->where('marketing_inst_actieId', $marketingId)
            ->where('marketing_inst_actief', '1')
            ->get($this->tableInstellingen)
            ->result();
         //echo $this->db->last_query().'<br />';
         return $return;
    }
// ## CRON ONLY FUNCTIONS    



    public function getRandomCustomer($dealerId){
      return  $this->db
        ->where('klant_dealerId', $dealerId)
        ->join('crm_autos', 'crm_klanten.klant_id = crm_autos.auto_klantId', 'left')
        ->order_by("RAND()")
        ->limit(1, 0)
        ->get($this->tableKlanten)->result();
  
    }
}
