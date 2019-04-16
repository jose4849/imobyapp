<?php //print '<pre>'; var_dump($openFactuur); print '</pre>'; 
if($message){
    echo '<p>'.$message.'</p>';    
}
?>
<div class="grayColumn">
<div class="titleBar">Autogegevens</div>
<div class="contentBlock">
    <div id="autoGegevens">
            <div id="autoImage">
               <?php if ($auto->auto_foto) { echo '<img src="'.$auto->auto_foto.'" class="preview_auto_small" id="preview-foto" style="cursor:pointer;"/>'; } else {echo '<span class="autoplaceholderxl" id="preview-foto" style="cursor:pointer;">&nbsp;</span>'; /*popup met upload*/} ?><input type="hidden" id="autoId" value="<?php echo $auto->auto_id; ?>" />
            </div>
            <div id="autoDetails">
                <span class="autoType"><?php echo $auto->auto_merk.' '.$auto->auto_type ;?></span><br />
                <span class="autoKenteken"><?php echo $auto->auto_kenteken; ?></span><br /><br />
                Bouwjaar: <?php echo $auto->auto_bouwjaar; ?><br />
                <div style="line-height:20px;margin:3px 0 0 0;">Status:
                    <div id="auto_actief" class="checkBoxSlider auto_actief">
                        <button type="button" class="radioSliderTrue auto_actief <?php echo ( ($auto->auto_actief=='1') ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
                        <button type="button" class="radioSliderFalse auto_actief <?php echo ( ( ($auto->auto_actief=='0') OR empty($auto->auto_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
                        <input type="radio" name="auto_actief" class="radioSliderOn auto_actief" value="1" <?php echo ($auto->auto_actief=='1' ? 'checked="checked"' : ''); ?> />
                        <input type="radio" name="auto_actief" class="radioSliderOff auto_actief" value="0" <?php echo ( ( ($auto->auto_actief=='0') OR empty($auto->auto_actief) ) ? 'checked="checked"' : ''); ?> />
                    </div>
                </div>
            </div>
            <div id="autoLinksDiv">
                <table id="autoLinks">
                    <tr>
                        <td><a class="button long" href="#" id="upload-bestand"><img class="file" src="<?php echo base_url(); ?>crmAssets/images/file.png" />Bestand<br />toevoegen</a></td>
                        <td><a class="button small" href="#" id="opmerking-maken"><img class="opmerking" src="<?php echo base_url(); ?>crmAssets/images/opmerking.png" />Opmerking maken</a></td>
                    </tr>
                    <tr>
                        <td><a class="button long" href="#" id="onderhoud-maken"><img class="calendar" src="<?php echo base_url(); ?>crmAssets/images/calendar.png" />Onderhoud afspraak maken</a></td>
                        <td><a class="button small" href="" id="factuur-opmaken"><img class="factuur" src="<?php echo base_url(); ?>crmAssets/images/factuur.png" />Factuur<br />maken</a></td>
                    </tr>
                    <tr>
                        <td><a class="button long" href="#" id="onderhoud-achteraf"><img class="pencil" src="<?php echo base_url(); ?>crmAssets/images/pencil.png" />Onderhoud achteraf registreren</a></td>
                        <td><a class="button small" href="#" id="auto-marketing"><img class="marketing" src="<?php echo base_url(); ?>crmAssets/images/marketing.png" />Marketing instellingen</a></td>
                    </tr>
                </table>
            </div>
    </div>
            
    
    <hr />
    <div class="subTitleBar">Kenmerken</div>
    <table border="0" id="kenmerken" >
        <tr>
            <td>Merk:</td>
            <td><span class="blueBold"><?php echo $auto->auto_merk; ?></span></td>
            <td>Datum tenaamstelling:</td>
            <td><span class="blueBold"><?php if($auto->auto_datumaanvangtenaamstellin) { echo date("d-m-Y", strtotime($auto->auto_datumaanvangtenaamstelling)); } ?></span></td>
        </tr>
        <tr>
            <td>Type:</td>
            <td><span class="blueBold"><?php echo $auto->auto_type; ?></span></td>
            <td>APK-vervaldatum:</td>
            <td><span class="blueBold"><?php if($auto->auto_vervaldatumapk) { echo date("d-m-Y", strtotime($auto->auto_vervaldatumapk)); } ?></span></td>
        </tr>
        <tr>
            <td>Transmissie:</td>
            <td><span class="blueBold"><?php echo $auto->auto_transmissie; ?></span></td>
             <td>Bouwjaar:</td>
            <td><span class="blueBold"><?php echo $auto->auto_bouwjaar; ?></span></td>
        </tr>
        <tr>
            <td>Brandstof:</td>
            <td><span class="blueBold"><?php echo $auto->auto_hoofdbrandstof; ?></span></td>
            <td>Verkoopdatum:</td>
            <td><span class="blueBold"></span></td>
        </tr>
        <tr>
            <td>Kmstand:</td>
            <td><span class="blueBold"><?php if($auto->auto_kilometerstand) { echo number_format($auto->auto_kilometerstand, 0, ',', '.' ); } ?></span></td>
            <td>Verkoopprijs:</td>
            <td><span class="blueBold">&euro;</span></td>
        </tr>
        <tr>
            <td>Carrosserievorm:</td>
            <td><span class="blueBold"><?php echo (($auto->auto_carrosserievorm) ? $auto->auto_carrosserievorm : $auto->auto_inrichting); ?></span></td>
            <td>Vraagprijs:</td>
            <td><span class="blueBold">&euro;<?php if($auto->auto_prijs) { echo number_format ($auto->auto_prijs, 0, ',', '.' ); } ?></span></td>
        </tr>        

    </table>
    <div class="subTitleBar">Onderhoud (<?php echo count($onderhoud); ?>)</div>
    <table border="0" id="auto-onderhoud" >
        <thead>
        <th style="width:120px;">Datum</th>
        <th>Omschrijving</th>
        <th style="width:10px;">&nbsp;</th>
    </thead>
     <?php 
    if(is_array($onderhoud)){

        //$onderhoud = array_reverse($onderhoud);
        foreach($onderhoud as $onderhoud){
            $text = $onderhoud->onderhoud_text;
            $maxWords = 20;
            $nrWords = count(explode(" ",$text));
            $textArray = explode(' ', $text);
            
            // new line shoud be treated as space!
            $nrWords += count(explode("\n",$text));

            if ($nrWords>$maxWords){
                $text = '<span class="opmerking">'.nl2br(implode(' ', array_slice(explode(' ', str_replace("\n", " \n", $text)), 0, $maxWords))).'<span class="readMore">... (Lees meer)</span></span><span class="longDescription" id="text-'.$onderhoud->onderhoud_id.'">'.nl2br($text).' <span class="readLess">(Lees minder)</span></span>';
            }
            else{
                $text = '<span id="text-'.$onderhoud->onderhoud_id.'">'.nl2br($text).'</span>';
            }
            echo '<tr>
            <td>'.date("d-m-Y H:i", strtotime($onderhoud->onderhoud_datum )).'</td>
            <td><a href="#" id="'.$onderhoud->onderhoud_id.'" class="edit-onderhoud">'.$text.'</span></a><input type="hidden" id="onderhoud_type-'.$onderhoud->onderhoud_id.'" value="'.$onderhoud->onderhoud_type.'"><input type="hidden" id="onderhoud_kmstand-'.$onderhoud->onderhoud_id.'" value="'.$onderhoud->onderhoud_kilometerstand.'">
    </td>
            <td class="remove-onderhoud" style="text-align:center;" rel="'.$onderhoud->onderhoud_id.'"><img src="'.BASE.'/crmAssets/images/delete.png" /></td>
            </tr>';  
        } 
    }
    ?>
    </table>

    <div class="subTitleBar">Bestanden (<?php echo count($bestanden); ?>)</div>
    <table border="0" id="auto-bestanden" >
    <thead>
        <th style="width:120px;">Datum</th>
        <th>Omschrijving</th>
        <th style="width:10px;">&nbsp;</th>
    </thead>
    <?php 
    if(is_array($bestanden)){
        $bestanden = array_reverse($bestanden);
        foreach($bestanden as $bestand){
            echo '<tr><td>'.date("d-m-Y  H:i", strtotime($bestand->document_datum )).'</td><td><a href="'.BASE.'/crm/auto/'.$auto->auto_id.'/bestand_'.$bestand->document_fileNaam.'" />'.$bestand->document_omschrijving  .'</a></td></td>
             <td class="remove-bestand" style="text-align:center;" rel="'.$bestand->document_id.'"><img src="'.BASE.'/crmAssets/images/delete.png" /></td>
             </tr>';  
        } 
    }
    ?>
    </table>
    
    <div class="subTitleBar">Facturen (<?php echo count($facturen); ?>)</div>
    <table border="0" id="auto-facturen" >
     <thead>
        <th style="width:120px;">Datum</th>
        <th>Omschrijving</th>
    </thead>
    <?php 
    if(is_array($facturen)){
        $facturen = array_reverse($facturen);
        foreach($facturen as $factuur){
           //print_r($factuur);
            echo '<tr><td>'.date("d-m-Y  H:i", strtotime($factuur->factuur_datum)).'</td><td><a href="'.BASE.'/crm/auto/'.$auto->auto_id.'/pdf_'.$factuur->factuur_id.'" />'.$factuur->factuur_omschrijving.'</a></td></tr>';  
        } 
    }
    ?>
    </table>
    
    <div class="subTitleBar">Opmerkingen (<?php echo count($opmerkingen); ?>)</div>
    <table border="0" id="auto-opmerkingen" >
    <thead>
        <th style="width:120px;">Datum</th>
        <th>Opmerking</th>
        <th style="width:10px;">&nbsp;</th>
    </thead>
    <?php 
    if(is_array($opmerkingen)){
        $opmerkingen = array_reverse($opmerkingen);
        foreach($opmerkingen as $opmerking){
            
            $text = $opmerking->notitie_text;
            $maxWords = 20;
            $nrWords = count(explode(" ",$text));
            $nrWords += count(explode("\n",$text));
            if ($nrWords>$maxWords){
                $text = '<span class="opmerking"> - '.implode(' ', array_slice(explode(' ', $text), 0, $maxWords)).'</xmp> <span class="readMore">...(Lees meer)</span></span><span class="longDescription"> - '.$text.' <span class="readLess">(Lees minder)</span></span>';
            }
            echo '<tr><td>'.$nrWords.'>'.$maxWords.'<br/>'.date("d-m-Y H:i", strtotime($opmerking->notitie_datum)).'</td><td>'.nl2br($text).'</td>
            <td class="remove-notitie" style="text-align:center;" rel="'.$opmerking->notitie_id.'"><img src="'.BASE.'/crmAssets/images/delete.png" /></td></tr>';  
        } 
    }
    ?>
    </table>
