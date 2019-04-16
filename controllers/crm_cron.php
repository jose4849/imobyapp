<?php

class crm_cron extends Controller{
    private $debug;
    function __construct(){
        parent::__construct();
        if($_SERVER['REMOTE_ADDR']!='86.94.132.162'){ // server ip, then die
            die('access denied');
        }
        $this->debug = 2;
    }


    function index(){
        if($this->debug==2){
            echo '<style>pre { height:200px;overflow:auto;border:1px solid gray; }</style>';
        }
        
       // $this->getMarketingActies();
       
       $this->autoUitVoorraad();
    }
    
    function autoUitVoorraad(){
        $this->load->model('crm_dealer');
        $dealers = $this->crm_dealer->CRON_getDealers();
        if($dealers){
            foreach($dealers as $key => $dealerInfo) {
                if($dealerInfo->dealer_email_uitvoorraad) {
                    $this->checkUitVoorraad($dealerInfo);
                    if($this->debug=='2') {
                        print '<pre>$dealerInfo:<br />'; print_r($dealerInfo); print '</pre>';
                    }
                }
            }
        }
    }
    
    function checkUitVoorraad($dealerInfo) {
        $this->load->model('crm_autos');
        $autos = $this->crm_autos->getOngekoppeld($dealerInfo->dealer_nvmId, '2013-10-30');//'.date("Y-m-d").'
        if($this->debug=='2') {
            print '<pre>$autos:<br />'; print_r($autos); print '</pre>';
        }
        if($autos){
            foreach($autos as $auto) {
                $mailData = $bodyData = (object) array();
                $image = $this->crm_autos->getImobyFoto($auto->ObjectTiaraID);
                $bodyData->uitvoorraadDatum = date("d-m-Y", strtotime($auto->archived_date));
                $bodyData->kenteken = $this->_formatKenteken($auto->kenteken);
                $bodyData->MerkType = $auto->merk.' '.$auto->type; 
                if($image[0]->media_url){
                    $bodyData->autoImage = 'http://app.imoby.nl/fileserver/bofiles/downloads/'.$dealerInfo->dealer_nvmId.'/'. $auto->ObjectTiaraID.'/'.$image[0]->media_url;
                }
                else{
                    $bodyData->autoImage =  'http://app.imoby.nl/crmAssets/images/placeholder75x100.png';
                }
                $mailData->emailTo = $dealerInfo->dealer_email;
                $mailData->emailToName = $dealerInfo->dealer_bedrijfsnaam;
                $mailData->subject = 'Auto uit voorraad';
                $mailData->body = $this->load->view('../../email/uitvoorraad', $bodyData, true); 
                if($this->debug=='2') {
                   echo $mailData;
                }
                $this->_sendDealerMail((array) $mailData);
                return;
            }
        }   
    }

    
    private function _sendDealerMail($mailData){
        
        if($this->debug) {
            print '<b> _sendDealerMail</b><br />';
        }
        
        $this->load->library('email');
        $config = array();
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $checkForEmpty = array_search("", $mailData);
        
        if($checkForEmpty===false) {
            if($this->debug) {
                $mailData['emailTo'] = 'stefan.de.vries@cre8it.nl';
                //$mailData['emailTo'] = 'redouan@imoby.nl';
                //$mailData['emailTo'] = 'frank.pietersen@cre8it.nl';
            }
            
            $this->email->to($mailData['emailTo'], $mailData['emailToName']);
            $this->email->from('info@imoby.nl', 'Imoby.nl');           
            $this->email->subject($mailData['subject']);
            $this->email->message($mailData['body']);
            //$this->email->send();
            if($this->debug) {
                echo 'Send mail<br />';
                if($this->debug==2) {
                    print '<pre>$mailData:<br />'; print_r($mailData); print '</pre>';
                }
            }
        
        }
        else{
            if($this->debug) {
                echo 'Kan mail niet verzenden '.$checkForEmpty.' is leeg <br />';
                echo $this->email->print_debugger().'<br />';
            }
        }
        if($this->debug) {
            echo '<hr>';
        }    
    }
    
    
 ///*** MARKETING ACTIES ***///   
    
