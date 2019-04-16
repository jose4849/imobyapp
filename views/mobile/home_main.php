<?php echo $header;
//echo '<pre>';
//print_r($informatie[0]);
//die();
 ?>
<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>bb/images/icon.png" />
<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>bb/images/icon120x120.png" />
<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>bb/images/icon152x152.png" />
<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>bb/images/icon76x76.png" />
<script type="text/javascript" src="<?php echo base_url(); ?>bb/bookmark/bookmark_bubble.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>bb/example/bookmarks.js"></script>
<!-- Modal -->    
<div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header row">              
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Email</h4></div>
				<div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button></div>
            </div>
            <div class="modal-body">

                <div class="DemoBS2">
                    <div class="panel-group" id="accordion">



                        <div class="panel">
                            <div class="">
                                <h4 class="panel-title"></h4>
                            </div>
                            <div id="accordionOne" class="panel-collapse collapse in">
                               
                                    <form id="register-form">
                                    <input required type="email" class="inputbox" id="name1" placeholder="Naam2" />
                                    <input required type="email" class="inputbox" id="email1" placeholder="Email" />
                                    <input required type="hidden" value="<?php echo $informatie[0]->dealer; ?>" class="inputbox" id="dealer_id1"  />
                                    <input required type="hidden" value="Message form mobile home" class="inputbox" id="subject1"  />
                                    <input required type="text"  class="inputbox" id="tel1" placeholder="Telefoonnummer" />
				    <textarea class="inputbox" id="body1" placeholder="Bericht" ></textarea>
                                    <input type="button" id="form-one" class="subbtn" value="Verstuur" />
                                    <br>
                                    <div class="success"></div>
                                    </form>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 


<!-- Modal -->    
<div class="modal fade" id="barichten" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header row">              
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Berichten</h4></div>
				<div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button></div>
            </div>

            <div class="modal-body">
                <p>Lorem ipsum (This will be static For now)dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p> <p>incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</p> <p>eiusmod tempor incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquaLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</p>
            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 
<header class="top">
    <div class="row nav-view">
        <div class="l-12 home-bar">&nbsp;</div>
    </div>
</header>
<section>
	
    <div class="container1 homePage">
		<div class="row home-top">
			<div class="l-12 bg-white nopad">
				<div class="page-info">
					<h3><?php echo $informatie[0]->name; ?></h3>
					<p>
                                        <?= $informatie[0]->street ?>
                                        <?= $informatie[0]->house_num ?>
                                        <?= $informatie[0]->house_num_addition ?><br>
                                        <?= $informatie[0]->postal_code ?>
                                        <?= $informatie[0]->city ?>	
					</p>
				</div>	
			</div>
		</div>
        <div class="row imboy-infodiv">
		
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/aanbod/<?= $stockPageId; ?>">
				<i class="ico icon-h-aaonbod"></i>
				<span>Aanbod</span>
				</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/informatie/<?= $homePageId; ?>">
			<i class="ico icon-h-informatie"></i><span>Informatie</span>
			</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/route/<?= $homePageId; ?>">
			<i class="ico icon-h-route"></i><span>Route</span>
			</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/vcard/<?= $homePageId; ?>">
			<i class="ico icon-h-vcard"  style="font-size:6vw"></i><span>vCard</span></a></div>
        </div>
        <div class="row imboy-infodiv">
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/minjvoerting/<?= $homePageId; ?>">
			<i class="ico icon-h-voertuig"></i><span>Mijn voertuig</span>
			</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/brandstof/<?= $homePageId; ?>">
			<i class="ico icon-h-brandstof"></i><span>Brandstof</span>
			</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/parkeerhulp/<?= $homePageId; ?>">
			<i class="ico icon-h-parkeerhulp"></i><span>Parkeerhulp</span>
			</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/ikenteken/<?= $homePageId; ?>">
			<i class="ico icon-h-ikenteken" style="font-size:6vw"></i><span>iKenteken</span>
			</a></div>
        </div>
        <div class="row imboy-infodiv">
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/onderhoud/<?= $homePageId; ?>">
			<i class="ico icon-h-onderhoud"></i><span>Onderhoud</span>
			</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/dashboard/<?= $homePageId; ?>">
			<i class="ico icon-h-dashboard"></i><span>Dashboard</span>
			</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/pechhulp/<?= $homePageId; ?>">
			<i class="ico icon-h-pechhulp"></i><span>Pech/Hulp</span>
			</a></div>
            <div class="l-3 round bg-white"><a href="<?= base_url() ?>mobile/schade/<?= $homePageId; ?>">
			<i class="ico icon-h-schade"></i><span>Schade</span>
			</a></div>
        </div>
    </div>
</section>  
<footer class="footer1 navbar-fixed-bottom">
    <div class="row">
        <ul id="btn-menu">
            <li><a href="tel:<?php echo $informatie[0]->phoneNumber1; ?>"  class="pho"><i class="fa fa-mobile" style="font-size:7vw"></i><span>Bellen</span></a></li>
            <li><a class="noeffect" data-toggle="modal" data-target="#email"   ><i class="fa fa-envelope"></i><span>Email</span></a></li>
            <li class="active"><a class="noeffect" data-toggle="modal" data-target="#barichten"  ><i class="fa fa-bell"></i><span>Berichten</span></a></li>
            <li><a  href="<?php if(isset($facebook)){ echo $facebook; } else{ echo "#"; } ?>"><i  class="fa fa-facebook-square"></i><span>Facebook</span></a></li>
            <li><a  href="<?php if(isset($twitter)){ echo $twitter; } else{ echo "#"; } ?>"><i class="fa fa-twitter"></i><span>Twitter</span></li>
        </ul>                
    </div>            
</footer>


<?php echo $footer; ?>
