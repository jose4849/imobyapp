<?php echo $header; ?>     
<?php 


$subject='';
if (isset($car->brand)) {
    $subject=$subject.$car->brand." ";
} ?> <?php if (isset($car->model)) {
    $subject=$subject.$car->model." ";
} ?> <?php if (isset($car->type)) {
    $subject=$subject.$car->type." ";
} ?>


<!-- Modal -->    
<div class="modal fade" id="acties" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">

                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Acties</h4></div>
                <div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordion">
                    <div class="accordion-group">
                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(10)">
                            <div class="accordion-heading top-bar">
                                <span>Maak een afspraak</span>  
                                <i class="fa rblueup fa-chevron-up" id="collapse10"></i>
                            </div>
                        </a>
                        <div class="accordion-body collapse in panel" id="collapsefull10" style="display: block;">

                            <div class="accordion-inner objdesc">     		
                                <input type="text" class="form-control" id="name1" placeholder="Naam" />
                                <input type="email" class="form-control" id="email1" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $dealer[0]->dealer; ?>" id="dealer_id1" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $subject; ?>" id="subject1" placeholder="Subject" />
                                <input type="text" class="form-control" id="tel1" placeholder="Telefoonnummer" />
                                <textarea class="form-control" id="body1" placeholder="Bericht" ></textarea>
                                <input type="submit" id="form-one" class="form-control" value="Verstuur" />
                                <div class="success1 success"></div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(11)">
                            <div class="accordion-heading top-bar">
                                <span>Meer informatie</span>  
                                <i class="fa rblueup fa-chevron-down" id="collapse11"></i>
                            </div>
                        </a>
                        <div class="accordion-body collapse in panel" id="collapsefull11" style="display: none;">
                            <div class="accordion-inner objdesc">     		
                                <input type="text" class="form-control" id="name2" placeholder="Naam" />
                                <input type="text" class="form-control" id="email2" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $dealer[0]->dealer; ?>" id="dealer_id2" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $subject; ?>" id="subject2" placeholder="Subject" />                                
                                <input type="text" class="form-control" id="tel2" placeholder="Telefoonnummer" />
                                <textarea class="form-control" id="body2" placeholder="Bericht" ></textarea>
                                <input type="submit" id="form-two" class="form-control" value="Verstuur" />
                                <div class="success2 success"></div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-group">
                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(12)">
                            <div class="accordion-heading top-bar">
                                <span>Proefrit aanvragen</span>  
                                <i class="fa rblueup fa-chevron-down" id="collapse12"></i>
                            </div>
                        </a>
                        <div class="accordion-body collapse in panel" id="collapsefull12" style="display: none;">
                            <div class="accordion-inner objdesc">     		
                                <input type="text" class="form-control" id="name3" placeholder="Naam" />
                                <input type="text" class="form-control" id="email3" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $dealer[0]->dealer; ?>" id="dealer_id3" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $subject; ?>" id="subject3" placeholder="Subject" />                                
                                <input type="text" class="form-control" id="tel3" placeholder="Telefoonnummer" />
                                <textarea class="form-control" id="body3" placeholder="Bericht" ></textarea>
                                <input type="submit" id="form-three" class="form-control" value="Verstuur" />
                                <div class="success3 success"></div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-group">
                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(13)">
                            <div class="accordion-heading top-bar">
                                <span>Financiering aanvragen</span>  
                                <i class="fa rblueup fa-chevron-down" id="collapse13"></i>
                            </div>
                        </a>
                        <div class="accordion-body collapse in panel" id="collapsefull13" style="display: none;">
                            <div class="accordion-inner objdesc">     		
                                <input type="text" class="form-control" id="name4" placeholder="Naam" />
                                <input type="text" class="form-control" id="email4" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $dealer[0]->dealer; ?>" id="dealer_id4" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $subject; ?>" id="subject4" placeholder="Subject" />                                                                
                                <input type="text" class="form-control" id="tel4" placeholder="Telefoonnummer" />
                                <textarea class="form-control" id="body4" placeholder="Bericht" ></textarea>
                                <input type="submit" id="form-four" class="form-control" value="Verstuur" />
                                <div class="success4 success"></div>
                            </div>
                        </div>
                    </div>				

                    <div class="accordion-group">
                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(14)">
                            <div class="accordion-heading top-bar">
                                <span>Lease offerte aanvragen</span>  
                                <i class="fa rblueup fa-chevron-down" id="collapse14"></i>
                            </div>
                        </a>
                        <div class="accordion-body collapse in panel" id="collapsefull14" style="display: none;">
                            <div class="accordion-inner objdesc">     		
                                <input type="text" class="form-control" id="name5" placeholder="Naam" />
                                <input type="text" class="form-control" id="email5" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $dealer[0]->dealer; ?>" id="dealer_id5" placeholder="Email" />
                                <input type="hidden" class="form-control" value="<?php echo $subject; ?>" id="subject5" placeholder="Subject" />                                                                
                                <input type="text" class="form-control" id="tel5" placeholder="Telefoonnummer" />
                                <textarea class="form-control" id="body5" placeholder="Bericht" ></textarea>
                                <input type="submit" id="form-five" class="form-control" value="Verstuur" />
                                <div class="success5 success"></div>
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
<div class="modal fade" id="delen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">               
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Delen</h4></div>
                <div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>

            <div class="modal-body">

                <div class="row objsocial">
                    <div class="l-12 nopad text-l">
                        <a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('<?php echo base_url(); ?>mobile/object/<?php echo $object; ?>'),'facebook-share-dialog','');"  ><i class="fa fa-facebook-square"></i>&nbsp; Facebook</a>
                        <br />
                        <a href="http://twitter.com/share?text=<?php echo $dealer[0]->name; ?>&url=<?php echo base_url(); ?>mobile/object/<?php echo $object; ?>"><i class="fa fa-twitter-square"></i>&nbsp; Twitter</a>
                    </div>
                </div>

                <div class="accordion-group">
                    <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(20)">
                        <div class="accordion-heading top-bar" style="background:#fff;padding:0px;font-size:4.5vw;line-height: 6vw;">
                            <span><i class="fa fa-envelope  theme-col"></i>&nbsp; <span class="theme-col" style="font-weight:normal;">Email</span></span>  
                            <i class="fa rblueup fa-chevron-down" id="collapse20"></i>
                        </div>
                    </a>
                    <div class="accordion-body collapse in panel" id="collapsefull20" style="display: none;">
                        <div class="accordion-inner objdesc">     		
                            <input type="text" class="form-control" id="jouwemailfrom6" placeholder="Uw naam" />
                            <input type="text" class="form-control" id="jouwemailto6" placeholder="Uw email" />
                            <input type="text" class="form-control" id="jouwemailtel6" placeholder="Ontvanger naam" />
                            <input type="text" class="form-control" id="jouwemailtel6" placeholder="Ontvanger email" />

                            <input type="submit" id="form-six" class="form-control" value="Verstuur" />
                            <div class="success6 success"></div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 
