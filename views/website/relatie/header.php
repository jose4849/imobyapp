<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="NL" />
        <title><?php echo SITETITLE; ?></title>
        <link href="<?php echo base_url() ?>assets/popup-website/bootstrap-combined.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/website_style.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/mobile/css/bootstrap-theme.min.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>assets/popup-website/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/popup-website/bootstrap.js"></script>
        <?php  if ($colorschme == 'nocolor') { ?>
            <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/scheme/blue.css" type="text/css" media="print, projection, screen" />        
        <?php } else { ?>        
            <link rel="stylesheet" href="<?= base_url() ?>assets/colorscheme/web_<?php echo $colorschme; ?>.css" type="text/css" media="print, projection, screen" />
        <?php }  ?>        <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
        <style type="text/css">
            .car-img { height: 123px; width: 153px; }
            .form-control{margin-bottom:10px;}
            .modal-content{border-radius:0px !important;}
            .list-group{box-shadow:none !important;}
            .list-group-item{border:0px solid red !important;}
            .panel{ box-shadow:none !important; }
            option:first { color: #999; }
            .home-nav{}
            .home-nav ul{ margin: 0px;}
            .home-nav ul li{ list-style: none; display: inline;}
            .home-nav ul li a{ min-width: 85px;text-align: center; padding: 8px; margin-right: 4px;  float: left;  font-weight: bold; background: #de2b24; color: #fff; border-radius: 6px 6px 0 0; -webkit-border-radius: 6px 6px 0 0; -moz-border-radius: 6px 6px 0 0;}
            .home-nav ul li a:hover{ text-decoration: none; background: #8c1b17;}
            .home-nav ul li a.nav-active{ text-decoration: none; background: #8c1b17;}
            p.mail_login{ float: right; min-height: 10px; overflow: hidden;}
            p.mail_login label{ display: inline; float: left; line-height: 35px;}
            p.mail_login label.Button-R{ margin-left: 20px; float: right; width: 110px;}
            p.mail_login label.Button-R input{ margin: 0px;}
        </style>      
    </head>
    <body>
        <?php
        $session_data = $this->session->userdata('logged_in');
        $dealer_id = ($session_data['klant_info']->klant_dealerId);
        ?>
        <div id="header">
            <h1 class="logo">
                <img id="topMenuLogo" title="Imoby.nl" alt="Imoby.nl" style="width: 100px;" src="<?php echo base_url() ?>media/dealers/<?php echo $dealer_id; ?>/logo_<?php echo $dealer_id; ?>.jpg" /></h1> 
            <div id="header-right">
                <div id="web-overview">
                    <p class="mail_login">
                        <label class="">
                            <?php echo ($session_data['klant_info']->klant_email); ?>
                        </label>
                        <label class="Button-R"><a href="<?php echo base_url('relatie/logout'); ?>" > <input id="login" type="submit" class="" name="logout" value="Uitloggen" /></a></label>
                    </p>
                </div>
            </div>
            <div class="clr"></div>
            <div class="home-nav">
                <?php echo $menu; ?>
            </div>
        </div>   