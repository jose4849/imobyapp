<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($informatie[0])){ echo $informatie[0]->name; } ?></title>
        <meta name="viewport" content="width=device-width"> 
        <meta name="apple-mobile-web-app-capable" content="yes" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>bb/images/favicon.png">
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/bengal-grid-v3.css" type="text/css" media="print, projection, screen" />
        <script type="text/javascript" src="<?= base_url() ?>assets/mobile/js/jquery.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/mobile/js/easytabs.js"></script>        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/style.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/kstyle.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/icofont/style.css" type="text/css" media="print, projection, screen" /> 
        <?php if ($colorschme == 'nocolor') { ?>
            <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/scheme/blue.css" type="text/css" media="print, projection, screen" />        
        <?php } else { ?>        
            <link rel="stylesheet" href="<?= base_url() ?>assets/colorscheme/<?php echo $colorschme; ?>.css" type="text/css" media="print, projection, screen" />
        <?php } ?>
        <script src="<?= base_url() ?>assets/mobile/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/mobile/js/jquery.validate.js"></script>
        <script src="<?= base_url() ?>assets/mobile/js/jquery.validate.min.js"></script>
        <script src="<?= base_url() ?>assets/mobile/js/bootstrap.min.js"></script>  
        <script>
            function goBack() {                  
                window.history.back()
            }
            
            
            $(document).ready(function(){
                fullscreen();  
            });          
            
            /*
             $(document).ready(function(){
             
                       $( "#form-one" ).click(function() {   
                           var jouwemail1 = $("#jouwemail1").val();
                           var jouwemail2 = $("#jouwemail1").val();
                           var jouwtel3 = $("#jouwemail1").val();
                
                           $.ajax({
                               url:"<?php echo base_url(); ?>mobile/emailsendhome",
                               data:{  
                                   from:jouwemail1,	
                                   to:jouwemail2,
                                   tel:jouwtel3					 
                               },
                               type:"POST",
                               datatype: 'json',
                               success:function(result){
                                   $(".success").html(result );
                               }       
                           });              
                       });         
                   });
                   /*
                   addEventListener('load', prettyPrint, false);
                   $(document).ready(function(){
                       $('pre').addClass('prettyprint linenums');
                   });*/
            /* email part  */
            $(document).ready(function(){

                $( "#one" ).click(function() { $('#one > i').toggleClass( "fa-angle-down fa-angle-up" ); });
                $( "#two" ).click(function() { $('#two > i').toggleClass( "fa-angle-down fa-angle-up" ); });
                $( "#three" ).click(function() { $('#three > i').toggleClass( "fa-angle-down fa-angle-up" ); });
                $( "#four" ).click(function() { $('#four > i').toggleClass( "fa-angle-down fa-angle-up" ); });
                $( "#five" ).click(function() { $('#five > i').toggleClass( "fa-angle-down fa-angle-up" ); });


                $( "#form-one" ).click(function() { 
                    
                    var name1  = $("#name1").val();
                    var email1 = $("#email1").val();
                    var tel1 = $("#tel1").val();
                    var dealer_id = $("#dealer_id1").val();
                    var body1 = $("#body1").val();
                    var subject1 = $("#subject1").val();
                    subject1="Maak een afspraak: "+subject1
                    $.ajax({
                        url:"<?php echo base_url(); ?>mobile/emailsendobject",
                        data:{ 
                            no:1,
                            from1:'from1',
                            email_name:name1,	
                            from:email1,
                            dealer_id:dealer_id,
                            subject:subject1,					 
                            body:body1					 
                        },
                        type:"POST",
                        datatype: 'json',
                        success:function(result){
                            $(".success1").html(result );
                            $(".success").html(result );
                        }       
                    });   
                });
                
                
                
                $( "#form-two" ).click(function() {
                    var name2  = $("#name2").val();
                    var email2 = $("#email2").val();
                    var tel2 = $("#tel2").val();
                    var dealer_id = $("#dealer_id2").val();
                    var body2 = $("#body2").val();
                    var subject2 = $("#subject2").val();
                    subject2="Meer informatie: "+subject2
                
                    $.ajax({
                        url:"<?php echo base_url(); ?>mobile/emailsendobject",
                        data:{ 
                            no:2,
                            from1:'from1',
                            email_name:name2,	
                            from:email2,
                            dealer_id:dealer_id,
                            subject:subject2,					 
                            body:body2					 
                        },
                        type:"POST",
                        datatype: 'json',
                        success:function(result){
                            $(".success2").html(result );
                        }       
                    });   
                });
                
                
                $( "#form-three" ).click(function() {
                    var name3  = $("#name3").val();
                    var email3 = $("#email3").val();
                    var tel3 = $("#tel3").val();
                    var dealer_id = $("#dealer_id3").val();
                    var body3 = $("#body3").val();
                    var subject3 = $("#subject3").val();
                    subject3="Proefrit aanvragen: "+subject3
                    $.ajax({
                        url:"<?php echo base_url(); ?>mobile/emailsendobject",
                        data:{ 
                            no:1,
                            from1:'from1',
                            email_name:name3,	
                            from:email3,
                            dealer_id:dealer_id,
                            subject:subject3,					 
                            body:body3					 
                        },
                        type:"POST",
                        datatype: 'json',
                        success:function(result){
                            $(".success3").html(result );
                        }       
                    });    
                });
                $( "#form-four" ).click(function() {
                    var name4  = $("#name4").val();
                    var email4 = $("#email4").val();
                    var tel4 = $("#tel4").val();
                    var dealer_id = $("#dealer_id4").val();
                    var body4 = $("#body4").val();
                    var subject4 = $("#subject4").val();
                    subject4="Financiering aanvragen: "+subject4
                    $.ajax({
                        url:"<?php echo base_url(); ?>mobile/emailsendobject",
                        data:{ 
                            no:1,
                            from1:'from1',
                            email_name:name4,	
                            from:email4,
                            dealer_id:dealer_id,
                            subject:subject4,					 
                            body:body4					 
                        },
                        type:"POST",
                        datatype: 'json',
                        success:function(result){
                            $(".success4").html(result );
                        }       
                    });    
                });
                $( "#form-five" ).click(function() {
                    var name5  = $("#name5").val();
                    var email5 = $("#email5").val();
                    var tel5 = $("#tel5").val();
                    var dealer_id = $("#dealer_id5").val();
                    var body5 = $("#body5").val();
                    var subject5 = $("#subject5").val();
                    subject5="Lease offerte aanvragen: "+subject5
                    $.ajax({
                        url:"<?php echo base_url(); ?>mobile/emailsendobject",
                        data:{ 
                            no:1,
                            from1:'from1',
                            email_name:name5,	
                            from:email5,
                            dealer_id:dealer_id,
                            subject:subject5,					 
                            body:body5					 
                        },
                        type:"POST",
                        datatype: 'json',
                        success:function(result){
                            $(".success5").html(result );
                        }       
                    });  
                });   
                
                $( "#form-six" ).click(function() {
                    var jouwemail6 = $("#jouwemailfrom6").val();
                    var jouwemail6 = $("#jouwemailto6").val();
                    var jouwtel6 = $("#jouwemailtel6").val();
                
                    $.ajax({
                        url:"<?php echo base_url(); ?>mobile/emailsendobject",
                        data:{
                            no:6,
                            from6:jouwemail6,	
                            to6:jouwemail6,
                            tel6:jouwtel6					 
                        },
                        type:"POST",
                        datatype: 'json',
                        success:function(result){
                            $(".success6").html(result );
                        }       
                    });   
                });                        
            });           
            
        </script> 
        <style>
            .tab-swipeable {
                width: 100%;
                position: absolute;
                right: 0px;
                top: 0px;
                border: 0px solid blue;

            }
            .prev,.next{    
                background: none repeat scroll 0 0 #00afd8;
                color: #fff;
                display: block;
                margin-top: 0.1em;
                padding: 0.7em 0;
                text-align: center;
            }
            .form-control{margin-bottom:10px;}
            .modal-content{border-radius:0px !important;}
            .list-group{box-shadow:none !important;}
            .list-group-item{border:0px solid red !important;}
            .panel{ box-shadow:none !important; }
        </style>
    </head>
    <body>
