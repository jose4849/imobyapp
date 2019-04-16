<?php echo $header; ?>

<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-1 nopad-l">
             <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-10">
                <span class="single-page-title">Dashboard</span>
            </div>                
            <div class="l-1"></div>                
        </div>
    </div>
</header>
<section>
    <div class="container1 commonpage">


        <div class="row dashboard">                  
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/remmen"><img class="img-cc" src="<?= base_url() ?>assets/mobile/images/brakes.jpg" alt="Remmen" /></a><span>Remmen</span></div>
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/motor"><img class="img-cc"  src="<?= base_url() ?>assets/mobile/images/motor.jpg" alt="Motor" /></a><span>Motor</span></div>
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/koeling"><img class="img-cc"  src="<?= base_url() ?>assets/mobile/images/cooling.jpg" alt="Koeling" /></a><span>Koeling</span></div>
        </div>
        <div class="row dashboard">                  
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/olie"><img class="img-cc"  src="<?= base_url() ?>assets/mobile/images/oil.jpg" alt="Olie" /></a><span>Olie</span></div>
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/banden"><img class="img-cc"  src="<?= base_url() ?>assets/mobile/images/tires2.jpg" alt="Winterklaar maken" /></a><span>Banden</span></div>
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/airbag"><img class="img-cc" src="<?= base_url() ?>assets/mobile/images/airbag.jpg" alt="Airbag" /></a><span>Airbag</span></div>
        </div>
        <div class="row dashboard">                  
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/besturing"><img class="img-cc"  src="<?= base_url() ?>assets/mobile/images/control.jpg" alt="controleren" /></a><span>Besturing</span></div>
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/accu"><img class="img-cc"  src="<?= base_url() ?>assets/mobile/images/battery.jpg" alt="Accu" /></a><span>Accu</span></div>
            <div class="l-4"><a href="<?= base_url() ?>mobile/dashboard/<?php echo $homePageId; ?>/roetfilter"><img class="img-cc"  src="<?= base_url() ?>assets/mobile/images/filter.jpg" alt="Roetfilter" /></a><span>Roetfilter</span></div>
        </div>






        <?php include('layout/footer2.php') ?>
    </div>
</section> 
<?php echo $footer; ?>