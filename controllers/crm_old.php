<?php
/**
 * Description of CRM
 *
 * @author Cre8it.nl
 */
class Crm extends CI_Controller{
    private $dealerId, $errorMessage, $remoteDealerDir, $remoteDealerPath,  $localDealerDir,  $crmDealerUrl, $facturenPath, $bestandenPath, $autoPath;
    public $breadcrumbs;
    
    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('http://www.imoby.nl/login.html');	
            //echo 'NIET INGELOGD';
        }
        else{
            $this->dealerId = 100;//'00010';//$this->session->userdata['imobycode'];
            
            $this->localDealerDir = FILEDIR.'/bofiles/crm_files/'.$this->dealerId.'/';
            $isDir = (is_dir($this->localDealerDir)) ?  true : mkdir($this->localDealerDir, 0777);
            $this->autoPath = $this->localDealerDir.'autos/';
            $this->bestandenPath = $this->localDealerDir.'bestanden/';
            $this->facturenPath = $this->localDealerDir.'facturen/';
            $this->crmDealerUrl = 'http://app.imoby.nl/fileserver/bofiles/crm_files/'.$this->dealerId.'/';

            $this->remoteDealerDir = 'http://app.imoby.nl/fileserver/bofiles/downloads/'.$this->dealerId.'/'; // get images from this
            $this->remoteDealerPath = '/home/imoby/domains/app.imoby.nl/public_html/fileserver/bofiles/downloads/'.$this->dealerId.'/';
            
            $this->load->library('crm_breadcrumbs');
            $this->crm_breadcrumbs->setCrumb(array('step' => 0, 'link' => '/crm/relaties','title' => 'Relatiebeheer'));
        }

        if($this->errorMessage){
            $this->session->errorMessage = $this->errorMessage;
        }
    }
    
    
// OVERVIEW FUNCTIONS       
    function index(){ 
        $this->load->model('crm_dealer');
        $dealer = $this->crm_dealer->getDealerInfo($this->dealerId);
        //$properties = array_filter(get_object_vars($data['view']['dealer']));
        if($this->_checkDealerInfo($dealer)===false){
            redirect(BASE . 'crm/settings');
        }
        else{
            redirect(BASE . 'crm/relaties');
        }
    }
//## OVERVIEW FUNCTIONS   


function sendTestMailing(){
    $this->load->library('Email');
    $data =  file_get_contents('/home/imoby/domains/app.imoby.nl/public_html/email/uitvoorraad.php');
    $config = array();
    $config['mailtype'] = 'html';
    $this->email->initialize($config);
    $this->email->from('info@imoby.nl', 'Imoby BV');
    //$this->email->to('stefan.de.vries@cre8it.nl');
    //$this->email->to('stefandevries@gmail.com');
    //$this->email->to('stefandv@hotmail.com');
    $this->email->to('frank.pietersen@cre8it.nl');
    $this->email->subject('Imoby voorraad update');
    $this->email->message($data);
    if(!$this->email->send()){
        echo 'not send';
    }
    else{
        echo 'Test send';
    }
}



//DEALER FUNCTION

function settings($mode=false){
    $this->load->model('crm_dealer');
    $this->load->model('crm_marketing');
    $this->crm_breadcrumbs->setCrumb(array('step' => 1, 'link' => '/crm/settings','title' => 'Instellingen'), true);
    if($mode=='edit'){

        $error = '';
        $this->load->library('form_validation');
        
        // setup
        $veldNamen = array('aanhef','voornaam','tussenvoegsel','achternaam','bedrijfsnaam','email','actief','postcode','adres','huisnummer','woonplaats','telefoon','mobiel', 'btwnr', 'kvknr', 'factuurtemplate', 'rekeningnr', 'emailBedrijfsgegevens'); 
        $veldNaam  = $this->input->post('veldNaam');
        $veldWaarde  = $this->input->post('veldWaarde');
        
        $veldValidaties = array(
            'aanhef'            => 'trim|xss_clean|strip_tags|required',
            'voornaam'          => 'trim|xss_clean|strip_tags|max_length[25]',
            'tussenvoegsel'     => 'trim|xss_clean|strip_tags|max_length[25]',
            'achternaam'        => 'trim|xss_clean|strip_tags|required|max_length[50]',
            'bedrijfsnaam'      => 'trim|xss_clean|strip_tags|max_length[50]',
            'email'             => 'trim|xss_clean|strip_tags|required|valid_email',
            'actief'            => 'trim|xss_clean|strip_tags',
            'postcode'          => 'trim|xss_clean|strip_tags',
            'adres'             => 'trim|xss_clean|strip_tags|max_length[50]',
            'huisnummer'        => 'trim|xss_clean|strip_tags|max_length[10]',
            'woonplaats'        => 'trim|xss_clean|strip_tags|max_length[50]',
            'telefoon'          => 'trim|xss_clean|strip_tags|max_length[11]',
            'mobiel'            => 'trim|xss_clean|strip_tags|max_length[11]',
            'btwnr'             => 'trim|xss_clean|strip_tags', // 'NL'    => '[0-9]{9}B[0-9]{2}',
            'kvknr'             => 'trim|xss_clean|strip_tags',// '[0-9]{8-11}',
            'factuurtemplate'   => 'trim|xss_clean|strip_tags',
            'rekeningnr'        => 'trim|xss_clean|strip_tags',
            'emailBedrijfsgegevens' => 'trim|xss_clean|numeric',
        );
        
        // Check of het veldnaam wel bestaat.
        $regexCheck = $this->_regexValidation($veldNaam, $veldWaarde);
        if(!in_array($veldNaam, $veldNamen)) {
            $error = 'Ilegal action'; 
        }
        else if($regexCheck!==true){
            $error = $regexCheck;
        }                
        else {   
            $this->form_validation->set_rules('veldWaarde', ucfirst($veldNaam), $veldValidaties[$veldNaam]);
            if($this->form_validation->run() === FALSE){
                $error = strip_tags(validation_errors());
            }
            else{
                $veldWaarde = set_value('veldWaarde'); // xss and tags cleaned
                if($veldNaam=='postcode'){
                    $veldWaarde = strtoupper($veldWaarde);               
                }
                $this->crm_dealer->updateDealerInfo($this->dealerId, array('dealer_'.$veldNaam => $veldWaarde));
            }
        }
        
        // return output
        die(json_encode(array('error' =>$error ))); //  $error
    }
    
    
    $acties = array();
    // get dealer acties and see if they have default acties
    $dealerActies = $this->crm_marketing->getDealerActies($this->dealerId);
    
    if(count($dealerActies)){
        $notIds = array();
        foreach($dealerActies as $actie){
            if($actie->marketing_defaultId){
                $notIds[] = $actie->marketing_defaultId;
            }
        }
    }
    
    $defaultActies = $this->crm_marketing->getDefaultActies($notIds);
    if( is_array($dealerActies) && is_array($defaultActies)){
        $acties = array_merge($dealerActies, $defaultActies);
    }
    else{
        if(is_array($dealerActies)){
            $acties = $dealerActies;
        }
        else if(is_array($defaultActies)){
            $acties = $defaultActies;
        }  
    }
    
    // format some of the data
	$data['view']['acties'] = $acties;
    

    $dealer = $this->crm_dealer->getDealerInfo($this->dealerId);
    if($mode=='autouitvoorraad') {
        if($dealer->dealer_email_uitvoorraad){
            $dealer_email_uitvoorraad = 0;
            $data['view']['message'] = '<p><b>Email \'Auto uit voorraad\' uitgeschreven.</b></p>';
        }
        else{
            $dealer_email_uitvoorraad = 1;
             $data['view']['message'] = '<p><b>Email \'Auto uit voorraad\' ingeschreven.</b></p>';
        }
        $this->crm_dealer->updateDealerInfo($this->dealerId, array('dealer_email_uitvoorraad' => $dealer_email_uitvoorraad));
    }
    
    
    if($this->_checkDealerInfo($dealer)===false){
        $data['view']['message'] = '<p><b>Niet alle velden zijn ingevuld, deze zijn essentieel voor de werking van deze applicatie.</b></p>';
    }
    $data['leftMenu']['menuActive'] = 'Settings';
    $data['view']['dealer'] = $dealer;
    $data['headerData']['active'] = 'Settings';
    $data['headerData']['jsInclude'][] = 'dealer';
    $data['headerData']['cssInclude'][] = 'dealer';
    $this->_buildPage('dealer', $data);  
}

private function _checkDealerInfo($dealerInfo){
    $return = false;
    $veldNamen = array('aanhef','voornaam', 'achternaam','bedrijfsnaam','email','postcode','adres','huisnummer','woonplaats','telefoon', 'btwnr', 'kvknr'); 
    $dealerInfo = (array) $dealerInfo;
    if($dealerInfo) {
        foreach($veldNamen as $name){
            $tmp = 'dealer_'.$name;
            if(empty($dealerInfo[$tmp])){
                return false;
                break;
            }
        }
    }
    else{
        return false;
    }
 
}

//## DEALER FUNCTION
    
