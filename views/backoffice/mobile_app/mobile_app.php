<?php $this->load->view('backoffice/layouts/header'); ?>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/mobile_app/layouts/leftMenu'); ?>
    </div>
    <div id="contentWrapper">
        <div id="breadCrumsBar"><a href="<?php echo base_url('backoffice/webmobiel/homepagina'); ?>" class="breadcrumb">Web en Mobiel </a> > <span class="lastBreadcrumbs">Homepagina</span></div>
        <div class="grayColumn">
            <div class="titleBar">Pagina bekijken</div>
            <div class="contentBlock">               
                <div class="mobile-left-view">
                    <!-- <img style="position:absolute;" src="<?= base_url() ?>assets/crmAssets/images/mobile-view1.jpg" /> -->
                    <div style="position: absolute; background: none repeat scroll 0% 0% black; height: 364px; left: 519px; width: 19px;"></div>
                    <iframe height="357" style="overflow:hidden;" width="235" src="<?php echo base_url(); ?>mobile/home/<?php echo $homePageId; ?>">
                    <p>Your browser does not support iframes.</p>
                    </iframe>                   
                </div>
                <div class="mobile-right-view">
                    <h3>imoby.nl/<?php echo $homePageId; ?></h3>
                    <p>
                        <span>Pagina actief:</span>
                        <span id="klant_actief" class="checkBoxSlider actief">
                            <button type="button" onclick="mobileAppStatus(1)" class="radioSliderTrue  blackText radioSlider<?php
        if ($mobileapp == 1) {
            echo "Active";
        } else {
            echo "Inactive";
        }
        ?>">aan</button>
                            <button type="button" onclick="mobileAppStatus(0)" class="radioSliderFalse  blackText radioSlider<?php
                                    if ($mobileapp == 0) {
                                        echo "Active";
                                    } else {
                                        echo "Inactive";
                                    }
        ?>">uit</button><br>
                            <input type="radio"  name="status1" class="radioSliderOn actief" value="1" checked="">
                            <input type="radio" name="status0" class="radioSliderOff actief" value="0">
                        </span> 
                    </p>
                    <script>
                        function mobileAppStatus(status) {
                            $.ajax({
                                url: "<?php echo base_url(); ?>backoffice/webmobiel/updateStatus",
                                data: {
                                    serviceStatus: status,
                                    dealerfunction: 1,
                                    dealer:<?php echo $dealer_id; ?>
                                },
                                type: "POST",
                                datatype: 'json',
                                success: function(result) {
                                    location.reload();
                                }
                            });


                        }
                    </script>
                </div>
            </div>
        </div>
        <div class="grayColumn">
            <div class="titleBar">QR-code</div>
            <div class="contentBlock">
                <div class="qr-code">
                    <img src="<?php echo base_url(); ?>qr_images/qr.php?w=296&f=6&c=<?php echo $homePageId; ?>&d=http%3A%2F%2Fapp.imoby.nl%2F<?php echo $homePageId; ?>" />
                </div>
                <div class="mobile-right-view">
                    <p>
                        <select id="qrformat" data-val="true">
                            <option value="">Kies formaat</option>
                            <option value="jpeg">JPEG</option>
                            <option value="png">PNG</option>
                        </select>
                        <select id="qrsize" data-val="true"> 
                            <option value="74">74</option>
                            <option value="148">148</option>
                            <option value="222">222</option>
                            <option value="296">296</option>
                            <option value="370">370</option>
                            <option value="481">481</option>
                            <option value="814">814</option>
                            <option value="962">962</option>                         
                        </select>
                    </p>
                    <div class="button-left">
                        <a id="qrdown" target="_blank" href="#" class="button addRelatie"><img src="<?= base_url() ?>assets/crmAssets/images/vinkje.png" class="add">Download</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="grayColumn">
            <div class="titleBar">Statistieken</div>
            <div class="contentBlock">
                <div class="afmeting">                   
                    <div class="base">
                        <div class="img-div" id="chart_div">
                            <!-------making statistics------>

                            <!-------making statistics--->
