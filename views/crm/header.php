<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="NL" />
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>bb/images/favicon.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/crmAssets/css/jquery-ui-1.10.3.css" type="text/css" media="print, projection, screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/crmAssets/css/jquery.dataTables.css?ts=<?php echo time();?>" type="text/css" media="print, projection, screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/crmAssets/css/crm.css?ts=<?php echo time();?>" type="text/css" media="print, projection, screen" />
    <?php $base=base_url(); ?>
    <?php if(is_array($cssInclude)){
        foreach ($cssInclude as $file){
            echo '<link rel="stylesheet" href="'.$base.'assets/crmAssets/css/'.$file.'.css?ts='.time().'" type="text/css" media="print, projection, screen" />'."\n";
        }
    }?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/jquery-ui-1.10.3.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/jquery-ui-timepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/jquery.ui.datepicker-nl.js"></script>
    <script>
    var base = '<?php echo base_url(); ?>';
    var baseUrl = '<?php echo base_url(); ?>';
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/crm.js?ts=<?php echo time();?>"></script>
    <?php if(is_array($jsInclude)){
        foreach ($jsInclude as $file){
            echo '<script type="text/javascript" src="'.$base.'assets/crmAssets/js/'.$file.'.js?ts='.time().'"></script>'."\n";
        }
    }?>
    <title>Relatiebeheer | Imoby.nl</title>    
</head>
<body>
    
    <div id="header">
        <div id="headerWrapper">
            <div id="headerMenu">
                <ul>
                    <li class="hassub">
                        <a href="<?php echo base_url(); ?>/<?php echo $imobyMobileCode; ?>"><img class="username" src="<?php echo base_url(); ?>assets/crmAssets/images/menuUsername.png" />imoby.nl/<?php echo $imobyMobileCode; ?></a>                      
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>logout"><img class="uitloggen" src="<?php echo base_url(); ?>assets/crmAssets/images/menuUitloggen.png" />Uitloggen</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="bottomHeader">
        <div id="bottomHeaderWrapper">
			<a href="<?php echo base_url('backoffice'); ?>">
            <img src="<?php echo base_url(); ?>assets/crmAssets/images/logo.png" alt="Imoby.nl - Backoffice" title="Imoby.nl - Backoffice" id="topMenuLogo"/>
            </a>
			<div id="bottomHeaderMenu">
                <ul>
                    
                    
                    <li><a href="<?= base_url() ?>backoffice/dashboard" >Dashboard</a></li>
                    <li><a href="<?php echo base_url('backoffice/webmobiel/homepagina'); ?>">Web en Mobiel</a></li>                    
                    <li><a href="<?php echo base_url('backoffice/relatiebeheer/relaties'); ?>" <?php /* if($active=='Relaties') {echo 'class="bottomHeaderMenu"'; }; */ echo 'class="bottomHeaderMenu"'; ?>>Relatiebeheer</a></li>
                    <li><a class="" href="<?= base_url() ?>backoffice/berichten/postvakin">Berichten</a></li>
                    <li><a class="" href="<?= base_url() ?>backoffice/instellingen/profiel">Instellingen</a></li>
                    <li><a class="" href="<?= base_url() ?>backoffice/info/contactgegevens">Info</a></li>
                    <!-- <li><a href="<?php echo base_url(); ?>crm/settings" <?php if($active=='Settings') {echo 'class="bottomHeaderMenu"'; }; ?> >Instellingen</a></li>--->
                    
                </ul>
            </div>
        </div>
    </div>