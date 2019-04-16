<?php
class Crm_breadcrumbs {
    private $path, $seperator, $basePath, $CI;

    function crm_breadcrumbs($basePath = '/', $seperator = ' > ') {
        $this->seperator = $seperator;
        $this->basePath = $basePath;
        $this->ci =& get_instance();
        $sessionCrumbs = $this->ci->session->userdata('breadcrumbs');
        $this->path = is_array($sessionCrumbs) ? $sessionCrumbs : array();
    }
        
        
    function getTest(){
        return $this->session->userdata('breadcrumbs');
    }
    function setTest(){
        $array = array('breadcrumbs' => array( 0 => '0', 1 => '1', 2 => '2' ) );
        $this->session->set_userdata($array);
    }
    function addBreadcrumb($step, $title, $link = false, $clear = false)  {
        $item->title = $title;
        if (strlen($link) > 0) {
            $item->link = $link;
        }
        //echo 'Add Crumb<br />';
        //echo 'S: '.$step.' T:'.$title.' L:'.$link.'<br />';
        if(empty($this->path[$step]->link)){
            //echo $step.' does not exist so add <br/>';
            $this->path[$step] = $item;
            $this->saveSession();
        }
        else{
            //echo $step.' exists<br/>';
            if($this->path[$step]->link!=$link) {
                //echo '"'.$link.'" is different from "'.$this->path[$step]->link.'" so replace it<br />';
                $this->path[$step] = $item;
                $this->saveSession();
            }
            else{
                //echo 'link is the same, so dont add<br/>';
                if($clear) { 
                    //echo 'clear requested<br />';
                    $this->clearPath($step); 
                }
            }
        }
    }
    
    function displayBreadcrumbs($format = true){
        return ($format)? $this->formatBreadcrumbs() : $this->path;
    }
    
    function formatBreadcrumbs(){
        $trail = ''; $i = 1;
        foreach($this->path as $key => $crumb){
            
            if($i!=count($this->path)){
                $trail .= '<a href="'.$this->basePath.$crumb->link.'">'.$crumb->title.'</a>'.$this->seperator;
            }
            else{
                $trail .= $crumb->title;
            }
            $i++;
        }
        return $trail;
    }
    
    function saveSession(){
        //echo 'saving '; print_r($this->path); echo '<br />';
        $this->ci->session->set_userdata(array('breadcrumbs' => $this->path));
    }
    
    function clearPath($step=0){
        $oldPath = $this->path;
        $this->path = array();
        //echo '<br />clean after '.$step.'<br />';
        $this->saveSession();
        foreach($oldPath as $pathStep => $pathValue){
            if($pathStep<=$step){
                //echo 'add:'.$pathStep.' '.$pathValue->title.'<br />';
                $this->path[] = $pathValue;
            }
            else{
                //echo 'dont add:'.$pathStep.' '.$pathValue->title.'<br />';
            }
        }
        $this->saveSession();
    }
    

}
?>