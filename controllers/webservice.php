<?php
/**
 * Description of webservice
 *
 * @author HIMEL
 */
 
//error_reporting(0);
class Webservice extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }


// TEMP MONITORING

private function returnData($data){
    $return = '';
    foreach($data as $key => $value){
        if(is_array($value)){
            $return .=  $key.'='.returnData($value)."\n";
        }
        else{
            $value = str_replace("&lt;", "<", str_replace("&gt;", ">",$value)); 
            $return .= $key.'='.$value."\n";  
        }
    }
    return $return;
}   

private function mailDebug($textmessage){
   
    $mime_boundary=md5(time());
    $headers = '';
    $headers .= 'From: support@imoby.nl <support@imoby.nl>' . "\n";
    $headers .= 'MIME-Version: 1.0'. "\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"". "\n"; 
    $msg = '';
    $msg .= "--".$mime_boundary. "\n";
    $msg .= "Content-Type: text/plain; charset=iso-8859-1". "\n";
    $msg .= "Content-Transfer-Encoding: 7bit". "\n\n";
    $msg .= $textmessage . "\n\n";
     
    mail('stefan.de.vries@cre8it.nl', 'IMOBY:'.$_POST['uid'], $msg.$this->logfile, $headers);
}
    
   // mailDebug(returnData($_POST));

