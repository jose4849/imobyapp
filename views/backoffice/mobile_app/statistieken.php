<?php $this->load->view('backoffice/layouts/header'); ?>
<div id="wrapper">
    <div id="leftMenu">
        <?php $this->load->view('backoffice/mobile_app/layouts/leftMenu'); ?>
    </div>




    <div id="contentWrapper">
        <div id="breadCrumsBar"><a href="<?php echo base_url('backoffice/webmobiel/homepagina'); ?>" class="breadcrumb">Web en Mobiel </a> > <span class="lastBreadcrumbs">Statistieken</span></div>
        <div class="grayColumn">
            <div class="titleBar">Algemene statistieken</div>
            <div class="contentBlock">
                <div class="afmeting" id="chart_div"  >
                    <img src="<?= base_url() ?>assets/crmAssets/images/grap.jpg" />
                </div>
                <div class="mobile-right-view">
                    <p>
                        <select id="GameID" data-val="true">
                            <option value="3">Week weergave</option>
                            <option value="2">Maand weergave</option>
                            <option value="1">Jaar weergave</option>
                        </select>
                    </p>

                </div>
            </div>
        </div>
        <div class="grayColumn">
            <div class="titleBar">Object statistieken</div>
            <div class="contentBlock">
                <div class="detectie">
                    <table>
                        <thead>
                            <tr>
                                <th class="p55"><span>Object</span></th>
                                <th class="p15"><span>Datum</span></th>
                                <th class="p15"><span>Code</span></th>
                                <th class="p15"><span>Aantal</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //  print_r($statisties);
                            foreach ($statisties as $stat) {
                                ?>
                                <tr>
                                    <td><?php echo $stat['brand'] . " " . $stat['brand']; ?></td>
                                    <td>-</td>
                                    <td><?php echo $stat['item']; ?></td>
                                    <td><?php echo $stat['eachdate']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div id="pagenation_container">
                    <!-- <div class="pagination">
                         <a href="#" class="page"><</a>
                         <span class="page active">1</span>
                         <a href="#" class="page">2</a>
                         <a href="#" class="page">3</a>
                         <a href="#" class="page">..</a>
                         <a href="#" class="page">></a>
                     </div>-->
                </div>
            </div>
        </div>
        <?php
        // echo '<pre>';
        // print_r($circle);
        // print_r($circlegraph);
        ?>
        <div class="grayColumn">
            <div class="titleBar">Type toestel</div>
            <div class="contentBlock type-toes">
                <div class="afmeting">
                    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                    <script type="text/javascript">
                        google.load("visualization", "1", {packages:["corechart"]});
                        google.setOnLoadCallback(drawChart);
                        function drawChart() {
                            
                            
                            
                            var data = google.visualization.arrayToDataTable([
                                ['Device', 'visits'],
<?php foreach ($circlegraph as $graph) { ?>
                ['<?php echo $graph->devicename; ?>',   <?php echo $graph->RowAmount; ?> ],
<?php } ?>
            ['',0]
                                
                                
        ]); 


        var options = {
            title: '',
            pieHole: 0.4
            
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
                    </script>

                    <div id="donutchart" style="width: 770px; height: 400px;"></div>
                    <style>
                        rect { 
                            /* fill:#F4F4F4!important; */
                        }
                    </style>
                </div>

            </div>
        </div>
    </div>







</div>

<script>
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

</script>


<?php $this->load->view('backoffice/layouts/footer'); ?>
