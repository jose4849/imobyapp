<?php //print '<pre>'; print_r($klant); print '</pre>';  ?>

<div class="grayColumn">
    <div class="titleBar">Klantgegevens</div>
    <div class="contentBlock">
        <input class="hidden" type="text" name="klantId" id="klantId" value="<?php echo ($klant->klant_id) ? $klant->klant_id : 0; ?>"  />
        <div id="klant-formulier">
            <fieldset>
                <input type="radio" name="aanhef"  value="De Heer" <?php echo ( (($klant->klant_aanhef == 'De Heer') OR empty($klant->klant_aanhef)) ? 'checked="checked"' : ''); ?> /><label>De heer</label><input type="radio" name="aanhef" value="Mevrouw" <?php echo ($klant->klant_aanhef == 'Mevrouw' ? 'checked="checked"' : ''); ?> /><label>Mevrouw</label><br /> 
                <span class="person" title="Voornaam"></span><input type="text" name="voornaam" id="voornaam" value="<?php echo ($klant->klant_voornaam) ? $klant->klant_voornaam : 'Voornaam'; ?>"  /><br />
                <span class="person" title="Tussenvoegsel"></span><input type="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php echo ($klant->klant_tussenvoegsel) ? $klant->klant_tussenvoegsel : 'Tussenvoegsel'; ?>"  /><br />
                <span class="person" title="Achternaam"></span><input type="text" name="achternaam" id="achternaam" value="<?php echo ($klant->klant_achternaam) ? $klant->klant_achternaam : 'Achternaam'; ?>" /><br />
                <span class="briefcase" title="Bedrijfsnaam"></span><input type="text" name="bedrijfsnaam" id="bedrijfsnaam" value="<?php echo ($klant->klant_bedrijfsnaam) ? $klant->klant_bedrijfsnaam : 'Bedrijfsnaam'; ?>" /><br />
                <span class="person" title="Geboortedatum"></span><input type="text" name="geboortedatum" id="geboortedatum" value="<?php echo ($klant->klant_geboortedatum) ? (date("d-m-Y", strtotime($klant->klant_geboortedatum))) : 'Geboortedatum'; ?>" /><br />
                <span class="mail" title="Email"></span><input type="text" name="email" id="email" value="<?php echo ($klant->klant_email) ? $klant->klant_email : 'Email'; ?>" /><br />
            </fieldset>
            <fieldset>

                <label for="klant_actief" class="relatie">Relatie actief</label> 
                <span id="klant_actief" class="checkBoxSlider actief">
                    <button type="button" class="radioSliderTrue <?php echo ( ( ($klant->klant_actief == '1') OR ( empty($klant->klant_actief) && ($klant->klant_actief != '0') ) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
                    <button type="button" class="radioSliderFalse  <?php echo ( ( ($klant->klant_actief == '0') ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
                    <input type="radio" name="actief" class="radioSliderOn actief" value="1" <?php echo ($klant->klant_actief == '1' ? 'checked="checked"' : ''); ?> />
                    <input type="radio" name="actief" class="radioSliderOff actief" value="0" <?php echo ( ( ($klant->klant_actief == '0') OR empty($klant->klant_actief) ) ? 'checked="checked"' : ''); ?> />
                </span><br />

                <span class="house" title="Postcode"></span><input type="text" name="postcode" id="postcode" value="<?php echo ($klant->klant_postcode) ? $klant->klant_postcode : 'Postcode'; ?>"  maxlength="7" /><br />
                <span class="house" title="Adres"></span><input type="text" name="adres" id="adres" value="<?php echo ($klant->klant_adres) ? $klant->klant_adres : 'Adres'; ?>"  /><br />
                <span class="house" title="Huisnummer"></span><input type="text" name="huisnummer" id="huisnummer" value="<?php echo ($klant->klant_huisnummer) ? $klant->klant_huisnummer : 'Huisnummer'; ?>" /><br />
                <span class="house" title="Woonplaats"></span><input type="text" name="woonplaats" id="woonplaats" value="<?php echo ($klant->klant_woonplaats) ? $klant->klant_woonplaats : 'Woonplaats'; ?>" /><br />
                <span class="phone" title="Telefoon"></span><input type="text" name="telefoon" id="telefoon" value="<?php echo ($klant->klant_telefoon) ? $klant->klant_telefoon : 'Telefoon'; ?>" maxlength="11" /><br />
                <span class="mobile" title="Mobiel"></span><input type="text" name="mobiel" id="mobiel" value="<?php echo ($klant->klant_mobiel) ? $klant->klant_mobiel : 'Mobiel'; ?>" maxlength="11" /><br />
            </fieldset>

            <fieldset class="links">
                <a class="button" href="#"  id="factuur-opmaken"><img class="factuur" src="<?php echo base_url(); ?>assets/crmAssets/images/factuur.png" />Factuur<br />maken</a>
                <a class="button" href="#" id="marketing-instellingen"><img class="marketing" src="<?php echo base_url(); ?>assets/crmAssets/images/marketing.png" />Marketing instellingen</a>
                <a class="button" href="#" id="upload-bestand"><img class="marketing" src="<?php echo base_url(); ?>assets/crmAssets/images/file.png" />Bestand toevoegen</a>
                <a class="button" href="#" id="opmerking-maken"><img class="marketing" src="<?php echo base_url(); ?>assets/crmAssets/images/opmerking.png" />Opmerking maken</a>
                <a class="button" href="#" id="opmerking-maken"><img class="eMail" src="<?php echo base_url(); ?>assets/crmAssets/images/eMail.png" />Email<br>versturen</a>
                <a class="button opslaanSave" id="opSave" href="#"><img class="marketing" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png" />Opslaan</a>
            </fieldset>
        </div>
    </div>