// TEMP MONITORING
    
    public function index(){
        $this->load->model('muser');
        $this->load->model('msocialmedia');
        
                
        //logfiles
        if ($_SERVER['SERVER_ADDR']=="10.0.0.20"){
            $servername="APP1";
        } else if ($_SERVER['SERVER_ADDR']=="10.0.0.21"){
            $servername="APP2";
        }else{
            $servername="UNKNOWN";
        }
        
        //oude logfiles verwijderen
       	for ( $counter = 1; $counter <= 5; $counter ++) {
       	    $dag=(date("d") + $counter);
            if ($dag>31){
                $dag=$dag-31;
            }
            $logfile='/home/imoby/domains/app.imoby.nl/public_html/logs/'.$dag.'-'.$servername.'.txt';
            if (file_exists($logfile)){
                unlink($logfile);
            }
        }
       

         
        $logfile='/home/imoby/domains/app.imoby.nl/public_html/logs/'.date("d").'-'.$servername.'.txt';
        $this->logfile = $logfile;
        //start log bij aanroep 
        file_put_contents($logfile, date("Y-m-d H:i:s")."\n",FILE_APPEND);

        if((!empty($_POST['data'])) && (!empty($_POST['uid']))){
            //$xmlStr = str_replace("&lt;", "<", str_replace("&gt;", ">",$_POST['data']));   
            $xmlStr = str_replace("&lt;?xml", "<?xml", str_replace('utf-8"?&gt;', 'utf-8"?>',$_POST['data']));  
            $NVMVestigingNR = $_POST['uid'];
            $ObjectTiaraID = $_POST['oid'];
            file_put_contents($logfile, " NVMvestiging: ".$NVMVestigingNR." - ObjectTiaraID: ".$ObjectTiaraID."\n",FILE_APPEND);
            
            
            
 // TEMP MONITORING    
 /*       
$users =  array('97241', '94808', '92410', '103123', '92410', '84027'); 
if(in_array($_POST['uid'], $users)) {
    $xmlStrFixed = str_replace("&lt;?xml", "<?xml", str_replace('utf-8"?&gt;', 'utf-8"?>',$_POST['data']));  
    file_put_contents('wstest/xmls/'.$NVMVestigingNR.'_'.$ObjectTiaraID.'_'.date('Y-m-d H_i_s').'_post.xml', print_r($_POST, true)); 
    file_put_contents('wstest/xmls/'.$NVMVestigingNR.'_'.$ObjectTiaraID.'_'.date('Y-m-d H_i_s').'_data_raw.xml', $_POST['data']);  
    file_put_contents('wstest/xmls/'.$NVMVestigingNR.'_'.$ObjectTiaraID.'_'.date('Y-m-d H_i_s').'_data_normal.xml', $xmlStr);
    if($_POST['uid']!='84027'){
        file_put_contents('wstest/xmls/'.$NVMVestigingNR.'_'.$ObjectTiaraID.'_'.date('Y-m-d H_i_s').'_data_fixed.xml', $xmlStrFixed);
        $xmlStr = $xmlStrFixed;
        file_put_contents($logfile, " Apply fix\n",FILE_APPEND);
    }
    
}  
 */       
// TEMP MONITORING           
            
            
            
            //$failed = '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>99</code><omschrijving>Fout bij publiceren voertuig!!!</omschrijving></status></antwoord>';
//            echo $failed;
//            die();
            
            
            //if user exist
            $existUser = $this->muser->agency_code_exist($_POST['uid']);
            if(!empty($existUser)){
                
                //parse xml string
                $data = $this->readcarXml($xmlStr);
                if(!$data){
                    file_put_contents($logfile, " Geen data uit XML file\n",FILE_APPEND); 
                }
               
                // when object directory not exist
                if (!is_dir('fileserver/bofiles/downloads/' . $NVMVestigingNR . '/' . $ObjectTiaraID)) {
                    file_put_contents($logfile, " Object directory bestaat niet\n",FILE_APPEND);
                    if (mkdir('fileserver/bofiles/downloads/' . $NVMVestigingNR . '/' . $ObjectTiaraID, 0777)) {
                        file_put_contents($logfile, " Object directory aangemaakt\n",FILE_APPEND);
                        //try to save xml file
                        try {
                            
                            if ((!empty($NVMVestigingNR)) && (!empty($ObjectTiaraID))) {
                                $success = '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>00</code><omschrijving>Advertentie goed verwerkt</omschrijving></status></antwoord>';
                                echo $success;
                                file_put_contents($logfile, " Succes returned\n",FILE_APPEND);
                                $this->load->model('mcar_specs');
                                $this->load->model('mobjectmedia');
                                $this->load->model('mmediaqueue');
                                $this->load->model('mcar_uitvoeringens');
                                $this->load->model('mcar_uitrustings');
                                $this->load->model('mcar_manufacturers');
                                $this->load->model('mcar_man_packs');
                                $this->load->model('mcar_additional_features');

                                //save car specification
                                $car_object = $this->save_car_object($NVMVestigingNR, $ObjectTiaraID,$data);
                                $car_id = $this->mcar_specs->save_car_spec($data,$NVMVestigingNR,$ObjectTiaraID);
                                file_put_contents($logfile, " car_id ".$car_id."\n",FILE_APPEND);
                               
                                if (!empty($data['foto_urls'])) {
                                    file_put_contents($logfile, " Saving foto_urls\n",FILE_APPEND);
                                        foreach ($data['foto_urls'] as $key => $value) {
                                            $carImage = array();
                                            $carImage['NVMVestigingNR'] = $NVMVestigingNR;
                                            $carImage['object_id'] = $ObjectTiaraID;
                                            $carImage['media_group'] = "";
                                            $carImage['media_url'] = mysql_real_escape_string($value);
                                            $carImage['mediaomschrijving'] = "";
                                            $carImage['mediaupdate'] = date('Y-m-d');
                                            $carImage['laatstewijziging'] = date('Y-m-d H:i:s');
                                            
                                            $saved_Media = $this->mobjectmedia->save_medialist($carImage);
                                            $imageQueue = array();
                                            $imageQueue['media_id'] = $saved_Media;
                                            $imageQueue['NVMVestigingNR'] = $NVMVestigingNR;
                                            $imageQueue['ObjectTiaraID'] = $ObjectTiaraID;
                                            $imageQueue['image_url'] = mysql_real_escape_string($value);
                                            //$this->mmediaqueue->save_queue($imageQueue);  //temporarily disabled by FPI
                                        }
                                 }
                                    
                                    
                                    
                                 if (!empty($data['Uitvoeringen'])) {
                                       //file_put_contents($logfile, " Saving Uitvoeringen\n",FILE_APPEND);
                                        foreach ($data['Uitvoeringen'] as $key => $value) {
                                            $values = explode("##", $value);
                                            $carUitvoeringen = array();
                                            $carUitvoeringen['NVMVestigingNR'] = $NVMVestigingNR;
                                            $carUitvoeringen['ObjectTiaraID'] = $ObjectTiaraID;
                                            $carUitvoeringen['type_id_000'] = $values[0];
                                            $carUitvoeringen['bouwjaar_996'] = $values[1];
                                            $this->mcar_uitvoeringens->save_car_uitvoeringen($carUitvoeringen);
                                        }
                                  }
                                    
                                  if (!empty($data['standarduitrusting'])) {
                                        //file_put_contents($logfile, " Saving standarduitrusting\n",FILE_APPEND);
                                        foreach ($data['standarduitrusting'] as $key => $value) {
                                            $values = explode("#",$value);
                                            $carUitrusting = array();
                                            $carUitrusting['NVMVestigingNR'] = $NVMVestigingNR;
                                            $carUitrusting['ObjectTiaraID'] = $ObjectTiaraID;
                                            $carUitrusting['ID'] = $values[0];
                                            $carUitrusting['uitrusting'] = $values[1];
                                            $this->mcar_uitrustings->save_car_uitrusting($carUitrusting);
                                        }
                                   }
                                    
                                   $this->addvideoQueue($NVMVestigingNR, $ObjectTiaraID); 
                                    
                                  //fabrieksopties
                                  if (!empty($data['fabrieksopties'])) {
                                        //file_put_contents($logfile, " Saving fabrieksopties\n",FILE_APPEND);
                                        foreach ($data['fabrieksopties'] as $key => $value) {
                                            $values = explode("#",$value);
                                            $carfabrieksopties = array();
                                            $carfabrieksopties['NVMVestigingNR'] = $NVMVestigingNR;
                                            $carfabrieksopties['ObjectTiaraID'] = $ObjectTiaraID;
                                            $carfabrieksopties['ID'] = $values[0];
                                            $carfabrieksopties['opties'] = $values[1];
                                            $this->mcar_manufacturers->save_car_manufacturer($carfabrieksopties);
                                        }
                                   }
                                    
                                    //basisopties
                                   if (!empty($data['basisopties'])) {
                                        //file_put_contents($logfile, " Saving basisopties\n",FILE_APPEND);
                                        foreach ($data['basisopties'] as $key => $value) {
                                            $values = explode("#",$value);
                                            $carbasisopties = array();
                                            $carbasisopties['NVMVestigingNR'] = $NVMVestigingNR;
                                            $carbasisopties['ObjectTiaraID'] = $ObjectTiaraID;
                                            $carbasisopties['ID'] = $values[0];
                                            $carbasisopties['opties'] = $values[1];
                                            $this->mcar_additional_features->save_car_additions($carbasisopties);
                                        }
                                    }
                                    
                                    //fabriekspakket
                                    if (!empty($data['fabriekspakket'])) {
                                        //file_put_contents($logfile, " Saving fabriekspakket\n",FILE_APPEND);
                                        foreach ($data['fabriekspakket'] as $key => $value) {
                                            $values = explode("#",$value);
                                            $carfabriekspakket = array();
                                            $carfabriekspakket['NVMVestigingNR'] = $NVMVestigingNR;
                                            $carfabriekspakket['ObjectTiaraID'] = $ObjectTiaraID;
                                            $carfabriekspakket['ID'] = $values[0];
                                            $carfabriekspakket['opties'] = $values[1];
                                            $this->mcar_man_packs->save_car_manpkg($carfabriekspakket);
                                        }
                                    }
                                    
                                    $facebook = $this->msocialmedia->is_facebook($NVMVestigingNR);
                                    if(!empty($facebook)){
                                         if($facebook[0]['added_status']){
                                             $social_post = $facebook[0]['social_post'];
                                             if(!empty($social_post)){
                                                 $this->posttofb($social_post, $facebook[0]['oauth_token_secret'], $ObjectTiaraID, $facebook['user_id']);
                                             }
                                         }
                                     }
                                     //$this->posttofb($ObjectTiaraID,'CAAGcCcJ6B5cBACjl5kN5F6FfEk6CZBGZCy81HZC4Y3stOMgAemCPDfpWU4WRBGoEzMVXc1ZBQAK1bv3uBVvSlckyNXcK5eUE1mh4Gt8NOFT3DEBxKvNm0ZALKgmBt66peZCpbgYcvUevBcTGhi9yaBhBqYrnyNGObhmR0zNMpZActSeOFumXCLA3VIoMMbNawgZD',$ObjectTiaraID, 574588179264200);
   
                                     $Twitter = $this->msocialmedia->is_twitter($NVMVestigingNR);
                                     if(!empty($Twitter)){
                                         if($Twitter[0]['added_status']){
                                             $social_post = $Twitter[0]['social_post'];
                                             if(!empty($social_post)){
                                                 $this->posttotwitter($social_post, $Twitter[0]['oauth_token'], $Twitter[0]['oauth_token_secret'],$ObjectTiaraID);
                                             }
                                         }
                                     }
                                 
                                    
                                    
                                //file_put_contents('servicelog.txt', 'Success ' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
                                file_put_contents($logfile, "Success \n",FILE_APPEND);
                            } else {
                                $failed = '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>99</code><omschrijving>Fout bij publiceren voertuig!!!</omschrijving></status></antwoord>';
                                echo $failed;
                                //file_put_contents('servicelog.txt', 'Failed ' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
                                file_put_contents($logfile, "Failed \n",FILE_APPEND);
                            }
                        } catch (Exception $Ex) {
                            $failed = '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>99</code><omschrijving>Fout bij publiceren voertuig!!!</omschrijving></status></antwoord>';
                            echo $failed;
                            //file_put_contents('servicelog.txt', 'Time limit exit ' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
                            file_put_contents($logfile, " Time Limit Exit \n",FILE_APPEND);
                        }
                    }
                } else {
                    // when object directory exist
                    
                    file_put_contents($logfile, " Object directory bestaat reeds\n",FILE_APPEND);
                    try {
                        if ((!empty($NVMVestigingNR)) && (!empty($ObjectTiaraID))) {
                            $success = '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>00</code><omschrijving>Advertentie goed verwerkt</omschrijving></status></antwoord>';
                            echo $success;
                            $this->load->model('mcar_specs');
                            $this->load->model('mobjectmedia');
                            $this->load->model('mmediaqueue');
                            $this->load->model('mcar_uitvoeringens');
                            $this->load->model('mcar_uitrustings');
                            $this->load->model('mcar_manufacturers');
                            $this->load->model('mcar_man_packs');
                            $this->load->model('mcar_additional_features');
                            
                            //update images
                            
                            if (!empty($data['foto_urls'])) {
                                file_put_contents($logfile, " deleting and inserting foto_urls\n",FILE_APPEND);
                                $this->mobjectmedia->deleteMediaByObj($NVMVestigingNR,$ObjectTiaraID);
                                foreach ($data['foto_urls'] as $key => $value) {
                                    $carImage = array();
                                    $carImage['NVMVestigingNR'] = $NVMVestigingNR;
                                    $carImage['object_id'] = $ObjectTiaraID;
                                    $carImage['media_group'] = "";
                                    $carImage['media_url'] = mysql_real_escape_string($value);
                                    $carImage['mediaomschrijving'] = "";
                                    $carImage['mediaupdate'] = date('Y-m-d');
                                    $carImage['laatstewijziging'] = date('Y-m-d H:i:s');

                                    $saved_Media = $this->mobjectmedia->save_medialist($carImage);

                                    $imageQueue = array();
                                    $imageQueue['media_id'] = $saved_Media;
                                    $imageQueue['NVMVestigingNR'] = $NVMVestigingNR;
                                    $imageQueue['ObjectTiaraID'] = $ObjectTiaraID;
                                    $imageQueue['image_url'] = mysql_real_escape_string($value);
                                    //$this->mmediaqueue->save_queue($imageQueue);
                                }
                            }
                            
                            
                            //update uitvoeringen
                            
                            if (!empty($data['Uitvoeringen'])) {
                                //file_put_contents($logfile, " deleting and inserting Uitvoeringen\n",FILE_APPEND);
                                $this->mcar_uitvoeringens->deleteUitVoeringenByObj($NVMVestigingNR,$ObjectTiaraID);       
                                foreach ($data['Uitvoeringen'] as $key => $value) {
                                    $values = explode("##", $value);
                                    $carUitvoeringen = array();
                                    $carUitvoeringen['NVMVestigingNR'] = $NVMVestigingNR;
                                    $carUitvoeringen['ObjectTiaraID'] = $ObjectTiaraID;
                                    $carUitvoeringen['type_id_000'] = $values[0];
                                    $carUitvoeringen['bouwjaar_996'] = $values[1];
                                    $this->mcar_uitvoeringens->save_car_uitvoeringen($carUitvoeringen);
                                }
                            }
                            
                            //update uitrusting
                            
                            if (!empty($data['standarduitrusting'])) {
                                //file_put_contents($logfile, " deleting and inserting standarduitrusting\n",FILE_APPEND);
                                $this->mcar_uitrustings->deleteUitrustingByObj($NVMVestigingNR,$ObjectTiaraID);
                                foreach ($data['standarduitrusting'] as $key => $value) {
                                    $values = explode("#",$value);
                                    $carUitrusting = array();
                                    $carUitrusting['NVMVestigingNR'] = $NVMVestigingNR;
                                    $carUitrusting['ObjectTiaraID'] = $ObjectTiaraID;
                                    $carUitrusting['ID'] = $values[0];
                                    $carUitrusting['uitrusting'] = $values[1];
                                    $this->mcar_uitrustings->save_car_uitrusting($carUitrusting);
                                }
                            }
                            
                            //fabrieksopties
                            
                            if (!empty($data['fabrieksopties'])) {
                                //file_put_contents($logfile, " deleting and inserting fabrieksopties\n",FILE_APPEND);
                                $this->mcar_manufacturers->deleteManufacturerByObj($NVMVestigingNR,$ObjectTiaraID);
                                foreach ($data['fabrieksopties'] as $key => $value) {
                                    $values = explode("#",$value);
                                    $carfabrieksopties = array();
                                    $carfabrieksopties['NVMVestigingNR'] = $NVMVestigingNR;
                                    $carfabrieksopties['ObjectTiaraID'] = $ObjectTiaraID;
                                    $carfabrieksopties['ID'] = $values[0];
                                    $carfabrieksopties['opties'] = $values[1];
                                    $this->mcar_manufacturers->save_car_manufacturer($carfabrieksopties);
                                }
                            }

                            //basisopties
                            
                            if (!empty($data['basisopties'])) {
                                //file_put_contents($logfile, " deleting and inserting basisopties\n",FILE_APPEND);
                                $this->mcar_additional_features->deleteAdditionsByObj($NVMVestigingNR,$ObjectTiaraID);
                                foreach ($data['basisopties'] as $key => $value) {
                                    $values = explode("#",$value);
                                    $carbasisopties = array();
                                    $carbasisopties['NVMVestigingNR'] = $NVMVestigingNR;
                                    $carbasisopties['ObjectTiaraID'] = $ObjectTiaraID;
                                    $carbasisopties['ID'] = $values[0];
                                    $carbasisopties['opties'] = $values[1];
                                    $this->mcar_additional_features->save_car_additions($carbasisopties);
                                }
                            }

                            //fabriekspakket
                            
                            if (!empty($data['fabriekspakket'])) {
                                //file_put_contents($logfile, " deleting and inserting fabriekspakket\n",FILE_APPEND);
                                $this->mcar_man_packs->deleteManpkgrByObj($NVMVestigingNR,$ObjectTiaraID);
                                foreach ($data['fabriekspakket'] as $key => $value) {
                                    $values = explode("#",$value);
                                    $carfabriekspakket = array();
                                    $carfabriekspakket['NVMVestigingNR'] = $NVMVestigingNR;
                                    $carfabriekspakket['ObjectTiaraID'] = $ObjectTiaraID;
                                    $carfabriekspakket['ID'] = $values[0];
                                    $carfabriekspakket['opties'] = $values[1];
                                    $this->mcar_man_packs->save_car_manpkg($carfabriekspakket);
                                }
                            }
                            
                            //file_put_contents('servicelog.txt', print_r($data,true));
                            
                            // if datum_out not exist or empty
                            if(empty($data['datum_out']->{0}))
                            {
                                $updated  = $this->update_car_object($NVMVestigingNR, $ObjectTiaraID, $data);
                                $car_id = $this->mcar_specs->update_car_spec($NVMVestigingNR,$ObjectTiaraID,$data);

                                $facebook = $this->msocialmedia->nvm_to_facebook($NVMVestigingNR);
                                if(!empty($facebook)){
                                    
                                     if($facebook[0]['updated_status']){
                                         $social_post = $facebook[0]['social_post'];
                                         if(!empty($social_post)){
                                             $this->posttofb($social_post, $facebook[0]['oauth_token_secret'],$ObjectTiaraID, $facebook['user_id']);
                                         }
                                     }
                                 }
                                 //$this->posttofb($ObjectTiaraID,'CAAGcCcJ6B5cBACjl5kN5F6FfEk6CZBGZCy81HZC4Y3stOMgAemCPDfpWU4WRBGoEzMVXc1ZBQAK1bv3uBVvSlckyNXcK5eUE1mh4Gt8NOFT3DEBxKvNm0ZALKgmBt66peZCpbgYcvUevBcTGhi9yaBhBqYrnyNGObhmR0zNMpZActSeOFumXCLA3VIoMMbNawgZD',$ObjectTiaraID, 574588179264200);
   
                                 $Twitter = $this->msocialmedia->is_twitter($NVMVestigingNR);
                                 if(!empty($Twitter)){
                                     if($Twitter[0]['updated_status']){
                                         $social_post = $Twitter[0]['social_post'];
                                         if(!empty($social_post)){
                                             $this->posttotwitter($social_post, $Twitter[0]['oauth_token'], $Twitter[0]['oauth_token_secret'],$ObjectTiaraID);
                                         }
                                     }
                                 }
                                 //file_put_contents('servicelog.txt', 'notdeleted_1 ' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
                                 file_put_contents($logfile, " Not deleted 1 \n",FILE_APPEND);
                             }
                             else
                             {
                                 $this->load->model('mobject');
                                 $this->load->model('mcar_specs');
                                 $this->load->model('mobjectmedia');
                                 $this->load->model('mmediaqueue');
                                 $this->load->model('mcar_uitvoeringens');
                                 $this->load->model('mcar_uitrustings');
                                 $this->load->model('mstatistics');
                                 
                                 $this->load->model('mcar_manufacturers');
                                 $this->load->model('mcar_man_packs');
                                 $this->load->model('mcar_additional_features');
                                    
                                 $this->load->helper('file');
                                 
                                 $objectExist = $this->mobject->hasObjectRecord($NVMVestigingNR,$ObjectTiaraID);
                                 //file_put_contents('servicelog.txt', 'notdeleted ' . print_r($objectExist,true) . "\r\n", FILE_APPEND);
                                 file_put_contents($logfile, " Notdeleted \n",FILE_APPEND);
                                 
// DELETE OPBJECT
                                 if($objectExist) 
                                 {
                                    /* // removed for archiving objects
                                    //set_time_limit(300);
                                    $this->mcar_manufacturers->deleteManufacturerByObj($NVMVestigingNR,$ObjectTiaraID);
                                    $this->mcar_man_packs->deleteManpkgrByObj($NVMVestigingNR,$ObjectTiaraID);
                                    $this->mcar_additional_features->deleteAdditionsByObj($NVMVestigingNR,$ObjectTiaraID);
                    
                                    $this->mcar_uitvoeringens->deleteUitVoeringenByObj($NVMVestigingNR,$ObjectTiaraID);
                                    $this->mcar_uitrustings->deleteUitrustingByObj($NVMVestigingNR,$ObjectTiaraID);
                                    $this->mobjectmedia->deleteMediaByObj($NVMVestigingNR,$ObjectTiaraID);
                                    $this->mobject->deleteObjectById($NVMVestigingNR,$ObjectTiaraID);
                                    $this->mstatistics->deleteStats($ObjectTiaraID); 
                                    
                                    $user_dir_path = 'fileserver/bofiles/downloads/'.$NVMVestigingNR.'/'.$ObjectTiaraID;
                                    $video_file = 'fileserver/bofiles/downloads/'.$NVMVestigingNR.'/'.$ObjectTiaraID.'.mp4';
                                    
                                    
                                    if(file_exists($video_file))
                                    {
                                       unlink($video_file); 
                                       file_put_contents($logfile, " Video file verwijderd\n",FILE_APPEND);
                                    }

                                    if(is_dir($user_dir_path))
                                    {
                                      delete_files($user_dir_path, TRUE);
                                      rmdir($user_dir_path);
                                      file_put_contents($logfile, " Object foto's verwijderd\n",FILE_APPEND);
                                    }
                                   */
                                   
                                   $this->mobject->archiveObject($ObjectTiaraID);
                                   file_put_contents($logfile, "Archived ObjectTiaraID: $ObjectTiaraID \n",FILE_APPEND);
                                 }
                             }
                            
//                               
                            //file_put_contents('servicelog.txt', 'Overwritten ' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
                            file_put_contents($logfile, " Overwritten (old log msg)\n",FILE_APPEND);
                        } else {
                            echo '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>99</code><omschrijving>Fout bij publiceren voertuig!!!</omschrijving></status></antwoord>';
                            //file_put_contents('servicelog.txt', 'Failed ' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
                            file_put_contents($logfile, " Failed (old log msg)\n",FILE_APPEND);
                        }
                    } catch (Exception $Ex) {
                        echo '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>99</code><omschrijving>Fout bij publiceren voertuig!!!</omschrijving></status></antwoord>';
                        //file_put_contents('servicelog.txt', 'Time limit exit ' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
                        file_put_contents($logfile, " Time limit exit (old log msg)\n",FILE_APPEND);
                    }
                }
            } else {
                echo '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>99</code><omschrijving>Fout bij publiceren voertuig!!!</omschrijving></status></antwoord>';
                //file_put_contents('servicelog.txt', 'User not exist' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
                file_put_contents($logfile, " User not exist (old log msg)\n",FILE_APPEND);
            }
        }else{
            
           echo '<antwoord><voertuig_id>'.$ObjectTiaraID.'</voertuig_id><status><code>99</code><omschrijving>Fout bij publiceren voertuig!!!</omschrijving></status></antwoord>';
           //file_put_contents('servicelog.txt', 'Invalid request' . date('Y-m-d H:i:s') . "\r\n", FILE_APPEND);
           file_put_contents($logfile, " Invalid request (old log msg)\n",FILE_APPEND);
        }
        
    }
    
    public function info(){
        $page = <<<EOF
        <style type="text/css">
            #API{ border: 1px solid #CCCCCC;font-family: tahoma,helvetica,verdana;font-size: 12px;margin: 0 auto;padding: 20px;width: 960px;}
            #API h1{text-align:center; color:#006CAD;}
        </style>
        <div id="API">
        <h1>IMOBY API USAGES</h1>
        <p><b>Please Send a post request to following url</b></p>
        <p>http://app.imoby.nl/webservice/</p>
        <h3>Required Fields</h3>
        <p>Your Post request must contain following fields</p>
        <h5>uid</h5>
        <em>uid will contain unique id for user</em>
        <!--<h5>oid</h5>
        <em>oid will contain object id for a object of that user</em>-->
        <h5>data</h5>
        <em>data will contain object information(must be a valid xml string) for a user</em>
        
        <h3>Return Type</h3>
        <p>After successfully accept your request we will send a json data,</p>
        <p>from where you will get <b>success</b> or <b>failed</b> information from INFO node as acknowlegement of your request</p>
        </div>
EOF;
        echo $page;
    }
    
    function readcarXml($xmlFile){
        
        
        //logfile opnieuw definieren
         if ($_SERVER['SERVER_ADDR']=="10.0.0.20"){
            $servername="APP1";
        } else if ($_SERVER['SERVER_ADDR']=="10.0.0.21"){
            $servername="APP2";
        }else{
            $servername="UNKNOWN";
        }
        
        $logfile='/home/imoby/domains/app.imoby.nl/public_html/logs/'.date("d").'-'.$servername.'.txt';
        //einde logfile definitie
        
        
        
        
            $xmlParser = new SimpleXMLElement($xmlFile);
            $data = array();
            //authenticate
            if(!empty($xmlParser->authenticatie->inlognaam)){
                $data['username'] = $xmlParser->authenticatie->inlognaam;
            }else{
                $data['username'] = "";
            }
            if(!empty($xmlParser->authenticatie->wachtwoord)){
                $data['password'] = $xmlParser->authenticatie->wachtwoord;
            }else{
                $data['password'] = "";
            }
            
            if(!empty($xmlParser->versie)){
                $data['versie'] = $xmlParser->versie;
            }else{
                $data['versie'] = "";
            }
            
            if(!empty($xmlParser->bericht_type)){
                $data['bericht_type'] = $xmlParser->bericht_type;
            }else{
                $data['bericht_type'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->portal_code)){
                $data['protal_code'] = $xmlParser->{'adverteer-info'}->portal_code;
            }else{
                $data['protal_code'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig_id)){
                $data['voertuig_id'] = $xmlParser->{'adverteer-info'}->voertuig_id;
            }else{
                $data['voertuig_id'] = "";
            }
            if(!empty($xmlParser->{'adverteer-info'}->datum_in_advertentie)){
                $data['datum'] = substr($xmlParser->{'adverteer-info'}->datum_in_advertentie,0,4).'-'.substr($xmlParser->{'adverteer-info'}->datum_in_advertentie,4,-2).'-'.substr($xmlParser->{'adverteer-info'}->datum_in_advertentie,-2,2);
            }else{
                $data['datum'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->datum_uit_advertentie)){
                $data['datum_out'] = $xmlParser->{'adverteer-info'}->datum_uit_advertentie;
            }else{
                $data['datum_out'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->aanvrager->klant)){
                $data['klant'] = $xmlParser->{'adverteer-info'}->aanvrager->klant;
            }else{
                $data['klant'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->aanvrager->{'kvk-nummer'})){
                $data['kvk_nummer'] = $xmlParser->{'adverteer-info'}->aanvrager->{'kvk-nummer'};
            }else{
                $data['kvk_nummer'] = "";
            }
            if(!empty($xmlParser->{'adverteer-info'}->aanvrager->naam)){
                $data['naam'] = $xmlParser->{'adverteer-info'}->aanvrager->naam;
            }else{
                $data['naam'] = "";
            }
            if(!empty($xmlParser->{'adverteer-info'}->aanvrager->{'e-mail'})){
                $data['email'] = $xmlParser->{'adverteer-info'}->aanvrager->{'e-mail'};
            }else{
                $data['email'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->kenteken)){
                $data['kenteken'] = $xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->kenteken;
            }else{
                $data['kenteken'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->merk)){
                $data['merk'] = $xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->merk; //specs
            }else{
                $data['merk'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->model)){
                 $data['model'] = $xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->model; //specs
            }else{
                 $data['model'] = "";
            }
           
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->uitvoering)){
                $data['uitvoering'] = $xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->uitvoering; //specs
            }else{
                $data['uitvoering'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->bouwjaar)){
                $data['bouwjaar'] = $xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->bouwjaar; //specs
            }else{
                $data['bouwjaar'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-1'})){
                $data['datum_deel_1'] = substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-1'},0,4).'-'.substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-1'},4,-2) .'-'.substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-1'},-2,2);
            }else{
                $data['datum_deel_1'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-2'})){
                $data['datum_deel_2'] = substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-2'},0,4).'-'.substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-2'},-2,2).'-'.substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-2'},-2,2);
            }else{
                $data['datum_deel_2'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->apkdatum)){
                $data['apkdatum'] = substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->apkdatum,0,4).'-'.substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-2'},-2,2).'-'.substr($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->{'datum-deel-2'},-2,2);
            }else{
                $data['apkdatum'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->kilometerstand)){
                $data['kilometerstand'] = $xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->kilometerstand;
            }else{
                $data['kilometerstand'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->marge)){
                $data['marge'] = $xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->marge; //specs
            }else{
                $data['marge'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->showroomprijs_excl_btw)){
                $data['showroomprijs_excl_btw'] = $xmlParser->{'adverteer-info'}->voertuig->{'kenteken-info'}->showroomprijs_excl_btw;
            }else{
                $data['showroomprijs_excl_btw'] = "";
            }
            
            //technische-info
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->kleur)){
                $data['kleur'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->kleur; //specs
            }else{
                $data['kleur'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->brandstof)){
                $data['brandstof'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->brandstof;
            }else{
                $data['brandstof'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->voertuigsoort)){
                $data['voertuigsoort'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->voertuigsoort;
            }else{
                $data['voertuigsoort'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->{'aantal-deuren'})){
                $data['aantal_deuren'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->{'aantal-deuren'};
            }else{
                $data['aantal_deuren'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->aandrijving)){
                $data['aandrijving'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->aandrijving;
            }else{
                $data['aandrijving'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->versnelling)){
                $data['versnelling'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->versnelling; //specs
            }else{
                $data['versnelling'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->koetswerk)){
                $data['koetswerk'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->koetswerk; //specs
            }else{
                $data['koetswerk'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->{'aantal-cilinders'})){
                $data['aantal_cilinders'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->{'aantal-cilinders'};
            }else{
                $data['aantal_cilinders'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->cilinderinhoud)){
                $data['cilinderinhoud'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->cilinderinhoud;
            }else{
                $data['cilinderinhoud'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->vermogen)){
                $data['vermogen'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->vermogen;
            }else{
                $data['vermogen'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->{'massa-ledig-gewicht'})){
                $data['massa_ledig_gewicht'] = $xmlParser->{'adverteer-info'}->voertuig->{'technische-info'}->{'massa-ledig-gewicht'};//specs
            }else{
                $data['massa_ledig_gewicht'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->kleur)){
                $data['kleur'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->kleur;
            }else{
                $data['kleur'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->uitvoering)){
                $data['uitvoering'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->uitvoering;
            }else{
                $data['uitvoering'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkdatum)){
                $data['apkdatum'] = substr($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkdatum,0,4).'-'.substr($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkdatum,4,-2) . '-' . substr($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkdatum,-2,2); //specs
            }else{
                $data['apkdatum'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkdatum)){
                $data['apkdatum'] = substr($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkdatum,0,4).'-'.substr($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkdatum,4,-2) . '-' . substr($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkdatum,-2,2); //specs
            }else{
                $data['apkdatum'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkbijaflevering)){
                $data['apkbijaflevering'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->apkbijaflevering;
            }else{
                $data['apkbijaflevering'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->kilometerstand)){
                $data['kilometerstand'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->kilometerstand;
            }else{
                $data['kilometerstand'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->brandstof)){
                $data['brandstof'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->brandstof; //specs
            }else{
                $data['brandstof'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->{'aantal-deuren'})){
                $data['aantal_deuren'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->{'aantal-deuren'};
            }else{
                $data['aantal_deuren'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->aandrijving)){
                $data['aandrijving'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->aandrijving;
            }else{
                $data['aandrijving'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->versnelling)){
                $data['versnelling'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->versnelling;
            }else{
                $data['versnelling'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->koetswerk)){
                $data['koetswerk'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->koetswerk;
            }else{
                $data['koetswerk'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->cilinderinhoud)){
                $data['scilinderinhoud'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->cilinderinhoud;
            }else{
                $data['scilinderinhoud'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->vermogen)){
                $data['vermogen'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->vermogen;
            }else{
                $data['vermogen'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->{'massa-ledig-gewicht'})){
                $data['massa_ledig_gewicht'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->{'massa-ledig-gewicht'};
            }else{
                $data['massa_ledig_gewicht'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->bouwjaar)){
                $data['bouwjaar'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->bouwjaar;
            }else{
                $data['bouwjaar'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->handelsvoorraad)){
                $data['handelsvoorraad'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->handelsvoorraad;
            }else{
                $data['handelsvoorraad'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->showroomprijs)){
                $data['showroomprijs'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->showroomprijs; //specs
            }else{
                $data['showroomprijs'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->handelsprijs)){
                $data['handelsprijs'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->handelsprijs;   //specs
            }else{
                $data['handelsprijs'] = "";
            }
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->exportprijs)){
                $data['exportprijs'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->exportprijs;     //specs
            }else{
                $data['exportprijs'] = "";
            }
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->{'vrije-tekst'})){
                $data['vrije_tekst'] = $xmlParser->{'adverteer-info'}->voertuig->{'advertentie-info'}->{'vrije-tekst'};
            }else{
                $data['vrije_tekst'] = "";
            }
            //foto-urls
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'foto-urls'}->url)){
                foreach($xmlParser->{'adverteer-info'}->voertuig->{'foto-urls'}->url as $key => $url){
                   $data['foto_urls'][] = $url;
                }
            }else{
                $data['foto_urls'] = "";
            }
            
            //Uitvoeringen
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->Uitvoeringen->Uitvoering)){
                foreach($xmlParser->{'adverteer-info'}->voertuig->Uitvoeringen->Uitvoering as $key=> $val){
                    $data['Uitvoeringen'][] = $val->{'type-id-000'}.'##'.$val->{'bouwjaar-996'};
                }
            }else{
                 $data['Uitvoeringen'] = "";
            }
            
            //standaard-uitrusting
            
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'standaard-uitrusting'})){
                foreach($xmlParser->{'adverteer-info'}->voertuig->{'standaard-uitrusting'}->stdu as $key => $val){
                    $attribute = $val->attributes();
                    $data['standarduitrusting'][] = $attribute['id']."#".$val->{0};
                    
                }
            }else{
                $data['standarduitrusting'] = "";
            }
            
            //fabrieksopties
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'fabrieksopties'})){
                foreach($xmlParser->{'adverteer-info'}->voertuig->{'fabrieksopties'}->fabop as $key => $val){
                    $attribute = $val->attributes();
                    $data['fabrieksopties'][] = $attribute['id']."#".$val->{0};
                    
                }
            }else{
                $data['fabrieksopties'] = "";
            }
            
            //basisopties
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'basisopties'})){
                foreach($xmlParser->{'adverteer-info'}->voertuig->{'basisopties'}->basop as $key => $val){
                    $attribute = $val->attributes();
                    $data['basisopties'][] = $attribute['id']."#".$val->{0};
                    
                }
            }else{
                $data['basisopties'] = "";
            }
            
            //fabriekspakket
            if(!empty($xmlParser->{'adverteer-info'}->voertuig->{'fabriekspakket'})){
                foreach($xmlParser->{'adverteer-info'}->voertuig->{'fabriekspakket'}->fabpak as $key => $val){
                    $attribute = $val->attributes();
                    $data['fabriekspakket'][] = $attribute['id']."#".$val->{0};
                    
                }
            }else{
                $data['fabriekspakket'] = "";
            }
            //print_r ($data);
            
            
            
            //oude XML files verwijderen
            $date = strtotime(date("Y-m-d", strtotime(date("Ymd"))) . " -1 days");
    	    $deletebefore = date("Y-m-d", $date);
    	
    	    $files = scandir('fileserver/bofiles/xmls/');
    	    foreach ($files as $key => $value)
    	    {
    	        if (substr($value, 0, 1) != ".")
    	        {
    	            $filename = substr($value, 0, 10);
                    
                    //file_put_contents($logfile, $filename.$deletebefore . " \n",FILE_APPEND);
    	            if ($filename < $deletebefore)
    	            {
    	                @unlink('fileserver/bofiles/xmls/' . $value);
    	            }
    	        }
    	    }
            
            
            //logging
            file_put_contents('fileserver/bofiles/xmls/'.date('Y-m-d')."_".$xmlParser->{'adverteer-info'}->portal_code.'_'.$xmlParser->{'adverteer-info'}->voertuig_id.'.xml', $xmlFile);
            file_put_contents($logfile, " XML file opgeslagen\n",FILE_APPEND);
            return $data;
        }
        
        private function addvideoQueue($NVMVestigingNR,$ObjectTiaraID)
        {
            //add video queue
            $insertData = array();
            $insertData['ObjectTiaraID'] = $ObjectTiaraID;
            $insertData['duration'] = 50;
            $insertData['NVMVestigingNR'] = $NVMVestigingNR;
            $insertData['is_done'] = 0;
            $this->db->insert('object_pending_3gp',$insertData);
        }
        
        
        private function save_car_object($Nvm,$objectTiaraID,$data){
            
            file_put_contents($this->logfile, " Saving Car Object\n",FILE_APPEND);
            $this->load->model('mobject');
            $objectData['NVMVestigingNR'] = $Nvm;
            $objectData['ObjectTiaraID'] = $objectTiaraID;
            $objectData['country'] = "";
            $objectData['streetnaam'] = "";
            $objectData['huisnummer'] = "";
            $objectData['postcode'] = "";
            $objectData['woonplaats'] = "";
            $objectData['land'] = "";
            $objectData['sale_rent'] = "";
            $objectData['prijsvoorvoegsel'] = "";
            $prijs = 0;
            if(!empty($data['showroomprijs'])){
                $prijs = $data['showroomprijs'];
            }elseif(!empty($data['handelsprijs'])){
                $prijs = $data['handelsprijs'];
            }else{
                $prijs = $data['exportprijs'];
            }
            $objectData['koopprijs'] = $prijs;
            $objectData['koopconditie'] = "";
            $objectData['aanvaarding'] = "";
            $objectData['objectaanmelding'] = "";
            $objectData['datuminvoer'] = "";
            $objectData['datumwijziging'] = "";
            $objectData['status'] = "";
            $objectData['transactiedatum'] = "";
            $objectData['bouwvorm'] = "";
            $objectData['plaatsing'] = "";
            $objectData['aanbiedingstekst'] = $data['vrije_tekst'];
            $objectData['custom_object_id'] = 0;
            $objectData['kenteken'] = $data['kenteken'];
            $objectData['merk'] = $data['merk'];
            $objectData['bouwjaar'] = $data['bouwjaar'];
            $objectData['brandstof'] = $data['brandstof'];
            $saved = $this->mobject->save_object($objectData);
            file_put_contents($this->logfile, " Saving Car Object result: ".$saved."\n",FILE_APPEND);
            return $saved;
        }
        
        private function update_car_object($Nvm,$objectTiaraID,$data){

            file_put_contents($this->logfile, " Updating car Object\n",FILE_APPEND);
            $this->load->model('mobject');
            
            $prijs = 0;
            if(!empty($data['showroomprijs'])){
                $prijs = $data['showroomprijs'];
            }elseif(!empty($data['handelsprijs'])){
                $prijs = $data['handelsprijs'];
            }else{
                $prijs = $data['exportprijs'];
            }
            $objectData['koopprijs'] = $prijs;
            
            $objectData['aanbiedingstekst'] = $data['vrije_tekst'];
            $objectData['kenteken'] = $data['kenteken'];
            $objectData['merk'] = $data['merk'];
            $objectData['bowjaar'] = $data['bowjaar'];
            $objectData['brandstof'] = $data['brandstof'];
            return $this->mobject->update_object($objectTiaraID,$objectData);
        }
        
        function posttofb($msg,$token,$objectid, $user_id=0){
            session_start();
            $this->load->plugin('imobyfacebook');
            $imobyFb = new ImobyFacebook();
            $user_profile = $imobyFb->get_profile($token);
            $imobyFb->log('WS: '.$objectid.' '.$token);
            
            //$imobyFb->post_on_wall($msg.' <a href="http://imoby.nl/'.$objectid.'">imoby.nl/'.$objectid.'</a>', $token);
            if($user_id=='0'){
                    $return = $imobyFb->post_on_wall($msg."\nhttp://imoby.nl/".$objectid, $token);
                }
            else{
               // get fanpage token
                $fanPages = $imobyFb->getFanPages($token); 
                $pageToken = false;   
                foreach($fanPages['data'] as $key => $page) {
                    if($page['id']==$user_id){
                        $pageToken = $page['access_token'];
                    }
                }
                
                $return = $imobyFb->post_on_page($user_id, $msg."\nhttp://imoby.nl/".$objectid, $pageToken); 
            }    

        }
        
        function posttotwitter($msg,$tokenAuth,$tokenSecret,$objectid){
            $this->load->plugin('twitteroauth');
            require_once(APPPATH.'libraries/twitter/secret.php');
            $twitterCon = new TwitterOAuth('EiJ0JNqlINlPxKOAMh3cw', 'GZ50vfq8vhWanVpI5830sHGn1XCeyOxiZ1l7im7Z5rc', $tokenAuth, $tokenSecret);
            $tweet = $msg.' <a href="http://imoby.nl/'.$objectid.'">imoby.nl/'.$objectid.'</a>';
            $twitterCon->post('statuses/update', array('status' => $tweet));
        }
        
        
        
        
        
    
/*    private function save_new_user($uid,$uemail){
                $this->load->model('muser');
		$saveData = array();
		
		$saveData['pre_name']    = "";
		$saveData['username']    = $uemail;
		$saveData['first_name']  = "";
		$saveData['last_name']   = "";
		$saveData['email']       = $uemail;
		$saveData['password']    = md5('1234');
		$saveData['orgpass']    = md5('1234');
		$saveData['type']        = 0;
		$userStatus              = 1;
		$saveData['imobycode']   = $uid;
		if($userStatus > 0){
			$saveData['status'] = $userStatus;	
		}else{
			$saveData['status'] = 0;
                }
                $saveData['website'] = "";
                $saveData['position'] = "";
                $saveData['phone'] = "";
                $saveData['office_name'] = "";
                $saveData['office_address'] = "";
                $saveData['office_postcode'] = "";
                $saveData['office_city']  = "";
                $saveData['office_phone']  = "";
                $saveData['office_fax']   = "";
                $saveData['office_email']   = "";
                $saveData['member_type'] = "CAR";
                
                if(!empty($saveData['imobycode'])){
                    $agencycode_exist = $this->muser->agency_code_exist($saveData['imobycode']);
                    if(empty($agencycode_exist)){
                        $saved = $this->muser->save_user_info($saveData);
                        return $saved;
                    }else{
                        return 0;
                    }
                }else{
                    return 0;
                }
    }*/
    
}

?>
