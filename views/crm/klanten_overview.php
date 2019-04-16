<div class="grayColumn" id="relatie">
    <div class="titleBar">Relaties
        <div id="result"></div></div>
    <div class="contentBlock">
        <p class="viewtype-button">
            <a class="button addRelatie" href="<?php echo base_url() . 'backoffice/relatiebeheer/relatie/0'; ?>"><img class="add" src="<?php echo base_url(); ?>assets/crmAssets/images/add.png" />Relatie toevoegen</a>

<!--        <span style="float:right;top:-41px;right:2px;width: 106px;" class="checkBoxSlider actief" id="klant_actief">          
    <button onclick="localstore('relatie')" id="relon" class="radioSliderTrue  radioSliderActive" type="button">relatie</button>
    <button onclick="localstore('voertuig')" id="reloff" style="width:54px;" class="radioSliderFalse radioSliderInactive" type="button">voertuig</button><br>
    <input type="radio" value="1" class="radioSliderOn actief" name="actief">
    <input type="radio" checked="checked" value="0" class="radioSliderOff actief" name="actief">
</span>-->
            <span class="viewtype" title="Selecteer weergave" >
                <select onchange="localstore('voertuig')">
                    <option>Relatie</option>
                    <option>Voertuig</option>
                </select>
            </span>
        </p>
        <div class="contant-white">
            <form  id="klanten-filter" class="tableForm" method="POST" action="<?php echo base_url() . 'backoffice/relatiebeheer/relaties/zoeken'; ?>">
                <table style="background: white;" id="autos-tabel-overview" cellspacing="0" sellpadding="0">
                    <thead>
                    <th class="klantNr"><span class="tableHeaderLabel">Klantnr.</span><br /><input class="klantNr" type="text" name="klantnr" maxlength="5" size="4" value="<?php //echo $_POST['klantnr'];    ?>" /></th>
                    <th class="naam2"><span class="tableHeaderLabel">Naam</span><br /><input class="naam" type="text" name="naam" value="<?php //echo $_POST['naam'];    ?>" size="10"/></th>
                    <th class="adresWoonplaats"><span class="tableHeaderLabel">Adres &amp; Woonplaats</span><br /><input class="adresWoonplaats" type="text" name="adres_woonplaats" value="<?php //echo $_POST['adres_woonplaats'];    ?>" size="25" /></th>
                    <th class="telefoon"><span class="tableHeaderLabel">Telefoon</span><br /><input class="telefoon" type="text" name="telefoonnr" maxlength="10" size="10" value="<?php //echo $_POST['telefoonnr'];    ?>" /></th>
                    <th class="status"><span class="tableHeaderLabel">Status</span><br /><input class="status" type="text" name="status" maxlength="8" size="3" value="<?php //echo $_POST['status'];    ?>" /></th>
                    </thead>

                    <?php
                    $ids = array();
                    if (is_array($autos)) {
                        // print '<pre>'; print_r($autos); print '</pre>';
                        foreach ($autos as $auto) {
                            $klant_id = $auto->klant_id;
                            if (!in_array($klant_id, $ids)) {
                                $ids[] = $klant_id;
                                echo '<tr>
                    <td style="text-align:right" >' . $auto->klant_id . '</td>
                    <td><a href="' . base_url() . 'backoffice/relatiebeheer/relatie/' . $auto->klant_id . '" title="Bewerk relatie">' . $auto->klant_naam . '</a></td>
                    <td>' . $auto->klant_adres_woonplaats . '</td>
                    <td>' . $auto->klant_telefoon . '</td>
                  
                    <td>' . $auto->klant_actief . ' <a href="' . base_url() . 'backoffice/relatiebeheer/relatie/' . $auto->klant_id . '"><img class="edit" src="' . base_url() . 'assets/crmAssets/images/edit.png" height="22" width="22" alt="Bewerk relatie" title="Bewerk relatie" /></a></td>
                </tr>';
                            }
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


<div class="grayColumn" id="voertuig" style="display:none;">
    <div class="titleBar">Relaties</div>
    <div class="contentBlock">
        <p class="viewtype-button">
            <a class="button addRelatie" href="<?php echo base_url() . 'backoffice/relatiebeheer/relatie/0'; ?>"><img class="add" src="<?php echo base_url(); ?>assets/crmAssets/images/add.png" />Relatie toevoegen</a>

            <span class="viewtype" title="Selecteer weergave" >          
                <select onchange="localstore('relatie')">              
                    <option>Voertuig</option>
                    <option>Relatie</option>
                </select>
            </span>
        </p>
        <div class="contant-white">
            <form id="klanten-filter" class="tableForm" method="POST" action="<?php echo base_url() . 'backoffice/relatiebeheer/relaties/zoeken'; ?>">
                <table style="background: white;" id="autos-tabel-overview" cellspacing="0" sellpadding="0">
                    <thead>
                    <th class="kenteken"><span class="tableHeaderLabel">Kenteken</span><br /><input class="kenteken" type="text" name="kenteken" maxlength="8" size="8" value="<?php //echo $_POST['kenteken'];    ?>" /></th>
                    <th class="merkType"><span class="tableHeaderLabel">Merk &amp; Type</span><br /><input class="merkType" type="text" name="merk_type" value="<?php //echo $_POST['merk_type'];    ?>" /></th>
                    <th class="klantNr"><span class="tableHeaderLabel">Klantnr.</span><br /><input class="klantNr" type="text" name="klantnr" maxlength="5" size="4" value="<?php //echo $_POST['klantnr'];    ?>" /></th>
                    <th class="naam"><span class="tableHeaderLabel">Naam</span><br /><input class="naam" type="text" name="naam" value="<?php //echo $_POST['naam'];    ?>" size="10"/></th>
                    <th class="status"><span class="tableHeaderLabel">Status</span><br /><input class="status" type="text" name="status" maxlength="8" size="3" value="<?php //echo $_POST['status'];    ?>" /></th>
                    </thead>

                    <?php
                    if (is_array($autos)) {
                        // print '<pre>'; print_r($autos); print '</pre>';
                        foreach ($autos as $auto) {
                            if (($auto->auto_kenteken) != null) {
                                if (($auto->auto_actief) == 1) {
                                    $actief = 'Actief';
                                } else {
                                    $actief = 'Inactief';
                                };
                                echo '<tr>
                    <td ><a href="' . base_url() . 'backoffice/relatiebeheer/auto/' . $auto->auto_id . '" title="Bewerk auto">' . $auto->auto_kenteken . '</a></td>
                    <td>' . $auto->auto_merk_type . '</td> 
                    <td style="text-align:right">' . $auto->klant_id . '</td>
                    <td><a href="' . base_url() . 'backoffice/relatiebeheer/relatie/' . $auto->klant_id . '" title="Bewerk relatie">' . $auto->klant_naam . '</a></td>
                    <td>' . $actief . ' <a href="' . base_url() . 'backoffice/relatiebeheer/auto/' . $auto->auto_id . '"><img class="edit" src="' . base_url() . 'assets/crmAssets/images/edit.png" height="22" width="22" alt="Bewerk voertuig" title="Bewerk voertuig" /></a></td>
                </tr>';
                            }
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


<script>
    function localstore(mode) {
        if (mode == 'relatie') {
            localStorage.setItem("mode", "relatie");
        }
        if (mode == 'voertuig') {
            localStorage.setItem("mode", "voertuig");
        }
        location.reload();
    }

    // Check browser support
    if (typeof (Storage) !== "undefined") {
        var mode = localStorage.getItem("mode");
        if (mode == "relatie") {
            $("#relatie").show();
            $("#voertuig").hide();

        }
        if (mode == "voertuig") {
            $("#relatie").hide();
            $("#voertuig").show();

        }
    } else {
        $("#voertuig").hide();
    }
</script>