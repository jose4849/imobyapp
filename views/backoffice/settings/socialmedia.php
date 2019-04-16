<?php $this->load->view('backoffice/layouts/header'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/popup.css') ?>" type="text/css" />

<script type="text/javascript" src="<?= base_url('assets/js/jquery.popup.js') ?>"></script>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/settings/layouts/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a href="#" class="breadcrumb">Instellingen</a> > <span class="lastBreadcrumbs">Social Media</span>
        </div>
        <div class="grayColumn">
            <div class="titleBar">Social Media</div>
            <div class="contentBlock">
                <div class="contact1">
                    <div class="gray-inner">
                        <h5>Hier kunt u uw Youtube, Facebook en/of Twitter accounts aan Imoby koppelen. Nieuwe presentaties worden dan automatisch op de 
                            gekoppelde social media kanalen geplaatst.</h5>
                        <div class="socialMbox">
                            <?php
                            //print_r($social_media);
                            $facebookId = 0;
                            $facebookUrl = '';
                            $facebookStatus = 0;
                            $twiterId = 0;
                            $twiterUrl = '';
                            $twiterStatus = 0;
                            $youtubeId = 0;
                            $youtubeUrl = '';
                            $youtubeStatus = 0;
                            foreach ($social_media as $key => $value) {
                                if ($value->social_type == 'facebook') {
                                    $facebookId = $value->id;
                                    $facebookUrl = $value->social_post;
                                    $facebookStatus = $value->updated_status;
                                } elseif ($value->social_type == 'twitter') {
                                    $twiterId = $value->id;
                                    $twiterUrl = $value->social_post;
                                    $twiterStatus = $value->updated_status;
                                } elseif ($value->social_type == 'youtube') {
                                    $youtubeId = $value->id;
                                    $youtubeUrl = $value->social_post;
                                    $youtubeStatus = $value->updated_status;
                                }
                            }
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="p30"><span></span></th>
                                        <th class="p40"><span></span></th>
                                        <th class="p20"><span></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="<?= base_url() ?>assets/crmAssets/images/facebook.jpg" />Gekoppeld</td>
                                        <td>
                                            <input type="url" class="facebook" placeholder="https://www.facebok.com/userid" name="Telefoonnummer" value="<?= $facebookUrl; ?>" readonly="">
                                            <div id="facebook" style="display:none">

                                                <h3 id="titley" >Imoby en Facebook</h3>
                                                <p class="titledesc">
                                                    Hier kunt uw Facebook account koppelen aan Imoby. Dit stelt 
                                                    Imoby in staat om automatisch uw nieuwe presentaties te posten op uw Facebook account.
                                                </p> 

                                                <div>
                                                    <a href="https://www.facebook.com/dialog/oauth?client_id=453040708126615&amp;redirect_uri=http%3A%2F%2Flocalhost%2Fimobynl_main%2Fuser%2Ffacebook%2F&amp;state=172f93fe249e0643c3d2e24d6daaa4a5&amp;scope=read_stream%2Cpublish_stream%2Cmanage_pages%2Coffline_access" class="btn">Inloggen met uw Facebook account</a><br><br>
                                                    <img src="<?php echo base_url(); ?>assets/crmAssets/images/facebook.jpg">

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="buttonholder">
                                                <a id="<?= $facebookId; ?>" class="<?= ($facebookStatus) ? "button-gr addRelatie" : "button addRelatie" ?>" href="#" <?= ($facebookStatus) ? 'onclick="changeSocialMediaStatus(this,true);"' : 'onclick="changeSocialMediaStatus(this,false);"' ?> >
                                                   <img class="add" src="<?= ($facebookStatus) ? base_url('assets/crmAssets/images/vinkje-grray.png') : base_url('assets/crmAssets/images/vinkje.png') ?>">
                                                    <?= ($facebookStatus) ? 'Ontkoppel' : 'Koppel' ?>
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="<?= base_url() ?>assets/crmAssets/images/twiter.jpg" />Niet gekoppeld</td>
                                        <td>
                                            <input class="twitter" type="url" placeholder="https://www.twitter.com/userid" name="Telefoonnummer" value="<?= $twiterUrl; ?>" readonly="">
                                            <div id="twitter" style="display:none">

                                                <h3 id="titley" >Imoby en Twitter</h3><br>
                                                <p class="titledesc">Hier kunt uw Twitter account koppelen aan Imoby. Dit stelt 
                                                    Imoby in staat om automatisch uw nieuwe presentaties te posten op uw Twitter account.</p> 
                                                <div class="twitterlogin">
                                                    <a href="https://api.twitter.com/oauth/authenticate?oauth_token=wddQUyZP9ZvTXBy4bzQVvvkacfbP24v6" class="btn">Inloggen met uw Twitter Account</a><br><br>
                                                    <img src="<?php echo base_url(); ?>assets/crmAssets/images/twiter.jpg">

                                                </div>
                                            </div>                                        

                                        </td>
                                        <td>
                                            <div class="buttonholder">
                                                <a id="<?= $twiterId; ?>" class="<?= ($twiterStatus) ? "button-gr addRelatie" : "button addRelatie" ?>" href="#" <?= ($twiterStatus) ? 'onclick="changeSocialMediaStatus(this,true);"' : 'onclick="changeSocialMediaStatus(this);"' ?> >
                                                   <img class="add" src="<?= ($twiterStatus) ? base_url('assets/crmAssets/images/vinkje-grray.png') : base_url('assets/crmAssets/images/vinkje.png') ?>">
                                                    <?= ($twiterStatus) ? 'Ontkoppel' : 'Koppel' ?>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><img src="<?= base_url() ?>assets/crmAssets/images/youtube.jpg" />Niet gekoppeld</td>
                                        <td>
                                            <input class="youtube" id="youtubeId" type="url" placeholder="https://www.youtube.com/users/userid" name="Telefoonnummer" value="<?= $youtubeUrl; ?>" readonly="">
                                            <div id="youtube" style="display:none">

                                                <h3 id="titley" >Imoby en Youtube</h3><br>
                                                <p class="titledesc">Hier kunt uw Youtube account koppelen aan Imoby. Dit stelt 
                                                    Imoby in staat om automatisch uw nieuwe presentaties te posten op uw Youtube account.</p> 
                                                <div class="twitterlogin">
                                                    <a href="https://accounts.google.com/o/oauth2/auth?response_type=code&redirect_uri=http%3A%2F%2Fapp.imoby.nl%2Fyoutube.php&client_id=864967251487.apps.googleusercontent.com&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fyoutube&access_type=offline&approval_prompt=force&pageId=none" class="btn">Inloggen met uw Twitter Account</a><br><br>
                                                    <img src="<?php echo base_url(); ?>assets/crmAssets/images/youtube.jpg">

                                                </div>
                                            </div>                                        
                                        
                                        </td>
                                        <td>
                                            <div class="buttonholder">
                                                <a id="<?= $youtubeId; ?>" class="<?= ($youtubeStatus) ? "button-gr addRelatie" : "button addRelatie" ?>" href="#" <?= ($youtubeStatus) ? 'onclick="changeSocialMediaStatus(this,true);"' : 'onclick="changeSocialMediaStatus(this);"' ?> >
                                                   <img class="add" src="<?= ($youtubeStatus) ? base_url('assets/crmAssets/images/vinkje-grray.png') : base_url('assets/crmAssets/images/vinkje.png') ?>">
                                                    <?= ($youtubeStatus) ? 'Ontkoppel' : 'Koppel' ?>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h5>Geen social media kanalen? Laat uw accounts maken en koppelen door Imoby. Vul uw gegevens hieronder aan.<br>
                            <span>Totale kosten bedragen € 95,- excl. BTW.</span></h5>
                        <p>
                            <label>
                                <input class="blackText" id="deheer" type="radio" checked="checked" value="De Heer" name="gender" />
                                De heer
                            </label>
                            <label><input class="blackText" id="mevrouw" type="radio" value="Mevrouw" name="gender" />
                                Mevrouw</label>
                        </p>
                        <div class="left-div1">
                            <fieldset>
                                <form action="">
                                    <p><span class="person"></span><input type="name" value="" id="voorname" name="Voornaam" placeholder="Voornaam" /></p>
                                    <p><span class="person"></span><input type="name" value="" id="tussenvoegsel" name="Tussenvoegsel" placeholder="Tussenvoegsel" /></p>
                                    <p><span class="person"></span><input type="name" value="" id="achternaam" name="Achternaam" placeholder="Achternaam" /></p>
                                </form>
                            </fieldset>
                        </div>
                        <div class="right-div1">
                            <fieldset>
                                <form action="">
                                    <p><span class="phone"></span><input type="text" value="" id="telefoonnummer" name="Telefoonnummer" placeholder="Telefoonnummer" /></p>
                                    <p><span class="mail"></span><input type="email" value="" id="emailaddress" name="E-mail adres" placeholder="E-mail adres" /></p>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div> 
                <div class="grayColumn">
                   
                    <div class="contentBlock">
                        <div class="contact1">
                            
                            <div class="buttonholder right"><a onclick="requestforsocialmedia();" href="javascript:void(0)" class="button addRelatie"><img src="<?= base_url() ?>assets/images/vinkje.png" class="add">Verzenden</a></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </form>
            </div>
        </div>   
    </div>
</div>

<script type="text/javascript">
    function changeSocialMediaStatus(val, status) {
        $.ajax({
            type: 'POST',
            cache: false,
            url: "<?php echo base_url('backoffice/instellingen/changeSocialMediaStatus'); ?>",
            data: {id: val.id, status: status},
            beforeSend: function() {
            },
            success: function(data) {
                if (data)
                    location.reload();
            },
            error: function(xhr, textStatus, thrownError) {
            }
        });
    }


    /* for pop up */
    $(function() {


        $('.facebook').popup({
            content: $('#facebook'),
            width: 600,
            height: 350
        });
        $('.twitter').popup({
            content: $('#twitter'),
            width: 600,
            height: 350
        });
        $('.youtube').popup({
            content: $('#youtube'),
            width: 600,
            height: 350
        });
    });
    /* popup end */
    function requestforsocialmedia(){
        var gender = $('input:radio[name=gender]:checked').val();
        var mevrouw = $("#voorname").val();
        var tussenvoegsel = $("#tussenvoegsel").val();
        var achternaam = $("#achternaam").val();
        var telefoonnummer = $("#telefoonnummer").val();
        var emailaddress = $("#emailaddress").val();
        $.ajax({
            type: 'POST',
            cache: false,
            url: "<?php echo base_url('backoffice/instellingen/socialmediaemail'); ?>",
            data: {dealer_id:'<?php echo $dealer[0]->imobycode ?>' ,company_name:'<?php echo $dealer[0]->name ?>' ,gender:gender, mevrouw: mevrouw, tussenvoegsel:tussenvoegsel,achternaam:achternaam,telefoonnummer:telefoonnummer,emailaddress:emailaddress },
            beforeSend: function() {
            },
            success: function(data) {
                
                   // location.reload();
                   alert(data);
            },
            error: function(xhr, textStatus, thrownError) {
            }
        });
    }

</script>
<style type="text/css">
    .socialMbox input{ cursor: pointer; }
    .popup .popup_content{}
    .popup .popup_content h3{
        background: #195d82;
        color: #ffffff;
        font-weight: bolder;
        margin: 0px;
        padding: 10px;        
        display: block;
    }
    .popup .popup_content .popup-div{
        background: #f4f4f4; border: 1px solid #e9e9e9; border-top: none; padding: 10px;
    }
    .popup .popup_content .popup-div p{
        margin: 0;
    }
</style>
<?php $this->load->view('backoffice/layouts/footer'); ?>
