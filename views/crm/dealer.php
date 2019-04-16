<?php //print '<pre>'; print_r($dealer); print '</pre>'; ?>
<!--<div class="grayColumn">
   <div class="titleBar">Uw gegevens</div>
    <?php if ($message){ echo $message; } ?>
    <div class="contentBlock">
        <div id="dealer-formulier">
        	<fieldset style="display:inline;">
                <input type="radio" name="aanhef"  value="De Heer" <?php echo ( (($dealer->dealer_aanhef=='De Heer') OR empty($dealer->dealer_aanhef)) ? 'checked="checked"' : ''); ?> /><label>De heer</label><input type="radio" name="aanhef" value="Mevrouw" <?php echo ($dealer->dealer_aanhef=='Mevrouw' ? 'checked="checked"' : ''); ?> /><label>Mevrouw</label><br /> 
        		<span class="person" title="Voornaam"></span><input type="text" name="voornaam" id="voornaam" value="<?php echo ($dealer->dealer_voornaam) ? $dealer->dealer_voornaam : 'Voornaam'; ?>"  /><br />
        		<span class="person" title="Tussenvoegsel"></span><input type="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php echo ($dealer->dealer_tussenvoegsel) ? $dealer->dealer_tussenvoegsel : 'Tussenvoegsel'; ?>"  /><br />
        		<span class="person" title="Achternaam"></span><input type="text" name="achternaam" id="achternaam" value="<?php echo ($dealer->dealer_achternaam) ? $dealer->dealer_achternaam : 'Achternaam'; ?>" /><br />
                <span class="briefcase" title="Bedrijfsnaam"></span><input type="text" name="bedrijfsnaam" id="bedrijfsnaam" value="<?php echo ($dealer->dealer_bedrijfsnaam) ? $dealer->dealer_bedrijfsnaam : 'Bedrijfsnaam'; ?>" /><br />
                <span class="mail" title="Email"></span><input type="text" name="email" id="email" value="<?php echo ($dealer->dealer_email) ? $dealer->dealer_email : 'Email'; ?>" /><br />
                <span class="kvknr" title="Kvk nummer"></span><input type="text" name="kvknr" id="kvknr" value="<?php echo ($dealer->dealer_kvknr) ? $dealer->dealer_kvknr : 'Kvknr'; ?>" /><br />
        	    <span class="btwnr" title="BTW Nummer"></span><input type="text" name="btwnr" id="btwnr" value="<?php echo ($dealer->dealer_btwnr) ? $dealer->dealer_btwnr : 'Btwnr'; ?>" /><br />
            </fieldset>
            <fieldset style="display:inline;">
                <span class="house" title="Postcode"></span><input type="text" name="postcode" id="postcode" value="<?php echo ($dealer->dealer_postcode) ? $dealer->dealer_postcode : 'Postcode'; ?>"  /><br />
                <span class="house" title="Adres"></span><input type="text" name="adres" id="adres" value="<?php echo ($dealer->dealer_adres) ? $dealer->dealer_adres : 'Adres'; ?>"  /><br />
        		<span class="house" title="Huisnummer"></span><input type="text" name="huisnummer" id="huisnummer" value="<?php echo ($dealer->dealer_huisnummer) ? $dealer->dealer_huisnummer : 'Huisnummer'; ?>" /><br />
                <span class="house" title="Woonplaats"></span><input type="text" name="woonplaats" id="woonplaats" value="<?php echo ($dealer->dealer_woonplaats) ? $dealer->dealer_woonplaats : 'Woonplaats'; ?>" /><br />
                <span class="phone" title="Telefoon"></span><input type="text" name="telefoon" id="telefoon" value="<?php echo ($dealer->dealer_telefoon) ? $dealer->dealer_telefoon : 'Telefoon'; ?>" /><br />
                <span class="mobile" title="Mobiel"></span><input type="text" name="mobiel" id="mobiel" value="<?php echo ($dealer->dealer_mobiel) ? $dealer->dealer_mobiel : 'Mobiel'; ?>" /><br />
                <span class="mobile" title="Mobiel"></span><input type="text" name="rekeningnr" id="rekeningnr" value="<?php echo ($dealer->dealer_rekeningnr) ? $dealer->dealer_rekeningnr : 'Rekeningnr'; ?>" /><br />
        
        	</fieldset>
    	</div>
    </div>
