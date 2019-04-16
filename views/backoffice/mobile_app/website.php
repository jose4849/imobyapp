<?php $this->load->view('backoffice/layouts/header'); ?>
<script src="<?php echo base_url(); ?>assets/js/dropzone.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/popup.css') ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/tabulous.css') ?>" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('assets/ckeditor/js/ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo base_url('assets/ckeditor/sample.js') ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/ckeditor/sample.css') ?>" rel="stylesheet" type="text/css" />
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/mobile_app/layouts/leftMenu'); ?> </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar"><a href="<?php echo base_url('backoffice/webmobiel/homepagina'); ?>" class="breadcrumb">Web en Mobiel</a> > <span class="lastBreadcrumbs">Website</span></div>
        <div class="grayColumn">
            <div class="titleBar">Website beheren</div>
            <div class="text-block">
                <p>Beheer de tabbladen van uw desktop. U kunt de tabbladen 'Home', 'Aanbod' en 'Contact' aanpassen maar niet verwijderen. Voeg generieke tabbladen toe door op '+' te klikken. Deze tabbladen kunt u naar wens aanpassen en eenvoudig verwijderen.</p>
            </div>          
            <div class="tab-Column">
                <div id="tabs2">
                    <ul class="top-bar-tab">
                        <li><a href="#tabs-1" title="">Home</a></li>
                        <li><a href="#tabs-2" title="">Aanbod</a></li>
                        <?php foreach ($pages as $page) { ?>
                            <li><a href="#<?php echo $page; ?>" title=""><?php
                                    $page_title = $page;
                                    echo strtolower(str_replace('_', ' ', $page_title));
                                    ?></a></li>
                        <?php } ?>
                        <li><a href="#tabs-3" title="">Contact</a></li>
                        <li class="last-child"><a title="" href="#newpage" class="">+</a></li>
                    </ul>
                    <div id="tabs_container">
                        <div id="tabs-1" class="tab-con">                            
                            <p class="Img-titel"><label>Titel :</label>
                                <input type="text" id="titlehome" value="<?php echo $home->page_title; ?>" />                                
                                <input type="hidden" id="pagestatus_home" value="1" />
                            </p>
                            <!-- <li class="afbeelding_header">
                                 <p class="left-div"><span>Afbeelding Header:</span> <span id="bladeren">Bladeren</span> Let op: Bestand moet Minimall 1366 pixels breed zijn(.jpeg,.png )</p>
                                 <p class="right-div" id="dz-preview-template">
                            <?php
                            $users_id = $user->id;
                            $filename = getcwd() . "/media/dealers/" . $dealer_id . "/home_" . $dealer_id . ".png";
                            $exist = file_exists($filename);
                            if ($exist == 1) {
                                ?>
                                                                                             <img height="136" width="396" id="defaultimg" src="<?= base_url() ?>media/dealers/<?php echo $dealer_id; ?>/home_<?php echo $dealer_id; ?>.png" />
                            <?php } else { ?>  
                                                                                             <img height="136" width="396" id="defaultimg" src="<?= base_url() ?>assets/photo.png" />
                            <?php } ?>
                                 </p>
                             </li>-->
                            <p class="">
                                <span class="bokst">Bodytekst :</span>
                                <br><br>
