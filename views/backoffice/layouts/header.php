<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
            <meta http-equiv="Content-Language" content="NL" />
            <title><?= $pagetitle; ?> | Imoby.nl</title>
			<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>bb/images/favicon.png">
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.dataTables.css" type="text/css" media="print, projection, screen" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/crm.css" type="text/css" media="print, projection, screen" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/klanten.css" type="text/css" media="print, projection, screen" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" type="text/css" media="print, projection, screen" />
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/usercss.css" type="text/css" media="print, projection, screen" />            
            <link rel="stylesheet" href="<?= base_url() ?>assets/css/new-style.css" type="text/css" media="print, projection, screen" />            
            <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/css/font-awesome.min.css" type="text/css" media="print, projection, screen" />  
            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-1.10.2.js"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-1.10.3.js"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-ui-timepicker.js"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.ui.datepicker-nl.js"></script>
    </head>
    <body>
        <div id="header">
            <div id="headerWrapper">
                <div id="headerMenu">
                    <ul>
                        <li >
                            <a href="<?php echo base_url('backoffice/instellingen/profiel'); ?>"><img class="username" src="<?= base_url() ?>assets/images/menuUsername.png" />imoby.nl/<?php if(isset($dealer[0])){ echo $dealer[0]->homePageId; } ?></a>
                        </li>
                        <li>
                            <a href="<?= site_url('logout'); ?>"><img class="uitloggen" src="<?= base_url() ?>assets/images/menuUitloggen.png" />Uitloggen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="bottomHeader">
            <div id="bottomHeaderWrapper">
                <h1 class="top-menu-logo"><a href="<?php echo base_url('backoffice'); ?>"><img src="<?= base_url() ?>assets/images/logo.png" alt="Imoby.nl - Backoffice" title="Imoby.nl - Backoffice" id="topMenuLogo"/></a></h1>
                <div id="bottomHeaderMenu">
                    <?php
                    $fns = array();
                    if (isset($dealer_functions[0]->functions)) {
                        $fns = explode(',', $dealer_functions[0]->functions);
                    }
                    ?>
                    <ul>
                        <li><a class="<?php
                            if ($activeTabHeader == "dashboard") {
                                echo 'bottomHeaderMenu';
                            }
                            ?>" href="<?= base_url() ?>backoffice/dashboard" class="bottomHeaderMenu">Dashboard</a></li>
                            <?php
                            if (in_array("1", $fns))
                            { 
                                $mobiel=base_url('backoffice/webmobiel/homepagina');
                            }
                            else{
                               $mobiel=base_url('backoffice/webmobiel/homepaginadefault'); 
                            }
                            
                            ?>
                            <li>
                                <a class="<?php if ($activeTabHeader == "mobileapp") { echo 'bottomHeaderMenu'; } ?>" href="<?php echo $mobiel; ?>">Web en Mobiel</a>
                            </li>                    
                            <?php
                            if (in_array("2", $fns)){
                                $crmlink=base_url('backoffice/relatiebeheer/relaties');  
                               // http://imobyupdate.projectflick.com/crm
                            }
                            else{
                                $crmlink=base_url('backoffice/crm/blank');
                            }
                            ?>
                            <li>
                                <a class="<?php if ($activeTabHeader == "crm") {echo 'bottomHeaderMenu'; } ?>" href="<?php echo $crmlink; ?>">Relatiebeheer</a>
                            </li>
                            
                            <li><a class="<?php
                            if ($activeTabHeader == "posts") {
                                echo 'bottomHeaderMenu';
                            }
                            ?>" href="<?= base_url() ?>backoffice/berichten/postvakin">Berichten</a></li>
                            <li>
                            <a class="<?php
                            if ($activeTabHeader == "setting") {
                                echo 'bottomHeaderMenu';
                            }
                            ?>" href="<?= base_url() ?>backoffice/instellingen/profiel">Instellingen</a>
                        </li>
                        <li>
                            <a class="<?php
                            if ($activeTabHeader == "contact") {
                                echo 'bottomHeaderMenu';
                            }
                            ?>" href="<?= base_url() ?>backoffice/info/contactgegevens">Info</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>