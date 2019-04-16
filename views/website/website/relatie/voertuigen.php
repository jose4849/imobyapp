<?php echo $header; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>crmAssets/css/jquery-ui-1.10.3.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>crmAssets/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>crmAssets/js/jquery-ui-1.10.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>crmAssets/js/jquery-ui-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>crmAssets/js/jquery.ui.datepicker-nl.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>crmAssets/js/crm.js?ts=1445341403"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>crmAssets/js/autos.js?ts=1445341403"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>crmAssets/js/facturen.js?ts=1445341403"></script>


<div id="cont_wrapper"> 
    <div class="cont_inner" style="padding-bottom:0px;">
        <h3 style="font-size: 28px; ">Mijn Auto's</h3>
        <select onchange="autoselect()" id="carid" class="top-car-select">
            <option value="">Select Auto</option>
            <?php
            $n = 0;
            foreach ($auto_ids as $auto_id) {
                ?>

                <option value="<?php echo $auto_id; ?>"><?php echo $auto_name[$n]; ?></option>
                <?php
                $n++;
            }
            ?>
        </select>
    </div>
</div>    
<div id="customer-cars">
    <div class="inner_content car-item">
        <div class="item-head">
            <div class="car-dec">
                <img height="133" width="167" alt="#" src="<?= base_url() ?>assets/images/car-7.jpg" />
                <div class="car-right">
                    <h1 class="car-tit"><?php echo $auto->auto_type; ?></h1>
                    <label class="car-model"><?php echo $auto->auto_kenteken; ?></label>
                    <label class="car-year"><?php echo $auto->auto_bouwjaar; ?></label>
                    <div class="car-status">
                        <span class="status-car">Status:</span>                         
                        <div style="line-height:20px;margin:3px 0 0 0; float: left">
                            <div id="auto_actief" class="checkBoxSlider auto_actief">
                                <button type="button" class="radioSliderTrue auto_actief <?php echo ( ($auto->auto_actief == '1') ? 'radioSliderActive' : 'radioSliderInactive'); ?> ">aan</button>
                                <button type="button" class="radioSliderFalse auto_actief <?php echo ( ( ($auto->auto_actief == '0') OR empty($auto->auto_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); ?>">uit</button><br />
                                <input type="radio" name="auto_actief" class="radioSliderOn auto_actief" value="1" <?php echo ($auto->auto_actief == '1' ? 'checked="checked"' : ''); ?> />
                                <input type="radio" name="auto_actief" class="radioSliderOff auto_actief" value="0" <?php echo ( ( ($auto->auto_actief == '0') OR empty($auto->auto_actief) ) ? 'checked="checked"' : ''); ?> />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-button">
                <input type="submit" id="onderhoud-maken" class="button" name="" value="Afspraak maken" />
                <input type="submit" id="opmerking-maken" class="button" name="" value="Notitie Maken" />
                <input type="submit" id="upload-bestand" class="button" name="" value="Document uploaden" />
            </div>
        </div>
        <script type="text/javascript">
            radioSlider('auto_actief');
            radioSlider('marketing_1');
            radioSlider('marketing_5');
            radioSlider('marketing_7');
            radioSlider('marketing_9');
            radioSlider('marketing_11');
            radioSlider('marketing_13');
            radioSlider('marketing_15');
            radioSlider('marketing_17');
        </script>  
        <div class="main">
            <div class="accordion-car">
                <div class="accordion-section">
                    <a class="accordion-section-title" href="#Kenmerken">Kenmerken</a>
                    <div id="Kenmerken" class="accordion-section-content open" style="display:block">


                        <table border="0" id="car-view-type" >
                            <tr>
                                <td>Merk:</td>
                                <td><span class="blueBold"><?php echo $auto->auto_merk; ?></span></td>
                                <td>Datum tenaamstelling:</td>
                                <td><span class="blueBold"><?php
                                        if ($auto->auto_datumaanvangtenaamstelling) {
                                            echo date("d-m-Y", strtotime($auto->auto_datumaanvangtenaamstelling));
                                        }
                                        ?></span></td>
                            </tr>
                            <tr>
                                <td>Type:</td>
                                <td><span class="blueBold"><?php echo $auto->auto_type; ?></span></td>
                                <td>APK-vervaldatum:</td>
                                <td><span class="blueBold"><?php
                                        if ($auto->auto_vervaldatumapk) {
                                            echo date("d-m-Y", strtotime($auto->auto_vervaldatumapk));
                                        }
                                        ?></span></td>
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
                                <td><span class="blueBold"><?php
                                        if ($auto->auto_kilometerstand) {
                                            echo number_format($auto->auto_kilometerstand, 0, ',', '.');
                                        }
                                        ?></span></td>
                                <td>Verkoopprijs:</td>
                                <td><span class="blueBold">&euro;</span></td>
                            </tr>
                            <tr>
                                <td>Carrosserievorm:</td>
                                <td><span class="blueBold"><?php echo (($auto->auto_carrosserievorm) ? $auto->auto_carrosserievorm : $auto->auto_inrichting); ?></span></td>
                                <td>Vraagprijs:</td>
                                <td><span class="blueBold">&euro;<?php
                                        if ($auto->auto_prijs) {
                                            echo number_format($auto->auto_prijs, 0, ',', '.');
                                        }
                                        ?></span></td>
                            </tr>        

                        </table>


                    </div>
                </div>
                <div class="accordion-section">
                    <a class="accordion-section-title" href="#Onderhoud">Onderhoud</a>
                    <div id="Onderhoud" class="accordion-section-content open" style="display:block" >
                        <table>
                            <thead>
                                <tr>
                                    <th>Datum</th>
                                    <th>Omschrijving</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($onderhoud as $onderhoud) { ?>
                                    <tr><td><?php echo date("d-m-Y H:i", strtotime($onderhoud->onderhoud_datum)) ?></td>  <td><?php echo $onderhoud->onderhoud_text; ?></td> <td></td></tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="accordion-section">
                    <a class="accordion-section-title" href="#Bestanden">Bestanden</a>
                    <div id="Bestanden" class="accordion-section-content open" style="display:block" >
                        <table border="0" id="auto-bestanden" >
                            <thead>
                            <th style="width:120px;">Datum</th>
                            <th>Omschrijving</th>
                            <th style="width:10px;">&nbsp;</th>
                            </thead>
                            <?php
                            if (is_array($bestanden)) {
                                $bestanden = array_reverse($bestanden);
                                foreach ($bestanden as $bestand) {
                                    echo '<tr><td>' . date("d-m-Y  H:i", strtotime($bestand->document_datum)) . '</td><td><a href="' . BASE . '/crm/auto/' . $auto->auto_id . '/bestand_' . $bestand->document_fileNaam . '" />' . $bestand->document_omschrijving . '</a></td></td>
             <td class="remove-bestand" style="text-align:center;" rel="' . $bestand->document_id . '">'
                                    . '<img src="' . BASE . '/crmAssets/images/delete.png" alt="Verwijderen" title="Verwijderen" />
                                                </td>
             </tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="accordion-section">
                    <a class="accordion-section-title" href="#Facturen">Facturen</a>
                    <div id="Facturen" class="accordion-section-content open" style="display:block">
                        <table border="0" id="auto-facturen" >
                            <thead>
                            <th style="width:120px;">Datum</th>
                            <th>Omschrijving</th>
                            </thead>
                            <?php
                            if (is_array($facturen)) {
                                $facturen = array_reverse($facturen);
                                foreach ($facturen as $factuur) {
                                    //print_r($factuur);
                                    echo '<tr><td>' . date("d-m-Y  H:i", strtotime($factuur->factuur_datum)) . '</td><td><a href="' . BASE . '/crm/auto/' . $auto->auto_id . '/pdf_' . $factuur->factuur_id . '" />' . $factuur->factuur_omschrijving . '</a></td></tr>';
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>                
                <div class="accordion-section">
                    <a class="accordion-section-title active" href="#Opmerkingen">Opmerkingen</a>
                    <div id="Opmerkingen" class="accordion-section-content open" style="display:block" >
                        <table border="0" id="auto-opmerkingen" >
                            <thead>
                            <th style="width:120px;">Datum</th>
                            <th>Opmerking</th>
                            <th style="width:10px;">&nbsp;</th>
                            </thead>
                            <?php
                            $this->load->helper('crm_upload_helper');
                            if (is_array($opmerkingen)) {
                                $opmerkingen = array_reverse($opmerkingen);
                                foreach ($opmerkingen as $opmerking) {
                                    $text = truncateText($opmerking->notitie_text, 'words', 10);
                                    echo '<tr><td>' . date("d-m-Y H:i", strtotime($opmerking->notitie_datum)) . '</td><td><a href="" class="edit-opmerking" id="' . $opmerking->notitie_id . '">' . nl2br($text) . '</a><span style="display:none;" id="opmerking_text-' . $opmerking->notitie_id . '">' . $opmerking->notitie_text . '</span></td>
            <td class="remove-notitie" style="text-align:center;" rel="' . $opmerking->notitie_id . '"><img src="' . BASE . '/crmAssets/images/delete.png" alt="Verwijderen" title="Verwijderen" /></td></tr>';
                                }
                            }
                            ?>
                        </table>

                    </div>
                </div>                
            </div>
        </div>
    </div>


    <br><br>
    <div class="top-form2 inner_content car-item">  


        <table border="0" id="marketing-auto-tabel" style="width: 500px;">
            <?php
            if (count($marketingActies)) {
                $actieIds = array();
                foreach ($marketingActies as $actie) {
                    $actieIds[] = $actie->marketing_id; //print '<pre>'; print_r($actie); print '</pre>'; 
                    ?>
                    <tr style="border:none;">
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
                    <?php
                }
            } else {
                echo 'U heeft nog geen auto specifieke marketing acties opgesteld.';
            }
            ?>
        </table>



        <div class="clr"></div>
        <p><input style="float:right" type="submit" class="button form1-submit" name="save" value="Opslaan"></p>
        <input type="hidden" id="autoId" value="<?php echo $auto->auto_id; ?>" />
    </div>     
</div>  

<?php $this->load->view('website/footer'); ?>
<div id="dialog-bestand-upload" title="Bestanden">
    <?php //echo form_open_multipart('crm/auto/'.$auto->auto_id.'/upload');    ?>
    <form enctype="multipart/form-data" style="margin: 0;" method="post" action="<?php echo base_url(); ?>crm/auto/<?php echo $auto->auto_id; ?>/upload" >
        <div id="bestand-upload" style="float: left;">
            <label for="userfile">Bestand:</label>
            <span class="fileBrowse">Bladeren</span>
            <input type="file" name="userfile" size="20" />
            <span class="grey-text" id="uploadFileName">Geen bestand geselecteerd</span><br />
            <span class="grey-text">Let op: Het bestand mag niet groter zijn dan 5mb.<br /> (pdf, jpg, doc, xls)</span>
        </div>
        <div id="bestand-upload-omschrijving" style=" margin-left: 20px; position: relative; float: right;">
            <label class="omschrijving">Omschrijving:</label><br />
            <input type="radio" name="omschrijvingType" value="standaard" checked="checked" />
            <label for="omschrijving" style="width:165px;">Standaard omschrijving:</label>
            <select class="grey-text" name="standaard">
                <option>Vrijwaringsbewijs</option>
                <option>Legitimatie</option>
                <option>Kenteken deel 3</option>
                <option>Koopovereenkomst</option>
            </select><br />
            <input type="radio" name="omschrijvingType" value="omschrijving" /><label for="omschrijving" style="width:165px;">Eigen omschrijving: </label><input type="text" name="omschrijving" id="omschrijving"  maxlength="255" size="25"/><br />
            <div class="ui-dialog-buttonpane ui-helper-clearfix">
                <div class="ui-dialog-buttonset">
                    <button type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                        <img src="<?php echo base_url(); ?>crmAssets/images/vinkje.png" class="vinkje">
                        <span class="ui-button-text">Toevoegen</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div id="uploadError"><?php echo $uploadMessage; ?></div>
</div>

<div id="dialog-opmerking" title="Opmerking plaatsen">
    <textarea id="opmerking" name="opmerking" rows="10" cols="62"></textarea><br />
    <input type="hidden" name="opmerkingId" id="opmerkingId" value="" />
    <!--<span id="opmerkingCounter">255</span>--> 
    <span id="returnMessage" class="error"> </span>
</div>


<div id="dialog-onderhoud" title="Onderhoud plannen">
    <input type="hidden" id="onderhoudId" name="onderhoudId" value="" />
    <table id="auto-onderhoud-table">
        <tr>
            <td><label class="onderhoudLabel" for="onderhoudDatum">Datum: </label></td>
            <td><input type="text" id="onderhoudDatum" name="onderhoudDatum" value="" /></td>
        </tr>
        <tr>
            <td><label class="onderhoudLabel" for="kilometerstand">Kilometerstand: </label></td>
            <td><input type="text" id="kilometerstand" name="kilometerstand" value="<?php echo $auto->auto_kilometerstand; ?>" /></td>
        </tr>
        <tr>
            <td><label class="onderhoudLabel" for="onderhoudType">Type afspraak: </label></td>
            <td><?php echo onderhoudType(); ?></td>
        </tr>

        <tr>
            <td><label class="onderhoudLabel" for="onderhoudOpmerking">Opmerking: </label></td>
            <td><textarea id="onderhoudOpmerking" name="onderhoudOpmerking" rows="10" cols="73" autofocus></textarea></td>
        </tr>
    </table>
    <!--<span id="onderhoudOpmerkingCounter">255</span>--> <div id="returnMessage" class="error">test </div>

</div>

<script type="text/javascript">

    function autoselect() {
        auto_id = ($('#carid').val());
        window.location.href = "<?php echo base_url('relatie/voertuigen'); ?>/" + auto_id;
    }

    jQuery(document).ready(function () {
        function close_accordion_section() {
            jQuery('.accordion-car .accordion-section-title').removeClass('active');
            jQuery('.accordion-car .accordion-section-content').slideUp(300).removeClass('open');
        }

        jQuery('.accordion-section-title').click(function (e) {
            // Grab current anchor value
            var currentAttrValue = jQuery(this).attr('href');

            if (jQuery(e.target).is('.active')) {
                close_accordion_section();
            } else {
                close_accordion_section();

                // Add active class to section title
                jQuery(this).addClass('active');
                // Open up the hidden content panel
                jQuery('.accordion-car ' + currentAttrValue).slideDown(300).addClass('open');
            }

            e.preventDefault();
        });
    });
</script>
<style>
    .checkBoxSlider {
        background: #00afd8 none repeat scroll 0 0;
        border: 1px solid #a9a9a9;
        border-radius: 5px;
        height: 23px;
        position: relative;
        width: 72px;
    }
    .checkBoxSlider button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #fff;
    }
    .checkBoxSlider .radioSliderTrue {
        height: 25px;
        left: 0;
        padding: 0;
        position: absolute;
        top: -3px;
        width: 38px;
    }
    .checkBoxSlider .radioSliderFalse {
        height: 25px;
        padding: 0;
        position: absolute;
        right: 0;
        top: -3px;
        width: 38px;
    }
    .radioSliderInactive, .radioSliderInactive {
        cursor: pointer;
    }
    .checkBoxSlider .radioSliderFalse.radioSliderInactive {
        right: -1px;
    }
    .checkBoxSlider .radioSliderTrue.radioSliderInactive {
        left: -1px;
    }
    .checkBoxSlider .radioSliderActive {
    }
    .checkBoxSlider .radioSliderInactive {
        background: #ffffff none repeat scroll 0 0;
        border: 1px solid #a9a9a9;
        border-radius: 5px;
        height: 25px;
        top: -1px;
        width: 38px;
    }
    .checkBoxSlider .radioSliderOn, .checkBoxSlider .radioSliderOff {
        display: none;
    }
    .contentBlock form table tr td a:link, .contentBlock form table tr td a:visited {
        color: #195d82;
        text-decoration: underline;
    }
    .contentBlock form table tr td a:hover, .contentBlock form table tr td a:active {
        text-decoration: none;
    }
    .ui-dialog .ui-dialog-content{    
        background: #f4f4f4;
    }
    .ui-dialog .ui-dialog-content form{ margin: 0;}
    .ui-dialog .ui-dialog-content label{ display: inline; cursor: default; font-size: 12px; margin: 0 8px;}
    .ui-dialog .ui-dialog-content select{
        color: #a2a2a2;
        height: 36px;
        margin: 0 11px 8px 2px;
        padding-bottom: 8px;
        padding-left: 17px;
        padding-top: 9px;
        width: 215px;
        border: none;
    }
    .ui-dialog .ui-dialog-content input[type="text"]{
        border: medium none;
        color: #a2a2a2;
        height: 34px;
        line-height: 33px;
        margin: 0 11px 8px;
        padding-left: 17px;
        width: 195px;
    }
    .ui-dialog-buttonset{
        margin-top: 40px;
    }
</style>

<?php
echo '<script type="text/javascript">' . "\n";
echo "radioSlider('auto_actief');\n";
if (count($actieIds)) {
    foreach ($actieIds as $id) {
        echo "radioSlider('marketing_" . $id . "');\n";
    }
}

if ($uploadMessage) {
    echo '$(document).ready(function(){  $("#dialog-bestand-upload").dialog( "open" ); }); ';
}

if ($openFactuur) {
    echo '$(document).ready(function(){ $("#dialog-auto-factuur").dialog( "open" ); }); ';
}
echo '</script>';
?>


</body>
</html>