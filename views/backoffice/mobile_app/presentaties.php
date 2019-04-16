<?php $this->load->view('backoffice/layouts/header'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/popup.css') ?>" type="text/css" />
<style type="text/css">
    .car-img {
        width: 153px;
        height: 123px;
    }
    img.center {
        margin-top: 0px;
    }
</style>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/mobile_app/layouts/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar"><a href="<?php echo base_url('backoffice/webmobiel/homepagina'); ?>" class="breadcrumb">Web en Mobiel</a> > <span class="lastBreadcrumbs">Presentaties</span></div>
        <div class="grayColumn">
            <div class="titleBar">Presentaties</div>
            <div class="contentBlock1">
                <?php foreach ($car_details as $car): ?>
                    <div class="presentaties-box">
                        <div class="img-box">
                            <?php
                            $remote = $car->remoteFile;
                            $carimg = explode(',', $remote);
                            if (isset($carimg[0])) {
                                ?>                           
                                <img class="center car-img" src="<?php echo $carimg[0]; ?>" />
                            <?php } ?>
                        </div>
                        <div class="pbox-part1">
                            <h4><?php echo $car->brand; ?> <?php echo $car->model; ?></h4>
                            <h3><?php echo $car->licenseNumber; ?></h3>	
                            <p>Datum: <?php echo $car->dateStart; ?> <br>Code: <?php echo $car->adNumber; ?></p>
                        </div>
                        <div class="pbox-part2">
                            <a href="#" onclick="iframechang(<?php echo $car->adNumber; ?>, '<?= $car->brand; ?> <?= $car->model; ?>')" class="search"><img src="<?= base_url() ?>assets/crmAssets/images/search.png" /></a>
                            <a style="cursor:pointer" onclick="network()" class="network"><img src="<?= base_url() ?>assets/crmAssets/images/network.png" /></a>
                            <a style="cursor:pointer" href="#" onclick="qrcode(<?php echo $car->adNumber; ?>, '<?= $car->brand; ?> <?= $car->model; ?>')" class="qrcode"><img src="<?= base_url() ?>assets/crmAssets/images/qr.png" /></a>
                        </div>
                        <div class="pbox-part3">
                            <div class="close-bt" onclick="objectDelete(<?php echo $car->car ?>)"><a class="btnobjectdel"><img src="<?= base_url() ?>assets/crmAssets/images/close-bt.png" /></a></div>
                            <p>
                                <span id="klant_actief" class="checkBoxSlider actiefx">
                                    <button  onclick="changeCarStatus(1,<?php echo $car->car ?>)" id="<?php echo $car->car ?>1" value="1" class="radioSliderTrue blackText <?= ($car->active) ? 'radioSliderActive' : 'radioSliderInactive' ?>" type="button">aan</button></a>
                                    <button  onclick="changeCarStatus(0,<?php echo $car->car ?>)" id="<?php echo $car->car ?>0" value="0" class="radioSliderFalse blackText <?= ($car->active) ? 'radioSliderInactive' : 'radioSliderActive' ?>" type="button">uit</button>
                                    <br>
                                </span>

                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div id="search" style="display:none">
    <h3 id="titley">Title</h3>

    <div class="mobile-left-view">

                    <!-- <img src="<?= base_url() ?>assets/crmAssets/images/mobile-view1.jpg" /> -->
        <div style="position: absolute; background: none repeat scroll 0% 0% black; height: 364px; left: 284px; width: 19px;"></div>
        <iframe id="iframe" height="357" style="overflow:hidden;" width="235" src="<?php echo base_url(); ?>mobile/aanbod/3456789">
        <p>Your browser does not support iframes.</p>
        </iframe>  
    </div>

</div>
<div id="network" style="display:none">
    <h3 id="titlez">Volkswagen Golf GTI | 12-ABC-34 | Mobiele weergave</h3>          
    <div id="chart_div" id="chart_div" style="width:100%;">        
    </div>      
</div>
<div id="qrcode" style="display:none">
    <h3 id="titlex" >Title</h3>   
    <div class="contentBlock">
        <div class="qr-code">
            <img id="qrimg" src="<?php echo base_url(); ?>qr_images/qr.php?w=296&f=6&c=0000&d=http%3A%2F%2Fapp.imoby.nl%2F0000">
        </div>
        <div class="mobile-right-view">
            <p>
                <select onchange="format(this)" id="qrformatx" data-val="true">
                    <option value="">Kies formaat</option>
                    <option value="jpeg">JPEG</option>
                    <option value="png">PNG</option>
                </select>
                <select onchange="qrsize(this)" id="qrsize" data-val="true"> 
                    <option value="74">74</option>
                    <option value="148">148</option>
                    <option value="222">222</option>
                    <option value="296">296</option>
                    <option value="370">370</option>
                    <option value="481">481</option>
                    <option value="814">814</option>
                    <option value="962">962</option>                          
                </select>
                <input type="hidden" value="jpeg" id="formatqr" />
                <input type="hidden" value="962" id="sizeqr" />
                <input type="hidden" value="" id="carid" />
            </p>
            <div  class="button-left">
                <a  id="qrdown" href="javascript:void(0);"  class="button addRelatie" onclick="qr()" ><img class="add" src="<?php echo base_url(); ?>assets/crmAssets/images/vinkje.png">Download</a>
            </div>

        </div>
    </div>      

</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.popup.js') ?>"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
                    function qr() {
                        var carid = $('#carid').val();
                        var qrsize = $('#sizeqr').val();
                        var qrformatx = $('#formatqr').val();
                        var url = "<?php echo base_url(); ?>" + "backoffice/webmobiel/qrimage/" + qrsize + "/" + carid + "/" + qrformatx;
                        window.open(url, '_blank')
                    }
                    function format(format) {
                        var qrformatx = format.value;
                        $("#formatqr").val(qrformatx);
                    }
                    function qrsize(size) {
                        var qrsize = size.value;
                        $("#sizeqr").val(qrsize);
                    }
                    function qrcode(id, title) {
                        $('#titlex').html(title);
                        $('#carid').val(id);
                        var qrsize = $("#sizeqr").val();
                        var url = "<?php echo base_url(); ?>backoffice/webmobiel/qrimage/" + qrsize + "/" + id + "/png";
                        $("#qrimg").attr("src", "<?php echo base_url(); ?>qr_images/qr.php?w=296&f=6&c=" + id + "&d=http%3A%2F%2Fapp.imoby.nl%2F" + id + "");
                    }
                    function iframechang(id, title) {
                        $('#titley').html(title);
                        $("#iframe").attr("src", "<?php echo base_url(); ?>mobile/object/" + id + "");
                    }
                    function network(id, title) {


                        $('#titlez').html(title);
                    }

                    google.load('visualization', '1', {packages: ['corechart', 'bar']});
                    google.setOnLoadCallback(drawChart);
                    google.load("visualization", "1", {
                        packages: ["corechart"],
                        callback: function () {
                            drawChart();
                        }
                    });


                    function drawChart() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', '');
                        data.addColumn('number', '');
                        data.addColumn({type: 'string', role: 'style'});

                        data.addRows(3);

                        data.setValue(0, 0, 'Value 1');
                        data.setValue(0, 1, 250);
                        data.setValue(0, 2, '#00AFD8');

                        data.setValue(1, 0, 'Value 2');
                        data.setValue(1, 1, 100);
                        data.setValue(1, 2, '#00AFD8');

                        data.setValue(2, 0, 'Value 2');
                        data.setValue(2, 1, 100);
                        data.setValue(2, 2, '#00AFD8')

                        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                        chart.draw(data, {
                            width: 597,
                            height: 175,
                            title: 'Total',
                            legend: 'none'
                        });
                    }



                    function changeCarStatus(val, car) {
                        /* val=1=ann and val=0=uit */
                        if (val == 1) {
                            $("#" + car + "0").removeClass();
                            $("#" + car + "0").addClass("radioSliderFalse blackText radioSliderInactive");
                            $("#" + car + "1").removeClass();
                            $("#" + car + "1").addClass("radioSliderTrue blackText radioSliderActive");
                        }
                        if (val == 0) {
                            $("#" + car + "1").removeClass();
                            $("#" + car + "1").addClass("radioSliderTrue  blackText radioSliderInactive");
                            $("#" + car + "0").removeClass();
                            $("#" + car + "0").addClass("radioSliderFalse  blackText radioSliderActive");
                        }

                        $(function () {
                            $.ajax({
                                type: 'POST',
                                cache: false,
                                url: "<?php echo base_url('backoffice/webmobiel/changeCarStatus'); ?>",
                                data: {car: car, active: val},
                                success: function (msg) {
                                    alert(msg);

                                }
                            });
                        });

                    }
                    function objectDelete(objectid) {
                        var confirmation = confirm("Are you sure to delete this car");
                        if (confirmation == 1) {
                            $.ajax({
                                type: 'POST',
                                cache: false,
                                url: "<?php echo base_url('backoffice/webmobiel/deleteCar'); ?>",
                                data: {car: objectid},
                                success: function (msg) {


                                }
                            });


                            alert('Car deleted successfully');
                        }
                        else {
                            alert('Thank you');
                        }

                    }
                    $(function () {

                        $(".search").click(function () {

                        });
                        $('.search').popup({
                            content: $('#search'),
                            width: 600,
                            height: 550,
                        });
                        $('.network').popup({
                            content: $('#network'),
                            width: 600,
                            height: 250
                        });
                        $('.qrcode').popup({
                            content: $('#qrcode'),
                            width: 600,
                        });
                    });

                    $(document).ready(function () {

                        $("#drop").change(function () {
                            var value = $("#drop").val();
                            console.log(value);
                            if (value == 1) {
                                location.href = ("<?php echo base_url(); ?>backoffice/mobileapp/index/1");
                            }
                            if (value == 2) {
                                location.href = ("<?php echo base_url(); ?>backoffice/mobileapp/index/2");
                            }
                            if (value == 3) {
                                location.href = ("<?php echo base_url(); ?>backoffice/mobileapp/index/3");
                            }

                        });
                        $("#qrformat").change(function () {
                            var qrformat = $("#qrformat").val();
                            var qrsize = $("#qrsize").val();
                            var url = "<?php echo base_url(); ?>backoffice/mobileapp/qrimage/" + qrsize + "/12345/" + qrformat;
                            $("#qrdown").attr("href", url);
                        });
                        $("#qrsize").change(function () {
                            var qrformat = $("#qrformat").val();
                            var qrsize = $("#qrsize").val();
                            var url = "<?php echo base_url(); ?>backoffice/mobileapp/qrimage/" + qrsize + "/12345/" + qrformat;
                            $("#qrdown").attr("href", url);
                        });

                    });
</script>
<style type="text/css">
    .btnobjectdel{ cursor: pointer; }
    .popup{}
    .popup .popup_content{
        overflow: hidden;
    }
    .popup .contentBlock{
        overflow: hidden;
        padding: 20px;
        width: 93.3%;
        margin-bottom: 0;
    }
    .qr-code{
        margin: 0;    
    }
    .popup .popup_content h3{
        background: #195d82;
        color: #ffffff;
        font-weight: bolder;
        margin: 0px;
        padding: 10px;        
        display: block;
    }
    .popup .popup_content .popup-div{
        background: #f4f4f4; border: 1px solid #e9e9e9; border-top: none; padding: 10px;
    }
    .popup .popup_content .popup-div p{
        margin: 0;
    }
</style>
<?php $this->load->view('backoffice/layouts/footer'); ?>