<!-- Modal -->    
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">               
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Contact</h4></div>
                <div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>
            <div class="modal-body">


                <h2 class="theme-col"> <?php echo $dealer[0]->name; ?></h2>
                <p>
                    <?php echo $dealer[0]->street; ?> <?php echo $dealer[0]->house_num; ?> <?php echo $dealer[0]->house_num_addition; ?><br>
                    <?php echo $dealer[0]->postal_code; ?> <?php echo $dealer[0]->city; ?>
                </p>
                <p><span class="theme-col">T </span>: <?php echo $dealer[0]->phoneNumber1; ?><br />
                    <span class="theme-col">E </span>: <?php echo $dealer[0]->email; ?><br />
                    <span class="theme-col">W</span>: <?php echo $dealer[0]->website; ?></p>

            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 
<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <!--<div class="l-3 nopad"> <a onclick="goBack()" ><i class="fa fa-reply"></i></a> </div>-->
            <div class="l-3 nopad">
                <a href="<?php echo base_url(); ?>mobile/aanbod/<?php echo $dealer[0]->stockPageId; ?>" ><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-6 nopad">&nbsp;</div>                
            <div class="l-1 text-l nopad"  style="font-size:7vw"><?php if ($previous != null) { ?><a  href="<?php echo base_url(); ?>mobile/object/<?php echo $previous; ?>"><i class="fa fa-arrow-left"></i></a><?php
                    } else {
                        echo '&nbsp;';
                    }
                    ?></div>
            <div class="l-1 nopad">&nbsp;</div>
            <div class="l-1 text-r nopad"  style="font-size:7vw"> <?php if ($next != null) { ?><a href="<?php echo base_url(); ?>mobile/object/<?php echo $next; ?>"><i class="fa fa-arrow-right" style="margin-right:2vw"></i></a><?php
            } else {
                echo '&nbsp;';
            }
                    ?></div>
        </div>
    </div>
</header>

<?php
//echo '<pre>';
//print_r($car);

if (isset($car->mediaFile)) {
        $remoteFile = $car->mediaFile;
        $objectFile = explode(",", $remoteFile);
}


?>

