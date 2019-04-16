<?php $this->load->view('backoffice/layouts/header'); ?>
<link rel="stylesheet" href="<?= base_url() ?>assets/crmAssets/css/jquery-ui-1.10.3.css" type="text/css" media="print, projection, screen" /> 
<link rel="stylesheet" href="<?= base_url() ?>assets/style.css" type="text/css" media="print, projection, screen" />
<link rel="stylesheet" href="<?= base_url() ?>assets/usercss.css" type="text/css" media="print, projection, screen" />
<div id="wrapper">
    <div id="sidebar">
        <h3 class="user-page-title">Dashboard</h3>
        <ul id="deshboard-menu">
            <li class="active"><a href="<?php echo base_url(); ?>backoffice/webmobiel/homepagina"><span class="icon-home"></span>Home</a></li>
            <li><a href="<?php echo base_url('backoffice/webmobiel/aanbodpagina'); ?>"><span class="icon-offer"></span>Aanbod</a></li>
            <li><a href="<?php echo base_url(); ?>backoffice/webmobiel/presentaties"><span class="icon-presentation"></span>Presentaties</a></li>
            <li><a href="<?php echo base_url(); ?>backoffice/webmobiel/statistieken"><span class="icon-statistics"></span>Statistieken</a></li>
            <li><a href="<?php echo base_url(); ?>backoffice/berichten/postvakin"><span class="icon-post"></span>Postvak IN</a></li>
            <li><a href="<?php echo base_url(); ?>backoffice/berichten/aanbod"><span class="icon-chat"></span>Reacties</a></li>
            <li><a href="<?php echo base_url(); ?>backoffice/webmobiel/website"><span class="icon-web"></span>Website</a></li>
            <li><a href="<?php echo base_url(); ?>backoffice/relatiebeheer/relaties"><span class="icon-crm"></span>Relatiebeheer</a></li>
        </ul>
    </div>
    <div id="content">
        <div class="content-box">
            <h4 class="content-box-title">Agenda</h4>
            <div id="calendar">
                <img src="<?php echo base_url() ?>assets/crmAssets/images/fullcalendar.jpg" />
            </div>
            <div id="agendalist">
                <div class="agendaday">
                    <span class="day">6</span> <span class="juni">juni</span>
                </div>
                <div class="agendalistitems">
                    <ul>
                        <li><span class="time">12:00</span><span class="message">Grote beurt - Dhr. Jansen</span></li>
                        <li><span class="time">15:15</span><span class="message">Inruil code 201 - Dhr. Peters</span></li>
                        <li><span class="time">15:15</span><span class="message">HJ-123-AH - Mevr. Sanders</span></li>
                        <li><span class="more">....</span></li>
                    </ul>                            
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="content-box">
            <h4 class="content-box-title">Berichten</h4>
            <div class="cbox-full">	
                <h3 class="b-text">Postvak IN</h3>
                <div class="content-box-left">

                    <?php $x=0; foreach($email as $mail){ ?>
                    
                    <p><?php echo $mail->subject; ?></p>
                    <p class="body-text"><?php echo $mail->body; ?>Van</p>
                    <p class="last-p text-gray">
                        <span class="blue"><?php echo $mail->from; ?></span>
                        <a class="next" href="<?php $email_id=$mail->email_id; echo base_url("backoffice/berichten/view/$email_id"); ?>">Next</a>
                    </p>
                    
                    
                    
                    <?php if($x!=2){ ?>
                    <hr>
                    
                    <div class="clr"></div>
                    <?php } $x++; } ?>
                </div>
            </div>	
            <div class="cbox-full">	
                <h3 class="b-text">Reacties aanbod</h3>
                <div class="content-box-left">

                    
                     <?php $x=0; foreach($annbod as $mail){ ?>
                    
                    <p><?php echo $mail->subject; ?></p>
                    <p class="body-text"><?php echo $mail->body; ?>Van</p>
                    <p class="last-p text-gray">
                        <span class="blue"><?php echo $mail->from; ?></span>
                        <a class="next" href="<?php $email_id=$mail->email_id; echo base_url("backoffice/berichten/view/$email_id"); ?>">Next</a>
                    </p>
                    
                    
                    <?php if($x!=2){ ?>
                    <hr>
                    
                    <div class="clr"></div>
                    <?php } $x++; } ?>

                </div>
            </div>	
        </div>

    </div>
</div>
<?php $this->load->view('backoffice/layouts/footer'); ?>
