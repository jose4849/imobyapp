<?php $this->load->view('admin/layout/header'); ?>
<script src="https://raw.githubusercontent.com/enyo/dropzone/master/downloads/dropzone.js"></script>
<script>
    $(function() {
  
        $('#dropzone').on('dragover', function() {
            $(this).addClass('hover');
            alert(1);
        });
  
        $('#dropzone').on('dragleave', function() {
            $(this).removeClass('hover');
            alert(2);
        });
  
        $('#dropzone input').on('change', function(e) {
            var file = this.files[0];
            // alert(3);
      
            $('#dropzone').removeClass('hover');
    
            if (this.accept && $.inArray(file.type, this.accept.split(/, ?/)) == -1) {
                return alert('File type not allowed.');
            }
    
            $('#dropzone').addClass('');
            $('#dropzone img').remove();
    
            if ((/^image\/(gif|png|jpeg|jpg)$/i).test(file.type)) {
                var reader = new FileReader(file);

                reader.readAsDataURL(file);
      
                reader.onload = function(e) {
                    var data = e.target.result,
                    $img = $('<img />').attr('src', data).fadeIn();
        
                    $('#dropzone div').html($img);
                };
            } else {
                var ext = file.name.split('.').pop();
      
                $('#dropzone div').html(ext);
            }
        });
  

  
  
    });
</script>
<style>



</style>

