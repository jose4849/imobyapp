<?php echo $header; ?>
		<header class="top">
            <div class="row nav-view">
				<div class="container1">
                <div class="l-1 nopad-l">
                    <a href="<?= base_url(); ?>mobile/home/<?php echo  $this->uri->segment(3);  ?>"><i class="fa fa-reply"></i></a>
                </div>
                <div class="l-10">
                    <span class="single-page-title">Pech/Hulp</span>
                </div>                
                <div class="l-1"></div>                
				</div>
            </div>
        </header>
        <section>
            <div class="container1 commonpage">
                <div class="row maintenance">

<div class="l-4">
	<a href="<?= base_url() ?>mobile/pechhulp/<?php echo $homePageId; ?>/hulpnummers">
	<div class="panel">
		
			<i class="ico icon-pechhulp"></i>
		
		<span>Hulpnummers<br />&nbsp;</span>
	</div></a>
</div>
<div class="l-4"><a href="<?= base_url() ?>mobile/pechhulp/<?php echo $homePageId; ?>/starthulp">
	<div class="panel">
		
			<i class="ico icon-pechhulp2"></i>
		
		<span>Starthulp geven</span>
	</div></a>
</div>
<div class="l-4"><a href="<?= base_url() ?>mobile/pechhulp/<?php echo $homePageId; ?>/wile">
	<div class="panel">
		
			<i class="ico icon-pechhulp3"></i>
		
		<span>Wiel verwisselen</span>
	</div></a>
</div>
                  
                </div>
                <div class="row maintenance">                  
<div class="l-4"><a href="<?= base_url() ?>mobile/pechhulp/<?php echo $homePageId; ?>/oververhitte">
	<div class="panel">
		
			<i class="ico icon-pechhulp4"></i>
		
		<span>Oververhitte motor</span>
	</div></a>
</div>
<div class="l-4"><a href="<?= base_url() ?>mobile/pechhulp/<?php echo $homePageId; ?>/lampje">
	<div class="panel">
		
			<i class="ico icon-pechhulp5"></i>
		
		<span>Lampje verwisselen</span>
	</div></a>
</div>
<div class="l-4"><a href="<?= base_url() ?>mobile/pechhulp/<?php echo $homePageId; ?>/sleutel">
	<div class="panel">
		
			<i class="ico icon-pechhulp6"></i>
		
		<span>Sleutel en alarm</span>
	</div></a>
</div>

                </div>
                <?php include('layout/footer2.php')?>
            </div>
        </section> 
<?php echo $footer; ?>