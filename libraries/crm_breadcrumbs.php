<?php
class Crm_breadcrumbs {
    private $CI;
    function crm_breadcrumbs(){
        $this->CI =& get_instance();
        $this->CI->load->library("session");
    }  
      
    public function getTest(){
        return $this->CI->session->userdata('breadcrumbs');
    }
    
    public function setCrumb($stepData = false, $clear = false) {
        // get and unset the crumbs
        $currentCrumbs = $this->CI->session->userdata('breadcrumbs');
        $this->CI->session->unset_userdata('breadcrumbs');
        
        // Loop through old crumbs and keep specific data
        $newCrubs = array();
        if(is_array($currentCrumbs)){
            foreach($currentCrumbs as $step => $crumbData){
                if($clear){
                    if($step<$stepData['step']){
                        $newCrubs[$step] = array(
                            'link'  => $crumbData['link'],
                            'title' => $crumbData['title']
                        );
                    }
                }
                else{
                    $newCrubs[$step] = array(
                        'link'  => $crumbData['link'],
                        'title' => $crumbData['title']
                    );
                }
            }
        }
        
        // Set the new step
        $newCrubs[$stepData['step']] = array(
            'link'  => $stepData['link'],
            'title' => $stepData['title']
        );

        // Set the session data
        $this->CI->session->set_userdata(array('breadcrumbs' => $newCrubs ));
    }         
    
    
    public function displayBreadcrumbs(){
        $links = array();
        $breadcrumbs = $this->CI->session->userdata('breadcrumbs');
        if(is_array($breadcrumbs)){
             foreach($breadcrumbs as $step => $crumbData){
                if($step==count($breadcrumbs)-1){
                    $links[] = '<span class="lastBreadcrumbs">'.$crumbData['title'].'</span>';
                }
                else{
                    $links[] = '<a href="'.$crumbData['link'].'" class="breadcrumb">'.$crumbData['title'].'</a>';
                }
             }
        }
        return join(' > ', $links);
    }
    
        
}     
?>