</div>
<div class="grayColumn">
    <div class="titleBar">Gekoppelde auto's</div>
    <div class="contentBlock">
        <input type="text" name="zoekKenteken" id="kenteken-zoeken" maxlength="8" class="kenteken" value="<?php echo $koppelKenteken; ?>"/>
        <button class="button" id="kenteken-zoeken-start"><img class="add" src="<?php echo base_url(); ?>assets/crmAssets/images/add.png" />Voeg toe</button>
        <div id="suggestionHolder" style="" >
            <div id="kentekenSuggestions" style="" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable"></div>
        </div>

        <?php if (count($autos)) { ?>
            <hr />
            <table id="autos-tabel">
                <thead>
                <th>Foto</th>
                <th>Merk &amp; Type</th>
                <th>Bouwjaar</th>
                <th>Kenteken</th>
                <th>KM stand</th>
                <th>Status</th>
                </thead>

                <?php
                //print '<pre>'; print_r($autos); print '</pre>';
                foreach ($autos as $auto) {
                    echo $auto->auto_fotoUrl;
                    $image = ($auto->auto_foto) ? '<img src="' . $auto->auto_foto . '" style="width:118px;height:89px;" />' : '<img src="' . base_url() . 'assets/crmAssets/images/placeholder75x100.png" style="width:118px;height:89px;" />';

                    echo '<tr>
                <td class="image-container"><a href="' . base_url() . 'crm/auto/' . $auto->auto_id . '">' . $image . '</a></td>
                <td><a href="' . base_url() . 'crm/auto/' . $auto->auto_id . '" title="Bewerk auto jose">' . $auto->auto_merk . ' ' . $auto->auto_type . '</a></td>
                <td>' . $auto->auto_bouwjaar . '</td>
                <td><a href="' . base_url() . 'crm/auto/' . $auto->auto_id . '" title="Bewerk auto">' . $auto->auto_kenteken . '</a></td>
                <td>' . number_format($auto->auto_kilometerstand, 0, '.', '.') . '</td>
                <td class="status">' . $auto->auto_actief . ' <a href="' . base_url() . 'crm/auto/' . $auto->auto_id . '" title="Bewerk Auto"><img class="edit" src="' . base_url() . 'assets/crmAssets/images/edit.png" height="22" width="22" alt="Bewerk auto" /></a></td>
            </tr>';
                }
                ?>
            </table>

        <?php } ?>
    </div>
</div>
<?php if (count($bestanden)) { ?>
    <div class="grayColumn">
        <div class="titleBar">Bestanden</div>
        <div class="contentBlock">
            <table id="bestanden-tabel">
                <thead>
                <th>Datum</th>
                <th>Beschrijving</th>
                <th>Bestandsnaam</th>

                </thead>

                <?php
                //print '<pre>'; print_r($autos); print '</pre>';
                foreach ($autos as $auto) {
                    echo '<tr>
                    <td>' . $auto->klant_id . '</td>
                    <td>' . $auto->klant_voorvoegsel . ' ' . $auto->klant_voornaam . (($auto->klant_tussenvoegsel) ? ' ' . $auto->klant_tussenvoegsel : '') . ' ' . $auto->klant_achternaam . '</td>
                    <td>' . $auto->klant_adres . ' ' . $auto->klant_huisnummer . ' ' . $auto->klant_plaats . '</td>
                </tr>';
                }
                ?>        

            </table>

        </div>
    </div>
<?php } ?>
<?php if (count($facturen)) { ?>
    <div class="grayColumn">
        <div class="titleBar">Facturen</div>
        <div class="contentBlock">
            <table id="facturen-tabel">
                <thead>
                <th>Datum</th>
                <th>Beschrijving</th>
                <th>Bestandsnaam</th>

                </thead>

                <?php
                //print '<pre>'; print_r($autos); print '</pre>';
                foreach ($autos as $auto) {
                    echo '<tr>
                    <td>' . $auto->klant_id . '</td>
                    <td>' . $auto->klant_voorvoegsel . ' ' . $auto->klant_voornaam . (($auto->klant_tussenvoegsel) ? ' ' . $auto->klant_tussenvoegsel : '') . ' ' . $auto->klant_achternaam . '</td>
                    <td>' . $auto->klant_adres . ' ' . $auto->klant_huisnummer . ' ' . $auto->klant_plaats . '</td>
                </tr>';
                }
                ?>    
            </table>
        </div>
    </div>
<?php } ?>

