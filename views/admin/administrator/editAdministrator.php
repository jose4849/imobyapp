<?php $this->load->view('admin/layout/header'); ?>
<?php
if (($superadmin == 1) || ($current == 1)) {
    $readonly = '';
} else {
    $readonly = 'disabled';
    $read = 'readonly';
}
?>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/new-style.css" type="text/css" media="print, projection, screen" />
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('admin/layout/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">

            <a class="breadcrumb" href="<?php echo base_url('admin/') ?>">  Admin Panel  </a>   &gt;   <a class="breadcrumb" href="<?php echo base_url('admin/beheerders/'); ?>">  Beheerders  </a>   &gt;   <span class="lastBreadcrumbs">  <?php echo $users->firstName; ?> <?php echo $users->middleName; ?> <?php echo $users->lastName; ?>  </span>
        </div>
        <div class="grayColumn">

            <div class="titleBar">  <?php echo $users->firstName; ?> <?php echo $users->middleName; ?> <?php echo $users->lastName; ?>  <a onclick="user_delete('<?php echo $users->id; ?>')"style="float:right;color:white;padding-right:25px;cursor:pointer;">X</a></div>
            <div class="contentBlock">
                <form action="" id="addUserForm">
                    <div class="contant-white-panel">
                        <h4>  Persoonlijke gegevens  </h4>
                        <p>
                            <label><input <?php $salutation=$users->salutation; if($salutation=='De Heer'){ echo "checked='checked'"; } ?>  type="radio" name="aanhef" value="De Heer"  id="deheer" class="blackText" />  
                                De heer  </label>
                            <label><input <?php  $salutation=$users->salutation; if($salutation=='Mevrouw'){ echo 'checked="checked"'; } ?>  type="radio" name="aanhef" value="Mevrouw" id="mevrouw" class="blackText" />  
                                Mevrouw  </label>
                        </p>
                        <div class="left-panel">
                            <fieldset>
                                <!--  <form action=""> -->
                                <p><span class="person"></span><input <?php echo $readonly; ?>  type="text" placeholder="Voornaam" name="Voornaam" value="<?php echo $users->firstName; ?>" />
                                <div class="errormessage" id="Voornaam"></div></p>
                                <p><span class="person"></span><input <?php echo $readonly; ?>  type="text" placeholder="Tussenvoegsel" name="Tussenvoegsel" value="<?php echo $users->middleName; ?>" />
                                <div class="errormessage" id="Tussenvoegsel"></div></p>
                                <p><span class="person"></span><input <?php echo $readonly; ?>  type="text" placeholder="Achternaam" name="Achternaam" value="<?php echo $users->lastName; ?>" />
                                <div class="errormessage" id="Achternaam"></div></p>
                                <!-- </form> -->
                            </fieldset>
                        </div>
                        <div class="right-panel">
                            <fieldset>
                                <!-- <form action=""> -->
                                <p><span class="phone"></span><input <?php echo $readonly; ?>  type="text" placeholder="Telefoonnummer" name="Telefoonnummer" value="<?php echo $users->phoneNumber1; ?>">
                                <div class="errormessage" id="Telefoonnummer"></div></p>
                                <p><span class="mail"></span><input <?php echo $readonly; ?>  type="email" placeholder="E-mail adres" name="email" value="<?php echo $users->email; ?>">
                                <div class="errormessage" <?php echo $readonly; ?>  id="email"></div></p>
                                <p><span class="drak">  &nbsp;&nbsp;&nbsp;Beheerder ID   </span><span class="gray">  ID<?php echo $users->id; ?>  </span> </p>
                                <!--  </form> -->
                            </fieldset>
                        </div>
                        <div class="clearfix"></div>  
                        <h4>  Bedrijfsgegevens  </h4>
                        <div class="left-panel">
                            <fieldset>
                                <!-- <form action=""> -->
                                <p><span title="Company Name" <?php echo $readonly; ?>  class="briefcase"></span><input <?php echo $readonly; ?>  type="text" placeholder="Organisatie" name="organization" value="<?php echo $users->organization; ?>">
                                <div class="errormessage" <?php echo $readonly; ?>  id="bedrijfsnaam"></div></p>
                                <p><span title="Company Name" <?php echo $readonly; ?>  class="briefcase"></span><input <?php echo $readonly; ?>  type="text" placeholder="Functie" name="function" value="<?php echo $users->function; ?>">
                                <div class="errormessage" <?php echo $readonly; ?>  id="Functie"></div></p>
                                <!-- </form> -->
                            </fieldset>
                        </div>
                        <div class="clearfix"></div>  


                        <?php if (($superadmin == 1) || ($current == 1)) { ?>
                            <?php if ($superadmin): ?>
                                <h4>  Rechtenprofiel  </h4>
                                <div class="left-panel">
                                    <fieldset>

                                        <!--  <form action=""> -->
                                        <div class="label-border">
                                            <label for="klant_actief" class="relatie">Superuser</label>
                                            <span class="checkBoxSlider actief2" id="klant_actief">
                                                <button type="button" class="suppera radioSliderTrue actief2 <?= ($is_superadmin) ? 'radioSliderActive' : 'radioSliderInactive' ?>">  aan  </button>
                                                <button type="button" class="supperi radioSliderFalse actief2 <?= (!$is_superadmin) ? 'radioSliderActive' : 'radioSliderInactive' ?>">  uit  </button>
                                                <br>
                                                <input type="hidden" name="actief2" id="supperu" value="<?php echo $is_superadmin; ?>" >

                                            </span>
                                        </div>
                                        <div class="clearfix"></div>  
                                        <div class="label-border">
                                            <label for="klant_actief" class="relatie">Admin</label>
                                            <span class="checkBoxSlider actief" id="klant_actief">
                                                <button type="button" class="admina radioSliderTrue actief <?= ($is_admin) ? 'radioSliderActive' : 'radioSliderInactive' ?>">  aan  </button>
                                                <button type="button" class="admini radioSliderFalse actief <?= (!$is_admin) ? 'radioSliderActive' : 'radioSliderInactive' ?>">  uit  </button>
                                                <br>
                                                <input type="hidden" id="adminu" name="actief" value="<?php echo $is_admin; ?>" >
                                            </span>
                                        </div>


                                        <!-- </form> -->


                                    </fieldset>
                                </div>
                            <?php endif; ?>



                            <div class="clearfix"></div>
                            <h4>Wachtwoord wijzigen</h4>
                            <div class="left-panel">
                                <fieldset>
                                    <!-- <form action=""> -->
                                    <?php if (($superadmin == 1)) { ?>                          
                                        <p><span title="lock" class="lock"></span><input type="text" placeholder="Nieuw wachtwoord" name="lock" value="">
                                        <div class="errormessage" id="lock"></div></p>
                                    <?php } else { ?>
                                        <p><span title="lock" class="lock"></span><input type="text" placeholder="Huidig wachtwoord" name="old_password" value="">
                                        <div class="errormessage" id="lock"></div></p>

                                        <p><span title="lock" class="lock"></span><input type="text" placeholder="Nieuw wachtwoord" name="lock" value="">
                                        <div class="errormessage" id="lock"></div>
                                        <div class="errormessage" id="passnotmatch"></div>
                                        </p>
                                    <?php } ?>
                                    <!-- </form> -->
                                </fieldset>
                            </div>
                        <?php } ?>






                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <div class="msg" id="msg"></div>
                    <div class="buttonholder right">
                        <?php if (($superadmin == 1) || ($current == 1)) { ?>
                            <a class="button addRelatie" href="javascript:void(0)" onclick="saveUser();">
                                <img class="add" src="<?php echo base_url(); ?>/assets/images/vinkje.png">
                                Opslaan 
                            </a>
                        <?php } ?>
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
                url: "<?php echo base_url('admin/beheerders/update/' . $users->id); ?>",
                type: "post",
                data: $("#addUserForm").serialize(),
                success: function(e) {
                    alert(e);                 
                    var obj = JSON.parse(e);
                    if(obj.success){
                        alert('De wijzigingen zijn succesvol opgeslagen.');
                        url="<?php echo base_url('admin/beheerders/'); ?>";
                        location.assign(url);
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
		
        $( document ).ready(function() {
            /* for super admin start */
            $( ".suppera" ).click(function() {
                $("#supperu").val("1");
            });
            $( ".supperi" ).click(function() {
                $("#supperu").val("0");
            });
            /* for super admin end */

            /* for admin start */
            $( ".admina" ).click(function() {
                $("#adminu").val("1");
            });
            $( ".admini" ).click(function() {
                $("#adminu").val("0");
            });
            /* for admin end */
		
        });
        function user_delete(id){
            var con = confirm("Weet u zeker dat u deze beheerder wilt verwijderen?");           
            if(con==true){
                $.ajax({
                    url: "<?php echo base_url('admin/beheerders/delete_user/'); ?>",
                    type: "post",
                    data: { user_id:id },
                    success: function(e) { 
                        alert(e);
                        url="<?php echo base_url('admin/beheerders/'); ?>";
                        location.assign(url);
                    },
                    error: function(er) {
                        alert(er);
                        url="<?php echo base_url('admin/beheerders/'); ?>";
                        location.assign(url);
                    }
                });
                console.log('Delete in process');
            }
            else{
                alert('Thank You');
            } 
        }
    </script>
    <?php $this->load->view('admin/layout/footer'); ?>