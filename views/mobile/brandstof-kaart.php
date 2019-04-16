<?php echo $header; ?>
</head>
<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-1 nopad">
                <a  href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply back"></i></a>
            </div>
            <div class="l-10">
                <span class="single-page-title">Brandstof</span>
            </div>                
            <div class="l-1 nopad-r" onclick="search()"  ><a class="noeffect right" onclick="search()" ><i class="fa fa-search"></i></a></div>                
        </div>
    </div>
</header>	


<section>
    <div class="container1 bg-white">
        <div class="row">

            <!-- brandstof google api map---->
            <?php
            if (isset($_GET['city'])) {
                $address = $_GET['city'];
                $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false');
                $output = json_decode($geocode);
                $lat = $output->results[0]->geometry->location->lat;
                $lng = $output->results[0]->geometry->location->lng;
            } else {
                if (isset($_GET['lat'])) {
                    $lat = $_GET['lat'];
                    $lng = $_GET['lng'];
                } else {
                    $lat = 52.1955660;
                    $lng = 5.4346110;
                }
            }
            $json = file_get_contents("http://www.brandstof-zoeker.nl/stations.json?partner=imoby&latitude=" . $lat . "&longitude=" . $lng . "&radius=25");
            $obj = json_decode($json);
            $stations = $obj->station;
            // print_r($stations);
            //die();
            ?>

            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>    
            <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script>
            <script type="text/javascript" src="<?= base_url() ?>assets/markerwithlabel.js"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                    initMap();
                });
                function initMap() {
                    /* center lat and lng */
                    var latLng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>);
                    var map = new google.maps.Map(document.getElementById('map_canvas'), {
                        zoom: 12,
                        center: latLng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        panControl: false,
                        zoomControl: true,
                        mapTypeControl: false,
                        scaleControl: true,
                        streetViewControl: false,
                        overviewMapControl: false,
                        rotateControl: false
                    });
                    var brandstof  = localStorage.getItem('bandstof');
                   // alert(brandstof);
                    var merken  = localStorage.getItem('merken');
                    if (brandstof == null) {
                        brandstof = 'Euro 95';
                    }
                   
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>),
                        map: map,
                        icon: '<?= base_url() ?>assets/redbtn.gif'
                    });
                    google.maps.event.addListener(marker, "rightclick", function () {
                    });
                    google.maps.event.addListener(map, 'dragend', function (event) {
                        var c = map.getCenter();
                        lat = c.lat();
                        lng = c.lng();
                        mapurl = "<?= base_url() ?>mobile/brandstof/<?php echo $this->uri->segment(3); ?>/?lat=" + lat + "&lng=" + lng + "";
                        window.location.assign(mapurl);
                    });




