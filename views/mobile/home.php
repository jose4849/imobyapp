<!DOCTYPE html>
<html>
    <head>
        <title>Imoby</title>
        <meta name="viewport" content="width=device-width">        
        <!--<link rel="stylesheet" href="https://bengal-grid.googlecode.com/git/bengal-grid-v2.css" type="text/css" media="print, projection, screen" />-->
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/bengal-grid-v3.css" type="text/css" media="print, projection, screen" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/style.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/kstyle.css" type="text/css" media="print, projection, screen" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/icofont/style.css" type="text/css" media="print, projection, screen" /> 
        <link rel="stylesheet" href="<?= base_url() ?>assets/mobile/scheme/blue.css" type="text/css" media="print, projection, screen" />        
        <script type="text/javascript" charset="utf-8">           
            function goBack() {                  
                window.history.back()
            }
        </script>		
    </head>
    <body>
        <header class="top">
            <div class="row nav-view">
                <div class="l-12 home-bar">&nbsp;</div>
            </div>
        </header>
        <section>
            <div class="container1 commonpage">
                <div class="row icon-img text-r">
                    <a href="<?php echo base_url(); ?>mobile/imobyInformatie"><img src="<?= base_url() ?>assets/mobile/images/icon.png" alt="Icon" /></a>
                </div>
                <div class="row logo text-c">
                    <a href=""><img src="<?= base_url() ?>assets/mobile/images/logo.png" alt="Imoby" /></a>
                </div>
                <div class="row searchcode">
                    <div class="text-c">
                        <p style="font-size:5vw;line-height:6.5vw">Zoeken met een Imoby code of kenteken</p>
                        <form action="<?= base_url(); ?>mobile/searchObject" method="post">                            
                            <input type="text" id="search1" name="search" value="" placeholder="" />
                            <input type="submit" class="place-middle"  id="searchButton" value="Zoeken" style="margin-top:7vw;margin-bottom:7vw;" />
                        </form>
                    </div>
                </div>
                <div class="row qrcode">
                    <div class="l-12 text-c" id="qrcode">
                        <p>Geen QR code reader? Download hier.</p>
                        <div class="row soical-iconDiv">
                            <div class="l-2">&nbsp;</div>
                            <div class="l-8">
                                <div class="row">
                                    <div class="l-4 google_play"><a href="http://www.i-nigma.mobi"><i class="fa fa-play"></i>Google Play</a></div>                            
                                    <div class="l-4 apple"><a href="http://www.i-nigma.mobi"><i class="fa fa-apple"></i>Apple</a></div>                            
                                    <div class="l-4 overige"><a href="http://www.i-nigma.mobi"><i class="fa fa-mobile"></i>Overige</a></div>
                                </div>
                            </div>
                            <div class="l-2">&nbsp;</div>
                        </div>
                    </div>
                    <div class="l-2">&nbsp;</div>
                </div>
                <?php include('layout/footer2.php') ?>
            </div>
        </section>            
    </body>
</html>
