<?php echo $header; ?>
<?php echo $this->load->view('website/single_car_popup'); ?>
<div id="header">
    <h1 class="logo"><img id="topMenuLogo" title="Imoby.nl" alt="Imoby.nl" style="width: 100px;" src="<?= base_url() ?>media/dealers/<?php echo $dealer_id; ?>/logo_<?php echo $dealer_id; ?>.png"></h1> 
    <div id="header-right">
                <div id="web-overview">
            <form method="post" action="<?php echo base_url('relatie/logincheck') ?>">
                <p>
                    <label id="emailid" class="E-mailadres">
                        <input required type="email" name="email" placeholder="E-mailadres" value="">
                        <input type="hidden" name="return" value="<?php echo base_url(); ?><?php echo $homePageId; ?>">
                    </label>
                    <label id="Wachtwoord" class="Wachtwoord">
                        <input type="password" placeholder="Wachtwoord" name="password" value=""><br>
                        <a onclick="resetpass()" href="javascript::void(0)"><span>Wachtwoord vergeten?</span></a>
                    </label>
                    <label id="Wachtwoord2" class="Button-R">
                        <input id="login" type="submit" class="" name="button" value="Inloggen">
                    </label>
                    </form>
                    <label id="reset" class="Button-R" style="display:none;">
                        
                    </label>
            
                    <script>
                    function resetpass(){
                        $("#reset").css("display", "block");
                        $("#emailid").html("&nbsp;"); 
                        $("#Wachtwoord").html('<input required id="resetmail" type="email" name="email" placeholder="E-mailadres" value="">'); 
                        $("#Wachtwoord2").html('<input onclick="resetemail()" id="login"  class="" name="button" value="Reset">'); 
                       
                    }
                    function resetemail(){
                        
                        $.ajax({
                            url:"<?php echo base_url(); ?>home/resetclient",
                            data:{ 	
                                resetmail:$('#resetmail').val()
                            },
                            type:"POST",
                            datatype: 'json',
                            success:function(result){
                                alert(result);
                            }       
                        }); 
                        
                        
                        
                        
                    }
                    </script>
                </p>
                <p>
                    <label class="Wachtwoord"><br>
                        <?php $this->session->flashdata('message') ?>
                        <?php (isset($email)) ? $email : '' ?>
                    </label>
                    <label class="Wachtwoord"><br>
                        <?php (isset($password)) ? $password : '' ?>
                    </label>
                </p>
            
        </div>
    </div>
    <div class="clr"></div>
    <div class="home-nav">
        <?php echo $menu; ?>
    </div>
</div>    
<div id="cont_wrapper"> 
    <div class="cont_inner" style="padding-bottom:0px;">
        <h3 style="font-size: 28px; "><?php echo $home->page_title; ?></h3>
        <style type="text/css">
            .white-con-bg{
                padding: 20px; border: 1px solid #ddd; background: #fff; font-size: 13px;
            }
        </style>
        <div class="white-con-bg">
            <?php echo $home->page_content; ?>
        </div>
    </div>
</div>    
    
<div id="cont_wrapper">
    <div class="cont_inner" >
        <h3 style="font-size: 28px;">Bekijk ons aanbod</h3>
        <?php echo $this->load->view('website/searchbox'); ?>      
        <div id="list-view" class="right-cont" style=" overflow-y: scroll;background: white none repeat scroll 0% 0%; border-right: 1px solid rgb(225, 225, 225); border-bottom: 1px solid rgb(225, 225, 225); height: 527px;">
            <?php foreach ($cars as $car): ?>
                <div class="div-box">
                    <div class="div-box-img">
                    <?php
                        $remotefile = $car->remoteFile;
                        $carimg = explode(",", $remotefile);
                        if (isset($carimg[0])) {
                    ?>
                    <img class="center car-img" alt="#" src="<?php echo $carimg[0]; ?>" >
                    <?php } ?>
                    </div>
                    <div class="div-box-details">
                        <h4><?= $car->brand; ?> <?= $car->model; ?> <?= $car->type; ?></h4>
                        <p></p>
                    </div>
                    <div class="div-box-price">
                        <p>Prijs: €  <?php echo $car->showroompris; ?> <br>Bouwjaar: <?= $car->buildYear; ?><br>Kmstand: <?= $car->KMvalue; ?> km</p>
                    </div>
                    <div class="div-box-arrow">
                        <a onclick="singlecar('<?php echo $car->adNumber; ?>')" href="#TaskListDialog"  role="button" data-toggle="modal" ><i class="fa fa-chevron-right"></i>
                        </a>
                    </div>  
                </div>
            <?php endforeach; ?>
            <div class="clr"></div>
        </div>

    </div>
</div>
<?php echo $this->load->view('website/footer'); ?>
