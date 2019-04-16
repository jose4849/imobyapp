<?php
/**
 * Description of autos Model
 *
 * @author Cre8it
 */
class Crm_facturen extends CI_Model {
    
    private $tableDefaultFactuurItems = 'crm_factuur_default_items'; 
    private $tableFactuurItems = 'crm_factuur_items';
    private $tableFacturen = 'crm_facturen';
    
    public function __construct(){
        parent::__construct();
    }
    
    function getDefaultFactuurItems(){
        return $this->db->get($this->tableDefaultFactuurItems)->result();
    }
    
    function checkFactuurNr($dealerId,$factuurNr){
          $test = $this->db
            ->where('factuur_id', $factuurNr)
            ->where('factuur_dealerId', $dealerId)
            ->get($this->tableFacturen)->row();
            return $test;
    }
    
    function getNewFactuurNr($dealerId){
        $result = $this->db->select_max('factuur_id')
            ->where('factuur_dealerId', $dealerId)
            ->get($this->tableFacturen)->row();
        
        if ($result->factuur_id) {
            if(is_numeric($result->factuur_id)){
                return $result->factuur_id+1;
            }
            else{// lets see if we can add the number
                if (preg_match('/[A-Za-z0-9]+/', $result->factuur_id)) {
                    $number = preg_replace("/[^0-9]/","", $result->factuur_id); // replace all but numbers
                    $number++;
                    return preg_replace("/[0-9]/", $number, $result->factuur_id); // replace number
                }
                else{
                    return $result->factuur_id;
                }
            }
        }
        else{
            return 1;
        }
    }
    
    function createFactuur($factuurData){
        $data = array(
            'factuur_id' => $factuurData['factuurId'],
            'factuur_dealerId' => $factuurData['dealerId'], 
            'factuur_autoId' => $factuurData['autoId'], 
            'factuur_omschrijving' => $factuurData['omschrijving']
        );
        if(is_array($factuurData['factuurItems'])){
            foreach($factuurData['factuurItems'] as $items){
                $this->insertFactuurRegels($items);
            }
        }
        return $this->db->insert($this->tableFacturen, $data);  
        //echo $this->db->last_query().'<br />';
    }
    
    private function insertFactuurRegels($itemsData){
        return $this->db->insert($this->tableFactuurItems, $itemsData);  
         //echo $this->db->last_query().'<br />';
    }
    
    function getAutoFacturen($dealerId, $autoId){
        $facturen = $this->db
            ->where('factuur_dealerId', $dealerId)
            ->where('factuur_autoId', $autoId)
            ->order_by("factuur_datum","DESC")
            ->get($this->tableFacturen)->result();
            return $facturen;
    }
    
    function getFactuurData($dealerId, $factuurId){
        $factuur = $this->db
            ->where('factuur_dealerId', $dealerId)
            ->where('factuur_id', $factuurId)
            ->get($this->tableFacturen)->row();
            
        //echo $this->db->last_query().'<br />';
        if($factuur->factuur_id){
            $factuurItems = $this->getFactuurItems($factuurId);
            //print '<pre>'; print_r($factuurItems); print '</pre>';            
            return array('factuurData' => $factuur, 'factuurItems' => $factuurItems);            
        }          
        else{
            return false;
        }  
            
    }
    
    function getFactuurItems($factuurId){
        $items = $this->db
            ->where('item_factuurId', $factuurId)
            ->get($this->tableFactuurItems)->result();
        //echo $this->db->last_query().'<br />';
        
        return $items;
    }
    
    function deleteFactuur($dealerId, $factuurId){
        if(($dealerId) && ($factuurId)) {
            $this->db->where('factuur_id', $factuurId)
                ->where('factuur_dealerId', $dealerId)
                ->delete($this->tableFacturen); 
            $this->db->where('item_factuurId', $factuurId)
                ->delete($this->tableFactuurItems); 
        }
        
    }
    
   function alleFacturenMetKlantData($dealerId){
        $facturen = $this->db
            ->where('factuur_dealerId', $dealerId)
            ->join('crm_autos a', 'f.factuur_autoId = a.auto_id', 'left')
            ->join('crm_klanten k', 'a.auto_klantId = k.klant_id ', 'left')
            ->order_by("factuur_datum","DESC")
            ->get($this->tableFacturen.' f')->result();
            //echo $this->db->last_query().'<br />';
            return $facturen;
    }
    
    
}