<?php
$map = 0;
foreach ($stations as $station) {
    //print_r($station);

    $loclat = $station->latitude;
    $loclng = $station->longitude;
    $brandst = '';
    $brandstof = $station->brandstof;
    $address = $station->adres;
    $postcode = $station->postcode;
    $plaats = $station->plaats;
    $add = $address . " " . $postcode . " " . $plaats;
    
    
    $bandstofarray = 'var brandstofs = new Array(';
    $bandstofarrayprice = 'var brandstofsprice = new Array(';
    foreach ($brandstof as $key => $brst) {
        $brandst.=$key . " : " . $brst . "<br>";
        $bandstofarray.="'" . $key . "',";
        $bandstofarrayprice.="'" . $brst . "',";
    }
    $keten = $station->keten;

    $naam = $station->naam;
    $bandstofarray.= '" ");';
    $bandstofarrayprice.= '" ");';
    echo $bandstofarrayprice;
    echo $bandstofarray;
    ?>
            

                if (isInArray(brandstof, brandstofs)) {
                    
                    indexNumber = brandstofs.indexOf(brandstof);
                    pricevalue = (brandstofsprice[indexNumber]);

                    var marker<?php echo $map; ?> = new MarkerWithLabel({
                        icon: '<?= base_url() ?>assets/st.png',
                        position: new google.maps.LatLng(<?php echo $loclat; ?>,<?php echo $loclng; ?>),
                        map: map,
                        draggable: false,
                        raiseOnDrag: true,
                    });
                    var iw<?php echo $map; ?> = new google.maps.InfoWindow({
                        content: "<div class='fuelpriceblock'><div class='left'><input id='add<?php echo $map; ?>' type='hidden' value='<?php echo $add; ?>' /><input id='stationname<?php echo $map; ?>' type='hidden' value='<?php echo $naam; ?>' /><input id='stationlat<?php echo $map; ?>' type='hidden' value='<?php echo $loclat; ?>' /><input id='stationlng<?php echo $map; ?>' type='hidden' value='<?php echo $loclng; ?>' /><img id='logom<?php echo $map; ?>' onerror='imgError(this);' class='br-logo'  src = '<?= base_url() ?>assets/brandlogo/<?php echo $keten; ?>.png' /></div><div class='priceblock'><span>Literprijs</span><span class='euro-sine'>&#8364;</span><div class='fuel-price'>" + pricevalue + "</div></div><div class='div3 arrowdiv3' onclick='detail_map(<?php echo $map; ?>," + pricevalue + ")' ></div>"
                    });
                    google.maps.event.addListener(marker<?php echo $map; ?>, "click", function (e) {
                        iw<?php echo $map; ?>.open(map, this);
                    });
                }

    <?php
    $map++;
    }
    ?>
    }

    function detail_map(x, price, name) {
        //console.log(x);
        var logo = $('#logom' + x).attr('src');
        var stationnames = $('#stationname' + x).val();
        var citybrand = $('#add' + x).val();
        var lat = $('#stationlat' + x).val();
        var lng = $('#stationlng' + x).val();
        $('#singlelat').val(lat);
        $('#singlelng').val(lng);
        $('#stationlogo').attr("src", logo)
        $("#gassname").html(stationnames);
        $("#price").html(price);
        // var citybrand=address+' '+postcode+' '+city;
        $("#citybrand").html(citybrand);
        $("#map_canvas").css("display", "none");
        $("#lijst").css("display", "none");
        $("#Instellingen").css("display", "block");



    }

            </script>                    
            <!-- brandstof google api map---->
            <div id="search" style="display:none;">
                <div class="row">
                    <div class="Search-Box">                        
                        <form action="#" method="GET">
                            <input type="text" class="l-12" name="city" placeholder="Zoek op plaatsnaam" />                            
                        </form>
                    </div>            
                </div>
            </div>
            <div id="map_canvas"   style="height: 500px; width:100%;"></div>
            <div id="lijst" class="l-12 googleMap2 nopad" style="display:none;" >
                <div class="row top-con">
                    <input type="hidden" id="tab1" value="0" />
                    <input type="hidden" id="tab2" value="0" />
                    <div id="literprijs" class="l-6 afstand" onclick="tab1('literprijs')">Literprijs</div>
                    <div id="afstand" class="l-6 literprijs" onclick="tab2('afstand')">Afstand</div>
                </div>
                <div class="l-12" style="background:white; min-height:500px; padding:0px;">

                    <ul class="listbrandstof">
                        <?php
                        $brands = array();
                        $fual = array();
                        foreach ($stations as $station) {
                            $brand = $station->keten;
                            if ($brand != null) {
                                if (in_array($brand, $brands, true)) {
                                    
                                } else {
                                    $brands[] = $brand;
                                }
                            }
                            $map = 0;
                            $loclat = $station->latitude;
                            $loclng = $station->longitude;
                            $brandst = '';
                            $brandstof = $station->brandstof;
                            $distance = $station->distance;
                            $naam = $station->naam;
                            $plaats = $station->plaats;
                            $keten = $station->keten;
                            foreach ($brandstof as $key => $brst) {
                                $brandst.=$key . " : " . $brst . "<br>";
                                if ($key != null) {
                                    if (in_array($key, $fual, true)) {
                                        
                                    } else {
                                        $fual[] = $key;
                                    }
                                }
                            }
                            if ((!empty($keten)) && (!empty($plaats))) {
                                
                            }
                        }
                        ?>                                  

                    </ul>
                    <div class="row text-c" style="padding-bottom: 28px;">
                        <div class="l-12  copy_right">
                            Copyright  Imoby B.V.
                        </div>
                    </div>
                </div>

            </div>
            <div id="Instellingen" class="l-12 googleMap2 nopad" style="display:none;" >
                <div class="l-12 info-text nopad">
                    <div class="l-12" style="background:white;min-height:500px;padding:0px;">
                        <ul class="product-detailes">
                            <li class="row nopad">
                                <div class="l-1">&nbsp;</div>
                                <div class="l-2">
                                    <img id="stationlogo" src="">
                                </div>
                                <div class="l-8">
                                    <span class="" id="gassname"></span>
                                </div>
                                <div class="l-1">&nbsp;</div>
                            </li>
                            <li id="citybrand"></li>
                            <li>Literprijs:</li>
                            <li id="price">&#163; </li>         
                        </ul>
                        <input type="hidden" id="mylat" value='<?php echo $lat; ?>' />
                        <input type="hidden" id="mylng" value='<?php echo $lng; ?>' />
                        <input id="singlelat" type="hidden" value="lat" /> 
                        <input id="singlelng" type="hidden" value="lng" /> 
                        <div class="row">
                            <div class="l-1">&nbsp;</div>
                            <div class="l-10 route-bepalen"><a id="direction" onclick="getLocation()"  >Route bepalen</a></div>
                            <div class="l-1">&nbsp;</div>
                        </div>
                        <div class="row text-c">
                            <div class="l-12  copy_right">
                                Copyright Imoby B.V.
                            </div>
                        </div>
                    </div>                   
                </div>               

            </div>    
        </div>

        <div id="setting" class="l-12 googleMap2 nopad" style="display:none;" >
            <div class="l-12 info-text nopad">
                <div class="l-12 commonpage">
                    <ul class="setting-div">                                                   
                        <li class="row"><label class="l-6"> Brandstof </label>
                            <select id="brandstof12" class="l-6">                               
                                <?php foreach ($fual as $fuals) { ?>
                                    <option value="<?php echo $fuals; ?>"><?php echo $fuals; ?></option>
                                <?php } ?>
                            </select>
                        </li>                             
                        <li class="row"><label class="l-6"> Merken </label>
                            <select id="merken12" class="l-6">
                                <option value="all">Alle merken</option>
                                <?php foreach ($brands as $bra) { ?>
                                    <option value="<?php echo $bra; ?>"><?php echo $bra; ?></option>
                                <?php } ?>
                            </select>
                        </li>                                                   
                    </ul>
                    <div class="row">
                        <div class="l-12 route-bepalen"><a onclick="savesetting()">Opslaan</a></div>
                    </div>
                    <div class="row text-c" >
                        <div class="l-12  copy_right">
                            Copyright Imoby B.V.
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
            <li class="l-4 acties" ><a  class="noeffect" onclick="kaart()" ><strong>Kaart</strong></a></li>
            <li class="l-4 delen"><a class="noeffect"  onclick="lijst()"  ><strong>Lijst</strong></a></li>
            <li class="l-4 contact"><a class="noeffect"  onclick="setting()"  ><strong>Instellingen</strong></a></li>
        </ul>
    </div>
