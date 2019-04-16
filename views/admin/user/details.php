<?php $this->load->view('admin/layout/header'); ?>
<script type="text/javascript" src="<?= base_url() ?>assets/dropzone.js"></script>
<?php
foreach ($dealer as $key => $value) {
    
}
$users_id = $value->users_id;
$dealer_id = $value->dealer_id;
$addresses_id = $value->addresses_id;
?>
<!-------------------------------------------------------------------------------------------------------------------->
<div class="messagepop2 pop">
    <lavel onclick="close_note()">X</lavel>
    <div id="titley"><h3 id="titleyh1" >Notitie maken</h3></div>
    <div id="noteinfo"></div>
</div>

<div class="messagepop pop">
    <lavel class="close">X</lavel>
    <div id="titley"><h3 id="titleyh1" >Opmerking plaatsen</h3></div>
    <input name="note_title" id="note_title" class="inputsubject" style="padding-left: 10px; color: rgb(0, 175, 216); width: 98%;" placeholder="Omschrijving">
    <textarea class="notearea" id="note_description" placeholder="Note"></textarea>
    <strong style="line-height:20px;">Bestand:</strong>
    <a class="button addRelatie" id="myId" href="#"><img class="add" src="<?php echo base_url(); ?>assets/images/add.png">Bladeren</a>
    <div style="width:100%;height:100px;">
        <div id="pre"></div>
    </div>
    <div id="attachfilename"></div>
    <p>Let op: Het Bestand mag niet groter Zijn dan 5mb.
        (pdf,jpg,doc,xls)</p>
    <a class="button addRelatie" style="float:right;" onclick="savenote()"  href="#"><img  class="add" src="<?php echo base_url(); ?>assets/images/vinkje.png">Opslaan</a>
    <script>
        var dealer = $('#dealer_id').val();
        var myDropzone = new Dropzone("#myId", {
            url: "<?php echo base_url(); ?>admin/gebruikers/note_up/?dealer_id=<?php echo $dealer_id; ?>",
            previewsContainer: '#pre',
            uploadMultiple: false,
            addRemoveLinks: true,
            maxFilesize: 5, // MB
            maxFiles: 3,
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                    this.removeAllFiles();
                    this.addFile(file);
                });
                
                this.on("success", function (file, responseText) {
                    $("#attachfilename").append(responseText+',');
                     
                });
                              
            },
            removedfile: function(file) {
                var allattach = $("#attachfilename").html();
                var res = allattach.split(",");
                console.log(res);
                console.log(file.name);
                var index = res.indexOf(file.name);
                if (index > -1) {
                    res.splice(index, 1);
                }
                $("#attachfilename").html(res);

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            complete: function(e) {
                // console.log(e);
                // $("#attachfilename").append(e.name + ',');
            }
        });
              
    </script>
    <style>
        .dz-preview{ width:100%;float:left;}
        .dz-image{ width:54px; border:opx solid red;float:left;}
        .dz-details{ float:left; width:150px; border:0px solid red; padding:7px;}
        .dz-image img{ height:54px;}
        .dz-success-mark{width:54px; border:0px solid red;float:left;}
        .dz-error-mark{ display:none;}

        .dz-remove {
            background-image: url("<?php echo base_url(); ?>/assets/images/closeup.png");
            border: 0 solid red;
            color: transparent;
            float: left;
            height: 55px;
            text-indent: -9944px;
            width: 55px;
        }

        #attachfilename{
            display:none;
        }

        #pre .dz-size {
            display: inline;
        }
        #pre .dz-filename {
            display: inline;
        }
        #pre .dz-success-mark{
            display: inline;
        }


        a.selected {
            background-color:#1F75CC;
            color:white;
            z-index:100;
        }
        #titley{  
            background: none repeat scroll 0 0 #195d82;
            color: #ffffff;
            display: block;
            font-weight: bolder;
            margin: 0; 
            line-height: 32px;
            padding-left:10px;
        }
        #titleyh1{ line-height: 32px; width: 96%;}
        .close{ float:right; cursor: pointer; }
        .inputsubject {
            border: 1px solid #195d82;
            border-radius: 2px;
            height: 27px;
            width: 99%;
            margin-bottom:10px;
        }
        .messagepop {
            z-index:999999999;
            background-color:#FFFFFF;
            border:1px solid #999999;
            cursor:default;
            display:none;
            margin-top: 15px;
            position:absolute;
            text-align:left;
            width:50%;
            margin-left:25%;
            z-index:50;
            padding: 25px 25px 20px;
        }
        .messagepop2 {
            z-index:999999999;
            background-color:#FFFFFF;
            border:1px solid #999999;
            cursor:default;
            display:none;
            margin-top: 15px;
            position:absolute;
            text-align:left;
            width:50%;
            margin-left:25%;
            z-index:50;
            padding: 25px 25px 20px;
        }
        label {
            display: block;
            margin-bottom: 3px;
            padding-left: 15px;
            text-indent: -15px;
        }

        .messagepop p, .messagepop.div {
            border-bottom: 1px solid #EFEFEF;
            margin: 8px 0;
            padding-bottom: 8px;
        }
        .notearea{
            border:1px solid #195D82;
            border-radius:2px;
            width: 95%;
            margin-top:10px;
            height:100px;
            margin-bottom:10px;
        }

        .dropdownnote {
            border: 1px solid #195D82;
            width: 40%;
        }
        .page-nav ul li{ float:right !important; }

    </style>
