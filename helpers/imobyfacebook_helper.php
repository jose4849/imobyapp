<?php
/**
 * Description of facebok_pi
 *
 * @author Himel
 */
require_once 'facebook_lib/facebook.php';

class ImobyFacebook {
   
    //private $app_id = '260206270752298'; OLD
    //private $app_secret = '6dc21d4875de2543847df1a03e845e5e'; OLD
    private $app_id = '431691030327224';
    private $app_secret = '0e16f299f753a3be8ce0e3fb1534f645';
    
    public $facebookObj;
    
    function __construct() {

        if($_SERVER['REMOTE_ADDR']=='86.94.132.162'){
         //   $this->app_id = '453040708126615';
        //    $this->app_secret = 'bc31eddfe270815ad52fdbb117fff126';
        }

        $config = array(
          'appId' => $this->app_id,
          'secret' => $this->app_secret,
          'cookie' => true
        );
        $this->facebookObj = new Facebook($config);
    }
    

    function getFBUser($access_token=null){
        $this->facebookObj->setAccessToken($access_token);
        return $this->facebookObj->getUser();
    }
    
    function getAppId(){
        return $this->app_id;
    }
    
    function getAuthUrl(){
        //local.sadiqbd.com/imoby
        $params = array(
            'scope' => 'read_stream,publish_stream,manage_pages,offline_access',
            'redirect_uri' => 'http://app.imoby.nl/user/facebook/' 
        );
        return $this->facebookObj->getLoginUrl($params);
    }
    
    function logoutFB(){
        return $this->facebookObj->getLogoutUrl();
    }
    
    function getFBAccesToken(){
        return $this->facebookObj->getAccessToken();
    }
    
    function get_profile($token=""){
        $user_profile = "";
        $this->facebookObj->setAccessToken($token);
        $access_token = array( 'access_token' => $token);
        if(!empty($token)){
            $user_profile = $this->facebookObj->api('/me','GET',$access_token);
        }else{
            $user_profile = $this->facebookObj->api('/me','GET');
        }
        return $user_profile;

    }
    
    function num_friends($token=""){
        $access_token = array( 'access_token' => $token );
        $user_friends = $this->facebookObj->api('/me/friends','GET',$access_token);
        return count($user_friends['data']);
    }
    
    function get_username($token=""){
        $access_token = array( 'access_token' => $token );
        $user_profile = $this->facebookObj->api('/me','GET',$access_token);
        return $user_profile['name'];
    }
    
    function get_session(){
        $session_key = 'fb_'.$this->app_id.'_access_token';
        $fb_session = $_SESSION[$session_key];
        return $fb_session;
    }
    
    function post_on_wall($m,$token){
        $msg = array(
            'message' => $m,
            'access_token' => $token 
        );
        $this->log('/me '.$token.' '.$m."\n");
        $post = $this->facebookObj->api('/me/feed','POST',$msg);   
        $this->log(join(', ',$post)."\n\n");
        return $post;
    }
    
    
    
    function askApi($arg) {
        return $this->facebookObj->api($arg);
    }
    
    
    function post_on_page($page, $m,$token){
        $msg = array(
            'message' => $m,
            'access_token' => $token 
        );
        $this->log($page.' '.$token.' '.$m."\n");
        $post = $this->facebookObj->api('/'.$page.'/feed','POST',$msg);
        $this->log(join(', ',$post)."\n\n");
        return $post;
    }
    
    
    function getFanPages($accessToken){
        return $this->facebookObj->api('me/accounts?access_token='.$accessToken);
    }

    function log($msg){
        $file = '/home/imoby/domains/app.imoby.nl/public_html/youtubeMovies/logs/facebook.txt';
        $fp = fopen($file, 'a+');
        fwrite($fp, $msg."\n");
        chmod($file, 0777);         
    }


}

?>
