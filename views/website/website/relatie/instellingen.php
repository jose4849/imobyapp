<?php echo $header; ?>
<link rel="stylesheet" href="http://192.168.0.17/crmAssets/css/jquery-ui-1.10.3.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="http://192.168.0.17/crmAssets/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="http://192.168.0.17/crmAssets/js/jquery-ui-1.10.3.js"></script>
<script type="text/javascript" src="http://192.168.0.17/crmAssets/js/jquery-ui-timepicker.js"></script>
<script type="text/javascript" src="http://192.168.0.17/crmAssets/js/jquery.ui.datepicker-nl.js"></script>
<script type="text/javascript" src="http://192.168.0.17/crmAssets/js/crm.js?ts=1445347208"></script>
<script type="text/javascript" src="http://192.168.0.17/crmAssets/js/klanten.js?ts=1445347208"></script>
<script type="text/javascript" src="http://192.168.0.17/crmAssets/js/autos.js?ts=1445347208"></script>


<div id="cont_wrapper"> 
    <div class="cont_inner" style="padding-bottom:0px;">
        <h3 style="font-size: 28px; ">Mijn Instellingen</h3>

    </div>
</div>    
<div id="" class="bg-white">
    <div class="inner_content">
        <div id="klant-formulier" class="top-form1">
            <form>
                <div class="mr-mrs">
                    <input class="hidden" type="text" name="klantId" id="klantId" value="<?php echo ($klant->klant_id) ? $klant->klant_id : 0; ?>"  />
                    <input style="display:inline" type="radio" name="aanhef"  value="De Heer" <?php echo ( (($klant->klant_aanhef == 'De Heer') OR empty($klant->klant_aanhef)) ? 'checked="checked"' : ''); ?> />
                    <label style="display:inline" >De heer</label>
                    <input style="display:inline"  type="radio" name="aanhef" value="Mevrouw" <?php echo ($klant->klant_aanhef == 'Mevrouw' ? 'checked="checked"' : ''); ?> />
                    <label style="display:inline" >Mevrouw</label><br /> 
                </div>
                <p>
                    <label><span>Naam</span><input title="text" name="voornaam" id="voornaam" value="<?php echo ($klant->klant_voornaam) ? $klant->klant_voornaam : 'Voornaam'; ?>" name="" placeholder="" /></label>
                    <label><span>Tussenvoegsel</span><input title="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php echo ($klant->klant_tussenvoegsel) ? $klant->klant_tussenvoegsel : 'Tussenvoegsel'; ?>" placeholder="" /></label>
                    <label><span>Achternaam</span><input title="text" name="achternaam" id="achternaam" value="<?php echo ($klant->klant_achternaam) ? $klant->klant_achternaam : 'Achternaam'; ?>" /></label>
                    <label><span>Straatnaam</span><input title="text" name="bedrijfsnaam" id="bedrijfsnaam" value="<?php echo ($klant->klant_bedrijfsnaam) ? $klant->klant_bedrijfsnaam : 'Bedrijfsnaam'; ?>" /></label>
                    <label><span>Postcode</span><input title="text" name="postcode" id="postcode" value="<?php echo ($klant->klant_postcode) ? $klant->klant_postcode : 'Postcode'; ?>" /></label>
                    <label><span>Huisnummer</span><input title="text" name="huisnummer" id="huisnummer" value="<?php echo ($klant->klant_huisnummer) ? $klant->klant_huisnummer : 'Huisnummer'; ?>" /></label>
                </p>
                <p>
                    <label><span>Woonplaats</span><input title="text" name="woonplaats" id="woonplaats" value="<?php echo ($klant->klant_woonplaats) ? $klant->klant_woonplaats : 'Woonplaats'; ?>" /></label>
                    <label><span>Telefoonnr.</span><input title="text" name="telefoon" id="telefoon" value="<?php echo ($klant->klant_telefoon) ? $klant->klant_telefoon : 'Telefoon'; ?>" placeholder="" /></label>
                    <label><span>Mobiel</span><input title="text" name="mobiel" id="mobiel" value="<?php echo ($klant->klant_mobiel) ? $klant->klant_mobiel : 'Mobiel'; ?>" placeholder="" /></label>
                    <label><span>E-mailadres</span><input name="email" id="email" value="<?php echo ($klant->klant_email) ? $klant->klant_email : 'Email'; ?>" /></label>
                    <label><span>Geb. datum</span><input title="text" name="geboortedatum" id="geboortedatum" value="<?php echo ($klant->klant_geboortedatum) ? (date("d-m-Y", strtotime($klant->klant_geboortedatum))) : 'Geboortedatum'; ?>" placeholder="" /></label>
                    <label><span>Bedrijfsnaam</span><input title="text" name="bedrijfsnaam" id="bedrijfsnaam" value="<?php echo ($klant->klant_bedrijfsnaam) ? $klant->klant_bedrijfsnaam : 'Bedrijfsnaam'; ?>" /></label>
                </p>
                <!--<input type="submit" class="button form1-submit" name="save" value="Opslaan">-->
            </form>
        </div>
        <div class="top-form2">
            <table border="0" id="marketing-klant-tabel" style="width: 500px;">
                <tr style="border:none;">
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
    <?php }
} else {
    echo 'Er zijn nog geen klantspecifieke acties aangemaakt.';
} ?>
            </table>
        </div>    


        <div class="top-form2">  

            <div class="clr"></div>
            <form action="javascript:void(0)">
                <p id="msg" style="color:red;"></p>
                <p>
                    <span>Gebruikersnaam</span>
                    <label><input readonly type="text" value="" id="klant_email" /></label>
                </p>
                <p>
                    <span>Nieuw wachtwoord</span>
                    <label><input type="password" id="newpass" value="" /></label>
                </p>
                <p>
                    <span>Bevestig wachtwoord</span>
                    <label><input type="password" id="confirmpass" value="" /></label>
                    <input onclick="resetemail()" type="submit" class="button form1-submit" name="save" value="Opslaan">
                </p>
            </form>
        </div>
        <script>
            function resetemail(){ 
                var newpass=$('#newpass').val();
                var confirmpass=$('#confirmpass').val();
                var klant_email=$('#klant_email').val();
                if(newpass==confirmpass){
                    $.ajax({
                        url:"<?php echo base_url(); ?>home/resetpass",
                        data:{ 	
                            klant_pass:newpass,klant_email:klant_email
                        },
                        type:"POST",
                        
                        success:function(result){
                            alert(result);
                        }       
                    }); 
                }
                else{
                    $('#msg').html('Password not match.');
                }
            }        
        
        
        </script>     




    </div>
</div>

<?php $this->load->view('website/footer'); ?>

<?php
echo '<script type="text/javascript">';


echo '$(document).ready(function(){';
echo "radioSlider('marketing_klant');\n";
if (count($actieIds)) {
    foreach ($actieIds as $id) {
        echo "radioSlider('marketing_" . $id . "');\n";
    }
}

echo '});</script>';
?>
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

</style>
</body>
</html>