<!--                            <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="541" height="177" id="Column3D" >
                                <param name="movie" value="http://app.imoby.nl/FusionChartsFree/Charts/FCF_Column3D.swf" />
                                <param name="quality" value="high" />
                                <embed id="hi" src="http://app.imoby.nl/FusionChartsFree/Charts/FCF_Column3D.swf" flashVars="&dataXML=&lt;graph yAxisMinValue='0' yAxisMaxValue='6' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;


                                       <?php
                                       if ($selected == 1) {
                                           /* for weekly view start */
                                           $total = 0;
                                           $totals = 0;
                                           $min = 0;
                                           $max = 0;
                                           if (isset($graph)) {
                                               $total = count($graph);
                                               foreach ($graph as $bar) {
                                                   $view_dt = $bar->view_dt;
                                                   $view_dt = date("d-m-Y", strtotime($view_dt));
                                                   $each = $bar->eachdate;
                                                   if ($each > $max) {
                                                       $max = $each;
                                                       $totals = $totals + $each;
                                                   }
                                                   if ($each < $min) {
                                                       $min = $each;
                                                       $totals = $totals + $each;
                                                   }
                                                   ?>
                                                   &lt;set name='<?php echo $view_dt; ?>' value='<?php echo $bar->eachdate; ?>' color='99D2EE' showName='1' hoverText='<?php echo $view_dt; ?>'/&gt;

                                                   <?php
                                               }
                                           }
                                       }
                                       /* for weekly view start */



                                       /* for weekly view start */
                                       if ($selected == 2) {

                                           $total = 0;

                                           $min = 0;
                                           $max = 0;
                                           if (isset($graph)) {
                                               $total = count($graph);
                                               foreach ($graph as $bar) {

                                                   $each = $bar->eachdate;
                                                   if ($each > $max) {
                                                       $max = $each;
                                                       $totals = $totals + $each;
                                                   }
                                                   if ($each < $min) {
                                                       $min = $each;
                                                       $totals = $totals + $each;
                                                   }
                                                   $d = date("d", strtotime($bar->view_dt));
                                                   $y = date("Y", strtotime($bar->view_dt));
                                                   if (($d >= 1) && ($d <= 10)) {
                                                       $jm++;
                                                   }
                                                   if (($d >= 11) && ($d <= 20)) {
                                                       $aj++;
                                                   }
                                                   if (($d >= 21) && ($d <= 31)) {
                                                       $js++;
                                                   }
                                               }
                                           }
                                           $view_dt1 = '1-10';
                                           $view_dt2 = '11-20';
                                           $view_dt3 = '21-30';
                                           ?>

                                           &lt;set name='<?php echo $view_dt1; ?>' value='<?php echo $jm; ?>' color='99D2EE' showName='1' hoverText='hello'/&gt;            
                                           &lt;set name='<?php echo $view_dt2; ?>' value='<?php echo $aj; ?>' color='99D2EE' showName='1' hoverText='hello'/&gt;            
                                           &lt;set name='<?php echo $view_dt3; ?>' value='<?php echo $js; ?>' color='99D2EE' showName='1' hoverText='hello'/&gt;            
                                           <?php
                                       }
                                       /* for weekly view start */
                                       /* for yearly view start */
                                       if ($selected == 3) {

                                           $total = 0;
                                           $totals = 0;
                                           $min = 0;
                                           $max = 0;


                                           $jm = 0;
                                           $aj = 0;
                                           $js = 0;
                                           $od = 0;
                                           // echo '<pre>';
                                           // print_r($graph);

                                           if (isset($graph)) {
                                               $total = count($graph);
                                               foreach ($graph as $bar) {
                                                   $each = $bar->eachdate;
                                                   if ($each > $max) {
                                                       $max = $each;
                                                       $totals = $totals + $each;
                                                   }
                                                   if ($each < $min) {
                                                       $min = $each;
                                                       $totals = $totals + $each;
                                                   }
                                                   $m = date("m", strtotime($bar->view_dt));
                                                   $y = date("Y", strtotime($bar->view_dt));
                                                   if (($m == 1) || ($m == 2) || ($m == 3)) {
                                                       $jm++;
                                                   }
                                                   if (($m == 4) || ($m == 5) || ($m == 6)) {
                                                       $aj++;
                                                   }
                                                   if (($m == 7) || ($m == 8) || ($m == 9)) {
                                                       $js++;
                                                   }
                                                   if (($m == 10) || ($m == 11) || ($m == 12)) {
                                                       $od++;
                                                   }
                                               }
                                           }
                                           $view_dt1 = 'Jun-Mar ' . $y;
                                           $view_dt2 = 'Apr-Jun ' . $y;
                                           $view_dt3 = 'Jul-Sept ' . $y;
                                           $view_dt4 = 'Oct-Dec ' . $y;
                                           ?>

                                           &lt;set name='<?php echo $view_dt1; ?>' value='<?php echo $jm; ?>' color='99D2EE' showName='1' hoverText='hello'/&gt;            
                                           &lt;set name='<?php echo $view_dt2; ?>' value='<?php echo $aj; ?>' color='99D2EE' showName='1' hoverText='hello'/&gt;            
                                           &lt;set name='<?php echo $view_dt3; ?>' value='<?php echo $js; ?>' color='99D2EE' showName='1' hoverText='hello'/&gt;            
                                           &lt;set name='<?php echo $view_dt4; ?>' value='<?php echo $od; ?>' color='99D2EE' showName='1' hoverText='hello'/&gt;            
                                           <?php
                                       }
                                       /* for yearly view start */
                                       ?>                                        




                                       &lt;/graph&gt;&chartWidth=541&chartHeight=177"
                                       quality="high" width="541" height="177" name="Column3D" type="application/x-shockwave-flash" 
                                       pluginspage="http://www.macromedia.com/go/getflashplayer" />                              </object>-->
                        </div>
