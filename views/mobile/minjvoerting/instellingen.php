<?php echo $header; ?>
<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-1 nopad">
                <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-10">
                <span class="single-page-title">Mijn voertuig inst</span>
            </div>                
            <div class="l-1"></div>                
        </div>
    </div>
</header>		
<section>
    <div class="container1 commonpage">
        <form class="login-registration">
            <div class="row">
                <p class="text-c">Inloggen met kenteken</p>
                <div class="l-1"></div>
                <div class="l-10 place-middle">
                    <input type="text" value="" placeholder="Kenteken" name="Badge" />
                </div>
                <div class="l-10 place-middle">
                    <input class="npage-btn" type="button" id="to-the-claim" value="Inloggen" name="to the claim" />
                </div>                
                <div class="l-1"></div>                        
            </div>
            <div class="row">
                <p class="text-c">Inloggen met gebruikersnaam en wachtwoord</p>
                <div class="l-1"></div>
                <div class="l-10 place-middle">
                    <input type="text" value="" placeholder="Gebruikersnaam" name="Username" />
                    <input type="password" value="" placeholder="Wachtwoord" name="password" />
                </div>
                <div class="l-1"></div>
            </div>
            <div class="row text-c">

                <div class="l-10 place-middle">
                    <input class="npage-btn" type="button" id="to-the-claim" value="Inloggen" name="to the claim" />
                </div>

            </div>
        </form>
        <?php include('layout/footer2.php') ?>
    </div>
</section>            
<?php echo $footer; ?>