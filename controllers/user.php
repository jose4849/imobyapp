<?php

class User extends Controller {

        private $member_types = array('LAND','CAR');
    
	function __construct()
	{
		parent::__construct();		
		$this->load->library('simplelogin');
		$this->load->model('muser');
		//if(LOCAL) $this->fp->setEnabled(true);
		if(!$this->session->userdata('logged_in'))
			if(!in_array($this->uri->segment(2), array('profiel','authenticate','login','signup','logout','uploadify','password_recovery','activate_account','activate','confirmation_send')))	
            redirect('http://www.imoby.nl/login.html');
	}

	function index() 
	{
	   
       redirect(BASE.'user/profiel');
	   //redirect(BASE.'user/presentaties');
	}

        function authenticate(){
            
            if($this->simplelogin->login($this->input->post('username'), $this->input->post('password'))){
                $this->session->set_userdata('loginfailed',0);
                redirect(BASE.'user/profiel');
                //redirect(BASE.'user/presentaties');
            }else{
                $this->session->set_userdata('loginfailed',1);				
                redirect('http://www.imoby.nl/login.html');
            }
        }
        
	function login($extra=NULL)
        
	{
        $data['title'] = 'Imoby';
        $data['err']=0;        
        $data['extra']=$extra;
                
        $rules['username']='required|xss_clean';
        $rules['password']='required|xss_clean';
        $this->validation->set_rules($rules);

        $fields['username'] = 'Username';
        $fields['password'] = 'Password';
        $this->validation->set_fields($fields);
        $this->validation->set_error_delimiters('<label class="error">', '</label>');
        
        if($this->input->post('sign-in')){
                echo $this->input->post('username');
        	die();
			if($this->validation->run() && $this->simplelogin->login($this->input->post('username'), $this->input->post('password')))	
				redirect(BASE.'user/profiel');
	           //redirect(BASE.'user/presentaties');
			else		
                            
				if($this->validation->run()) $data['err']=1;
                                redirect(BASE);
        }
		$data['selectedMenu'] = array(
    	'isHome'=>false,
		'isOverons' => false,
		'isVastgoed' => false,
		'isAuto' => false,
		'isSupport' => false,
		'isContact' => false,
		'isBusiness' => false
    	);
//        $this->load->view('user/vheader', $data); 
//        $this->load->view('user/vlogin');
//        $this->load->view('user/vfooter');      
	}	
		

        
	function add_user()
	{
		$this->muser->addUser();
	}	
	
	function delete_user($user_id)
	{  
		$this->muser->deleteUser($user_id);
	}
        
        function deleteobject()
        {
           
                $this->load->model('mobject');
                $this->load->model('mwonendetails');
                $this->load->model('mstatistics');
                $this->load->model('mobjectmedia');
                $this->load->model('mmediaqueue');
                $this->load->model('mverdiepingen');
                $this->load->model('mmobileapps');
                $this->load->model('mwoonhuis');
                $this->load->model('mwoonlagen');
                $this->load->model('mcar_specs');
                $this->load->model('mcar_uitrustings');
                $this->load->model('mcar_uitvoeringens');
                $this->load->model('mcar_manufacturers');
                $this->load->model('mcar_man_packs');
                $this->load->model('mcar_additional_features');
                $this->load->helper('file');
                
                $member_type = $this->session->userdata('member_type');
                $imobycode = $this->session->userdata('imobycode');
                $objectid = $this->input->post('object_id',true);
                $this->mobjectmedia->deleteMediaByObj($imobycode,$objectid);
                
                $object = $this->mobject->get_object_byid($objectid);
                
                
                 
                
                if($member_type == 'CAR')
                {
                    
                    $this->mcar_specs->deleteCarSpecByObj($imobycode,$objectid);
                    $this->mcar_uitrustings->deleteUitrustingByObj($imobycode,$objectid);
                    $this->mcar_uitvoeringens->deleteUitVoeringenByObj($imobycode,$objectid);
                    
                    $this->mcar_manufacturers->deleteManufacturerByObj($imobycode,$objectid);
                    $this->mcar_man_packs->deleteManpkgrByObj($imobycode,$objectid);
                    $this->mcar_additional_features->deleteAdditionsByObj($imobycode,$objectid);
                }
                else
                {
                    
                    $this->mwonendetails->deleteWonenByObj($imobycode,$objectid);
                    $this->mverdiepingen->deleteVerdiepingenByObj($imobycode,$objectid);
                    $this->mwoonhuis->deleteWoonhuisByObj($imobycode,$objectid);
                    $this->mwoonlagen->deleteWoonlagenByObj($imobycode,$objectid);
                }
                if(file_exists('fileserver/bofiles/downloads/'.$imobycode.'/'.$objectid.'.mp4'))
                {
                    unlink('fileserver/bofiles/downloads/'.$imobycode.'/'.$objectid.'.mp4');
                }
                if(is_dir('fileserver/bofiles/downloads/'.$imobycode.'/'.$objectid)){
                    
                   // rmdir('downloads/'.$userDetails['imobycode']);
                    delete_files('fileserver/bofiles/downloads/'.$imobycode.'/'.$objectid,TRUE);
                    rmdir('fileserver/bofiles/downloads/'.$imobycode.'/'.$objectid);
                    
                }
                
                $deleted = $this->mobject->deleteObjectById($imobycode,$objectid);
                
                $this->mstatistics->deleteStats($objectid);
                
                
                if(!empty($object[0]['custom_object_id'])){
                    $this->mppresentation->delete_pp($object[0]['custom_object_id']);
                }else{
                    $this->mmediaqueue->delete_media_queue($imobycode,$objectid);
                }
                
                echo $deleted;
        }
	
	function reset_password($user_id)
	{		
		$this->muser->resetPassword($user_id);
	}	

	function edit_user()
	{
		$this->muser->editInfo();
	}
	
	function change_password() {
		redirect('user/profile/'.$this->muser->changePassword());
	}
	
	function update_profile() {
		$updated = $this->muser->updateProfile();
                echo $updated;
	}	
	
	function upload_avatar($user_id)
	{
	   
		$ext = substr($_FILES["Filedata"]["name"], strrpos($_FILES["Filedata"]["name"], '.') + 1);
		move_uploaded_file($_FILES["Filedata"]["tmp_name"],"upload/" . "avatar_".$user_id.".".$ext);		
		$config['image_library'] = 'gd2';
		$config['source_image'] = "upload/" . "avatar_".$user_id.".".$ext;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 50;
		$config['height'] = 50;	
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		$data['avatar'] = "avatar_".$user_id.".".$ext;
		$this->db->where('id',$user_id);
		$this->db->update('users', $data);
		echo "1";		
	}	
	
	function signup()
	{
        $data = array();
        $data['err']=1;
        
        
    	$rules['username']='required|xss_clean';
        $rules['password']='required|xss_clean|min_length[5]';
        $rules['cpassword']='required|xss_clean|min_length[5]|matches[password]';
        $rules['email']='required|xss_clean|valid_email';
        $rules['recaptcha_challenge_field'] = 'required|callback_recaptcha_check';        
        $this->validation->set_rules($rules);

    	$fields['username']='Username';
        $fields['password']='Password';
        $fields['cpassword']='Confirm Password';
        $fields['email']='Email';
        $fields['recaptcha_challenge_field'] = 'Captcha'; 
        $this->validation->set_fields($fields);        
        $this->validation->set_error_delimiters('<label class="error">', '</label>');        
        
        if($this->input->post('sign-up')){
        	
			if($this->muser->signup())
				redirect('user/confirmation_send');
			else 
				$data['err']=0;
        }
        $this->load->helper('recaptcha');
    	$data['recaptcha']=recaptcha_get_html(RECAPTCHA_PUBLIC);	
    	
		$data['title'] = "Imoby.nl";
		$data['selectedMenu'] = array(
		'isHome'=>false,
		'isOverons' => false,
		'isWoning' => false,
	    'isAuto' => false,
		'isProducten' => false,
	    'isContact' => false
		 );	
    	$data['logo'] = "logo.png";
        $this->load->view('imoby_front/vheader', $data); 
        $this->load->view('user/vsignup', $data);
        $this->load->view('imoby_front/vfooter');  
	}	
	
	
	function activate_account($user_id="",$code=""){
		if(!empty($user_id) && !empty($code)){
			$data['status']=$this->muser->activateAccount($user_id,$code);	
		}else{
			$data['status'] = 0;
		}
		$data['title'] = "Imoby.nl";
		$data['selectedMenu'] = array(
		'isHome'=>false,
		'isOverons' => false,
		'isWoning' => false,
	    'isAuto' => false,
		'isProducten' => false,
	    'isContact' => false
		 );	
		$this->load->view('imoby_front/vheader', $data); 
        $this->load->view('user/vactivate',$data);
        $this->load->view('imoby_front/vfooter'); 
	}
	
	function confirmation_send(){
		$data=array();
		$data['title'] = "Imoby.nl";
		$data['selectedMenu'] = array(
		'isHome'=>false,
		'isOverons' => false,
		'isWoning' => false,
		'isAuto' => false,
		'isProducten' => false,
		'isContact' => false
		 );	
		$this->load->view('imoby_front/vheader', $data); 
		$this->load->view('user/vconfirm_send');
		$this->load->view('imoby_front/vfooter'); 
	}
	
	
	
	function activate() {
		$data['title'] = 'Imoby';

        if($this->input->post('email')){
        		$email = $this->input->post('email');
        		$code = md5(uniqid().time());
        		$users = $this->db->getWhere('user', array('email'=>$email));
        		
        		$user = $users->result_array();
        		if(!empty($user)){
        		$user_id = $user[0]['id'];
        		}else{
        			$user_id = 0;
        		}
        		if(isset($user_id) && $user_id != 0){   		
	        		$this->db->where('email',$this->input->post('email'));
	        		$this->db->update('user',array('code'=>$code));    		
					$mail_content = array();
					$mail_content['to'] = $email;
					$mail_content['subject'] = 'Reactivate account';
					$mail_content['msg_body'] = '<br/><p><a href="'.BASE.'user/activate_account/'.$user_id.'/'.$code.'">Click here</a> to activate your imbody account.</p>';
					$this->muser->send_email($mail_content);
					echo 1;
        		}
        		else{
        			echo 0;
        		}
			
        }        
        
        
	}	

	
	function password_recovery($step=0,$user_id=NULL,$code=NULL) {
		$data['title'] = 'Imoby';
		$data['selectedMenu'] = array(
		'isHome'=>false,
		'isOverons' => false,
		'isVastgoed' => false,
		'isAuto' => false,
		'isSupport' => false,
		'isContact' => false,
		'isBusiness' => false
    	);	

		switch ($step){
		case 0:
	        $rules['email']='required|xss_clean|valid_email';
	        $this->validation->set_rules($rules);
	
	        $fields['email'] = 'Email';
	        $this->validation->set_fields($fields);
	        
	        if($this->input->post('recover')){
	        	if($this->validation->run()){   
	        		$code=md5(uniqid().time());
	        		$email = $this->input->post('email');
	        		$result=$this->db->getWhere('user', array('email'=>$email));
	        		if($result->num_rows()){	        			
		        		$user_id=$result->row()->id; 		
		        		$this->db->where('email',$this->input->post('email'));
		        		$this->db->update('user',array('code'=>$code)); 
		        		$mail_content = array();
						$mail_content['to'] = $email;
						$mail_content['subject'] = 'Password Recovery';
						$mail_content['msg_body'] = '<br/><p>Click this link to reset password: <a href="'.BASE.'user/password_recovery/1/'.$user_id.'/'.$code.'">'.BASE.'user/password_recovery/1/'.$user_id.'/'.$code.'</a></p>';     		
						$this->muser->send_email($mail_content);
						$data['msg']='Check your mailbox for instructions.';
						echo 1;
	        		}else 
	        			$data['msg']='Email Address is not recognised.';
	        			echo 0;
				}
	        } 
        break;	        
        case 1: 
        	$pass=time(); 		
        	$result=$this->db->getWhere('user',array('id'=>$user_id,'code'=>$code));
        	if($result->num_rows()){
        		$email=$result->row()->email;        	
	        	$this->db->where('id',$user_id);
	        	$this->db->where('code',$code);
	        	$this->db->update('user',array('password'=>md5($pass),'code'=>'')); 
	        	$mail_content1 = array();
				$mail_content1['to'] = $email;
				$mail_content1['subject'] = 'Password Recovery';
				$mail_content1['msg_body'] = '<br/><p>Your new password is:<strong>: <strong>'.$pass.'</strong></p>';     		
				$this->muser->send_email($mail_content1);
				$data['msg']='Your new password is sent to your email address. Please check your inbox or spam'; 
        		$data['msgcolor'] = "";
        	}
			else{
				$data['msgcolor'] = 'red';
				$data['msg']='Link already used or expired!'; 
			}      	  
        break;	 
		}           
        $this->load->view('user/vheader', $data); 
        $this->load->view('user/vpassrecovery');
        $this->load->view('user/vfooter');  
	}

    function recaptcha_check($str) {    	
    	$this->load->helper('recaptcha');
		$resp = recaptcha_check_answer(RECAPTCHA_PRIVATE,
										$_SERVER["REMOTE_ADDR"],
										$this->input->post("recaptcha_challenge_field"),
										$this->input->post("recaptcha_response_field"));
		if(!$resp->is_valid) {
			$this->validation->set_message('recaptcha_check','Captcha incorrect, please try again.');
			return FALSE;
		}
		else {
			return TRUE;
		}    	
    }
    
	function profiel()
	{	$this->load->model('mmessage');
                $this->load->model('mmobileapps');
                
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');

		$this->load->view('user/vheader',$data);
                
		$this->load->view('user/profile/vprofie',$data);
		$this->load->view('user/vfooter');
        
	}  
	
	function instellingen(){
		$data = array();
                $data['member_type'] = $this->session->userdata('member_type');
                
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$this->load->view('user/profile/vintellingen',$data);
                
	}
	
	function logo(){
		$data = array();
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$this->load->view('user/profile/vlogo',$data);
	}
        
        function ajaxremovelogo(){
            $this->load->model('muser');
            $user_id = $this->input->post('user_id');
            $logo_file = $this->input->post('logo_file');
            $file = 'fileserver/bofiles/uploads/profile_images/'.$logo_file;
            $filethumb = 'fileserver/bofiles/uploads/profile_images/thumbnail/'.$logo_file;
            $filelarge = 'fileserver/bofiles/uploads/profile_images/large/'.$logo_file;
            $filemedium = 'fileserver/bofiles/uploads/profile_images/medium/'.$logo_file;
            if(file_exists($file)){
                $del = unlink($file);
            }
            if(file_exists($filelarge)){
                $dellarge = unlink($filelarge);
            }
            if(file_exists($filemedium)){
                $delmedium = unlink($filemedium);
            }
            if(file_exists($filethumb)){
                $deltmb = unlink($filethumb);
            }
            
            
            if($del && $deltmb && $dellarge && $delmedium){
                $removed = $this->muser->remove_logo_by_id($user_id);
            }
            echo $removed;
        }
	
	function socialmedia(){
                $this->load->model('msocialmedia');
		$data = array();
                $data['twitter_acc_exist'] = $this->msocialmedia->is_twitter($this->session->userdata('user_id'));
                $data['youtube_acc_exist'] = $this->msocialmedia->is_youtube($this->session->userdata('user_id'));
                $data['fb_acc_exist'] = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
		$this->load->view('user/profile/vsocialmedia',$data);
	}
	