<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('admin/layout/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a class="breadcrumb" href="#">Admin Panel</a> &gt;<a class="breadcrumb" href="#">Gebruikers</a> &gt;<span class="lastBreadcrumbs">Nieuwe gebruiker</span>
        </div>
        <div class="grayColumn">
            <div class="titleBar">Nieuwe gebruiker</div>
            <div class="contentBlock">
                <div class="user-detail">
                    <div  id="dropzone" class="dropzone img-block">
                        <img width="" height="" class="default-img" alt="placeholder" src="<?= base_url() ?>assets/images/placeholder.png">
                        <input name="file" type="file" accept="image/png" />
                    </div> 
                    <div class="details-left">
                        <h2 class="title"><br></h2>
                        <p class="subtitle"><br></p>
                        <p><span class="detail-left">Tel: </span><span class="detail-right"></span></p>
                        <p><span class="detail-left">Email: </span><span class="detail-right"></span></p>
                    </div>
                    <div class="details-right">
                        <p><span class="detail-left">Imoby ID:</span><span class="detail-right"></span></p>
                        <p><span class="detail-left">Contact: </span><span class="detail-right"></span></p>
                        <p><span class="detail-left">Tel: </span><span class="detail-right"></span></p>
                        <p><span class="detail-left">Email: </span><span class="detail-right"><a href="#"></a></span></p>
                    </div>
                </div>
                <div class="relatie-tab ui-tabs ui-widget ui-widget-content ui-corner-all" id="tabs">
                    <ul class="tabmenu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Dossier</a></li>
                        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false"><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Kenmerken</a></li>
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false"><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Producten</a></li>
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-4" aria-labelledby="ui-id-4" aria-selected="false"><a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">Koppelingen</a></li>
                    </ul>
                    <div class="tabcontainer ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-1" aria-labelledby="ui-id-1" role="tabpanel" aria-expanded="true" aria-hidden="false">     
                        <div class="tabcontent">                                
                            <div class="buttonholder"><a href="#" class="button addRelatie"><img src="<?= base_url() ?>assets/images/add.png" class="add" />Notitie maken</a></div>
                            <div class="buttonholder"><!-- <a href="#" class="button addRelatie"><img src="<?= base_url() ?>assets/images/add.png" class="add" />Upload file</a>--></div>
                            <div class="buttonholder right"><a href="#" class="button addRelatie"><img src="<?= base_url() ?>assets/images/add2.png" class="add" />Meekijken</a></div>

                            <table class="relatie-tabel garagebedrijfx-table">
                                <thead>
                                    <tr>
                                        <th class="p25"><span>Datum</span></th>
                                        <th class="p20"><span>Medewerker</span></th>
                                        <th class="p15"><span>Actie</span></th>
                                        <th class="p30"><span>Omschrijving</span></th>
                                        <th class="p10"><span>&nbsp;</span></th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                        <div class="page-nav">

                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <form action="" id="addUserForm">
                        <div class="tabcontainer ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-2" aria-labelledby="ui-id-2" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">     
                            <div class="tabcontent">
                                <div class="company">
                                    <h2>Bedrijfsgegevens</h2>
                                    <div class="left-div">
                                        <fieldset>
                                            <p><span class="briefcase"></span><input type="text" placeholder="Bedrijfsnaam" name="name" ></p>
                                            <p><span class="house addres"></span>
                                                <input class="street" type="text" placeholder="Straat" name="street" >
                                                <input class="nr" type="text" maxlength="5" placeholder="Nr" name="house_num" >
                                                <input class="toev" type="text" maxlength="5" placeholder="Toev" name="house_num_addition" >
                                            </p>
                                            <p><span class="house"></span><input type="text" placeholder="Postcode" name="postal_code" ></p>
                                            <p><span class="house"></span><input type="text" placeholder="Vestigingsplaats" name="city" ></p>
                                            <p><span class="kvknr"></span><input type="text" placeholder="KvKnr" name="KvKnr" ></p>
                                            <p><span class="btwnr"></span><input type="text" placeholder="BTWnr" name="BTWnr" ></p>
                                        </fieldset>

                                    </div>
                                    <div class="right-div">

                                        <fieldset>
                                            <p><span class="phone"></span><input type="text" placeholder="Telefoonnummer" name="phoneNumber1" ></p>
                                            <p><span class="phone"></span><input type="text" placeholder="Faxnummer" name="faxNumber" ></p>
                                            <p><span class="mail"></span><input type="text" placeholder="E-mail adres" name="company_email" ></p>
                                            <p><span class="web"></span><input type="text" placeholder="Website" name="Website" ></p>
                                            <p><span class="btwnr"></span><input type="text" placeholder="Naam rekeninghouder" name="accountnumber" ></p>
                                            <p><span class="btwnr"></span><input type="text" placeholder="IBAN" name="IBAN" ></p>
                                        </fieldset>

                                    </div>
                                </div>
                                <div class="contact">
                                    <h2>Contactpersoon</h2>
                                    <p>
                                        <label><input type="radio" name="salutation" value="Mr." checked="checked" id="deheer" class="blackText">
                                            De heer</label>
                                        <label><input type="radio" name="salutation" value="Ms." id="mevrouw" class="blackText">
                                            Mevrouw</label>
                                    </p>
                                    <div class="left-div">
                                        <fieldset>
                                            <p><span class="person"></span><input type="text" placeholder="Voornaam" name="Voornaam" ></p>
                                            <p><span class="person"></span><input type="text" placeholder="Tussenvoegsel" name="Tussenvoegsel" ></p>
                                            <p><span class="person"></span><input type="text" placeholder="Achternaam" name="Achternaam" ></p>

                                        </fieldset>
                                    </div>
                                    <div class="right-div">
                                        <fieldset>

                                            <p><span class="phone"></span><input type="text" placeholder="Telefoonnummer" name="phoneNumber2" ></p>
                                            <p><span class="mail"></span><input type="text" placeholder="E-mail adres" name="company_contact_email" ></p>
                                            <p><span class="person"></span><input type="text" placeholder="Functie" name="function" ></p>

                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="buttonholder right"  id="save"><a href="javascript:void(0)" onclick="saveUser()" class="button addRelatie"><img src="<?= base_url() ?>assets/images/vinkje.png" class="add" />Volgende</a></div>
                            <div class="clearfix"></div>
                        </div>                               
                        <!-- </form>    --> 
                        <div class="tabcontainer ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-3" aria-labelledby="ui-id-3" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">      
                            <div class="tabcontent">                                
                                <table class="products-table">
                                    <tbody>

                                        <?php $x = 1;
                                        foreach ($products as $product) { ?>
                                            <tr>
                                                <td><span class="iphone"></span><?php echo $product->description; ?> </td>
                                                <td>
                                                    <label>€ <?php echo $product->price; ?></label>
                                                    <span id="klant_actief" class="checkBoxSlider actief<?php echo $x; ?>">
                                                        <button onclick="service('<?php echo $x; ?>',1)" type="button" class="radioSliderTrue actief<?php echo $x; ?> blackText radioSliderInactive">aan</button>
                                                        <button onclick="service('<?php echo $x; ?>',0)" type="button" class="radioSliderFalse actief<?php echo $x; ?> blackText radioSliderActive">uit</button><br>
                                                        <input type="hidden" id="actief<?php echo $x; ?>" name="actief<?php echo $x; ?>" class="radioSliderOn actief<?php echo $x; ?>" value="1" >

                                                    </span>
                                                </td>
                                            </tr>
                                        <?php $x++; } ?>


                                        <!--
                                        <tr>
                                            <td><span class="user"></span>Relatiebeheer</td>
                                            <td>
                                                <label>€ 34,50</label>
                                                <span id="klant_actief" class="checkBoxSlider actiefr">
                                                    <button type="button" class="radioSliderTrue  actiefr blackText radioSliderInactive">aan</button>
                                                    <button type="button" class="radioSliderFalse  actiefr blackText radioSliderActive">uit</button><br>
                                                    <input type="radio" name="actiefr" class="radioSliderOn actiefr" value="1" >
                                                    <input type="radio" name="actiefr" class="radioSliderOff actiefr" value="0" checked="" >
                                                </span>
                                            </td>
                                        </tr>
                                        <tr><td><span class="euro"></span>Facturatie</td>
                                            <td>
                                                <label>€   9,95</label>
                                                <span id="klant_actief" class="checkBoxSlider actiefi">
                                                    <button type="button" class="radioSliderTrue actiefi blackText radioSliderActive">aan</button>
                                                    <button type="button" class="radioSliderFalse actiefi blackText radioSliderInactive">uit</button><br>
                                                    <input type="radio" name="actiefi" class="radioSliderOn actiefi" value="1" checked="">
                                                    <input type="radio" name="actiefi" class="radioSliderOff actiefi" value="0">
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="link"></span>DMS Koppeling</td>
                                            <td>
                                                <label>€ 19,95</label>
                                                <span id="klant_actief" class="checkBoxSlider actiefd">
                                                    <button type="button" class="radioSliderTrue actiefd blackText radioSliderActive">aan</button>
                                                    <button type="button" class="radioSliderFalse actiefd blackText radioSliderInactive">uit</button><br>
                                                    <input type="radio" name="actiefd" class="radioSliderOn actiefd" value="1" checked="">
                                                    <input type="radio" name="actiefd" class="radioSliderOff actiefd" value="0">
                                                </span>
                                            </td>
                                        </tr>
                                        -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="buttonholder right"><a href="#" class="button addRelatie" onclick="saveFunction();"><img src="<?= base_url() ?>assets/images/vinkje.png" class="add">Opslaan</a></div>
                            <div class="clearfix"></div>
                            <input id="dealer_id" type="hidden" value="">
                        </div>
                    </form> 
                    <div class="tabcontainer ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-4" aria-labelledby="ui-id-4" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
                        <div class="tabcontent">    


                            <table border="0" cellspacing="0" cellpadding="0" class="packages">
                                <tbody>
                                    <tr>
                                        <td class="packages"><strong>VWE</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" checked="" name="source" value="VWE" class="blackText"> <strong class="lightblue">Advertentiemanager</strong></td>
                                        <td><input type="text" placeholder="Gebr. naam" name="vweid" value=""></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="source" value="VWEH" class="blackText"> Hexon</td>
                                        <td><input type="text" placeholder="Gebr. naam" name="vwehid" value=""></td>
                                        <td></td>
                                    </tr>

                                </tbody>
                            </table>

                            <table border="0" cellspacing="0" cellpadding="0" class="packages">
                                <tbody>
                                    <tr>
                                        <td class="packages"><strong>Hexon</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="source" value="HEX" class="blackText">Doorlinken voorraad</td>
                                        <td><input type="text" placeholder="Gebr. naam" name="hexid" value=""></td>
                                        <td><button>Genereer</button></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="buttonholder right"><a href="#" class="button addRelatie"><img src="<?= base_url() ?>assets/images/vinkje.png" class="add">Opslaan</a></div>
                        <div class="clearfix"></div>




                    </div>
                </div>                                

            </div>
        </div>   
    </div>
</div>
<script type="text/javascript">
    
    function saveUser() {
        
        $.ajax({
            url: "<?php echo base_url('admin/gebruikers/insert'); ?>",
            type: "post",
            data: $("#addUserForm").serialize(),
            success: function(e) {
                alert(e);
                // alert(e);
                window.location.assign("<?php echo base_url() ?>admin/gebruikers/details/"+e);
            },
            error: function(er) {
                alert(er);
            }
        });
    }
    function saveFunction() {
        if($('#dealer_id').val() == ""){
            alert('First Insert Dealer Info in Features Tab!');
            return;
        }
        var url = "<?php echo base_url('admin/user/insertFunction'); ?>/";
        url += $('#dealer_id').val();
        $.ajax({
            url: url,
            type: "post",
            data: $("#addUserForm").serialize(),
            success: function(e) {
                var obj = JSON.parse(e);
                if (obj.success) {
                    alert('Data Inserted Successfully!');
                } else {
                    alert(obj.message);
                }
            },
            error: function(er) {
                alert(er);
            }
        });
    }
    
    function service(id,value){
        $('#actief'+id).val(value);
    }
           

            
		

    
</script>

<script type="text/javascript">
    jQuery(function($){
        $("#dropzone").dropzone({ url: "<?php echo base_url('admin/user/uploader'); ?>?userid=<?php echo "jose3"; ?>",success: function(response){
                $('.default-img').remove();
            }}        
    );       
    });  
</script>

<?php $this->load->view('admin/layout/footer'); ?>