//## KLANT FUNCTIONS    
    // Overzicht van auto's en eigenaaren
    function relaties(){
        $this->load->model('crm_klanten');
        $data = array();
        $data['leftMenu']['menuActive'] = 'Relaties'; 
        $this->crm_breadcrumbs->setCrumb(array('step' => 1, 'link' => '/crm/relaties','title' => 'Relaties'), true);
        $autos =  $this->crm_klanten->klantenMetAutoInformatie($this->dealerId);
       // echo '<pre>';
       // print_r($autos);
      //  die();
        
        if(count($autos)){
            foreach ($autos as $key => $autoData) {
               // $autos[$key]->klant_naam = $autoData->klant_voorvoegsel . ' ' . $autoData->klant_voornaam . (($autoData->klant_tussenvoegsel) ? ' ' . $autoData->klant_tussenvoegsel : '') . ' ' . $autoData->klant_achternaam;
                $autos[$key]->klant_adres_woonplaats = $autoData->klant_adres . ' ' . $autoData->klant_huisnummer . ' ' . $autoData->klant_woonplaats;
               // $autos[$key]->auto_kenteken = $this->_formatKenteken($autos[$key]->auto_kenteken);
                $autos[$key]->auto_merk_type = $autoData->auto_merk . ' ' . $autoData->auto_type;
                $autos[$key]->klant_actief = ($autos[$key]->klant_actief) ? 'Actief' : 'Inactief';
            }
        }
        // searching
      
        
        if (count($_POST)) {
            $autos = $this->_searchAutoArray($autos, $_POST);
        }
      
        $data['view']['autos'] = $autos;
        $data['headerData']['jsInclude'][] = 'klanten';
        $data['headerData']['cssInclude'][] = 'klanten';
        $this->_buildPage('klanten_overview', $data);  
    }


    // specifieke klant en edit functies
    function relatie($klantId=false, $mode=false, $kenteken=false){
        $this->crm_breadcrumbs->setCrumb(array('step' => 1, 'link' => '/crm/relaties','title' => 'Relaties'));
        $data = array();
        if( ($klantId=='koppel') || ($mode=='koppel') ) {
            $kenteken =  ($mode=='koppel') ? $kenteken : $mode;
            $klantId = (is_numeric($klantId)) ? $klantId : '0';
            $data['view']['koppelKenteken'] = (strpos('-', $kenteken)) ? $kenteken : $this->_formatKenteken($kenteken);
            $mode = false;
        }
        
        $klantId = !is_numeric($klantId) ? false : $klantId;
        $this->load->model('crm_klanten');
        $this->load->model('crm_autos');
        $this->load->model('crm_marketing');
        
        
        if (!empty($klantId)) { // bestaande klant
            if($this->crm_klanten->checkDealerKlant($klantId,  $this->dealerId)===false){
                die('"Klant bestaat niet."');
                //$this->errorMessage = "Klant bestaat niet.";
                //redirect('crm/')
                exit();
            }
            $data['view']['klantId'] = $klantId; // uit db straks
        }
        
        if($mode) {
            switch($mode){
                case 'edit':
                    $this->_bewerk_klant($klantId);
                    break;  
                 case 'marketingSetting':
                    $this->_marketingSetting('klant', $klantId);
                    break; 
                default:
                break;
            }
            exit();
        }
           //Als we een klant hebben, dan de gegevens ophalen
        if($klantId){
            $klant = $this->crm_klanten->getKlant($klantId, $this->dealerId);
            $data['view']['klant'] = $klant;
            $this->crm_breadcrumbs->setCrumb(array('step' => 2, 'link' => '/crm/relatie/'.$klant->klant_id,'title' => $klant->klant_voornaam[0].'. '.(($klant->klant_tussenvoegsel) ? $klant->klant_tussenvoegsel.' ' : '').' '.$klant->klant_achternaam), true);
            $name = $data['view']['klant']->klant_voornaam;
            $name .= ($data['view']['klant']->klant_tussenvoegsel) ?  ' '.$data['view']['klant']->klant_tussenvoegsel : '';
            $name .= ($data['view']['klant']->klant_achternaam) ?  ' '.$data['view']['klant']->klant_achternaam : '';
            //$this->breadcrumbs->addBreadcrumb(1, $name, 'relatie/'.$klantId);
        
            $autos = $this->crm_autos->autosByKlant($klantId);
            if(count($autos)){
                foreach($autos as $key => $autoData){
                    $autos[$key]->auto_kenteken = $this->_formatKenteken($autos[$key]->auto_kenteken);
                    $autos[$key]->auto_actief = ($autos[$key]->auto_actief) ? 'Actief' : 'Inactief';
                    $autos[$key]->auto_foto = ($autos[$key]->auto_foto) ? $this->crmDealerUrl.$autos[$key]->auto_foto : false;  
                }
            }
            $data['view']['autos'] = $autos;
            $data['view']['marketingActies'] = $this->crm_marketing->getDealerActiesAndSettings($this->dealerId, 'klant', $klantId);
        
            //$data['view']['facturen'] = $this->crm_documenten->getFacturen($klantId);
            //$data['view']['documenten'] = $this->crm_documenten->getDocumenten($klantId, 'facturen'); // 'facturen' niet
        }
        elseif($klantId==0){
            $this->crm_breadcrumbs->setCrumb(array('step' => 2, 'link' => '/crm/relaties','title' => 'Nieuwe relatie'));
        }
        else if($klantId==''){
            redirect('/crm/relaties');
        }

        // Build the data for the pages
        $data['leftMenu']['menuActive'] = 'Relaties'; 
        $data['headerData']['jsInclude'][] = 'klanten';
        $data['headerData']['jsInclude'][] = 'autos';
        $data['headerData']['cssInclude'][] = 'klanten';
        $data['headerData']['cssInclude'][] = 'autos';
        $this->_buildPage('klant', $data); 
    }
    

    // klant informatie bewerken
    function _bewerk_klant($klantId){
                 
        $error = '';
        $this->load->model('crm_klanten');
        $this->load->library('form_validation');
        
        // setup
        $veldNamen = array('aanhef','voornaam','tussenvoegsel','achternaam','bedrijfsnaam','geboortedatum','email','actief','postcode','adres','huisnummer','woonplaats','telefoon','mobiel', 'marketing'); 
        $veldNaam  = $this->input->post('veldNaam');
        $veldWaarde  = $this->input->post('veldWaarde');
        
        $veldValidaties = array(
            'aanhef'            => 'trim|xss_clean|strip_tags|required',
            'voornaam'          => 'trim|xss_clean|strip_tags|required|max_length[25]',
            'tussenvoegsel'     => 'trim|xss_clean|strip_tags|max_length[25]',
            'achternaam'        => 'trim|xss_clean|strip_tags|required',
            'bedrijfsnaam'      => 'trim|xss_clean|strip_tags|max_length[50]',
            'geboortedatum'     => 'trim|xss_clean|strip_tags|max_length[11]',
            'email'             => 'trim|xss_clean|strip_tags|required|valid_email',
            'actief'            => 'trim|xss_clean|strip_tags',
            'postcode'          => 'trim|xss_clean|strip_tags',
            'adres'             => 'trim|xss_clean|strip_tags|max_length[50]',
            'huisnummer'        => 'trim|xss_clean|strip_tags|max_length[10]',
            'woonplaats'        => 'trim|xss_clean|strip_tags|max_length[50]',
            'telefoon'          => 'trim|xss_clean|strip_tags|max_length[11]',
            'mobiel'            => 'trim|xss_clean|strip_tags|max_length[11]',
            'marketing'         => 'trim|xss_clean|strip_tags|'
        );
        
        // Klant verwijderen
        if($veldNaam=='delete'){
            //log_message('ERROR', 'HIER2 veldNaam:'.$veldNaam.' $veldWaarde:'.$veldWaarde);
            //echo $this->crm_klanten->deleteKlant($klantId, $this->dealerId);
            exit();
        }
        
        // Check of het veldnaam wel bestaat.
        $regexCheck = $this->_regexValidation($veldNaam, $veldWaarde);
        if(!in_array($veldNaam, $veldNamen)) {
            $error = 'Ilegal action'; 
        }
        else if($regexCheck!==true){
            $error = $regexCheck;
        }
        else{                 
            // check if the value is valid
            $this->form_validation->set_rules('veldWaarde', ucfirst($veldNaam), $veldValidaties[$veldNaam]);
            if($this->form_validation->run() === false){
                $error = strip_tags(validation_errors());
                die(json_encode(array('klantId' => $klantId, 'error' => $error)));
            }
            else{
                $veldWaarde = set_value('veldWaarde'); // xss and tags cleaned
                if($veldNaam=='postcode'){
                    $veldWaarde = strtoupper($veldWaarde);
                                    
                }
                // exceptions.... 
                if($veldNaam=='geboortedatum'){
                    $veldWaarde = ($veldWaarde) ? date("Y-m-d", strtotime($veldWaarde)) :  null;
                }
                
                // Is dit een nieuwe klant, dan nieuwe id ophalen.
                if($klantId==0){
                    $insertData = array('klant_dealerId' => $this->dealerId, 'klant_registratieDatum' => date("Y-m-d"));
                    $klantId = $this->crm_klanten->createKlant($insertData);
                }
              
                // save the data no return message
                $this->crm_klanten->updateKlant($klantId, array('klant_'.$veldNaam => $veldWaarde));
            }
        }
        
        // return output
        die(json_encode(array('klantId' => $klantId, 'error' => $error)));
    }
//## KLANT FUNCTIONS    
    