    function getMarketingActies(){

        if($this->debug) {
            echo '<b> 1.&nbsp;&nbsp;getMarketingActies</b><br />';
        }
        $this->load->model('crm_marketing');
        
        // get active marketing acties
        $marketingActies = $this->crm_marketing->CRON_getDealerActies();
        if($this->debug) {
            echo count($marketingActies).' active found</br />';
        }
        // get subject active settings for each marketing actie
        if($marketingActies){
            foreach($marketingActies as $key => $actieData){
                if($this->debug=='2') {
                    print '<pre>actieData:<br />'; print_r($actieData); print '</pre>';
                }
                
                if($actieData->marketing_verzendOp){
                    if($actieData->marketing_verzendOp != date("j-n")) {
                        if($this->debug) {
                            echo $actieData->marketing_verzendOp.' is niet vandaag ('.date("j-n").'), skip actie. <br />';
                        }
                        break;
                    } 
                }
                
                $klantenSettings = $this->crm_marketing->CRON_getSettings($actieData->marketing_id);
                // run individual action per subject
                foreach($klantenSettings as $klantSetting){
                    // If the customer marketing setting is 1 run amarketing actie
                    if($klantSetting->marketing_inst_actief){
                        $this->_runActie($actieData, $klantSetting);
                    }
                }
                
                // Update last run time.
                $this->crm_marketing->handleMarketingActie($actieData->marketing_id, $actieData->marketing_dealerId, array('marketing_lastRun' => date("Y-m-d H:i:s")));
            }
        }
    }


