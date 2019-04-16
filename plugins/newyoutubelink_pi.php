<?php

/**
 * @author Cre8it BV
 * @copyright 2013
 */

class NewYoutubeLink{
    
    function __construct(){
        require_once 'google/Google_Client.php';
        require_once 'google/contrib/Google_YouTubeService.php';
        
        $this->client = new Google_Client();
        $this->youtube = new Google_YoutubeService($this->client);  
    }

    function authUrl($code=false){
        return $this->client->authenticate($code);
    }

    public function getAccessToken(){
        return $this->client->getAccessToken();
    }
   
    public function setAccessToken($token){
        $this->client->setAccessToken($token);
    }
 
    function insertVideo($movieData){
        $snippet = new Google_VideoSnippet();
        $snippet->setTitle($movieData['title']);
        $snippet->setDescription($movieData['description']);
        $snippet->setTags($movieData['tags']);
        $snippet->setCategoryId("2"); // 2 = Autos & Vehicles
        
        $status = new Google_VideoStatus();
        $status->setPrivacyStatus("public");
        
        $video = new Google_Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);
        
        return $this->youtube->videos->insert("status,snippet,contentDetails", $video, array(  'data' => file_get_contents($movieData['path']),'mimeType' => "video/*")); 
    }
    
}