<?php echo $header; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/crmAssets/css/jquery-ui-1.10.3.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/jquery-ui-1.10.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/jquery-ui-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/jquery.ui.datepicker-nl.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/crm.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/klanten.js?ts=1445347208"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/crmAssets/js/autos.js?ts=1445347208"></script>

<div class="main">
    <!----------------------------------------------mid part start --------------------------------------> 
    <div id="swipeable-2" class="tab-swipeable">
        <header class="top">
            <div class="row nav-view">
                <div class="container1">
                    <div class="l-8 nopad-l">
                        <div class="l-6 text-center zoeken nopad-l">
                            <a href="<?php echo base_url(); ?>mobile/home/1234570"><i class="fa fa-reply"></i></a>
                        </div>
                        <div class="l-3 home">

                        </div>
                        <div class="l-3" >

                        </div>
                    </div>
                    <div class="l-4 infotab nopad-r">

                        <div class="l-4 grid">
                            <a id="view-grid" href="#">&nbsp;</i></a>
                        </div>
                        <div class="l-8 rightnav nopad-r">
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section>    
            <div class="container1 commonpage totaal-anbod">
                <div class="row">
                    <input onclick="swip_next(3, 2)" type="submit" value="Mijn Voetuigen" />
                    <input onclick="swip_next(4, 2)" type="submit" value="Mijn instellingen" />
                    <input onclick="swip_next(5, 2)" type="submit" value="Mijn afspraken" />
                    <input onclick="" type="submit" value="Uitloggen" />
                </div>
            </div>
        </section>
    </div>                
    <!----------------------------------------------mid part end-------------------------------------->        




    <!----------------------------------------------afspraken-------------------------------------->
    <div id="swipeable-5" class="tab-swipeable" style="display:none;">
        <header class="top">
            <div class="row nav-view">
                <div class="container1">
                    <div class="l-12 nopad-l">
                        <a href="#"><i onclick="swip_pre(2, 5)" class="fa fa-chevron-left"></i><span></span></a>
                    </div>
                </div>
            </div>
        </header>
        <section>    
            <div class="container1 commonpage totaal-anbod">
                <div class="row">
                    <!-----------------1-------------------->
                    <section>
                        <table>
                            <thead>
                                <tr>
                                    <th>Datum</th>
                                    <th>Omschrijving</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Merk:</td><td>Volkswagen</td></tr>
                                <tr><td>Type:</td><td>Golf GTI</td></tr>
                                <tr><td>Transmissie:</td><td>Automaat</td></tr>
                                <tr><td>Brandstof:</td><td>Benzine</td></tr>
                                <tr><td>KM stand:</td><td>23.456</td></tr>
                            </tbody>
                            <tfoot></tfoot>
                        </table>     
                    </section>     

                    <!-----------------1-------------------->

                </div>
            </div>
        </section>
    </div>   
    <!----------------------------------------------afspraken end--------------------------------------> 









    <!----------------------------------------------Mijn instellingen start-------------------------------------->
    <div id="swipeable-4" class="tab-swipeable" style="display:none;">
        <header class="top">
            <div class="row nav-view">
                <div class="container1">
                    <div class="l-12 nopad-l">
                        <a href="#"><i onclick="swip_pre(2, 4)" class="fa fa-chevron-left"></i><span></span></a>
                    </div>
                </div>
            </div>
        </header>
        <section>    
            <div class="container1 commonpage totaal-anbod">
                <div class="row">
                    <!-----------------1-------------------->
                    <section>
                        <div class="">
                            <div class="row">
                                <div class="accordion" id="accordion">
                                    <div class="accordion-group">
                                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(10)">
                                            <div class="accordion-heading top-bar">
                                                <span>persoonlijke gegevens</span>  
                                                <i class="fa rblueup fa-chevron-up" id="collapse10"></i>
                                            </div>
                                        </a>
                                        <div class="accordion-body collapse in" id="collapsefull10" style="display: block;">
                                            <span class="dhr">Dhr.<input type="radio" /></span>
                                            <span class="mevr">Mevr.<input type="radio" /> </span>
                                            <input type="text" />
                                            <input type="text" />
                                            <input type="text" />
                                        </div>
                                    </div>

                                    <div class="accordion-group">
                                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(13)">
                                            <div class="accordion-heading top-bar">
                                                <span>E-mail meldingen</span>  
                                                <i class="fa rblueup fa-chevron-up" id="collapse13"></i>
                                            </div>
                                        </a>
                                        <div class="accordion-body collapse in" id="collapsefull13" style="display: block;">
                                            <label>
                                                Follow up na verkoop
                                                <div id="verkoop" class="checkBoxSlider verkoop right">
                                                    <button type="button" class="radioSliderTrue auto_actief radioSliderActive <?php /* echo ( ($auto->auto_actief == '1') ? 'radioSliderActive' : 'radioSliderInactive'); */ ?> ">aan</button>
                                                    <button type="button" class="radioSliderFalse auto_actief radioSliderInactive <?php /* echo ( ( ($auto->auto_actief == '0') OR empty($auto->auto_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); */ ?>">uit</button><br />
                                                    <input type="radio" name="auto_actief" class="radioSliderOn auto_actief" value="1" <?php /* echo ($auto->auto_actief == '1' ? 'checked="checked"' : ''); */ ?> />
                                                    <input type="radio" name="auto_actief" class="radioSliderOff auto_actief" value="0" <?php /* echo ( ( ($auto->auto_actief == '0') OR empty($auto->auto_actief) ) ? 'checked="checked"' : ''); */ ?> />
                                                </div>
                                            </label>
                                            <label>
                                                Follow up na onderhoud
                                                <div id="onderhoud" class="checkBoxSlider onderhoud right">
                                                    <button type="button" class="radioSliderTrue auto_actief radioSliderActive <?php /* echo ( ($auto->auto_actief == '1') ? 'radioSliderActive' : 'radioSliderInactive'); */ ?> ">aan</button>
                                                    <button type="button" class="radioSliderFalse auto_actief radioSliderInactive <?php /* echo ( ( ($auto->auto_actief == '0') OR empty($auto->auto_actief) ) ? 'radioSliderActive' : 'radioSliderInactive'); */ ?>">uit</button><br />
                                                    <input type="radio" name="auto_actief" class="radioSliderOn auto_actief" value="1" <?php /* echo ($auto->auto_actief == '1' ? 'checked="checked"' : ''); */ ?> />
                                                    <input type="radio" name="auto_actief" class="radioSliderOff auto_actief" value="0" <?php /* echo ( ( ($auto->auto_actief == '0') OR empty($auto->auto_actief) ) ? 'checked="checked"' : ''); */ ?> />
                                                </div>
                                            </label>

                                        </div>
                                    </div>                     



                                    <div class="accordion-group">
                                        <a href="#" data-parent="#accordion" class="accordion-toggle" onclick="collapse(14)">
                                            <div class="accordion-heading top-bar">
                                                <span>Accountgegevens</span>  
                                                <i class="fa rblueup fa-chevron-up" id="collapse14"></i>
                                            </div>
                                        </a>
                                        <div class="accordion-body collapse in" id="collapsefull14" style="display: block;">
                                            <input type="text" placeholder="Gebruikersnaam" />
                                            <input type="text" placeholder="Wachtwoord" />
                                            <input type="text" placeholder="Herhaal wachtwood" />
                                            <div class="row">
                                                <div class="l-3">&nbsp;</div>
                                                <div class="l-6"><input type="submit" name="" value="Opslaan" /></div>
                                                <div class="l-3">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>



                                </div> 
                            </div>



                        </div>
                    </section>     
                    <!-----------------1-------------------->
                </div>
            </div>
        </section>
    </div>   
    <!----------------------------------------------Mijn instellingen end--------------------------------------> 









    <!----------------------------------------------Mijn Voetuigen start-------------------------------------->


    <div id="swipeable-3" class="tab-swipeable" style="display:none;">
        <header class="top">
            <div class="row nav-view">
                <div class="container1">
                    <div class="l-12 nopad-l">
                        <a href="#"><i onclick="swip_pre(2, 3)" class="fa fa-chevron-left"></i><span></span></a>
                    </div>
                </div>
            </div>
        </header>
        <section>    
            <div class="container1 commonpage totaal-anbod">
                <div class="row">
                    <!-----------------1-------------------->
                    <!------------------------------popup-------------------------------->
                    <!-- Modal -->    
                    <div class="modal fade" id="one" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header row">              
                                    <div class="l-10 nopad"><h4 class="modal-title" id="myModalLabel">Afspraak maken</h4></div>
                                    <div class="l-2 nopad close-button">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>
                                </div>
                                <div class="modal-body">
                                    <input type="text" placeholder="Datum" />
                                    <input type="text" placeholder="Datum" />
                                    <label class="selectnav type-select">
                                        <select>
                                            <option>Type afspraak</option>
                                        </select>
                                    </label>
                                    <textarea class="maken-area"></textarea>
                                    <div class="row">
                                        <div class="l-6">&nbsp;</div>
                                        <div class="l-6 control-form">
                                            <input type="submit" value="Verstuur" class="form-control button" >
                                        </div>
                                    </div>
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
                                    <div class="l-10 nopad">
                                        <h4 class="modal-title" id="myModalLabel">Notitie maken</h4
                                        ></div>
                                    <div class="l-2 nopad close-button"><button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                        </button></div>
                                </div>

                                <div class="modal-body">
                                    <textarea class="notice-area" placeholder="Notitie"></textarea>
                                    <div class="row">
                                        <div class="l-6">&nbsp;</div>
                                        <div class="l-6 control-form"><input type="submit" value="Verstuur" class="form-control button" ></div>
                                    </div>
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
                                    <div class="l-2 nopad close-button">
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="l-6 control-form"> <input type="submit" value="Document uploaden" class="form-control" id="form-one"></div>
                                        <div class="l-6">&nbsp;</div>
                                    </div>
                                    <input type="text" placeholder="Datum" />
                                    <div class="row"> 
                                        <div class="l-6">&nbsp;</div>
                                        <div class="l-6 control-form"><input type="submit" value="Verstuur" class="form-control" id="form-one"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>     
                    <!-- Modal --> 
                    <!------------------------------popup-------------------------------->
                    <section>
                        <div class="mijnvoertuig">
                            <form get="" method="" class="login-registration">
                                <div class="row">
                                    <div class="l-12 selectnav">
                                        <select class="border-1" id="brand">
                                            <option value="">Merk Model</option>
                                            <option value="95">1.62-16V Expression Sport | 79-HX-VA</option>              
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
                                                <span class="autoType">Volkswagen Golf GTI</span>
                                                <span class="autoKenteken">121-ABC-23</span>
                                                <label class="autoKenteken">Bouwjaar: 2006 </label>
                                                <div class="status-div">Status:
                                                    <div id="klant_car" class="checkBoxSlider klant_car right">
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

                        </div>
                    </section>     

                    <!-----------------1-------------------->

                </div>
            </div>
        </section>
    </div>   
    <!----------------------------------------------Mijn Voetuigen end--------------------------------------> 
