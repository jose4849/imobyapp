<?php
/**
 * Description of klanten Model
 *
 * @author Cre8it
 */
class Crm_klanten extends CI_Model{
    
    private $tableName = 'crm_klanten';
    
    public function __construct(){
        parent::__construct();
       
    }
    
    
    private function cleanKlanten(){
        $this->db->or_where('klant_voornaam IS NULL');
        $this->db->or_where('klant_achternaam IS NULL');
        $this->db->or_where('klant_email IS NULL');
        $this->db->delete($this->tableName); 
        //$this->db->get($this->tableName);
        //echo $this->db->last_query();	 	
        //remove from marketing settings
    }
    
    
    function checkDealerKlant($klantId, $dealerId){
       $result = $this->db
            ->where('klant_id',$klantId)
            ->where('klant_dealerId',$dealerId)
            ->get($this->tableName)->num_rows();
        //echo $this->db->last_query();
        return ($result) ? true : false;
    }
    
    
    function createKlant($data){
        $this->db->insert($this->tableName, $data); 
        $klantId = $this->db->insert_id();
        $this->setDefaultMarketingInstellingenKlant($klantId, $data['klant_dealerId']);
        return $klantId;
    }
    
    function setDefaultMarketingInstellingenKlant($klantId, $dealerId) {
        $query = $this->db->select('marketing_id')
            ->where('marketing_dealerId', $dealerId)
            ->where('marketing_type', 'klant')
            ->get('crm_marketing_dealeracties');

         if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                 $marketingData = array(
                    'marketing_inst_actieId' => $row->marketing_id,
                    'marketing_inst_actief' => 1, 
                    'marketing_inst_type' => 'klant', 
                    'marketing_inst_typeId' => $klantId
                );
                $this->db->insert('crm_marketing_instellingen', $marketingData); 
                //$this->db->last_query().'<br />';
            }
        }  
    }
    
    
    private function deleteKlant($klantId, $dealerId){
         $this->db
            ->where('klant_id', $klantId)
            ->where('klant_dealerId', $dealerId)
            ->delete($this->tableName); 

         return $this->db->last_query();
    }
    
    
    function updateKlant($klantId, $data){
        $return = $this->db
            ->where('klant_id', $klantId)
            ->update($this->tableName, $data);   
        return  $return;// $this->db->last_query();
    }
    
    function getKlant($klantId, $dealerId){     
        $result = $this->db
            ->where('klant_id',$klantId)
            ->where('klant_dealerId', $dealerId)
            ->get($this->tableName)->row();
        //echo $this->db->last_query();
        return $result;
    }
    
    function klantenMetAutoInformatie($dealerId){
        // first clean up empty rows
        $this->cleanKlanten();
        
        // then get the klanten                                
        $result =  $this->db
            ->join('crm_autos', 'crm_klanten.klant_id = crm_autos.auto_klantId', 'left')
            ->where('crm_klanten.klant_dealerId', $dealerId)
            ->get($this->tableName)->result();
        $this->db->last_query();
        return $result;
    }
    
    function klantMetAutoInformatie($klantId){
        $result = $this->db
            ->where('crm_klanten.klant_id',$klantId)
            ->join('crm_autos', 'crm_klanten.klant_id = crm_autos.auto_klantId', 'left')
            ->get($this->tableName)->row();
        //echo $this->db->last_query();
        return $result;
    }
    
    
}
