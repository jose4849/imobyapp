<?php //print '<pre>'; print_r($facturen); print '</pre>'; ?>
<div class="grayColumn">
    <div class="titleBar">Facturen</div>
    <div class="contentBlock">
        <a href="#" class="button" id="verwijder-factuur"><img class="kruisje" src="<?php echo base_url(); ?>assets/crmAssets/images/kruisje.png" />Verwijderen</a>
        <div class="contant-white">
        <form id="facturen-filter" method="POST" action="<?php echo base_url(); ?>crm/facturen/zoeken'; ?>">
            <table id="facturen-tabel" cellspacing="0" sellpadding="0" id="autos-tabel-overview" style="background: white;">
            <thead>
                <th class="factuurNr"><span class="tableHeaderLabel">Factuurnr.</span><br /><input class="factuurNr" type="text" name="factuurId" maxlength="10" size="4" value="<?php //echo $_POST['factuurId']; ?>" /></th>
                <th class="naam"><span class="tableHeaderLabel">Naam</span><br /><input class="naam" type="text" name="naam"  size="10" value="<?php //echo $_POST['naam']; ?>" /></th>
                <th class="adresWoonplaats"><span class="tableHeaderLabel">Adres &amp; Woonplaats</span><br /><input class="adresWoonplaats" type="text" name="adres_woonplaats" size="25" value="<?php //echo $_POST['adres_woonplaats']; ?>" /></th>
                <th class="kenteken"><span class="tableHeaderLabel">Kenteken</span><br /><input class="kenteken" type="text" name="kenteken" maxlength="8" size="8"value="<?php //echo $_POST['kenteken']; ?>" /></th>
                <th class="omschrijving"><span class="tableHeaderLabel">Omschrijving</span><br /><input class="omschrijving" type="text" name="factuurOmschrijving" size="10" value="<?php //echo $_POST['factuurOmschrijving']; ?>" /></th>
                <th class="datum"><span class="tableHeaderLabel">Datum</span><br /><input class="datum" type="text" name="factuurDatum" maxlength="10" size="10" value="<?php //echo $_POST['factuurDatum']; ?>" /></th>
            </thead>
             </form>
             <form id="delete-factuur-form" action="<?php echo base_url(); ?>crm/facturen/" method="POST" style="padding:0;margin:0;width:18px;display:inline;">
            <?php
            $base=base_url();
            if(is_array($facturen)){
                $i = 0;
                foreach($facturen as $key => $factuurData){   
                    //if($i==0) { $factuurData['factuurId'] = 'testinglongname'; }
                    $facId = (strlen($factuurData['factuurId'])>3) ? '<label for="deleteFactuur" title="'.$factuurData['factuurId'].'" style="cursor:pointer;">'.substr($factuurData['factuurId'], 0, 5).'...</label>' : $factuurData['factuurId'];//'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$factuurData['factuurId'];
                    echo '<tr>';
                    if($factuurData['deleteFactuur']){ 
                        echo  '<td><span style=" position: relative; top: 2px;"><input style="margin:0;height:11px;" type="checkbox" name="deleteFactuur" id="deleteFactuur" value="'.$factuurData['factuurId'].'" /></span> '.$facId.'</td>'; 
                    }
                    else {
                        echo '<td >'.$facId.'</td>';
                    }
                    echo '<td><a href="'.$base.'crm/relatie/'.$factuurData['factuurKlantId'].'" title="Bewerk relatie">'.$factuurData['klant_naam'].'</a></td>
                        <td>'.$factuurData['klant_adres_woonplaats'].'</td>
                        <td><a href="'.$base.'crm/auto/'.$factuurData['factuurAutoId'].'" title="Bewerk auto">'.$factuurData['auto_kenteken'].'</a></td>
                        <td><a href="'.$base.'crm/auto/'.$factuurData['factuurAutoId'].'/pdf_'.$factuurData['factuurId'].'" title="Download factuur">'.$factuurData['factuurOmschrijving'].'</a></td>
                        <td>'.date("d-m-Y", strtotime($factuurData['factuurDatum'])).'</td>
                    </tr>';
                    $i++;
                }
            }
            ?>
            </table>
        </form>
            <br><br>
            <div class="contant-white-bottom">
                <div class="page-left-t"><span>20 item</span></div>
                <div class="page-nav"><span>&nbsp;</span></div>
            </div>
        </div>
    </div>
</div>

