<?php
/**
 * Description of dealer Model
 *
 * @author Cre8it
 */
class Crm_dealer extends CI_Model{
    
    private $tableDealers;
    
    public function __construct(){
        parent::__construct();
        $this->tableDealers = 'crm_dealers';
        $this->tableKlanten = 'crm_klanten';
    }
   public function getUserDealerId($userId){

        $this->db->select('*');
        $this->db->from('users2dealers');
        $this->db->where('user',6);
        $query = $this->db->get();
        return $resultset=$query->result();
   }
    
    public function getDealerInfo($dealerId, $checkOnly=false){
     
        $query = $this->db
            ->where('dealer_id', $dealerId)
            ->get($this->tableDealers);
       
        if ($query->num_rows() > 0) {
           
            return $query->row();
           
        }
        else{
             die("Hazrat");
            if($checkOnly){
                return false;
            }
            else {
                
                $dealerData = $this->checkImobyUser($dealerId);
                if(!$dealerData){
                    $dealerData = (object) array(
                        'dealer_registratieDatum' => date("Y-m-d H:i:s"),
                        'dealer_actief' => 1,
                        'dealer_nvmId' => $dealerId);
                }
                $this->setDealerInfo($dealerData);
               
                return $dealerData;
            }
        }     
    }
      
    private function checkImobyUser($dealerId){
          $query = $this->db
            ->select('*')
            ->where('klantnummer', $dealerId)
            ->get('users');
           
        if ($query->num_rows() > 0) {
            $imobyData = $query->row();
            
         
          /*  
          $dealerData = (object) array(
                'dealer_registratieDatum' => date("Y-m-d H:i:s"),
                'dealer_actief' => 1,
                'dealer_nvmId' => $dealerId,
                'dealer_aanhef' => ($imobyData->pre_name=='Dhr.') ? 'De Heer' : 'Mevrouw',
                'dealer_voornaam' => $imobyData->firstName,
                'dealer_achternaam' => $imobyData->lastName,
                'dealer_email' => $imobyData->email,
                'dealer_telefoon' => $imobyData->phone,
                'dealer_bedrijfsnaam' => $imobyData->office_name,
                'dealer_adres' => $imobyData->office_address,
                'dealer_postcode' => $imobyData->office_postcode,
                'dealer_woonplaats' => $imobyData->office_city
            );
            */
           
            return $dealerData;
        }
        else{
            return false;
        }
    }
    
    function setDealerInfo($dealerData){
        return $this->db->insert($this->tableDealers, $dealerData); 
    }
    
    function updateDealerInfo($dealerId, $dealerData){
        return $this->db
            ->where('dealer_nvmId', $dealerId)
            ->update($this->tableDealers, $dealerData);  
    }
    
    function getMobileCode($dealerId){
         $return = is_numeric($dealerId) ? $this->db->query("SELECT ObjectTiaraID FROM `mobile_apps` WHERE `NVMVestigingNR` = '".$dealerId."' AND `mode` = 'application' ")->row() : false;;
         return $return->ObjectTiaraID;   
     }
    
    
    
    
/** CRON **/
    public function CRON_getDealers(){
        $query = $this->db
           // ->where('dealer_nvmId', $dealerId)
            ->get($this->tableDealers);
         if ($query->num_rows() > 0) {
            $dealers = array();
            foreach ($query->result() as $row) {
                $dealers[] = $row;
            }
            return $dealers;
        }  
        return false;
    }
    
}