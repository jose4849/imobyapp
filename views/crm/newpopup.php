<div id="dialog-auto-marketing-instellingen" title="Marketing Instellingen Auto">
    <!--<table border="0" id="marketing-auto-tabel" style="width: 500px;">
    <?php
    if (count($marketingActies)) {
        $actieIds = array();
        foreach ($marketingActies as $actie) {
            $actieIds[] = $actie->marketing_id; //print '<pre>'; print_r($actie); print '</pre>'; 
            ?>
                                                                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                                                                    <td><?php echo $actie->marketing_titel; ?>asdfasdfdfas</td>
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
    </table-->
    <style>
        .factuur-maken{}
        .factuur-maken p{ border-bottom: 1px solid #e1e1e1; margin: 0px; padding: 8px 0; color: #2f2f2f;}
        .factuur-maken p:last-child{ border: none;}
        .factuur-maken p input[type="radio"]{ margin-right: 10px;}
        .factuur-maken2{}
        .factuur-maken2 p{ margin: 0px; padding: 8px 0; color: #2f2f2f; font-weight: bold;}
        .factuur-maken2 p input[type="radio"]{ margin-right: 10px;}
        .factuur-maken2 p.invoice-number label{ font-weight: normal; line-height: 37px; margin-right: 20px;}
        .factuur-maken2 p.invoice-number input[type="text"]{ float: right; border: 1px solid #e8e8e8; width: 143px; padding:0 5px; height: 35px; line-height: 34px; }
        .factuur-maken2 p.description label{ font-weight: normal; line-height: 37px; margin-right: 20px;}
        .factuur-maken2 p.description input[type="text"]{ float: right; border: 1px solid #e8e8e8; width: 204px; padding:0 5px; height: 35px; line-height: 34px; }
        .text-editor{
            border: 1px solid #c1c1c1; margin-bottom: 20px;
        }
        .text-editor textarea{
            border: 1px solid #e4e4e4; width: 95%; padding: 10px; margin: 10px; margin: 5px; resize: none;
        }
        table.purchasing-car{  margin-bottom: 10px; width: 100%;}
        table.purchasing-car thead{}
        table.purchasing-car thead tr{}
        table.purchasing-car thead tr th{ text-align: left; padding: 10px;}
        table.purchasing-car tbody {}
        table.purchasing-car tbody tr{}
        table.purchasing-car tbody tr td{ text-align: left; padding: 3px 10px; color: #3d3d3d; font-weight: bold;}
        table.selling-car{  margin-bottom: 10px; width: 100%;}
        table.selling-car thead{}
        table.selling-car thead tr{}
        table.selling-car thead tr th{ text-align: left; padding: 10px;}
        table.selling-car tbody {}
        table.selling-car tbody tr{ margin-bottom: 10px;}
        table.selling-car tbody tr td{ text-align: left; padding: 3px 10px; color: #3d3d3d; font-weight: bold;}
        table.remaining{  margin-bottom: 10px; width: 100%;}
        table.remaining thead{}
        table.remaining thead tr{}
        table.remaining thead tr th{ text-align: left; padding: 10px;}
        table.remaining tbody { margin-bottom: 10px;}
        table.remaining tbody tr{}
        table.remaining tbody tr td{  text-align: left; padding: 3px 10px; color: #3d3d3d; font-weight: bold;}
        table.total{  margin-bottom: 10px; width: 100%;}
        table.total thead{}
        table.total thead tr{}
        table.total thead tr th{ background: #185d82;  text-align: left; padding: 10px;}
        table.total tbody{ margin-bottom: 10px;}
        table.total tbody tr{}
        table.total tbody tr td{ text-align: right; padding: 3px 10px; font-weight: bold;}
        table.total tfoot{}
        table.total tfoot tr{}
        table.total tfoot tr td{ padding: 3px 10px;}
    </style>
    <div class="factuur-maken">
        <p><input type="radio" />Verkoop</p>
        <p><input type="radio" />Verkoop/Inkoop</p>
        <p><input type="radio" />Inkoop</p>
        <p><input type="radio" />APK/Onderhoud</p>
    </div>
    <div class="factuur-maken2">
        <p><input type="radio" />Verkoop</p>
        <p><input type="radio" />Verkoop/Inkoop</p>
        <p><input type="radio" />Inkoop</p>
        <p><input type="radio" />APK/Onderhoud</p>
        <p class="invoice-number"><label>Factuurnummer<img src="<?php echo base_url(); ?>assets/crmAssets/images/i-icon.png"></label><input type="text" name="invoice number" value="" /></p>
        <p class="description"><label>Omschrijving</label><input type="text" name="Description" value="" /></p>
    </div>
    <div class="text-editor">
        <p>
            <textarea></textarea>
        </p>
        <table class="purchasing-car">
            <thead>
                <tr>
                    <th>Inkoop auto</th>
                    <th>tot. ex BTW</th>
                    <th>BTW%</th> 
                    <th>BTW bedrag</th>
                    <th>tot. incl BTW</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
            </tbody>
        </table>
        <table class="selling-car">
            <thead>
                <tr>
                    <th>Verkoop auto</th>
                    <th>tot. ex BTW</th>
                    <th>BTW%</th> 
                    <th>BTW bedrag</th>
                    <th>tot. incl BTW</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
            </tbody>
        </table>
        <table class="remaining">
            <thead>
                <tr>
                    <th>Overig</th>
                    <th>tot. ex BTW</th>
                    <th>BTW%</th> 
                    <th>BTW bedrag</th>
                    <th>tot. incl BTW</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
                <tr>
                    <td>Volkswagen GTI 2.0 12-ABC-34</td>
                    <td>&#8364;</td>
                    <td>
                        <select>
                            <option>20&#37;</option>>
                            <option>10&#37;</option>>
                            <option>30&#37;</option>>
                            <option>40&#37;</option>>
                            <option>50&#37;</option>>
                        </select>
                    </td> 
                    <td>&#8364;</td>
                    <td>&#8364;</td>
                </tr>
            </tbody>
        </table>
        <table class="total">
            <thead>
                <tr>
                    <th colspan="6">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3">Totaal excl. BTW:</td>
                    <td>&#8364;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">Totaal excl. BTW:</td>
                    <td>&#8364;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>Wij verzoeken u deze factuur te voldoen binnen x dagen op reknr. t.n.v. naam.</td>                    
                </tr>
                <tr>
                    <td>Met vriendelijke groet,</td>                                    
                </tr>
                <tr>
                    <td>naam</td>               
                </tr>
            </tfoot>
        </table>

    </div>
    <style type="text/css">
        p.text-select{}
        p.text-select label{ cursor: default; margin-right: 20px;}
        p.text-select select{ width: 146px; padding: 10px; height: 36px; border: 1px solid #c0c0c0; color: #185d82;}
    </style>
    <p class="text-select">
        <label>Kies Briefpapier</label>
        <select>
            <option>&nbsp;</option>
            <option>1</option>
            <option>12</option>
            <option>123</option>
            <option>1234</option>
            <option>12345</option>
            <option>123456</option>
        </select>
    </p>

    <style type="text/css">
        .inkoop-top{ background: #f2f2f2; border: 1px solid #e9e9e9; padding: 20px;  margin-bottom: 10px; clear: both;}
        .inkoop-top form{}
        .inkoop-top table{}
        .inkoop-top table tbody{}
        .inkoop-top table tbody tr{  margin-bottom: 5px;}
        .inkoop-top table tbody tr td{ font-weight: bold; line-height: 37px;}
        .inkoop-top table tbody tr td textarea{ width: 100%; height: 100px; padding: 5px; border: 1px solid #e4e4e4; resize: none;}
        .inkoop-top table tbody tr td input[type="text"], .inkoop-top table tbody tr td select{ border: 1px solid #e4e4e4; background: #fff; height: 27px; padding: 5px 10px;}
        .inkoop-top table tbody tr td select.kenteken-select{ background: url("http://192.168.0.17assets/crmAssets/images/kenteken.png") left top no-repeat #fff; border: 1px solid #e4e4e4; color: #01aed9; text-align: center; font-weight: bold; float: right; width: 182px; height: 42px;}
        .inkoop-top table tbody tr td input.kilometerstand{ width: 147px; float: right; border: 1px solid #e4e4e4; height: 27px; padding: 5px 10px;}
        .inkoop-bottom{ background: #f2f2f2; border: 1px solid #e9e9e9; padding: 10px;  margin-bottom: 10px;}
        .inkoop-bottom table{  margin-bottom: 10px;}
        .inkoop-bottom table thead{}
        .inkoop-bottom table thead tr{}
        .inkoop-bottom table thead tr th{ text-align: left; padding: 10px;}
        .inkoop-bottom table tbody{ margin-bottom: 10px;}
        .inkoop-bottom table tbody tr{}
        .inkoop-bottom table tbody tr td{ text-align: left; padding: 3px 10px;}
    </style>
    <div class="inkoop">
        <div class="inkoop-top">
            <form>
                <table>
                    <tbody>
                        <tr><td>Kenteken</td><td>&nbsp;</td><td colspan="2">
                                <select class="kenteken-select">
                                    <option>12- ABC - 43</option>
                                    <option>12- ABC - 44</option>
                                    <option>12- ABC - 45</option>
                                    <option>12- ABC - 46</option>
                                </select>
                            </td></tr>
                        <tr><td>Kilometerstand</td><td colspan="2">&nbsp;</td><td><input type="text" class="kilometerstand" name="" value="" /></td></tr>
                        <tr>
                            <td>Prijs</td>
                            <td><input type="text" name="" class="" value="" placeholder="&euro;" /></td>
                            <td>BTW &#37;</td> 
                            <td>
                                <select>
                                    <option>10&#37;</option>
                                    <option>20&#37;</option>
                                    <option>30&#37;</option>
                                    <option>40&#37;</option>
                                    <option>50&#37;</option>
                                    <option>60&#37;</option>
                                </select>
                            </td>
                        </tr>
                        <tr><td colspan="4">Opmerkingen</td></tr>
                        <tr><td colspan="4"><textarea></textarea></td></tr>
                        <tr>
<td colspan="2"><input type="submit" name="Voge toe Volgende" value="Voge toe" class="button" /></td>
<td colspan="2"><input type="submit" name="Volgende" value="Volgende" class="button" /></td>
</tr>
                    </tbody>                    
                </table>
            </form>
        </div>
        <div class="inkoop-bottom">
            <table>
                <thead><tr><th>Kenteken</th><th>Merk & Type<t/h><th>&nbsp; &nbsp;</th></tr></thead>
                    <tbody>
                        <tr><td>12- ABC - 43 </td><td>Volkswagen GTI 2.0</td><td><img title="Verwijderen" alt="Verwijderen" src="http://192.168.0.17/assets/crmAssets/images/delete.png"></td>  </tr>
                        <tr><td>12- ABC - 43 </td><td>Volkswagen GTI 2.0</td><td><img title="Verwijderen" alt="Verwijderen" src="http://192.168.0.17/assets/crmAssets/images/delete.png"></td>  </tr>
                        <tr><td>12- ABC - 43 </td><td>Volkswagen GTI 2.0</td><td><img title="Verwijderen" alt="Verwijderen" src="http://192.168.0.17/assets/crmAssets/images/delete.png"></td>  </tr>
                    </tbody>
            </table>
        </div>
    </div>    
    
    <style type="text/css">
        .Overige{}
        .Overige table{}
        .Overige table thead{}
        .Overige table thead tr{}
        .Overige table thead tr th{ text-align: left; border-right: 2px solid #fff; padding: 5px;}
        .Overige table tbody{}
        .Overige table tbody tr{}
        .Overige table tbody tr td{ border-right: 2px solid #f4f4f4; background: #fff; padding: 5px; line-height: 27px; vertical-align: middle;}
        .Overige table tbody tr td input{ width: 90%; padding: 5px 5px; border: none;}
        .Overige table tbody tr td select{ width: 105%; padding: 5px 5px; border: none;}
    </style>
    <div class="Overige">
         <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>Aantal</th>
                    <th>Prijs/stuk</th>
                    <th>Item</th>
                    <th>tot. ex BTW</th>
                    <th>BTW &#37;</th>
                    <th>BTW bedrag</th>
                    <th>tot. incl BTW</th>
                    <th>&nbsp;</th>                    
                </tr>
            </thead>            
            <tbody>
                  <tr>
                    <td><input type="text" name="" value="" class="" /></td>                    
                    <td><input type="text" name="" value="" class="" placeholder="" /></td>                    
                    <td>
                        <select>
                            <option></option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                        </select>
                    </td>                    
                    <td><input type="text" name="" value="" class="" /></td>                   
                    <td>
                        <select>
                            <option></option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                        </select>
                    </td>                    
                    <td><input type="text" name="" value="" class="" /></td>                      
                    <td><input type="text" name="" value="" class="" /></td>                      
                    <td><img title="Verwijderen" alt="Verwijderen" src="http://192.168.0.17/assets/crmAssets/images/delete.png"></td>                      
                </tr>
                  <tr>
                    <td><input type="text" name="" value="" class="" /></td>                    
                    <td><input type="text" name="" value="" class="" placeholder="" /></td>                    
                    <td>
                        <select>
                            <option></option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                        </select>
                    </td>                    
                    <td><input type="text" name="" value="" class="" /></td>                   
                    <td>
                        <select>
                            <option></option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                        </select>
                    </td>                    
                    <td><input type="text" name="" value="" class="" /></td>                      
                    <td><input type="text" name="" value="" class="" /></td>                      
                    <td><img title="Verwijderen" alt="Verwijderen" src="http://192.168.0.17/assets/crmAssets/images/delete.png"></td>                      
                </tr>
                  <tr>
                    <td><input type="text" name="" value="" class="" /></td>                    
                    <td><input type="text" name="" value="" class="" placeholder="" /></td>                    
                    <td>
                        <select>
                            <option>adfasd asdf sadf asdf asdfasdf asdf</option>
                            <option>adfasd asdf sadf asdf asdfasdf asdf</option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                        </select>
                    </td>                    
                    <td><input type="text" name="" value="" class="" /></td>                   
                    <td>
                        <select>
                            <option></option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                            <option>adfasd</option>
                        </select>
                    </td>                    
                    <td><input type="text" name="" value="" class="" /></td>                      
                    <td><input type="text" name="" value="" class="" /></td>                      
                    <td><img title="Verwijderen" alt="Verwijderen" src="http://192.168.0.17/assets/crmAssets/images/delete.png"></td>                      
                </tr>
               
            </tbody>            
        </table>
    </div>
    
    
    
    <style type="text/css">
        .email-editor{}
        .email-editor p{ line-height: 36px; margin-bottom: 10px;}
        .email-editor p textarea{ width: 100%; border: 1px solid #e4e4e4; padding: 10px;}
        .email-editor input.email-note, .email-editor input.from-to{ width: 480px; padding: 0 10px; height: 36px; line-height: 36px; border: 1px solid #e4e4e4; background: #fff; float: right;}
        .email-editor input[type="radio"]{ margin-left: 5px;}
        .email-editor input[type="date"], .email-editor input[type="time"]{ margin-left: 5px; width: 120px; padding: 0 10px; height: 36px; line-height: 36px; border: 1px solid #e4e4e4; color: #00afd8;}
    </style>
    <div class="email-editor">
        <form>
            <p>Aan:<input type="text" name="" placeholder="Dit bericht wordt verzonden aan ...... relaties" class="from-to" /></p>
            <p>Onderwerp e-mail:<input class="email-note" type="text" value="" name="" placeholder="Is uw auto al winterklaar? Ga veilig op de weg met winterban...." /></p> 
            <p><textarea></textarea></p> 
            <p><input type="radio" />Dit bericht verzenden op <input type="date" name="" /> <input type="time" name="usr_time" /> </p>
            <p><input type="radio" />Dit bericht nu verzenden</p>
            <p><input type="submit" class="button" value="Vorige" /></p>

        </form>
    </div>
    
    <style type="text/css">
        .email-draft{}
        .email-draft p{ width: 100%; float: left; margin: 4px 0;}
        .email-draft p label{ width: 50%; float: left; line-height: 36px; font-size: 14px; font-weight: bold;}
        .email-draft p label select{ padding: 0 10px; width: 100%; border: 1px solid #e4e4e4; background: #fff; color: #185d82; height: 36px;}
        .email-draft p label span select{ width: 45.8%;}
        span.checkitem{ background: #fff; border: 1px solid #e4e4e4; float: right; border-top: none; padding: 10px; width: 47.3%; font-size: 14px; line-height: 24px;}
        span.checkitem input[type="checkbox"]{ margin-right: 3px;}
    </style>
    <div class="email-draft">
        <h4>Kenmerken - Relatie</h4>
        <form>
            <p><label>Geslacht:</label><label><select><option>Beide</option><option>Beide</option><option>Beide</option><option>Beide</option><option>Beide</option></select></label></p>
            <p><label>Regio:</label>
                <label>
                    <select>
                        <option>Heel Nederland</option>
                        <option>Heel Nederland</option>
                        <option>Heel Nederland</option>
                    </select>
                </label>
                <span class="checkitem">
                    <input type="checkbox" />Gelderland<br />
                    <input type="checkbox" />Flevoland<br />
                    <input type="checkbox" />Noord-Brabant
                </span>
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
        </form>
    </div>
    <style type="text/css">
        .email-draft2{}
        .email-draft2 p{ width: 100%; float: left; margin: 4px 0;}
        .email-draft2 p label{ width: 50%; float: left; line-height: 36px; font-size: 14px; font-weight: bold;}
        .email-draft2 p label select{ padding: 0 10px; width: 100%; border: 1px solid #e4e4e4; background: #fff; color: #185d82; height: 36px;}
        .email-draft2 p label span select{ width: 45.8%;}
        span.checkitem2{ background: #fff; border: 1px solid #e4e4e4; float: right; border-top: none; padding: 10px; width: 47.3%; font-size: 14px; line-height: 24px;}
        span.checkitem2 input[type="checkbox"]{ margin-right: 3px;}
    </style>
    <div class="email-draft2">
        <h4>Kenmerken - Relatie</h4>
        <form>
            <p>
                <label>Merk:</label>
                <label>
                    <select>
                        <option>Beide</option>
                        <option>Beide</option>
                        <option>Beide</option>
                        <option>Beide</option>
                        <option>Beide</option>
                    </select>
                </label>
                <span class="checkitem2">
                    <input type="checkbox" />Gelderland<br />
                    <input type="checkbox" />Flevoland<br />
                    <input type="checkbox" />Noord-Brabant
                </span>
            </p>
            <p><label>Type:</label>
                <label>
                    <select>
                        <option>Heel Nederland</option>
                        <option>Heel Nederland</option>
                        <option>Heel Nederland</option>
                    </select>
                </label>
                <span class="checkitem2">
                    <input type="checkbox" />Gelderland<br />
                    <input type="checkbox" />Flevoland<br />
                    <input type="checkbox" />Noord-Brabant
                </span>
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
        </form>
    </div>
</div>