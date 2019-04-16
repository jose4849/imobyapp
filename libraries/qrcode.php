<?php
class QRcode{
	
	private $qr_url;
	private $width;
	private $height;
	private $cpath;
	private $cdata;
	
	public function generateQR($width,$height,$callbackpath,$callbackdata){
		$this->width = $width;
		$this->height = $height;
		$this->cpath = $callbackpath;
		$this->cdata = $callbackdata;
		$chartURL = "http://chart.googleapis.com/chart?";
		$chartURL .="chs=".$this->width. "x".$this->height."&cht=qr&chl=" . urlencode($this->cpath.$this->cdata);
		$this->qr_url = $chartURL;
		return $this;
	}
	
	public function newPngQR(){
		$image = imagecreatefrompng($this->qrcode);
		$txtColor = imagecolorallocate($image,250,250,250);
		imagestring($image,5,(($this->width / 2) - 5*5),($this->height - (5*5)),'Imoby-'.$this->cdata,$txtColor);
		
		header('Content-type: image/png');
		imagepng($image);
	}
	
	
}