</div>
<script>
    function savenote() {
        var note_title = $("#note_title").val();
        var note_description = $("#note_description").val();
        var attachment = $("#attachfilename").html();

        var dealer = '<?php echo $value->users_id; ?>';
        var admin_id = '<?php echo $user->id; ?>';
        var url = "<?php echo base_url('admin/gebruikers/note_insert'); ?>/";
        $.ajax({
            url: url,
            type: "post",
            data: {note_title: note_title, note_description: note_description, file: attachment, dealer: dealer, admin_id: admin_id},
            success: function(e) {
                alert(e);
                location.reload();

            },
            error: function(er) {
                alert(er);
            }
        });

        //alert("Your Note successfully Save");
    }
    function viewnote(id) {
        $.ajax({
            url: "<?php echo base_url('admin/gebruikers/note_view'); ?>/",
            type: "post",
            data: {id: id},
            success: function(e) {
                $('.messagepop2').slideFadeToggle();
                $('#noteinfo').html(e);
            },
            error: function(er) {
                alert(er);
            }
        });
    }
    function delete_note(note_id,current_admin_id,admin_id){
        if(current_admin_id == admin_id){
            $.ajax({
                url: "<?php echo base_url('admin/gebruikers/delete_note'); ?>/",
                type: "post",
                data: {note_id: note_id,admin_id:admin_id},
                success: function(e) {
                    alert(e);
                    location.reload();
                },
                error: function(er) {
                    alert(er);
                }
            });
        }
        else{
            alert('You Cannot Delete this note.');
        }
    }
    function close_note() {
        $('.messagepop2').slideFadeToggle(function() {
            e.removeClass('selected');
        });
        location.reload();
    }
    function deselect(e) {
        $('.pop').slideFadeToggle(function() {
            e.removeClass('selected');
        });
    }

    $(function() {
        $('#contact').on('click', function() {
            if ($(this).hasClass('selected')) {
                deselect($(this));
            } else {
                $(this).addClass('selected');
                $('.pop').slideFadeToggle();
            }
            return false;
        });

        $('.close').on('click', function() {
            deselect($('#contact'));
            return false;
        });
    });
    $.fn.slideFadeToggle = function(easing, callback) {
        return this.animate({opacity: 'toggle', height: 'toggle'}, 'fast', easing, callback);
    };
</script>

