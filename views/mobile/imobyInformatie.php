<?php include('layout/header2.php');?>
        <header class="top">
            <div class="row nav-view">
				<div class="container1">
					<div class="l-12 nopad">
						<a href="<?= base_url(); ?>mobile/home/<?php echo  $this->uri->segment(3);  ?>"><i class="fa fa-reply"></i></a>
					</div>
				</div>	
            </div>
        </header>
        <section>
            <div class="container1 commonpage">
                <div class="row">
                    <div class="col-lg-12 info-text nopad">
                        <p>Deze mobiele website wordt ter beschikking gesteld en technisch beheerd door Imoby B.V.</p> <p>Imoby B.V. is niet aansprakelijk voor de binnen deze mobiele websites getoonde content.</p> <p>Voor meer informatie kunt u contact opnemen met:</p>
                    </div>
                </div>
                <div class="row addressImoby">
				
				<div class="l-12 nopad">
                            <h4 style="margin-bottom:4vw;margin-top: 3vw; font-size: 5vw;padding:0" class="theme-col">Imoby B.V.</h4>
                            <p style="margin-bottom:1em;">
                                Nieuwe Kade 16
                                <br>
                                6827 AB Arnhem
                            </p>
                            <span class="theme-col bold">T</span>: 026-302002<br>
                            <span class="theme-col bold">E</span>: info@imoby.nl<br>
                            <span class="theme-col bold">W</span>: www.imoby.nl<br>
                    </div>
                </div>
				<?php include('layout/footer2.php');?>
            </div>
        </section>            
    </body>
</html>