	function twitter(){
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
		$data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$this->load->plugin('twitteroauth');
                $this->load->model('msocialmedia');
		$this->load->model('mmessage');
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $this->load->model('mmobileapps');
                
		require_once(APPPATH.'libraries/twitter/secret.php');
		$twitter_acc_exist = $this->msocialmedia->is_twitter($this->session->userdata('user_id'));
                
                if(empty($twitter_acc_exist)){
                    if (isset($_REQUEST['oauth_verifier'])){

                            $twitter=$this->session->userdata('twitter');
                            $connection = new TwitterOAuth('EiJ0JNqlINlPxKOAMh3cw', 'GZ50vfq8vhWanVpI5830sHGn1XCeyOxiZ1l7im7Z5rc', $twitter['oauth_token'], $twitter['oauth_token_secret']);

                            /* Request access tokens from twitter */
                            $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
                            $tweet = "you logged in from Imoby.nl at ".date('F j, Y H:i:s');
                            $twitterCon = new TwitterOAuth('EiJ0JNqlINlPxKOAMh3cw', 'GZ50vfq8vhWanVpI5830sHGn1XCeyOxiZ1l7im7Z5rc', $access_token['oauth_token'], $access_token['oauth_token_secret']);
//                            $twitterCon->post('statuses/update', array('status' => $tweet));
                            if(isset($access_token['user_id'])){
                                    $access_token['userid'] = $this->session->userdata('user_id');
                                    $access_token['added_status'] = 1;
                                    $access_token['updated_status'] = 1;
                                    $access_token['social_type'] = 'twitter';
                                    $access_token['link_date'] = date("Y-m-d");
                                    $this->msocialmedia->save_socailmedia($access_token);
                                    
                                    redirect(BASE.'user/twitter');
                            }			
                    }else{
                            /* Build TwitterOAuth object with client credentials. */
                            $connection = new TwitterOAuth('EiJ0JNqlINlPxKOAMh3cw', 'GZ50vfq8vhWanVpI5830sHGn1XCeyOxiZ1l7im7Z5rc');
                            /* Get temporary credentials. */
                            $request_token = $connection->getRequestToken();
                            /* Save temporary credentials to session. */
                            $token = $request_token['oauth_token'];
                            $token_secret = $request_token['oauth_token_secret'];
                            $this->session->set_userdata('twitter',array('oauth_token'=>$token,'oauth_token_secret'=>$token_secret));
                            $data['authUrl'] = $connection->getAuthorizeURL($token);
                            
                              

                    }
                }else{
                    try{
                     $twitterCon = new TwitterOAuth('EiJ0JNqlINlPxKOAMh3cw', 'GZ50vfq8vhWanVpI5830sHGn1XCeyOxiZ1l7im7Z5rc', $twitter_acc_exist[0]['oauth_token'], $twitter_acc_exist[0]['oauth_token_secret']);
                     $getTweet = $twitterCon->get('statuses/user_timeline',array('user_id' => $twitter_acc_exist[0]['user_id']));
//                     echo '<pre>';
//                     echo $twitter_acc_exist[0]['oauth_token'].'<br/>';
//                     echo $twitter_acc_exist[0]['oauth_token_secret'].'<br/>';
//                     print_r($getTweet); die();
                     $data['twitterplogo'] = $getTweet[0]->user->profile_image_url;
                     $data['twitter_username'] = $getTweet[0]->user->screen_name;
                     $data['twitter_name'] = $getTweet[0]->user->name;
                     $data['twitter_since'] = $getTweet[0]->user->created_at;
                     $data['twitter_favourites'] = $getTweet[0]->user->favourites_count;
                     $data['twitter_followers'] = $getTweet[0]->user->followers_count;
                     $data['twitter_friends'] = $getTweet[0]->user->friends_count;
                     $data['twitter_status'] = $getTweet[0]->user->statuses_count;
                     $data['twitter_link'] = 'https://twitter.com/#!/'.$getTweet[0]->user->screen_name;
                     $data['msgText'] = $twitter_acc_exist[0]['social_post'];
                     $data['added_status'] = $twitter_acc_exist[0]['added_status'];
                     $data['updated_status'] = $twitter_acc_exist[0]['updated_status'];
                    }catch(Exception $ex){
                        redirect(BASE.'user/twitter');
                    }
                     
                }
                $data['userid'] = $this->session->userdata('user_id');
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/profile/twitter/vtwitter',$data);
		$this->load->view('user/vfooter');
	}
        
        function deactive_twitter(){
                $this->load->model('msocialmedia');
                require_once(APPPATH.'libraries/twitter/secret.php');
                $this->load->plugin('twitteroauth');
                $twitterAcc = $this->msocialmedia->is_twitter($this->session->userdata('user_id'));
                $deleted  = $this->msocialmedia->delete_socialmedia($this->session->userdata('user_id'),'twitter');
                $tweet = "you logged out from imoby.projecflick.com at ".date('F j, Y H:i:s');
                $twitterCon = new TwitterOAuth($consumer_key, $consumer_secret, $twitterAcc[0]['oauth_token'], $twitterAcc[0]['oauth_token_secret']);
                $twitterCon->post('statuses/update', array('status' => $tweet));
                if($deleted){
                    redirect(BASE.'user/profiel#user/socialmedia');
                }else{
                    redirect(BASE.'user/profiel#user/socialmedia'); 
                }
        }
        
        function youtube_old(){
              $data = array();
              $data['logo'] = "logo.png";
              $data['title'] = 'Imoby';
              $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
			//echo  BASEABSPATH;
	          $this->load->plugin('imobyyoutube');
              //ini_set()
			  ini_set('include_path','.;D:\php\includes');
              $this->load->model('msocialmedia');
     	 $this->load->model('mmessage');
              $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
              $youtube_acc_exist = $this->msocialmedia->is_youtube($this->session->userdata('user_id'));
              if(empty($youtube_acc_exist)){
					//echo '<pre>';print_r($_GET);
                  if(isset($_REQUEST['token'])){
				      
                      ini_set('include_path', ini_get('include_path'). ';' .'D:/wamp/www/backoffice/system/plugins;D:/wamp/www/backoffice/');
                      $imobyTube = new ImobyYouTube();
					  
                      $saveMedia = array();
                      $saveMedia['userid'] = $this->session->userdata('user_id');
                      $saveMedia['oauth_token'] = '';
                      $saveMedia['oauth_token_secret'] = $imobyTube->getAuthSubHttpClient(urldecode($_REQUEST['token']));
					  print_r($saveMedia['oauth_token_secret']);
					  die();
                      echo $imobyTube->getAuthSubHttpClient($_REQUEST['token']);die();
                      $youtubeObj = $imobyTube->getYouTubeInstance($saveMedia['oauth_token_secret'], 'imoby-'.$this->session->userdata('user_id'),$this->session->userdata('user_id'));
                      $youtubeObj->setMajorProtocolVersion(2);
                      $userProfileEntry = $youtubeObj->getUserProfile('default');
                      $saveMedia['user_id'] = '';
                      $saveMedia['screen_name'] = (string)$userProfileEntry->getUsername();
                      $saveMedia['added_status'] = 1;
                      $saveMedia['updated_status'] = 0;
                      $saveMedia['social_type'] = 'youtube';
                      $this->msocialmedia->save_socailmedia($saveMedia);
                      redirect('http://app.imoby.nl/user/youtube');
                  }else{
                      ini_set('include_path', ini_get('include_path'). ';' .'D:/wamp/www/backoffice/system/plugins;D:/wamp/www/backoffice/');
                      $imobyTube = new ImobyYouTube();
                      $data['authUrl'] = $imobyTube->getAuthSubRequestUrl();
                  }
              }else{
                  
                     ini_set('include_path', ini_get('include_path'). ';' .'D:/wamp/www/backoffice/system/plugins;D:/wamp/www/backoffice');
                     $imobyTube = new ImobyYouTube();
                     $youtubeObj = $imobyTube->getYouTubeInstance($youtube_acc_exist[0]['oauth_token_secret'], 'imoby-'.$this->session->userdata('user_id'),$this->session->userdata('user_id'));
                     $youtubeObj->setMajorProtocolVersion(2);

                     $userProfileEntry = $youtubeObj->getUserProfile('default');
                     $data['youtube_username'] = $userProfileEntry->getUsername();
                     $data['youtube_plogo']  = $userProfileEntry->getThumbnail()->getUrl();
                     $data['youtube_since']  = $userProfileEntry->getPublished()->text;
                     
                     $statistics = $userProfileEntry->getStatistics();
                     $data['last_loggin']  = $statistics->getLastWebAccess();
                     $data['channel_views']  = $statistics->getViewCount();
                     $data['video_viewed']  = $statistics->getVideoWatchCount();
                     $data['subscribers']  = $statistics->getSubscriberCount();
                     $data['uploads']  = $userProfileEntry->getFeedLink('http://gdata.youtube.com/schemas/2007#user.uploads')->countHint;
                     $data['youtube_link']   = 'http://youtube.com/'.$userProfileEntry->getUsername();
                     $data['added_status']   = $youtube_acc_exist[0]['added_status'];
                     $data['updated_status'] = $youtube_acc_exist[0]['updated_status'];
                     
              }
              
              
              ini_set('include_path','.;C:/wamp/bin/php/php5.3.10;C:/wamp/bin/php/php5.3.10'); //
              $this->load->view('user/vheader',$data);
              $this->load->view('user/profile/youtube/vyoutube',$data);
              $this->load->view('user/vfooter');
              
        }
      
       
        function youtube(){
            $data = array();
            $data['logo'] = "logo.png";
            $data['title'] = 'Imoby';
            $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
            
            $this->load->model('msocialmedia');
            $this->load->model('mmessage');
            $this->load->model('mmobileapps');
            $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
            $youtube_acc_exist =  $this->msocialmedia->is_youtube($this->session->userdata('user_id'));
            if(count($youtube_acc_exist)==0){
                redirect(BASE.'user/linkyoutube');
                exit();
            }
            
            $data['youtube_username'] =  $youtube_acc_exist[0]['screen_name'];
            $data['youtube_link'] =  $youtube_acc_exist[0]['user_id'];
            $data['added_status'] = $youtube_acc_exist[0]['added_status'];
            $data['updated_status'] = $youtube_acc_exist[0]['updated_status'];
            $data['msgText'] = $youtube_acc_exist[0]['social_post'];
            
            $data['userid'] = $this->session->userdata('user_id');
            $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
            $this->load->view('user/vheader',$data);
            $this->load->view('user/profile/youtube/vyoutube',$data);
            $this->load->view('user/vfooter');
              
        }
        
        function linkyoutube($partOne=false, $partTwo=false){
            if ( ($partOne) && ($partTwo)) {
                $_GET['code'] = $partOne.'/'.$partTwo;
            }
 
            $this->load->plugin('newyoutubelink'); //newyoutubelink_pi.php
            $youtube = new NewYoutubeLink();
            
            if(!isset($_GET['code']) ){ // no code yet, so redirect to google auth
                $authToken = $youtube->authUrl();
            }
            else if(isset($_GET['code'])){ // got code, save it and redirect to youtube
                $accessToken = $youtube->authUrl($_GET['code']);
                $youtube->setAccessToken($accessToken);
                $this->load->model('msocialmedia');
                $saveMedia = array();
                $saveMedia['userid'] = $this->session->userdata('user_id');
                $saveMedia['oauth_token'] = $accessToken;
                $saveMedia['oauth_token_secret'] = 'x';
                $saveMedia['user_id'] = 'Moet nog worden opgehaald';
                $saveMedia['screen_name'] = 'Moet nog worden opgehaald';
                $saveMedia['added_status'] = 1;
                $saveMedia['updated_status'] = 1;
                $saveMedia['social_type'] = 'youtube';
                $saveMedia['link_date'] = date("Y-m-d");
                $this->msocialmedia->save_socailmedia($saveMedia);      
                
               //echo 'data saved, redirect to function youtube again<br />';
               redirect(BASE.'user/youtube');
            }  
        }	
        
        
        
        function deactive_youtube(){
                $this->load->model('msocialmedia'); 
                $deleted  = $this->msocialmedia->delete_socialmedia($this->session->userdata('user_id'),'youtube');
                if($deleted){
                    redirect(BASE.'user/profiel#user/socialmedia');
                }else{
                    redirect(BASE.'user/profiel#user/socialmedia'); 
                }
        }
        
        
        function updateFacebookPage(){
            $data = array();
            $this->load->plugin('imobyfacebook');
            $this->load->model('msocialmedia');
            $userid =  $this->session->userdata('user_id');
            $type = 'facebook';
            $data['user_id'] = $this->input->post('selectedPage');
            if(isset($data['user_id'])) {
                $this->msocialmedia->update_socialmedia_status($userid,$type,$data);
                $fb_account = $this->msocialmedia->is_facebook($this->session->userdata('user_id')); 
                $imobyFB = new ImobyFacebook();
                $user_profile = $imobyFB->get_profile($fb_account[0]['oauth_token_secret']);
                $m = 'Imoby account linked.';
                if($fb_account[0]['user_id']=='0'){
                    $return = $imobyFB->post_on_wall($m, $fb_account[0]['oauth_token_secret']);
                }
                else{
                   // get fanpage token
                    $fanPages = $imobyFB->getFanPages($fb_account[0]['oauth_token_secret']); 
                    $pageToken = false;   
                    foreach($fanPages['data'] as $key => $page) {
                        if($page['id']==$data['user_id']){
                            $pageToken = $page['access_token'];
                        }
                    }
                    $return = $imobyFB->post_on_page($fb_account[0]['user_id'], $m, $pageToken); 
                }
            }       
        }
        
        
        function facebook(){
    	    session_start();
            $this->load->plugin('imobyfacebook');
            $this->load->model('msocialmedia');
            $this->load->model('mmessage');
            $this->load->model('mmobileapps');
            $data = array();
            $data['logo'] = "logo.png";
            $data['title'] = 'Imoby';
	        $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
            $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
	        $fb_acc_exist = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
            

            if(empty($fb_acc_exist)){
                $imobyFB = new ImobyFacebook();
				$userFBID = $imobyFB->getFBUser();
                
                if($userFBID){
                    $saveMedia = array();
                    $saveMedia['userid'] = $this->session->userdata('user_id');
                    $saveMedia['oauth_token'] = $imobyFB->getFBUser();
                    $saveMedia['oauth_token_secret'] = (string)$imobyFB->getFBAccesToken();
                    $saveMedia['user_id'] = "";
                    
                    $saveMedia['screen_name'] = $imobyFB->get_username($saveMedia['oauth_token_secret']);
                    $saveMedia['added_status'] = 1;
                    $saveMedia['updated_status'] = 1;
                    $saveMedia['social_type'] = 'facebook';
                    $saveMedia['link_date'] = date("Y-m-d");
                    $this->msocialmedia->save_socailmedia($saveMedia);
                    redirect(BASE.'user/facebook/');
                    
                }else{
                    $data['authUrl'] = $imobyFB->getAuthUrl();
                    echo $data['authUrl'];
                }
                
            }else{
		try{	
                $imobyFB = new ImobyFacebook();
                $userFBID = $imobyFB->getFBUser();
				$user_profile = $imobyFB->get_profile($fb_acc_exist[0]['oauth_token_secret']);
               
                // Display pages
                $fanPages = array();
                $fanPages = $imobyFB->getFanPages($fb_acc_exist[0]['oauth_token_secret']); 
                $fanPages['data'][count($fanPages)+1]['name'] = $user_profile['name'].' (prive)';
                $fanPages['data'][count($fanPages)+1]['id'] = '0';                     
               
                
                $data['fanPages'] = $fanPages['data'];
                $data['selected_fanPage'] = $fb_acc_exist[0]['user_id'];
                $data['fb_username'] = $imobyFB->get_username($fb_acc_exist[0]['oauth_token_secret']);            
                $data['fb_verified'] = $user_profile['verified'];
                $data['friends'] = $imobyFB->num_friends($fb_acc_exist[0]['oauth_token_secret']);
                $data['fb_link'] = $user_profile['link'];
                $data['added_status'] = $fb_acc_exist[0]['added_status'];
                $data['updated_status'] = $fb_acc_exist[0]['updated_status'];
                $data['userid'] = $this->session->userdata('user_id');
                $data['msgText'] = $fb_acc_exist[0]['social_post'];
                
                // ask for fanpages and set pageId to post on.
                
                
                }catch(Exception $ex){
                    redirect(BASE.'user/facebook/');
                }
                
            }
            $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
            $this->load->view('user/vheader',$data);
            $this->load->view('user/profile/facebook/vfbook',$data);
            $this->load->view('user/vfooter');
              
        }
        
function _facebook_TEST(){
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $this->load->plugin('imobyfacebook');
    $this->load->model('msocialmedia');
    $this->load->model('mmessage');
    $this->load->model('mmobileapps');
    $data = array();
    $data['logo'] = "logo.png";
    $data['title'] = 'Imoby';
    $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
    $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
    $fb_acc_exist = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
    
    if($fb_acc_exist){
        $imobyFB = new ImobyFacebook();
		$user_profile = $imobyFB->get_profile($fb_acc_exist[0]['oauth_token_secret']);
        print '<pre>$fb_acc_exist:<br />';     print_r($fb_acc_exist);           print '$user_profile<br />'; print_r($user_profile);        print '</pre>';
        /*
        $post = $imobyFB->post_on_wall('Logged in From '.BASE.' at :'.date('Y-m-d H:i:s'), $fb_acc_exist[0]['oauth_token_secret']);
        if($post){
           echo 'posted<br />';
        } 
        else{
            echo 'cant post<br />';
        }
       
        */
        $fb_acc_exist[0]['oauth_token_secret'] = $fb_acc_exist[0]['oauth_token_secret'].'x';
        $fanPages = $imobyFB->getFanPages($fb_acc_exist[0]['oauth_token_secret']);
        $page_id = $fanPages['profile_id'];
        print '$fanPages<pre>';     print_r($fanPages);      print '</pre>';
        
        echo 'Token:<br />';
        $test = $imobyFB->exchangeToken($fb_acc_exist[0]['oauth_token_secret']);
        echo '$test:'.$test.'<br />#Token:<br />';
    
    
         /*
        $page_id = '574588179264200';
        $message = 'testing';
        try {
        	$page_info = $imobyFB->askApi("/$page_id?fields=access_token");
            print '$page_info<pre>';     print_r($page_info);      print '</pre>';
        	if( !empty($page_info['access_token']) ) {
        		$args = array(
        			'access_token'  => $page_info['access_token'],
        			'message'       => $message 
        			);
        		//$post_id = $imobyFB->post_on_page("/$page_id/feed", $message,$page_info['access_token']);
                print '$post_id<pre>';     print_r($post_id);      print '</pre>';
        	} 
        	else {
        	    $permissions = array();
        		$permissions = $imobyFB->askApi("/me/permissions");
                print '$permissions<pre>';     print_r($permissions);      print '</pre>';
                if(is_array($permissions)){
            		if( !array_key_exists('publish_stream', $permissions['data'][0]) || !array_key_exists('manage_pages', $permissions['data'][0])) {
            			echo 'no permissions!';
            		}
                }
                else{
                    echo 'permissions not a array!';
                }
        	}
        } 
        catch  (Exception $e) {
        	echo 'Error: '.$e.'<br/>';
        	$user = null;
        }   
        */     
    }
    else{
        echo 'No facebook account!';
    }
    
    
    $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
    $this->load->view('user/vheader',$data);
    $this->load->view('user/profile/facebook/vfbook',$data);
    $this->load->view('user/vfooter');
}
        