// AUTO FUNCTIONS
    function auto($autoId=false, $mode=false, $extra=false) {  
        $message = '';
        $autoId = (!is_numeric($autoId) || ($autoId=='0') ) ? false : $autoId;
        $this->load->model('crm_klanten');
        $this->load->model('crm_autos');
        $this->load->model('crm_note_files');
        $this->load->model('crm_onderhoud');
        $this->load->model('crm_marketing');
        $this->load->model('crm_facturen');
               
        // bestaande klant controle
        if (!empty($autoId)) { 
            if($this->crm_autos->checkDealerAuto($autoId,  $this->dealerId)==0){
                die('"Auto bestaat niet."');
            }
        } 
        
         // mode switcher
        if($mode) {   
            
            if(strpos($mode, 'pdf_')!== false){
                $factuurId = str_replace('pdf_','',$mode);
                $mode = 'factuurPdf';     
            }
            if(strpos($mode, 'bestand_')!== false){
                $bestandName = str_replace('bestand_','',$mode);
                $mode = 'bestand';     
            }
            switch($mode){
                case 'edit':
                    $this->_bewerk_auto($autoId);
                    exit();
                    break;  
                case 'opmerking':
                    $this->_opmerking($autoId);
                    exit();
                    break;
                case 'onderhoud':
                    $this->_onderhoud($autoId);
                    exit();
                    break;
                 case 'deleteOnderhoud':
                    if(is_numeric($this->input->post('deleteOnderhoud'))) {
                        echo $this->crm_onderhoud->deleteOnderhoud($autoId, $this->input->post('deleteOnderhoud'));
                    }
                    exit();
                    break;
                 case 'deleteBestand':
                    if(is_numeric($this->input->post('deleteBestand'))) {
                        echo $this->crm_note_files->deleteAutoFile($this->bestandenPath, $autoId, $this->input->post('deleteBestand'));
                    }
                    exit();
                    break;   
                case 'deleteNotitie':
                    if(is_numeric($this->input->post('deleteNotitie'))) {
                        echo $this->crm_note_files->deleteNote($this->input->post('deleteNotitie'));
                    }

                    exit();
                    break;                      
                case 'factuur':
                    $this->_createFactuur($autoId);
                    exit();
                    break;
                case 'factuurAanmaken':
                    $data['view']['openFactuur'] = true;

                    break;
                case 'factuurPdf':
                    $this->_factuurPDF($factuurId);
                    exit();
                    break;   
                case 'bestand':
                    $this->_downloadFile($this->bestandenPath.'/'.$bestandName, $bestandName);
                    exit();
                    break;      
                case 'marketingSetting':
                    $this->_marketingSetting('auto', $autoId);
                    exit();
                    break;
                case 'activeSetting':
                    if(is_numeric($this->input->post('auto_actief', true))) { $this->crm_autos->setActive($autoId, $this->input->post('auto_actief', true)); }
                    exit();
                    break;
                case 'upload':
                    $data['view']['uploadMessage'] = $this->_upload('bestand', 'auto', $autoId);
                    break;      
                case 'autoFoto':
                    $message = $this->_upload('autoFoto', $this->input->post('klantId'), $autoId);
                    break;       
                default:
                break;
            }
        }
        
        if($autoId<=0){
            redirect('crm/relaties');	
            exit();
        }
        
        // default action
        $auto =  $this->crm_autos->autoNaarKlant($autoId);

        $auto->auto_kenteken = $this->_formatKenteken($auto->auto_kenteken);
        $auto->auto_foto = ($auto->auto_foto) ? $this->crmDealerUrl.$auto->auto_foto : '';
        
        $this->crm_breadcrumbs->setCrumb(array('step' => 1, 'link' => '/crm/relaties','title' => 'Relaties'));
        $this->crm_breadcrumbs->setCrumb(array('step' => 2, 'link' => '/crm/relatie/'.$auto->klant_id,'title' => $auto->klant_voornaam[0].'. '.(($auto->klant_tussenvoegsel) ? $auto->klant_tussenvoegsel.' ' : '').' '.$auto->klant_achternaam));  
        $this->crm_breadcrumbs->setCrumb(array('step' => 3, 'link' => '/crm/auto/'.$auto->auto_id,'title' => $auto->auto_merk.' '.$auto->auto_type));
            
        
        $data['view']['message'] = $message;
        $data['view']['auto'] = $auto;
        $data['view']['opmerkingen'] = $this->crm_note_files->getNotes($autoId);
        $data['view']['bestanden'] = $this->crm_note_files->getDocumenten('bestand', 'auto', $autoId);
        $data['view']['facturen'] = $this->crm_facturen->getAutoFacturen($this->dealerId, $autoId);
        $data['view']['factuurItems'] = $this->crm_facturen->getDefaultFactuurItems();
        $data['view']['factuurNummer'] = $this->crm_facturen->getNewFactuurNr($this->dealerId);
        $data['view']['onderhoud'] = $this->crm_onderhoud->getOnderhoud($autoId);
        $data['view']['marketingActies'] = $this->crm_marketing->getDealerActiesAndSettings($this->dealerId, 'auto', $autoId);
        
        
          // Build the data for the pages
        $data['leftMenu']['menuActive'] = 'Relaties'; 
        $data['headerData']['jsInclude'][] = 'autos';
        $data['headerData']['jsInclude'][] = 'facturen';
        $data['headerData']['cssInclude'][] = 'autos';
        $data['headerData']['cssInclude'][] = 'facturen';
        $this->_buildPage('auto', $data); 
    }
    
    // auto informatie bewerken
    function _bewerk_auto($autoId){
        $error = '';
        $this->load->model('crm_klanten');
        $this->load->model('crm_autos');
        
        $autoData = $this->input->post('auto');
        $klantId = $this->input->post('klantId');
        $kenteken = $this->input->post('kenteken');
        $kenteken = preg_replace('/[^A-Z0-9]/','',$kenteken);
        
        if (!empty($klantId)) { // bestaande klant
            if($this->crm_klanten->checkDealerKlant($klantId,  $this->dealerId)===false){
                die('"Klant bestaat niet."');
            }
        }
        
// NEED FORM VALIDATION!!!   trim|xss  
   
        $sessionData = $this->session->userdata('kenteken');
        $saveSpecs = $saveAutoData = array();       
        if($sessionData[$kenteken]){
            $sessionAutoData = $sessionData[$kenteken];
            if(is_array($autoData)){
                foreach($autoData as $data){
                    $key = $data['name'];
                    $value = $data['value'];
                    if(empty($sessionAutoData[$key])){
                        if($key == 'verkoopdatum'){
                            $value = date("Y-m-d H:i:s", strtotime($value));
                        }
                        $sessionAutoData[$key] = $value;
                        //echo 'added to: '.$key .' => '.$value."\n";
                    }
                }
            }
            // prepare for saving
            foreach($sessionAutoData as $key => $value){
                if(in_array($key, array('datumaanvangtenaamstelling', 'datumeersteafgiftenederland', 'datumeerstetoelating', 'auto_vervaldatumapk', 'auto_aankoopdatum', 'auto_verkoopdatum', 'vervaldatumapk'))) {	
                    $value = date("Y-m-d H:i:s", strtotime($value));
                }
                $saveAutoData['auto_'.strtolower($key)] = $value;  
            }
            
            unset($saveAutoData['auto_fotos']);
        }
        else{
            die('Geen data opgeslagen?');
        }
        
      // print '<pre>'; print_r($saveAutoData); print '</pre>';exit();

// format saving data BEFORE RDW SESSION DATA
//        $saveSpecs = $saveAutoData = array();
//        if($autoData){
//            foreach($autoData as $key => $autoDetail){
//                if(strpos($autoDetail['name'], 'specificatie')===0) {
//                    $saveSpecs[] = array('specificatie_id' => $specificatieId, 'specificatie_autoId' => $autoId, 'specifcatie_naam' => '', 'specificatie_waarde' => $autoDetail['value']);
//                }
//                else if(strpos($autoDetail['name'], 'kenteken')===0) {
//                    $saveAutoData['auto_'.ucfirst(strtolower($autoDetail['name']))] = preg_replace('/[^A-Z0-9]/','', $autoDetail['value']);
//                }
//                else{
//                    $saveAutoData['auto_'.strtolower($autoDetail['name'])] = $autoDetail['value'];
//                }
//            }
//        }
//### format saving data BEFORE RDW SESSION DATA        

        // Nieuwe auto
        if($autoId===false){	
            // Controle of kenteken al bekend is bij klant
            $search =  array('fieldName' => 'kenteken', 'fieldValue' => $saveAutoData['auto_kenteken']);
            if($this->crm_autos->autosByKlant($klantId, false, $search)){
                 die('Auto was al gekoppeld aan klant' ); //  $
            }
        
            // auto opslaan
            $createAuto = array('auto_klantId' => $klantId, 'auto_actief' => 1, 'auto_registratiedatum' => date("Y-m-d"));
            $autoId = $this->crm_autos->createAuto($createAuto, $this->dealerId);
            
            // prep saving specs
            if($saveSpecs){
                foreach($saveSpecs as $key => $array){
                    $saveSpecs[$key]['specificatie_autoId'] = $autoId;
                    unset($saveSpecs[$key]['specificatie_id']);
                    $this->crm_autos->createSpecifications($saveSpecs[$key]); // Have to use this cause this version of the codeigniter db class doesnt support batch insert
                }
            }
        }
        else{ //update car specifications
            if($saveSpecs){
                foreach($saveSpecs as $key => $array){
                    $specificatieId = $saveSpecs[$key]['specificatie_id'];
                    unset($saveSpecs[$key]['specificatie_id']);
                    $this->crm_autos->updateSpecifications($specificatieId, $data); // Have to use this cause this version of the codeigniter db class doesnt support batch update
                }
            }
        }
        // save picture
        if($saveAutoData['auto_foto']){
            $fileLocation = false;
            if(strpos('http://',$saveAutoData['auto_foto'])===false){ 
                $fileLocation = $this->remoteDealerPath.$saveAutoData['auto_foto'];
            }
            else{
                $fileLocation = $saveAutoData['auto_foto'];
            }
            if($fileLocation){
                $isDir = (is_dir($this->localDealerDir)) ?  true : mkdir($this->localDealerDir, 0777);
                $isDir = (is_dir($this->autoPath)) ?  true : mkdir($this->autoPath, 0777);
                $fotoData = file_get_contents(''.$fileLocation.'');
                if($fotoData){
                    $fp = fopen($this->autoPath.$autoId.'.jpg', 'w');
                    fwrite($fp, $fotoData);
                    fclose($fp);             
                }
                $saveAutoData['auto_foto'] = 'autos/'.$autoId.'.jpg';
            }
        }
       
       
        // update car details
        $this->crm_autos->updateAuto($autoId, $klantId, $saveAutoData);
        $this->session->unset_userdata('kenteken');
        echo 'completed';
        exit();
   
    }
    
    function ongekoppeld($kenteken=false){
        //echo APPPATH ;
        $this->load->model('crm_autos');
        $this->load->model('crm_klanten');
        $autos = $this->crm_autos->getOngekoppeld($this->dealerId);
        $this->crm_breadcrumbs->setCrumb(array('step' => 1, 'link' => '/crm/ongekoppeld','title' => 'Ongekoppeld auto\'s'), true);

        $klanten = $this->crm_klanten->klantenMetAutoInformatie($this->dealerId);
        if(count($klanten)){
            foreach ($klanten as $key => $klantData) {
                unset($klanten[$key]);
                $klanten[$klantData->klant_id]->klant_id = $klantData->klant_id;
                $klanten[$klantData->klant_id]->klant_naam = $klantData->klant_voorvoegsel.' '.$klantData->klant_voornaam.(($klantData->klant_tussenvoegsel) ? ' ' .$klantData->klant_tussenvoegsel : '').' '.$klantData->klant_achternaam;
            }
            $data['view']['klanten'] = $klanten;
        }



        if(count($autos)){
            foreach($autos as $key => $autoData){
                //print '<pre>'; print_r($autoData); print '</pre>';
                $autos[$key]->auto_kenteken = $this->_formatKenteken($autos[$key]->kenteken);
                $autos[$key]->auto_merk_type = $autoData->merk . ' ' . $autoData->type;
                $autos[$key]->auto_kmstand = (($autoData->kilometerstand) ? number_format($autoData->kilometerstand, 0, '.', '.') : $autoData->kilometerstand);
                $autos[$key]->auto_bouwjaar = $autoData->bouwjaar;
                $autos[$key]->auto_archivedate = date("d-m-Y", strtotime($autoData->archived_date));
                
                $fotos = $this->crm_autos->getImobyFoto($autos[$key]->ObjectTiaraID);
                $autoFoto = false;
                if(strpos('http://',$fotos[0]->media_url)){ // false  
                    $autoFoto = $fotos[0]->remote_url;
                }
                else if(!empty($fotos[0]->media_url)) {
                    $autoFoto = $this->remoteDealerDir.$autoData->ObjectTiaraID.'/'.$fotos[0]->media_url;
                }
                $autos[$key]->mediaUrl = $fotos[0]->media_url;
                $autos[$key]->mediaUrl = $fotos[0]->remote_url;
                $autos[$key]->foto = $autoFoto;
                
            }
        }

        // searching
        if (count($_POST)) {
            $autos = $this->_searchAutoArray($autos, $_POST);
        }
        
        $autos = $this->_sortmulti($autos, 'archived_date', 'ASC');
        if($kenteken){
            $data['view']['openKoppelen'] = $kenteken;
        }
        $data['view']['autos'] = $autos;
        
        // Build the data for the pages
        $data['leftMenu']['menuActive'] = "Ongekoppelde auto's"; 
        $data['headerData']['jsInclude'][] = 'autos';
        $data['headerData']['cssInclude'][] = 'autos';
        $this->_buildPage('ongekoppeld', $data); 
         
    }
    
    
