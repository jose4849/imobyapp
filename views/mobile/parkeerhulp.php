<?php echo $header; ?>
<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-1 nopad-l">
                <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-10">
                <span class="single-page-title">Parkeerhulp</span>
            </div>                
            <div class="l-1"></div>                
        </div>
    </div>
</header>		 


<!-- Modal -->    
<div class="modal fade" id="location" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">              
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Parkeerplaats opgeslagen.</h4></div>
                <div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>
            <div class="modal-body">
                <div class="DemoBS2">
                    <div class="panel-group" >
                        <div id="mapholder"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>     
<!-- Modal -->

<!-- Modal -->    
<div class="modal fade" id="parking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">              
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Route naar voertuig.</h4></div>
                <div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>
            <div class="modal-body">
                <div class="DemoBS2">
                    <div class="panel-group" >
                        <h4>Huidige positie (blauw) en parkeerplaats (rood).</h4>
                        <div id="parkingplace"></div>
                        <h4>Klik op de kaart voor de routebeschrijving.</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 
<!-- Modal -->    
<div class="modal fade" id="memo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">              
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Memo</h4></div>
                <div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>
            <div class="modal-body">
                <div class="DemoBS2">
                    <div class="panel-group" >
                        <form action="#"  >
                            <textarea onload="viewcookie()" id="memotext" name="cookievalue"></textarea>
                            <input type="submit" onclick="checkCookie()" value="Opslaan" />
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 


<section>
    <div class="container1 commonpage">    
        <div class="row target">
            <div class="l-2 text-c"><span class="icon-parkeerhulp"></span></div><div data-toggle="modal" data-target="#location" onclick="getLocation()"  class="l-10">Locatie opslaan</div>
        </div>
        <div class="row target">
            <div class="l-2 text-c"><span class="icon-parkeerhulp2"></span></div><div onclick="getparking()" data-toggle="modal" data-target="#parking" class="l-10">Route naar voertuig</div>
        </div>
        <div class="row target">
            <div class="l-2 text-c"><span class="icon-parkeerhulp3"></span></div><div onclick="viewcookie()" class="l-10" data-toggle="modal" data-target="#memo" >Memo</div>
        </div>	

        <?php include('layout/footer2.php') ?>
    </div>
</section>		

<script>
    var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        var latlon = position.coords.latitude + "," + position.coords.longitude;
        document.cookie="parkeenhulp="+latlon+"";
        var cookiesdata = document.cookie;      
        // alert("Uw instellingen zijn succesvol opgeslagen.");
        
        //alert(latlon);

        var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="
            + latlon + "&markers=color:red%7Clabel:A%7C" + latlon + "&zoom=16&size=400x400&sensor=false";
                                    
        var google_url = "http://maps.google.com/?q="+latlon+"&center="
            + latlon + "&markers=color:red%7Clabel:A%7C" + latlon + "&zoom=16&size=400x400&sensor=false";
    
        document.getElementById("mapholder").innerHTML = "<a href='"+google_url+"'><img src='" + img_url + "'></a>";
    }
    function showPositionpark(position) {
        var latlon = position.coords.latitude + "," + position.coords.longitude;
        alert(latlon);
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                break;
        }
    }


    function getparking() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(parking, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }
    function parking(position) {
        var latlon = position.coords.latitude + "," + position.coords.longitude;
        // var latlon = "23.8645647,90.3917683";
        var latlons=(getCookie('parkeenhulp'));
        // alert(latlon);
        //  alert(latlons);
        var url="http://maps.google.com/?saddr="+latlon+"&daddr="+latlons+"";
        $('#parkingplace').html('<a href="'+url+'" target="_blank"><img src="https://maps.googleapis.com/maps/api/staticmap?center='+latlon+'&zoom=14&size=400x400&maptype=roadmap&markers=color:blue%7Clabel:U%7C'+latlon+'&markers=color:green%7Clabel:A%7C'+latlons+'" /></a>');
        // $('#parkingplace').html('<a href="http://maps.google.com/?q=' + latlon + '&center=' + latlon + '&markers=color:blue%7Clabel:S%7C' + latlon + msg + '&zoom=16&maptype=roadmap"><img src="https://maps.googleapis.com/maps/api/staticmap?center=' + latlon + '&markers=color:blue%7Clabel:%7C' + latlon + latlons + '&zoom=16&size=1600x1300&maptype=roadmap" />');
        
        // "http://maps.googleapis.com/maps/api/staticmap?center="+latlons+"&zoom=14&markers=icon:http%3A%2F%2Ftinyurl.com%2F2ftvtt6|31.909440199627042,35.00186054020873|31.909440199627042,35.0000&sensor=false";
        /*console.log(latlon);
        $.ajax({
            type: 'POST',
            cache: false,
            url: "<?php echo base_url('mobile/parking'); ?>",
            data: {latlon: latlon},
            success: function(msg) {
                $('#parkingplace').html('<a href="http://maps.google.com/?q=' + latlon + '&center=' + latlon + '&markers=color:blue%7Clabel:S%7C' + latlon + msg + '&zoom=16&maptype=roadmap"><img src="https://maps.googleapis.com/maps/api/staticmap?center=' + latlon + '&markers=color:blue%7Clabel:%7C' + latlon + msg + '&zoom=16&size=1600x1300&maptype=roadmap" />');
            }
        });*/
    }

    /* 
                                 Seting cookies of parkeerhup start
     */


    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function checkCookie() {
        var user = $('#memotext').val();
        setCookie("memo", user, 30);
        console.log(user);
    }
    function eraseCookie(name) {
        setCookie("memo", '', 30);
    }
    function viewcookie() {
        console.log('hello');
        var memo = getCookie('memo');
        $('#memotext').val(memo);
    }
    $(document).ready(function() {
        viewcookie();
    });

    /* 
                                 Seting cookies of parkeerhup end
     */


</script>

<?php echo $footer; ?>