</div>
</div>

<div id="dialog-bestand-upload" title="Bestanden">
    <?php //echo form_open_multipart('crm/auto/'.$auto->auto_id.'/upload');?>
    <form enctype="multipart/form-data" method="post" action="http://app.imoby.nl/crm/auto/<?echo $auto->auto_id; ?>/upload" >
    <div id="bestand-upload">
        <label for="userfile">Bestand:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <span class="fileBrowse">Bladeren</span><input type="file" name="userfile" size="20" /><span class="grey-text" id="uploadFileName">Geen bestand geselecteerd</span><br />
        <span class="grey-text">Let op: Het bestand mag niet groter zijn dan 5mb.<br /> (pdf, jpg, doc, xls)</span>
    </div>
    <div id="bestand-upload-omschrijving">
        <label class="omschrijving">Omschrijving:</label><br />
        <input type="radio" name="omschrijvingType" value="standaard" checked="checked" /><label for="omschrijving" style="width:165px;">Standaard omschrijving: </label>
        <select class="grey-text" name="standaard">
            <option>Vrijwaringsbewijs</option>
            <option>Legitimatie</option>
            <option>Kenteken deel 3</option>
            <option>Koopovereenkomst</option>
        </select><br />
        <input type="radio" name="omschrijvingType" value="omschrijving" /><label for="omschrijving" style="width:165px;">Eigen omschrijving: </label><input type="text" name="omschrijving" id="omschrijving"  maxlength="255" size="25"/><br />
        <span class="button-opslaan" style="float:right;left:0px;right:0px;"><img class="vinkje" src="<?php echo base_url(); ?>/crmAssets/images/vinkje.png" /><button class="button" type="submit" value="" />Toevoegen</button></span>
     </div>
   
    </form>
    <div id="uploadError"><?php echo $uploadMessage; ?></div>
