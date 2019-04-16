<?php echo $header; ?>
		<header class="top">
            <div class="row nav-view">
				<div class="container1">
                <div class="l-1 nopad-l">
                    <a href="<?= base_url(); ?>mobile/home/<?php echo  $this->uri->segment(3);  ?>"><i class="fa fa-reply"></i></a>
                </div>
                <div class="l-10">
                    <span class="single-page-title">Schade</span>
                </div>                
                <div class="l-1"></div>                
				</div>
            </div>
        </header>	

        <section class="schade">
            <div class="container1 commonpage">
                <div class="row">
                    <p>Mobiel schade melden is de platform van het Verbond van Verzekeraar waarmee eenzijdige en tweezijdige autoschades kunnen worden gemeld. </p>
                    <p>De mobiele website "Mobielschademelden" vervangt hiermee het Europese schadeaangifte formulier. Een melding via deze mobiele website wordt automatisch doorgestuurd naar de juiste verzekeraar op basis van het kenteken van het voertuig. </p>
                    <p>Via de e-mail krijg u als melder zelf ook een afschrift. Voertuiggegevens worden automatisch opgehaald, de locatie wordt opgehaald met behulp van GPS. Verder worden er veel minder vragen gesteld waardoor mobiel schade melden veel makkelijker wordt dan met het oude formulier. </p>
                    <p>Vrijwel alle Nederlandse verzekeraars en een aantal leasemaatschappijen willen graag dat u gebruik maakt van Mobiel schade melden. </p>
                </div>
                <div class="row text-c">

                    <div class="l-10 place-middle">
                        <a href="https://www.mobielschademelden.nl/"><input class="npage-btn" type="button" id="to-the-claim" value="Naar het schadeformulier" name="to the claim" /></a>
                    </div>

                </div>
                <?php include('layout/footer2.php')?>
            </div>
        </section>            
<?php echo $footer; ?>