</div>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
       radioSlider('klant_car');
       radioSlider('verkoop');
       radioSlider('onderhoud');
    });

    function collapse(x) {
        $("#collapse" + x).toggleClass("fa-chevron-up", "fa-chevron-down");
        $("#collapse" + x).toggleClass("fa-chevron-down", "fa-chevron-up");
        $("#collapsefull" + x).slideToggle("slow", function () {
            // Animation complete.
        });

    }
    function swip_pre(pre, curr) {
        // console.log(id);           
        var target = 'swipeable-' + pre;
        var current = 'swipeable-' + curr;
        $('#' + target).show("slide", {direction: 'left'});
        $('#' + current).hide("slide", {direction: 'right'});

    }
    function swip_next(pre, curr) {
        var target = 'swipeable-' + pre;
        var current = 'swipeable-' + curr;
        $('#' + current).hide("slide", {direction: 'left'});
        $('#' + target).show("slide", {direction: 'right'});
    }
    $(".swip-previous").click(function () {
        var current = $(this).parent().attr('id');
        var result = current.split('-');
        var id = parseInt(result[1]) - parseInt(1);
        var target = 'swipeable-' + id;
        alert(target);
        $('#' + target).show("slide", {direction: 'left'});
        $('#' + current).hide("slide", {direction: 'right'});
    });

    $(".swip-next").click(function () {
        var current = $(this).parent().attr('id');
        var result = current.split('-');
        var id = parseInt(result[1]) + parseInt(1);
        var target = 'swipeable-' + id;

        $('#' + current).hide("slide", {direction: 'left'});
        $('#' + target).show("slide", {direction: 'right'});
    });
</script>        
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
    }
    .checkBoxSlider .radioSliderFalse {
    }
    .radioSliderInactive, .radioSliderInactive {
        cursor: pointer;
    }
    .checkBoxSlider .radioSliderFalse.radioSliderInactive {
    }
    .checkBoxSlider .radioSliderTrue.radioSliderInactive {
    }
    .checkBoxSlider .radioSliderActive {
    }
    .checkBoxSlider .radioSliderInactive {
        background: #ffffff none repeat scroll 0 0;
        border-radius: 5px;
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

<?php echo $footer; ?>