</div>

<div id="dialog-opmerking" title="Opmerking plaatsen">
    <textarea id="opmerking" name="opmerking" rows="10" cols="62"></textarea><br />
    <!--<span id="opmerkingCounter">255</span>--> <span id="returnMessage" class="error"> </span>
</div>

<div id="dialog-onderhoud" title="Onderhoud plannen">
<input type="hidden" id="onderhoudId" name="onderhoudId" value="" />
    <table>
        <tr>
            <td><label for="onderhoudDatum">Datum: </label></td>
            <td><input type="text" id="onderhoudDatum" name="onderhoudDatum" value="" /></td>
        </tr>
        <tr>
            <td><label for="kilometerstand">Kilometerstand: </label></td>
            <td><input type="text" id="kilometerstand" name="kilometerstand" value="<?php echo $auto->auto_kilometerstand; ?>" /></td>
        </tr>
       <tr>
            <td><label for="onderhoudType">Type afspraak: </label></td>
            <td><?php echo onderhoudType(); ?></td>
        </tr>
        
        <tr>
            <td><label for="onderhoudOpmerking">Opmerking: </label></td>
            <td><textarea id="onderhoudOpmerking" name="onderhoudOpmerking" rows="10" cols="73" autofocus></textarea></td>
        </tr>
    </table>
    <!--<span id="onderhoudOpmerkingCounter">255</span>--> <div id="returnMessage" class="error">test </div>
    
