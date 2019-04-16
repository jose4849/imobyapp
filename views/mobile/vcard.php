<?php echo $header; ?>
<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-2 nopad">
                <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-8">
                <span class="single-page-title">vCard</span>
            </div>                
            <div class="l-2"></div>                
        </div>
    </div>
</header>

<section class="vcard">
    <div class="container1 commonpage">

        <form class="login-registration" action="<?= base_url() ?>mobile/vcard/<?php echo $homePageId; ?>/email/"  method="get" >
            <div class="row">
                <p class="text-c">Vul hieronder uw emailadres in en ontvang de vCard in uw e-mail.</p>
                <div class="l-1"></div>
                <div class="l-10 place-middle">

                    <input type="text" name="email" value="" name="search" />
                </div>
                <div class="l-1"></div>                        
            </div>
            <div class="row">
                <div class="l-12 btnholder">

                    <input class="npage-btn" type="submit" id="shipping" name="" value="Verzenden" />

                </div>
            </div>
            <div class="row">
                <p class="text-c">U kunt de vCard ook direct downloaden op uw telefoon. Klik hiervoor op onderstaande button.</p>
                <div class="l-12 btnholder">
                    <a class="noeffect" href="<?= base_url() ?>mobile/vcard/<?php echo $homePageId; ?>/download"><input class="npage-btn" type="button" id="download" name="download" value="Downloaden" /></a>
                </div>
            </div>
        </form>
        <?php include('layout/footer2.php') ?>		
    </div>
</section>            
<?php echo $footer; ?>
