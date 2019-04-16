<?php echo $header; ?>
<div class="main">
    <!----------------------------------------------Left part start-------------------------------------->     
    <div id="swipeable-1" class="tab-swipeable" style="display:none;">
        <header class="top">
            <div class="row nav-view">
                <div class="container1">
                    <div class="l-11"><span style="text-align: left;">Zoeken in <?php echo $total_rows; ?> VOERTUIG(EN)</span></div>
                    <div class="l-1 infotab nopad-r">                           
                        <div class="l-12 rightnav">
                            <a href="#"><i onclick="swip_next(2, 1)" class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section>    
            <div class="container1 totalOffer">
                <form class="zoekenf">
                    <div class="row">
                        <div class="l-12 searchItem nopad">
                            <input id="search-form" type="search" placeholder="Zoeken op trefwoord" value="" name="Search by keyword" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-12 selectnav">
                            <select id='brand' >
                                <option value=''>Merk / Model</option>                                       
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-6 selectnav searchItem nopad-l">
                            <input class="search-form" value='' type="text" id="prijs-van" placeholder="Prijs van" name="prijs-van" />
                        </div>
                        <div class="l-6 selectnav nopad-r right">
                            <input class="search-form" value='' type="text" id="prijs-tot" placeholder="Prijs van" name="prijs-tot" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-6 selectnav nopad-l">
                            <input class="search-form" value='' type="text" id="year1" placeholder="Bouwjaar van" name="year1" />
                        </div>
                        <div class="l-6 selectnav nopad-r right">
                            <input class="search-form" value='' type="text" id="year2" placeholder="Bouwjaar tot" name="year2" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-6 selectnav nopad-l">
                            <input class="search-form" value='' type="text" id="kmstand-van" placeholder="Kmstand van" name="kmstand-van" />
                        </div>
                        <div class="l-6 selectnav nopad-r right">
                            <input class="search-form" value='' type="text" id="kmstand-tot" placeholder="Kmstand tot" name="kmstand-tot" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-12 selectnav">
                            <select id="carrosserie" name="carrosserie">
                                <option value=''>Carrosserie</option>                                       
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-12 selectnav">
                            <select id="zitplaatsen" name="zitplaatsen">
                                <option value=''>Zitplaatsen</option>
                                <option value="1">1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                                <option value="6" >6</option>
                                <option value="7" >7</option>
                                <option value="8" >8</option>
                                <option value="9" >9</option>
                                <option value="10" >10</option>
                                <option value="11" >Meer</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-12 selectnav">
                            <select id="aantal-deuren" name="aantal-deuren" >
                                <option value='' >Aantal deuren</option>
                                <option value="1">1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                                <option value="6" >6</option>
                                <option value="7" >7</option>
                                <option value="8" >8</option>
                                <option value="9" >9</option>
                                <option value="10" >10</option>
                                <option value="11" >Meer</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-12 selectnav">
                            <select id="transmissie" name="transmissie">
                                <option value="" >Transmissie</option>                                     
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="l-12 selectnav">
                            <select id="brandstof" name="brandstof">
                                <option value='' >Brandstof</option>                                       
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="re-sarch nopad-l">
                            <input onclick="reset()" type="button" id="reset-button" value="Reset" name="Reset" />
                        </div>
                        <div class="re-sarch right nopad-r">
                            <input onclick="swip_next(2, 1)" type="button" id="search-button" value="Zoeken" name="search" />
                        </div>
                    </div>                  
                </form>
            </div>
        </section>                   
    </div>
    <!----------------------------------------------Left part end -------------------------------------->        
    <!----------------------------------------------mid part start --------------------------------------> 
    <div id="swipeable-2" class="tab-swipeable">
        <header class="top">
            <div class="row nav-view">
                <div class="container1">
                    <div class="l-8 nopad-l">
                        <div class="l-6 text-center zoeken nopad-l">
                            <a href="#"><i onclick="swip_pre(1, 2)" class="fa fa-chevron-left left"></i>
                                <span class="text-r left" style="padding-left:2vw" onclick="swip_pre(1, 2)" >zoeken</span></a>
                        </div>
                        <div class="l-3 home">
                            <a href="<?= base_url() ?>mobile/home/<?php echo $homePageId; ?>"><i class="fa fa-home"></i></a>
                        </div>
                        <div class="l-3" >
                            <a id="view-list"  href="#"><i  class="fa fa-list-ul"></i></a>
                        </div>
                    </div>
                    <div class="l-4 infotab nopad-r">

                        <div class="l-4 grid">
                            <a id="view-grid" href="#"><i class="fa fa-th-large"></i></a>
                        </div>
                        <div class="l-8 rightnav nopad-r">
                            <a href="#"><i onclick="swip_next(3, 2)" class="fa fa-chevron-right"></i>
                                <span class="text-l right" style="padding-right:2vw" onclick="swip_next(3, 2)" >Info</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section> 
            <div class="listDiv container1" id="list-view" >
                <?php $n = 0; ?>
                <?php foreach ($cars as $car):
                    ?>
                    <?php $n++; ?>
                    <div class="row bg-white list-view">
                        <div class="l-4 img-block">
                            <a href="<?= base_url() ?>mobile/object/<?php echo $car->adNumber; ?>" >
                                <?php
                                $remotefile = $car->remoteFile;
                                $carimg = explode(",", $remotefile);
                                if (isset($carimg[0])) {
                                    ?>
                                    <img src="<?php echo $carimg[0]; ?>" width="100%" alt="img" />
                                <?php } ?>
                            </a>
                        </div>
                        <div class="l-8 list-content">

                            <div class="carlistdetails">
                                <label class="car-title">
                                    <?php
                                    //    echo '<pre>';
                                    //  print_r($car);


                                    $ctitle = $car->brand . ' ' . $car->model . ' ' . $car->type;
                                    if (strlen($ctitle) > 20) {
                                        $ctar = str_split($ctitle, 21);
                                        echo $ctar[0] . '..';
                                    } else
                                        echo $ctitle;
                                    ?>
                                </label>
                                <label class="price">Prijs: <i class="fa fa-eur"></i> <?php echo $car->showroompris; // echo number_format($car->showroomprijs, 2, ',', '.');    ?></label>
                                <label class="year">Bouwjaar: <?= $car->buildYear; ?></label>
                                <label class="mileage">Kmstand: <?php echo $car->KMvalue; ?> km</label> 
                            </div>
                            <div class="goright"><a href="<?= base_url() ?>mobile/object/<?php echo $car->adNumber; ?>"><i class="fa fa-chevron-right"></i></a></div>
                        </div>   

                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <!-- <div class="l-6 gridviewimg nopad"><a href="#" class="previous">Vorige</a></div>
                    <div class="l-6 gridviewimg nopad right"><a href="#" class="next">Volgende</a></div> -->
                    <?php echo $link; ?>
                </div>
            </div>



            <div class="container1" id="grid-view" style="display:none;">

                <div class="row">
                    <?php $n = 0; ?>
                    <?php foreach ($cars as $car): ?>
                        <?php $n++; ?>
                        <div class="l-6 bg-white gridviewimg">
                            <a href="<?= base_url() ?>mobile/object/<?php echo $car->adNumber; ?>">
                                <?php
                                $remotefile = $car->remoteFile;
                                $carimg = explode(",", $remotefile);
                                if (isset($carimg[0])) {
                                    ?>
                                    <img src="<?php echo $carimg[0]; ?>" alt="Image not found.." />
                                <?php } ?>
                            </a>
                            <label><?= $car->brand; ?> <?= $car->model; ?> <?= $car->type; ?></label>
                            <span class="carprice"><i class="fa fa-eur"></i>  <?php echo $car->showroompris; ?></span>
                        </div>                            
                        <?php ($n % 2 == 0) ? '</div><div class="row">' : '' ?>
                    <?php endforeach; ?>
                </div>


                <div class="row">
                    <?php echo $link; ?>
                    <!-- <div class="l-6 gridviewimg nopad"><a href="#" class="previous">Vorige</a></div>
                    <div class="l-6 gridviewimg nopad right"><a href="#" class="next">Volgende</a></div> -->
                </div>
            </div>
        </section> 
    </div>                
    <!----------------------------------------------mid part end-------------------------------------->        
    <!----------------------------------------------right part start-------------------------------------->
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
                    <br />
                    <br />
                    <div class="l-12 bg-white rectangle">
                        <h4 class="theme-col" style="margin-bottom:4vw;margin-top: 3vw; font-size: 5vw;padding:0"><?php echo $DealerInfo[0]->name; ?></h4>                        
                        <p><?php echo $DealerInfo[0]->street; ?> <?php echo $DealerInfo[0]->house_num; ?> <?php echo $DealerInfo[0]->house_num_addition; ?><br> <?php echo $DealerInfo[0]->postal_code; ?> <?php echo $DealerInfo[0]->city; ?></p>                        
                    </div>

                    <div class="l-12 bg-white call">
                        <i class="ico icon-info"></i><a href="tel:<?php echo $DealerInfo[0]->phoneNumber1; ?>">Bellen</a>                        
                    </div>
                    <div class="l-12 bg-white call">
                        <i class="ico icon-info2" style="font-size:5vw;"></i><a href="mailto:<?php echo $DealerInfo[0]->email; ?>">Mailen</a>                                         
                    </div>
                    <div class="l-12 bg-white call">
                        <i class="ico icon-info3"></i>
                        <?php
                        $address = $DealerInfo[0]->name;
                        $address = $address . "House# " . $DealerInfo[0]->house_num;
                        $address = $address . " " . $DealerInfo[0]->house_num_addition;
                        $address = $address . "Postcode# " . $DealerInfo[0]->postal_code;
                        $address = $address . " " . $DealerInfo[0]->city;
                        $address = $address . " " . $DealerInfo[0]->country;
                        ?>
                        <a target="_blank" href="http://maps.google.com/?q=+<?php echo $DealerInfo[0]->street; ?>+<?php echo $DealerInfo[0]->house_num; ?>+,+<?php echo $DealerInfo[0]->house_num_addition; ?>+,+<?php echo $DealerInfo[0]->city; ?>+&z=16">Locatie</a>                            
                    </div>
                </div>
            </div>
        </section>



    </div>   

    <!----------------------------------------------right part end--------------------------------------> 

