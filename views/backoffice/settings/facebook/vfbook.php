<ul class="nav2">
                        <li><a class="submenu" href="<?php echo BASE.'user/profiel#user/instellingen';?>"><img width="16" height="16" alt="" src="<?php echo IMAGES;?>settings.png"/>Instellingen</a></li>
                        <li><a class="submenu" href="<?php echo BASE.'user/profiel#user/logo';?>"><img width="16" height="16" alt="" src="<?php echo IMAGES;?>prof_logo.png"/>Logo</a></li>
                        <li><a class="submenu" href="<?php echo BASE.'user/profiel#user/socialmedia';?>"><img width="16" height="13" alt="" src="<?php echo IMAGES;?>msocmed.png"/>Social Media</a></li>
                    </ul>
                </div>
</div>
</div>
<!--<ul class="nav-bottom">
                        <li><a href="<?php //echo BASE.'user/profiel#user/intellingen'?>"><img width="16" height="16" alt="" src="<?php //echo IMAGES;?>/d.png">Instellingen</a></li>
                        <li><a href="<?php //echo BASE.'user/profiel#user/logo'?>"><img width="16" height="16" alt="" src="<?php //echo IMAGES;?>/go.png">Logo</a></li>
                        <li><a href="<?php //echo BASE.'user/profiel#user/socialmedia'?>"><img width="16" height="13" alt="" src="<?php //echo IMAGES;?>/gr.png">Social Media</a></li>
                    </ul>
                </div>
</div>-->

<div class="content">
    <div class="heading">
        <h2>Facebook<label> Account</label></h2>
    </div>
    <div class="innerdiv1">
             <div class="center1">
                <h3>Imoby en Facebook</h3><br/>
              
                <p class="titledesc">
                    Hier kunt uw Facebook account koppelen aan Imoby. Dit stelt 
                    Imoby in staat om automatisch uw nieuwe presentaties te posten op uw Facebook account.
                </p> 
            <?php 

             if(!empty($authUrl)){
            ?>  
                    <div class="twitterlogin">
                            <img src="<?php echo IMAGES;?>images/face.png" alt="Twitter"/>
                            <a class="btn" href="<?php echo $authUrl;?>">Inloggen met uw Facebook account</a>
                    </div>
            <?php }else{ ?>
                <br/>
                <h4>Facebook status</h4>
                
               <p>
                    <label>User name : </label><span><?php echo $fb_username;?></span>
                </p>
                <div class="clear"></div>
<!--
                <p>
                   <label>Verified : </label><span><?php echo $fb_verified;?></span>
                </p>
                <div class="clear"></div>
-->
                <p>
                    <label>Facebook URL : </label><span><a target="_blank" href="<?php echo $fb_link; ?>"><?php echo $fb_link;?></a></span>
                </p>
                <div class="clear"></div>
               <!--
                <p>
                    <span><input type="checkbox" name="added_status" <?php if($added_status){ echo 'checked';} ?> value="1" /> Automatically post for all of my presentations that are added.</span>
                </p>
                <p>

                    <span><input type="checkbox" name="updated_status" <?php if($updated_status){ echo 'checked';} ?> value="1" /> Automatically post for all of my presentations that are updated.</span>
                </p>-->
                <div class="clear"></div>
                <br/>
                <p>
                    <label>Op welke pagina wilt u dat Imoby meldingen plaatst?</label><br/>
                    <span>
                    <?php
                        if($fanPages){
                            foreach($fanPages as $fanPage){   
                                $selected = ($selected_fanPage == $fanPage['id']) ? 'selected="selected"' : '';
                                $options .= '<option value="'.$fanPage['id'].'" '.$selected.'>'.$fanPage['name'].'</option>';       
                            }
                            echo '<select name="fanPage" id="fanPage">'.$options.'</select>';
                        }
                        ?><em>(Een test bericht zal op de pagina worden geplaatst bij verandering)</em>
                    </span><br /><br />
                    <span>
                    <label>Standaard bericht voor de posts op uw Facebook account</label><br/>
                    <span><textarea name="postData" maxlength="120" style="width:410px;height:105px;resize:none;"><?php if(!empty($msgText)){ echo $msgText;} ?></textarea></span><br/>
                    <em>(Max character 120)</em><br/>
                    <span><input name="postDataBtn" type="button" value="Update"/></span>
                </p>
             <?php } ?>   
            </div>   
    </div>
</div>

 
<input type="hidden" name="userid" value="<?php echo $userid; ?>"/>