// ### AUTO FUNCTIONS

// FACTUREN FUNCTIONS
    function facturen($mode=false){
        $this->load->model('crm_facturen');
 
        
        $this->crm_breadcrumbs->setCrumb(array('step' => 1, 'link' => '/crm/facturen','title' => 'Facturen'), true);
        
        if($_POST['deleteFactuur']){
            $this->crm_facturen->deleteFactuur($this->dealerId, $_POST['deleteFactuur']);
        }
        $allFacturen = $this->crm_facturen->alleFacturenMetKlantData($this->dealerId);
        $facturen = array();
        if($allFacturen){
            $i = 0;
            foreach($allFacturen as $key => $factuurData){
                $deleteFactuur = ($i==0) ? true : false;
                $facturen[] = array(
                    'deleteFactuur' => $deleteFactuur,
                    'factuurId' => $factuurData->factuur_id,
                    'factuurKlantId' => $factuurData->klant_id,
                    'factuurAutoId' => $factuurData->auto_id,
                    'klant_naam' => $factuurData->klant_voornaam.' '.(($factuurData->klant_tussenvoegsel) ? $factuurData->klant_tussenvoegsel.' ' : '' ).$factuurData->klant_achternaam,
                    'klant_adres_woonplaats' => $factuurData->klant_adres.' '.$factuurData->klant_huisnummer.' '.$factuurData->klant_woonplaats,
                    'klant_telefoon' => $factuurData->klant_telefoon,
                    'auto_kenteken' => $this->_formatKenteken($factuurData->auto_kenteken),
                    'factuurOmschrijving' => $factuurData->factuur_omschrijving,
                    'factuurDatum' => $factuurData->factuur_datum
                    );
                    $i++;

            }
        }
                // searching
        if ( ($mode=='zoeken') && count($_POST) ) {
            $facturen = $this->_searchAutoArray($facturen, $_POST);
        }
        

        
        $data = array();
        $data['view']['facturen'] = $facturen;
        $data['leftMenu']['menuActive'] = "Facturen"; 
        $data['headerData']['jsInclude'][] = 'facturen';
        $data['headerData']['cssInclude'][] = 'facturen';
        $this->_buildPage('facturen', $data); 
    }
    
    private function _createFactuur($autoId){
        // check if factuur ID exists
// FORM CHECK
        $error = '';
        $this->load->model('crm_facturen');
        
        if($this->crm_facturen->checkFactuurNr($this->dealerId, $_POST['factuurId'])){
            $error .= "Factuur nummer is al in gebruik.<br />";            
        }
        if($_POST['factuurOmschrijving']==''){
            $error .= "Factuur omschrijving onjuist.<br />\n";
        }
                
        if(is_array($_POST['factuurData'])){
            $factuurItems = array();
            foreach($_POST['factuurData'] as $id => $factuurData) {
                if($_POST['factuurId']==''){
                    $error .= "Factuur nummer onjuist.<br />\n";
                }
                else {
                    $factuurItems[$id]['item_factuurId'] = trim($_POST['factuurId']);
                }
                
                if( ($factuurData['itemAantal']=='') || (!is_numeric($factuurData['itemAantal'])) ){
                    $error .= "Item aantal onjuist.<br />\n";
                }
                else{
                    $factuurItems[$id]['item_aantal'] = $factuurData['itemAantal'];
                }
                
                if( ($factuurData['itemPrijs']=='') || (!is_numeric($factuurData['itemPrijs'])) ){
                    $error .= "Item prijs onjuist.<br />\n";
                }
                else{
                    $factuurItems[$id]['item_stukPrijs'] = $factuurData['itemPrijs'];
                }
                
                if( ($factuurData['itemBtw']=='') || (!is_numeric($factuurData['itemBtw'])) ){
                    $error .= "Item BTW % onjuist.<br />\n";
                }
                else{
                    $factuurItems[$id]['item_btw'] = $factuurData['itemBtw'];
                }
                
                if( ($factuurData['itemNaam']=='') ){
                    $error .= "Item naam onjuist.<br />\n";
                }
                else{
                    $factuurItems[$id]['item_naam'] = $factuurData['itemNaam'];
                }        
            }
        }
        else{
            $error .= "Geen items opgegeven.<br />";
        }
        
        if(empty($_POST['factuurId'])){
            $error .= "Geen factuurId opgegeven.<br />";
        }
        if(empty($_POST['autoId'])){
            $error .= "Geen autoId opgegeven.<br />";
        }
        
        if($error){
            echo die(json_encode(array('error' => $error)));
        }
                
        // create factuur
        $factuur = array(
            'dealerId' => $this->dealerId,
            'factuurId' => trim(strip_tags($_POST['factuurId'])),
            'omschrijving' => trim(strip_tags($_POST['factuurOmschrijving'])),
            'autoId' => $_POST['autoId'], 
            'factuurItems' => $factuurItems 
        );
        $return = $this->crm_facturen->createFactuur($factuur);         
        echo die(json_encode(array('factuurId' => $_POST['factuurId'], 'error' => $error)));
    }
    
  
    
    
    private function _factuurPDF($factuurId){  
        $this->load->model('crm_facturen');  
        $factuur = $this->crm_facturen->getFactuurData($this->dealerId, $factuurId);
        if(!$factuur){
            die('factuur bestaat niet');
        }
        else {
            $isDir = (is_dir($this->facturenPath)) ?  true : mkdir($this->facturenPath, 0777);
            $klantAuto = $this->crm_autos->autoNaarKlant($factuur['factuurData']->factuur_autoId);
            $filePath = $this->facturenPath.$factuurId.'_'.$klantAuto->auto_kenteken.'.pdf';
            if(is_file($filePath)){             
                $this->_downloadFile($filePath, $klantAuto->auto_kenteken);
                exit();
            }
            else{
                //echo 'File does not exist, create, offer download';
                $this->load->model('crm_autos');  
                $this->load->model('crm_dealer');
                $this->load->library('crm_pdf');
                $dealer = $this->crm_dealer->getDealerInfo($this->dealerId);
                
                $factuurRegels = '';
                $factuurBtw = $factuurSubtotaal = $factuurTotaal = 0;
                foreach($factuur['factuurItems'] as $key => $regelDetails){
                    $btw = $regelDetails->item_btw/100;
                
                    $itemPrijs = $regelDetails->item_aantal*$regelDetails->item_stukPrijs;
                    $itemBtw = $itemPrijs*$btw;
                    $itemTotaal = $itemPrijs+$itemBtw;
    
                    $factuurSubtotaal = $factuurSubtotaal+$itemPrijs;
                    $factuurBtw = $factuurBtw+$itemBtw;

                    $factuurRegels .=' <tr>
                        <td style="width: 50px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">'.$regelDetails->item_aantal.'</td>
                        <td style="width: 60px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">&euro;'.$regelDetails->item_stukPrijs.'</td>
                        <td style="width: 300px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">'.$regelDetails->item_naam.'</td>
                        <td style="width: 40px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">'.$regelDetails->item_btw.'%</td>
                        <td style="text-align: right;width: 80px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">&euro;'.number_format($itemTotaal,2).'</td>
                     </tr>';  
                }

                 
                 $factuurItems = '
                 Factuurnummer: '.$factuur['factuurData']->factuur_id.'<br />
                 <table style="width:100%;border-width: 0 0 1px 1px;border-spacing: 0;border-collapse: collapse;border-style: solid;">
                        <tr>
                    		<td style="width: 50px;margin: 0;14.padding: 4px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">Aantal</td>
                    		<td style="width: 60px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">Prijs/stuk</td>
                    		<td style="width: 300px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">Item</td>
                    		<td style="width: 40px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">btw%</td>
                    		<td style="text-align: right;width: 80px;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">Totaal</td>
                    	</tr>
                            '.$factuurRegels.'
                        <tr>
                            <td colspan="4" style="text-align: right;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">Subtotaal:&nbsp;&nbsp;</td>
                            <td style="text-align: right;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">&euro;'.number_format($factuurSubtotaal, 2).'</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">Totaal btw:&nbsp;&nbsp;</td>
                            <td style="text-align: right;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">&euro;'.number_format($factuurBtw, 2).'</td>
                        </tr>
                         <tr>
                            <td colspan="4" style="text-align: right;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">Totaal:&nbsp;&nbsp;</td>
                            <td style="text-align: right;border-width: 1px 1px 0 0;border-style: solid;border-color:#cccccc;">&euro;'.number_format(($factuurSubtotaal+$factuurBtw), 2).'</td>
                        </tr>
                </table>';
                 
//                $replaceTemplateVars = array(
//                    '{BEDRIJFSADRES}'       => $dealer->dealer_bedrijfsnaam,
//                    '{BEDRIJFSADRES}'       => $dealer->dealer_adres,
//                    '{BEDRIJFSHUISNUMMER}'  => $dealer->dealer_huisnummer,
//                    '{BEDRIJFSWOONPLAATS}'  => $dealer->dealer_woonplaats,
//                    '{BEDRIJFSPOSTCODE}'    => $dealer->dealer_postcode,
//                    '{BEDRIJFSKVKNR}'       => $dealer->dealer_kvknr,
//                    '{BEDRIJFSBTWNR}'       => $dealer->dealer_btwnr,
//                    '{BEDRIJFSEMAIL}'       => $dealer->dealer_email,
//                    '{BEDRIJFSTELEFOON}'    => $dealer->dealer_telefoon,
//                    
//                    '{FACTUURREGELS}'       => $factuurItems,
//                    '{FACTUURNUMMER}'       => $factuur['factuurData']->factuur_id
//                );
//                    foreach($replaceTemplateVars as $key => $value){
//                        $html = str_replace($key, $value, $html);
//                    }
//                    //print '<xmp>'; print_r($html); print '</xmp>';               
    
                

                if($dealer->dealer_emailBedrijfsgegevens){
                    $footerHtml = '<table border="0"><tr><td>'.$dealer->dealer_bedrijfsnaam.'<br />'.$dealer->dealer_adres.' '.$dealer->dealer_huisnummer.'<br />'.$dealer->dealer_postcode.' '.$dealer->dealer_woonplaats.'<br />'.$dealer->dealer_telefoon.'</td><td>Rekening: '.$dealer->dealer_rekeningnr.'<br />KvK: '.$dealer->dealer_kvknr.'<br />BTW: '.$dealer->dealer_btwnr.'<br /></td></tr></table>';
                }
                
                $klantAdres = $klantAuto->klant_voornaam.' '.(($klantAuto->klant_tussenvoegsel) ? $klantAuto->klant_tussenvoegsel.' ' : '').' '.$klantAuto->klant_achternaam.'<br />'.$klantAuto->klant_adres.' '.$klantAuto->klant_huisnummer.'<br />'.$klantAuto->klant_postcode.' '.$klantAuto->klant_woonplaats;
                
                $autoGegevens = 'Merk: '.$klantAuto->auto_merk.' '.$klantAuto->auto_type.'<br />Kenteken: '.$this->_formatKenteken($klantAuto->auto_kenteken).'<br />Kilometerstand: '.$klantAuto->auto_kilometerstand;
                
                $textLinks = ($dealer->dealer_factuurtemplate=='links') ? $klantAdres : $autoGegevens;



              
                $textRechts = ($dealer->dealer_factuurtemplate=='links') ?  $autoGegevens : $klantAdres;

               // die("X".PDF_MARGIN_TOP."x");
                        
                $pdf = new crm_pdf('P', 'mm', 'A4', true, 'UTF-8', false);
                if($footerHtml){
                    $pdf->setFooterHtml($footerHtml);
                }//$pdf->setHeaderHtml('<b>123</b>');
                
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                $pdf->SetMargins(10, 10, 10);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(20);
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                $pdf->setPrintHeader(FALSE);
                $pdf->SetFont('times', '', 12);
                $pdf->AddPage();
                //$w, $h, $x, $y
                if($dealer->dealer_factuurtemplate=='rechts'){
                    $pdf->writeHTMLCell(100, 40, 100, 50, $klantAdres, 0, 0, 0, true, 'L', true); 
                    $pdf->writeHTMLCell(70, 40, 10, 50, $autoGegevens, 0, 0, 0, true, 'L', true); 
                    //MultiCell 
                    
                }
                else{
                    $pdf->writeHTMLCell(100, 40, 20, 50, $klantAdres, 0, 0, 0, true, 'L', true);
                    $pdf->writeHTMLCell(50, 40, 150, 50, $autoGegevens, 0, 0, 0, true, 'L', true); 
                }
                
                
                $pdf->writeHTMLCell(190, 40, 10, 100, $factuurItems, 0, 0, 0, true, 'L', true); 
                
                $pdf->lastPage();
                $pdf->Output($filePath, 'F');   
                sleep(2);
                $this->_downloadFile($filePath, $klantAuto->auto_kenteken);          
            }

        }
        // redirect to auto
        
    }

