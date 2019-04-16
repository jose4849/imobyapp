<div class="grayColumn">
    <div class="titleBar">Marketing</div>
    <div class="contentBlock marketingContent">        
        <a class="button Actie123" href="#" id="marketing-toevoegen"><img class="marketing" src="<?php echo base_url() ?>assets/crmAssets/images/marketing.png" />Actie<br />toevoegen</a><br />
        <?php
        $actieIds = array();
        foreach ($acties as $actie) {

            $actieIds[] = $actieId = 'actie_' . $actie->marketing_id . '_' . $actie->marketing_defaultId;
            ?> 
            <a name="<?php echo $actieId; ?>"></a> 
            <form class="marketingForm" id="<?php echo $actieId; ?>" method="POST" action="<?php echo BASE; ?>crm/marketing/edit#<?php echo $actieId; ?>" onSubmit="return checkForm('<?php echo $actieId; ?>');">
                <div class="marketingTitleBar" ><?php echo $actie->marketing_titel; ?> 
                    <div id="marketing" class="checkBoxSlider slider_<?php echo $actieId; ?>">
                        <button type="button" class="radioSliderTrue <?php echo ( ($actie->marketing_actief == '1') ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
                        <button type="button" class="radioSliderFalse  <?php echo ( ( ($actie->marketing_actief == '0') OR empty($actie->marketing_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
                        <input type="radio" rel="<? echo $actie->marketing_id; ?>" name="actief" class="radioSliderOn slider_<? echo $actieId; ?>" value="1" <?php echo ($actie->marketing_actief == '1' ? 'checked="checked"' : ''); ?> />
                        <input type="radio" rel="<? echo $actie->marketing_id; ?>" name="actief" class="radioSliderOff slider_<? echo $actieId; ?>" value="0" <?php echo ( ( ($actie->marketing_actief == '0') OR empty($actie->marketing_actief) ) ? 'checked="checked"' : ''); ?> />
                    </div>
                </div>
                <div style="display:none;" class="marketingActieContent">
                    <div id="messages_<?php echo $actieId; ?>" ><b><?php echo $messages[$actie->marketing_id . '_' . $actie->marketing_defaultId]; ?></b></div>
                    <?php // print '<pre>'; print_r($actie); print '</pre>'; ?>
                    <?php
                    if ($errors[$actie->marketing_id . '_' . $actie->marketing_defaultId]) {
                        echo '<div id="error">' . $errors[$actie->marketing_id . '_' . $actie->marketing_defaultId] . '</div>';
                    }
                    ?>
                    <input type="hidden" name="ids" value="<?php echo $actie->marketing_id . '_' . $actie->marketing_defaultId; ?>" />
                    <table border="0" cellspacing="0" cellpadding="0" class="marketingFormTable">
                        <tr>
                            <td style="padding:0 15px 0 0; width:175px; vertical-align:middle;">
                                <b>Onderwerp e-mailbericht:</b>
                            </td>
                            <td colspan="2" style="width:598px">
                                <label class="lefLabel">
                                    <input class="inputText" type="text" name="templateSubject" id="<?php echo $actieId; ?>_templateSubject" value="<?php echo $actie->marketing_template_subject; ?>" />
                                    <input type="button" class="sub-button" value="{{...}}" />
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:0 15px 0 0 ;width:175px;vertical-align:middle;">
                                <b>Aanhef:</b>
                            </td>
                            <td >
                                <?php echo aanhefSelect($actieId, $actie->marketing_template_aanhef); ?>
                            </td><td>
                                <?php echo aanhefNaam($actieId, $actie->marketing_template_aanhef_naam); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <textarea name="template" id="<?php echo $actieId; ?>_template" rows="15" style="width: 782px;"><?php echo $actie->marketing_template; ?></textarea> <br />

                            </td>
                        </tr>
                        <tr>
                            <td>     
                                <a href="<?php echo $actieId; ?>" rel="<?php echo $actie->marketing_defaultId; ?>"class="resetText">Reset tekst</a>
                            </td>
                            <td style="text-align: right;" colspan="2">     
                                <a href="<?php echo $actieId; ?>" class="exampleEmail">Voorbeeld</a>
                            </td>
                        </tr>                           
                        <tr>
                            <td style="padding:0 15px 0 0 ;width:175px; vertical-align:middle;">
                                <b>Afzender:</b>
                            </td>
                            <td>  
                                <?php echo afzenderSelect($actieId, $actie->marketing_template_afzender); ?>
                            </td><td>
                                <?php echo afzenderNaam($actieId, $actie->marketing_template_afzender_naam, $dealer); ?>

                            </td>
                        </tr>
    <!--                        <tr>
                            <td style="padding:0 15px 0 0 ;width:175px;text-align: right;vertical-align:middle;"><b>Bedrijfsgegevens:</b></td>
                            <td style="padding:0 0 0 15px width:178px;color:#A2A2A2;"><?php //echo $dealer->dealer_bedrijfsnaam;  ?><br /><?php //echo $dealer->dealer_adres . ' ' . $dealer->dealer_huisnummer;  ?><br /><?php echo $dealer->dealer_postcode . ' ' . $dealer->dealer_woonplaats; ?></td>
                            <td style="color:#A2A2A2;">Tel: <?php //echo $dealer->dealer_telefoon;  ?><br />Email: <?php //echo $dealer->dealer_email;  ?><br />Website: </td>
                        </tr>-->
                        <tr><td colspan="3">
                                <b style="display:block;line-height:25px;">
                                    <?php if ($actie->marketing_dataveld) : ?>
                                        Dit bericht verzenden  
                                        <?php
                                        if ($actie->marketing_verzendDataveldOp != 'op') {
                                            echo '<input type="text"  id="dataveldDagen_' . $actieId . '"  name="dataveldDagen" value="' . $actie->marketing_verzendDataveld . '" size="2" maxlenght="2" /> dagen ';
                                        } else {
                                            echo '<input type="hidden" id="dataveldDagen_' . $actieId . '" name="dataveldDagen" value="' . $actie->marketing_verzendDataveld . '" size="2" maxlenght="2" />';
                                        }
                                        ?>
                                        <?php echo dataveldOp($actie->marketing_verzendDataveldOp, true); ?> de <?php echo dataveld($actie->marketing_dataveld, true); ?> <br />
                                    <?php else : ?>
                                     <!--   <input type="radio" name="verzend_type" value="verzendOp" <?php echo (($actie->marketing_verzendOp != '') ? 'checked="checked"' : ''); ?> />--> dit bericht verzenden op <?php echo verzendOpDag($actie->marketing_verzendOpDay, $actieId); ?> <?php echo verzendOpMaand($actie->marketing_verzendOpMonth, $actieId); ?> van ieder jaar.<br />
                                    <?php endif; ?></b>
    <!--<label for="type">Dit is een marketing actie voor de</label> <?php echo actieType($actie->marketing_type); ?><br /> -->
                            </td></tr>

                        <tr><td colspan="3">
                                <button class="button" id="" style="10px;"><img class="vinkje" src="/assets/crmAssets/images/vinkje.png" />Opslaan</button>
                            </td></tr>
                    </table>
                    <br /><br /> <br /><br />   
                </div>
            </form>     
        <?php } ?>            
    </div>
