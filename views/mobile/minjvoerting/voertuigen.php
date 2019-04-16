<?php echo $header; ?>
<!------------------------------popup-------------------------------->
<!-- Modal -->    
<div class="modal fade" id="one" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">              
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Afspraak maken</h4></div>
                <div class="l-2 nopad">
					<button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
					
				</div>
            </div>

            <div class="modal-body">
				<input type="text" placeholder="Datum" />
				<input type="text" placeholder="Datum" />
				<select>
					<option>Type afspraak</option>
				</select>
				<textarea></textarea>
				<input type="submit" value="Verstuur" class="form-control button" >
            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 

<!-- Modal -->    
<div class="modal fade" id="two" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">              
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Notitie maken</h4></div>
                <div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>

            <div class="modal-body">
				<textarea placeholder="Notitie"></textarea>
				<input type="submit" value="Verstuur" class="form-control button" >
            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 


<!-- Modal -->    
<div class="modal fade" id="three" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header row">              
                <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Document uploaden</h4></div>
                <div class="l-2 nopad"><button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>

            <div class="modal-body">
				<input type="submit" value="Document uploaden" class="form-control" id="form-one">
				<input type="text" placeholder="Datum" />
				<input type="submit" value="Verstuur" class="form-control" id="form-one">
            </div>

        </div>
    </div>
</div>     
<!-- Modal --> 



<!------------------------------popup-------------------------------->

<header class="top">
    <div class="row nav-view">
        <div class="container1">
            <div class="l-1 nopad">
                <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-reply"></i></a>
            </div>
            <div class="l-10">
                <span class="single-page-title">Mijn voertuig voe</span>
            </div>                
            <div class="l-1 nopad">
                <a href="<?= base_url(); ?>mobile/home/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-home"></i></a>
            </div>           
        </div>
    </div>
</header>		
<section>
    <div class="container1 commonpage">
        <form get="" method="" class="login-registration">
            <div class="row">
                <div class="l-12 selectnav">
                    <select class="border-1" id="brand">
                        <option value="">Merk Model</option>
                        <option value="95">1.6-16V Expression Sport | 79-HX-VA</option>              
                        <option value="96">SCIROCCO | 36-LDS-4</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="row bg-white list-view">
                    <div class="l-5 img-block">
                        <a href="#" >
                            <img src="<?php echo base_url(); ?>/assets/images/car-7.jpg" alt="#">
                        </a>
                    </div>
                    <div class="l-7 list-content">
                        <div class="carlistdetails">
                            <span class="autoType">1.6-16V Expression Sport</span>
                            <span class="autoKenteken">79-HX-VA</span>
                            <label class="autoKenteken">Bouwjaar: 2015 </label>
                            <div style="line-height:20px;margin:-7px 0 20px;">Status:
                                <div id="auto_actief" class="checkBoxSlider auto_actief right">
                                    <button type="button" class="radioSliderTrue auto_actief radioSliderActive <?php /* echo ( ($auto->auto_actief == '1') ? 'radioSliderActive' : 'radioSliderInactive'); */ ?> ">aan</button>
                                    <button type="button" class="radioSliderFalse auto_actief radioSliderInactive <?php /* echo ( ( ($auto->auto_actief == '0') OR empty($auto->auto_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); */ ?>">uit</button><br />
                                    <input type="radio" name="auto_actief" class="radioSliderOn auto_actief" value="1" <?php /* echo ($auto->auto_actief == '1' ? 'checked="checked"' : ''); */ ?> />
                                    <input type="radio" name="auto_actief" class="radioSliderOff auto_actief" value="0" <?php /* echo ( ( ($auto->auto_actief == '0') OR empty($auto->auto_actief) ) ? 'checked="checked"' : ''); */ ?> />
                                </div>
                            </div>
                        </div>                        
                    </div>   
                    <br>
                </div>
            </div>
            <div class="row button-box">
                <a class="noeffect" data-toggle="modal" data-target="#one"   ><input type="submit"   value="Afspraak maken" /></a>
                <a class="noeffect" data-toggle="modal" data-target="#two"  ><input type="submit" data-toggle="modal" data-target="#email" class="button"  value="Notitie maken" /></a>
                <a class="noeffect" data-toggle="modal" data-target="#three"  ><input type="submit" data-toggle="modal" data-target="#email" class="button"  value="Document uploaden" /></a>
            </div>
            <div class="row">
                <div class="accordion" id="accordion">
                    <div class="accordion-group">
                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(10)">
                            <div class="accordion-heading top-bar">
                                <span>Kenmerken</span>  
                                <i class="fa rblueup fa-chevron-up" id="collapse10"></i>
                            </div>
                        </a>
                        <div class="accordion-body collapse in" id="collapsefull10" style="display: block;">
                            <table>
                                <thead>
                                </thead>
                                <tbody>
                                    <tr><td>Merk:</td><td>Volkswagen</td></tr>
                                    <tr><td>Type:</td><td>Golf GTI</td></tr>
                                    <tr><td>Transmissie:</td><td>Automaat</td></tr>
                                    <tr><td>randstof:</td><td>Benzine</td></tr>
                                    <tr><td>KM stand:</td><td>23.456</td></tr>
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(12)">
                            <div class="accordion-heading top-bar">
                                <span>Onderhoud</span>  
                                <i class="fa rblueup fa-chevron-down" id="collapse12"></i>
                            </div>
                        </a>
                        <div class="accordion-body collapse in" id="collapsefull12" style="display: none;">
                            <table>
                                <thead>
                                </thead>
                                <tbody>
                                    <tr><td>Merk:</td><td>Volkswagen</td></tr>
                                    <tr><td>Type:</td><td>Golf GTI</td></tr>
                                    <tr><td>Transmissie:</td><td>Automaat</td></tr>
                                    <tr><td>randstof:</td><td>Benzine</td></tr>
                                    <tr><td>KM stand:</td><td>23.456</td></tr>
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </form>
        <?php include('layout/footer2.php') ?>
    </div>