    private function _runActie($actieData, $klantSetting){
        
        $this->load->model('crm_dealer');
        $this->load->model('crm_klanten');
        $this->load->model('crm_autos');
        
        if($this->debug) {
            echo '<b>_runActie '.$actieData->marketing_titel.'</b><br />';
        }
        
        if($actieData->marketing_type=='klant'){
            $klant = $this->crm_klanten->klantMetAutoInformatie($klantSetting->marketing_inst_typeId);
        }
        else if(($actieData->marketing_type=='auto') || ($actieData->marketing_type=='auto_onderhoud') ){
            $klant = $this->crm_autos->autoNaarKlant($klantSetting->marketing_inst_typeId);
        }


        if($this->debug=='2') {
            print '<pre>$klant:<br />'; print_r($klant); print '</pre>';
        }
        
        // See if the subject is active and wants to be contacted
        if( ($klant->klant_actief) && ($klant->klant_marketing) ) {
            $sendMail = false;
            if($this->debug) {
                echo 'Klant is actief en wil marketing acties <br />';
            }
            
            // send on specific date
            if(preg_match('/^[0-9]{1,2}-[0-9]{1,2}$/', $actieData->marketing_verzendOp)){ 
                if($this->debug) {
                    echo 'Send on specific date '.$actieData->marketing_verzendOp.' <br />';
                }
                if(date("j-n") == $actieData->marketing_verzendOp){
                    if($this->debug) {
                        $sendMail = true;
                        echo 'Yes, date is today, send email to customer!!!<br />';
                    }
                }
            }
            else{ // send using a specific database table field.
                if($this->debug) {
                    echo 'Send '.$actieData->marketing_verzendDataveld.' from '.$actieData->marketing_dataveld.' <br />';
                }
                
                // days from database table field 
                $days = ($actieData->marketing_verzendDataveld>0) ? '+'.$actieData->marketing_verzendDataveld : $actieData->marketing_verzendDataveld;
                
                // select right database table
                if($actieData->marketing_type=='auto_onderhoud'){ // specific type of db table
                    $this->load->model('crm_onderhoud');
                    if($this->debug) {
                        echo 'Select onderhoudhistory <br />';
                    }
                    $onderhoud = $this->crm_onderhoud->getOnderhoud($klantSetting->marketing_inst_typeId);
        
                    if(count($onderhoud)){
                        $dateFormat = "m-d";
                        foreach($onderhoud as $onderhoudData){
                            $sendDate = date($dateFormat, strtotime($onderhoudData->onderhoud_datum.' '.$days.' days'));
                            if($this->debug) {
                                echo 'klant '.$actieData->marketing_dataveld.' = '.$onderhoudData->onderhoud_datum.', '.$days.' = '.$sendDate.'<br />';
                            }
                            if($sendDate==date($dateFormat)){
                                if($this->debug) {
                                    $sendMail = true;
                                    echo 'Yes, date meets criteria, send email to customer!!!<br />';
                                    break;
                                }
                            } 
                            else{
                                if($this->debug){
                                    echo $sendDate." is not date ".date($dateFormat)." so dont send<hr />";
                                }
                            }
                        }
                    }
                    else{
                        if($this->debug) {
                           echo 'Gebruiker -> auto heeft geen onderhoud. <br />';
                        }
                    }
                   // print '<pre>';  print_r($klantSetting);  print_r($onderhoud); print '</pre>';    

                     
                   // exit();                
                }
                else{ // auto or klant related
                    $klantDataVeldDatum = $klant->{$actieData->marketing_dataveld};
                    if($klantDataVeldDatum!=''){
                        
                        $dateFormat = ($actieData->marketing_dataveld=='klant_geboortedatum') ? 'm-d' : 'Y-m-d';
                        $sendDate = date($dateFormat, strtotime($klantDataVeldDatum.' '.$days.' days'));
                        if($this->debug) {
                            echo 'klant '.$actieData->marketing_dataveld.' = '.$klantDataVeldDatum.', '.$days.' = '.$sendDate.'<br />';
                        }
                        if($sendDate==date($dateFormat)){
                            if($this->debug) {
                                $sendMail = true;
                                echo 'Yes, date meets criteria, send email to customer!!!<br />';
                            }
                        } 
                        else{
                            if($this->debug){
                                echo $sendDate." is not date ".date($dateFormat)." so dont send<hr />";
                            }
                        }
                    }
                    else{
                        if($this->debug){
                             echo '$klantDataVeldDatum is leeg:<br />klant '.$actieData->marketing_dataveld.' = '.$klantDataVeldDatum.', '.$days.' = '.$sendDate.'<hr />';
                        }  
                    }
                }
            } 
            
            // get dealer data and prepare the mail
            if($sendMail){
                $dealer = $this->crm_dealer->getDealerInfo($actieData->marketing_dealerId);
                if($this->debug==2) {
                    print '<pre>$dealer:<br />'; print_r($dealer); print '</pre>';
                }
                $mail = array();
                $mailBody = $this->replaceAanhef($klant, $actieData->marketing_template_aanhef, $actieData->marketing_template_aanhef_naam);
                $mailBody .= $this->replaceBody($dealer, $klant, $actieData->marketing_template);
                $mailBody .= $this->replaceAfzender($dealer, $actieData->marketing_template_afzender, $actieData->marketing_template_afzender_naam);
	
                $mail['body'] = $mailBody; 
                $mail['subject'] = strip_tags($this->replaceBody($dealer, $klant, $actieData->marketing_template_subject));//$this->replaceVars($dealer, $klant, $actieData->marketing_template_subject);
                $mail['emailTo'] = $klant->klant_email;
                $mail['emailToName'] = $klant->klant_voornaam.' '.(($klant->klant_tussenvoegsel) ? $klant->klant_tussenvoegsel.' ' : '' ).$klant->klant_achternaam;
                $mail['emailFrom'] = $dealer->dealer_email;
                $mail['emailFromName'] = $dealer->dealer_voornaam.' '.(($dealer->dealer_tussenvoegsel) ? $dealer->dealer_tussenvoegsel.' ' : '' ).$dealer->dealer_achternaam;
                $this-> _sendMarketingMail($mail);
            } 
        }
    }