private function _downloadFile($path, $fileName=false){
    if(is_file($path)) {
        if($fileName!==false){
            $fileName = basename($path);
        }
        // required for IE
        if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}
        
        // get the file mime type using the file extension
        switch(strtolower(substr(strrchr($path, '.'), 1))) {
        	case 'pdf': $mime = 'application/pdf'; break;
        	case 'zip': $mime = 'application/zip'; break;
        	case 'jpeg':
        	case 'jpg': $mime = 'image/jpg'; break;
        	default: $mime = 'application/force-download';
        }
        header('Pragma: public'); 	// required
        header('Expires: 0');		// no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
        header('Cache-Control: private',false);
        header('Content-Type: '.$mime);
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($path));	// provide file size
        header('Connection: close');
        readfile($path);		// push it out
        exit();
    
    }
    else{
        die('Bestand bestaat niet.');
    }
}

// ###FACTUREN FUNCTIONS


// MARKETING FUNCTIONS
    function marketing($marketingId=false, $mode=false){
        $data = array();
        $this->load->model('crm_marketing');
        $this->load->model('crm_dealer');
        $this->load->library('form_validation');
        $this->crm_breadcrumbs->setCrumb(array('step' => 1, 'link' => '/crm/marketing','title' => 'Marketing'), true);

        if($mode=='activeSetting'){
            if( is_numeric($marketingId) && is_numeric($_POST['active']) ){
                if($this->crm_marketing->handleMarketingActie($marketingId, $this->dealerId, array('marketing_actief' => $_POST['active']))){
                    echo 'success';
                }
                else{
                    die('Kan marketing actie niet bewerken.');
                }
            }
            else{
                die('Kan marketing actie niet bewerken.');
            }
            exit();
        }

        if($_POST){
            //print '<pre>'; print_r($_POST);  print '</pre>';
            $this->form_validation->set_error_delimiters('<b class="error">', '</b><br />');
            $this->form_validation->set_rules('ids', 'Marketing Id', 'trim|xss_clean|strip_tags|required');
            $this->form_validation->set_rules('actief', 'Actief', 'trim|numeric|required');
            $this->form_validation->set_rules('template', 'Email bericht', 'trim|xss_clean|strip_tags|required');
            $this->form_validation->set_rules('templateSubject', 'Email onderwerp', 'trim|xss_clean|strip_tags|required');
            $this->form_validation->set_rules('templateAanhef', 'Aanhef', 'xss_clean|strip_tags|required');
            $this->form_validation->set_rules('templateAanhefNaam', 'Aanhef naam', 'xss_clean|strip_tags|required');
            $this->form_validation->set_rules('templateAfzender', 'Afzender', 'xss_clean|strip_tags|required');
            $this->form_validation->set_rules('templateAfzenderNaam', 'Afzender naam', 'xss_clean|strip_tags|required');
            $this->form_validation->set_rules('verzendOpDag', 'verzend dag', 'trim|numeric');
            $this->form_validation->set_rules('verzendOpMaand', 'verzend maand', 'trim|numeric');
            $this->form_validation->set_rules('dataveldDagen', 'dagen', 'trim|numeric'); 
            $this->form_validation->set_rules('verzendDataveldOp', 'verzend maand', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('verzend_type', 'verzend maand', 'trim|xss_clean|strip_tags');
            
            if($this->form_validation->run() === FALSE){
                $data['view']['messages'][$this->input->post('ids')] = validation_errors();
                //print '<pre>'; print_r($data['view']['error'][$marketing_ids]);  print '</pre>';
            }
            else{
                
                // Get post data
                $marketing_ids = set_value('ids'); //$this->input->post('ids');
                $ids = explode('_',$marketing_ids);
                $marketingId = $ids[0];
                $defaultActionId =  $ids[1];
                // get default value's'
                $defaultAction = $this->crm_marketing->getDefaultActies(false, $defaultActionId);

                $type = $defaultAction[0]->marketing_type;//$this->input->post('type');
                $actief = set_value('actief');//$this->input->post('actief');
                $title = $defaultAction[0]->marketing_titel;//$this->input->post('title');
                $verzendOp = set_value('verzendOpDag').'-'.set_value('verzendOpMaand');//$this->input->post('verzendOpDag').'-'.$this->input->post('verzendOpMaand');
                $verzend_type = set_value('verzend_type');//$this->input->post('verzend_type');
                $dataveld =  $defaultAction[0]->marketing_dataveld;//$this->input->post('dataveld');
                $dataveldDagen = set_value('dataveldDagen');//$this->input->post('dataveldDagen');
                if(set_value('verzendDataveldOp')){
                    $verzendDataveldOp = (set_value('verzendDataveldOp')=='voor') ? '-' : ''; //$this->input->post('verzendDataveldOp')=='voor')
                }
                else{
                    $verzendDataveldOp = $defaultAction->marketing_verzendOp;
                }
                
                // build sql array
                $marketingActie = array(); 
                $marketingActie['marketing_actief'] = set_value('actief');
                $marketingActie['marketing_type'] = $type;
                $marketingActie['marketing_titel'] = $title;
                $marketingActie['marketing_template'] = set_value('template');
                $marketingActie['marketing_template_subject'] = set_value('templateSubject');
                $marketingActie['marketing_template_aanhef'] = set_value('templateAanhef');
                $marketingActie['marketing_template_aanhef_naam'] = set_value('templateAanhefNaam'); 
                $marketingActie['marketing_template_afzender'] = set_value('templateAfzender'); //$templateSubject;
                $marketingActie['marketing_template_afzender_naam'] = set_value('templateAfzenderNaam'); //$templateSubject;
                $marketingActie['marketing_id'] = $marketingId;
                $marketingActie['marketing_defaultId'] = $defaultActionId;
                $marketingActie['marketing_dealerId'] = $this->dealerId;
                
                if($verzend_type=='verzendDataveld'){ //verzendDataveld
                    $marketingActie['marketing_verzendDataveld'] = $verzendDataveldOp.$dataveldDagen;
                    $marketingActie['marketing_dataveld'] = $dataveld;
                    $marketingActie['marketing_verzendOp'] = ''; 
                }
                else{ // verzendOp
                    $marketingActie['marketing_verzendOp'] = $verzendOp;
                    $marketingActie['marketing_verzendDataveld'] = '';
                    $marketingActie['marketing_dataveld'] = '';
                }
                
                
               // print '<pre>'; print_r($marketingActie);  print '</pre>';exit();
                
                 // Insert or update here.
                $data['view']['messages'][set_value('ids')] =  ($this->crm_marketing->handleMarketingActie($marketingId, $this->dealerId, $marketingActie)) ? 'Marketing Actie Geupdate' :  '<b class="error">Kon de Marketing Actie niet update</b>';
                
            }

        }
        
        // Get all the defined marketing acties
        $acties = array();
        // get dealer acties and see if they have default acties
        $dealerActies = $this->crm_marketing->getDealerActies($this->dealerId);
        
        if(count($dealerActies)){
            $notIds = array();
            foreach($dealerActies as $actie){
                if($actie->marketing_defaultId){
                    $notIds[] = $actie->marketing_defaultId;
                }
            }
        }
        
        $defaultActies = $this->crm_marketing->getDefaultActies($notIds);
        if( is_array($dealerActies) && is_array($defaultActies)){
            $acties = array_merge($dealerActies, $defaultActies);
        }
        else{
            if(is_array($dealerActies)){
                $acties = $dealerActies;
            }
            else if(is_array($defaultActies)){
                $acties = $defaultActies;
            }  
        }
        
        // format some of the data
         if(count($acties)){
            $notIds = array();
            foreach($acties as $actie){
                if($actie->marketing_dataveld){
                    if($actie->marketing_verzendDataveld<0){
                        $actie->marketing_verzendDataveldOp = 'voor';
                    }
                    else if($actie->marketing_verzendDataveld=='0'){
                        $actie->marketing_verzendDataveldOp = 'op';
                    }
                    else{
                        $actie->marketing_verzendDataveldOp = 'na';
                    }
                    $actie->marketing_verzendDataveld = abs($actie->marketing_verzendDataveld);
                }
                else if($actie->marketing_verzendOp){
                    $date = explode('-',$actie->marketing_verzendOp);
                    $actie->marketing_verzendOpDay = $date[0];
                    $actie->marketing_verzendOpMonth = $date[1];
                }
                else {
                    $actie->marketing_verzendOp = true;
                    $actie->marketing_verzendOpDay = '';
                    $actie->marketing_verzendOpMonth = '';
                }
            }
        }
        
        $dealer = $this->crm_dealer->getDealerInfo($this->dealerId);
        $exampleUser = $this->crm_marketing->getRandomCustomer($this->dealerId);
        
         // example user
        if($exampleUser){
            $user = $exampleUser[0];
            //print '<pre>'; print_r($user); print_r($dealer); print '</pre>';
            $exampleArray = array(
                //algemeen
                '{{NONE}}' => '',
                // Klant
                '{{VOORNAAM}}' => $user->klant_voornaam, 
                '{{ACHTERNAAM}}' => $user->klant_achternaam, 
                '{{VOLLEDIGENAAM}}' => $user->klant_voornaam.' '.(($user->klant_tussenvoegsel) ? $user->klant_tussenvoegsel.' ' : '').' '.$user->klant_achternaam,
                // Auto
                '{{MERK}}' => $user->auto_merk, 
                '{{TYPE}}' => $user->auto_type, 
                '{{MODEL}}' => $user->auto_model, 
                '{{KENTEKEN}}' => $user->auto_kenteken, 
                '{{APK-VERVALDATUM}}' => date("d-m-Y", strtotime($user->auto_vervaldatumapk)), 
                // Dealer
                '{{DEALERVOORNAAM}}' => $dealer->dealer_voornaam,
                '{{DEALERACHTERNAAM}}' => $dealer->dealer_achternaam,
                '{{DEALERVOLLEDIGENAAM}}' => $dealer->dealer_voornaam.' '.(($dealer->dealer_tussenvoegsel) ? $dealer->dealer_tussenvoegsel.' ' : '').' '.$dealer->dealer_achternaam,
                
                '{{BEDRIJFSNAAM}}' => $dealer->dealer_bedrijfsnaam, 
                '{{BEDRIJFSTELEFOON}}' => $dealer->dealer_telefoon, 
                '{{BEDRIJFSEMAIL}}' => $dealer->dealer_email, 
            );
            $data['view']['exampleUser'] = json_encode($exampleArray);
        }
        else{
            $data['view']['exampleUser'] = 'null';
        }        
        
        
        // default actie teksten
        $defaultActies = $this->crm_marketing->getDefaultActies($notIds);
        if(is_array($defaultActies)){
            //print '<pre>'; print_r($defaultActies); print '</pre>';
            $defaultText = array();
            foreach($defaultActies as $actie){
                $defaultText[$actie->marketing_defaultId] = array(
                'aanhef'            => $actie->marketing_template_aanhef,
                'aanhef_naam'       => $actie->marketing_template_aanhef_naam,
                'afzender'          => $actie->marketing_template_afzender,
                'afzender_naam'     => $actie->marketing_template_afzender_naam,
                'template'          => $actie->marketing_template,
                'template_subject'  => $actie->marketing_template_subject,
                'verzendOp'         => $actie->marketing_verzendOp,
                'verzendDataveld'   => $actie->marketing_verzendDataveld
                );
            }
            $data['view']['defaultText'] = json_encode($defaultText);
        }
        else{
             $data['view']['defaultText'] = 'null';
        }
        
        $data['view']['acties'] = $acties;
        $data['view']['dealer'] = $dealer;
        // Build the data for the pages
        $data['leftMenu']['menuActive'] = "Marketing"; 
        $data['headerData']['jsInclude'][] = 'marketing';
        $data['headerData']['cssInclude'][] = 'marketing';
        $this->_buildPage('marketing', $data); 
    }
    
    private function _marketingSetting($type, $typeId){
        $marketingId = preg_replace("/[^0-9]/","",$this->input->post('marketingActie'));
        if(!is_numeric($marketingId)) { die('Maketing niet opgeslagen.'); }
        $marketingActief = preg_replace("/[^0-9]/","",$this->input->post('marketingWaarde'));
        if(!is_numeric($marketingActief)) { die('Maketing niet opgeslagen'); }
        
        $this->load->model('crm_marketing');
        echo $this->crm_marketing->setInstellingen($marketingId, $type, $typeId, $marketingActief);
        
    }
// ### MARKETING FUNCTIONS

// Algemene functies
    private function _opmerking($autoId){
        
       
        $error = '';
        $this->load->model('crm_note_files');
        $this->load->library('form_validation');

        $opmerking = $this->input->post('opmerking');
        $opmerkingId = $this->input->post('opmerkingId');
        $this->form_validation->set_rules('opmerking', 'Opmerking', 'trim|xss_clean|strip_tags|required');



        if($this->form_validation->run() === FALSE){
            $error = strip_tags(validation_errors());
        }
        else{
            $opmerking  = set_value('opmerking');
            if(is_numeric($opmerkingId)){  
                if(!$this->crm_note_files->updateNote($autoId, $opmerkingId, $opmerking)){
                    $error = 'Kon notitie niet bewerken.';
                }
            }
            else{
                if(!$this->crm_note_files->saveNote($autoId, $opmerking)){
                    $error = 'Kon notitie niet opslaan.';
                }
            }
            
        }
        die(json_encode(array('autoId' => $autoId, 'error' => $error)));
    }
    
    function _onderhoud($autoId){
        //die(print_r($_POST));
        $error = '';
        $this->load->model('crm_onderhoud');
        $this->load->library('form_validation');

        $opmerking = $this->input->post('onderhoudOpmerking');
        $datum = $this->input->post('onderhoudDatum');
        $onderhoudId = $this->input->post('onderhoudId');
        $kilometerstand = $this->input->post('kilometerstand');
        $onderhoudType = $this->input->post('onderhoudType');
        
        $this->form_validation->set_rules('onderhoudOpmerking', 'Opmerking', 'trim|xss_clean|strip_tags|required');
        $this->form_validation->set_rules('onderhoudDatum', 'Datum', 'trim|xss_clean|strip_tags|required|max_length[16]');
        $this->form_validation->set_rules('onderhoudId', 'OnderhoudId', 'trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('kilometerstand', 'Kilometerstand', 'trim|xss_clean|strip_tags');
        $this->form_validation->set_rules('onderhoudType', 'Type afspraak', 'trim|xss_clean|strip_tags');
        
        $this->form_validation->run();
        if($this->form_validation->run() === FALSE){
            $error = strip_tags(validation_errors());
        }
        else{
            $data = array(
                'onderhoud_text'   => set_value('onderhoudOpmerking'),
                'onderhoud_datum'  => date("Y-m-d H:i:s", strtotime(set_value('onderhoudDatum'))),
                'onderhoud_type'  => set_value('onderhoudType'),
                'onderhoud_kilometerstand'  => set_value('kilometerstand'),   
            );
            if($onderhoudId){
               if(!$this->crm_onderhoud->updateOnderhoud(set_value('onderhoudId'),$autoId, $data)){
                    $error = 'Kon notitie niet opslaan.';
                } 
            }
            else{
                $data['onderhoud_autoId'] = $autoId;
                if(!$this->crm_onderhoud->saveOnderhoud($autoId, $data)){
                    $error = 'Kon notitie niet opslaan.';
                }
            }
        }

        die(json_encode(array('autoId' => $autoId, 'error' => $error)));
    }    
    
    
    

    function _upload($documentType, $documentOwner, $ownerId){
		$this->load->helper('crm_upload');
        $isDir = (is_dir($this->localDealerDir)) ?  true : mkdir($this->localDealerDir, 0777);
   
        if($documentType=='bestand'){
            $isDir = (is_dir($this->bestandenPath)) ?  true : mkdir($this->bestandenPath, 0777);        
            $upload = upload($this->bestandenPath, 'userfile', false, false, array('docx', 'xlsx', 'doc', 'xls', 'png', 'jpg', 'gif'));
            if(is_array($upload)){
                if($upload['error']) {
                    return $upload['error'];
                }
                else{
                    $omschrijving = ($this->input->post('omschrijvingType')=='standaard') ? $this->input->post('standaard') :  $this->input->post('omschrijving');
                    $this->load->model('crm_note_files');
                    
                    if($this->crm_note_files->saveDocument($upload['fileName'], $omschrijving, $documentType, $documentOwner, $ownerId)){
                        return 'Bestand toegevoegd<br />';
                    }
                    else{
                        return 'Bestand kon niet worden toegevoegd<br />';
                    }
                }
            }
            else{
                return $upload;
            }
        }
        
        if($documentType=='autoFoto'){
            $this->load->model('crm_autos');
            $isDir = (is_dir($this->autoPath)) ?  true : mkdir($this->autoPath, 0777); 
            $fileName = $ownerId; // partial, extention gets added by upload script       
            $savedFileName = upload($this->autoPath, 'userfile', $fileName, true, array('png','jpg','gif'),  array('width' => 640, 'height' => 480) );
            if(is_array($savedFileName)){
                if($savedFileName['error']) {
                    echo $savedFileName['error'];
                }
                else{
                    $this->crm_autos->updateAuto($ownerId, $documentOwner, array('auto_foto' => 'autos/'.$savedFileName['fileName']));
                }
            }
            
            // redirect back to auto
            redirect('/crm/auto/'.$ownerId);
        }
        exit();
    }

    // kenteken format
    function _formatKenteken($kenteken){
        $kenteken = strtoupper($kenteken);
        $kenteken = preg_replace('/[^A-Z0-9]/','',$kenteken);
        
        $matchArray = array();
        $matchArray[0] = array('/^[A-Z]{2}[\d]{2}[\d]{2}$/',  array(2,2,2));   //XX-99-99
        $matchArray[1] = array('/^[\d]{2}[\d]{2}[A-Z]{2}$/',  array(2,2,2));   //99-99-XX
        $matchArray[2] = array('/^[\d]{2}[A-Z]{2}[\d]{2}$/',  array(2,2,2));   //99-XX-99
        $matchArray[3] = array('/^[A-Z]{2}[\d]{2}[A-Z]{2}$/', array(2,2,2));   //XX-99-XX
        $matchArray[4] = array('/^[A-Z]{2}[A-Z]{2}[\d]{2}$/', array(2,2,2));   //XX-XX-99
        $matchArray[5] = array('/^[\d]{2}[A-Z]{2}[A-Z]{2}$/', array(2,2,2));   //99-XX-XX
        $matchArray[6] = array('/^[\d]{2}[A-Z]{3}[\d]{1}$/',  array(2,3,1));   //99-XXX-9
        $matchArray[8] = array('/^[A-Z]{2}[\d]{3}[A-Z]{1}$/', array(2,3,1));   //XX-999-X
        $matchArray[7] = array('/^[\d]{1}[A-Z]{3}[\d]{2}$/',  array(1,3,2));   //9-XXX-99
        $matchArray[9] = array('/^[A-Z]{1}[\d]{3}[A-Z]{2}$/', array(1,3,2));   //X-999-XX
            
        foreach($matchArray as $matchData){
            if(preg_match($matchData[0], $kenteken)){
                $start = 0;
                $returnKenteken = '';
                foreach($matchData[1] as $key => $split){
                    $returnKenteken .= substr($kenteken, $start, $split);
                    if($key!=2){
                           $returnKenteken .= '-';
                    }
                    $start += $split;
                }
            }
        }
              
        return $returnKenteken;
    }
    
    function _formatPostcode($postcode){
         return preg_replace('/((?<=[0-9]{4})(?=[a-Z]))/',' ', $postcode);
    }
    // zoek functie
    function zoeken($type=false, $searchValue=false){
        
        $this->load->model('crm_autos');
        if($type=='imobyKentekenAjax'){
            $kenteken = preg_replace('/[^0-9a-zA-Z]/', '', $searchValue);
            $autoData = $this->crm_autos->zoekImobyAjax($kenteken, $this->dealerId);
            if($autoData){
                foreach($autoData as $kenteken){
                    $kenteken->kenteken = $this->_formatKenteken($kenteken->kenteken);
                }
            }
            else{
                $error = 'Auto niet gevonden.';
            }
             //print '<pre>'; print_r($autoData); print '</pre>'; exit();
            die(json_encode(array('autoData' => $autoData, 'error' => $error))); 
        }
        else if($type=='imobyKenteken') {
            $kenteken = preg_replace('/[^0-9a-zA-Z]/', '', $this->input->post('kenteken'));
            $autoData = $this->crm_autos->zoekImoby($kenteken, $this->dealerId);

             if($autoData) {
                $autoFotos = $this->crm_autos->getImobyFoto($autoData->ObjectTiaraID, 3);
                $autoData->kenteken = $this->_formatKenteken($kenteken);
                foreach($autoFotos as $key => $fotoDetails) {
                    $autoFotos[$key]->fotoUrl = false;
                    if(strpos('http://',$fotoDetails->media_url)){ // false  
                        $autoFotos[$key]->fotoUrl = $fotoDetails->remote_url;
                        $autoFotos[$key]->fotoId = $autoData->ObjectTiaraID.'/'.$fotoDetails->media_url;
                    }
                    else if(!empty($fotoDetails->media_url)){
                        $autoFotos[$key]->fotoUrl = $this->remoteDealerDir.$autoData->ObjectTiaraID.'/'.$fotoDetails->media_url;
                        $autoFotos[$key]->fotoId = $autoData->ObjectTiaraID.'/'.$fotoDetails->media_url;
                    }
                    unset($autoFotos[$key]->remote_url);
                    unset($autoFotos[$key]->media_url);
                    unset($autoFotos[$key]->NVMVestigingNR);
                    unset($autoFotos[$key]->object_id);
                }
                
                $autoData->fotos = $autoFotos;
                
             }
             else{
                $error = 'Auto niet gevonden.';
             }
             
             //print '<pre>'; print_r($autoData); print '</pre>'; exit();
            die(json_encode(array('autoData' => $autoData, 'error' => $error)));
        }
        else if($type=='rdwData') {
            $error = '';

//            if($searchValue){
//                $kenteken = preg_replace('/[^0-9a-zA-Z]/', '', $searchValue);
//            }
//            else{}
                $kenteken = preg_replace('/[^0-9a-zA-Z]/', '', $this->input->post('kenteken'));
            
            if(strlen($kenteken)!=6){
                $error = 'Ongeldig kenteken.';
            }
            else{
                // See if we got the data in the session for this kenteken
                $sessionData = false;//(object) $this->session->userdata('kenteken');
               // $kenteken = strtoupper($kenteken);
                if(is_array($sessionData[$kenteken])){
                     $autoData = $sessionData[$kenteken];
                }
                else{
                    $this->session->unset_userdata('kenteken');
                    $autoData = $this->_getRdwData($kenteken);
                    $autoDataIMOBY = $this->crm_autos->zoekImoby($kenteken, $this->dealerId);
                    if( ($autoData) || ($autoDataIMOBY) ){
                        
                        
                        
                        // If we got IMOBY data add the pictures, kmstand, 'prijs', bouwjaar and transmission
                        if($autoDataIMOBY){
                            
                            // If we got IMOBY data but no RDW data, add imoby data, happens if rdw derps
                            if($autoData==''){   
                                 $autoData->merk = $autoDataIMOBY->merk;
                                 $autoData->model = $autoDataIMOBY->model;
                                 $autoData->type = $autoDataIMOBY->type;
                                 $autoData->inrichting = $autoDataIMOBY->carrosserievorm;
                                 $autoData->eerstekleur = $autoDataIMOBY->kleur;
                                 $autoData->hoofdbrandstof = $autoDataIMOBY->brandstof;
                                 $autoData->vervaldatumapk = $autoDataIMOBY->APKdatum;
                                 $autoData->datumeersteafgiftenederland = '';
                                 $autoData->datumaanvangtenaamstelling = '';
                            }
                            
                            // Add imoby data
                            $autoData->kilometerstand = $autoDataIMOBY->kilometerstand;
                            $autoData->transmissie = $autoDataIMOBY->transmissie;
                            $autoData->bouwjaar = $autoDataIMOBY->bouwjaar;
                            $autoData->prijs = $autoDataIMOBY->prijs;
                           
                            
                            // See if we got some pictures
                            $autoFotos = $this->crm_autos->getImobyFotoKenteken($kenteken, $this->dealerId, 3); 
                            foreach($autoFotos as $key => $fotoDetails) {
                            	if(is_numeric($key)){
                            		$autoFotos[$key]->fotoUrl = false;
                            		if(strpos('http:',$fotoDetails->media_url)){  //false  
                            			$autoFotos[$key]->fotoUrl = $fotoDetails->remote_url;
                            			$autoFotos[$key]->fotoId = $autoFotos['ObjectTiaraID'].'/'.$fotoDetails->media_url;
                            		}
                            		else if(!empty($fotoDetails->media_url)){
                            			$autoFotos[$key]->fotoUrl = $this->remoteDealerDir.$autoFotos['ObjectTiaraID'].'/'.$fotoDetails->media_url;
                            			$autoFotos[$key]->fotoId = $autoFotos['ObjectTiaraID'].'/'.$fotoDetails->media_url;
                            		}
                            	}
                            	unset($autoFotos[$key]->remote_url);
                            	unset($autoFotos[$key]->media_url);
                                unset($autoFotos['ObjectTiaraID']);
                                $autoData->fotos = $autoFotos;
                            }
                        }
                        else{
                            $autoData->kilometerstand = '';
                            $autoData->transmissie = '';
                            $autoData->bouwjaar = '';
                            $autoData->prijs = '';
                        }
                        
                        // remove unwanted stuff
                        unset($autoData->Wachtopkeuren);
                        unset($autoData->WAMverzekerdgeregistreerd);
                        unset($autoData->Vermogenbromsnorfiets);
                        
                        $autoData->Kenteken = $this->_formatKenteken($kenteken);
                        $autoData = array_change_key_case((array) $autoData, CASE_LOWER);
                        // save to session 
                        $kenteken = strtoupper($kenteken);
                        $sessionKentekenData = array($kenteken => $autoData);
                        $this->session->set_userdata('kenteken', $sessionKentekenData);
                    }
                    else{

                        $error = 'Auto niet gevonden. '.$kenteken .' '.$autoData ;
                    }
                }
            }
            
            
            if($searchValue){
                print '<pre>';  
                print_r($autoData);
                print_r($this->session->userdata('kenteken'));
                print '</pre>';
            }
            
            die(json_encode(array('autoData' => $autoData, 'error' => $error)));
        }
        else{
            die('Invalid search');
        }
        
    }

    private function _getRdwData($kenteken){

        $format = 'json';
        if(ctype_alnum($kenteken)){;
            
            $accountKey = 'J6m1Nmfm5Svhg8r/FfEWkFrxv/YoReGf9XtoqafWZnw';
            $ServiceRootURL = 'https://api.datamarket.azure.com/Data.ashx/opendata.rdw/VRTG.Open.Data/v1/';
            $WebSearchURL = $ServiceRootURL . 'KENT_VRTG_O_DAT?$format=json&$filter=Kenteken%20eq%20';
            
            $cred = sprintf('Authorization: Basic %s', base64_encode($accountKey . ":" . $accountKey) );
            $context = stream_context_create(array('http' => array('header' => $cred)));
            $request = $WebSearchURL . urlencode( '\''.$kenteken.'\'');
            $response = file_get_contents($request, 0, $context);
            $response = json_decode($response);
           
            $response = $response->d->results[0];
           
            if($response){
                $tmp = explode(';',$response->Handelsbenaming);
                $response->Type = trim(str_replace($response->Merk,'',$tmp[0]));
                $response->Model = trim($tmp[1]);
                $response->Datumaanvangtenaamstelling = date("d-m-Y",preg_replace("/[^0-9]/","",$response->Datumaanvangtenaamstelling)/1000);
                $response->VervaldatumAPK = date("d-m-Y",preg_replace("/[^0-9]/","",$response->VervaldatumAPK)/1000);
                $response->DatumeersteafgifteNederland = date("d-m-Y",preg_replace("/[^0-9]/","",$response->DatumeersteafgifteNederland)/1000);
                $response->Datumeerstetoelating = date("d-m-Y",preg_replace("/[^0-9]/","",$response->Datumeerstetoelating)/1000);
                unset($response->__metadata);
                
            }
            return $response;
           
        }
        else{
            return 'Format error';
        }
    }


    private function _searchAutoArray($search, $post){
       $returnArray = array();
       if(is_array($search)){
            $original = 'array';
        }
        else if(is_object($search)){
            $original = 'object';
        }
         //see how many fields we need to match
        $searchHits = 0;
        foreach ($post as $k => $v) {
             $v = trim($v);
             if (!empty($v)) {
                $searchHits++;
            }
        }
        // if we got fields to match, lets search
        if ($searchHits) {
            foreach ($search as $key => $searchData) {
                
                if(is_array($searchData)){
                    $subOrginal = 'array';
                    $searchData = (object) $searchData;
                } 
                else if(is_object($searchData)){
                    $subOrginal = 'object';
                }
                
                //print '<pre>'; var_dump($searchData); print '</pre>';
                // search options
                $match = 0;
                if ($post['factuurId']) {
                    if (stripos($searchData->factuurId,$post['factuurId']) > -1) {
                        $match++;
                    }
                }
                if ($post['factuurOmschrijving']) {
                    if (stripos($searchData->factuurOmschrijving, $post['factuurOmschrijving']) > -1) {
                        $match++;
                    }
                }
                if ($post['factuurDatum']) {
                    if (stripos($searchData->factuurDatum,$post['factuurDatum']) > -1) {
                        $match++;
                    }
                }
                if (is_numeric($post['klantnr'])) {
                    if ($searchData->klant_id == $post['klantnr']) {
                        $match++;
                    }
                }
                if ($post['naam']) {
                    if (stripos($searchData->klant_naam, $post['naam']) > -1) {
                        $match++;
                    }
                }
                if ($post['adres_woonplaats']) {
                    if (stripos($searchData->klant_adres_woonplaats, $post['adres_woonplaats']) > -1) {
                        $match++;
                    }
                }
                if ($post['telefoonnr']) {
                    if (strpos($searchData->klant_telefoon, $post['telefoonnr']) > -1) {
                        $match++;
                    }
                }
                if ($post['kenteken']) {
                    if (stripos($searchData->auto_kenteken, $post['kenteken']) > -1) {
                        $match++;
                    }
                }
                if ($post['merk_type']) {
                    if (stripos($searchData->auto_merk_type, $post['merk_type']) > -1) {
                        $match++;
                    }
                }
                if ($post['status']) {
                    if (stripos($searchData->auto_actief, $post['status']) > -1) {
                        $match++;
                    }
                }
                if ($post['kmstand']) {
                    if (stripos($searchData->auto_kmstand, $post['kmstand']) > -1) {
                        $match++;
                    }
                }
                if ($post['bouwjaar']) {
                    if (stripos($searchData->auto_bouwjaar, $post['bouwjaar']) > -1) {
                        $match++;
                    }
                }
                if ($post['archived_date']) {
                    if (stripos($searchData->auto_archivedate, $post['archived_date']) > -1) {
                        $match++;
                    }
                }
                
                // return data if it matches the fields we are searching
                if ($match==$searchHits) {
                    $searchData = ($subOrginal == 'array') ? (array) $searchData : (object) $searchData;
                    $returnArray[$key] = $searchData;  
                }      
            }
        }
        else{
            // we've got nothing to search, return all 
            $returnArray = $search;
        }
        return ($original == 'array') ? (array) $returnArray : (object) $returnArray;;
    }
    
    
    
    private function _sortmulti ($array, $index, $order, $natsort=FALSE, $caseSensitive=FALSE) {
        //echo '<b>IN ('.$index.', '.$order.') </b><br />'; print '<pre>';            var_dump($array);            print '</pre>';
        $arrayType = 'array';
        if(is_object($array)) {
            $array = (array) $array;
            $arrayType = 'object';
        }
        
        if(count($array)>0) {
            foreach(array_keys($array) as $key) {
                //
                $keyType = 'array';
                if(is_object($array[$key])) {
                    $array[$key] = (array) $array[$key];
                    $keyType = 'object';
                }
    
                $temp[$key] = $array[$key][$index];
                
                if(!$natsort) {
                    if ($order=='asc'){
                        asort($temp);
                    }
                    else {   
                        arsort($temp);
                    }
                }
                else {
                    if ($caseSensitive===true){
                        natsort($temp);
                    }
                    else{
                        natcasesort($temp);
                    }
                    if($order!='asc') {
                        $temp = array_reverse($temp,TRUE);
                    }
                }
            }
            foreach(array_keys($temp) as $key) {
                if (is_numeric($key)){
                    if($keyType=='object'){
                        $array[$key] = (object) $array[$key];
                    }
                    $sorted[] = $array[$key];
                }
                else {
                    $sorted[$key] = $array[$key];
                    if($keyType=='object'){
                        $sorted[$key] = (object) $sorted[$key];
                    }
                }
            }
            
            if($arrayType=='object') {
                $sorted = (object) $sorted;
            }

            //echo '<b>OUT</b><br />'; print '<pre>';            var_dump($sorted);            print '</pre>';
            return $sorted;
        }
        
        if($arrayType=='object') {
            $sorted = (object) $sorted;
        }
       
        return $sorted;
    }

    function _regexValidation($fieldName, $fieldValue, $regex = false){
        $veldValidaties = array(
            'aanhef'            => '/^[a-z0-9 .\-]+$/i', //'/^[a-zA-Z ]$/',
            'voornaam'          => '/^[a-z0-9 .\-]+$/i', //'/^[a-zA-Z- ]$/',
           // 'tussenvoegsel'     => '/^[a-z0-9 .\-]+$/i', //'/^[a-zA-Z- ]$/',
            'actief'            => '/^[0-9]{1}$/',
            'postcode'          => '/^[0-9]{4}\s{1}[A-Z]{2}$/'  /* '/^[0-9]{4}[a-zA-Z]{2}$/' */
        );
        if( ($veldValidaties[$fieldName]) && ($fieldValue) ) {
            $doRegex = ($regex) ? $regex : $veldValidaties[$fieldName];
            if (preg_match($doRegex, $fieldValue)) {
                return true; // match and valid
            }
            else {
                return ucfirst($fieldName).' heeft niet het juiste formaat.';
            } 
        }
        else{ // havent got the regex or a fieldValue, so true.
            return true;
        }
    }
     
// LAYOUT FUNCTIONS

    function _buildMenu($active) {

        // get items from db
        $menuItems = array();
        $menuItems['Relaties'] = array('link' => BASE.'crm/relaties', 'active' => false);
        $menuItems['Facturen'] = array('link' => BASE.'crm/facturen', 'active' => false);
        $menuItems['Marketing'] = array('link' => BASE.'crm/marketing', 'active' => false);
        $menuItems["Ongekoppelde auto's"] = array('link' => BASE.'crm/ongekoppeld', 'active' => false);
        //$menuItems['Something'] = array('link' => BASE.'crm/something', 'active' => false);
        if($menuItems[$active]){
            $menuItems[$active]['active'] = true;
        }
        return $menuItems;
    }
    
    
    // Handle the main build
    function _buildPage($view, $data){  
        $data['leftMenu']['menuItems'] = $this->_buildMenu($data['leftMenu']['menuActive']);
        $data['leftMenu']['breadcrumbs'] = $this->crm_breadcrumbs->displayBreadcrumbs();
        
        //dirty but works
        $this->load->model('crm_dealer');
        $imobyMobileCode =  $this->crm_dealer->getMobileCode($this->dealerId);
        $data['headerData']['imobyMobileCode'] = $imobyMobileCode;
        $data['headerData']['active'] = ($data['headerData']['active']) ? $data['headerData']['active'] : 'Relaties';
        $this->load->view('crm/header', $data['headerData']);     
        $this->load->view('crm/leftMenu', $data['leftMenu']);
        $this->load->view('crm/'.$view, $data['view']); 
        $this->load->view('crm/footer', $footerData); 
    }
    
//## LAYOUT FUNCTIONS    
}

?>