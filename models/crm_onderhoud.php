<?php
/**
 * Description of autos Model
 *
 * @author Cre8it
 */
class Crm_onderhoud extends CI_Model{
    private $tableName = 'crm_auto_onderhoud';
    public function __construct(){
        parent::__construct();
    }
    
    function saveOnderhoud($autoId, $data) {
        return $this->db->insert($this->tableName, $data);
    }
     function updateOnderhoud($onderhoudId, $autoId, $data) {      
        return $this->db->where('onderhoud_autoId', $autoId)->where('onderhoud_id', $onderhoudId)->update($this->tableName, $data);
        
    }
       
    function getOnderhoud($autoId) {
        $this->db->where('onderhoud_autoId',$autoId);
        $this->db->order_by("onderhoud_datum", "DESC"); 
        $result = $this->db->get($this->tableName)->result();
        //echo $this->db->last_query().'<br/>';
        return $result;

    }
    function deleteOnderhoud($autoId, $onderhoudId){
        $this->db->where('onderhoud_id', $onderhoudId);
        $this->db->where('onderhoud_autoId', $autoId);
        return $this->db->delete($this->tableName); 
         
    }
}
?>