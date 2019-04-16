<?php include('layout/header2.php');?>
<link rel="stylesheet" href="<?= base_url() ?>assets/mobile/scheme/blue.css" type="text/css" media="print, projection, screen" />  
<header class="top">
    <div class="row nav-view">
		<div class="container1">
        <div class="l-2 nopad">
            <a href="<?= base_url(); ?>mobile/home/<?php echo  $this->uri->segment(3);  ?>"><i class="fa fa-reply"></i></a>
        </div>
        <div class="l-8">

        </div>                
        <div class="l-2"></div>                
		</div>
    </div>
</header>
        <section>        
            <div class="container1 commonpage">
                <div class="row info-text">
<p>De door u opgevraagde Imoby presentatie is niet (meer) beschikbaar.</p>    
                </div>
                <div class="row addressImoby">
                    <div class="l-12">
                            <h4 class="theme-col" style="margin-bottom:4vw;margin-top: 3vw; font-size: 5vw;padding:0">Imoby B.V.</h4>
                            <p style="margin-bottom:1em;">
                                Nieuwe Kade 16,
                                <br />
                                6827 AB Arnhem.
                            </p>
                            <span class="theme-col bold">T </span>: 026-3020027<br />
                            <span class="theme-col bold">E </span>: info@imoby.nl<br />
                            <span class="theme-col bold">W</span>: www.imoby.nl<br />
                    </div>
                </div>
                <?php include('layout/footer2.php')?>
            </div>
        </section>            
    </body>
</html>