</div>
</div>
<!--
<div class="grayColumn">
<div class="titleBar">Help Block</div>
    <div class="contentBlock">
    Uitleg {VARIABLEN}
    </div>
</div>
-->
<div id="defaultBoxes" style="display:none;">
    <?php echo aanhefSelect('DEFAULT', ''); ?>
    <?php echo afzenderSelect('DEFAULT', ''); ?>
</div>




<!--<div id="dialog-nieuwe-actie" title="Nieuwe marketing actie">
<?php $actieIds[] = $actieId = '0_0'; ?>
    <form id="<?php echo $actieId; ?>" method="POST" action="<?php echo BASE; ?>crm/marketing/edit" onSubmit="return checkForm('<?php echo $actieId; ?>');">
        <div class="contentBlock">
           <input type="hidden" name="ids" value="0_0" />
            Titel: <input type="text" name="title" id="<?php echo $actieId; ?>_title" value="" /> 
                <span class="actief"> Actief: </span>
                <div id="marketing" class="checkBoxSlider slider_<?php echo $actieId; ?>">
                <button type="button" class="radioSliderTrue radioSliderActive">aan</button>
                <button type="button" class="radioSliderFalse radioSliderInactive">uit</button><br />
                <input type="radio" name="actief" class="radioSliderOn slider_<? echo $actieId; ?>" value="1" checked="checked" />
                <input type="radio" name="actief" class="radioSliderOff slider_<? echo $actieId; ?>" value="0" />
            </div>
            <b>Bewerk hier uw email template:</b><br />
            -Email Onderwerp: <input type="text" name="templateSubject" id="<?php echo $actieId; ?>_templateSubject" value="" /><br /> 
            Email bericht:<br />
            <textarea name="template" id="<?php echo $actieId; ?>_template" rows="15" cols="90"></textarea> <br />
            <input type="radio" name="verzend_type" value="verzendDataveld" checked="checked" /> dit bericht verzenden  <input type="text" name="dataveldDagen" value="" size="2" maxlenght="2"  />  dagen <?php echo dataveldOp(); ?> de <?php echo dataveld(); ?> datum <br />
            <input type="radio" name="verzend_type" value="verzendOp"  /> dit bericht verzenden op <?php echo verzendOpDag(); ?> <?php echo verzendOpMaand(); ?><br />
             <button class="button" id=""><img class="vinkje" src="/assets/crmAssets/images/vinkje.png" />Opslaan</button>
        </div>
    </form>     
