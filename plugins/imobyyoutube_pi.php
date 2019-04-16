<?php
/**
 * Description of youtube_pi
 *
 * @author Himel
 */
ini_set('include_path', ini_get('include_path'). ';' .'C:/wamp/www/backoffice/system/plugins;C:/wamp/www/backoffice');



class ImobyYouTube{

    //private $youtube_api_key = "AI39si4oJq_w-4PJG9LDlwyrhdHfgd4ypWZYiXcLZQmOCwCzR0vLaLfXe0EQrdFgwMEMHyhwafVOXjM4edrmOf_Nf497opArFg";
	//private $youtube_api_key = "AI39si5JxN3v9sNA58U5KFr7ZdEdXNfUJv7vpLeR78NV6RBpoqPTDpBtCEFUEBJOI6qaM6Cke09KTXFAIHUvNLeedAzztygX-A";
    //private $youtube_api_key = "AI39si5TWE7V_3JQYZwo67GojX7mZjBqQ84kL1A2eweGjvIzCQVRXHie76n5Fo2kgmqL0ChvfHojQKO3FlbKhP5jTN9kJlMUyw";
	private $youtube_api_key = "AI39si5JxN3v9sNA58U5KFr7ZdEdXNfUJv7vpLeR78NV6RBpoqPTDpBtCEFUEBJOI6qaM6Cke09KTXFAIHUvNLeedAzztygX-A";
    function ImobyYouTube(){
        require_once 'Zend/Loader.php';
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_AuthSub');
    }
  
    function get_developer_key(){
        return $this->youtube_api_key;
    }
    
    function getAuthSubRequestUrl(){
        $next = 'http://b.imoby.nl/user/youtube/?returnfrom=youtube';
        $scope = 'http://gdata.youtube.com';
        $secure = false;
        $session = true;
        return Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure, $session);
    }
    
    function getAuthSubHttpClient($request_token){
   
        return  Zend_Gdata_AuthSub::getAuthSubSessionToken($request_token);
        
    }
    
    function getYouTubeInstance($token,$application_id,$client_id){
        $httpClient = Zend_Gdata_AuthSub::getHttpClient($token);
        $yt = new Zend_Gdata_YouTube($httpClient, $application_id, '233015585396.apps.googleusercontent.com', $this->youtube_api_key);
        return $yt;
    }
    
}

?>