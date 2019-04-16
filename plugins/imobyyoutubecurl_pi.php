<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImobyYoutubeCurl_pi
 *
 * @author HIMEL
 */
class ImobyYoutubeCurl{
    //put your code here
   /*
    // OLD
    private $devKey = "AI39si5JxN3v9sNA58U5KFr7ZdEdXNfUJv7vpLeR78NV6RBpoqPTDpBtCEFUEBJOI6qaM6Cke09KTXFAIHUvNLeedAzztygX-A";
    private $clienId = "233015585396.apps.googleusercontent.com";
    private $clientSecret = "BV-hv6XRNz8guK96znWYGEK2";
    private $redirectUri = "http://app.imoby.nl/user/youtube/?returnfrom=youtube";
  */
    
   //new
    private $devKey = "AI39si4UAQPQdkPMtojgkMJjamoFLiqt282zqqX2_cODMoJT8T0mu1WMk54-6oJpkjasdvTJygIqISO-78YfLxNlapA1xPA57g";
    private $clienId = "864967251487.apps.googleusercontent.com";
    private $clientSecret = "8U8IXZGmK2dxqOlac5YWYE2f";
    private $redirectUri = "http://app.imoby.nl/youtube.php";
    //new
    
    
    private $authLocation = "https://accounts.google.com/o/oauth2/auth";
    private $authTokenUrl = "https://accounts.google.com/o/oauth2/token";
    private $uploadUrl = "https://uploads.gdata.youtube.com/feeds/api/users/default/uploads";
    private $getuploadUrl = "https://gdata.youtube.com/action/GetUploadToken";
    private $defaultPath = "https://gdata.youtube.com/feeds/api/users/default?access_token=";
    function __construct() {
        
    }
    
    function getAuthUrl(){
        $authUrl = $this->authLocation."?redirect_uri=".$this->redirectUri;
        $authUrl .= "&response_type=code&";
        $authUrl .= "client_id=".$this->clienId;
        $authUrl .= "&approval_prompt=force&";
        $authUrl .= "scope=https://gdata.youtube.com&";
        $authUrl .= "access_type=offline";
        echo $authUrl;
        return $authUrl;
    }
    
    function requestAccessToken($code)
    {
        
        $oauth2token_url = $this->authTokenUrl;
        $clienttoken_post = array(
        "code" => $code,
        "client_id" => $this->clienId,
        "client_secret" => $this->clientSecret,
        "redirect_uri" => $this->redirectUri,
        "grant_type" => "authorization_code",
        
        );

        $curl = curl_init($oauth2token_url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $clienttoken_post);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $json_response = curl_exec($curl);
        curl_close($curl);
        
        $authObj = json_decode($json_response);
       
        if (isset($authObj->refresh_token)){
           
                 //refresh token only granted on first authorization for offline access
                //save to db for future use (db saving not included in example)
                global $refreshToken;
                $refreshToken = $authObj->refresh_token;
                return $refreshToken;
        }
        else{
            echo 'didnt get a refresh token because:<pre>';
            print_r($authObj);
            echo '</pre>';
        }   
    }
    
    
    function refreshAccessToken($refreshToken)
    {
        $oauth2token_url = $this->authTokenUrl;
        $clienttoken_post = array(
        "client_id" => $this->clienId,
        "client_secret" => $this->clientSecret,
        "refresh_token" => $refreshToken,
        "grant_type" => "refresh_token",
        
        );
        
        echo $refreshToken.'<br />';
        echo $oauth2token_url.'<br />';
        print_r($clienttoken_post).'<br />';
        $curl = curl_init($oauth2token_url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $clienttoken_post);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json_response = curl_exec($curl);
        curl_close($curl);
        $authObj = json_decode($json_response);
        print '<pre>$authObj'; print_r($authObj); print '</pre>';
        return $authObj->access_token;
    }
    
    function getAuthToken($code)
    {  
            
            return $this->requestAccessToken($code);
        
    }
    
    function getUserProfile($access_token)
    {
        if(!empty($access_token)){
            $xmlStr = file_get_contents($this->defaultPath.$access_token);
            $xmlObj = new SimpleXMLElement($xmlStr);      
            return $xmlObj;
        }
        else{
            echo 'No access token';
        }
    }
    