</footer>
<style>

</style>
<script src="<?= base_url() ?>assets/mobile/js/jquery.min.js"></script>
<script>
    function log(h) {
        document.getElementById("log").innerHTML += h + "<br />";
    }
    function isInArray(value, array) {
        return array.indexOf(value) > -1;
    }
    function kaart() {
        $("#map_canvas").css("display", "block");
        $("#lijst").css("display", "none");
        $("#Instellingen").css("display", "none");
        $("#setting").css("display", "none");
        $(".fa-search").css("display", "block");
        $(".back").css("display", "block");
    }
    function lijst() {
        console.log('list');
        $("#map_canvas").css("display", "none");
        $("#lijst").css("display", "block");
        $("#Instellingen").css("display", "none");
        $("#setting").css("display", "none");
        $(".fa-search").css("display", "none");
        $(".back").css("display", "block");

        /* ajax operation start here */
        var result = '';
                        
        var merken = localStorage.getItem('merken');
        var brandstof = localStorage.getItem('bandstof');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>mobile/brandstoflistajax",
            data: {merken: merken, brandstof: brandstof, lat: '<?php echo $lat; ?>', lng: '<?php echo $lng; ?>'}
        })
        .done(function (msg) {
            // console.log(msg);
            var obj = jQuery.parseJSON(msg);
            var id = 0;
            $.each(obj, function (key, val) {
                console.log(val);
                var array = val.split('|');
                console.log(array[1]);
                $("img").error(function () {
                    $(this).hide();
                });
                var sing = '<li data-position="' + array[0] + '" data-pposition="' + array[3] + '" >'
                    + '<div class="row">'
                    + '<div class="l-2 con-icon">'
                    + '<img id="logo' + id + '" onerror="imgError(this);" alt="NO LOGO" src="<?php echo base_url(); ?>assets/brandlogo/' + array[1] + '.png"></div>'
                    + '<div  class="l-5 price-detailes ">'

                    + '<input id="stationname' + id + '" type="hidden" value="' + array[2] + '" />'
                    + '<input id="city' + id + '" type="hidden" value="' + array[4] + '" />'
                    + '<input id="address' + id + '" type="hidden" value="' + array[8] + '" />'
                    + '<input id="postcode' + id + '" type="hidden" value="' + array[9] + '" />'
                    + '<input id="lat' + id + '" type="hidden" value="' + array[6] + '" />'
                    + '<input id="long' + id + '" type="hidden" value="' + array[7] + '" />'
                    + '<strong id="price' + id + '" > &#8364; ' + array[0] + '</strong>'
                    + '<span id="gas' + id + '">' + array[1] + '</span><span id="city' + id + '">' + array[4] + '</span></div>'
                    + '<div class="l-4 kmp" id="dis' + id + '">' + array[3] + ' km</div>'
                    + '<div class="l-1">'
                    + '<a onclick="detail(' + id + ')" class="detailes-calss">Details</a></div>'
                    + '</div></li>';
                id++;
                result = result + sing;

            });
            $(".listbrandstof").html(result);
        });
        /* ajax operation end here */
    }

    function sort_li(a, b) {
        return ($(b).data('position')) < ($(a).data('position')) ? 1 : -1;
    }
    function psort_li(a, b) {
        return ($(b).data('pposition')) < ($(a).data('pposition')) ? 1 : -1;
    }



    function tab1(id) {
        var tab1 = $('#tab1').val();
        var tab2 = $('#tab2').val();
        if (tab1 == 0) {
            $(".listbrandstof li").sort(sort_li).appendTo('.listbrandstof');
            searchby = 'P';
            var searchby;
            if (id == "literprijs") {
                $('#literprijs').removeClass("afstand");
                $('#literprijs').addClass("literprijs");
                $('#afstand').removeClass("literprijs");
                $('#afstand').addClass("afstand");

            }
            $('#tab1').val(2);
            if (tab2 == 0) {
            } else {
                $('#tab2').val(0);
            }
        }
    }




    function tab2(id) {
        var tab1 = $('#tab1').val();
        var tab2 = $('#tab2').val();

        if (tab2 == 0) {
            $(".listbrandstof li").sort(psort_li).appendTo('.listbrandstof');
            var searchby;

            if (id == "afstand") {
                $('#literprijs').removeClass("literprijs");
                $('#literprijs').addClass("afstand");
                $('#afstand').removeClass("afstand");
                $('#afstand').addClass("literprijs");
                searchby = 'D';

            }
            $('#tab2').val(2);
            if (tab1 == 0) {
            } else {
                $('#tab1').val(0);
            }
        }
    }

    function detail(x) {
        var logo = $('#logo' + x).attr('src');
        var price = $('#price' + x).html();
        var stationnames = $('#stationname' + x).val();
        var city = $('#city' + x).val();
        var address = $('#address' + x).val();
        var postcode = $('#postcode' + x).val();
        var lat = $('#lat' + x).val();
        console.log(lat);
        var lng = $('#long' + x).val();
        console.log(lng);
        $('#singlelat').val(lat);
        $('#singlelng').val(lng);
        $('#stationlogo').attr("src", logo)
        $("#gassname").html(stationnames);
        $("#price").html(price);
        var citybrand = address + ' ' + postcode + ' ' + city;
        $("#citybrand").html(citybrand);
        $("#map_canvas").css("display", "none");
        $("#lijst").css("display", "none");
        $("#Instellingen").css("display", "block");
        $(".back").css("display", "none");


    }

    function getLocation() {



        var mylat = $('#mylat').val();
        var mylng = $('#mylng').val();

        var lng = $('#singlelng').val();
        var lat = $('#singlelat').val();
        var url = "http://maps.google.com/?saddr=" + mylat + "," + mylng + "&daddr=" + lat + "," + lng + "";
        // alert(url);

        window.open(url, '_blank');
    }


    function imgError(image) {
        image.onerror = "";
        image.src = "<?php echo base_url(); ?>assets/st-gr_1.png";
        return true;
    }

    function Instellingen() {
        $("#map_canvas").css("display", "none");
        $("#lijst").css("display", "none");
        $("#Instellingen").css("display", "block");
        $("#setting").css("display", "none");
        $(".fa-search").css("display", "none");
    }
    function setting() {
        $("#map_canvas").css("display", "none");
        $("#lijst").css("display", "none");
        $("#Instellingen").css("display", "none");
        $("#setting").css("display", "block");
        var brandstof  = localStorage.getItem('bandstof');
        var merken  = localStorage.getItem('merken');
        // alert(brandstof);
        $('#brandstof12').val(brandstof).attr("selected");
        $('#merken12').val(merken).attr("selected");
        
        
    }
    function details(stationname, price) {
        $("#stationname").html(stationname);
        $("#price").html(price);
        $("#map_canvas").css("display", "none");
        $("#lijst").css("display", "none");
        $("#Instellingen").css("display", "block");
    }
    function search() {
       
        $("#search").toggle('slow');
    }
    function savesetting() {
        var bandstof = $("#brandstof12").val();
        var merken = $("#merken12").val();
        localStorage.setItem('bandstof',bandstof);
        localStorage.setItem('merken',merken);
        var bandstof = localStorage.getItem('bandstof');
        var merken = localStorage.getItem('merken');
        //alert(bandstof);
        //document.cookie = "bandstof=" + bandstof + "";
        //document.cookie = "merken=" + merken + "";
        //var cookiesdata = document.cookie;
        alert("Uw instellingen zijn succesvol opgeslagen.");
        location.reload();
    }
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(name) == 0)
                return c.substring(name.length, c.length);
        }
        return "";
    }
    
    
    $( document ).ready(function() {
        var brandstof  = localStorage.getItem('bandstof');
        var merken  = localStorage.getItem('merken');
        // alert(brandstof);
        $('#brandstof12').val(brandstof).attr("selected");
        $('#merken12').val(merken).attr("selected");
    });    
    



</script>

<?php echo $footer; ?>
