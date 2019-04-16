<script type="text/javascript" src="<?php echo base_url('assets/ckeditor/js/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
    .next-button{ position: relative; float: right; }
    .next-button img.vinkje{ position: absolute; top: 36%;}
    .next-button input.button.next-class{ position: static; cursor: pointer;}
</style>
<script>
    function replaceid(id) {
        $('#invoice-number').val(id);
    }
</script>
<style type="text/css">
    .ui-dialog{
        top: 70px !important;
    }
    .ui-dialog-content.ui-widget-content{
        padding: 0px; overflow: hidden;
    }
    .factuur-maken{}
    .factuur-maken p{ border-bottom: 1px solid #e1e1e1; margin: 0px; padding: 8px 0; color: #2f2f2f;}
    .factuur-maken p:last-child{ border: none;}
    .factuur-maken p input[type="radio"]{ margin-right: 10px;}
    .factuur-maken2{ background: #f4f4f4; padding: 20px; overflow: hidden;}
    .invoice-number img {
        left: 4px;
        position: relative;
        top: -4px;}
    .factuur-maken2 p{ margin: 0px; padding: 8px 0; color: #2f2f2f; font-weight: bold;}
    .factuur-maken2 p input[type="radio"]{ margin-right: 10px;}
    .factuur-maken2 p.invoice-number label{ font-weight: normal; line-height: 37px; margin-right: 20px;}
    .factuur-maken2 p.invoice-number input[type="text"]{ float: right; border: 1px solid #e8e8e8; width: 143px; padding:0 5px; height: 35px; line-height: 34px; }
    .factuur-maken2 p.description label{ font-weight: normal; line-height: 37px; margin-right: 20px;}
    .factuur-maken2 p.description input[type="text"]{ float: right; border: 1px solid #e8e8e8; width: 204px; padding:0 5px; height: 35px; line-height: 34px; }
    .text-editor{
        border: 1px solid #c1c1c1; margin-bottom: 20px; padding-top: 10px; width: 720px;
    }
    .text-editor table{
        margin-bottom: 40px; left: 0; width: 720px;
    }
    .text-editor textarea{
        border: 1px solid #e4e4e4; width: 95%; padding: 10px; margin: 10px; margin: 5px; resize: none; height: 120px;
    }
    table.purchasing-car{ }
    table.purchasing-car thead{ float: left; width: 720px;}
    table.purchasing-car thead tr{}
    table.purchasing-car thead tr th{ text-align: left; padding: 10px 0; text-indent: 10px;}    
    table.purchasing-car tbody {}
    table.purchasing-car tbody tr{}
    table.purchasing-car tbody tr td{ text-indent: 10px; font-weight: bold; text-align: left; padding: 5px 0px; color: #3d3d3d; font-weight: bold;}
    table.purchasing-car tbody tr td select{ background: url("<?php echo base_url(); ?>assets/crmAssets/images/select2.png") 98% 47% no-repeat; margin-bottom: 0; font-weight: bold; width: 84%; padding: 0; border: none; font-weight: bold; color: #2f2f2f;}

    th.lnkoopAuto, th.verkoopAuto, th.overigAuto{ width: 350px; float: left;}
    th.toTExBTW{ width: 100px; float: left; border-left: 1px solid #fff; }
    th.btW{ width: 65px; float: left; border-left: 1px solid #fff; }
    th.BtWVedrag{ width: 100px; float: left; border-left: 1px solid #fff; }
    th.totInclBTW{ width: 101px; float: left; border-left: 1px solid #fff; }

    td.lnkoopAuto2, td.verkoopAuto2, td.overigAuto2{ width: 350px; float: left;}
    td.toTExBTW2{ width: 100px; float: left; border-left: 1px solid #fff; }
    td.btW2{ width: 65px; float: left; border-left: 1px solid #fff; }
    td.BtWVedrag2{ width: 100px; float: left; border-left: 1px solid #fff; }
    td.totInclBTW2{ width: 101px; float: left; border-left: 1px solid #fff; }

    table.selling-car{ }
    table.selling-car thead{ float: left; width: 720px;}
    table.selling-car thead tr{}
    table.selling-car thead tr th{ text-align: left; padding: 10px 0; text-indent: 10px;}
    table.selling-car tbody {}
    table.selling-car tbody tr{ margin-bottom: 10px;}
    table.selling-car tbody tr td{ text-indent: 10px; font-weight: bold; text-align: left; padding: 5px 0; text-indent: 10px; color: #3d3d3d; font-weight: bold;}
    table.selling-car tbody tr td select{ background: url("<?php echo base_url(); ?>assets/crmAssets/images/select2.png") 98% 47% no-repeat; margin-bottom: 0; font-weight: bold; width: 84%; padding: 0; border: none; font-weight: bold; color: #2f2f2f;}

    table.remaining{}
    table.remaining thead{ float: left; width: 720px;}
    table.remaining thead tr{}
    table.remaining thead tr th{ text-align: left; padding: 10px 0; text-indent: 10px;}
    table.remaining tbody { margin-bottom: 10px;}
    table.remaining tbody tr{}
    table.remaining tbody tr td{ text-indent: 10px; font-weight: bold; text-align: left; padding: 5px 0px; color: #3d3d3d; font-weight: bold;}
    table.remaining tbody tr td select{ background: url("<?php echo base_url(); ?>assets/crmAssets/images/select2.png") 98% 47% no-repeat; margin-bottom: 0; font-weight: bold; width: 84%; padding: 0; border: none; font-weight: bold; color: #2f2f2f;}

    table.total{}
    table.total thead{}
    table.total thead tr{}
    table.total thead tr th{ background: #185d82;  text-align: left; padding: 10px;}
    table.total tbody{ margin-bottom: 10px;}
    table.total tbody tr{ line-height: 20px;}
    table.total tbody tr td{ text-align: right; padding: 3px 10px; font-weight: bold;}
    table.total tfoot{}
    table.total tfoot tr{ line-height: 30px;}
    table.total tfoot tr td{ padding: 3px 10px;}    
</style>

<style type="text/css">
    .dropdown{        
        cursor: pointer;
    }
    .desc { color:#6b6b6b;}
    .desc a {color:#0092dd;}

    .dropdown dd, .dropdown dt, .dropdown ul { margin:0px; padding:0px; }
    .dropdown dd { position:relative; right: 0px; top: 25px; }
    .dropdown a, .dropdown a:visited { color:#00afd8; text-decoration:none; outline:none;}
    .dropdown a:hover { color:#fff;}
    .dropdown dt a:hover { color:#fff; }
    .dropdown dt a {background:#fff; display:block; padding-right:20px;}
    .dropdown dt a span {cursor:pointer; display:block; padding:5px;}
    .dropdown dd ul { background:#fff; border:1px solid #ccc; border-top: none; color:#C5C0B0; display:none; left:0px; padding:5px 0px; position:absolute; top:2px; width:auto; min-width:180px; list-style:none;}
    .dropdown span.value { display:none;}
    .dropdown dd ul li a { padding:5px; display:block;}
    .dropdown dd ul li a:hover { background-color:#00afd8;}

    .dropdown img.flag { border:none; vertical-align:middle; margin-left:10px; }
    .flagvisibility { display:none;}
</style>

<style type="text/css">
    .inkoop{ width: 420px;}
    .inkoop-top{  overflow: hidden; background: #f2f2f2; border: 1px solid #e9e9e9; padding: 20px;  margin-bottom: 10px; clear: both;  width: 380px;}
    .inkoop-top form{}
    .inkoop-top div.kenteken{ margin: 0 auto; width: 100%;}
    .inkoop-top div.kenteken p{ margin-bottom: 10px; margin-top: 0;  font-weight: bold; overflow: hidden; line-height: 36px;}
    .inkoop-top div.kenteken input[type="text"], .inkoop-top div select{ border: 1px solid #e5e5e5; height: 36px; padding: 0 10px; line-height: 36px;}
    .inkoop-top div.kenteken textarea{ margin-top: 10px; border: 1px solid #e5e5e5; width: 93.7%; height: 80px; padding: 2% 3%; resize: none;}
    .inkoop-top table tbody{}
    .inkoop-top table tbody tr{  margin-bottom: 5px;}
    .inkoop-top table tbody tr td{ font-weight: bold; line-height: 37px;}
    .inkoop-top table tbody tr td input[type="text"], .inkoop-top table tbody tr td select{ border: 1px solid #e4e4e4; background: #fff; height: 27px; padding: 5px 10px;}
    
    .inkoop-top div.kenteken div.k1{ margin-bottom: 40px; clear: both;}
    .inkoop-top div.kenteken div.k1 label{ }
    .inkoop-top div.kenteken input.kenteken{ font-size: 20px; position: absolute; width: 120px; padding-right: 36px; padding-left: 0px; text-align: center; left: 27px; top: 4px; background: none;  border: none; font-weight: bold; height: 32px; color: #00afd8;}
    .inkoop-top div.kenteken input.kenteken:focus, .inkoop-top div.kenteken input.kenteken:visit, .inkoop-top div.kenteken input.kenteken:active{ outline: none; }
    
    .dropdownSelect{
     position: relative; background: url("<?php echo base_url(); ?>assets/crmAssets/images/kenteken-sele.png") left top no-repeat; width: 185px;  height: 39px; float: right;
    }
    
    
    .inkoop-top div.kenteken p input.Prijs{ width: 113px; margin-left: 15px;}
    .inkoop-top div.kenteken p input.kilometerstand{ width: 134px; float: right;}
    span.vogetoe{ width: 120px; float: left; text-align: left; position: relative}
    span.volgende{ width: 120px; float: right; text-align: right; position: relative;}
    span.vogetoe input.button, span.volgende input.button{ display: inline; cursor: pointer; position: static;}
    label.prijs1{}
    label.btw1{ float: right;}
    label.btw1 select{ width: 92px; margin-left: 12px;}

    .inkoop-bottom{ background: #f2f2f2; border: 1px solid #e9e9e9; padding: 15px 20px;  margin-bottom: 10px; width: 380px;}
    .inkoop-bottom table{  margin-bottom: 10px; width: 100%;}
    .inkoop-bottom table thead{}
    .inkoop-bottom table thead tr{}
    .inkoop-bottom table thead tr th{ text-align: left; padding: 10px 18px;}
    .inkoop-bottom table tbody{ margin-bottom: 10px;}
    .inkoop-bottom table tbody tr{}
    .inkoop-bottom table tbody tr td{ text-align: left; padding: 3px 10px;}
    .inkoop-bottom table tbody tr td.img-tag{ text-align: center;}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        
        
        

$('.removeitem').on('click',function(){
    alert("Remove");
  // e.preventDefault();
  // $(this).parent().parent().remove();
});


        
        /*  $(".dropdown img.flag").addClass("flagvisibility");
         
         $(".dropdown dt a").click(function() {
         $(".dropdown dd ul").toggle();
         });
         
         $(".dropdown dd ul li a").click(function() {
         var text = $(this).html();
         $(".dropdown dt a span").html(text);
         $(".dropdown dd ul").hide();
         $("#result").html("Selected value is: " + getSelectedValue("sample"));
         });
         
         function getSelectedValue(id) {
         return $("#" + id).find("dt a span.value").html();
         }
         
         $(document).bind('click', function(e) {
         var $clicked = $(e.target);
         if (! $clicked.parents().hasClass("dropdown"))
         $(".dropdown dd ul").hide();
         });
         
         
         $("#flagSwitcher").click(function() {
         $(".dropdown img.flag").toggleClass("flagvisibility");
         }); */
    });

    function dropdown() {
        $(".dropdown dd ul").css("display", "block");
    }
    function closeid(id) {
        alert(id);
        $(".dropdown dd ul").css("display", "none");
        $('#kentekenvalue').val(id);
    }
    function additem(){
       $('#items').append('<tr><td>12- ABC - 43 </td><td>Volkswagen GTI 2.0</td><td class="img-tag"><img class="removeitem" title="Verwijderen" alt="Verwijderen" src="<?php echo base_url(); ?>/assets/crmAssets/images/delete.png"></td>  </tr>'); 
    }
</script>
<div id="dialog-factuur" title="Factuur maken - Selecteer type">
    <div class="factuur-maken2">
        <p><input name="invoice_type" checked type="radio" />Verkoop</p>
        <p><input name="invoice_type" type="radio" />Verkoop & Inkoop</p>
        <p><input name="invoice_type" type="radio" />Inkoop</p>
        <p><input name="invoice_type" type="radio" />APK/Onderhoud</p>
        <?php
        if (preg_match('/[A-Za-z0-9]+/', $factuurNummer)) {
            $factuurNummerint = preg_replace("/[^0-9]/", "", $factuurNummer); // replace all but numbers
        }
        ?>
        <p class="invoice-number"><label>Factuurnummer<img style="cursor:pointer;" onclick="replaceid('<?php echo $factuurNummer; ?>')" title="<?php echo $factuurNummer; ?>" src="<?php echo base_url(); ?>/assets/crmAssets/images/i-icon.png" /></label><input type="text" id="invoice-number" name="invoice number" value="<?php echo $factuurNummerint; ?>" /></p>
        <p class="description"><label>Omschrijving</label><input type="text" name="Description" value="" /></p>        
        <p class="next-button">
            <img class="vinkje" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png" />
            <input  id="factuur12"   class="button next-class" value="Volgende" />
        </p>
    </div>
</div>


<div id="dialog-factuurs" title="Inkoop - Voertuig kiezen">
    <div class="inkoop">
        <div class="inkoop-top">
           
                <div class="kenteken">
                    <div class="k1"> 
                        Kenteken
                        <div class="dropdownSelect">
                            <label onclick="dropdown()" class="">
                                <input class="kenteken" id="kentekenvalue" type="text" value="12-ABC-43" maxlength="8" name="zoekKenteken">
                            </label>
                            <dl id="sample" class="dropdown">
                                <dd>
                                    <ul>
                                        <li onclick="closeid('12-ABC-43')"><a href="#">12-ABC-43</a></li>
                                        <li onclick="closeid('12-ABC-53')"><a href="#">12-ABC-53</a></li>
                                        <li onclick="closeid('12-ABC-63')"><a href="#">12-ABC-63</a></li>
                                        <li onclick="closeid('12-ABC-73')"><a href="#">12-ABC-73</a></li>
                                    </ul>
                                </dd>
                            </dl>
                            <span id="result"></span>
                        </div>
                    </div>                    

                    <p> Kilometerstand <input type="text" class="kilometerstand" name="" value="" /></p>
                    <p>                        
                        <label class="prijs1"> Prijs <input type="text" name="" class="Prijs" value="" placeholder="&euro;" /></label>
                        <label class="btw1">BTW &#37; 
                            <select>
                                <option>0&#37;</option>
                                <option>6&#37;</option>
                                <option>21&#37;</option>

                            </select>
                        </label>
                    </p>
                    <p>Opmerkingen<textarea></textarea></p>
                    <p>
                        <span class="vogetoe">
                            <img class="vinkje" src="<?php echo base_url(); ?>assets/crmAssets/images/plus.jpg" />
                            <input onclick="additem()" type="submit" name="Voeg toe" value="Voeg toe" class="button" />
                        </span>
                        <span class="volgende">
                            <img class="vinkje" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png" />
                            <input id="three" type="submit" name="Volgende" value="Volgende" class="button" />
                        </span>
                    </p>
                </div>
           
        </div>
        <div class="inkoop-bottom">
            <table id="items">
                <thead>
                    <tr>
                        <th>Kenteken</th><th>Merk & Type<t/h><th>&nbsp; &nbsp;</th></tr></thead>
                    <tbody>
                    </tbody>
            </table>
        </div>
    </div>  
</div>  
<!--------------------------------------two end ------------------------------------->
<!--------------------------------------three start ------------------------------------->


<div id="dialog-three" title="Overige factuurregels">
    <style type="text/css">
        .Overige{ padding: 15px; width: 885px; overflow: hidden; background: #f4f4f4;}
        .Overige table{ width: 100%; margin-bottom: 60px;}
        .Overige table thead{}
        .Overige table thead tr{}
        .Overige table thead tr th{ font-size: 12px; text-align: center; border-right: 1px solid #fff; padding: 8px 0;}
        th.aantal{ width: 75px;}
        th.prijs-stuk{ width: 86px;}
        th.item{ width: 340px; text-align: left !important; padding-left: 12px !important;}
        th.totexBTW{ width: 92px;}
        th.btw{width: 66px;}
        th.btw-bedrag{width: 95px;}
        th.tot-incl-BTW{width: 102px;}
        th.close{width: 25px;}
        .Overige table tbody{}
        .Overige table tbody tr{}
        .Overige table tbody tr td{ border-right: 1px solid #f4f4f4; background: #fff; padding: 0 5px; line-height: 27px; vertical-align: middle;}
        .Overige table tbody tr td:last-child{ text-align: center;}
        .Overige table tbody tr td input{ font-weight: bold; width: 90%; padding: 5px 5px; border: none;}
        .Overige table tbody tr td select{ background: url("<?php echo base_url(); ?>assets/crmAssets/images/select2.png") 98% 47% no-repeat; margin-bottom: 0; font-weight: bold; width: 102%; padding: 5px 5px; border: none; font-weight: bold; color: #2f2f2f;}
    </style>
    <div  class="Overige">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="aantal">Aantal</th>
                    <th class="prijs-stuk">Prijs/stuk</th>
                    <th class="item">Item</th>
                    <th class="totexBTW">tot. ex BTW</th>
                    <th class="btw">BTW &#37;</th>
                    <th class="btw-bedrag">BTW bedrag</th>
                    <th class="tot-incl-BTW">tot. incl BTW</th>
                    <th class="close">&nbsp;</th>                    
                </tr>
            </thead>            
            <tbody>
                <tr>
                    <td><input type="text" name="" value="" class="" /></td>                    
                    <td><input type="text" name="" value="" class="" placeholder="" /></td>                    
                    <td style="padding-right: 11px;" >
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
                            <option>0&#37</option>
                            <option>6&#37</option>
                            <option>21&#37</option>
                        </select>
                    </td>                    
                    <td><input type="text" name="" value="" class="" /></td>                      
                    <td><input type="text" name="" value="" class="" /></td>                      
                    <td><img title="Verwijderen" alt="Verwijderen" src="<?php echo base_url(); ?>/assets/crmAssets/images/delete.png"></td>                      
                </tr>
            </tbody>            
        </table>
        <p class="toevoegen-button">
            <img class="toevoegen-plus" src="<?php echo base_url(); ?>assets/crmAssets/images/plus.jpg" />
            <input  id=""  type="submit" class="button toevoegen" value="Factuurregel toevoegen " />
        </p>
        <p class="next-button">
            <img class="vinkje" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png" />
            <input  id="five"  type="submit" class="button next-class" value="Volgende" />
        </p>
    </div>
</div>  


<!--------------------------------------three end ------------------------------------->
<!--------------------------------------four start ------------------------------------->




<!--------------------------------------four end ------------------------------------->
<!--------------------------------------five start ------------------------------------->

<div id="dialog-five" title="Editor">
    <div class="text-editor" >
        <p>
            <textarea id="invoice_editor2" >
                T. Test
                Teststraat 1
                1234 AB Test
                Geachte heer/mevrouw,
                Bijgaand treft u de factuur aan met betrekking tot onderstaande factuurregels.
            </textarea>
        </p>
        <table class="purchasing-car" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="lnkoopAuto">Inkoop auto</th>
                    <th class="toTExBTW">tot. ex BTW</th>
                    <th class="btW">BTW&#37</th> 
                    <th class="BtWVedrag">BTW bedrag</th>
                    <th class="totInclBTW">tot. incl BTW</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="lnkoopAuto2">Volkswagen GTI 2.0 12-ABC-34</td>
                    <td class="toTExBTW2">&#8364;</td>
                    <td class="btW2">
                        <select>
                            <option>20&#37;</option>
                            <option>10&#37;</option>
                            <option>30&#37;</option>
                            <option>40&#37;</option>
                            <option>50&#37;</option>
                        </select>
                    </td> 
                    <td class="BtWVedrag2">&#8364;</td>
                    <td class="totInclBTW2">&#8364;</td>
                </tr>
            </tbody>
        </table>
        <table class="selling-car" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="verkoopAuto">Verkoop auto</th>
                    <th class="toTExBTW">tot. ex BTW</th>
                    <th class="btW">BTW&#37</th> 
                    <th class="BtWVedrag">BTW bedrag</th>
                    <th class="totInclBTW">tot. incl BTW</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="verkoopAuto2">Volkswagen GTI 2.0 12-ABC-34</td>
                    <td class="toTExBTW2">&#8364;</td>
                    <td class="btW2">
                        <select>
                            <option>20&#37;</option>
                            <option>10&#37;</option>
                            <option>30&#37;</option>
                            <option>40&#37;</option>
                            <option>50&#37;</option>
                        </select>
                    </td> 
                    <td class="BtWVedrag2">&#8364;</td>
                    <td class="totInclBTW2">&#8364;</td>
                </tr>
            </tbody>
        </table>
        <table class="remaining" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="overigAuto">Overig</th>
                    <th class="toTExBTW">tot. ex BTW</th>
                    <th class="btW">BTW&#37</th> 
                    <th class="BtWVedrag">BTW bedrag</th>
                    <th class="totInclBTW">tot. incl BTW</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="overigAuto2">Volkswagen GTI 2.0 12-ABC-34</td>
                    <td class="toTExBTW2">&#8364;</td>
                    <td class="btW2">
                        <select>
                            <option>20&#37;</option>
                            <option>10&#37;</option>
                            <option>30&#37;</option>
                            <option>40&#37;</option>
                            <option>50&#37;</option>
                        </select>
                    </td> 
                    <td class="BtWVedrag2">&#8364;</td>
                    <td class="totInclBTW2">&#8364;</td>
                </tr>
                <tr>
                    <td class="overigAuto2">Volkswagen GTI 2.0 12-ABC-34</td>
                    <td class="toTExBTW2">&#8364;</td>
                    <td class="btW2">
                        <select>
                            <option>20&#37;</option>
                            <option>10&#37;</option>
                            <option>30&#37;</option>
                            <option>40&#37;</option>
                            <option>50&#37;</option>
                        </select>
                    </td> 
                    <td class="BtWVedrag2">&#8364;</td>
                    <td class="totInclBTW2">&#8364;</td>
                </tr>               
            </tbody>
        </table>
        <table class="total" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="6">Totaal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">Totaal excl. BTW:</td>
                    <td>&#8364;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">Totaal excl. BTW:</td>
                    <td>&#8364;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">Totaal excl. BTW:</td>
                    <td>&#8364;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>            
            <tfoot>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
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

    <p class="text-select">
        <label>Kies briefpapier</label>
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

    <p class="make-pdf">
        <img class="vinkje" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png" />
        <input  id="five"  type="submit" class="button maakpdf" value="Maak .PDF" />
    </p>


</div>
<!--------------------------------------five end ------------------------------------->
<style type="text/css">
    .toevoegen-button{ position: relative; float: left; }
    .toevoegen-button img.toevoegen-plus{ position: absolute; top: 29%; left: 6%;}
    .toevoegen-button input.button.toevoegen{ position: static; cursor: pointer; width: 200px;}
    .next-button{ position: relative; float: right; }
    .next-button img.vinkje{ position: absolute; top: 36%;}
    .next-button input.button.next-class{ position: static; cursor: pointer;}   
</style>        


<style type="text/css">
    p.text-select{ float: left;}
    p.text-select label{ cursor: default; margin-right: 20px;}
    p.text-select select{ width: 146px; padding: 10px; height: 36px; border: 1px solid #c0c0c0; color: #185d82;}
</style>

<style type="text/css">        
    .make-pdf{ position: relative; float: right; }
    .make-pdf img.vinkje{ position: absolute; top: 36%;}
    .make-pdf input.button.maakpdf{ position: static; cursor: pointer;}
</style>

<script type="text/javascript">
    CKEDITOR.replace('invoice_editor', {
        filebrowserBrowseUrl: '<?php echo base_url(); ?>assets/ckeditor/browse.php?type=Images&dealer_id=<?php echo $dealer_id; ?>&base=<?php echo base_url(); ?>&dir=' + encodeURIComponent("media/dealers/<?php echo $dealer_id; ?>/"),
        filebrowserUploadUrl: '<?php echo base_url(); ?>assets/ckeditor/upload.php?type=Files&dealer_id=<?php echo $dealer_id; ?>&base=<?php echo base_url(); ?>&dir=' + encodeURIComponent('media/dealers/<?php echo $dealer_id; ?>/'),
        toolbar: [
            {name: 'document',
                items: ['-', 'NewPage', 'Preview', '-', 'Templates']}, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
            ['Source', 'Cut', 'Copy', 'Paste', 'PasteText',
                'PasteFromWord', '-', 'Undo', 'Redo', 'TextField',
                'Textarea', 'Select', 'Button', 'ImageButton',
                'HiddenField', 'Bold', 'Italic', 'Underline',
                'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
                'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter',
                'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language',
                'Styles', 'Format', 'Font', 'FontSize'
            ],
        ]
    });
</script>