    function getStatistics($access_token)
    {
        if(!empty($access_token)){
            $xmlStr =  file_get_contents($this->defaultPath.$access_token);
            $xmlObj = new SimpleXMLElement($xmlStr);
            $childs = $xmlObj->children('yt', TRUE);
            return $childs;

        }
    }
    
    function getGd($access_token)
    {
        if(!empty($access_token)){
            $xmlStr =  file_get_contents($this->defaultPath.$access_token);
            $xmlObj = new SimpleXMLElement($xmlStr);
            $childs = $xmlObj->children('gd', TRUE);
            return $childs;

        }
    }
    
    function directuploadVideo($refreshToken)
    {
        $oauth2token_url = $this->uploadUrl;
        
        $xml_data = '--1448064
Content-Type: application/atom+xml; charset=UTF-8
<?xml version="1.0"?>
<entry xmlns="http://www.w3.org/2005/Atom"
  xmlns:media="http://search.yahoo.com/mrss/"
  xmlns:yt="http://gdata.youtube.com/schemas/2007">
  <media:group>
    <media:title type="plain">1448064 video title</media:title>
    <media:description type="plain">
      A video for imoby.nl
    </media:description>
    
    <media:keywords>imoby, Land</media:keywords>
  </media:group>
  <media:content url="http://app.imoby.nl/1448064.mp4" />
</entry>
 --1448064
Content-Type: video/mp4
Content-Transfer-Encoding: binary

<Binary File Data>
--1448064--';
        
        $headers = array(
            "Content-type: multipart/related; boundary='1448064'",
            "Content-length: " . strlen($xml_data),
            "Authorization: Bearer " . $refreshToken,
            "GData-Version:  2",
            "X-GData-Key: key=". $this->devKey,
            "Slug: 1448064.mp4",
        ); 
        
//Connection: close


        $curl = curl_init($oauth2token_url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json_response = curl_exec($curl);
//        curl_close($curl);
//        $authObj = json_decode($json_response);
        return $json_response;
    }
    
    function uploadVideoToken($refreshToken,$data)
    {
        $oauth2token_url = $this->getuploadUrl;

        $xml_data = '<?xml version="1.0"?>
            <entry xmlns="http://www.w3.org/2005/Atom"
              xmlns:media="http://search.yahoo.com/mrss/"
              xmlns:yt="http://gdata.youtube.com/schemas/2007">
              <media:group>
                <media:title type="plain">'.$data['title'].'</media:title>
                <media:description type="plain">'.$data['description'].'</media:description>
                <media:category scheme="http://gdata.youtube.com/schemas/2007/categories.cat">Autos</media:category>
                <media:keywords>'.$data['keywords'].'</media:keywords>
              </media:group>
            </entry>';
        
        $headers = array(
            "Content-type: application/atom+xml; charset=UTF-8",
            "Content-length: ". strlen($xml_data),
            "Authorization: Bearer " . $refreshToken,
            "GData-Version:  2",
            "X-GData-Key:key=". $this->devKey,
        ); 

        $curl = curl_init($oauth2token_url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json_response = curl_exec($curl);
        print '<pre>$json_response'; print_r($json_response); print '</pre>';
        $getResponse = simplexml_load_string($json_response);
        print '<pre$getResponse>'; print_r($getResponse); print '</pre>';
        curl_close($curl);

        return $getResponse;
    }
    
    public function uploadToYoutube($loc,$token,$filepath)
    {
        $fileUpload = "@".$filepath;
        $oauth2token_url = $loc.'?nexturl='.  urlencode('http://app.imoby.nl/videoConv_movies.php');
        $post_data = array(
            'file' => $fileUpload,
            'token' => $token
        );      
        
        $curl = curl_init($oauth2token_url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/html; charset=utf-8"));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0');//$_SERVER["HTTP_USER_AGENT"]);
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        
        $json_response = curl_exec($curl);
        curl_close($curl);
        print '<pre>$json_response'; print_r($json_response); print '</pre>';
        return $json_response;
    }
}

?>