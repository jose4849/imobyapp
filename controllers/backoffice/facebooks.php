<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Facebooks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    public function index() {
        
         $this->load->helper('imobyfacebook');
         $imobyFB = new ImobyFacebook();
    
	 //echo $userFBID = $imobyFB->jose();
        echo $imobyFB->getAuthUrl(); 
        
        //$this->load->view('backoffice/settings/facebook/vfbook');
    }

   
}
