<!DOCTYPE html>
<html>
    <head>
        <title><?php if(isset($informatie[0])){ echo $informatie[0]->name; } ?></title>
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>bb/images/favicon.png">
        <meta name="viewport" content="width=device-width">
        <meta name="apple-mobile-web-app-capable" content="yes" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--<link rel="stylesheet" href="https://bengal-grid.googlecode.com/git/bengal-grid-v2.css" type="text/css" media="print, projection, screen" />-->
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/bengal-grid-v3.css" type="text/css" media="print, projection, screen" />
        
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/style.css" type="text/css" media="print, projection, screen" />
		<link rel="stylesheet" href="<?= base_url() ?>assets/mobile/kstyle.css" type="text/css" media="print, projection, screen" />
		<link rel="stylesheet" href="<?= base_url() ?>assets/mobile/icofont/style.css" type="text/css" media="print, projection, screen" /> 
        <?php if($colorschme=='nocolor'){?>
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/scheme/blue.css" type="text/css" media="print, projection, screen" />        
        <?php } else { ?>        
        <link rel="stylesheet" href="<?= base_url() ?>assets/colorscheme/<?php echo $colorschme; ?>.css" type="text/css" media="print, projection, screen" />
        <?php } ?>
        <script type="text/javascript" charset="utf-8">           
            function goBack() {                  
                window.history.back()
            }
                        function fullscreen() {
                $('a').click(function() {
                    if(!$(this).hasClass('noeffect')) {
                        window.location = $(this).attr('href');
                        return false;
                    }
                });
            }
 

            
            
            function goBack() {                  
                window.history.back()
            }
            
            
            $(document).ready(function(){
                fullscreen();  
            }          
            
        </script>		
       
    </head>
    <body>