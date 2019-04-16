<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="NL" />
        <title>Imoby</title>
        <link href="<?= base_url() ?>assets/popup-website/bootstrap-combined.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/website_style.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/css/font-awesome.min.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/css/bootstrap-theme.min.css">
        <script type="text/javascript" src="<?= base_url() ?>assets/popup-website/jquery.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/popup-website/bootstrap.js"></script>
        <?php  if ($colorschme == 'nocolor') { ?>
            <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/scheme/blue.css" type="text/css" media="print, projection, screen" />        
        <?php } else { ?>        
            <link rel="stylesheet" href="<?= base_url() ?>assets/colorscheme/web_<?php echo $colorschme; ?>.css" type="text/css" media="print, projection, screen" />
        <?php }  ?>
        <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
        <style>
            .car-img {
                height: 123px;
                width: 153px;
            }
            .form-control{margin-bottom:10px;}
            .modal-content{border-radius:0px !important;}
            .list-group{box-shadow:none !important;}
            .list-group-item{border:0px solid red !important;}
            .panel{ box-shadow:none !important; }
            option:first {
                color: #999;
            }
            
            .home-nav{}
            .home-nav ul{ margin: 0px;}
            .home-nav ul li{ list-style: none; display: inline;}
            .home-nav ul li a{ min-width: 85px;text-align: center; padding: 8px; margin-right: 4px;  float: left;  font-weight: bold; background: #de2b24; color: #fff; border-radius: 6px 6px 0 0; -webkit-border-radius: 6px 6px 0 0; -moz-border-radius: 6px 6px 0 0;}
            .home-nav ul li a:hover{ text-decoration: none; background: #8c1b17;}
             .home-nav ul li a.nav-active{ text-decoration: none; background: #8c1b17;}
        </style>      
    </head>
    <body>