<div id="dialog-kenteken-zoeken" title="Auto gevonden">
    <form id="form-kenteken-zoeken">
        <div id="rdwError" style="display:none;"></div>
        <fieldset style="float:left;display:inline;width:400px;">
            <label for="kenteken">Kenteken: </label><div id="kenteken"></div><br />			
            <label for="merk">Merk: </label><div id="merk"></div><br />			    
            <label for="type">Type: </label><div id="type"></div><br />
            <label for="model">Model: </label><div id="model"></div><br/ >
                <label for="bouwjaar">Bouwjaar: </label><div id="bouwjaar"></div><br/ >
                <label for="kilometerstand">Kilometerstand: </label><div id="kilometerstand"></div><br/ >
                <label for="transmissie">Transmissie: </label><div id="transmissie"></div><br/ >
                <label for="datumeersteafgiftenederland">Datum eerste afgifte: </label> <div id="datumeersteafgiftenederland"></div><br/ >
        </fieldset>

        <br />
        <!--<button id="addSpec">Specificatie toevoegen</button><br />-->

        <div id="fotoContainer"></div>
    </form>
    <img src="<?php echo base_url(); ?>assets/crmAssets/images/loading_bar.gif" id="kenteken-zoeken-loading"  style="display:none"/>
</div>



<div id="dialog-marketing-instellingen" title="Marketing Instellingen Klant">
    <table border="0" id="marketing-klant-tabel" style="width: 500px;">
        <tr>
            <td>Klant Marketing</td>
            <td>
                <div id="klant_marketing" class="checkBoxSlider marketing_klant">
                    <button type="button" class="radioSliderTrue <?php echo ( ($klant->klant_marketing == '1') ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
                    <button type="button" class="radioSliderFalse  <?php echo ( ( ($klant->klant_marketing == '0') OR empty($klant->klant_marketing) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
                    <input type="radio" name="marketing_klant" class="radioSliderOn marketing" value="1" <?php echo ($klant->klant_marketing == '1' ? 'checked="checked"' : ''); ?> />
                    <input type="radio" name="marketing_klant" class="radioSliderOff marketing" value="0" <?php echo ( ( ($klant->klant_marketing == '0') OR empty($klant->klant_marketing) ) ? 'checked="checked"' : ''); ?> />
                </div>
            </td>
        </tr>
        <?php if (count($marketingActies)) {
            $actieIds = array();
            foreach ($marketingActies as $actie) {
                $actieIds[] = $actie->marketing_id; //print '<pre>'; print_r($actie); print '</pre>'; ?>
                <tr>
                    <td><?php echo $actie->marketing_titel; ?></td>
                    <td>
                        <div id="klant_marketing" class="checkBoxSlider marketing_<?php echo $actie->marketing_id; ?>">
                            <button type="button" class="radioSliderTrue <?php echo ( ($actie->setting->marketing_inst_actief == '1') ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
                            <button type="button" class="radioSliderFalse  <?php echo ( ( ($actie->setting->marketing_inst_actief == '0') OR empty($actie->setting->marketing_inst_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
                            <input type="radio" name="marketing_<?php echo $actie->marketing_id; ?>" class="radioSliderOn marketing" value="1" <?php echo ($actie->setting->marketing_inst_actief == '1' ? 'checked="checked"' : ''); ?> />
                            <input type="radio" name="marketing_<?php echo $actie->marketing_id; ?>" class="radioSliderOff marketing" value="0" <?php echo ( ( ($actie->setting->marketing_inst_actief == '0') OR empty($actie->setting->marketing_inst_actief) ) ? 'checked="checked"' : ''); ?> />
                        </div>
                    </td>
                </tr>
    <?php }
} else {
    echo 'Er zijn nog geen klantspecifieke acties aangemaakt.';
} ?>
    </table>
</div>

<?php echo $this->load->view("crm/klant_invoice"); ?>


<!--
<div id="dialog-factuur" title="Factuur">
    <table border="0" id="auto-factuur-tabel" style="width: 400px;">
        <tr>
            <td>Selecteer auto: </td>
            <td>
<?php
if (is_array($autos)) {
    echo '<select name="factuurAuto" id="factuurAuto">';
    foreach ($autos as $key => $auto) {
        echo '<option value="' . $auto->auto_id . '">' . $auto->auto_merk . ' ' . $auto->auto_type . ' (' . $auto->auto_kenteken . ')</option>';
    }
    echo '</select>';
} else {
    echo 'Klant heeft geen auto\'s.';
}
?>
            </td>
        </tr>
    </table>
</div>
-->







<?php
echo '<script type="text/javascript">';
echo "radioSlider('marketing_klant');\n";
if (count($actieIds)) {
    foreach ($actieIds as $id) {
        echo "radioSlider('marketing_" . $id . "');\n";
    }
}

echo '$(document).ready(function(){';
if (($koppelKenteken) && ($klant->klant_id != 0)) {
    echo '$("#kenteken-zoeken-start").trigger("click");';
}


echo '});</script>';
?>