</div>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!-- jQueryUI -->
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> 
<script type="text/javascript">
                            $(document).ready(function () {
                                $("#grid-view").hide();
                                $(".fa-th-large").css("opacity", "0.50");
                            });
                            $("#view-list").click(function () {
                                $("#grid-view").hide();
                                $("#list-view").show();
                                $(".fa-list-ul").css("opacity", "1");
                                $(".fa-th-large").css("opacity", "0.50");
                            });
                            $("#view-grid").click(function () {
                                $("#list-view").hide();
                                $("#grid-view").show();
                                $(".fa-list-ul").css("opacity", "0.5");
                                $(".fa-th-large").css("opacity", "1");
                            });



                            function swip_pre(pre, curr) {
                                // console.log(id);           
                                var target = 'swipeable-' + pre;
                                var current = 'swipeable-' + curr;
                                $('#' + target).show("slide", {direction: 'left'});
                                $('#' + current).hide("slide", {direction: 'right'});
                                if (pre == 1) {
                                    //$("#search-form").html("");
                                    $("#brand").html("<option value=''>Merk / Model</option>");
                                    // $("#prijs-van").html("");
                                    // $("#prijs-tot").html("");
                                    // $("#year1").html("");
                                    // $("#year2").html("");
                                    // $("#kmstand-van").html("");
                                    // $("#kmstand-tot").html("");
                                    $("#carrosserie").html("<option value='' >Carrosserie</option>");
                                    //$("#aantal-deuren").html("");
                                    $("#transmissie").html("<option value='' >Transmissie</option>");
                                    $("#brandstof").html("<option value='' >Brandstof</option>");

                                    /*  search form data start*/
                                    $.ajax({
                                        url: "<?php echo base_url(); ?>mobile/ajax_search_form",
                                        data: {aanbod:<?php echo $aanbod; ?>},
                                        type: "POST",
                                        datatype: 'json',
                                        success: function (result) {
                                            //  console.log(result);
                                            var dataArray = [];
                                            var brands = [];
                                            var brandstofs = [];
                                            var versnellings = [];
                                            var carrosseries = [];
                                            var obj = jQuery.parseJSON(result);
                                            for (key in obj)
                                                dataArray.push([key.toString(), obj [key]]);
                                            for (i = 0; i < dataArray.length; i++) {
                                                /* for bands */
                                                var brand = dataArray[i][1].brand;
                                                var found = jQuery.inArray(brand, brands);
                                                if (found >= 0) {
                                                } else {
                                                    // Element was not found, add it.
                                                    brands.push(brand);
                                                    $("#brand").append("<option value=" + brand + " >" + brand + "</option>");
                                                }
                                                /* end for bands */
                                                /* for brandstof */
                                                var brandstof = dataArray[i][1].brandstof;
                                                var found = jQuery.inArray(brandstof, brandstofs);
                                                if (found >= 0) {
                                                } else {
                                                    // Element was not found, add it.
                                                    brandstofs.push(brandstof);
                                                    $("#brandstof").append("<option value=" + brandstof + "  >" + brandstof + "</option>");
                                                }
                                                /* end for brandstof */
                                                /* for versnelling */
                                                var versnelling = dataArray[i][1].versnelling;
                                                var found = jQuery.inArray(versnelling, versnellings);
                                                if (found >= 0) {
                                                } else {
                                                    // Element was not found, add it.
                                                    versnellings.push(versnelling);
                                                    $("#transmissie").append("<option value=" + versnelling + "  >" + versnelling + "</option>");
                                                }
                                                /* end for versnelling */

                                                /* for Carrosserie */
                                                var carrosserie = dataArray[i][1].type;
                                                var found = jQuery.inArray(carrosserie, carrosseries);
                                                if (found >= 0) {
                                                } else {
                                                    // Element was not found, add it.
                                                    carrosseries.push(carrosserie);
                                                    $("#carrosserie").append("<option value=" + carrosserie + "  >" + carrosserie + "</option>");
                                                }
                                                /* end for Carrosserie */
                                            }
                                            // console.log(dataArray[0]); 
                                            //  console.log(brands);
                                        }});
                                    /*  search form data end*/
                                }
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

                            /* year option */

                            //            $(document).ready(function () {
                            //                var year1 = 2000;
                            //                var year2 = 2000;
                            //                for(i = 0; i < 100; i++){        
                            //                    $("#year1").get(0).options[$("#year1").get(0).options.length] = new Option(year1, year1);
                            //                    year1=year1+1;
                            //                    $("#year2").get(0).options[$("#year2").get(0).options.length] = new Option(year2, year2);
                            //                    year2=year2+1;
                            //                }
                            //            });
                            /* year option end */

                            /* search  ajax start*/

                            $(document).ready(function () {
                                console.log('search part here');
                                $("input").keyup(function () {
                                    search();
                                });
                                $("select")
                                        .change(function () {
                                            search();
                                        });
                            });
                            function search() {
                                var searchtext = $("#search-form").val();
                                var brand = $("#brand").val();
                                var prijsvan = $("#prijs-van").val();
                                var prijstot = $("#prijs-tot").val();
                                var bouwjaarVan = $("#year1").val();
                                var bouwjaarTot = $("#year2").val();
                                var kmstandVan = $("#kmstand-van").val();
                                var kmstandTot = $("#kmstand-tot").val();
                                var carrosserie = $("#carrosserie").val();
                                var zitplaatsen = $("#zitplaatsen").val();
                                var aantalDeuren = $("#aantal-deuren").val();
                                var transmissie = $("#transmissie").val();
                                var brandstof = $("#brandstof").val();

                                //                console.log(searchtext); 
                                //                console.log(brand); 
                                //                console.log(prijsvan); 
                                //                console.log(prijstot); 
                                //                console.log(bouwjaarVan); 
                                //                console.log(bouwjaarTot); 
                                //                console.log(kmstandVan); 
                                //                console.log(kmstandTot); 
                                //                console.log(carrosserie); 
                                //                console.log(zitplaatsen); 
                                //                console.log(aantalDeuren); 
                                //                console.log(transmissie); 
                                //                console.log(brandstof);
                                /*  search form data start*/
                                $.ajax({
                                    url: "<?php echo base_url(); ?>mobile/ajax_search_object",
                                    data: {
                                        searchtext: searchtext,
                                        brand: brand,
                                        prijsvan: prijsvan,
                                        prijstot: prijstot,
                                        bouwjaarVan: bouwjaarVan,
                                        bouwjaarTot: bouwjaarTot,
                                        kmstandVan: kmstandVan,
                                        kmstandTot: kmstandTot,
                                        type: carrosserie,
                                        zitplaatsen: zitplaatsen,
                                        deuren: aantalDeuren,
                                        versnelling: transmissie,
                                        brandstof: brandstof
                                    },
                                    type: "POST",
                                    datatype: 'json',
                                    success: function (result) {
                                        //console.log(result);
                                        var format = '';
                                        var full = '';
                                        var formatgrid = '';
                                        var fullgrid = '';
                                        var dataArray = [];
                                        var obj = jQuery.parseJSON(result);
                                        for (key in obj)
                                            dataArray.push([key.toString(), obj [key]]);
                                        for (i = 0; i < dataArray.length; i++) {
                                            var brand = dataArray[i][1].brand;
                                            var model = dataArray[i][1].model;
                                            var type = dataArray[i][1].type;
                                            var remoteFile = dataArray[i][1].remoteFile;
                                            var showroomprijs = dataArray[i][1].showroomprijs;
                                            var buildYear = dataArray[i][1].buildYear;
                                            var voertuig_id = dataArray[i][1].voertuig_id;
                                            var kilometerstand = dataArray[i][1].kilometerstand;
                                            /* For list view */
                                            format = '';
                                            format = "<div class='row bg-white list-view'>";
                                            format = format + "<div class='l-4 img-block'>";
                                            format = format + '<a href="<?php echo base_url(); ?>mobile/object/' + voertuig_id + '">';
                                            format = format + '<img width="100%" alt="img" src="' + remoteFile + '"></a>';
                                            format = format + "</div>";

                                            format = format + '<div class="l-8 list-content">';
                                            format = format + '<label class="car-title">' + brand + ' ' + model + ' ' + type + '</label>';
                                            format = format + '<div class="carlistdetails">';
                                            format = format + '<label class="price">Prijs: <i class="fa fa-eur"></i> ' + showroomprijs + '</label>';
                                            format = format + '<label class="year">Bouwjaar: ' + buildYear + '</label>';
                                            format = format + '<label class="mileage">Kmstand: ' + kilometerstand + ' km</label>';
                                            format = format + '</div>';
                                            format = format + '<div class="goright"><a href="<?php echo base_url(); ?>mobile/object/' + voertuig_id + '"><i class="fa fa-chevron-right"></i></a></div>';
                                            format = format + '</div>';
                                            format = format + '</div>';
                                            full = full + format;
                                            /* for list */
                                            /* for grid view */
                                            formatgrid = '';
                                            formatgrid = formatgrid + '<div class="l-6 bg-white gridviewimg">';
                                            formatgrid = formatgrid + '<a href="<?php echo base_url(); ?>mobile/object/' + voertuig_id + '">';
                                            formatgrid = formatgrid + '<img alt="1" src="' + remoteFile + '"></a>';
                                            formatgrid = formatgrid + '<label>' + brand + ' ' + model + ' ' + type + '</label>';
                                            formatgrid = formatgrid + '<span class="carprice"><i class="fa fa-eur"></i> ' + showroomprijs + '</span>';
                                            formatgrid = formatgrid + '</div>';
                                            fullgrid = fullgrid + formatgrid;
                                            /* for grid view */

                                        }
                                        $("#list-view").html(full);
                                        $("#grid-view").html(fullgrid);


                                    }});
                                /*  search form data end*/
                            }
                            function reset() {
                                $("select").val("0");
                            }
                            /* search  ajax start*/




</script>        
<?php echo $footer; ?>