<?php include('layout/header2.php');?>
<header class="top">
    <div class="row nav-view">
		<div class="container1">
        <div class="l-2 nopad">
            <a href="<?= base_url(); ?>mobile/home/<?php echo  $this->uri->segment(3);  ?>"><i class="fa fa-reply"></i></a>
        </div>
        <div class="l-8">
            <span class="single-page-title">Informatie</span>
        </div>                
        <div class="l-2"></div>                
		</div>
    </div>
</header>
        <section>        
            <div class="container1 commonpage">
                <div class="row info-text">
                    <div class="l-12">
                        <img style="width: 100px;" src="<?= base_url() ?>media/dealers/<?php echo $dealer_id; ?>/logo_<?php echo  $dealer_id; ?>.png" alt="logo 2" />
                    </div>
                </div>
                <div class="row addressImoby">
                    <div class="l-12">
                            <h4 class="theme-col" style="margin-bottom:4vw;margin-top: 3vw; font-size: 5vw;padding:0"><?= $informatie[0]->name ?></h4>
                            <p style="margin-bottom:1em;">
                               <?= $informatie[0]->street ?> <?= $informatie[0]->house_num ?> <?= $informatie[0]->house_num_addition ?>
                                <br />
                                 <?= $informatie[0]->postal_code ?> <?= $informatie[0]->city ?>  <?php //$informatie[0]->country ?>
                            </p>
                            <span class="theme-col bold">T </span>: <?= $informatie[0]->phoneNumber1 ?><br />
                            <span class="theme-col bold">E </span>: <?= $informatie[0]->email ?><br />
                            <span class="theme-col bold">W</span>: <?= $informatie[0]->website ?><br />
                    </div>
                </div>
                <?php include('layout/footer2.php')?>
            </div>
        </section>            
    </body>
</html>
