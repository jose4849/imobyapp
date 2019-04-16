<?php $this->load->view('backoffice/layouts/header'); ?>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/layouts/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
                <div id="breadCrumsBar">
                    <a class="breadcrumb" href="#">Instellingen</a> &gt; <span class="lastBreadcrumbs">Profiel</span>
                </div>
                <form action="" id="saveDealerProfile">
                <div class="grayColumn">
                    <div class="titleBar">Bedrijfsgegevens</div>
                    <div class="contentBlock">
                        <div class="company1">
                            <div class="left-div1">
                                    <fieldset>
                                        <p><span class="briefcase"></span><input type="text" placeholder="Bedrijfsnaam" name="Bedrijfsnaam" value="<?php echo $dealer[0]->name?>"><div class="errormessage" id="Bedrijfsnaam"></div></p>
                                        <p><span class="house"></span><input type="text" placeholder="Adres" name="Adres" value=""></p>
                                        <p><span class="house"></span><input type="text" placeholder="Postcode" name="Postcode" value="<?php echo $dealer[0]->postalcode?>"><div class="errormessage" id="Postcode"></div></p>
                                        <p><span class="house"></span><input type="text" placeholder="Vestigingsplaats" name="Vestigingsplaats" value=""><div class="errormessage" id="Vestigingsplaats"></div></p>
                                        <p><span class="kvknr"></span><input type="text" placeholder="KvKnr" name="KvKnr" value="<?php echo $dealer[0]->chamberOfCommerce?>"><div class="errormessage" id="KvKnr"></div></p>
                                        <p><span class="btwnr"></span><input type="text" placeholder="BTWnr" name="BTWnr" value="<?php echo $dealer[0]->Taxcode?>"><div class="errormessage" id="BTWnr"></div></p>
                                    </fieldset>
                            </div>
                            <div class="right-div1">
                                    <fieldset>
                                        <p><span class="phone"></span><input type="text" placeholder="Telefoonnummer" name="Telefoonnummer" value="<?php echo $dealer[0]->dealer_phoneNumber1?>"><div class="errormessage" id="Telefoonnummer"></div></p>
                                        <p><span class="phone"></span><input type="text" placeholder="Faxnummer" name="Faxnummer" value="<?php echo $dealer[0]->faxNumber?>"><div class="errormessage" id="Faxnummer"></div></p>
                                        <p><span class="mail"></span><input type="text" placeholder="E-mail adres" name="comEmail" value="<?php echo $dealer[0]->dealer_email?>"><div class="errormessage" id="comEmail"></div></p>
                                        <p><span class="web"></span><input type="text" placeholder="Website" name="Website" value="<?php echo $dealer[0]->website?>"><div class="errormessage" id="Website"></div></p>
                                    </fieldset>
                            </div>
                            <div class="right-div-last">
                                <div class="img-block">
                                    <img width="" height="" src="<?= base_url() ?>assets/images/placeholder.png" alt="placeholder">
									<span>Bedrijfslogo</span>
                                </div>
                                <div class="buttonholder">
                                    <a class="button addRelatie" href="#"><img class="add" src="<?= base_url() ?>assets/images/vinkje.png">Uploaden</a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>                            
                        
                    </div>
                </div>
                <div class="grayColumn">
                    <div class="titleBar">Contactpersoon</div>
                    <div class="contentBlock">
                        <div class="contact1">
                            <p>
                                <label><input type="radio" name="aanhef" value="De Heer" checked="checked" id="deheer" class="blackText">
                                    De heer</label>
                                <label><input type="radio" name="aanhef" value="Mevrouw" id="mevrouw" class="blackText">
                                    Mevrouw</label>
                            </p>
                            <div class="left-div1">
                                <fieldset>
                                        <p><span class="person"></span><input type="text" placeholder="Voornaam" name="Voornaam" value="<?php echo $dealer[0]->firstName?>"><div class="errormessage" id="Voornaam"></div></p>
                                        <p><span class="person"></span><input type="text" placeholder="Tussenvoegsel" name="Tussenvoegsel" value="<?php echo $dealer[0]->middleName?>"><div class="errormessage" id="Tussenvoegsel"></div></p>
                                        <p><span class="person"></span><input type="text" placeholder="Achternaam" name="Achternaam" value="<?php echo $dealer[0]->lastName?>"><div class="errormessage" id="Achternaam"></div></p>
                                </fieldset>
                            </div>
                            <div class="right-div1">
                                <fieldset>
                                        <p><span class="mobile"></span><input type="text" placeholder="Telefoonnummer" name="Telefoonnummer2" value="<?php echo $dealer[0]->user_phoneNumber1?>"><div class="errormessage" id="Telefoonnummer2"></div></p>
                                        <p><span class="mail"></span><input type="text" placeholder="E-mail adres" name="userEmail" value="<?php echo $dealer[0]->user_email; ?>"><div class="errormessage" id="userEmail"></div></p>
                                </fieldset>
                            </div>
                        </div>
                        <div class="clearfix"></div>                            
                        
                    </div>
                </div> 
                <div class="grayColumn">
                    <div class="titleBar">Gebruikersnaam en Wachtwoord</div>
                    <div class="contentBlock">
                        <div class="contact1">
                            <div class="left-div1">
                                <fieldset>
                                        <p><span class="id-card"></span></p><div class="org-size"><b>VWE Klantnummer:</b> <span class="org-right">77175</span> </div><p></p>
                                        <p><span class="id-card"></span></p><div class="org-size"><b>Gebruikersnaam:</b> <span class="org-right"><?php echo $dealer[0]->user_email?></span></div><p></p>
                                        <p><span class="key"></span><input type="text" placeholder="Nieuw wachtwoord" name="password" value=""><div class="errormessage" id="password"></div></p>
                                        <p><span class="key"></span><input type="text" placeholder="Bevestig wachtwoord" name="confirmpassword" value=""><div class="errormessage" id="confirmpassword"></div></p>
                                </fieldset>
                            </div>
                        </div>
                        <div class="clearfix"></div>                            
                        
                    </div>
                </div> 
                <div class="grayColumn">
                    <div class="titleBar">Imoby URL en e-mailadres</div>
                    <div class="contentBlock">
                        <div class="contact1">
                            <div class="left-div2">
                                <fieldset>
                                        <p><span class="clip"></span><input type="text" placeholder="" name="Achternaam2" value=""> <b>.imoby.nl</b></p>
                                        <p><span class="mail"></span></p><div class="org-size"><b>garage.jansen@imoby.nl</b></div><p></p>
                                </fieldset>
                            </div>
                        </div>
                        <div class="clearfix"></div>                            
                        
                    </div>
                </div>
                <div class="grayColumn">
                    <div class="titleBar">Bedrijfsomschrijving</div>
                    <div class="contentBlock">
                        <div class="contact1">
                                <textarea id="elm1" name="area"></textarea>
                            <p>Deze omschrijving wordt op uw bedrijfspagina getoond.</p>
                            <div class="buttonholder right"><a class="button addRelatie" href="javascript:void(0)" onclick="saveProfile();"><img class="add" src="<?= base_url() ?>assets/images/vinkje.png">Opslaan</a></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div> 
                </form>  
            </div>
</div>
<script type="text/javascript">
        function saveProfile() {
            $.ajax({
                url: "<?php echo base_url('backoffice/profile/saveProfile');?>",
                type: "post",
                data: $("#saveDealerProfile").serialize(),
                success: function(e) {
                    if(e == 'success'){
                        alert('Data Updated Successfully!');
                    }else{
                            $.each($.parseJSON(e), function( key, val ) {
                                $('#'+key).html(val);
                        });
                    }
                },
                error: function(er) {
                    alert(er);
                }
            });


        }
    </script>
<?php $this->load->view('backoffice/layouts/footer'); ?>