    private function _sendMarketingMail($mailData){
        
        if($this->debug) {
            print '<b> _sendMarketingMail</b><br />';
        }
        
        $this->load->library('email');
        $config = array();
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $checkForEmpty = array_search("", $mailData);
        
        if($checkForEmpty===false) {
            if($this->debug) {
                $mailData['emailTo'] = 'stefan.de.vries@cre8it.nl';
                $mailData['emailFrom'] = 'stefan.de.vries@cre8it.nl';
            }
            
            $this->email->to($mailData['emailTo'], $mailData['emailToName']);
            $this->email->from($mailData['emailFrom'], $mailData['emailFromName']);           
            $this->email->subject($mailData['subject']);
            $this->email->message($mailData['body']);
            $this->email->send();
            if($this->debug) {
                echo 'Send mail<br />';
                print '<pre>$mailData:<br />'; print_r($mailData); print '</pre>';
            }
        
        }
        else{
            if($this->debug) {
                echo 'Kan mail niet verzenden '.$checkForEmpty.' is leeg <br />';
                echo $this->email->print_debugger().'<br />';
            }
        }
        if($this->debug) {
            echo '<hr>';
        }
        
    }
    
    private function replaceBody($dealer, $klant, $message) {
        if(trim($message)) {
            if(strpos($message, '{{XXE}}')!==false){
                $birthDate = explode("-", $klant->klant_geboortedatum);
                $leeftijd = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[0])).'e';
            }
            else{
                $leeftijd = 0;
            }
            
    
            $vars = array();
            // Klant
            $vars[0] = '/{{AANHEF}}/';
            $vars[1] = '/{{VOORNAAM}}/';
            $vars[2] = '/{{TUSSENVOEGSEL}}/';
            $vars[3] = '/{{ACHTERNAAM}}/';
            $vars[4] = '/{{XXE}}/';
            $vars[5] = '/{{MERK}}/';
            $vars[6] = '/{{TYPE}}/';
            $vars[7] = '/{{MODEL}}/';
            $vars[8] = '/{{KENTEKEN}}/';
            $vars[9] = '/{{APKVERVALDATUM}}/';
            
            //Dealer
            $vars[10] = '/{{BEDRIJFSNAAM}}/';
            $vars[11] = '/{{BEDRIJFSADRESS}}/';
            $vars[12] = '/{{BEDRIJSHUISNUMMER}}/';
            $vars[13] = '/{{BEDRIJFSWOONPLAATS}}/';
            $vars[14] = '/{{BEDRIJFSTELEFOON}}/';
            $vars[15] = '/{{BEDRIJFSGEGEVENS}}/';
            $vars[16] = '/{{BEDRIJFSEMAIL}}/';
            $vars[17] = '/{{DEALERVOLLEDIGENAAM}}/';
            

            
            $replacements = array();
            // Klant
            $replacements[0] = $klant->klant_aanhef;
            $replacements[1] = $klant->klant_voornaam;
            $replacements[2] = $klant->klant_tussenvoegsel;
            $replacements[3] = $klant->klant_achternaam;
            $replacements[4] = $leeftijd;
            $replacements[5] = $klant->auto_merk;
            $replacements[6] = $klant->auto_type;
            $replacements[7] = $klant->auto_model;
            $replacements[8] = $klant->auto_kenteken;
            $replacements[9] = date("d-m-Y",strtotime($klant->auto_vervaldatumapk));
            