</div>-->
<div class="grayColumn">
    <div class="titleBar">Uw factuur</div>
    <div class="contentBlock">
        Voor uw factuur kunt U  gebruik maken van een standaard C4, C5 of C6 envelop.
        Zowel met het venster links of rechts voor de adres gegevens van uw klant.<br />
        Venster links <input type="radio" value="links" name="vensterLokatie" <?php echo ( (($dealer->dealer_factuurtemplate =='links') OR empty($dealer->dealer_factuurtemplate )) ? 'checked="checked"' : ''); ?> /> of <input type="radio" value="rechts" name="vensterLokatie"  <?php echo ( ($dealer->dealer_factuurtemplate =='rechts') ? 'checked="checked"' : ''); ?> /> venster rechts<br /><br />
         <!-- Een standaard venster envelop heeft een venster van 40mm hoog, 100mm breed, 60mm van de bovenkant, en 20mm vanaf de linker-, of  rechter-rand.<br /> -->
         <br />
         Indien u eigen briefpapier heeft kunt u hier de optie om de bedrijfsgegevens onder aan de factuur uitschakelen. <input type="checkbox" value="1" name="emailBedrijfsgegevens" <?php echo ( ($dealer->dealer_emailBedrijfsgegevens) ? 'checked="checked"' : ''); ?> /><br />
    </div>
</div>
<div class="grayColumn">
    <div class="titleBar">Uw marketing instellingen</div>
    <div class="contentBlock">
        U kunt hier uw marketing acties simpel aan en uitzetten, voor meer persoonlijke instellingen gaat u naar de <a href="/crm/marketing">Marketing</a> pagina.<br /><br />
  <table border="0" cellpadding="10px">      
<?php
$actieIds = array();
foreach($acties as $actie) {
   $actieIds[] = $actieId = 'actie_'.$actie->marketing_id.'_'.$actie->marketing_defaultId;
    echo '<tr><td style="border-bottom: 1px solid rgb(225, 225, 225);width:33%">'.$actie->marketing_titel.'</td><td style="border-bottom: 1px solid rgb(225, 225, 225);width:66%">';
     if($actie->marketing_id){
?> 
    
        <div id="marketing" class="checkBoxSlider slider_<?php echo $actieId; ?>">
            <button type="button" class="radioSliderTrue <?php echo ( ($actie->marketing_actief=='1') ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
            <button type="button" class="radioSliderFalse  <?php echo ( ( ($actie->marketing_actief=='0') OR empty($actie->marketing_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
            <input type="radio" rel="<?echo $actie->marketing_id; ?>" name="actief" class="radioSliderOn slider_<?echo $actieId; ?>" value="1" <?php echo ($actie->marketing_actief=='1' ? 'checked="checked"' : ''); ?> />
            <input type="radio" rel="<?echo $actie->marketing_id; ?>" name="actief" class="radioSliderOff slider_<?echo $actieId; ?>" value="0" <?php echo ( ( ($actie->marketing_actief=='0') OR empty($actie->marketing_actief) ) ? 'checked="checked"' : ''); ?> />
        </div>
      
<?php }
    else{
        echo '<span>U moet deze marketing actie eerst aanmaken op de <a href="/crm/marketing">Marketing</a> pagina.</span>';
    }
    echo '</td></tr>';
} $actie = '';
?>       

<tr><td style="border-bottom: 1px solid rgb(225, 225, 225);width:33%">Auto uit voorraad</td><td style="border-bottom: 1px solid rgb(225, 225, 225);width:66%">
<div id="" class="checkBoxSlider slider_EUV">
        <button type="button" class="radioSliderTrue <?php echo ( ($dealer->dealer_email_uitvoorraad=='1') ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
        <button type="button" class="radioSliderFalse  <?php echo ( ( ($dealer->dealer_email_uitvoorraad=='0') OR empty($dealer->dealer_email_uitvoorraad) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
        <input type="radio" rel="" name="autouitvoorraad" class="radioSliderOn slider_EUV" value="1" <?php echo ($dealer->dealer_email_uitvoorraad=='1' ? 'checked="checked"' : ''); ?> />
        <input type="radio" rel="" name="autouitvoorraad" class="radioSliderOff slider_EUV" value="0" <?php echo ( ( ($dealer->dealer_email_uitvoorraad=='0') OR empty($dealer->dealer_email_uitvoorraad) ) ? 'checked="checked"' : ''); ?> />
    </div>
</td>
</tr>
      </table>  
    </div>
</div>
<?php
if(is_object($dealer)){
    echo '<script type="text/javascript"> $(document).ready(function(){'; 
    foreach($dealer as $key => $value){
        if( ($value=='') && (!in_array($key,array('dealer_tussenvoegsel','dealer_mobiel'))) ){
            echo '$("#'.str_replace('dealer_','',$key).'").addClass("inputError");';
        }
    }
    echo "radioSlider('slider_EUV');\n";
    echo '});</script>'; 
}
if(count($actieIds)){
    echo '<script type="text/javascript">';
    foreach($actieIds as $id){
        echo "radioSlider('slider_".$id."');\n";
    }
    echo '</script>';
}


?>