<section class="container1 bg-white">
    <div class="row">
        <div class="l-12 objhead">
            <div class="l-12 text-l nopad">
<?php if (isset($car->brand)) {
    echo $car->brand;
} ?> <?php if (isset($car->model)) {
    echo $car->model;
} ?> <?php if (isset($car->type)) {
    echo $car->type;
} ?><br />
                <span class="theme-col"><i class="fa fa-eur"></i> <?php if (isset($car->showroompris)) {
    echo number_format($car->showroompris, 2, ',', '.');
} ?></span>
            </div>

        </div>
        <div class="l-12">
            <div id="sliderbox">
                <div id="largeImg">
                    <img style="opacity: 0.88;" id="Large" name="slide" src="<?php echo $objectFile[0]; ?>">
                    <div class="slider-btm">
                        <div id="leftAngle" class="theme-col">
                            <i class="fa fa-chevron-left"></i>   
                        </div>
                        <a onclick="myFunction()" target="_blank" class="midbtn theme-col" id="slideBtn">
                            <i class="fa fa-pause"></i>
                        </a>
                        <div id="rightAngle" class="theme-col">
                            <i class="fa fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div id="imageMenu">
                    <div style="position: relative; " id="img_menubar">
<?php foreach ($objectFile as $objsrc) { ?>
                            <img alt="No Image" class="selected" src="<?php echo $objsrc; ?>" />      
<?php } ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="l-12">
            <div class="accordion" id="accordion2">
                <div class="accordion-group">
                    <a onclick="collapse(1)" class="accordion-toggle" data-parent="#accordion2" href="#Omschrijving">
                        <div class="accordion-heading top-bar">
                            <span>Omschrijving</span>  
                            <i  id="collapse1" class="fa fa-chevron-up rblueup"></i>
                        </div>
                    </a>
                    <div style="display:block;" id="collapsefull1" class="accordion-body collapse in">
                        <div class="accordion-inner objdesc">                              
<?php echo $car->vrije_tekst; ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <a onclick="collapse(2)" class="accordion-toggle" data-parent="#accordion2" href="#Specificaties">
                        <div class="accordion-heading top-bar">
                            <span>Specificaties</span>  
                            <i  id="collapse2" class="fa fa-chevron-down rblueup"></i>
                        </div>
                    </a>

                    <div style="display:none;" id="collapsefull2" class="accordion-body collapse in">
                        <div class="accordion-inner objdesc">     
                            <table  width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody><tr>
                                        <td width="30%" class="bg_td">Prijs</td>
                                        <td width="30%" class="bg_td1"><i class="fa fa-eur"></i> <?php if (isset($car->showroompris)) {
    echo number_format($car->showroompris, 2, ',', '.');
} ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="bg_td">Merk</td> 
                                        <td width="30%" class="bg_td1"><?php if (isset($car->brand)) {
    echo $car->brand;
} ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>

                                    <tr>
                                        <td width="30%" class="bg_td">Model</td>
                                        <td width="30%" class="bg_td1"><?php if (isset($car->model)) {
    echo $car->model;
} ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>

                                    <tr>
                                        <td width="30%" class="bg_td">Type</td>
                                        <td width="30%" class="bg_td1"><?php echo $car->type;  ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="bg_td">Carrosserievorm</td>
                                        <td width="30%"  class="bg_td1"><?php if (isset($car->koetswerk)) {
    echo $car->koetswerk;
} ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="bg_td">Bouwjaar</td>
                                        <td width="30%" class="bg_td1"><?php if (isset($car->buildYear)) {
    echo $car->buildYear;
} ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>

                                    <tr>
                                        <td width="30%" class="bg_td">Transmissie</td>
                                        <td width="30%"  class="bg_td1"><?php if (isset($car->versnelling)) {
    echo $car->versnelling;
} ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>

                                    <tr>
                                        <td width="30%" class="bg_td">Kleur</td>
                                        <td width="30%"  class="bg_td1"><?php if (isset($car->kleur)) {
                                                echo $car->kleur;
                                            } ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="bg_td">BTW/Marge</td>
                                        <td width="30%"  class="bg_td1">
<?php
if (isset($car->marge)) {
    $marge = $car->marge;
    if ($marge == 'ja') {
        echo "Marge";
    } else {
        echo "BTW";
    }
}
?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="bg_td">Gewicht (leeg)</td>
                                        <td width="30%"  class="bg_td1"><?php  $car->massa-ledig-gewicht;  ?> kg</td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>

                                    <tr>
                                        <td width="30%" class="bg_td">Brandstof</td>
                                        <td width="30%"  class="bg_td1"><?php if (isset($car->brandstof)) {
    echo $car->brandstof;
} ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>

                                    <tr>
                                        <td width="30%" class="bg_td">APK datum</td>
                                        <td width="30%"  class="bg_td1">
