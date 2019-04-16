<div id="footer">
    <div id="footer-inner">
        <h1>Neem contact op</h1>
        <div class="foot-left">
            <form>
                <p style="color:white;" class="success"></p>
                <p>
                    <input type="text" required id="name1"  placeholder="Naam" />
                    <input type="text" required id="name2"  placeholder="Achternaam" /></p>
                <p>
                    <input type="email" id="email" required name="E-mail" value="" placeholder="E-mail">
                    <input type="" id="phone" name="phone number" required value="" placeholder="Telefoonnummer">
                </p>
                <p>
                    <input class="topic" type="text" id='body1' value="" name="Onderwerp" placeholder="Onderwerp" />
                </p>
                <textarea rows="4" id="contactbody" required placeholder="Bericht..." cols="50"></textarea>
                <input type="button" onclick="emailsend()" id="form-one"value="Versturen" class="button foot-button">  
            </form>
            <script>
             function emailsend(){
                    var name1  = $("#name1").val()+" "+$("#name2").val();
                    var email1 = $("#email").val();
                    var tel1 = $("#phone").val();
                    var dealer_id = "<?php echo $DealerInfo[0]->dealer; ?>";
                    var body1 = $("#body1").val();
                    var subject1 = $("#contactbody").val();
                    subject1="From Website: "+subject1;
                    $.ajax({
                        url:"<?php echo base_url(); ?>mobile/emailsendobject",
                        data:{ 
                            no:1,
                            from1:'from1',
                            email_name:name1,	
                            from:email1,
                            dealer_id:dealer_id,
                            subject:subject1,					 
                            body:body1					 
                        },
                        type:"POST",
                        datatype: 'json',
                        success:function(result){
                            
                            $(".success1").html(result );
                            $(".success").html(result );
                        }       
                    }); 
             }   
                
             $(document).ready(function(){
                
                $( "#form-one" ).click(function() { 
                    
                    alert('jose');
                    /*
                    var name1  = $("#name1").val()+" "+$("#name2").val();
                    var email1 = $("#email").val();
                    var tel1 = $("#phone").val();
                    var dealer_id = "<?php echo $DealerInfo[0]->dealer; ?>";
                    var body1 = $("#body1").val();
                    var subject1 = $("#contactbody").val();
                    subject1="From Website: "+subject1;
                    $.ajax({
                        url:"<?php echo base_url(); ?>mobile/emailsendobject",
                        data:{ 
                            no:1,
                            from1:'from1',
                            email_name:name1,	
                            from:email1,
                            dealer_id:dealer_id,
                            subject:subject1,					 
                            body:body1					 
                        },
                        type:"POST",
                        datatype: 'json',
                        success:function(result){
                            $(".success1").html(result );
                            $(".success").html(result );
                        }       
                    }); 
                    */
                    
                    
                    
                });
                
             });
            </script>
        </div>
        <div class="foot-map">
            <?php
            //print_r($DealerInfo[0]);
            
            $address = '';
            $steet=$DealerInfo[0]->street;
            if($steet!=null){ $address=$address.$steet; }
            
            $postal_code=$DealerInfo[0]->postal_code;
            if($postal_code!=null){ $address=$address." ".$postal_code; }
            $city=$DealerInfo[0]->city;
            if($city!=null){ $address=$address." ".$city; }
            $address = str_replace(" ", "+", $address);

            $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
            $output = json_decode($geocode);
            $lat = $output->results[0]->geometry->location->lat;
            $lng = $output->results[0]->geometry->location->lng;
            ?>
            <img alt="" src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $lat . "," . $lng; ?>&amp;zoom=15&amp;size=280x220&amp;maptype=roadmap&markers=color:orange%7C<?php echo $lat . "," . $lng; ?>&amp;sensor=false" />
        </div>
        <div class="foot-address">            
            <?php echo $DealerInfo[0]->name; ?><br>
            <?php echo $DealerInfo[0]->street; ?><br>
            <?php echo $DealerInfo[0]->city; ?>
            <?php echo $DealerInfo[0]->postal_code; ?>,<?php echo $DealerInfo[0]->country ?>.<br><br>
            T: <?php echo $DealerInfo[0]->phoneNumber1; ?><br />
            F: <?php echo $DealerInfo[0]->phoneNumber2; ?><br />
            E: <?php echo $DealerInfo[0]->email; ?>
            <ul class="soical-icon-media">
                <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>                              
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>  
                <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>               
            </ul>
        </div>
        <div class="clr"></div>   
        <p>Powered by Imoby.nl</p>
    </div>
</div>