</div>

<div id="dialog-preview-foto" title="<?php echo $auto->auto_kenteken; ?>">
    <?php if($auto->auto_foto) {
        echo '<img src="'.$auto->auto_foto.'" id="popup-preview-auto"/><br /><a href="#" id="fotoWijzigen">Wijzigen</a>';
    }
    
    
    echo '<br /><br /><div id="autoFoto-upload" style="'.(($auto->auto_foto) ? 'display:none' : '').'">
        <form enctype="multipart/form-data" method="post" action="http://app.imoby.nl/crm/auto/'.$auto->auto_id.'/autoFoto">
        <label for="userfile">Bestand:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <span class="fileBrowse">Bladeren</span><input type="file" name="userfile" size="20" /><span class="grey-text" id="uploadFileName">Geen bestand geselecteerd</span><br />
        <span class="grey-text">Let op: Het bestand mag niet groter zijn dan 5mb.<br /> (jpg, png, gif)</span><br />
        <span class="button-opslaan"><button class="button" type="submit" value="" /><img class="vinkje" src="'.BASE.'/crmAssets/images/vinkje.png" />Toevoegen</button></span>
     <input type="hidden" name="klantId" value="'.$auto->auto_klantId.'"/>
    </div>';
    
    ?>
</div>

<div id="dialog-auto-marketing-instellingen" title="Marketing Instellingen Auto">
    <table border="0" id="marketing-auto-tabel" style="width: 500px;">
        <?php if(count($marketingActies)) { $actieIds = array(); foreach($marketingActies as $actie) {  $actieIds[] = $actie->marketing_id; //print '<pre>'; print_r($actie); print '</pre>';?>
        <tr>
            <td><?php echo $actie->marketing_titel; ?></td>
            <td>
                <div id="klant_marketing" class="checkBoxSlider marketing_<?php echo $actie->marketing_id; ?>">
                    <button type="button" class="radioSliderTrue <?php echo ( ($actie->setting->marketing_inst_actief=='1') ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
                    <button type="button" class="radioSliderFalse  <?php echo ( ( ($actie->setting->marketing_inst_actief=='0') OR empty($actie->setting->marketing_inst_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
                    <input type="radio" name="marketing_<?php echo $actie->marketing_id; ?>" class="radioSliderOn marketing" value="1" <?php echo ($actie->setting->marketing_inst_actief=='1' ? 'checked="checked"' : ''); ?> />
                    <input type="radio" name="marketing_<?php echo $actie->marketing_id; ?>" class="radioSliderOff marketing" value="0" <?php echo ( ( ($actie->setting->marketing_inst_actief=='0') OR empty($actie->setting->marketing_inst_actief) ) ? 'checked="checked"' : ''); ?> />
                </div>
            </td>
        </tr>
        <?php  } } else{ echo 'U heeft nog geen auto specifieke marketing acties opgesteld.';} ?>
    </table>
