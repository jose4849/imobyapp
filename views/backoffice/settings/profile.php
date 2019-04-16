<?php $this->load->view('backoffice/layouts/header'); ?>
<script src="<?php echo base_url(); ?>assets/js/dropzone.js"></script>

<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/settings/layouts/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a class="breadcrumb" href="#">Instellingen</a> &gt; <span class="lastBreadcrumbs">Profiel</span>
        </div>
        <?php if (!empty($dealer)) { ?>
            <form action="" id="saveDealerProfile">
                <div class="grayColumn">
                    <div class="titleBar">Bedrijfsgegevens</div>
                    <div class="contentBlock">
                        <div class="company1">
                            <div class="left-div1">
                                <fieldset>
                                    <p><span class="briefcase"></span><input type="text" placeholder="Bedrijfsnaam" name="Bedrijfsnaam" value="<?php echo $dealer[0]->name ?>"><div class="errormessage" id="Bedrijfsnaam"></div></p>
                                    <p><span class="house"></span><input type="text" placeholder="Adres" name="Adres" value="<?php echo $dealer[0]->street ?>">
                                        <input type="hidden" placeholder="Adres" name="house_num" value="<?php echo $dealer[0]->house_num; ?>">
                                        <input type="hidden" placeholder="Adres" name="house_num_addition" value="<?php echo $dealer[0]->house_num_addition; ?>">

                                    </p>
                                    <p><span class="house"></span><input type="text" placeholder="Postcode" name="Postcode" value="<?php echo $dealer[0]->postal_code ?>"><div class="errormessage" id="Postcode"></div></p>
                                    <p><span class="house"></span><input type="text" placeholder="Vestigingsplaats" name="Vestigingsplaats" value="<?php echo $dealer[0]->accountnumber ?>"><div class="errormessage" id="Vestigingsplaats"></div></p>
                                    <p><span class="kvknr"></span><input type="text" placeholder="KvKnr" name="KvKnr" value="<?php echo $dealer[0]->chamberOfCommerce ?>"><div class="errormessage" id="KvKnr"></div></p>
                                    <p><span class="btwnr"></span><input type="text" placeholder="BTWnr" name="BTWnr" value="<?php echo $dealer[0]->Taxcode ?>"><div class="errormessage" id="BTWnr"></div></p>
                                </fieldset>
                            </div>
                            <div class="right-div1">
                                <fieldset>
                                    <p><span class="phone"></span><input type="text" placeholder="Telefoonnummer" name="Telefoonnummer" value="<?php echo $dealer[0]->dealer_phoneNumber1 ?>"><div class="errormessage" id="Telefoonnummer"></div></p>
                                    <p><span class="phone"></span><input type="text" placeholder="Faxnummer" name="Faxnummer" value="<?php echo $dealer[0]->faxNumber ?>"><div class="errormessage" id="Faxnummer"></div></p>
                                    <p><span class="mail"></span><input type="text" placeholder="E-mail adres" name="useremail" value="<?php echo $dealer[0]->user_email ?>"><div class="errormessage" id="comEmail"></div></p>
                                    <p><span class="web"></span><input type="text" placeholder="Website" name="Website" value="<?php echo $dealer[0]->website ?>"><div class="errormessage" id="Website"></div></p>
                                </fieldset>
                            </div>
                            <div class="right-div-last">
                                <div class="img-block">
                                    <div class="remove-logo icon-remove-sign">
                                        <i class="fa fa-remove" onclick="removeLogo('<?php echo $user->id ?>')"></i>
                                    </div>
                                    <?php
                                    $users_id = $user->id;
                                    $filename = getcwd() . "/media/dealers/" . $dealer_id . "/logo_" . $dealer_id . ".jpg";
                                    if (file_exists($filename)) {
                                        ?>
                                        <img  alt="placeholder" width="114"  src="<?= base_url() ?>media/dealers/<?php echo $dealer_id; ?>/logo_<?php echo $dealer_id; ?>.jpg">
                                    <?php } else { ?>                      
                                        <img width="" height="" alt="placeholder" src="<?= base_url() ?>assets/images/placeholder.png">
                                        <span>Bedrijfslogo</span>
                                    <?php } ?>

                                </div>
                                <div class="buttonholder">
                                    <a id="dropzone" class="button addRelatie" href="#"><img class="add" src="<?= base_url() ?>assets/images/vinkje.png">Uploaden</a>
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
                                <label><input type="radio" <?php $salutation = $dealer[0]->salutation;
                                if ($salutation == 'De Heer') {
                                    echo "checked='checked'";
                                } ?> name="aanhef" value="De Heer" checked="checked" id="deheer" class="blackText">
                                    De heer</label>
                                <label><input type="radio" <?php $salutation = $dealer[0]->salutation;
                                if ($salutation == 'Mevrouw') {
                                    echo 'checked="checked"';
                                } ?> name="aanhef" value="Mevrouw" id="mevrouw" class="blackText">
                                    Mevrouw</label>
                            </p>
                            <div class="left-div1">
                                <fieldset>
                                    <p><span class="person"></span><input type="text" placeholder="Voornaam" name="Voornaam" value="<?php echo $dealer[0]->firstName ?>"><div class="errormessage" id="Voornaam"></div></p>
                                    <p><span class="person"></span><input type="text" placeholder="Tussenvoegsel" name="Tussenvoegsel" value="<?php echo $dealer[0]->middleName ?>"><div class="errormessage" id="Tussenvoegsel"></div></p>
                                    <p><span class="person"></span><input type="text" placeholder="Achternaam" name="Achternaam" value="<?php echo $dealer[0]->lastName ?>"><div class="errormessage" id="Achternaam"></div></p>
                                </fieldset>
                            </div>
                            <div class="right-div1">
                                <fieldset>
                                    <p><span class="mobile"></span><input type="text" placeholder="Telefoonnummer" name="Telefoonnummer2" value="<?php echo $dealer[0]->user_phoneNumber1 ?>"><div class="errormessage" id="Telefoonnummer2"></div></p>
                                    <p><span class="mail"></span><input type="text" placeholder="E-mail adres" name="userEmail" value="<?php echo $dealer[0]->dealer_email; ?>"><div class="errormessage" id="userEmail"></div></p>
                                </fieldset>
                            </div>
                        </div>
                        <div class="clearfix"></div>                            

                    </div>
                </div> 
                <div class="grayColumn">
                    <div class="titleBar">Gebruikersnaam en wachtwoord</div>
                    <div class="contentBlock">
                        <div class="contact1">
                            <div class="left-div1">
                                <fieldset>
                                    <p><span class="id-card"></span></p><div class="org-size"><b>Imoby ID:</b> <span class="org-right"><?php echo $dealer[0]->homePageId ?></span> </div><p></p>
                                    <p><span class="id-card"></span></p><div class="org-size"><b>Gebruikersnaam:</b> <span class="org-right"><?php echo $dealer[0]->user_email ?></span></div><p></p>
                                    <p><span class="key"></span><input type="password" placeholder="Oud Wachtwoord" name="old_password" value=""><div class="errormessage" id="old_password"></div></p>
                                    <p><span class="key"></span><input type="password" placeholder="Nieuw wachtwoord" name="new_password" value=""><div class="errormessage" id="password"></div></p>

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
                            <div class="left-div2 urlEmailAddress">
                                <fieldset>
                                    <p><label><span class="clip"></span><input type="text" placeholder=""  value="<?php echo $dealer[0]->homePageId ?>"> <b>.imoby.nl</b></label><a href="#" class="resetUrl">Reset URL</a></p>
                                    <p><label><span class="mail"></span><input type="text" placeholder="" id="email_id" onkeyup="newemail()" value="<?php echo $dealer[0]->homePageId ?>"><b>@mail.imoby.nl</b></label><a href="#" class="resetEmail">Reset emailadres</a></p>
                                    <p id="message">Please use between 6 and 30 characters.</p>
                                </fieldset>
                            </div>
                        </div>
                        <div class="clearfix"></div>                          
                    </div>
                    <div class="contentBlock">
                        <div class="contact1">
                            <div class="buttonholder right"><a class="button addRelatie" href="javascript:void(0)" onclick="saveProfile();"><img class="add" src="<?= base_url() ?>assets/images/vinkje.png">Opslaan</a></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="grayColumn">

                </div> 
            </form>
<?php } ?>
    </div>