</section>            


<style type="text/css">
    select.border-1{
        border: 1px solid #cfcfcf; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;
    }
    table{ width: 100%;}
    table thead{ background: #d6d6d6;}
    table thead tr{}
    table thead tr th{ text-align: left; padding: 2.4vw 2vw;}
    table thead tr th:last-child{ width: 65%;}
    table tbody{}
    table tbody tr td{}
    table tbody tr td{ padding: 1vw 2vw; font-size: 3.5vw;}
    table thead tr td:last-child{ color: red; width: 20%;}
    .button-box{}
    .button-box input{ margin-bottom: 2.5vw; font-weight: bold;}
    .checkBoxSlider {
        background: #00afd8 none repeat scroll 0 0;
        border: 1px solid #a9a9a9;
        border-radius: 5px;
        height: 23px;
        position: relative;
        width: 72px;
    }
    .checkBoxSlider button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #fff;
    }
    .checkBoxSlider .radioSliderTrue {
        height: 25px;
        left: 0;
        padding: 0;
        position: absolute;
        top: -3px;
        width: 38px;
    }
    .checkBoxSlider .radioSliderFalse {
        height: 25px;
        padding: 0;
        position: absolute;
        right: 0;
        top: -3px;
        width: 38px;
    }
    .radioSliderInactive, .radioSliderInactive {
        cursor: pointer;
    }
    .checkBoxSlider .radioSliderFalse.radioSliderInactive {
        right: -1px;
    }
    .checkBoxSlider .radioSliderTrue.radioSliderInactive {
        left: -1px;
    }
    .checkBoxSlider .radioSliderActive {
    }
    .checkBoxSlider .radioSliderInactive {
        background: #ffffff none repeat scroll 0 0;
        border: 1px solid #a9a9a9;
        border-radius: 5px;
        height: 23px;
        top: -1px;
        width: 38px;
    }
    .checkBoxSlider .radioSliderOn, .checkBoxSlider .radioSliderOff {
        display: none;
    }
    .contentBlock form table tr td a:link, .contentBlock form table tr td a:visited {
        color: #195d82;
        text-decoration: underline;
    }
    .contentBlock form table tr td a:hover, .contentBlock form table tr td a:active {
        text-decoration: none;
    }

</style>


<script>
    function collapse(x) {
        $("#collapse" + x).toggleClass("fa-chevron-up", "fa-chevron-down");
        $("#collapse" + x).toggleClass("fa-chevron-down", "fa-chevron-up");
        $("#collapsefull" + x).slideToggle("slow", function () {
            // Animation complete.
        });

    }
    function geo() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successFunction);
        } else {
            alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
        }
    }
    function successFunction(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        console.log('Your latitude is :' + lat + ' and longitude is ' + lng);
        var url = "http://maps.google.com/?saddr=" + lat + "," + lng + "&daddr=<?php echo $lat . "," . $lng; ?>";
        window.open(url, '_blank');
    }
</script>
<?php echo $footer; ?>