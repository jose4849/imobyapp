<div class="grayColumn">
    <div class="titleBar">Ongekoppelde auto's</div>
    <div class="contentBlock">
        <div class="contant-white">
            <form id="ongekoppeld-filter" method="POST" action="<?php base_url('crm/ongekoppeld/zoeken'); ?>">
                <table id="autos-ongekoppeld-tabel" class="ongekoppeldTable" cellpadding="0" cellspacing="0" >
                    <thead>
                    <th class="ongekoppeld-foto"><span class="tableHeaderLabel">Foto</span></th>
                    <th class="ongekoppeld-merkType"><span class="tableHeaderLabel">Merk &amp; Type</span><br /><input class="ongekoppeld-merkType"type="text" name="merk_type" value="<?php //echo $_POST['merk_type'];  ?>" /></th>
                    <th class="ongekoppeld-bouwjaar"><span class="tableHeaderLabel">Bouwjaar</span><br /><input class="ongekoppeld-bouwjaar" type="text" name="bouwjaar" value="<?php //echo $_POST['bouwjaar'];  ?>"  size="4" maxlength="4" /></th>
                    <th class="ongekoppeld-kenteken"><span class="tableHeaderLabel">Kenteken</span><br /><input class="ongekoppeld-kenteken" type="text" name="kenteken" value="<?php //echo $_POST['kenteken'];  ?>" size="8" maxlength="8"/></th>
                    <th class="ongekoppeld-kmstand"><span class="tableHeaderLabel">Status</span><br /><input class="ongekoppeld-kmstand" type="text" name="kmstand" value="<?php //echo $_POST['kmstand'];  ?>" size="6" maxlength="6"/></th>
                    <th class="ongekoppeld-uitvoorraad"><span class="tableHeaderLabel">Datum uit voorraad</span><br /><input class="ongekoppeld-uitvoorraad" type="text" name="archived_date" value="<?php //echo $_POST['archived_date'];  ?>" size="6" maxlength="6"/></th>
                    </thead>

                    <?php
                    if (is_array($autos)) {
                        // print '<pre>'; print_r($autos[0]); print '</pre>';
                        $base = base_url();
                        foreach ($autos as $auto) {
                            if ($auto->foto) {
                                $img = '<img src="' . $auto->foto . '" style="width:118px;" alt="' . $auto->ObjectTiaraID . '" title="' . $auto->ObjectTiaraID . '"/>';
                            } else {

                                $img = '<img src="' . base_url() . 'assets/crmAssets/images/placeholder.png" style="width:118px;"/>';
                            }
                            $archivedate = $auto->auto_archivedate;
                            if ($archivedate == '0000-00-00') {
                                $stock_status = 'Voorraad';
                                $archivedate = 'N.v.t.';
                            } else {
                                $stock_status = 'Verkocht';
                            }
                            echo '<tr>
                            <td class="foto-container">' . $img . '</td>
                            <td>' . $auto->auto_merk_type . '<br /><br /><a class="button Ongekoppeld koppelOngekoppeld" href="#" id="' . $auto->auto_kenteken . '" style="line-height: 30px !important;color:#FFF;height: 30px;"><img class="vinkje 1234" src="' . base_url() . 'assets/crmAssets/images/vinkje.png" />Koppelen</a></td>
                            <td>' . $auto->auto_bouwjaar . '</td>
                            <td>' . $auto->auto_kenteken . '</td>
                            <td>' . $stock_status . '</td>
                            <td>' . $archivedate . '</td>
                        </tr>';
                        }
                    }
                    ?>
                </table>
            </form>
            <br>
            <div class="contant-white-bottom">
                <div class="page-left-t"><span>20 item</span></div>
                <div class="page-nav"><span>&nbsp;</span></div>
            </div>
        </div>
    </div>
</div>
<?php
//print '<pre>'; print_r($klanten); print '</pre>';
?>
<div id="dialog-auto-koppelen" title="Auto koppelen">
    <form id="auto-koppelen-form">
        Auto met het kenteken <span id="koppelKenteken"></span> koppelen aan:<br />
        <select name="koppelRelatieId" id="koppelRelatieId">
            <option value="0" selected="selected">Nieuwe relatie</option>
<?php
if (is_array($klanten)) {
    foreach ($klanten as $klant) {
        echo '<option value="' . $klant->klant_id . '">' . $klant->klant_naam . '</option>';
    }
}
?>
        </select>

    </form>
</div>

<?php if ($openKoppelen) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#dialog-auto-koppelen").dialog( "open" );
            $("#koppelKenteken").html('<?php echo $openKoppelen; ?>');  

        });
    </script>
<?php } ?>