        function fb_test(){
            $this->load->plugin('imobyfacebook');
            $this->load->model('msocialmedia');
            $fb = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
            
            
            $imobyFB = new ImobyFacebook();
            
            $res = $imobyFB->post_on_wall('Test App post seconds:'.date('s'), $fb[0]['oauth_token_secret']);
            print_r($res);
            $prof = $imobyFB->get_profile($fb[0]['oauth_token_secret']);
            echo '<pre>';
            print_r($prof);
            
        }
        
        function deactive_facebook(){
                $this->load->model('msocialmedia'); 
                $deleted  = $this->msocialmedia->delete_socialmedia($this->session->userdata('user_id'),'facebook');
                if($deleted){
                    redirect(BASE.'user/profiel#user/socialmedia');
                }else{
                    redirect(BASE.'user/profiel#user/socialmedia'); 
                }
        }

        function updateSocialMediaStatus()
        {
            $userid = $this->input->post('userid');
            $type   = $this->input->post('type');
            $field  = $this->input->post('field');
            $status = $this->input->post('status');
            $data = array();
            $this->load->model('msocialmedia');
            
            $data[$field] = $status;
            $this->msocialmedia->update_socialmedia_status($userid,$type,$data);
            
            
        }
        
        function updateSocialMediaPost()
        {
            $userid = $this->input->post('userid');
            $type   = $this->input->post('type');
            $text   = $this->input->post('text');
            $data = array();
            $this->load->model('msocialmedia');
            
            $data['social_post'] = $text;
            $this->msocialmedia->update_socialmedia_status($userid,$type,$data);
        }

        function presentaties(){
                redirect(BASE.'user/profiel');
                $this->load->model('mobject');
                $this->load->model('mobjectmedia');
                $this->load->library('pagination');
                $this->load->model('msocialmedia');
		$this->load->model('mmessage');
		$this->load->model('mppresentation');
                $this->load->model('mcar_specs');
                $this->load->model('mmobileapps');
                $member_type = $this->session->userdata('member_type');
                
                
                
                $data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                
                $offset = $this->uri->segment(3);
                if(empty($offset)){
                        $offset=0;
                }
                $limit = 30;
                $config['total_rows'] = $this->mobject->count_available_objects($this->session->userdata('imobycode'));
                $config['per_page'] = $limit;
                $config['base_url'] = BASE.'user/presentaties/';
                $config['cur_tag_open'] = '<a class="selected" >';
                $config['cur_tag_close'] = "</a>";
                $config['num_links'] = 3;
                
                $config['next_link'] = "&gt;";
                $config['first_link'] = "<<";
                $config['last_link'] = ">>";
                
                $data['totalpages'] = ceil($config['total_rows']/$limit);
                $data['currentPage'] = ($offset/$limit)+1;
                $this->pagination->initialize($config);

                
                
                $objects = $this->mobject->get_available_objects($this->session->userdata('imobycode'),$limit,$offset);

                foreach($objects as $key => $object){
                        if($member_type == $this->member_types[1]){
                            
                           $objects[$key]['car_title'] = $this->mcar_specs->get_car_title($this->session->userdata('imobycode'),$object['ObjectTiaraID']);
                        }
                        $medias = $this->mobjectmedia->get_object_medias($object['ObjectTiaraID']);
                        
			
                        $objects[$key]['media_group'] = $medias[0]['media_group'];
                        if($object['custom_object_id'] == 0){
                            if($member_type == $this->member_types[1]){
                                //$objects[$key]['url'] = substr($medias[0]['media_url'],0,strlen($medias[0]['media_url'])-1);
                                $objects[$key]['url'] = BASE.'fileserver/bofiles/downloads/'.$object['NVMVestigingNR'].'/'.$object['ObjectTiaraID'].'/'.$medias[0]['media_url'];
                            }else{
                                $objects[$key]['url'] = substr($medias[0]['media_url'],0,strlen($medias[0]['media_url'])-1).'5';
                                
                            }
			}else{
				$objects[$key]['url'] = $medias[0]['media_url'];
			}
				

                }
                
                $data['facebook'] = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
                $data['twitter'] = $this->msocialmedia->is_twitter($this->session->userdata('user_id'));
                $data['youtube'] = $this->msocialmedia->is_youtube($this->session->userdata('user_id'));
                $data['objects'] = $objects;
		
                $data['pagination'] = $this->pagination->create_links();
		$data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/presentation/vcurrentpresentation',$data);
		$this->load->view('user/vfooter');
	}
        
        function search_presentaties(){
                $data = array();
                $this->load->model('mobject');
                $this->load->model('mobjectmedia');
                $object_tiaraid = $this->input->post('searchTxt');
                $objects = $this->mobject->get_object_by_code($object_tiaraid);
                
                foreach($objects as $key => $object){
                    
                        $medias = $this->mobjectmedia->get_object_medias($object['ObjectTiaraID']);
                        

                        $objects[$key]['media_group'] = $medias[0]['media_group'];
                        $objects[$key]['url'] = substr($medias[0]['media_url'],0,strlen($medias[0]['media_url'])-1).'5';

                }
                $data['objects'] = $objects;
                $this->load->view('user/presentation/vsrchpresentation',$data);
        }
	
	function huidigepresentaties(){   // need to change currentpresentation -> huidigepresentaties 
//            error_reporting(E_ALL);    
            $this->load->model('mmessage');
                $this->load->model('mcar_specs');
                $this->load->model('mmobileapps');
                $member_type = $this->session->userdata('member_type');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $this->load->model('mobject');
                $this->load->model('mobjectmedia');
                $this->load->library('pagination');
                $this->load->model('msocialmedia');
		$this->load->model('mppresentation');
                $data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $offset = $this->uri->segment(3);
                if(empty($offset)){
                        $offset=0;
                }
                $limit = 30;
                $config['total_rows'] = $this->mobject->count_available_objects($this->session->userdata('imobycode'));
                $config['per_page'] = $limit;
                $config['base_url'] = BASE.'user/huidigepresentaties/';
                
                $config['cur_tag_open'] = '<a class="selected" >';
                $config['cur_tag_close'] = "</a>";
                $config['num_links'] = 3;
                
                $config['next_link'] = "&gt;";
                $config['first_link'] = "<<";
                $config['last_link'] = ">>";
                
                $data['totalpages'] = ceil($config['total_rows']/$limit);
                $data['currentPage'] = ($offset/$limit)+1;
                $this->pagination->initialize($config);

                
                $objects = $this->mobject->get_available_objects($this->session->userdata('imobycode'),$limit,$offset);

                foreach($objects as $key => $object){
                        
                        if($member_type == $this->member_types[1]){
                            
                           $objects[$key]['car_title'] = $this->mcar_specs->get_car_title($this->session->userdata('imobycode'),$object['ObjectTiaraID']);
                        }
                    
                        $medias = $this->mobjectmedia->get_object_medias($object['ObjectTiaraID']);
                        

                        $objects[$key]['media_group'] = $medias[0]['media_group'];
			if($object['custom_object_id'] == 0){
				if($member_type == $this->member_types[1]){
                                    $objects[$key]['url'] = substr($medias[0]['media_url'],0,strlen($medias[0]['media_url'])-1);
                                }else{
                                    $objects[$key]['url'] = substr($medias[0]['media_url'],0,strlen($medias[0]['media_url'])-1).'5';
                                }
			}else{
				$objects[$key]['url'] = $medias[0]['media_url'];
			}
                }
                
                $data['facebook'] = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
                $data['twitter'] = $this->msocialmedia->is_twitter($this->session->userdata('user_id'));
                $data['youtube'] = $this->msocialmedia->is_youtube($this->session->userdata('user_id'));
                $data['objects'] = $objects;
                $data['pagination'] = $this->pagination->create_links();
				$data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
				$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/presentation/vcurrentpresentation',$data);
		$this->load->view('user/vfooter');
	}
	
