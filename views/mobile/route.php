<?php include('layout/header2.php'); ?>
<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-1 nopad">
                <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-10">
                <span class="single-page-title">Route</span>
            </div>                
            <div class="l-1"></div>
        </div>	

    </div>
</header>

<section>
    <div id="list-view" class="container1 commonpage">
        <div class="row">
            <div class="col-lg-12 googleMap nopad">
                <div id="map_canvas">
                    <?php
                    $address = '';
                    $steet = $informatie[0]->street;
                    if ($steet != null) {
                        $address = $address . $steet;
                    }
                    $house_num = $informatie[0]->house_num;
                    if ($house_num != null) {
                        $address = $address . " " . $house_num;
                    }
                    $house_num_addtion = $informatie[0]->house_num_addtion;
                    if ($house_num_addtion != null) {
                        $address = $address . " " . $house_num_addtion;
                    }
                    $postal_code = $informatie[0]->postal_code;
                    if ($postal_code != null) {
                        $address = $address . " " . $postal_code;
                    }
                    $city = $informatie[0]->city;
                    if ($city != null) {
                        $address = $address . " " . $city;
                    }
             $address = str_replace(" ", "+", $address);

                    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false');
                    $output = json_decode($geocode);
                    $lat = $output->results[0]->geometry->location->lat;
                    $lng = $output->results[0]->geometry->location->lng;
                    ?>


                    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                    <script type="text/javascript">

                        var geocoder = new google.maps.Geocoder();
                        var address = "<?php echo $informatie[0]->street; ?> <?php echo $informatie[0]->house_num; ?> <?php echo $informatie[0]->city; ?> <?php echo $informatie[0]->postal_code; ?>  Netherlands";

                        geocoder.geocode( { 'address': address}, function(results, status) {

                            if (status == google.maps.GeocoderStatus.OK) {
                                var latitude = results[0].geometry.location.lat();
                                var longitude = results[0].geometry.location.lng();
                                //alert(latitude);
                                var url="//maps.googleapis.com/maps/api/staticmap?center="+latitude+"+"+longitude+"&zoom=16&size=400x400&markers=color:red%7C"+latitude+","+longitude+" ";
                                // alert(url);
                                var url2 = "http://maps.google.com/?saddr="+latitude+","+longitude+"&daddr=<?php echo $lat . "," . $lng; ?>";
                                $('img#myurl').attr('src',url);
                                $('a#urlloc').attr('href',url2);
                            } 
                        }); 
                    </script>

                    <a id="glink" target="_blank"  > 
                        <img  width="100%" id="myurl" alt="loading" src="" />
                    </a>
                </div>
                <p class="text-c">Klik op de kaart voor een routebeschrijving</p>
            </div>
        </div>
<?php include('layout/footer2.php') ?>
    </div>
</section>
<script>
$(window).bind("load", function() {
   geo();
});
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
    $("#glink").attr("href", url)
    //window.open(url, '_blank');
}
</script>
</body>
</html>