<?php if (isset($car->APKdate)) {
    echo $car->APKdate;
} ?></td>
                                    </tr>
                                    <tr>
                                        <td height="10" style="border-right:none;"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="bg_td">Kilometerstand</td>
                                        <td width="30%" class="bg_td1"><?php if (isset($car->KMvalue)) {
                                    echo $car->KMvalue;
                                } ?> km</td>
                                    </tr>

                                </tbody></table>
                        </div>
                    </div>
                </div>

                <div class="accordion-group">
                    <a onclick="collapse(3)" class="accordion-toggle" data-parent="#accordion2" href="#Accessoires">
                        <div class="accordion-heading top-bar">
                            <span>Accessoires</span>  
                            <i id="collapse3" class="fa fa-chevron-down rblueup"></i>
                        </div>
                    </a>
                    <div style="display:none;" id="collapsefull3" class="accordion-body collapse in">
                        <div class="accordion-inner objdesc">     


                            <div id="descAcce" style="display: block;">
                                Accessoires information
                                    <?php
                                    echo $car->specsdefault;

                                    /*
                                      $specFabric = $car->specFabric;
                                      $specFabrics = explode(",", $specFabric);
                                      foreach ($specFabrics as $fabrics) {
                                      ?>
                                      <ul style="margin-left:0px;">
                                      <li width="30%" class="bg_td1"><?php echo $fabrics; ?></li>
                                      </ul>
                                      } */
                                    ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <a onclick="collapse(4)" class="accordion-toggle" data-parent="#Kaart" href="#Kaart">
                        <div class="accordion-heading top-bar">
                            <span>Kaart</span>  
                            <i id="collapse4" class="fa fa-chevron-down rblueup"></i>
                        </div>
                    </a>
                    <div style="display:none;" id="collapsefull4" class="accordion-body collapse in">
                        <div class="accordion-inner">     
                            <div id="descAcce" style="display: block;">

                                <div id="map_canvas">

<?php
$address = '';
$steet=$dealer[0]->street;
if($steet!=null){ $address=$address.$steet; }
$house_num=$dealer[0]->house_num;
if($house_num!=null){ $address=$address." ".$house_num; }
$house_num_addtion=$dealer[0]->house_num_addtion;
if($house_num_addtion!=null){ $address=$address." ".$house_num_addtion; }
$postal_code=$dealer[0]->postal_code;
if($postal_code!=null){ $address=$address." ".$postal_code; }
$city=$dealer[0]->city;
if($city!=null){ $address=$address." ".$city; }
$address = str_replace(" ", "+", $address);

$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
$output = json_decode($geocode);
$lat = $output->results[0]->geometry->location->lat;
$lng = $output->results[0]->geometry->location->lng;
?>
                                    <a onclick="geo()" ><img onclick="getLocation()" width="100%" src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $lat . "," . $lng; ?>&amp;zoom=15&amp;size=280x220&amp;maptype=roadmap&markers=color:orange%7C<?php echo $lat . "," . $lng; ?>&amp;sensor=false" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="navbar-fixed-bottom">
    <div class="row">
        <ul class="footer-nav">
            <li class="l-4 acties" ><a class="noeffect" data-toggle="modal" data-target="#acties" ><strong>Acties</strong></a></li>
            <li class="l-4 delen"><a class="noeffect" data-toggle="modal" data-target="#delen" ><strong>Delen</strong></a></li>
            <li class="l-4 contact"><a class="noeffect" data-toggle="modal" data-target="#contact" ><strong>Contact</strong></a></li>
        </ul>
    </div>
