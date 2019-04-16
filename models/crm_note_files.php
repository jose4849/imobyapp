<?php
/**
 * Description of autos Model
 *
 * @author Cre8it
 */
class Crm_note_files extends CI_Model{
    
    private $notesTable = 'crm_auto_notities';
    private $documentenTable = 'crm_documenten';
    public function __construct(){
        parent::__construct();
    }
    
    
    function saveDocument($documentName, $omschrijving, $documentType, $documentOwner, $ownerId) {
        $data = array('document_fileNaam' => $documentName, 'document_omschrijving' => $omschrijving, 'document_type' => $documentType, 'document_owner' => $documentOwner, 'document_datum' => date("Y-m-d H:i:s"));
        if($documentOwner=='auto'){
            $data['document_autoId'] = $ownerId;
        }
        else if($documentOwner=='klant'){
            $data['document_klantId'] = $ownerId;
        }
        
        return $this->db->insert($this->documentenTable, $data);
    }
    
    
    function getDocumenten($documentType, $documentOwner, $ownerId) {
            if($documentOwner=='auto'){
                $this->db->where('document_autoId', $ownerId);
            }
            else if($documentOwner=='klant'){
                $this->db->where('document_klantId', $ownerId);
            }
           $result = $this->db
                ->where('document_type',$documentType)
                ->get($this->documentenTable)->result();
        return $result;
    }
    
    
    function saveNote($autoId, $opmerking) {
        $data = array(
            'notitie_autoId' => $autoId,
            'notitie_text'   => $opmerking
        );
        return $this->db->insert($this->notesTable, $data);
    }
    function updateNote($autoId, $opmerkingId, $opmerking) {
        $data = array(
            'notitie_text'   => $opmerking,
            'notitie_datum'   => date("Y-m-d H:i:s")
        ); 	
        return $this->db->where('notitie_autoId', $autoId)->where('notitie_id', $opmerkingId)->update($this->notesTable, $data);
    }
    
    
    
    
    
    function getNotes($autoId) {
        return $this->db
            ->where('notitie_autoId',$autoId)
            ->get($this->notesTable)->result();
    }
    function deleteNote($noteId){
         return $this->db->delete($this->notesTable, array('notitie_id' => $noteId)); 
    }
    
    function getFacturen(){
        return false;
    }
    
    
    function deleteAutoFile($filePath, $autoId, $documentId) {
        ///home/imoby/domains/app.imoby.nl/public_html/fileserver/bofiles/crm_files
        $file = $this->getFile($documentId);
        if(is_file($filePath.$file->document_fileNaam)){
            if($this->deleteFile($documentId)){
                unlink($filePath.$file->document_fileNaam);
            }
        }
        else{
            return 'Cannot delete file.';
        }
        
    }
    
    private function deleteFile($documentId){
        return $this->db->delete($this->documentenTable, array('document_id' => $documentId)); 
    }
    
    private function getFile($documentId){
        $return = $this->db
            ->where('document_id',$documentId)
            ->get($this->documentenTable)->result();
            //return $this->db->last_query().'<br />';
        return ($return) ? $return[0] : false;
    }
}