</div>-->

<div style="display:none" id="three" title="E-mail editor">


    <style type="text/css">

        .ui-dialog-content.ui-widget-content{
            overflow: hidden; padding: 0;
        }
        .email-editor{ width: 660px;  padding: 20px; background: #f4f4f4; border: 1px solid #e6e6e6; overflow: hidden;}
        .email-editor p{ line-height: 36px; margin-top: 0; margin-bottom: 10px;}
        .email-editor p textarea{ width: 97%; resize: none; height: 300px; border: 1px solid #e6e6e6; padding: 10px;}
        .email-editor input[type="radio"]{ margin-left: 5px; width: 10px; height: 10px; margin-right: 10px;}
        .email-editor input[type="text"]{ margin-left: 5px; width: 120px; padding: 0 10px; height: 36px; line-height: 36px; border: 1px solid #e4e4e4; color: #00afd8;}
        .email-editor p label{ position: relative; width: 500px; height: 36px; line-height: 36px; border: 1px solid #e4e4e4; background: #fff; float: right;}
        .email-editor input.email-note{ width: 430px; padding: 0 10px; height: 36px; line-height: 36px; border: none; float: left; margin: 0;}
        .email-editor input.sub-button{ width: 50px; height: 36px; line-height: 36px; color: #fff; text-align: center; float: right; cursor: pointer; border: none; background: #00afd8;}
        .email-editor input.from-to{ width: 480px; padding: 0 10px; height: 36px; line-height: 36px; border: 1px solid #e4e4e4; background: #fff; float: right;}
        p.vorige-button{float: left; }
        p.verzenden-button{float: right; position: relative; }
        p.vorige-button input.button.vorige{ background: #888888; padding: 0px; font-weight: bold;}
        input.button.verzenden{ position: static;}
    </style>

    <div class="email-editor">
        <form>
            <p>Aan:<input type="text" name="" placeholder="Dit bericht wordt verzonden aan ...... relaties" class="from-to" /></p>
            <p>Onderwerp e-mail:
                <label>
                    <input class="email-note" type="text" value="" name="" placeholder="" />
                    <input type="button" class="sub-button" value="{{...}}" />
                </label>
            </p> 
            <p><textarea></textarea></p> 
            <p ><input type="radio" />Dit bericht verzenden op
                <input type="text" name="" placeholder="30 - 01- 2016" />
<!--                    <input type="text" name="usr_time" value="" placeholder="00:00 uur" /> ---></p>
            <p><input type="radio" />Dit bericht nu verzenden</p>
            <p class="vorige-button"><input type="submit" class="button vorige" value="Vorige" /></p>
            <p class="verzenden-button">
                <img class="vinkje" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png" />
                <input type="submit"  class="button verzenden" value="Verzenden" />
            </p>
        </form>
    </div> 
</div>
<!--   ------------------------------- 2nd part ----------------------------------->


<div style="display:none" id="dialog-nieuwe-actie" title="Marketing e-mail opstellen">
    <style type="text/css">
        .ui-dialog-content.ui-widget-content{overflow: hidden; padding: 0;}
        .email-draft{ width: 400px; padding: 20px; background: #f4f4f4; border: 1px solid #e6e6e6; overflow: hidden;}
        .email-draft p{ width: 100%; float: left; margin: 4px 0;}
        .email-draft p label{ width: 50%; float: left; line-height: 36px;  font-weight: bold;}
        .email-draft p label select{ padding: 0 10px; width: 100%; border: 1px solid #e4e4e4; background: #fff; color: #185d82; height: 36px;}
        .email-draft p label span select{ width: 41.5%;}
        span.checkitem{ background: #fff; border: 1px solid #e4e4e4; float: right; border-top: none; padding: 10px; width: 44.3%;  line-height: 24px;}
        span.checkitem input[type="checkbox"]{ margin-right: 8px;}
        p.volgende-button{float: right; position: relative; margin-top: 100px; width: 30%; }
        p.volgende-button input.button.volgende{ position: static;}
    </style>
    <div class="email-draft">
        <h4>Kenmerken - Relatie</h4>
        <form>
            <p><label>Geslacht:</label><label><select><option>Beide</option><option>Beide</option><option>Beide</option><option>Beide</option><option>Beide</option></select></label></p>
            <p><label>Regio:</label>
                <label>
                    <select>
                        <option>Gelderland</option>
                        <option>Flevoland</option>
                        <option>Noord-Brabant</option>
                    </select>
                </label>

            </p>
            <p>
                <label>Leeftijd:</label>
                <label>
                    <span>
                        <select>
                            <option>18jr</option>
                            <option>18jr</option>
                            <option>18jr</option>
                            <option>18jr</option>
                            <option>18jr</option>
                        </select>
                    </span>
                    t/m
                    <span>
                        <select>
                            <option>50jr</option>
                            <option>50jr</option>
                            <option>50jr</option>
                            <option>50jr</option>
                        </select>
                    </span>
                </label>                
            </p>
            <p class="volgende-button">
                <img class="vinkje" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png" />
                <input type="submit" id="marketing2" class="button volgende" value="Volgende" />
            </p>
        </form>
    </div>
    <!------------------------end of two----------->








    <div style="display:none" id="one" title="Marketing e-mail opstellen">    
        <style type="text/css">
            .ui-dialog-content.ui-widget-content{
                overflow: hidden; padding: 0;
            }
            .email-draft2{ width: 400px; padding: 20px; background: #f4f4f4; border: 1px solid #e6e6e6; overflow: hidden;}
            .email-draft2 p{ width: 100%; float: left; margin: 4px 0;}
            .email-draft2 p label{ width: 50%; float: left; line-height: 36px;  font-weight: bold;}
            .email-draft2 p label select{ padding: 0 10px; width: 100%; border: 1px solid #e4e4e4; background: #fff; color: #185d82; height: 36px;}
            .email-draft2 p label span select{ width: 41.5%;}
            span.checkitem2{ background: #fff; border: 1px solid #e4e4e4; float: right; border-top: none; padding: 10px; width: 44.3%;  line-height: 24px;}
            span.checkitem2:last-child{  margin-bottom: 40px;}
            span.checkitem2 input[type="checkbox"]{  margin-right: 8px;}
            p.volgende-button{float: right; position: relative; margin-top: 100px; width: 30%; }
            p.volgende-button input.button.volgende{ position: static;}
        </style>
        <div class="email-draft2">
            <h4>Kenmerken - Voertuig</h4>
            <form>
                <p>
                    <label>Merk:</label>
                    <label>
                        <select>
                            <option>Gelderland</option>
                            <option>Flevoland</option>
                            <option>Noord-Brabant</option>
                        </select>
                    </label>

                </p>
                <p><label>Type:</label>
                    <label>
                        <select>
                            <option>Gelderland</option>
                            <option>Flevoland</option>
                            <option>Noord-Brabant</option>
                        </select>
                    </label>

                </p>
                <p>
                    <label>Bouwjaar:</label>
                    <label>
                        <span>
                            <select>
                                <option>2001</option>
                                <option>18jr</option>
                                <option>18jr</option>
                                <option>18jr</option>
                                <option>18jr</option>
                            </select>
                        </span>
                        t/m
                        <span>
                            <select>
                                <option>2010</option>
                                <option>50jr</option>
                                <option>50jr</option>
                                <option>50jr</option>
                            </select>
                        </span>
                    </label>                
                </p>
                <p class="volgende-button">
                    <img class="vinkje" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png" />
                    <input id="marketing3" type="submit" class="button volgende" value="Volgende" />
                </p>
            </form>
        </div>
    </div>









    <div id="dialog-email-example" title="Email voorbeeld">
        <div id="emailAanhef"></div><br />
        <div id="emailBody"></div><br />
        <div id="emailAfzender"></div>
    </div>
    <?php

    function dataveldDagen($selectedDag = false) {
        $dagenArray = array(0, 7, 14, 21, 28);
        $selectBox = '<select name="dataveldDagen">';
        foreach ($dagenArray as $dagen) {
            $selected = ($selectedDag == $dagen) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $dagen . '" ' . $selected . '>' . $dagen . '</option>';
        }
        $selectBox .= '</select>';
        return $selectBox;
    }

    function dataveldOp($selectedOp = false, $nameOnly = false) {
        $opArray = array('voor' => 'voor', 'na' => 'na', 'op' => 'op');
        $selectBox = '<select name="verzendDataveldOp">';
        foreach ($opArray as $op) {
            $selected = ($selectedOp == $op) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $op . '" ' . $selected . '>' . $op . '</option>';
        }
        $selectBox .= '</select>';

        if ($nameOnly) {
            $selectBox = $opArray[$selectedOp] . '<input type="hidden" name="verzendDataveldOp" value="' . $selectedOp . '">';
        }
        return $selectBox;
    }

    function dataveld($dataveld = false, $nameOnly = false) {
        $typeArray = array(
            'auto_vervaldatumapk' => 'APK vervaldatum',
            'auto_aankoopdatum' => 'aankoopdatum',
            'klant_geboortedatum' => 'geboortedatum',
            'onderhoud_datum' => 'de laatste onderhouds beurt'
        );

        $selectBox = '<select name="dataveld">';
        foreach ($typeArray as $veld => $veldNaam) {
            $selected = ($dataveld == $veld) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $veld . '" ' . $selected . '>' . $veldNaam . '</option>';
        }
        $selectBox .= '</select>';
        if ($nameOnly) {
            $selectBox = $typeArray[$dataveld];
        }
        return $selectBox;
    }

    function verzendOpDag($dag = false, $id = false) {
        $selectBox = '<select class="date1" name="verzendOpDag" id="dag_' . $id . '" >';
        for ($i = 1; $i <= 31; $i++) {
            //echo $dag.'=d='.$i.'<br />';
            $selected = ($dag == $i) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
        }
        $selectBox .= '</select>';
        return $selectBox;
    }

    function verzendOpMaand($maand = false, $id = false) {
        $names = array('', 'januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december');

        $selectBox = '<select class="maand2" name="verzendOpMaand" id="maand_' . $id . '">';
        for ($i = 1; $i <= 12; $i++) {
            $maxDays = cal_days_in_month(CAL_GREGORIAN, $i, date("Y"));
            $selected = ($maand == $i) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $i . '" ' . $selected . ' days="' . $maxDays . '">' . $names[$i] . '</option>';
        }
        $selectBox .= '</select>';
        return $selectBox;
    }

    function actieType($type = false) {
        $selectBox = '<select name="type">';
        $selected[$type] = 'selected="selected"';
        $selectBox .= '<option value="auto" ' . $selected['auto'] . '>auto</option>';
        $selectBox .= '<option value="klant" ' . $selected['klant'] . '>klant</option>';
        $selectBox .= '</select>';
        return $selectBox;
    }

    function aanhefSelect($id, $selectedKey = false) {
        $names = array('Geachte heer/mevrouw', 'Beste', 'Geen aanhef', 'Vrije invoer');

        $selectBox = '<select name="templateAanhef" id="templateAanhef_' . $id . '" style="" class="vrijeInvoer" >';
        foreach ($names as $name) {
            $selected = ($selectedKey == $name) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $name . '" ' . $selected . '>' . $name . '</option>';
        }
        if (!in_array($selectedKey, $names) && !empty($selectedKey)) {
            $selectBox .= '<option value="' . $selectedKey . '" selected="selected">' . $selectedKey . '</option>';
        }
        $selectBox .= '</select>';
        return $selectBox;
    }

    function aanhefNaam($id, $selectedKey = false) {

        $names = array('{{ACHTERNAAM}}' => 'Achternaam, ', '{{VOORNAAM}}' => 'Naam, ', '{{VOLLEDIGENAAM}}' => 'Naam en achternaam, ', '{{NONE}}' => 'Geen naam, ');
        $selectBox = '<select name="templateAanhefNaam" id="templateAanhefNaam_' . $id . '" style="float:right;">';
        foreach ($names as $key => $name) {
            $selected = ($selectedKey == $key) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $key . '" ' . $selected . '>' . $name . '</option>';
        }
        $selectBox .= '</select>';
        return $selectBox;
    }

    function afzenderSelect($id, $selectedKey = false) {
        $names = array('Met vriendelijke groet', 'Groet', 'Hoogachtend', 'Geen afsluiting', 'Vrije invoer');

        $selectBox = '<select name="templateAfzender" id="templateAfzender_' . $id . '" style="" class="vrijeInvoer" >';
        foreach ($names as $name) {
            $selected = ($selectedKey == $name) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $name . '" ' . $selected . '>' . $name . ',</option>';
        }
        if (!in_array($selectedKey, $names) && !empty($selectedKey)) {
            $selectBox .= '<option value="' . $selectedKey . '" selected="selected">' . $selectedKey . ',</option>';
        }
        $selectBox .= '</select>';
        return $selectBox;
    }

    function afzenderNaam($id, $selectedKey = false, $dealer) {
        $names = array('{{DEALERACHTERNAAM}}' => 'Achternaam', '{{DEALERVOORNAAM}}' => 'Naam', '{{DEALERVOLLEDIGENAAM}}' => 'Naam en achternaam', '{{NONE}}' => 'Geen naam', '{{BEDRIJFSNAAM}}' => 'Bedrijfsnaam');

        $selectBox = '<select name="templateAfzenderNaam" id="templateAfzenderNaam_' . $id . '" style="float:right;">';
        foreach ($names as $key => $name) {
            $selected = ($selectedKey == $key) ? 'selected="selected"' : '';
            $selectBox .= '<option value="' . $key . '" ' . $selected . '>' . replaceDealerName($dealer, $name) . '</option>';
        }
        $selectBox .= '</select>';
        return $selectBox;
    }

    function replaceDealerName($dealer, $name) {
        if ($dealer->dealer_achternaam) {
            $name = str_replace('Achternaam', $dealer->dealer_achternaam, $name);
            $name = str_replace('en achternaam', $dealer->dealer_achternaam, $name);
        }
        if ($dealer->dealer_voornaam) {
            $name = str_replace('Naam', $dealer->dealer_voornaam, $name);
        }
        if ($dealer->dealer_bedrijfsnaam) {
            $name = str_replace('Bedrijfsnaam', $dealer->dealer_bedrijfsnaam, $name);
        }
        return $name;
    }

    echo '<script type="text/javascript">';
    if (count($actieIds)) {
        foreach ($actieIds as $id) {
            echo "radioSlider('slider_" . $id . "');\n";
        }
    }
    if ($_POST['ids']) {
        echo "$('#messages_actie_" . $_POST['ids'] . "').parent().show();";
    }
    if ($exampleUser) {
        echo 'var exampleUser = ' . $exampleUser . ';';
    }
    if ($defaultText) {
        echo 'var defaultText = ' . $defaultText . ';';
    }
    echo '</script>';
    ?>