	function set_object_online(){
		$this->load->model('mobject');
		$objectid = $this->input->post('objectid');
		$data = array();
		$data['mobile_view_status'] = 'online';
		$updated = $this->mobject->change_object_status($objectid,$data);
		if($updated){
			echo 1;
		}else{
			echo 0;
		}
	}
	function set_object_offline(){
		$this->load->model('mobject');
		$objectid = $this->input->post('objectid');
		$data = array();
		$data['mobile_view_status'] = 'offline';
		$updated = $this->mobject->change_object_status($objectid,$data);
		if($updated){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	function set_app_online(){
		$this->load->model('mmobileapps');
		$objectid = $this->input->post('objectid');
		$data = array();
		$data['status'] = 1;
		$updated = $this->mmobileapps->change_object_status($objectid,$data);
		if($updated){
			echo 1;
		}else{
			echo 0;
		}
	}
	function set_app_offline(){
		$this->load->model('mmobileapps');
		$objectid = $this->input->post('objectid');
		$data = array();
		$data['status'] = 0;
		$updated = $this->mmobileapps->change_object_status($objectid,$data);
		if($updated){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	function creeerpresentatie(){  // need to change createpresentation -> Creëer presentatie
		
                $this->load->model('mmessage');
		$this->load->model('mppresentation');
                $this->load->model('mmobileapps');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
		$data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['member_type'] = $this->session->userdata('member_type');
                $dictionary = $this->db->get('dictonary_accessories');
                $data['dictionary'] = $dictionary->result_array();
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/presentation/vcreatepresentation',$data);
		$this->load->view('user/vfooter');
                
	}
	
	
	function ajaxpresentationpreview(){
            
            $presen = $this->input->post('presentation');
            
            if( $presen && $presen['filmcount'] ){
                
                $presen = json_decode($presen, true);
                //var_dump($presen);
                //echo $presen['film0']['imglarge'];
                $xmlfile = 'slickboard/test.xml';
                $xmlwrite = fopen($xmlfile, 'w') or die('Cannot open file:  '.$xmlfile);
                
                $data = '<slickboard>';
                if( $presen['bgaudio'] ){
                    $data .= '<sound><clip id="music" url="'.$presen['bgaudio'].'" delay="0" stream="5" timeout="30" retry="2" /></sound>';
                    $data .= '<action><item type="sound_play" target="music" event="timer" delay="0" loop="0" /><item type="global_volume" event="timer" delay="0" volume="0.2" /></action>';
                }
                
                for($i=0; $i<$presen['filmcount']; $i++){
                    $img = '<object><image url="'. $presen['film'.$i]['imglarge'] .'" fill="trim" width="640" height="480" />';
                    $slide = '<slide duration="'. $presen['film'.$i]['slideduration'] .'" preload="2" />';
                    if($presen['film'.$i]['effectnumber'] > 0){
                        $effect = '<transition_in type="fly" duration="'. $presen['film'.$i]['effectduration'] .'" startPoint="'. $presen['film'.$i]['effectnumber'] .'" /></object>';
                    }else{
                        $effect = '<transition_in type="fade" duration="'. $presen['film'.$i]['effectduration'] .'" /></object>';
                    }
                    $data .= $img . $slide . $effect;
                }
                
                $ctrlbarStart = '<object offset_x="0" offset_y="460"><rect width="650" height="20" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" shadow="control_bar" /><rect width="650" height="20" fill_color="4488ff" fill_alpha=".5" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" />';
                $backButton = '<object id="backward" offset_x="25" offset_y="5" ><polygon fill_color="ffffff" state="hit"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><action><item type="slideshow_backward" /></action></object>';
                $playButton = '<object id="play" offset_x="8" offset_y="0" ><rect width="10" height="15" fill_alpha="0" state="hit" /><rect x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" /><rect x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" /><rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" /><rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" /><rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" /><rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" /><polygon fill_color="ffffff" state="checked" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><polygon fill_color="ffffff" state="checked_over" glow="control" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><polygon fill_color="ffaaaa" state="checked_press" glow="control" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><action><item type="slideshow_toggle" /><item type="sounds_pause" event="check" /><item type="sounds_resume" event="uncheck" /></action></object>';
                $forwardButton = '<object id="forward" offset_x="122" offset_y="5" ><polygon fill_color="ffffff" state="hit"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><action><item type="slideshow_forward" /></action></object>';
                $volumeButton = '<object id="volume" offset_x="530" offset_y="2" ><rect width="100" height="15" fill_color="224488" corner_tl="10" corner_tr="10" corner_br="10" corner_bl="10"  shadow="inner" /><object id="speaker_cloak"><rect x="95" y="0" width="1" height="1" fill_alpha="0"  /></object><object id="speaker_constrain"><rect x="2" y="4" width="96" height="10" fill_alpha="0"  /></object><object id="speaker" shadow="default"><rect x="2" y="2" width="26" height="15" fill_alpha="0" state="hit" /><polygon fill_color="ffffff"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><object><circle x="15" y="8" radius="6" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha="1" line_thickness="3" /><cloak target="speaker_cloak" radius_1="50" radius_2="75" /></object><object> <circle x="15" y="8" radius="10" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".75" line_thickness="2" /><cloak target="speaker_cloak" radius_1="25" radius_2="50" /></object><object><circle x="15" y="8" radius="14" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".5" line_thickness="1" /><cloak target="speaker_cloak" radius_1="0" radius_2="30" /></object><constrain target="speaker_constrain" reflect="0" /><action><item type="adjust_global_volume" event="slider" /><item type="drag" target="speaker" /></action></object></object>';
                $ctrlbarEnd = '</object><filter><shadow id="default" /><shadow id="control_bar" knockout="true" distance="5" alpha=".25" blurX="10" blurY="10" /><shadow id="inner" inner="true" distance="3" alpha=".25" blurX="5" blurY="5" /><glow id="control" color="ff4400" alpha=".9" blurX="10" blurY="10" inner="false" /></filter>';
                
                $data .= $ctrlbarStart . $playButton . $volumeButton . $ctrlbarEnd ;
                $data .= '</slickboard>';
                
                fwrite($xmlwrite, $data);
                fclose($xmlwrite);
                
                $result = BASE.$xmlfile.'?unique_id='.time();
                echo $result;
                
            }else{
                echo 'Sorry! No data received';
            }
            /* function ends */
        }
	
	
	function ajaxcleartmpdir(){
            
            $tmpDir = $this->input->post('tmpDir');
            $files = glob($tmpDir.'/*'); // get all file names
            if( !empty($files) ){
                
                foreach($files as $file){ // iterate files
                    if(is_file($file))
                        $result = unlink($file); // delete file
                }
                echo $result;
                
            }else{
                echo 'Sorry! No data received';
            }
            /* function ends */
        }
        
        function ajaxcreatetextimage(){
            
            parent::Controller();    
            session_start();
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        
            $txtimg = $this->input->post('txtimg');
            $txtimg = json_decode($txtimg, true);
            
            if($txtimg){
                require_once (APPPATH.'libraries/Image_Toolbox.class.php');
                //var_dump($txtimg); 
                if($txtimg['mode'] == 'new'){
                    /* For Mode New */
                    if(preg_match('/(^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$)/i', $txtimg['image'])){
                        $imgtoolbox = new Image_Toolbox(640, 480, $txtimg['image']);
                        $originalname = $txtimg['image'];
                    }else{
                        $imgtoolbox = new Image_Toolbox(BASEABSPATH.$txtimg['image']);
                        $originalname = 'original_'.$txtimg['eachunique'].'_'.$txtimg['id'].'_640x480.jpg';
                        $imgtoolbox->save(BASEABSPATH.'fileserver/bofiles/downloads/'.$txtimg['code'].'/'.$originalname);
                    }
                    
                    if($txtimg['textcount'] > 0){
                        for($i=1; $i<=$txtimg['textcount']; $i++){
                            $text = $txtimg['text'.$i]['msg'];
                            $txtimg['text'.$i]['font'] = str_replace(' ', '', $txtimg['text'.$i]['font']);
                            if($txtimg['text'.$i]['weight']=='bold'){
                                $txtimg['text'.$i]['font'] = $txtimg['text'.$i]['font'].'_b';
                            }
                            if($txtimg['text'.$i]['style'] == 'italic'){
                                $txtimg['text'.$i]['font'] = $txtimg['text'.$i]['font'].'_i';
                            }
                            
                            $font = BASEABSPATH.'Font/win/'.$txtimg['text'.$i]['font'].'.ttf';
                            $font_size = $txtimg['text'.$i]['size'];
                            $font_color = $txtimg['text'.$i]['color'];
                            $x_axis = ($txtimg['text'.$i]['axisX']);
                            $y_axis = ($txtimg['text'.$i]['axisY'] + (($font_size-16)+18)); /* Little bit height adjustment */
                            if($txtimg['text'.$i]['uline'] == 'underline'){
                                $len=strlen($text);
                                $text.='%0d'.str_repeat('_', ($font_size * $len) / ($font_size * 1.25));
                                $text=urldecode($text);
                            }
                            
                            $imgtoolbox->addText($text, $font, $font_size, $font_color, $x_axis, $y_axis,$angle = 0);
                        }
                    }
                    
                    if(preg_match('/(^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$)/i', $txtimg['image'])){
                        $imgtoolbox->addImage(640, 480, $txtimg['image']);
                    }else{
                        $imgtoolbox->addImage(BASEABSPATH.$txtimg['image']);
                    }
                    $newname = 'textimg_'.$txtimg['eachunique'].'_'.$txtimg['id'].'_640x480.jpg';
                    $newfile = BASEABSPATH.'fileserver/bofiles/downloads/'.$txtimg['code'].'/'.$newname;
                    $newthumb = str_replace('640x480', '214x160', $newfile);
                    $imgtoolbox->save($newfile);
                    $imgtoolbox->newOutputSize(214, 160);
                    $imgtoolbox->save($newthumb);
                    //var_dump($imgtoolbox);
                }else{
                    /* For Mode Edit */
                    if(preg_match('/(^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$)/i', $txtimg['image'])){
                        $imgtoolbox = new Image_Toolbox(640, 480, $txtimg['image']);
                        $originalname = $txtimg['image'];
                    }else{
                        $imgtoolbox = new Image_Toolbox(BASEABSPATH.'fileserver/bofiles/downloads/'.$txtimg['code'].'/'.$txtimg['image']);
                        $originalname = 'original_'.$txtimg['eachunique'].'_'.$txtimg['id'].'_640x480.jpg';
                        $imgtoolbox->save(BASEABSPATH.'fileserver/bofiles/downloads/'.$txtimg['code'].'/'.$originalname);
                    }
                                        
                    if($txtimg['textcount'] > 0){
                        for($i=1; $i<=$txtimg['textcount']; $i++){
                            $text = $txtimg['text'.$i]['msg'];
                            $txtimg['text'.$i]['font'] = str_replace(' ', '', $txtimg['text'.$i]['font']);
                            if($txtimg['text'.$i]['weight']=='bold'){
                                $txtimg['text'.$i]['font'] = $txtimg['text'.$i]['font'].'_b';
                            }
                            if($txtimg['text'.$i]['style'] == 'italic'){
                                $txtimg['text'.$i]['font'] = $txtimg['text'.$i]['font'].'_i';
                            }
                            
                            $font = BASEABSPATH.'Font/win/'.$txtimg['text'.$i]['font'].'.ttf';
                            $font_size = $txtimg['text'.$i]['size'];
                            $font_color = $txtimg['text'.$i]['color'];
                            $x_axis = ($txtimg['text'.$i]['axisX']);
                            $y_axis = ($txtimg['text'.$i]['axisY'] + (($font_size-16)+18)); /* Little bit height adjustment */
                            if($txtimg['text'.$i]['uline'] == 'underline'){
                                $len=strlen($text);
                                $text.='%0d'.str_repeat('_', ($font_size * $len) / ($font_size * 1.25));
                                $text=urldecode($text);
                            }
                            
                            $imgtoolbox->addText($text, $font, $font_size, $font_color, $x_axis, $y_axis,$angle = 0);
                        }                        
                    }
                    
                    if(preg_match('/(^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$)/i', $txtimg['image'])){
                        $imgtoolbox->addImage(640, 480, $txtimg['image']);
                    }else{
                        $imgtoolbox->addImage(BASEABSPATH.'fileserver/bofiles/downloads/'.$txtimg['code'].'/'.$txtimg['image']);
                    }
                    $newname = 'textimg_'.$txtimg['eachunique'].'_'.$txtimg['id'].'_640x480.jpg';
                    $newfile = BASEABSPATH.'fileserver/bofiles/downloads/'.$txtimg['code'].'/'.$newname;
                    $newthumb = str_replace('640x480', '214x160', $newfile);
                    $imgtoolbox->save($newfile);
                    $imgtoolbox->newOutputSize(214, 160);
                    $imgtoolbox->save($newthumb);
                }
                $result = array(
                    'id' => $txtimg['id'],
                    'mode' => $txtimg['mode'],
                    'code' => $txtimg['code'],
                    'imgname' => $newname,
                    'thumbname' => str_replace('640x480', '214x160', $newname),
                    'original' => $originalname
                );
                
                echo json_encode($result);
                //var_dump($result);
                
            }else{
                echo 'Sorry! No data received';
            }
            /* function ends */
        }
	
	function save_presentation(){
		$this->load->model('mppresentation');
		$data = array();
		
                $id = $this->input->post('pid');
		$data['jsondata'] = $this->input->post('myPresentation');
		$data['NVMVestigingNR'] = $this->session->userdata('imobycode');
                if($id == '')
                    $saved = $this->mppresentation->save_pp($data);
                else
                    $saved = $this->mppresentation->update_pp($id,$data);                   
                    
		if($saved){
			echo $saved;
		}else{
			echo 0;
		}
	}
	
	function wachtrij(){
		$this->load->library('pagination');
		$this->load->model('mppresentation');
		$this->load->model('mmessage');
		$this->load->model('mmobileapps');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
		$data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
		
		$offset = $this->uri->segment(3);
                if(empty($offset)){
                        $offset=0;
                }
                $limit = 30;
                $config['total_rows'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
                $config['per_page'] = $limit;
                $config['base_url'] = BASE.'user/wachtrij/';
                
                $config['cur_tag_open'] = '<a class="selected" >';
                $config['cur_tag_close'] = "</a>";
                $config['num_links'] = 3;
                
                $config['next_link'] = "&gt;";
                $config['first_link'] = "<<";
                $config['last_link'] = ">>";
                
                $data['totalpages'] = $config['total_rows'];
                $data['currentPage'] = ($offset/$limit)+1;
                $this->pagination->initialize($config);
		
		$pendingpres = $this->mppresentation->get_pp($this->session->userdata('imobycode'),$limit,$offset);
		
		$ppresentation = array();
		if(!empty($pendingpres)){
			foreach($pendingpres as $key=>$pp){
				$ppresentation[$key]['id'] = $pp['pendingp_id'];
				$ppresentation[$key]['NVMVestigingNR'] = $pp['NVMVestigingNR'];
				$ppresentation[$key]['jsondata'] = json_decode($pp['jsondata']);
			}
		}
		$data['pagination'] = $this->pagination->create_links();
		$data['pendingPresentations'] = $ppresentation;
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/presentation/vpendingpresentation',$data);
		$this->load->view('user/vfooter');
	}
        
        public function wachtrij_delete()
        {
            $this->load->model('mppresentation');
            $pendingPresentation_id = $this->input->post('objectid',true);
            
            $deleted = $this->mppresentation->delete_pp($pendingPresentation_id);
            $response = array();
            
            if($deleted)
            {
                $response['status'] = 200;
                $response['msg'] = 'Successfully Deleted';
                $response['redirectUrl'] = BASE.$this->uri->segment(1).'/huidigepresentaties';
                
            }else{
                
                $response['status'] = 500;
                $response['msg'] = 'Sorry! Object not deleted. Try again later';
            }
            
            echo json_encode($response);
        }
        
	function editpresentation($ppid){
            
            parent::Controller();    
            session_start();
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
            
		$this->load->model('mppresentation');
		$this->load->model('mmessage');
		$this->load->model('mmobileapps');
		$data = array();
                $data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
		$data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
		if($ppid != ''){
                    $data['ppid'] = $ppid;
                    $ppdatabyid = $this->mppresentation->getpp_byid($ppid);
                    if($ppdatabyid){
                        $data['ppjson'] = $ppdatabyid[0]['jsondata'];
                        $data['ppjsonInarray'] = json_decode($data['ppjson']);
                    }else{
                        $data['ppjson'] = '';
                        $data['notfound'] = "Sorry! This presentaion is not found or it is not editable.";
                    }
                }else{
                    $data['ppjson'] = '';
                    $data['notfound'] = "Sorry! No presentation selected.";
                }
                $data['member_type'] = $this->session->userdata('member_type');
                $dictionary = $this->db->get('dictonary_accessories');
                $data['dictionary'] = $dictionary->result_array();
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/presentation/veditpresentation',$data);
		$this->load->view('user/vfooter');
	}
        
	function publish_pending_presentation(){
		$this->load->model('mobject');
		$this->load->model('mobjectmedia');
		$this->load->model('mppresentation');
		$this->load->model('mwonendetails');
		$this->load->model('mwoonhuis');
		$this->load->model('mwoonlagen');
		$this->load->model('mverdiepingen');
		$this->load->model('mcar_specs');
		$this->load->model('mcar_uitvoeringens');
		$this->load->model('mcar_uitrustings');
		$this->load->model('msocialmedia');
		$pendingobjectid = $this->input->post('objectid');
		$data = array();
		$pendingObject = $this->mppresentation->getpp_byid($pendingobjectid);
		$member_type = $this->session->userdata('member_type');
		$jsondata = $pendingObject[0]['jsondata'];
		
		$jsondataObj = json_decode($jsondata);/*echo '<pre>';*/
		//print_r($jsondataObj);
		if(!empty($jsondataObj)){
                  
                     foreach($jsondataObj as $Obj){
                         if(property_exists($Obj, 'id')){ 
                           if(!empty($Obj->code)){
                               $imoby_code = $Obj->code;
                           }
                           break;
                         }
                     } 
                    
                  if($member_type == "LAND"){
                      $objectData['NVMVestigingNR'] = $imoby_code;
                      $objectUniqueID = time();
                      $objectData['ObjectTiaraID'] = substr($objectUniqueID, 4,strlen($objectUniqueID));
                      $objectData['country'] = "Nederlands";
                      $objectData['huisnummer'] = "";
                      $objectData['streetnaam'] = $jsondataObj->pStreetnaam;
                      $objectData['postcode'] = $jsondataObj->pPostcode;
                      $objectData['woonplaats'] = $jsondataObj->pwoonplaats;
                      $objectData['land'] = "NL";
                      $objectData['sale_rent'] = $jsondataObj->ptitle;
                      $objectData['prijsvoorvoegsel'] = "";
                      $objectData['koopprijs'] = "";
                      $objectData['koopconditie'] = "";
                      $objectData['aanvaarding'] = $jsondataObj->aanvaarding;
                      $objectData['objectaanmelding'] = "";
                      $objectData['datuminvoer'] = "";
                      $objectData['datumwijziging'] = "";
                      $objectData['status'] = "";
                      $objectData['transactiedatum'] = "";
                      $objectData['bouwvorm'] = $jsondataObj->bouw;
                      $objectData['plaatsing'] = "";
                      $objectData['aanbiedingstekst'] = $jsondataObj->pdescrip;
                      $objectData['custom_object_id'] = $pendingObject[0]['pendingp_id'];


                      $objectId = $this->mobject->save_object($objectData);
                      $wonenDetails['NVMVestigingNR'] = $objectData['NVMVestigingNR'];
                      $wonenDetails['ObjectTiaraID'] = $objectData['ObjectTiaraID'];
                      $wonenDetails['bouwjaar_jaar'] = $jsondataObj->jaar;
                      $wonenDetails['gebruiksoppervlakte_woonfunctie'] = $jsondataObj->woonoppervlak;
                      $wonenDetails['perceeloppervlakte'] = $jsondataObj->perceeloppervlakte;
                      $wonenDetails['inhoud'] = $jsondataObj->inhoud;
                      $wonenDetails['installatie_soortenverwarming'] = $jsondataObj->verwarming;
                      $wonenDetails['soorten_warm_water'] = $jsondataObj->warmwater;
                      $wonenDetails['CVKetel_bandstof'] = $jsondataObj->brandtrof;
                      $wonenDetails['ligging'] = $jsondataObj->ligging;
                      $wonenDetails['tuin_type'] = $jsondataObj->tuin;
                      $wonenDetails['voorzieningen_wonen'] = $jsondataObj->voorzieningen;
                      $wonenDetails['diversen_isolatievormen_isolatie'] = $jsondataObj->isolatie;
                      $wonenDetails['garage_soorten_soort'] = $jsondataObj->garage;

                      $wonenid = $this->mwonendetails->save_wonen($wonenDetails);

                      $woonhuisData['wonenid'] = $wonenid;
                      $woonhuisData['NVMVestigingNR'] = $objectData['NVMVestigingNR'];
                      $woonhuisData['ObjectTiaraID'] = $objectData['ObjectTiaraID'];
                      $woonhuisData['type_woning'] = $jsondataObj->typewoning;
                      $this->mwoonhuis->save_woonhuis($woonhuisData);


                      $woonlagenData['NVMVestigingNR'] = $objectData['NVMVestigingNR'];
                      $woonlagenData['ObjectTiaraID'] = $objectData['ObjectTiaraID'];
                      $woonlagenData['wonenid'] = $wonenid;
                      $woonlagenData['beganegrond_overigeRuimten'] = $jsondataObj->berging;
                      $this->mwoonlagen->save_woonlagen($woonlagenData);

                      $verdiepingenData['wonenid'] = $wonenid;
                      $verdiepingenData['NVMVestigingNR'] = $objectData['NVMVestigingNR'];
                      $verdiepingenData['ObjectTiaraID'] = $objectData['ObjectTiaraID'];
                      $verdiepingenData['aantal_kamers'] = $jsondataObj->aantalkamer;
                      $this->mverdiepingen->save_verdiepingen($verdiepingenData);

                      foreach($jsondataObj as $key => $jObj){
                          if(property_exists($jObj, 'id')){
                            $medialistArray = array();
                            $medialistArray['NVMVestigingNR'] = $objectData['NVMVestigingNR'];
                            $medialistArray['object_id'] = $objectData['ObjectTiaraID'];
                            $medialistArray['media_group'] = "Video";
                            if($jObj->newimage != ""){
                                $medialistArray['media_url'] = $jObj->newimage;
                            }else{
                                $medialistArray['media_url'] = $jObj->image;
                            }
                            $medialistArray['mediaomschrijving'] = "Custom Presentation";
                            $medialistArray['mediaupdate'] = date("Y-m-d");
                            $medialistArray['laatstewijziging'] = date("Y-m-d")."T".date("H:i:s");
                            $this->mobjectmedia->save_medialist($medialistArray);
                          }
                      }
                  
                  }else{
			
                      
                      /*
		       *Nick: Controlle op uniek id voor voertuig + verschil tussen geimporteerde advertenties en
		       *door gebruiker aangemaakt (toevoegen i aan het begin)
		       */
		      $uniqueId = false;
		      $objectUniqueID = time();
		      $objectUniqueIDT = substr($objectUniqueID, 3,strlen($objectUniqueID));
		      while ($uniqueId == false){		
			$objectUniqueID = "I" . $objectUniqueIDT;
			$result = $this->mobject->getObjectByID($objectUniqueID);
			if (empty($result)){
				$uniqueId = true;
			}
			else{
				$objectUniqueIDT = $objectUniqueIDT - 1;				
			}
		      }
		      $objectData['NVMVestigingNR'] = $imoby_code;
		      $objectData['ObjectTiaraID'] = $objectUniqueID;
                      $objectData['country'] = "Nederlands";
                      $objectData['huisnummer'] = "";
                      $objectData['streetnaam'] = "";
                      $objectData['postcode'] = "";
                      $objectData['woonplaats'] = "";
                      $objectData['land'] = "NL";
                      $objectData['sale_rent'] = "";
                      $objectData['prijsvoorvoegsel'] = "";
                      $objectData['koopprijs'] = $jsondataObj->prijs;
                      $objectData['koopconditie'] = "";
                      $objectData['aanvaarding'] = "";
                      $objectData['objectaanmelding'] = "";
                      $objectData['datuminvoer'] = "";
                      $objectData['datumwijziging'] = "";
                      $objectData['status'] = "";
                      $objectData['transactiedatum'] = "";
                      $objectData['bouwvorm'] = "";
                      $objectData['plaatsing'] = "";
                      $objectData['aanbiedingstekst'] = $jsondataObj->pdescrip;
                      $objectData['custom_object_id'] = $pendingObject[0]['pendingp_id'];
                      $objectData['kenteken'] = $jsondataObj->kenteken;
                      $objectData['merk'] = $jsondataObj->merk;
                      $objectData['bouwjaar'] = $jsondataObj->bouwjaar;
                      $objectData['brandstof'] = $jsondataObj->brandstof;
                      $objectId = $this->mobject->save_object($objectData);
                      $this->db->trans_start();
                      foreach($jsondataObj as $key => $jObj){
                          if(property_exists($jObj, 'id')){
                            $medialistArray = array();
                            $medialistArray['NVMVestigingNR'] = $objectData['NVMVestigingNR'];
                            $medialistArray['object_id'] = $objectData['ObjectTiaraID'];
                            $medialistArray['media_group'] = "Video";
                            if($jsondataObj->{$key}->newimage != ""){
                                $medialistArray['media_url'] = $jObj->newimage;
                            }else{
                                $medialistArray['media_url'] = $jObj->image;
                            }
                            $medialistArray['mediaomschrijving'] = "Custom Presentation";
                            $medialistArray['mediaupdate'] = date("Y-m-d");
                            $medialistArray['laatstewijziging'] = date("Y-m-d")."T".date("H:i:s");
                            $this->mobjectmedia->save_medialist($medialistArray);
                            
                          }
                          
                      }
                      $this->db->trans_complete();
                      
                        $saveData = array();
                        
                        
                        $saveData['showroomprijs'] = $jsondataObj->prijs;
                        $saveData['handelsprijs'] = "";
                        $saveData['exportprijs'] = "";
                        $saveData['merk'] = $jsondataObj->merk;
                        $saveData['model'] = $jsondataObj->model;
                        $saveData['uitvoering'] = $jsondataObj->type;
                        $saveData['koetswerk'] = $jsondataObj->carrosserievorm;
                        $saveData['bouwjaar'] = $jsondataObj->bouwjaar;
                        $saveData['versnelling'] = $jsondataObj->transmissie;
                        $saveData['kleur'] = $jsondataObj->kleur;
                        if($jsondataObj->marge){
                        $saveData['marge'] = "true";
                        }else{
                           $saveData['marge'] = "false"; 
                        }
                        $saveData['massa_ledig_gewicht'] = $jsondataObj->gewicht;
                        $saveData['brandstof'] = $jsondataObj->brandstof;
                        $saveData['apkdatum'] = $jsondataObj->apk_datum;
                        $saveData['kilometerstand'] = $jsondataObj->kilometerstand;
                        $car_id = $this->mcar_specs->save_car_spec($saveData,$objectData['NVMVestigingNR'],$objectData['ObjectTiaraID']);
                        
                        $accessories = explode(",", $jsondataObj->accessories);
                        foreach($accessories as $acc){
                            $saveData = array();
                            $saveData['NVMVestigingNR'] = $objectData['NVMVestigingNR'];
                            $saveData['ObjectTiaraID'] = $objectData['ObjectTiaraID'];
                            $saveData['ID'] = "";
                            $saveData['uitrusting'] = mysql_real_escape_string($acc);
                            $this->mcar_uitrustings->save_car_uitrusting($saveData);
                        }
                        
                  }

		}
                
                
                 
		if(!empty($pendingObject)){
                    
                        $facebook = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
                        if(!empty($facebook)){
                             if($facebook[0]['added_status']){
                                 $social_post = $facebook[0]['social_post'];
                                 if(!empty($social_post)){
                                     $this->posttofb($social_post, $facebook[0]['oauth_token_secret'],$objectData['ObjectTiaraID']);
                                 }
                             }
                         }

                         $Twitter = $this->msocialmedia->is_twitter($this->session->userdata('user_id'));
                         if(!empty($Twitter)){
                             if($Twitter[0]['added_status']){
                                 $social_post = $Twitter[0]['social_post'];
                                 if(!empty($social_post)){
                                     $this->posttotwitter($social_post, $Twitter[0]['oauth_token'], $Twitter[0]['oauth_token_secret'],$objectData['ObjectTiaraID']);
                                 }
                             }
                         }
                     
			$this->mppresentation->update_pp($pendingObject[0]['pendingp_id'],array('publish'=>1));
                        
                        
                        $insertData = array();
                        $insertData['ObjectTiaraID'] = $objectData['ObjectTiaraID'];
                        $insertData['duration'] = $jsondataObj->pduration;
                        $insertData['NVMVestigingNR'] = $objectData['NVMVestigingNR'];
                        $insertData['is_done'] = 0;
                        
                        
                        $this->db->insert('object_pending_3gp ',$insertData);
		}
		
		
	}
        
        function posttofb($msg,$token,$objectid){
            session_start();
            $this->load->plugin('imobyfacebook');
            $imobyFb = new ImobyFacebook();
            $imobyFb->post_on_wall($msg.' http://imoby.nl/'.$objectid, $token);
        }
        
        function posttotwitter($msg,$tokenAuth,$tokenSecret,$objectid){
            $this->load->plugin('twitteroauth');
            require_once(APPPATH.'libraries/twitter/secret.php');
            $twitterCon = new TwitterOAuth('EiJ0JNqlINlPxKOAMh3cw', 'GZ50vfq8vhWanVpI5830sHGn1XCeyOxiZ1l7im7Z5rc', $tokenAuth, $tokenSecret);
            $tweet = $msg.' http://imoby.nl/'.$objectid;
            $twitterCon->post('statuses/update', array('status' => $tweet));
        }
	
        function generateVideoFromSWF()
        {
            $this->db->where('is_done', 0);
            $query = $this->db->get('object_pending_3gp');

            if ($query->num_rows() > 0)
            {
                $row = $query->row();
                echo getcwd().DIRECTORY_SEPARATOR."fileserver/bofiles/downloads".DIRECTORY_SEPARATOR.$row->NVMVestigingNR.DIRECTORY_SEPARATOR;
                var_dump($row);
                $URL = "http://b.imoby.nl/user/webincludes/".$row->ObjectTiaraID;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $URL);
                $data = curl_exec($ch);
                curl_close($ch);
            }


        }
        
        function qrcode(){
                $this->load->model('mobject');
                $this->load->model('mobjectmedia');
				$this->load->model('mmessage');
                $this->load->model('mcar_specs');
                $this->load->model('mppresentation');
                $this->load->model('mmobileapps');
                $member_type = $this->session->userdata('member_type');
                $data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $uriData = $this->uri->segment(3);
                
                if(!empty($uriData)){
                        $object = $this->mobject->get_object_by_code($uriData);
                        if($member_type == $this->member_types[1]){
                           $object[0]['car_title'] = $this->mcar_specs->get_car_title($this->session->userdata('imobycode'),$object[0]['ObjectTiaraID']);
                        }
                        $media_urls = $this->mobjectmedia->get_objmedia_by_obj_id($object[0]['ObjectTiaraID']);
			if($object[0]['custom_object_id'] == 0){
				$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
			}else{
				$object[0]['media_url'] = $media_urls[count($media_urls)-1]['media_url'];
			}
			$object[0]['media_group'] = $media_urls[0]['media_group'];
                        $data['objects'] = $object;
                        $data['qrcodeImage'] = QR.'qr.php?w=296&f=7&c='.$object[0]['ObjectTiaraID'].'&d='. urlencode(BASE.$object[0]['ObjectTiaraID']);

                }else{
                        $data['objects'] = "";
                        $data['qrcodeImage']= "";
                }
                $data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));   
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                $this->load->view('user/vheader',$data);
                $this->load->view('user/presentation/vqrcode',$data);
                $this->load->view('user/vfooter');
        }
        
        function qrcodeapplicatie(){
                $this->load->model('mobject');
                $this->load->model('mobjectmedia');
		$this->load->model('mmessage');
		$this->load->model('mmobileapps');
                $data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $uriData = $this->uri->segment(3);
                
                
                    $this->load->model('mmobileapps');
                    $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                    if(!empty($uriData)){
                        
                        $data['qrcodeImage'] = QR.'qr.php?w=296&f=6&c='.$data['mobileapps'][0]['ObjectTiaraID'].'&d='.urlencode(BASE.$data['mobileapps'][0]['ObjectTiaraID']);
                    }else{
                        $data['qrcodeImage'] = "";
                    }
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                $this->load->view('user/vheader',$data);
                $this->load->view('user/mobilepagina/vqrcode',$data); 
                $this->load->view('user/vfooter');
        }
        
        
        function qrimage(){
		$qrDataGet[0] = $this->uri->segment(3);
		$qrDataGet[1] = $this->uri->segment(4);
		$qrDataGet[2] = $this->uri->segment(5);
                
                if(!in_array($qrDataGet[0], array(74,148,222,296,370,481,814,962))){
                    echo "Sorry! We do not support this size qr images";
                }else{
                    if($qrDataGet[2] != "" && $qrDataGet[2] == 'j'){
                        $img = QR.'qr.php?w='.$qrDataGet[0].'&c='.$qrDataGet[1].'&d='. urlencode(BASE.$qrDataGet[1]).'&t=j'; 
                    }else{
                        $img = QR.'qr.php?w='.$qrDataGet[0].'&c='.$qrDataGet[1].'&d='. urlencode(BASE.$qrDataGet[1]); 
                    }
                               
                    echo '<img src="'.$img.'"/>';
                }
                
	}
        
        function object_statistieken(){
                $this->load->model('mobject');
                $this->load->model('mobjectmedia');
                $this->load->model('mstatistics');
                $this->load->model('mmessage');
                $this->load->model('mcar_specs');
                $this->load->model('mppresentation');
                $this->load->model('mmobileapps');
                $member_type = $this->session->userdata('member_type');
                $data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $uriData = $this->uri->segment(3);
                //object details
                if(!empty($uriData)){
                        $object = $this->mobject->get_object_by_code($uriData);
                        if($member_type == $this->member_types[1]){
                           $object[0]['car_title'] = $this->mcar_specs->get_car_title($this->session->userdata('imobycode'),$object[0]['ObjectTiaraID']);
                        }
                        $media_urls = $this->mobjectmedia->get_objmedia_by_obj_id($object[0]['ObjectTiaraID']);
                        
			if($object[0]['custom_object_id'] == 0){
				$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
			}else{
				$object[0]['media_url'] = $media_urls[count($media_urls)-1]['media_url'];
			}
			
			//$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
                        $object[0]['media_group'] = $media_urls[0]['media_group'];
                        $data['objects'] = $object;
                        

                }else{
                        $data['objects'] = "";
                        
                }
                // last seven days statistics
                 $statistics7 = $this->mstatistics->view_objlast_7days($this->uri->segment(3));
                 $num_rows7 = count($statistics7); 
                 if(empty($num_rows7) || $num_rows7 < 6){
                     $num_rows7 = 6;
                 }
                 $xml7 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows7}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $i = 0;
                 if(!empty($statistics7)){
                     $total7 = 0;
                     foreach($statistics7 as $s7){   
                        $MAX7[] = $s7['viewd'];
                        $MIN7[] = $s7['viewd'];
                        $total7 += (int)$s7['viewd'];
                        $xml7 .= "&lt;set name='".string_to_date($s7['view_dt'],true)."' value='".$s7['viewd']."' color='99D2EE'";
                        if($i == 0 || $i == (int)($num_rows7/2) || $i == $num_rows7-1){
                            $xml7 .= " showName='1'";
                        }else{
                            $xml7 .= " showName='0'";
                        }
                        $xml7 .= " hoverText='".string_to_date($s7['view_dt'],true)."'/&gt;";

                        $i++;
                     }
                     $data['max7'] = max($MAX7);
                     $data['min7'] = min($MIN7);
                     $data['total7'] = $total7;
                 }else{
                     $data['max7'] = "0";
                     $data['min7'] = "0";
                     $data['total7'] = "0";
                     $xml7 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml7 .= "&lt;/graph&gt;";
                 $data['lastSevenDaysXml'] = $xml7;
                 
                 
                 //last 30 days statistics
                 $statistics30 = $this->mstatistics->view_objlast_30days($this->uri->segment(3));
                 $num_rows = count($statistics30);
                 if(empty($num_rows) || $num_rows <6){
                     $num_rows = 6;
                 }
                 $xml30 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $j = 0;
                 if(!empty($statistics30)){
                     $total30 = 0;
                     foreach($statistics30 as $s30){   
                        $MAX30[] = $s30['viewd'];
                        $MIN30[] = $s30['viewd'];  
                        $total30 += (int)$s30['viewd'];
                        $xml30 .= "&lt;set name='".string_to_date($s30['view_dt'],true)."' value='".$s30['viewd']."' color='99D2EE'";
                        if($j == 0 || $j == (int)($num_rows/2) || $j == $num_rows-1){
                            $xml30 .= " showName='1'";
                        }else{
                            $xml30 .= " showName='0'";
                        }
                        $xml30 .= " hoverText='".string_to_date($s30['view_dt'],true)."'/&gt;";

                        $j++;
                     }
                     $data['max30'] = max($MAX30);
                     $data['min30'] = min($MIN30);
                     $data['total30'] = $total30;
                 }else{
                     $data['max30'] = "0";
                     $data['min30'] = "0";
                     $data['total30'] = "0";
                     
                     $xml30 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml30 .= "&lt;/graph&gt;";
                 
                 $data['lastThirtyDaysXml'] = $xml30;
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
                $this->load->view('user/presentation/vstatistican',$data);
                $this->load->view('user/vfooter');
        }
        
        function bekijk_presentatie(){
            
                $this->load->model('mobject');
                $this->load->model('mobjectmedia');
                $this->load->model('mstatistics');
				$this->load->model('mmessage');
                $this->load->model('mcar_specs');
                $this->load->model('mppresentation');
                $this->load->model('mmobileapps');
                $member_type = $this->session->userdata('member_type');
                require_once(APPPATH.'libraries/Mobile_Detect.php');
                
                $detect = new Mobile_Detect();
                $statistics = array();
                if(is_numeric($this->uri->segment(3))){
                    $statistics['item_id'] =  $this->uri->segment(3);
                    $statistics['view_dt'] = date('Y-m-d');
                    if($detect->isAndroid()){
                        $statistics['devicename'] = 'Android';
                    }elseif($detect->isAndroidtablet()){
                        $statistics['devicename'] = 'Android Tablet';
                    }elseif($detect->isIphone()){
                        $statistics['devicename'] = 'Iphone';
                    }elseif($detect->isIpad()){
                        $statistics['devicename'] = 'Ipad';
                    }elseif($detect->isBlackberry()){
                        $statistics['devicename'] = 'Blackberry';
                    }elseif($detect->isBlackberrytablet()){
                        $statistics['devicename'] = 'Blackberry Tablet';
                    }elseif($detect->isWindowsphone()){
                        $statistics['devicename'] = 'Windows phone';
                    }else{
                        $statistics['devicename'] = 'PC';
                    }
                    $this->mstatistics->save_statistics($statistics);
                }
                $data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $uriData = $this->uri->segment(3);
                if(!empty($uriData)){
                        $object = $this->mobject->get_object_by_code($uriData);
                        if($member_type == $this->member_types[1]){
                           $object[0]['car_title'] = $this->mcar_specs->get_car_title($this->session->userdata('imobycode'),$object[0]['ObjectTiaraID']);
                        }
                        $media_urls = $this->mobjectmedia->get_objmedia_by_obj_id($object[0]['ObjectTiaraID']);
			
                        if($object[0]['custom_object_id'] == 0){
				//$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
                $object[0]['media_url'] = BASE.'fileserver/bofiles/downloads/'.$object[0]['NVMVestigingNR'].'/'.$object[0]['ObjectTiaraID'].'/'.$media_urls[0]['media_url'];
			}else{
				$object[0]['media_url'] = $media_urls[count($media_urls)-1]['media_url'];
			}
			
			//$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
                        $object[0]['media_group'] = $media_urls[0]['media_group'];
                        $data['objects'] = $object;
                        

                }else{
                        $data['objects'] = "";
                        
                }
                
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
                $this->load->view('user/presentation/vexample',$data);
                $this->load->view('user/vfooter');
        }
        
        
        function webincludes(){
                $this->load->model('mobject');
                $this->load->model('mobjectmedia');
                $this->load->model('mstatistics');
		$this->load->model('mmessage');
		$this->load->model('mppresentation');
                $this->load->model('mcar_specs');
                $this->load->model('mmobileapps');
                $member_type = $this->session->userdata('member_type');
                $data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['member_type'] = $member_type;
                $data['member_types'] = $this->member_types;
                $uriData = $this->uri->segment(3);
                
                if(is_numeric($uriData) && !empty($uriData)){
                        $object = $this->mobject->get_object_by_code($uriData);
                        if($member_type == $this->member_types[1]){
                           $object[0]['car_title'] = $this->mcar_specs->get_car_title($this->session->userdata('imobycode'),$object[0]['ObjectTiaraID']);
                        }
                        $media_urls = $this->mobjectmedia->get_objmedia_by_obj_id($object[0]['ObjectTiaraID']);
                        if($object[0]['custom_object_id'] == 0){
				$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
			}else{
				$object[0]['media_url'] = $media_urls[count($media_urls)-1]['media_url'];
			}
//			//$object[0]['media_url'] = substr($media_urls[0]['media_url'],0,strlen($media_urls[0]['media_url'])-1).'1';
//                        
			$object[0]['media_group'] = $media_urls[0]['media_group'];
                        $data['objects'] = $object;
//                        
//                        
                        $images = $this->mobjectmedia->get_objmedia_by_obj_id($uriData);
//			if($object[0]['custom_object_id'] == 0){
//				$soundLink = SOUNDS;
//                                $randVal = mt_rand(1, 5);
//                                //echo $randVal;
//                        $xmlData = '<slickboard>';
//                        $xmlData .= '<sound><clip id="music" url="'.$soundLink.'sound_'.$randVal.'.mp3" delay="0" stream="5" timeout="30" retry="2" /></sound>';
//                        $xmlData .= '<action><item type="sound_play" target="music" event="timer" delay="0" loop="0" /><item type="global_volume" event="timer" delay="0" volume="0.5" /></action>';
//                        foreach($images as $image){
//				$xmlData .= '<object>';
//				
//				$xmlData .= '<image url="'.DOWNLOADS.$image['NVMVestigingNR'].'/'.$image['object_id'].'/'.$image['media_name'].'" fill="trim" width="640" height="480" />';
//				
//				$xmlData .= '  <slide duration="5" preload="2" />
//						<transition_in type="fade" duration="2" />
//					    </object>';
//                        }
//                        $xmlData .= '<object offset_x="0" offset_y="460">
//                                        <rect width="650" height="20" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" shadow="control_bar" />
//                                        <rect width="650" height="20" fill_color="4488ff" fill_alpha=".5" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" />
//                                        <object id="play" offset_x="8" offset_y="0" >
//                                            <rect width="10" height="15" fill_alpha="0" state="hit" />
//
//                                            <polygon fill_color="ffffff" state="checked" >
//                                                <point x="12" y="10" />
//                                                <point x="2" y="4" />
//                                                <point x="2" y="16" />
//                                            </polygon>
//                                            <polygon fill_color="ffffff" state="checked_over" glow="control" >
//                                                <point x="12" y="10" />
//                                                <point x="2" y="4" />
//                                                <point x="2" y="16" />
//                                            </polygon>
//                                            <polygon fill_color="ffaaaa" state="checked_press" glow="control" >
//                                                <point x="12" y="10" />
//                                                <point x="2" y="4" />
//                                                <point x="2" y="16" />
//                                            </polygon>
//
//                                            <rect x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" />
//                                            <rect x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" />
//                                            <rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" />
//                                            <rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" />
//                                            <rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" />
//                                            <rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" />
//
//                                            <action>
//                                                <item type="slideshow_toggle" />
//                                                <item type="sounds_pause" event="check" />
//                                                <item type="sounds_resume" event="uncheck" />
//                                            </action>
//                                        </object>
//                                        <object id="volume" offset_x="530" offset_y="2" >
//                                            <rect width="100" height="15" fill_color="224488" corner_tl="10" corner_tr="10" corner_br="10" corner_bl="10"  shadow="inner" />
//                                            <object id="speaker_cloak">
//                                                <rect x="95" y="0" width="1" height="1" fill_alpha="0"  />
//                                            </object>
//                                            <object id="speaker_constrain">
//                                                <rect x="2" y="4" width="96" height="10" fill_alpha="0"  />
//                                            </object>
//                                            <object id="speaker" shadow="default">
//                                                <rect x="2" y="2" width="26" height="15" fill_alpha="0" state="hit" />
//                                                <polygon fill_color="ffffff">
//                                                    <point x="4" y="5" />
//                                                    <point x="10" y="5" />
//                                                    <point x="15" y="2" />
//                                                    <point x="15" y="13" />
//                                                    <point x="10" y="10" />
//                                                    <point x="4" y="10" />
//                                                </polygon>
//                                                <polygon fill_color="ffffff" state="over" glow="control">
//                                                    <point x="4" y="5" />
//                                                    <point x="10" y="5" />
//                                                    <point x="15" y="2" />
//                                                    <point x="15" y="13" />
//                                                    <point x="10" y="10" />
//                                                    <point x="4" y="10" />
//                                                </polygon>
//                                                <polygon fill_color="ffaaaa" state="press" glow="control">
//                                                    <point x="4" y="5" />
//                                                    <point x="10" y="5" />
//                                                    <point x="15" y="2" />
//                                                    <point x="15" y="13" />
//                                                    <point x="10" y="10" />
//                                                    <point x="4" y="10" />
//                                                </polygon>
//                                                <object>
//                                                    <circle x="15" y="8" radius="6" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha="1" line_thickness="3" />
//                                                    <cloak target="speaker_cloak" radius_1="50" radius_2="75" />
//                                                </object>
//                                                <object> 
//                                                    <circle x="15" y="8" radius="10" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".75" line_thickness="2" />
//                                                    <cloak target="speaker_cloak" radius_1="25" radius_2="50" />
//                                                </object>
//                                                <object>
//                                                    <circle x="15" y="8" radius="14" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".5" line_thickness="1" />
//                                                    <cloak target="speaker_cloak" radius_1="0" radius_2="30" />
//                                                </object>
//                                                <constrain target="speaker_constrain" reflect="0" />
//                                                <action>
//                                                    <item type="adjust_global_volume" event="slider" />
//                                                    <item type="drag" target="speaker" />
//                                                </action>
//                                            </object>
//                                        </object>
//                                    </object>
//                                    <filter>
//                                        <shadow id="default" />
//                                        <shadow id="control_bar" knockout="true" distance="5" alpha=".25" blurX="10" blurY="10" />
//                                        <shadow id="inner" inner="true" distance="3" alpha=".25" blurX="5" blurY="5" />
//                                        <glow id="control" color="ff4400" alpha=".9" blurX="10" blurY="10" inner="false" />
//                                    </filter>
//                                </slickboard>';
//				file_put_contents('slickboard/webincludes.xml', $xmlData);
//			}else{
//				
//				$customJsData = $this->mppresentation->getpp_byid($object[0]['custom_object_id']);
////                                echo $object[0]['custom_object_id'];
////				print_r($customJsData);die();
//				$presen = json_decode($customJsData[0]['jsondata']);
//				//var_dump($presen);
//				//echo $presen['film0']['imglarge'];
//				$xmlfile = 'slickboard/webincludes.xml';
//				$xmlwrite = fopen($xmlfile, 'w') or die('Cannot open file:  '.$xmlfile);
//				
//				$data1 = '<slickboard>';
//				 //echo get_class($presen);
//				foreach(get_object_vars($presen) as $key=>$value){
//                                    if($key == 'bgaudio'){
//                                        
//				    $data1 .= '<sound><clip id="music" url="'.DOWNLOADS.$object[0]['NVMVestigingNR'].'/'.$presen->bgaudio.'" delay="0" stream="5" timeout="30" retry="2" /></sound>';
//				    $data1 .= '<action><item type="sound_play" target="music" event="timer" delay="0" loop="0" /><item type="global_volume" event="timer" delay="0" volume="0.5" /></action>';
//				
//                                    }
//                                }
//				for($i=1; $i<=$presen->filmcount; $i++){
//					$image = $presen->$i->newimage != '' ? DOWNLOADS.$this->session->userdata('imobycode').'/'.$presen->$i->newimage : DOWNLOADS.$this->session->userdata('imobycode').'/'.$presen->$i->image;
//				    $img = '<object><image url="'. $image .'" fill="trim" width="640" height="480" />';
//				    $slide = '<slide duration="'. $presen->$i->slideduration .'" preload="2" />';
//				    if($presen->$i->effectnumber > 0){
//					$effect = '<transition_in type="fly" duration="'. $presen->$i->effectduration .'" startPoint="'. $presen->$i->effectnumber .'" /></object>';
//				    }else{
//					$effect = '<transition_in type="fade" duration="'. $presen->$i->effectduration .'" /></object>';
//				    }
//				    $data1 .= $img . $slide . $effect;
//				}
//				
//				$ctrlbarStart = '<object offset_x="0" offset_y="460"><rect width="650" height="20" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" shadow="control_bar" /><rect width="650" height="20" fill_color="4488ff" fill_alpha=".5" corner_tl="1" corner_tr="1" corner_br="1" corner_bl="1" />';
//				$backButton = '<object id="backward" offset_x="25" offset_y="5" ><polygon fill_color="ffffff" state="hit"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="0" y="15" /><point x="15" y="0" /><point x="13" y="8" /><point x="20" y="8" /><point x="20" y="22" /><point x="13" y="22" /><point x="15" y="30" /></polygon><action><item type="slideshow_backward" /></action></object>';
//				$playButton = '<object id="play" offset_x="8" offset_y="0" ><rect width="10" height="15" fill_alpha="0" state="hit" /><rect x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" /><rect x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked" /><rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" /><rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffffff" state="unchecked_over" /><rect glow="control" x="0" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" /><rect glow="control" x="8" y="2" width="4" height="15" fill_color="ffaaaa" state="unchecked_press" /><polygon fill_color="ffffff" state="checked" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><polygon fill_color="ffffff" state="checked_over" glow="control" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><polygon fill_color="ffaaaa" state="checked_press" glow="control" ><point x="12" y="10" /><point x="2" y="4" /><point x="2" y="16" /></polygon><action><item type="slideshow_toggle" /><item type="sounds_pause" event="check" /><item type="sounds_resume" event="uncheck" /></action></object>';
//				$forwardButton = '<object id="forward" offset_x="122" offset_y="5" ><polygon fill_color="ffffff" state="hit"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="0" y="15" /><point x="-15" y="0" /><point x="-13" y="8" /><point x="-20" y="8" /><point x="-20" y="22" /><point x="-13" y="22" /><point x="-15" y="30" /></polygon><action><item type="slideshow_forward" /></action></object>';
//				$volumeButton = '<object id="volume" offset_x="530" offset_y="2" ><rect width="100" height="15" fill_color="224488" corner_tl="10" corner_tr="10" corner_br="10" corner_bl="10"  shadow="inner" /><object id="speaker_cloak"><rect x="95" y="0" width="1" height="1" fill_alpha="0"  /></object><object id="speaker_constrain"><rect x="2" y="4" width="96" height="10" fill_alpha="0"  /></object><object id="speaker" shadow="default"><rect x="2" y="2" width="26" height="15" fill_alpha="0" state="hit" /><polygon fill_color="ffffff"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><polygon fill_color="ffffff" state="over" glow="control"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><polygon fill_color="ffaaaa" state="press" glow="control"><point x="4" y="5" /><point x="10" y="5" /><point x="15" y="2" /><point x="15" y="13" /><point x="10" y="10" /><point x="4" y="10" /></polygon><object><circle x="15" y="8" radius="6" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha="1" line_thickness="3" /><cloak target="speaker_cloak" radius_1="50" radius_2="75" /></object><object> <circle x="15" y="8" radius="10" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".75" line_thickness="2" /><cloak target="speaker_cloak" radius_1="25" radius_2="50" /></object><object><circle x="15" y="8" radius="14" start="45" end="135" fill_alpha="0" line_color="ffffff" line_alpha=".5" line_thickness="1" /><cloak target="speaker_cloak" radius_1="0" radius_2="30" /></object><constrain target="speaker_constrain" reflect="0" /><action><item type="adjust_global_volume" event="slider" /><item type="drag" target="speaker" /></action></object></object>';
//				$ctrlbarEnd = '</object><filter><shadow id="default" /><shadow id="control_bar" knockout="true" distance="5" alpha=".25" blurX="10" blurY="10" /><shadow id="inner" inner="true" distance="3" alpha=".25" blurX="5" blurY="5" /><glow id="control" color="ff4400" alpha=".9" blurX="10" blurY="10" inner="false" /></filter>';
//				
//				$data1 .= $ctrlbarStart . $playButton . $volumeButton . $ctrlbarEnd ;
//				$data1 .= '</slickboard>';
//				
//				fwrite($xmlwrite, $data1);
//				fclose($xmlwrite);
//				
//				$result = BASE.$xmlfile.'?unique_id='.time();
//				$data['xmlSrc'] = $result;
//			}
//
                }
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['pendingPresntationExist'] = $this->mppresentation->count_pp($this->session->userdata('imobycode'));
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
                $this->load->view('user/presentation/vwebinclude',$data);
                $this->load->view('user/vfooter');
            
        }
	
	function myimoby(){ // previous mobilepagina()
                $this->load->model('mmobileapps');
                $this->load->model('msocialmedia');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['facebook'] = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
                $data['twitter'] = $this->msocialmedia->is_twitter($this->session->userdata('user_id'));
                $data['youtube'] = $this->msocialmedia->is_youtube($this->session->userdata('user_id'));
                $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/mobilepagina/vthuispagina',$data);
		$this->load->view('user/vfooter');
	}
	
	function applicatie(){ // need to change thuispagina -> applicatie 
                $this->load->model('mmobileapps');
                $this->load->model('msocialmedia');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['facebook'] = $this->msocialmedia->is_facebook($this->session->userdata('user_id'));
                $data['twitter'] = $this->msocialmedia->is_twitter($this->session->userdata('user_id'));
                $data['youtube'] = $this->msocialmedia->is_youtube($this->session->userdata('user_id'));
                $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/mobilepagina/vthuispagina',$data);
		$this->load->view('user/vfooter');
	}
        
        function bekijkapplicatie(){
            $this->load->model('mmobileapps');
            $this->load->model('mstatistics');
	    $this->load->model('mmessage');
	    $this->load->model('mmobileapps');
            require_once(APPPATH.'libraries/Mobile_Detect.php');
            $data = array();
            $data['logo'] = "logo.png";
            $data['title'] = 'Imoby';
            $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
            $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
            
                $detect = new Mobile_Detect();
                $statistics = array();
                if(is_numeric($this->uri->segment(3))){
                    $statistics['item_id'] =  $this->uri->segment(3);
                    $statistics['view_dt'] = date('Y-m-d');
                    if($detect->isAndroid()){
                        $statistics['devicename'] = 'Android';
                    }elseif($detect->isAndroidtablet()){
                        $statistics['devicename'] = 'Android Tablet';
                    }elseif($detect->isIphone()){
                        $statistics['devicename'] = 'Iphone';
                    }elseif($detect->isIpad()){
                        $statistics['devicename'] = 'Ipad';
                    }elseif($detect->isBlackberry()){
                        $statistics['devicename'] = 'Blackberry';
                    }elseif($detect->isBlackberrytablet()){
                        $statistics['devicename'] = 'Blackberry Tablet';
                    }elseif($detect->isWindowsphone()){
                        $statistics['devicename'] = 'Windows phone';
                    }else{
                        $statistics['devicename'] = 'PC';
                    }
                    $this->mstatistics->save_statistics($statistics);
                }
	    $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
             $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
            $this->load->view('user/vheader',$data);
            $this->load->view('user/mobilepagina/vappexample',$data);
            $this->load->view('user/vfooter');
        }
        
        function applicatiedownload(){
            $this->load->model('mmobileapps');
	    $this->load->model('mmessage');
	    $this->load->model('mmobileapps');
            $data = array();
            $data['logo'] = "logo.png";
            $data['title'] = 'Imoby';
            $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
            $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
            $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
             $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
	    $this->load->view('user/vheader',$data);
            $this->load->view('user/mobilepagina/vappdownload',$data);
            $this->load->view('user/vfooter');
        }
        
        function mobilewebsite(){
           $id =  $this->uri->segment(3);
           $fileContent = 'Nederlands:
Het onderstaande script moet in de head worden opgenomen van de html pagina.
Dit script zorgt ervoor dat een bezoeker met een mobiele telefoon de vraag
krijgt of de bezoeker de mobiele pagina wil bezoeken. 

Engels:
The script below should be included in the head of the html page.
This script allows a visitor with a cell phone asked if the visitor
wants to visit the mobile page.

<script type="text/javascript" src="'.BASE.'base/mobilescript/'.$id.'/imoby.js"></script>';
           file_put_contents('tempjs/instructions.txt', $fileContent);
           $file="instructions.txt";
           header('Content-type:application/octet-stream');
           header('Content-Disposition: attachment; filename='.basename($file));
           readfile('tempjs/'.$file);
        }
        
        function mobilescript(){
            $id = $this->uri->segment(3);
            $filename = $this->uri->segment(4);
            if(!empty($filename) && $filename =="imoby.js"){
                if(!empty($id)){
                    
                    echo 'if(screen.width <= 699) { if(confirm("Do you want to visit imoby.nl?")){
                                window.location = "'.BASE.$id
                            .'"} }';
                }
            }
        }
        
        function applicatiestatistieken(){
            $this->load->model('mmobileapps');
            $this->load->model('mstatistics');
	    $this->load->model('mmessage');
            $data = array();
            $data['logo'] = "logo.png";
            $data['title'] = 'Imoby';
            $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
            $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
            // last seven days statistics
                 $statistics7 = $this->mstatistics->view_objlast_7days($this->uri->segment(3));
                 $num_rows7 = count($statistics7); 
                 if(empty($num_rows7) || $num_rows7 < 6){
                     $num_rows7 = 6;
                 }
                 $xml7 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows7}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $i = 0;
                 if(!empty($statistics7)){
                     $total7 = 0;
                     foreach($statistics7 as $s7){   
                        $MAX7[] = $s7['viewd'];
                        $MIN7[] = $s7['viewd'];
                        $total7 += (int)$s7['viewd'];
                        $xml7 .= "&lt;set name='".string_to_date($s7['view_dt'],true)."' value='".$s7['viewd']."' color='99D2EE'";
                        if($i == 0 || $i == (int)($num_rows7/2) || $i == $num_rows7-1){
                            $xml7 .= " showName='1'";
                        }else{
                            $xml7 .= " showName='0'";
                        }
                        $xml7 .= " hoverText='".string_to_date($s7['view_dt'],true)."'/&gt;";

                        $i++;
                     }
                     $data['max7'] = max($MAX7);
                     $data['min7'] = min($MIN7);
                     $data['total7'] = $total7;
                 }else{
                     $data['max7'] = "0";
                     $data['min7'] = "0";
                     $data['total7'] = "0";
                     $xml7 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml7 .= "&lt;/graph&gt;";
                 $data['lastSevenDaysXml'] = $xml7;
                 
                 
                 //last 30 days statistics
                 $statistics30 = $this->mstatistics->view_objlast_30days($this->uri->segment(3));
                 $num_rows = count($statistics30);
                 if(empty($num_rows) || $num_rows < 6){
                     $num_rows = 6;
                 }
                 $xml30 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $j = 0;
                 if(!empty($statistics30)){
                     $total30 = 0;
                     foreach($statistics30 as $s30){   
                        $MAX30[] = $s30['viewd'];
                        $MIN30[] = $s30['viewd'];  
                        $total30 += (int)$s30['viewd'];
                        $xml30 .= "&lt;set name='".string_to_date($s30['view_dt'],true)."' value='".$s30['viewd']."' color='99D2EE'";
                        if($j == 0 || $j == (int)($num_rows/2) || $j == $num_rows-1){
                            $xml30 .= " showName='1'";
                        }else{
                            $xml30 .= " showName='0'";
                        }
                        $xml30 .= " hoverText='".string_to_date($s30['view_dt'],true)."'/&gt;";

                        $j++;
                     }
                     $data['max30'] = max($MAX30);
                     $data['min30'] = min($MIN30);
                     $data['total30'] = $total30;
                 }else{
                     $data['max30'] = "0";
                     $data['min30'] = "0";
                     $data['total30'] = "0";
                     
                     $xml30 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml30 .= "&lt;/graph&gt;";
                 
                 $data['lastThirtyDaysXml'] = $xml30;
            
            
            $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
             $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
            $this->load->view('user/vheader',$data);
            $this->load->view('user/mobilepagina/vappstatistics',$data);
            $this->load->view('user/vfooter');
        }
	
	function totaalaanbod(){
                $this->load->model('mmobileapps');
                $this->load->model('mstatistics');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'total_aanbod');
		if(!empty($data['mobileapps'])){
                $statistics7 = $this->mstatistics->view_objlast_7days($data['mobileapps'][0]['ObjectTiaraID']);
                 $num_rows7 = count($statistics7); 
                 if(empty($num_rows7) || $num_rows7 < 6){
                     $num_rows7 = 6;
                 }
                 $xml7 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows7}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $i = 0;
                 if(!empty($statistics7)){
                     $total7 = 0;
                     foreach($statistics7 as $s7){   
                        $MAX7[] = $s7['viewd'];
                        $MIN7[] = $s7['viewd'];
                        $total7 += (int)$s7['viewd'];
                        $xml7 .= "&lt;set name='".string_to_date($s7['view_dt'],true)."' value='".$s7['viewd']."' color='99D2EE'";
                        if($i == 0 || $i == (int)($num_rows7/2) || $i == $num_rows7-1){
                            $xml7 .= " showName='1'";
                        }else{
                            $xml7 .= " showName='0'";
                        }
                        $xml7 .= " hoverText='".string_to_date($s7['view_dt'],true)."'/&gt;";

                        $i++;
                     }
                     $data['max7'] = max($MAX7);
                     $data['min7'] = min($MIN7);
                     $data['total7'] = $total7;
                 }else{
                     $data['max7'] = "0";
                     $data['min7'] = "0";
                     $data['total7'] = "0";
                     $xml7 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml7 .= "&lt;/graph&gt;";
                 $data['lastSevenDaysXml'] = $xml7;
                 
                 
                 //last 30 days statistics
                 $statistics30 = $this->mstatistics->view_objlast_30days($data['mobileapps'][0]['ObjectTiaraID']);
                 $num_rows = count($statistics30);
                 if(empty($num_rows) || $num_rows < 6){
                     $num_rows = 6;
                 }
                 $xml30 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $j = 0;
                 if(!empty($statistics30)){
                     $total30 = 0;
                     foreach($statistics30 as $s30){   
                        $MAX30[] = $s30['viewd'];
                        $MIN30[] = $s30['viewd'];  
                        $total30 += (int)$s30['viewd'];
                        $xml30 .= "&lt;set name='".string_to_date($s30['view_dt'],true)."' value='".$s30['viewd']."' color='99D2EE'";
                        if($j == 0 || $j == (int)($num_rows/2) || $j == $num_rows-1){
                            $xml30 .= " showName='1'";
                        }else{
                            $xml30 .= " showName='0'";
                        }
                        $xml30 .= " hoverText='".string_to_date($s30['view_dt'],true)."'/&gt;";

                        $j++;
                     }
                     $data['max30'] = max($MAX30);
                     $data['min30'] = min($MIN30);
                     $data['total30'] = $total30;
                 }else{
                     $data['max30'] = "0";
                     $data['min30'] = "0";
                     $data['total30'] = "0";
                     
                     $xml30 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml30 .= "&lt;/graph&gt;";
                 
                 $data['lastThirtyDaysXml'] = $xml30;
                }
                $data['qrcodeImage'] = BASE.'qr_images/qr.php?w=296&f=7&c='.$data['mobileapps'][0]['ObjectTiaraID'].'&d='. urlencode(BASE.'base/'.$data['mobileapps'][0]['ObjectTiaraID']);
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                $this->load->view('user/vheader',$data);
		$this->load->view('user/mobilepagina/vtotalaanbod',$data);
		$this->load->view('user/vfooter');
	}
	
	function statistieken(){
                $this->load->model('mmobileapps');
                $this->load->model('mstatistics');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		if(!empty($data['mobileapps'])){
                $statistics7 = $this->mstatistics->view_objlast_7days($data['mobileapps'][0]['ObjectTiaraID']);
                 $num_rows7 = count($statistics7); 
                 if(empty($num_rows7) || $num_rows7 < 6){
                     $num_rows7 = 6;
                 }
                 $xml7 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows7}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $i = 0;
                 if(!empty($statistics7)){
                     $total7 = 0;
                     foreach($statistics7 as $s7){   
                        $MAX7[] = $s7['viewd'];
                        $MIN7[] = $s7['viewd'];
                        $total7 += (int)$s7['viewd'];
                        $xml7 .= "&lt;set name='".string_to_date($s7['view_dt'],true)."' value='".$s7['viewd']."' color='99D2EE'";
                        if($i == 0 || $i == (int)($num_rows7/2) || $i == $num_rows7-1){
                            $xml7 .= " showName='1'";
                        }else{
                            $xml7 .= " showName='0'";
                        }
                        $xml7 .= " hoverText='".string_to_date($s7['view_dt'],true)."'/&gt;";

                        $i++;
                     }
                     $data['max7'] = max($MAX7);
                     $data['min7'] = min($MIN7);
                     $data['total7'] = $total7;
                 }else{
                     $data['max7'] = "0";
                     $data['min7'] = "0";
                     $data['total7'] = "0";
                     $xml7 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml7 .= "&lt;/graph&gt;";
                 $data['lastSevenDaysXml'] = $xml7;
                 
                 
                 //last 30 days statistics
                 $statistics30 = $this->mstatistics->view_objlast_30days($data['mobileapps'][0]['ObjectTiaraID']);
                 $num_rows = count($statistics30);
                 if(empty($num_rows) || $num_rows < 6){
                     $num_rows = 6;
                 }
                 $xml30 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $j = 0;
                 if(!empty($statistics30)){
                     $total30 = 0;
                     foreach($statistics30 as $s30){   
                        $MAX30[] = $s30['viewd'];
                        $MIN30[] = $s30['viewd'];  
                        $total30 += (int)$s30['viewd'];
                        $xml30 .= "&lt;set name='".string_to_date($s30['view_dt'],true)."' value='".$s30['viewd']."' color='99D2EE'";
                        if($j == 0 || $j == (int)($num_rows/2) || $j == $num_rows-1){
                            $xml30 .= " showName='1'";
                        }else{
                            $xml30 .= " showName='0'";
                        }
                        $xml30 .= " hoverText='".string_to_date($s30['view_dt'],true)."'/&gt;";

                        $j++;
                     }
                     $data['max30'] = max($MAX30);
                     $data['min30'] = min($MIN30);
                     $data['total30'] = $total30;
                 }else{
                     $data['max30'] = "0";
                     $data['min30'] = "0";
                     $data['total30'] = "0";
                     
                     $xml30 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml30 .= "&lt;/graph&gt;";
                 
                 $data['lastThirtyDaysXml'] = $xml30;
                }
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                $this->load->view('user/vheader',$data);
		$this->load->view('user/statistics/vtotalview',$data);
		$this->load->view('user/vfooter');
	}
	
	function weekmaand(){   // previous totalviews()
                $this->load->model('mmobileapps');
                $this->load->model('mstatistics');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		if(!empty($data['mobileapps'])){
                 $statistics7 = $this->mstatistics->view_objlast_7days($data['mobileapps'][0]['ObjectTiaraID']);
                 $num_rows7 = count($statistics7); 
                 if(empty($num_rows7) || $num_rows7 < 6){
                     $num_rows7 = 6;
                 }
                 $xml7 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows7}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $i = 0;
                 if(!empty($statistics7)){
                     $total7 = 0;
                     foreach($statistics7 as $s7){   
                        $MAX7[] = $s7['viewd'];
                        $MIN7[] = $s7['viewd'];
                        $total7 += (int)$s7['viewd'];
                        $xml7 .= "&lt;set name='".string_to_date($s7['view_dt'],true)."' value='".$s7['viewd']."' color='99D2EE'";
                        if($i == 0 || $i == (int)($num_rows7/2) || $i == $num_rows7-1){
                            $xml7 .= " showName='1'";
                        }else{
                            $xml7 .= " showName='0'";
                        }
                        $xml7 .= " hoverText='".string_to_date($s7['view_dt'],true)."'/&gt;";

                        $i++;
                     }
                     $data['max7'] = max($MAX7);
                     $data['min7'] = min($MIN7);
                     $data['total7'] = $total7;
                 }else{
                     $data['max7'] = "0";
                     $data['min7'] = "0";
                     $data['total7'] = "0";
                     $xml7 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml7 .= "&lt;/graph&gt;";
                 $data['lastSevenDaysXml'] = $xml7;
                 
                 
                 //last 30 days statistics
                 $statistics30 = $this->mstatistics->view_objlast_30days($data['mobileapps'][0]['ObjectTiaraID']);
                 $num_rows = count($statistics30);
                 if(empty($num_rows) || $num_rows < 6){
                     $num_rows = 6;
                 }
                 $xml30 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $j = 0;
                 if(!empty($statistics30)){
                     $total30 = 0;
                     foreach($statistics30 as $s30){   
                        $MAX30[] = $s30['viewd'];
                        $MIN30[] = $s30['viewd'];  
                        $total30 += (int)$s30['viewd'];
                        $xml30 .= "&lt;set name='".string_to_date($s30['view_dt'],true)."' value='".$s30['viewd']."' color='99D2EE'";
                        if($j == 0 || $j == (int)($num_rows/2) || $j == $num_rows-1){
                            $xml30 .= " showName='1'";
                        }else{
                            $xml30 .= " showName='0'";
                        }
                        $xml30 .= " hoverText='".string_to_date($s30['view_dt'],true)."'/&gt;";

                        $j++;
                     }
                     $data['max30'] = max($MAX30);
                     $data['min30'] = min($MIN30);
                     $data['total30'] = $total30;
                 }else{
                     $data['max30'] = "0";
                     $data['min30'] = "0";
                     $data['total30'] = "0";
                     
                     $xml30 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml30 .= "&lt;/graph&gt;";
                 
                 $data['lastThirtyDaysXml'] = $xml30;
                }
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                $this->load->view('user/vheader',$data);
		$this->load->view('user/statistics/vtotalview',$data);
		$this->load->view('user/vfooter');
	}
	
	function jaar(){ // overviews()
                $this->load->model('mmobileapps');
                $this->load->model('mstatistics');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		if(!empty($data['mobileapps'])){
                    $statistics910 = $this->mstatistics->view_objlast_910days($data['mobileapps'][0]['ObjectTiaraID']);
                }
                $num_rows910 = count($statistics910); 
                 if(empty($num_rows910) || $num_rows910 < 6){
                     $num_rows910 = 6;
                 }
                 
                 $xml910 = "&lt;graph yAxisMinValue='0' yAxisMaxValue='{$num_rows910}' yAxisName='views' decimalPrecision='0' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' rotateNames='0' baseFont='Arial' baseFontSize='8' showValues='0' hoverCapSepChar=': ' chartBottomMargin='0' canvasBgColor='EEEEEE' canvasBaseColor='EEEEEE' divlinecolor='FFFFFF' &gt;";
                 $j = 0;
                 if(!empty($statistics910)){
                     $total910 = 0;
                     foreach($statistics910 as $s910){   
                        $MAX910[] = $s910['viewd'];
                        $MIN910[] = $s910['viewd'];  
                        $total910 += (int)$s910['viewd'];
                        $xml910 .= "&lt;set name='".string_to_date($s910['view_dt'],true)."' value='".$s910['viewd']."' color='99D2EE'";
                        if($j == 0 || $j == (int)($num_rows910/2) || $j == $num_rows910-1){
                            $xml910 .= " showName='1'";
                        }else{
                            $xml910 .= " showName='0'";
                        }
                        $xml910 .= " hoverText='".string_to_date($s910['view_dt'],true)."'/&gt;";

                        $j++;
                     }
                     $data['max910'] = max($MAX910);
                     $data['min910'] = min($MIN910);
                     $data['total910'] = $total910;
                 }else{
                     $data['max910'] = "0";
                     $data['min910'] = "0";
                     $data['total910'] = "0";
                     
                     $xml910 .= "&lt;set name='".date('Y-m-d')."' value='0' color='99D2EE' showName='0' hoverText='".date('Y-m-d')."'/&gt;";      
                 }
                 $xml910 .= "&lt;/graph&gt;";
                 
                 $data['lastThirtyMonthsXml'] = $xml910;
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                $this->load->view('user/vheader',$data);
		$this->load->view('user/statistics/voverview',$data);
		$this->load->view('user/vfooter');
	}
	
	function object(){ //previous summary()
		$this->load->model('mmessage');
                $this->load->model('mobject');
                $this->load->model('mmobileapps');
                $this->load->model('mstatistics');
                $this->load->library('pagination');
                $this->load->model('mcar_specs');
                $member_type = $this->session->userdata('member_type');
                $data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $offset = $this->uri->segment(3);
                if(empty($offset)){
                        $offset=0;
                }
                $limit = 30;
                $config['total_rows'] = $this->mobject->count_available_objects($this->session->userdata('imobycode'));
                $config['per_page'] = $limit;
                $config['base_url'] = BASE.'user/summary/';
                $config['last_link'] = ">>";
                $config['first_link'] = ">>";
                $config['next_link'] = ">";
                $config['prev_link'] = "<";
                $config['cur_tag_open'] = '<a class="selected" >';
                $config['cur_tag_close'] = "</a>";
                $this->pagination->initialize($config);

                
                $objects = $this->mobject->get_available_objects($this->session->userdata('imobycode'),$limit,$offset);
                if(!empty($objects)){
                    foreach($objects as $key =>$obj){
                        $objects[$key]['views'] = $this->mstatistics->total_views($obj['ObjectTiaraID']);
                        if($member_type == "CAR"){
                            $objects[$key]['cars_title'] = $this->mcar_specs->get_car_title($obj['NVMVestigingNR'],$obj['ObjectTiaraID']);
                        }
                    }
                    
                    $data['objects'] = $objects;
                    $data['pagination'] = $this->pagination->create_links();
                }else{
                    $data['objects'] = "";
                    $data['pagination'] = "";
                }
                $data['member_type'] = $member_type;
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/statistics/vsummery',$data);
		$this->load->view('user/vfooter');
	}
	
	function toestel(){ // previous mobileoverview()
                $this->load->model('mmobileapps');
                $this->load->model('mstatistics');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['mobileapps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                if(!empty($data['mobileapps'])){
                    $mobileoverviews = $this->mstatistics->mobile_overviews($data['mobileapps'][0]['ObjectTiaraID']);
                    $totalViewCount = $this->mstatistics->total_mobiledevice_viewcount($data['mobileapps'][0]['ObjectTiaraID']);
                    $xml = "&lt;graph  decimalPrecision='2' formatNumberScale='0' decimalSeparator=',' thousandSeparator='.' showValues='0' pieRadius='225' pieYScale='45' baseFont='Arial' baseFontSize='9' showNames='0' &gt;&lt;set name='.mobi Mowser' value='1.14'/&gt;&lt;set name='Access NetFront Ver. 3.2' value='0.02'/&gt;&lt;set name='Apple iPad' value='3.93'/&gt;";
                    if(!empty($mobileoverviews) && !empty($totalViewCount)){
                        foreach($mobileoverviews as $moviews){
				$view = ((int)$moviews['viewd'] * 100);
				$totalView = (int)$totalViewCount[0]['totalView'];
			
				if($totalView == 0){
					$totalView = ((int)$totalView + 10);
				}
                           $percentOfViewd = ($view / $totalView + 10);
                           $xml .= "&lt;set name='".$moviews['devicename']."' value='".$percentOfViewd."'/&gt;";
                           
                        }
                    }
                    $xml .= "&lt;/graph&gt";
                }
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
                $data['piexml'] = $xml;
		$this->load->view('user/vheader',$data);
		$this->load->view('user/statistics/vmobileoverview',$data);
		$this->load->view('user/vfooter');
	}
	
	function producten(){
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$this->load->view('user/vheader',$data);
		$this->load->view('user/producten/vproductcard',$data);
		$this->load->view('user/vfooter');
	}
	
	function businesscard(){
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$this->load->view('user/vheader',$data);
		$this->load->view('user/producten/vproductcard',$data);
		$this->load->view('user/vfooter');
	}
	
	function qrorders(){
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$this->load->view('user/vheader',$data);
		$this->load->view('user/producten/vproductqr',$data);
		$this->load->view('user/vfooter');
	}
	
	function vsign(){
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$this->load->view('user/vheader',$data);
		$this->load->view('user/producten/vproductsign',$data);
		$this->load->view('user/vfooter');
	}
	
	function help(){
                $this->load->model('mhelp');
		$this->load->model('mmessage');
		$this->load->model('mmobileapps');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $helpGroup = $this->mhelp->get_help_group('manual');
                if(!empty($helpGroup)){
                    foreach($helpGroup as $key=>$hg){
                        $helpGroup[$key]['submenu']= $this->mhelp->get_help_submenu_by_mgid($hg['help_mg_id']);
                        
                    }
                    $submenus = $this->mhelp->get_help_submenu_by_mgid($helpGroup[0]['help_mg_id']);
                    if(!empty($submenus))
                    $data['pages'] = $this->mhelp->get_page_by_menuid($submenus[0]['help_subm_id']);
                }
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $data['menus'] = $helpGroup;
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/help/vcontact',$data);
		$this->load->view('user/vfooter');
	}
	
	function manual(){
                $this->load->model('mhelp');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $helpGroup = $this->mhelp->get_help_group('manual');
                $firstmenu = "";
                if(!empty($helpGroup)){
                    foreach($helpGroup as $key=>$hg){
                        $helpGroup[$key]['submenu']= $this->mhelp->get_help_submenu_by_mgid($hg['help_mg_id']);
                        
                    }
                    $submenus = $this->mhelp->get_help_submenu_by_mgid($helpGroup[0]['help_mg_id']);
                    if(!empty($submenus))
                    $data['pages'] = $this->mhelp->get_page_by_menuid($submenus[0]['help_subm_id']);
                }
                
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $data['menus'] = $helpGroup;
		$this->load->view('user/vheader',$data);
		$this->load->view('user/help/vhelp',$data);
		$this->load->view('user/vfooter');
	}
        
        function show_help_page(){
            $this->load->model('mhelp');
            $data = array();
            $menuid = $this->input->post('menuid',true);
            $data['pages'] = $this->mhelp->get_page_by_menuid($menuid);
            
            $this->load->view('user/help/vshowpage',$data);
        }
	
	function faqs(){
                $this->load->model('mhelp');
		$this->load->model('mmessage');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
                $helpGroup = $this->mhelp->get_help_group('faqs');
                if(!empty($helpGroup)){
                    foreach($helpGroup as $hg){
                        $hg['submenu']= $this->mhelp->get_help_submenu_by_mgid($hg['help_mg_id']);
                        
                    }
                    $submenus = $this->mhelp->get_help_submenu_by_mgid($helpGroup[0]['help_mg_id']);
                    if(!empty($submenus))
                    $data['pages'] = $this->mhelp->get_page_by_menuid($submenus[0]['help_subm_id']);
                }
                $data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                $data['menus'] = $helpGroup;
		$this->load->view('user/vheader',$data);
		$this->load->view('user/help/vhelp',$data);
		$this->load->view('user/vfooter');
	}
	
	function contact(){
		$this->load->model('mmessage');
		$this->load->model('mmobileapps');
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user']=$this->muser->get_user_by_id($this->session->userdata('user_id'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
                 $data['mobile_apps'] = $this->mmobileapps->get_mobile_app($this->session->userdata('imobycode'),'application');
		$this->load->view('user/vheader',$data);
		$this->load->view('user/help/vcontact',$data);
		$this->load->view('user/vfooter');
	}
	
	/*****Message ****/
	function inbox(){
		$this->load->model('mmessage');
		$this->load->library('pagination');
		$offset = $this->uri->segment(3);
		if(empty($offset)){
			$offset = 0;
		}
		$limit = 30;
                $config['total_rows'] = $this->mmessage->count_messages($this->session->userdata('user_id'));
                $config['per_page'] = $limit;
                $config['base_url'] = BASE.'user/inbox/';
                $config['last_link'] = ">>";
                $config['first_link'] = ">>";
                $config['next_link'] = ">";
                $config['prev_link'] = "<";
                $config['cur_tag_open'] = '<a class="selected" >';
                $config['cur_tag_close'] = "</a>";
                $this->pagination->initialize($config);
		$data = array();
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$data['message'] = $this->mmessage->get_messages($this->session->userdata('user_id'),$limit,$offset);
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('user/vheader',$data);
		$this->load->view('user/message/vmessageinbox',$data);
	}
	
	function view_msg(){
		$this->load->model('mmessage');
		$data['logo'] = "logo.png";
		$data['title'] = 'Imoby';
                $data['user'] = $this->muser->get_user_by_id($this->session->userdata('user_id'));
		$messageid = $this->uri->segment(3);
		if(is_numeric($messageid)){
			$data['message'] = $this->mmessage->get_single_message($messageid);
			$updateReadStatus = array('read_status' => 0);
			$this->mmessage->change_message_status($messageid,$updateReadStatus);
		}else{
			$data['message'] = "";
		}
		$data['countUnreadMsg'] = $this->mmessage->count_undreadmessages($this->session->userdata('user_id'));
		$this->load->view('user/vheader',$data);
		$this->load->view('user/message/vmessagedetails',$data);
	}
	
	function logout()
	{
		$this->simplelogin->logout();	
		$re = str_replace('backoffice/', '', BASE);
		redirect($re);
	}
	
	
	
}