<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('admin/layout/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar">
            <a class="breadcrumb" href="<?php echo base_url('admin/gebruikers'); ?>">Admin Panel</a> &gt; <a class="breadcrumb" href="<?php echo base_url('admin/gebruikers'); ?>">Gebruikers</a> &gt; <span class="lastBreadcrumbs"><?php echo $value->name; ?></span>
        </div>
        <div class="grayColumn">
            <div class="titleBar"><?php echo $value->name; ?><a onclick="user_delete('<?php echo $users_id ?>')" style="float:right;color:white;padding-right:25px;cursor:pointer;" style="float:right;color:white;padding-right:20px;">X</a></div>
            <div class="contentBlock">
                <div class="user-detail">
                    <form  id="dropzone" action="<?php echo base_url('admin/gebruikers/uploader'); ?>?userid=<?php echo $dealer_id; ?>" class="dropzone img-block">
                        <div class="remove-logo icon-remove-sign">
                            <i class="fa fa-remove" onclick="removeLogo(<?php echo $dealer_id ?>)" ></i>
                        </div>
                        <?php
                        $filename = getcwd() . "/media/dealers/" . $dealer_id . "/logo_" . $dealer_id . ".jpg";
                        ?>
                        <?php if (file_exists($filename)) : ?>
                            <img  alt="placeholder" width="114"  src="<?= base_url() ?>media/dealers/<?php echo $dealer_id; ?>/logo_<?php echo $dealer_id; ?>.jpg">
                        <?php else: ?>                      
                            <img width="" height="" class="default-img" alt="placeholder" src="<?= base_url() ?>assets/images/placeholder.png">
                        <?php endif; ?>
                    </form> 
                    <div class="details-left">
                        <h2 class="title"><?php echo $value->name; ?></h2>
                        <p class="subtitle">
                            <?php echo $value->street; ?> <?php echo $value->house_num; ?> <?php echo $value->house_num_addition; ?><br>
                            <?php echo $value->postal_code; ?> <?php echo $value->city; ?>
                        </p>
                        <p><span class="detail-left">Tel: </span><span class="detail-right"><?php echo $value->dealer_phoneNumber1; ?></span></p>
                        <p><span class="detail-left">Email: </span><span class="detail-right"><a href="mailto:<?php echo $value->user_email; ?>"><?php echo $value->user_email; ?></a></span></p>
                    </div>
                    <div class="details-right">
                        <p><span class="detail-left">Imoby ID:</span><span class="detail-right"><?php echo $value->homePageId; ?></span></p>
                        <p><span class="detail-left">Contactpersoon: </span><span class="detail-right"><?php echo $value->firstName . ' ' . $value->middleName . ' ' . $value->lastName; ?></span></p>
                        <p><span class="detail-left">Tel: </span><span class="detail-right"><?php echo $value->user_phoneNumber2; ?></span></p>
                        <p><span class="detail-left">Email: </span><span class="detail-right"><a href="mailto:"><?php echo $value->dealer_email; ?></a></span></p>
                    </div>
                </div>
                <div class="relatie-tab ui-tabs ui-widget ui-widget-content ui-corner-all" id="tabs">

                    <?php
                    $functions = array();
                    if (isset($dealer_functions[0]->functions)) {
                        $functions = explode(",", $dealer_functions[0]->functions);
                    }
                    $active = "ui-tabs-active ui-state-active";
                    if ($functions == null) {
                        $producttab = $active;
                    } else {
                        $producttab = "";
                    }
                    $sourced = 1;
                    $source = $value->source;
                    $sourceId = $value->sourceId;

                    if (($functions != null) && ($source == '')) {
                        $kuppel = $active;
                    } else {
                        $kuppel = "";
                    }
                    ?>
                    <ul class="tabmenu ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                        <li class="ui-state-default ui-corner-top " role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="false" ><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Dossier</a></li>
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false"  ><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Kenmerken</a></li>
                        <li class="ui-state-default ui-corner-top <?php echo $producttab; ?>" role="tab" tabindex="-1" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false"><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Producten</a></li>
                        <li class="ui-state-default ui-corner-top <?php echo $kuppel; ?>" role="tab" tabindex="-1" aria-controls="tabs-4" aria-labelledby="ui-id-4" aria-selected="false"><a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">Koppelingen</a></li>
                    </ul>
                    <div class="tabcontainer ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-1" aria-labelledby="ui-id-1" role="tabpanel" aria-expanded="true" aria-hidden="false">     
                        <div class="tabcontent">                                
                            <div class="buttonholder" style="z-index:111;"><a style="z-index:29;" href="#" id="contact"  class=" button addRelatie"><img src="<?= base_url() ?>assets/images/add.png" class="add">Notitie maken</a></div>
                            <!-- <div class="buttonholder"><a href="#" class="button addRelatie"><img src="<?= base_url() ?>assets/images/add.png" class="add">Upload file</a></div>-->
                            <div class="buttonholder right"><a href="#" class="button addRelatie"><img src="<?= base_url() ?>assets/images/add2.png" class="add">Meekijken</a></div>

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

                                <tbody>
                                    <?php foreach ($notes as $note) { ?>
                                        <tr>
                                            <td><?php echo $note->note_date; ?></td>
                                            <td><?php echo $note->firstName; ?> <?php echo $note->middleName; ?> <?php echo $note->lastName; ?> </td>
                                            <td>Note</td>
                                            <td><a style="text-decoration:underline; cursor:pointer;"onclick="viewnote(<?php echo $note->note_id; ?>);" ><?php echo $note->note_title; ?></a></td>
                                            <td><img width="" onclick="delete_note('<?php echo $note->note_id; ?>','<?php echo $user->id; ?>','<?php echo $note->admin_id; ?>')" height="" alt="delete" src="<?= base_url() ?>assets/images/delete2.png"></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="page-nav">
                            <?php echo $pagination; ?>
                            <!--                            <ul>
                                                            <li>Pagina 1</li>
                                                            <li><a class="prev" href="#">Prev</a></li>
                                                            <li><a class="next" href="#">Next</a></li>
                                                        </ul>-->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="tabcontainer ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-2" aria-labelledby="ui-id-2" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">     
                        <div id="updateUserForm">
                            <div class="tabcontent">
                                <div class="company">
                                    <h2>Bedrijfsgegevens</h2>
                                    <div class="left-div">
                                        <fieldset>
                                            <p><span class="briefcase"></span><input type="text" placeholder="Bedrijfsnaam" name="name" value="<?php echo $value->name; ?>"></p>
                                            <p><span class="house addres"></span>
                                                <input class="street" type="text" placeholder="Straat" name="street" value="<?php echo $value->street; ?>">
                                                <input class="nr" type="text" maxlength="5" placeholder="Nr" name="house_num" value="<?php echo $value->house_num; ?>">
                                                <input class="toev" type="text" maxlength="5" placeholder="Toev" name="house_num_addition" value="<?php echo $value->house_num_addition; ?>">
                                            </p>
                                            <p><span class="house"></span><input type="text" placeholder="Postcode" name="postal_code" value="<?php echo $value->postal_code; ?>"></p>
                                            <p><span class="house"></span><input type="text" placeholder="Vestigingsplaats" name="city" value="<?php echo $value->city; ?>"></p>
                                            <p><span class="kvknr"></span><input type="text" placeholder="KvKnr" name="KvKnr" value="<?php echo $value->chamberOfCommerce; ?>"></p>
                                            <p><span class="btwnr"></span><input type="text" placeholder="BTWnr" name="BTWnr" value="<?php echo $value->Taxcode; ?>"></p>
                                        </fieldset>
                                    </div>
                                    <div class="right-div">
                                        <fieldset>
                                            <p><span class="phone"></span><input type="text" placeholder="Telefoonnummer" name="phoneNumber1" value="<?php echo $value->dealer_phoneNumber1; ?>"></p>
                                            <p><span class="phone"></span><input type="text" placeholder="Faxnummer" name="faxNumber" value="<?php echo $value->faxNumber; ?>"></p>
                                            <p><span class="mail"></span><input type="text" placeholder="E-mail adres" name="company_email" value="<?php echo $value->user_email; ?>"></p>
                                            <p><span class="web"></span><input type="text" placeholder="Website" name="Website" value="<?php echo $value->website; ?>"></p>
                                            <p><span class="btwnr"></span><input type="text" placeholder="Naam rekeninghouder" name="accountnumber" value="<?php echo $value->accountnumber; ?>"></p>
                                            <p><span class="btwnr"></span><input type="text" placeholder="IBBN" name="IBAN" value="<?php echo $value->iban; ?>"></p>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="contact">
                                    <h2>Contactpersoon</h2>
                                    <p>
                                        <label><input type="radio" <?php
                            $salutation = $value->salutation;
                            if ($salutation == 'De Heer') {
                                echo "checked='checked'";
                            }
                            ?> name="salutation" value="De Heer" checked="checked" id="deheer" class="blackText">
                                            De heer<input type="radio" <?php
                            $salutation = $value->salutation;
                            if ($salutation == 'Mevrouw') {
                                echo 'checked="checked"';
                            }
                            ?> name="salutation" value="Mevrouw" id="mevrouw" class="blackText">
                                            Mevrouw</label>
                                    </p>
                                    <div class="left-div">
                                        <fieldset>                                                
                                            <p><span class="person"></span><input type="text" placeholder="Voornaam" name="Voornaam" value="<?php echo $value->firstName; ?>"></p>
                                            <p><span class="person"></span><input type="text" placeholder="Tussenvoegsel" name="Tussenvoegsel" value="<?php echo $value->middleName; ?>"></p>
                                            <p><span class="person"></span><input type="text" placeholder="Achternaam" name="Achternaam" value="<?php echo $value->lastName; ?>"></p>                                                
                                        </fieldset>
                                    </div>
                                    <div class="right-div">
                                        <fieldset>
                                            <p><span class="phone"></span><input type="text" placeholder="Telefoonnummer" name="phoneNumber2" value="<?php echo $value->user_phoneNumber2; ?>"></p>
                                            <p><span class="mail"></span><input type="text" placeholder="E-mail adres" name="company_contact_email" value="<?php echo $value->dealer_email; ?>"></p>
                                            <p><span class="person"></span><input type="text" placeholder="Functie" name="function" value="<?php echo $value->function; ?>"></p>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="buttonholder right"><a href="javascript:void(0)" class="button addRelatie" onclick="updateUser();"><img src="<?= base_url() ?>assets/images/vinkje.png" class="add">Opslaan</a></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <?php
                    $functions = array();
                    if (isset($dealer_functions[0]->functions)) {
                        $functions = explode(",", $dealer_functions[0]->functions);
                    }
                    ?>
                    <div class="tabcontainer ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-3" aria-labelledby="ui-id-3" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">      
                        <div id="updateFunctionForm">
                            <div class="tabcontent">                                
                                <table class="products-table">
                                    <tbody>
                                            <?php $x = 1; foreach ($products as $product) { ?>
                                            <tr>
                                                <td><span class="iphone"></span><?php echo $product->description; ?></td>
                                                <td>
                                                    <label style=" display: unset;" >€ <?php echo $product->price; ?></label>
                                                    <span id="klant_actief" class="checkBoxSlider actief<?php echo $x; ?>">
                                                        <button onclick="service('<?php echo $x; ?>',1)" type="button" class="radioSliderTrue  actief<?php echo $x; ?> blackText <?= (in_array("$x", $functions)) ? 'radioSliderActive' : 'radioSliderInactive' ?>">aan</button>
                                                        <button onclick="service('<?php echo $x; ?>',0)" type="button" class="radioSliderFalse  actief<?php echo $x; ?> blackText <?= (!in_array("$x", $functions)) ? 'radioSliderActive' : 'radioSliderInactive' ?>">uit</button><br>
                                                        <input type="radio" id="actief<?php echo $x; ?>" name="actief<?php echo $x; ?>" class="radioSliderOn actief<?php echo $x; ?>" value="<?php if(in_array("$x", $functions)){ echo '1';}else{ echo '0';} ?>" checked="<?= (in_array("$x", $functions)) ? 'checked' : '' ?>">
                                                        
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php $x++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="buttonholder right"><a href="javascript:void(0)" class="button addRelatie" onclick="updateFunction();"><img src="<?= base_url() ?>assets/images/vinkje.png" class="add">Opslaan</a></div>
                            <div class="clearfix"></div>
                            <input id="dealer_id" type="hidden" value="<?php echo $value->dealer_id; ?>">
                        </div>
                    </div>
                    <div class="tabcontainer ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-4" aria-labelledby="ui-id-4" role="tabpanel" style="display: none;" aria-expanded="false" aria-hidden="true">
                        <div class="tabcontent" id="updateSourceForm">    
                            <table border="0" cellspacing="0" cellpadding="0" class="packages">
                                <tbody>
                                    <?php
                                    $source = $value->source;
                                    $sourceId = $value->sourceId;
                                    if ($source == 'vwe') {
                                        $vwe = "checked=''";
                                        $vwe_id = $sourceId;
                                    } else {
                                        $vwe = '';
                                        $vwe_id = ' ';
                                    }
                                    if ($source == 'vweh') {
                                        $vweh = "checked=''";
                                        $vweh_id = $sourceId;
                                    } else {
                                        $vweh = '';
                                        $vweh_id = ' ';
                                    }
                                    if ($source == 'hexon') {
                                        $hexon = "checked=''";
                                        $hexon_id = $sourceId;
                                    } else {
                                        $hexon = '';
                                        $hexon_id = ' ';
                                    }
                                    ?>
                                    <tr>
                                        <td class="packages"><strong>VWE</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input  type="radio" <?php echo $vwe; ?> name="source" value="vwe" class="blackText"> <strong class="lightblue">Advertentiemanager</strong></td>
                                        <td><input type="text" placeholder="VWE Dealer ID" name="vwe" value="<?php echo $vwe_id; ?>"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><input  type="radio" <?php echo $vweh; ?> name="source" value="vweh" class="blackText"> Hexon</td>
                                        <td><input type="text" placeholder="VWE Dealer ID" name="vweh" value="<?php echo $vweh_id; ?>"></td>
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
                                        <td><input   type="radio" <?php echo $hexon; ?> name="source" value="hexon" class="blackText">Doorlinken voorraad</td>
                                        <td><input readonly type="text" placeholder="Imoby ID" name="hexon" value="<?php echo $hexon_id; ?>"></td>
                                        <td><button>Genereer</button></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="buttonholder right"><a href="#" onclick="source()" class="button addRelatie"><img src="<?= base_url() ?>assets/images/vinkje.png" class="add">Opslaan</a></div>
                        <div class="clearfix"></div>
                    </div>
                </div>                                

            </div>
        </div>   
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        changeRadion('actiefr');
        changeRadion('actiefm');
        changeRadion('actiefi');
        changeRadion('actiefd');
    });

    function changeRadion(id) {
        var $onButton = $('.radioSliderTrue', '.' + id);
        var $offButton = $('.radioSliderFalse', '.' + id);

        var $onInput = $('.radioSliderOn', '.' + id);
        var $offInput = $('.radioSliderOff', '.' + id);
        if ($onButton.hasClass('radioSliderActive')) {
            $onInput.prop("checked", "checked");
            $onInput.trigger("change");
            $offInput.prop("checked", false);
        }
        else {
            $onInput.prop("checked", false);
            $offInput.prop("checked", "checked");
            $offInput.trigger("change");
        }

    }
    function source() {
        var url = "<?php echo base_url('admin/gebruikers/updatesource'); ?>/";
        url += $('#dealer_id').val();
        $.ajax({
            url: url,
            type: "post",
            data: $('#updateSourceForm :input').serialize(),
            success: function(e) {
                alert(e);
            },
            error: function(er) {
                //alert(er);
            }
        });

    }
    function updateUser() {

        $.ajax({
            url: "<?php echo base_url('admin/gebruikers/update') . '/' . $users_id . '/' . $dealer_id . '/' . $addresses_id; ?>",
            type: "post",
            data: $('#updateUserForm :input').serialize(),
            success: function(e) {
                var obj = JSON.parse(e);
                if (obj.success) {
                    //$('#dealer_id').val(obj.dealer_id);
                    alert('De wijzigingen zijn succesvol opgeslagen.');
                    window.location.assign("<?php echo base_url() ?>admin/gebruikers/details/<?php echo $users_id; ?>");
                } else {
                    alert(obj.message);
                }
            },
            error: function(er) {
                alert(er);
            }
        });
    }
    function updateFunction() {
        if ($('#dealer_id').val() == "") {
            alert('First Insert Dealer Info in Features Tab!');
            return;
        }
        var url = "<?php echo base_url('admin/gebruikers/updateFunction'); ?>/";
        url += $('#dealer_id').val();
        $.ajax({
            url: url,
            type: "post",
            data: $('#updateFunctionForm :input').serialize(),
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

    function removeLogo(dealer_id) {
        var url = "<?php echo base_url('admin/gebruikers/delete_profile_image'); ?>/";
        $.ajax({
            url: url,
            type: "post",
            data: {user_id: dealer_id},
            success: function(e) {
                alert(e);
                location.reload();

            }});
    }
    function service(id,value){
        $('#actief'+id).val(value);
    }
       

    function user_delete(id){
        alert(id);
        var con = confirm("Weet u zeker dat u deze gebruiker wilt verwijderen?");           
        if(con==true){
            $.ajax({
                url: "<?php echo base_url('admin/beheerders/delete_user/'); ?>",
                type: "post",
                data: { user_id:id },
                success: function(e) { 
                    alert(e);
                    url="<?php echo base_url('admin/gebruikers'); ?>";
                    location.assign(url);
                },
                error: function(er) {
                    alert(er);
                    url="<?php echo base_url('admin/gebruikers'); ?>";
                    location.assign(url);
                }
            });
            console.log('Delete in process');
        }
        else{
            alert('Thank You');
        } }

</script>

<?php $this->load->view('admin/layout/footer'); ?>