</footer>
</body>
<script type="text/javascript">
 
 
 
 
 
    var custom;
    custom = "0";
    $(function () {            
        
        $("#img_menubar img").click(function () {
            $obj = $(this);
            var imagePath = $obj.attr('src');
            console.log(custom);
            if (custom == 0) {
                //imagePath = imagePath.substr(0, imagePath.length-1) + 4;
            }
            $("#largeImg img#Large").attr('src', imagePath);
            $("#img_menubar img").removeClass('selected');
            $obj.addClass('selected');
            console.log($obj.width());
        });

        $("#leftAngle").click(function () {
            var prevElement = $("img.selected").prev();
            if (prevElement[0] != undefined) {
                $("img.selected").removeClass('selected');
                prevElement.addClass('selected');
                selectedImg = $("img.selected").attr('src');
                if (custom == 0) {
                    //selectedImg = selectedImg.substr(0, selectedImg.length-1) + 4;
                }
                $("#largeImg img#Large").attr('src', selectedImg);
                $("#img_menubar").css('position', 'relative');
                var leftShift = $("img.selected").width();
                $("#img_menubar").animate({'left': '+=' + (leftShift + 5)});
            } else {
                $("#img_menubar").css('position', 'relative');
                $("#img_menubar").animate({'left': 0});
            }
            return false;
        });

        $("#rightAngle").click(function () {
            var nextElement = $("img.selected").next();
            if (nextElement[0] != undefined) {
                $("img.selected").removeClass('selected');
                nextElement.addClass('selected');
                selectedImg = $("img.selected").attr('src');
                if (custom == 0) {
                    //selectedImg = selectedImg.substr(0, selectedImg.length-1) + 4;
                }
                $("#largeImg img#Large").attr('src', selectedImg);
                $("#img_menubar").css('position', 'relative');
                var leftShift = $("img.selected").width();
                $("#img_menubar").animate({'left': '-=' + (leftShift + 5)});
                console.log(leftShift);
            } else {
                $("#img_menubar").css('position', 'relative');
                $("#img_menubar").animate({'right': 0});
            }
            return false;
        });
        function resize()
        {
            var imageHeight = window.screen.height;
            if (imageHeight == 1280)
            {
                $("#largeImg img#Large").height(parseInt(imageHeight / 5));

            } else if (imageHeight == 800)
            {
                $("#largeImg img#Large").height(parseInt(imageHeight / 2));
            }
        }

        var navigatorTxt = navigator.userAgent;


    });
</script>    

<script type="text/javascript">
$( document ).ready(function() {
    myFunction();
});
<?php $s = 1;
foreach ($objectFile as $objsrc) { ?>
        var image<?php echo $s; ?> = new Image()
        image<?php echo $s; ?>.src = "<?php echo $objsrc; ?>"
    <?php $s++;
} ?>

    //  var image1 = new Image()
    // image1.src = "http://app.imoby.nl/fileserver/bofiles/downloads/91618/10168533/26367131.jpg"
        

    var element = document.getElementById("Large");
    var duration = 3000;
    var hidtime = 0;
    var showtime = 2000;

    function SetFade(Fade) {
        element.style.opacity = Fade;
        element.style.MozOpacity = Fade;
        element.style.KhtmlOpacity = Fade;
        element.style.filter = 'alpha(opacity=' + (Fade * 100) + ');';
    }

    function fadeOut() {
        if (stop != 1) {
            for (i = 0; i <= 1; i += 0.01) {
                setTimeout("SetFade(" + (1 - i) + ")", i * duration);
            }
            setTimeout("slideit()", (duration + hidtime));
        }
    }
    function FadeIn() {
        for (i = 0; i <= 1; i += 0.01) {
            setTimeout("SetFade(" + i + ")", i * duration);
        }
        setTimeout("fadeOut()", (duration + showtime));
    }

    var step = 0
    var stop = 1

    function slideit() {
        //if browser does not support the image object, exit.
        if (!document.images)
            return

        if (step < 5)
            step++
        else
            step = 1
        document.images.slide.src = eval("image" + step + ".src")
        FadeIn()
    }

    //slideit()

    function myFunction()
    {
        if (stop == 1) {
            document.getElementById("slideBtn").innerHTML = "<i class='fa fa-pause'></i>";
            stop = 0
            slideit()
        }
        else {
            document.getElementById("slideBtn").innerHTML = "<i class='fa fa-play'></i>";
            stop = 1
        }
    }

    function map(){
        // alert('hello');
        // window.location='http://maps.google.com/?q=+<?php echo $dealer[0]->street; ?>+,+<?php echo $dealer[0]->city; ?>+&z=16';
    }
</script>
<script>
    function collapse(x){  
        $( "#collapse"+x ).toggleClass("fa-chevron-up","fa-chevron-down");
        $( "#collapse"+x ).toggleClass("fa-chevron-down","fa-chevron-up");
        $( "#collapsefull"+x ).slideToggle( "slow", function() {
            // Animation complete.
        }); 
         
    }
    function geo(){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successFunction);
        } else {
            alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
        }
    }
function successFunction(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    console.log('Your latitude is :'+lat+' and longitude is '+lng);
    var url="http://maps.google.com/?saddr="+lat+","+lng+"&daddr=<?php echo $lat . "," . $lng; ?>";
    window.open(url, '_blank');
}
</script>


</div>
<?php echo $footer; ?>