            //Dealer
            $replacements[10] = $dealer->dealer_bedrijfsnaam;
            $replacements[11] = $dealer->dealer_adres;
            $replacements[12] = $dealer->dealer_huisnummer;
            $replacements[13] = $dealer->dealer_woonplaats;
            $replacements[14] = $dealer->dealer_telefoon;
            $replacements[15] = '<table border="0" cellpadding="20" style="width: 620px;">
            <tr>
            <td valign="top" style="width: 120px;"><b>&nbsp;Bedrijfsgegevens:</b></td>
            <td style="color:#A2A2A2;width: 250px;">'.$dealer->dealer_bedrijfsnaam.'<br />'.$dealer->dealer_adres.' '.$dealer->dealer_huisnummer.'<br />'.$dealer->dealer_postcode.' '.$dealer->dealer_woonplaats.'</td>
            <td style="color:#A2A2A2;width: 250px;">Tel: '.$dealer->dealer_telefoon.'<br />Email: '.$dealer->dealer_email.'<br />Website: </td>
            </tr></table>';
            $replacements[16] = $dealer->dealer_email;
            $replacements[17] = $dealer->dealer_voornaam.' '.(($dealer->dealer_tussenvoegsel) ? $dealer->dealer_tussenvoegsel.' ' : '').' '.$dealer->dealer_achternaam;
             
             
            $message = preg_replace($vars, $replacements, $message);
            if($this->debug) {
                echo 'Result:<br />'.nl2br($message).'<br />';
            }
        }
        else{
             if($this->debug) {
                 echo 'message is empty, nothing to replace.';
             }
        }
       
       return nl2br($message);
    }
    
    private function replaceAanhef($klant, $aanhef, $aanhefNaam){
        //Aanhef
        $returnAanhef = '';
        if($aanhef!='Geen aanhef'){
            $vars = array('/Geachte heer\/mevrouw/', '/Beste/', '/Geen aanhef/');
            $replacements = array('Geachte heer/mevrouw', 'Beste', '');  //'.$klant->klant_aanhef
            
            $returnAanhef = preg_replace($vars, $replacements, $aanhef);
            $returnAanhef .= ($aanhefNaam!='{{NONE}}') ? ' ' : ', ';
        }
        // AanhefNames
        $vars = array('/{{ACHTERNAAM}}/', '/{{VOORNAAM}}/', '/{{VOORNAAM}} {{ACHTERNAAM}}/', '/{{NONE}}/');
        $replacements = array($klant->klant_achternaam, $klant->klant_voornaam, $klant->klant_voornaam.' '.$klant->klant_achternaam, '');
        $returnAanhef .= preg_replace($vars, $replacements, $aanhefNaam);
         
        if(($aanhef=='Geen aanhef') && ($aanhefNaam=='{{NONE}}')){
            return '';
        }
        return $returnAanhef.', <br /><br />';
    }
    
    
    
    private function replaceAfzender($dealer, $afzender, $afzenderNaam){
        //Afzender
        $returnAfzender = ($afzender!='Geen afsluiting') ? $afzender.'' : '';  
        if(($returnAfzender) && ($afzenderNaam!='{{NONE}}') ){
            $returnAfzender .= ',<br />';
        }  
    
        // AfzenderNames
        $dealerVolledigeNaam = $dealer->dealer_voornaam.' '.(($dealer->dealer_tussenvoegsel) ? $dealer->dealer_tussenvoegsel.' ' : '').' '.$dealer->dealer_achternaam;
        $vars = array('/{{DEALERACHTERNAAM}}/', '/{{DEALERVOORNAAM}}/', '/{{DEALERVOORNAAM}} {{DEALERACHTERNAAM}}/', '/{{NONE}}/', '/{{BEDRIJFSNAAM}}/', '/{{DEALERVOLLEDIGENAAM}}/');
        $replacements = array($dealer->dealer_achternaam, $dealer->dealer_voornaam, $dealer->dealer_achternaam.' '.$dealer->dealer_achternaam, '', $dealer->dealer_bedrijfsnaam, $dealerVolledigeNaam);
        
        $returnAfzender .= preg_replace($vars, $replacements, $afzenderNaam);
    
        if(($afzender=='Geen afsluiting') && ($afzenderNaam=='{{NONE}}')){
            return '';
        }
        return '<br /><br />'.$returnAfzender;
    }
     
     
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
}
    
?>