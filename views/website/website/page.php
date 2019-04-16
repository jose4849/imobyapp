<?php echo $header; ?>        
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
    <div class="cont_inner">
        <h3><?php echo $current_page_title; ?></h3>
        <style type="text/css">
            .white-con-bg{
                padding: 20px; border: 1px solid #ddd; background: #fff; font-size: 13px;
            }
        </style>
        <div class="white-con-bg">
            <?php echo $current_page_content; ?>
        </div>
    </div>
</div>
<?php echo $this->load->view('website/footer'); ?>