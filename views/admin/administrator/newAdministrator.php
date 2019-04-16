<?php $this->load->view('admin/layout/header'); ?>
<!--<link rel="stylesheet" href="<?= base_url() ?>assets/css/new-style.css" type="text/css" media="print, projection, screen" />-->
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('admin/layout/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a class="breadcrumb" href="#">Admin Panel</a> &gt; <a class="breadcrumb" href="#">Beheerders</a> &gt; <span class="lastBreadcrumbs">Nieuwe beheerder</span>
        </div>
        <div class="grayColumn">
            <div class="titleBar">Nieuwe beheerder</div>
            <div class="contentBlock">
                <form action="" id="addUserForm">
                    <div class="contant-white-panel">
                        <h4>Persoonlijke gegevens</h4>
                        <p>
                            <label><input type="radio" name="aanhef" value="De Heer" checked="checked" id="deheer" class="blackText">
                                De heer</label>
                            <label><input type="radio" name="aanhef" value="Mevrouw" id="mevrouw" class="blackText">
                                Mevrouw</label>
                        </p>
                        <div class="left-panel">
                            <fieldset>
                                <!--  <form action=""> -->
                                <p><span class="person"></span><input type="name" placeholder="Voornaam" name="Voornaam" value="">
                                    <div class="errormessage" id="Voornaam"></div></p>
                                <p><span class="person"></span><input type="name" placeholder="Tussenvoegsel" name="Tussenvoegsel" value="">
                                    <div class="errormessage" id="Tussenvoegsel"></div></p>
                                <p><span class="person"></span><input type="name" placeholder="Achternaam" name="Achternaam" value="">
                                    <div class="errormessage" id="Achternaam"></div></p>
                                <!-- </form> -->
                            </fieldset>
                        </div>
                        <div class="right-panel">
                            <fieldset>
                                <!-- <form action=""> -->
                                <p><span class="phone"></span><input type="text" placeholder="Telefoonnummer" name="Telefoonnummer" value="">
                                    <div class="errormessage" id="Telefoonnummer"></div></p>
                                <p><span class="mail"></span><input type="email" placeholder="E-mail adres" name="email" value="">
                                    <div class="errormessage" id="email"></div></p>
                               <!-- <p><span class="drak">&nbsp;&nbsp;&nbsp;Beheerder ID </span><span class="gray">ID123456</span> </p>-->
                                <!--  </form> -->
                            </fieldset>
                        </div>
                        <div class="clearfix"></div>  
                        <h4>Bedrijfsgegevens</h4>
                        <div class="left-panel">
                            <fieldset>
                                <!-- <form action=""> -->
                                <p><span title="Company Name" class="briefcase"></span><input type="text" placeholder="Organisatie" name="organization" value="">
                                    <div class="errormessage" id="bedrijfsnaam"></div></p>
                                <p><span title="Company Name" class="briefcase"></span><input type="text" placeholder="Functie" name="function" value="">
                                    <div class="errormessage" id="Functie"></div></p>
                                <!-- </form> -->
                            </fieldset>
                        </div>
                        <div class="clearfix"></div>  
                        <h4>Rechtenprofiel</h4>
                        <div class="left-panel">
                            <fieldset>
                                <?php if ($superadmin): ?>
                                    <!--  <form action=""> -->
                                    <div class="label-border">
                                        <label for="klant_actief" class="relatie">Superuser</label>
                                        <span class="checkBoxSlider actief2" id="klant_actief">
                                            <button type="button" class="radioSliderTrue actief2 radioSliderActive">aan</button>
                                            <button type="button" class="radioSliderFalse actief2 radioSliderInactive">uit</button>
                                            <br>
                                            <input type="radio" name="actief2" value="1" checked="checked" class="radioSliderOn actief2">
                                            <input type="radio" name="actief2" value="0" class="radioSliderOff actief2">
                                        </span>
                                    </div>
                                    <div class="clearfix"></div>  
                                    <div class="label-border">
                                        <label for="klant_actief" class="relatie">Admin</label>
                                        <span class="checkBoxSlider actief" id="klant_actief">
                                            <button type="button" class="radioSliderTrue actief radioSliderActive ">aan</button>
                                            <button type="button" class="radioSliderFalse actief radioSliderInactive">uit</button>
                                            <br>
                                            <input type="radio" name="actief" value="1" checked="checked" class="radioSliderOn actief">
                                            <input type="radio" name="actief" value="0" class="radioSliderOff actief">
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <div class="label-border">
                                        <label for="klant_actief" class="relatie">Admin</label>
                                        <span class="checkBoxSlider actief" id="klant_actief">
                                            <button type="button" class="radioSliderTrue actief radioSliderActive ">aan</button>
                                            <button type="button" class="radioSliderFalse actief radioSliderInactive">uit</button>
                                            <br>
                                            <input type="radio" name="actief" value="1" checked="checked" class="radioSliderOn actief">
                                            <input type="radio" name="actief" value="0" class="radioSliderOff actief">
                                        </span>
                                    </div>
                                    <!-- </form> -->

                                <?php endif; ?>
                            </fieldset>
                        </div>
                        <div class="clearfix"></div>
                        <h4>Gebruikersnaam en wachtwoord</h4>
                        <div class="left-panel">
                            <fieldset>
                                <!-- <form action=""> -->
                                <p><span class="drak">Gebruikersnaam</span><span class="gray">E-mailadres</span></p>
                                <p><span title="lock" class="lock"></span><input type="text" placeholder="Wachtwoord" name="lock" value="">
                                    <div class="errormessage" id="lock"></div></p>
                                <!-- </form> -->
                            </fieldset>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="buttonholder right">
                        <a class="button addRelatie" href="javascript:void(0)" onclick="saveUser();">
                            <img class="add" src="<?php echo base_url(); ?>/assets/images/vinkje.png">
                            Toevoegen 
                        </a>
                    </div>
                </form>
                <div class="clearfix"></div>   
            </div>
        </div>   
    </div>
	</div>
    <script type="text/javascript">
        function saveUser() {
		   
            $.ajax({
                url: "<?php echo base_url('admin/beheerders/insert');?>",
                type: "post",
                data: $("#addUserForm").serialize(),
                success: function(e) {
                    if(e == 'success'){
                        alert('De nieuwe beheerder is met succes aangemaakt.');
                        var url="http://imobyupdate.projectflick.com/admin/beheerders";
                        window.location.assign(url)
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
    <?php $this->load->view('admin/layout/footer'); ?>