<!--<div id="main-con">
	<div id="inside-main-con">
		<div class="vgheader"><img src="<?php //echo IMAGES;?>profile_button.gif" height="32" width="34" alt="profiel" /><span>Twitter</span>Account</div>
		<div class="innerdiv1">
			<div class="center1">
                            <h3>Imoby and Facebook</h3>
                            <p class="titledesc">You can link your Facebook account to imoby. This will enable imoby to automatically post for your new and updated presentations on your Facebook account.</p> 
			<?php 
                        
				//if(!empty($authUrl)){
			?>
				<div class="twitterlogin">
					<img src="<?php //echo IMAGES;?>twitter_logo.gif" alt="Twitter"/>
					<a class="btn" href="<?php //echo $authUrl;?>">Sign in Facebook Account</a>
				</div>
			<?php //}else{ ?>
                            <h4>Facebook status</h4>
                            <p>
                                <img src="<?php //echo $twitterplogo;?>" alt="twitter profile logo"/>
                            </p>
                            <p>
                                <label>User name : </label><span><?php //echo $fb_username;?></span>
                            </p>
                            <div class="clear"></div>
             
                            <p>
                               <label>Verified : </label><span><?php //echo $fb_verified;?></span>
                            </p>
                            <div class="clear"></div>
                            <p>
                                <label>Friends : </label><span><?php //echo $friends;?></span>
                            </p>
                            <div class="clear"></div>
                            
                            <p>
                                <label>Facebook URL : </label><span><a target="_blank" href="<?php //echo $fb_link; ?>"><?php //echo $fb_link;?></a></span>
                            </p>
                            <div class="clear"></div>
                            <p>
                                
                                <span><input type="checkbox" name="added_status" <?php //if($added_status){ echo 'checked';} ?> value="1" /> Automatically post for all of my presentations that are added.</span>
                            </p>
                            <p>
                                
                                <span><input type="checkbox" name="added_status" <?php //if($updated_status){ echo 'checked';} ?> value="1" /> Automatically post for all of my presentations that are updated.</span>
                            </p>
                            <div class="clear"></div>
                        <?php //} ?>    
                        </div>
		</div>
	</div>
</div>-->

<script type="text/javascript">
    $(function(){
       $("input[name=postDataBtn]").click(function(){
           msgData = $("textarea[name=postData]").val();
           userid = $("input[name=userid]").val();
           $.ajax({
              type:"POST",
              url : "<?php echo BASE.'user/updateSocialMediaPost'; ?>",
              data : {userid: userid, type: 'facebook', text: msgData},
              success: function(e){
                  
              }
           });
       }); 
        
       $("input[name=added_status]").change(function(){
          obj = $(this);
          userid = $("input[name=userid]").val();
          if(obj.attr('checked')){
              
              $.ajax({
                 type:"POST",
                 url : "<?php echo BASE.'user/updateSocialMediaStatus'; ?>",
                 data : {userid: userid, type:'facebook', field:'added_status', status: 1},
                 success:function(e){
                     
                 }
                 
              });
          }else{
              
              $.ajax({
                 type:"POST",
                 url : "<?php echo BASE.'user/updateSocialMediaStatus'; ?>",
                 data : {userid: userid, type:'facebook', field:'added_status', status: 0},
                 success:function(e){
                     
                 }
                 
              });
          }
       }); 
       
        if($("select[name=fanPage]").length){
            $("select[name=fanPage]").change(function(){
                var selected = $('select[name=fanPage] :selected').val();
                $.ajax({
                    type:"POST",
                    url : "<?php echo BASE.'user/updateFacebookPage'; ?>",
                    data : {selectedPage: selected},
                    success:function(e){
                       // if(e) { alert(e); };
                    }
                })
            });
        }
       
       
       
       $("input[name=updated_status]").change(function(){
          obj = $(this);
          userid = $("input[name=userid]").val();
          if(obj.attr('checked')){
              
              $.ajax({
                 type:"POST",
                 url : "<?php echo BASE.'user/updateSocialMediaStatus'; ?>",
                 data : {userid: userid, type:'facebook', field:'updated_status', status: 1},
                 success:function(e){
                    
                 }
                 
              });
          }else{
             
              $.ajax({
                 type:"POST",
                 url : "<?php echo BASE.'user/updateSocialMediaStatus'; ?>",
                 data : {userid: userid, type:'facebook', field:'updated_status', status: 0},
                 success:function(e){
                     
                 }
                 
              });
          }
       });
    });
</script>