<!--                                    <textarea   class="contenthome" placeholder="Lorem Lorem Lorem">
                                <?php echo $home->page_content; ?>
                                </textarea>-->

                                <!-----------texteditor---------------------------->
                                <textarea cols="150" id="editor_home" name="editor_home" rows="150">
                                    <?php echo $home->page_content; ?>
                                </textarea>
                                <script type="text/javascript">
                                    $(document).ready(function () {

                                        CKEDITOR.replace('editor_home', {
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


                                    });
                                </script>
                                <!-----------texteditor---------------------------->
                            </p>


                            <p class="savebutton">
                                <span class="buttonclass2">
                                    <img src="<?= base_url() ?>assets/crmAssets/images/vinkje.png" />
                                    <input onclick="updatepage('home', '<?php echo $home->page_id; ?>')" class="button" type="button" value="Opslaan" />
                                </span>
                            </p>

                        </div>

                        <div id="tabs-2">
                            <span>Pagina actief:
                                <?php
                                $status = $annbod->page_status;
                                if ($status == 1) {
                                    $class1 = "radioSliderTrue  blackText radioSliderActive";
                                    $class2 = "radioSliderFalse  blackText radioSliderInactive";
                                } else {
                                    $class1 = "radioSliderTrue radioSliderInactive";
                                    $class2 = "radioSliderFalse radioSliderActive";
                                }
                                ?>
                            </span>
                            <span class="checkBoxSlider actief" id="klant_actief">
                                <button id="annbod0"   onclick="pagestatus(1, 'annbod', '<?php echo $home->dealer_id; ?>')" class="<?php echo $class1; ?>" type="button">aan</button>
                                <button id="annbod1"   onclick="pagestatus(0, 'annbod', '<?php echo $home->dealer_id; ?>')" class="<?php echo $class2; ?>" type="button">uit</button><br>
                                <input type="hidden" id="pagestatus_annbod" value="<?php echo $status; ?>" />
                            </span>
                        </div>

                        <div id="tabs-3">
                            <span>Pagina actief:
                                <?php
                                $status = $contact->page_status;
                                if ($status == 1) {
                                    $class1 = "radioSliderTrue  blackText radioSliderActive";
                                    $class2 = "radioSliderFalse  blackText radioSliderInactive";
                                } else {
                                    $class1 = "radioSliderTrue radioSliderInactive";
                                    $class2 = "radioSliderFalse radioSliderActive";
                                }
                                ?>                            

                            </span>
                            <span class="checkBoxSlider actief" id="klant_actief"> 
                                <button id="contact0"   onclick="pagestatus(1, 'contact', '<?php echo $home->dealer_id; ?>')" class="<?php echo $class1; ?>" type="button" >aan</button>
                                <button id="contact1"   onclick="pagestatus(0, 'contact', '<?php echo $home->dealer_id; ?>')" class="<?php echo $class2; ?>" type="button" >uit</button><br>
                                <input type="hidden" id="pagestatus_contact" value="<?php echo $status; ?>" />
                            </span>
                        </div>

                        <div id="tabs-4">                            
                            <p> 
                                <span>Pagina actief:</span> 
                                <span class="checkBoxSlider actief" id="klant_actief">                                        <button class="radioSliderTrue  blackText radioSliderActive" type="button" onclick="mobileAppStatus(1)">aan</button>                                        <button class="radioSliderFalse  blackText radioSliderInactive" type="button" onclick="mobileAppStatus(0)">uit</button><br>                                        <input type="radio" checked="" value="1" class="radioSliderOn actief" name="actief">                                        <input type="radio" value="0" class="radioSliderOff actief" name="actief">                                    </span> </p>
                            <p class="Img-titel"><span>Titel :</span>
                                <input type="text" />
                            </p>
                            <p class="bodytekst"> <span>Bodytekst :<br><br></span>
                                <textarea class="" placeholder="Lorem Lorem Lorem"></textarea>
                            </p>
                            <p class="savebutton">
                                <span class="buttonclass2">
                                    <a onclick="save('page_name')" href="#"  class="button">
                                        <img src="<?= base_url() ?>assets/crmAssets/images/vinkje.png" />
                                        Opslaan
                                    </a>
                                </span>
                            </p>

                        </div>
                        <!-- dynamic page Tabs Start-->
                        <?php foreach ($pages as $page) { ?>

                            <div id="<?php echo $page; ?>">



                                <?php
                                $page_title = $page;
                                strtolower(str_replace('_', ' ', $page_title));
                                ?>                                 
                                <p class="Img-titel"><label>Url :</label>
                                    <input type="text" id="titlehome" value="<?php echo $home->page_title; ?>" />                                
                                    <input type="hidden" id="pagestatus_home" value="1" />
                                </p>
                                <p class="switchbutton Img-titel">
                                    <?php
                                    $pageresult = $info[$page];
                                    $status = $pageresult->page_status;
                                    $first = '';
                                    $second = '';
                                    if ($status == 1) {
                                        $first = 'radioSliderTrue radioSliderActive';
                                        $second = 'radioSliderFalse  radioSliderInactive';
                                    } else {
                                        $first = 'radioSliderTrue radioSliderInactive';
                                        $second = 'radioSliderFalse radioSliderActive';
                                    }
                                    ?>
                                    <span>Pagina actief:</span>
                                    <span class="checkBoxSlider actief" id="klant_actief">
                                        <button id="<?php echo $pageresult->page_slug; ?>0" onclick="pagestatus(1, '<?php echo $pageresult->page_slug; ?>')"  class="<?php echo $first; ?>" type="button" onclick="pagestatus(1)" >aan</button>
                                        <button id="<?php echo $pageresult->page_slug; ?>1" onclick="pagestatus(0, '<?php echo $pageresult->page_slug; ?>')"  class="<?php echo $second; ?>" type="button" onclick="pagestatus(0)" >uit</button><br>
                                        <input type="hidden" id="pagestatus_<?php echo $pageresult->page_slug; ?>" value="1" />
                                    </span>
                                </p>
                                <p class="Img-titel"><label>Titel :</label>
                                    <input type="text" id="title<?php echo $page; ?>"  value="<?php echo $pageresult->page_title; ?>"  />
                                </p>
                                <p class="">
                                    <span>Bodytekst :</span>
                                    <br><br>
                                    <!-----------texteditor---------------------------->
                                    <textarea cols="150" id="editor_<?php echo $page; ?>" name="editor_<?php echo $page; ?>" rows="150">
                                        <?php echo $pageresult->page_content; ?>
                                    </textarea>
                                    <script type="text/javascript">
                                        $(document).ready(function () {

                                            CKEDITOR.replace('editor_<?php echo $page; ?>', {
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

                                        });
                                    </script>
                                    <!-----------texteditor---------------------------->




                                                    <!--                                            <textarea id="<?php echo $page; ?>" class="content<?php echo $page; ?>"  name="area"><?php echo $pageresult->page_content; ?></textarea>-->

                                </p>
                                <p class="savebutton">
                                    <span class="buttonclass2">
                                        <a onclick="updatepage('<?php echo $page; ?>', '<?php echo $pageresult->page_id; ?>')" class="button right">
                                            <img src="<?= base_url() ?>assets/crmAssets/images/vinkje.png" />
                                            Opslaan
                                        </a>
                                    </span>
                                    <a onclick="removepage('<?php echo $pageresult->page_id; ?>')" class="remove-button">
                                        Verwijderen
                                    </a>
                                </p>

                            </div>
                        <?php } ?>
                        <!-- dynamic page End -->                        

                        <div id="newpage">


                            <p class="Img-titel"><span>Titel :</span>
                                <input id="newpagetitle" type="text" />
                            </p>
                            <p class="switchbutton" style="display: none;">
                                <span>Pagina actief:</span>
                                <span class="checkBoxSlider actief" id="klant_actief">
                                    <button id="create0" class="radioSliderTrue radioSliderActive" type="button" onclick="pagestatus(1, 'create')" >aan</button>
                                    <button id="create1" class="radioSliderFalse radioSliderInactive" type="button" onclick="pagestatus(0, 'create')" >uit</button><br>
                                    <input type="hidden" id="pagestatus_create" value="1" />
                                </span>
                            </p>
                            <p> <span class="bokst">Bodytekst</span><br><br>
                                <!-----------texteditor---------------------------->
                                <textarea cols="150" id="editor1" name="editor1" rows="50">
			
                                </textarea>
                                <script type="text/javascript">
                                    $(document).ready(function () {


                                        CKEDITOR.replace('editor1', {
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


                                    });
                                </script>
                                <!-----------texteditor---------------------------->

                            </p>
                            <p class="savebutton">
                                <span class="buttonclass2">
                                    <a onclick="newpage()" class="button">
                                        <img src="<?= base_url() ?>assets/crmAssets/images/vinkje.png" />
                                        Opslaan
                                    </a>
                                </span>
                            </p>

                        </div>
                        <!--End tabs container-->
                    </div>
                </div>
                <!--End tabs-->
            </div>
        </div>
    </div>

</div>
<script type="text/javascript" src="<?php echo base_url('assets/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.popup.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/tabulous.js') ?>"></script>
<script>

                                        $('#tabs2').tabulous({
                                            effect: 'slideLeft'
                                        });

                                        function save(page) {
                                            $('#newpagetitle').val();
                                        }

                                        function newpage() {

                                            var newpagetitle = $('#newpagetitle').val();
                                            var elm1 = CKEDITOR.instances['editor1'].getData()
                                            var pagestatus = $('#pagestatus_create').val();
                                            $.ajax({
                                                type: 'POST',
                                                url: "<?php echo base_url(); ?>backoffice/webmobiel/newpage?userid=<?php echo $dealer_id; ?>",
                                                            data: {newpagetitle: newpagetitle, page_content: elm1, pagestatus: pagestatus},
                                                            success: function (msg) {
                                                                alert(msg);
                                                                location.reload();
                                                            }
                                                        });
                                                    }

                                                    function updatepage(page_slug, page_id) {

                                                        var pagestatus = $('#pagestatus_' + page_slug).val();
                                                        // var page_content = $('.editor'+page_slug).val();
                                                        var page_content = CKEDITOR.instances['editor_' + page_slug].getData()
                                                        // var page_content = $('.content'+page_slug).val();
                                                        var page_title = $('#title' + page_slug).val();

                                                        console.log(pagestatus);
                                                        console.log(page_title);
                                                        console.log(page_content);
                                                        console.log(page_id);

                                                        $.ajax({
                                                            type: 'POST',
                                                            url: "<?php echo base_url(); ?>backoffice/webmobiel/updatepage",
                                                            data: {userid: '<?php echo $users_id = $user->id; ?>', page_id: page_id, page_slug: page_slug, pagestatus: pagestatus, page_title: page_title, page_content: page_content},
                                                            success: function (msg) {
                                                                alert(msg);
                                                                location.reload();
                                                            }
                                                        });





                                                    }

                                                    function removepage(page_id) {
                                                        var confarmation = confirm("Are you sure to delete this page. !");
                                                        if (confarmation == 1) {
                                                            $.ajax({
                                                                type: 'POST',
                                                                url: "<?php echo base_url(); ?>backoffice/webmobiel/pagedelete?pageid=" + page_id + "",
                                                                data: {},
                                                                success: function (msg) {
                                                                    alert(msg);
                                                                    location.reload();
                                                                }
                                                            });
                                                        }
                                                        else {
                                                            alert("Thank you.");
                                                        }
                                                    }

                                                    function createpagestatus(status) {
                                                        var pagestatus = $('#pagestatus').val(status);

                                                    }

                                                    function pagestatus(x, butto, id) {

                                                        var pagestatus = $('#pagestatus_' + butto).val();

                                                        if (x == 0) {

                                                            //alert('Inactive');
                                                            $("#" + butto + "0").removeClass();
                                                            $("#" + butto + "0").addClass("radioSliderTrue radioSliderInactive");
                                                            $("#" + butto + "1").removeClass();
                                                            $("#" + butto + "1").addClass("radioSliderFalse radioSliderActive");
                                                            $('#pagestatus_' + butto).val(0);

                                                        }
                                                        if (x == 1) {

                                                            //alert('Active');
                                                            $("#" + butto + "0").removeClass();
                                                            $("#" + butto + "0").addClass("radioSliderTrue radioSliderActive");
                                                            $("#" + butto + "1").removeClass();
                                                            $("#" + butto + "1").addClass("radioSliderFalse radioSliderInactive");
                                                            $('#pagestatus_' + butto).val(1);
                                                        }



                                                        if (butto == 'annbod') {
                                                            // alert('annbod');

                                                            $.ajax({
                                                                type: 'POST',
                                                                url: "<?php echo base_url(); ?>backoffice/webmobiel/pagestatuschange",
                                                                data: {page_status: x, page_slug: butto, dealer_id: id},
                                                                success: function (msg) {
                                                                    alert(msg);
                                                                    location.reload();
                                                                }
                                                            });


                                                        }
                                                        if (butto == 'contact') {

                                                            /* ajax   */
                                                            $.ajax({
                                                                type: 'POST',
                                                                url: "<?php echo base_url(); ?>backoffice/webmobiel/pagestatuschange",
                                                                data: {page_status: x, page_slug: butto, dealer_id: id},
                                                                success: function (msg) {
                                                                    alert(msg);
                                                                    location.reload();
                                                                }
                                                            });
                                                            /* ajax   */

                                                        }

                                                    }

                                                    /* for photo upload dropzone start */
<?php $users_id = $user->id; ?>
                                                    new Dropzone(document.body, {// Make the whole body a dropzone
                                                        url: "<?php echo base_url(); ?>backoffice/webmobiel/bannerupload?userid=<?php echo $users_id = $user->id; ?>&dealerid=<?php echo $dealer_id; ?>", // Set the url
                                                                previewsContainer: "#dz-preview-template", // Define the container to display the previews
                                                                clickable: "#bladeren", // Define the element that should be used as click trigger to select files.
                                                                parallelUploads: 1,
                                                                thumbnailWidth: 400,
                                                                thumbnailHeight: 150,
                                                                success: function (response) {
                                                                    $('#defaultimg').css("display", "none");
                                                                }
                                                            });

                                                            /* for photo upload dropzone start */

</script>
<style type="text/css">
    .cke_toolbox_collapser {
        display: none !important;
    }
    #cke_top_editor1{ background: none repeat scroll 0 0 transparent !important; }
    .cke_button a{
        background: none repeat scroll 0 0 transparent !important;
        padding: 4px  !important;

    }
    .cke_styles a{
        background: none repeat scroll 0 0 white !important;
        padding: 4px  !important;
    }
    .cke_path a{
        background: none repeat scroll 0 0 white !important;
        padding: 4px  !important;
    }
    .cke_disabled a{
        background: none repeat scroll 0 0 white !important;
        padding: 4px  !important;
    }
    .cke_off a{
        background: none repeat scroll 0 0 white !important;
        padding: 4px  !important;
    }
    .cke_toolbox_collapser{
        background: none repeat scroll 0 0 transparent !important;
        padding: 4px  !important;
    }
    .titleBar {
        margin-bottom: 0;
    }

    .text-block {
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        padding: 20px;
        background: #fff;
    }

    #tabs_container {
        background: none;
    }
    .tab-Column {
        background: #f4f4f4;
        min-height: 400px;
        overflow: hidden;
    }

    .tab-Column #tabs_container {
        background: none;
        padding: 23px;
    }

    .tab-Column #tabs_container ul {
        padding: 0px;
    }

    .tab-Column ul.top-bar-tab {
        background: #00afd8;
        width: 97% !important;
        margin: 0px;
        padding-left: 26px !important;
    }

    .tab-Column ul.top-bar-tab li {}

    .tab-Column ul.top-bar-tab li a {
        background: none !important;
        color: #fff !important;
        font-weight: bold;
    }

    .tab-Column ul.top-bar-tab li a.tabulous_active {
        background: #f4f4f4 !important;
        color: #00afd8 !important;
    }

    .tab-Column ul.top-bar-tab li a:hover {
        background: #f4f4f4 !important;
        color: #00afd8 !important;
    }

    .tab-con {
        position: relative !important;
        top: 0px !important;
        min-height: 100px;
        overflow: hidden;
        width: 100%;
    }
    .Img-titel label{
        width: 80px; float: left; line-height: 34px;
    }

    .Img-titel input {
        height: 30px;
        width: 300px;
        line-height: 30px;
        margin-left: 10px;
        padding-left: 10px;
        border: 1px solid #e1e1e1;
    }

    .Img-titel span {

    }

    span.bokst{
        line-height: 38px;
    }

    .afbeelding_header {
        border-bottom: 1px solid #e1e1e1;
        float: left;
        width: 100%;
        padding: 20px 0;
        min-height: 10px;
        overflow: hidden;
    }

    .bodytekst {
        float: left;
        width: 100%;
        padding: 20px 0;
    }

    .bodytekst span {
        float: left;
        width: 100%;

        font-weight: bold;
        display: block;
        /* 
        padding-bottom: 20px; 
         line-height: 30px;
        */
    }

    .bodytekst textarea {
        width: 97%;
        border: 1px solid #e1e1e1;
        height: 150px;
        resize: none;
        color: #e1e1e1;
        padding: 10px;
    }

    .left-div {
        width: 50%;
        float: left;
    }

    p.left-div {
        color: #bcbcbc;
        line-height: 38px;
    }

    p.left-div span {
        color: #000;
        font-size: 12px;
        float: left;
        margin-right: 8px;
    }

    p.left-div span#bladeren {
        padding: 0px;
        margin-right: 8px;
        height: 38px;
        width: 101px;
        float: left;
        line-height: 38px;
        color: #fff;
        background: #00afd8;
        text-align: center;
        cursor: pointer;
    }

    .right-div {
        width: 50%;
        float: right;
    }

    .opslaan {
        float: right;
        position: relative;
        line-height: 38px !important;
        padding: 0 31px !important;
        text-align: center;
        cursor:pointer;
        color: #fff !important;
        background: url("<?php base_url() ?>assets/crmAssets/images/button.png") repeat-y #00AFD8 !important;
    }

    .opslaan img {
        position: absolute;
        left: 7%;
        top: 24%;
    }u   

    #defaultimg{ width:100%; }

    /* additional css end */

    .btnobjectdel {
        cursor: pointer;
    }

    .popup {}

    .popup .popup_content {}

    .popup .popup_content h3 {
        background: #195d82;
        color: #ffffff;
        font-weight: bolder;
        margin: 0px;
        padding: 10px;
        display: block;
    }

    .popup .popup_content .popup-div {
        background: #f4f4f4;
        border: 1px solid #e9e9e9;
        border-top: none;
        padding: 10px;
    }

    .popup .popup_content .popup-div p {
        margin: 0;
    }

    .hideleft.make_transist.showleft{
        width: 95%;
    }
</style>
<?php $this->load->view('backoffice/layouts/footer'); ?>