</div>

<div id="dialog-auto-factuur" title="Factuur opmaken">
    <form id="auto-factuur-form">
     
    Factuurnummer: <input type="text" value="<?php echo $factuurNummer; ?>" name="factuurNummer" id="factuurNummer" maxlength="11" /><br />
    Omschrijving:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="" name="factuurOmschrijving" id="factuurOmschrijving" maxlength="255"/><br />
    <div id="factuur-error"></div>
        <table id="auto-factuur-tabel" cellspacing="10">
            <thead>
                <th style="width: 30px;">Aantal</th>
                <th style="width: 30px;">Prijs/stuk</th>
                <th >Item </th>
                <th style="width: 30px;">BTW%</th>
                <th style="width: 30px;">Totaal</th>
                <th style="width: 5px;">&nbsp;</th>
            </thead>
            <tbody>
            </tbody>
            <tfoot>  
                <tr id="newRow" style="display:none;">
                    <td><input type="text" name="aantal[]" id="aantal_" maxlength="3" size="8"/></td>
                    <td><input type="text" name="stukPrijs[]" id="stukPrijs_" maxlength="6" size="11" class="stukPrijs" /></td>
                    <td><?php echo factuurItems($factuurItems); ?></td>
                    <td><select class="btw" style="width:100%;" name="btw[]" id="btw_" > <option value="21" selected="selected">21%</option> <option value="6">6%</option>  <option value="0">0%</option> </select></td>
                    <td><input type="text" name="totaal[]" id="totaal_" maxlength="6" style="width:95%;" readonly="readonly"/></td>
                    <td class="remove-factuur-row"><img src="<?php echo base_url(); ?>crmAssets/images/delete.png" /></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">Subtotaal:&nbsp;&nbsp;</td>
                    <td style="text-align: right;">&euro;<span id="subTotaal"></span></td>
                    <td>&nbsp</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">Totaal btw:&nbsp;&nbsp;</td>
                    <td style="text-align: right;">&euro;<span id="totaalBtw"></span></td>
                    <td>&nbsp</td>
                </tr>
                 <tr>
                    <td colspan="4" style="text-align: right;">Totaal:&nbsp;&nbsp;</td>
                    <td style="text-align: right;">&euro;<span id="totaalPrijs"></span></td>
                    <td>&nbsp</td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<?php
function factuurItems($factuurItems){
    $selectbox = '<select class="factuurItems" name="factuurItem[]" style="width:100%;"><option value="">Selecteer</option>';
    if(count($factuurItems)){   
        foreach($factuurItems as $item){
            $selectbox .= '<option value="'.$item->item_id.'">'.$item->item_text.'</option>';
        }
    }
    $selectbox .= '<option value="anders">Anders</option></select>';
    return $selectbox;
}
function onderhoudType($type=false){
    $onderhoudtypes = array('APK', 'Grote onderhoudsbeurt', 'Kleine onderhoudsbeurt', 'Autobanden', 'Schadeherstel', 'Airco check', 'Overige onderhoud');
    $selectbox = '<select class="onderhoudType" name="onderhoudType" id="onderhoudType" ><option value="">Selecteer</option>';
    if(count($onderhoudtypes)){   
        foreach($onderhoudtypes as $item){
            $selectbox .= '<option value="'.$item.'">'.$item.'</option>';
        }
    }
    $selectbox .= '</select>';
    return $selectbox;
}

echo '<script type="text/javascript">'."\n";
echo "radioSlider('auto_actief');\n";
if(count($actieIds)){
    foreach($actieIds as $id){
        echo "radioSlider('marketing_".$id."');\n";
    }
}

if($uploadMessage){
    echo '$(document).ready(function(){ $("#dialog-bestand-upload").dialog( "open" ); }); ';
}

if($openFactuur){
    echo '$(document).ready(function(){ $("#dialog-auto-factuur").dialog( "open" ); }); ';
}
echo '</script>';
?>