<?php
$avg = 0;
if ($selected == 2) {
    $avg = $totals / 7;
}
if ($selected == 3) {
    $avg = $totals / 30;
}
if ($selected == 1) {
    $avg = $totals / 365;
}
?> 
<!--                        <h3>Laatste 30 dagen, <label>Max.: <?php echo $max; ?>, Min.: <?php echo $min; ?></label>, <label>Gemiddeld: <?php echo round($avg, 2); ?></label>, Totaal: <?php //echo $total = $min + $max;     ?> <?php echo $totals; ?></h3>-->
                    </div>
                </div>
                <div class="mobile-right-view">
                        <?php $selected; ?>
                    <p>                                   
                        <select id="drop" data-val="true">
                            <option <?php
                        if ($selected == 1) {
                            echo "selected";
                        }
                        ?> value="1">Week weergave</option>
                            <option <?php
                        if ($selected == 2) {
                            echo "selected";
                        }
                        ?> value="2">Maand weergave</option>                            
                            <option <?php
                            if ($selected == 3) {
                                echo "selected";
                            }
                        ?> value="3">Jaar weergave</option>
                        </select>
                    </p>
<!--                    <p style="margin-top: 30px;"> 
                        <span class="afmet">Gemiddeld: <?php echo round($avg, 2); ?></span>
                        <span class="afmet">Totaal: <?php echo $totals; ?><?php //echo $total = $min + $max;        ?></span>
                    </p>	-->
                </div>
            </div>
        </div>



        <div class="grayColumn">
            <div class="titleBar">Detectie script</div>
            <div class="contentBlock">
                <div class="detectie">
                    <h4>Het onderstaande script zorgt ervoor dat bezoekers met een mobiele telefoon de vraag krijgen of ze de mobiele versie willen bekijken.</h4>
                    <h4>Plaats het onderstaande script in de head van uw homepage of website.</h4>
                    <textarea rows="4" cols="50"><script type="text/javascript" src="http://app.imoby.nl/base/mobilescript/<?php echo $homePageId; ?>/imoby.js"></script>
                    </textarea> 
                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
    
    
    google.load('visualization', '1', {packages: ['corechart', 'bar']});
    google.setOnLoadCallback(drawChart);


   function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', '');
    data.addColumn('number', '');
    data.addColumn({ type: 'string', role: 'style' });
    
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
        width: 541, 
        height: 175, 
        title: 'Total',
        legend: 'none'
    });
  }

google.load("visualization", "1", { 
	packages: ["corechart"], 
	callback: function() { drawChart(); }
});

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    $(document).ready(function() {
        $("#drop").change(function() {
            var value = $("#drop").val();
            console.log(value);
            if (value == 1) {
                location.href = ("<?php echo base_url(); ?>backoffice/webmobiel/homepagina/1");
            }
            if (value == 2) {
                location.href = ("<?php echo base_url(); ?>backoffice/webmobiel/homepagina/2");
            }
            if (value == 3) {
                location.href = ("<?php echo base_url(); ?>backoffice/webmobiel/homepagina/3");
            }
        });
        $("#qrformat").change(function() {
            var qrformat = $("#qrformat").val();
            var qrsize = $("#qrsize").val();
            var url = "<?php echo base_url(); ?>backoffice/webmobiel/qrimage/" + qrsize + "/<?php echo $user->klantnummer; ?>/" + qrformat;
            $("#qrdown").attr("href", url);
        });
        $("#qrsize").change(function() {
            var qrformat = $("#qrformat").val();
            var qrsize = $("#qrsize").val();
            var url = "<?php echo base_url(); ?>backoffice/webmobiel/qrimage/" + qrsize + "/<?php echo $user->klantnummer; ?>/" + qrformat;
            $("#qrdown").attr("href", url);
        });
    });
</script>
<?php $this->load->view('backoffice/layouts/footer'); ?>