</div>
<script type="text/javascript">
    function saveProfile() {
        $.ajax({
            url: "<?php echo base_url('backoffice/instellingen/saveProfile'); ?>",
            type: "post",
            data: $("#saveDealerProfile").serialize(),
            success: function (e) {
                alert(e);
                if (e == 'success') {

                    alert('Data Updated Successfully!');
                } else {
                    /*
                     $.each($.parseJSON(e), function(key, val) {
                     $('#' + key).html(val);
                     }); */
                }
            },
            error: function (er) {
                alert(er);
            }
        });
    }

    function removeLogo(user_id) {
        alert(user_id);
        var url = "<?php echo base_url('backoffice/instellingen/delete_profile_image'); ?>/";
        $.ajax({
            url: url,
            type: "post",
            data: {user_id: user_id},
            success: function (e) {
                location.reload();

            }});
    }


    $(document).ready(function () {
        /* start from here */

        /* end here */
    });
    function newemail() {
        $("#message").css("color", "red");

        var email_id = $('#email_id').val();
        var url = "<?php echo base_url('backoffice/instellingen/newemailsearch'); ?>/";
        $.ajax({
            url: url,
            type: "post",
            data: {email_id: email_id},
            success: function (e) {
                $('#message').text(e);
            }});




    }

</script>
<script type="text/javascript">
    jQuery(function ($) {
        $("#dropzone").dropzone({url: "<?php echo base_url('backoffice/instellingen/uploader'); ?>?userid=<?php echo $dealer_id; ?>", success: function (response) {
                        location.reload();
                    }}
                );
            });
</script>
<style>
    .dz-preview{display:none;}
</style>
<?php $this->load->view('backoffice/layouts/footer'); ?>
