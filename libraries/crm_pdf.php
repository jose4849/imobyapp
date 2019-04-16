<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class crm_pdf extends TCPDF
{
    public $footerHtml, $headerHtml;
    function __construct() {
        parent::__construct();
    }
    
    public function setFooterHtml($html){
        $this->footerHtml = $html;
    }
    public function Footer() {
        $this->SetTextColor(139,137,137);
        $this->writeHTML($this->footerHtml);  
    }
    
//    public function setHeaderHtml($html){
//        $this->headerHtml = $html;
//    }
//
//    public function Header() {      
//        $this->writeHTML('ZZ'.$this->headerHtml);         
//    }   
}
?>