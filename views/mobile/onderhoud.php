<?php echo $header; ?>
<script>
    function fullscreen() {
        //alert("hello");
                
        $('a').click(function() {
            if(!$(this).hasClass('noeffect')) {
                var link = (this);
               // alert(link);
                if(link==''){
                            
                }
                else{
                    window.location = $(this).attr('href');
                }
                //
                return false;
            }
        }); 
    }
    fullscreen();
</script>
<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-1 nopad-l">
                <a  href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-10">
                <span class="single-page-title">Onderhoud</span>
            </div>                
            <div class="l-1"></div>                
        </div>
    </div>
</header>
<section>
    <div class="container1 commonpage">
        <div class="row maintenance">                  
            <div class="l-4">
                <a href="<?= base_url() ?>mobile/onderhoud/<?php echo $homePageId; ?>/ruitenwissers">
                    <div class="panel">

                        <i class="ico icon-onderhoud"></i>

                        <span> Ruitenwissers<br /> vervangen</span>
                    </div>
                </a>
            </div>
            <div class="l-4">
                <a href="<?= base_url() ?>mobile/onderhoud/<?php echo $homePageId; ?>/verlichting">
                    <div class="panel">

                        <i class="ico icon-onderhoud2"></i>

                        <span>Verlichting <br /> controleren</span>
                    </div>
                </a> 
            </div>
            <div class="l-4">
                <a href="<?= base_url() ?>mobile/onderhoud/<?php echo $homePageId; ?>/vloeistoffen">
                    <div class="panel">

                        <i class="ico icon-onderhoud3"></i>

                        <span>Vloeistoffen <br />controleren</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="row maintenance">                  
            <div class="l-4">
                <a href="<?= base_url() ?>mobile/onderhoud/<?php echo $homePageId; ?>/wassen">
                    <div class="panel">

                        <i class="ico icon-onderhoud4"></i>
                        <span>Wassen en<br /> poetsen</span>

                    </div>
                </a>  
            </div>
            <div class="l-4">
                <a href="<?= base_url() ?>mobile/onderhoud/<?php echo $homePageId; ?>/winterklaar">
                    <div class="panel">                   
                        <i class="ico icon-onderhoud5"></i>
                        <span>Winterklaar <br />maken</span>
                    </div>
                </a> 
            </div>
            <div class="l-4">
                <a href="<?= base_url() ?>mobile/onderhoud/<?php echo $homePageId; ?>/airco">
                    <div class="panel">                   
                        <i class="ico icon-onderhoud6"></i>
                        <span>Airco<br /><br /></span>
                    </div>
                </a>
            </div>
        </div>
        <div class="row maintenance">
            <div class="l-4">
                <a href="<?= base_url() ?>mobile/onderhoud/<?php echo $homePageId; ?>/banden">
                    <div class="panel">                   
                        <i class="ico icon-onderhoud7"></i>
                        <span>Banden<br />controleren</span> 
                    </div>
                </a>
            </div>
            <div class="l-4">

            </div>
        </div>
        <?php include('layout/footer2.php') ?>
    </div>
</section> 
<?php echo $footer; ?>