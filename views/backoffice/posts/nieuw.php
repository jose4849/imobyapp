<?php $this->load->view('backoffice/layouts/header'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/ckeditor/js/ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo base_url('assets/ckeditor/sample.js') ?>" type="text/javascript"></script>
<link href="<?php echo base_url('assets/ckeditor/sample.css') ?>" rel="stylesheet" type="text/css" />
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/posts/layouts/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar"><a href="/crm/relaties" class="breadcrumb">Berichten</a> > <span class="lastBreadcrumbs">Postvak IN</span></div>
        <div class="grayColumn">
            <div class="titleBar3">Nieuw bericht</div>           
            <div class="contentBlock1">
                <div style="text-align:center;" id="loading"></div>
                <strong style="line-height:30px;" >Aan</strong>
                <span style="float:right;cursor:pointer;"><a onclick='hideshow("cc")'>CC</a> <a onclick='hideshow("bcc")' >BCC</a></span>
                <input id="reciver" width="100%" type="text" style="width: 100%; height: 32px; border: 0px solid gray;">	
                <span style="float:right;cursor:pointer;"><a onclick='hideshow("cc")'>CC</a> <a onclick='hideshow("bcc")' >BCC</a></span><br>
                <strong class='cc' style="line-height:30px;display:none;" >CC</strong>
                <input class='cc' id="cc" width="100%" type="text" style="display:none;width: 100%; height: 32px; border: 0px solid gray;">	

                <strong class='bcc' style="line-height:30px;display:none;" >BCC</strong>
                <input class='bcc' id="bcc" width="100%" type="text" style="width: 100%;display:none; height: 32px; border: 0px solid gray;">	


                <strong style="line-height:30px;" >Onderwerp</strong>
                <input id="subject" width="100%" type="text" style="width: 100%; height: 32px; border: 0px solid gray;">	
                <br><br><br><br>
                <strong style="line-height:30px; margin-top:20px;" >
                    <textarea id="message" style="width: 97%; height: 232px;margin-top:20px; border: 0px solid gray;" >Luram ipsam</textarea>
                </strong>
                <br>
                <div  id="submit" class="buttonholder right">
                    <a class="button addRelatie" href="#">
                        <img  class="add" src="<?php echo base_url() ?>assets/crmAssets/images/vinkje.png">Verzenden
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>
<script> 	
    $(document).ready(function () {
        $("#submit").one('click', function (event) {  
            var reciver =  $('#reciver').val();
            var subject = $('#subject').val();
            var message = $('#message').val();
            $('#loading').html('<img src="<?php echo base_url(); ?>/assets/ajax-loader.gif">');
            $.ajax({
                type: 'POST',                   
                url: "<?php echo base_url(); ?>backoffice/berichten/emailsend?dealer=<?php echo $dealer_id; ?>",
                data: {reciver:reciver, subject: subject , message:message },
                success: function(msg) { 
                    alert("Email send successfully. Thank you.");
                    location.reload();
                }
            });

        
        });
    });
    function hideshow(ele){
        $("."+ele).toggle();
    }

    CKEDITOR.replace( 'message', {  
     //   filebrowserBrowseUrl: '<?php echo base_url(); ?>assets/ckeditor/browse.php?type=Images&dealer_id=<?php echo $dealer_id; ?>&base=<?php echo base_url(); ?>&dir=' + encodeURIComponent("media/dealers/<?php echo $dealer_id; ?>/"),  
      //  filebrowserUploadUrl: '<?php echo base_url(); ?>assets/ckeditor/upload.php?type=Files&dealer_id=<?php echo $dealer_id; ?>&base=<?php echo base_url(); ?>&dir=' + encodeURIComponent('media/dealers/<?php echo $dealer_id; ?>/'),
        toolbar: [
            { name: 'document', 
                items: [  '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
            ['Cut', 'Copy', 'Paste', 'PasteText',
                'PasteFromWord', '-', 'Undo', 'Redo','TextField',
                'Textarea', 'Select', 'Button',
                'Bold', 'Italic', 'Underline', 
                'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
                'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter',
                'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ,
                'Styles', 'Format', 'Font', 'FontSize' 
            ],
        ]                        
    });
</script>
<?php $this->load->view('backoffice/layouts/footer'); ?>
