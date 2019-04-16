<?php

function upload($uploadPath, $fieldName, $setFilename=false, $overwrite=false, $allowedExt=false, $resize=false){
    if(!is_array($allowedExt)){ $allowedExt =  array('jpg', 'gif', 'png'); }
    if (!isset($_FILES[$fieldName])) {
    	 return array('error' => 'Geen bestand opgegeven.');
    }
    else{ 
        if(!makeDirectory($uploadPath)){
            return  array('error' => 'Kan doel folder niet aanmaken.');
        }
        
        $ext = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
        $filename = md5($_FILES[$fieldName]['tmp_name'].time()).'.'.$ext;
        
        if($setFilename){
            $filename = $setFilename.'.'.$ext;
        }
        //!checkType($_FILES[$fieldName]['name'], $_FILES[$fieldName]['type']) &&
        if( !in_array($ext, $allowedExt)){
            return  array('error' => 'Bestandtype niet toegestaan.');
        }
        if( is_file($uploadPath.$filename) && ($overwrite===false) ){
            return array('error' => 'File bestaat al..');
        }
        
        if(!copy($_FILES[$fieldName]['tmp_name'], $uploadPath.$filename)) {
			if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $uploadPath.$filename)){
                return array('error' => 'Kon bestand niet opslaan.');
			}
		}
         
        // check for resize needs
        if(is_array($resize) && ($resize['width']) && ($resize['height']) ){
            $info = getimagesize($uploadPath.$filename);
      
            $width = $info[0];
            $height = $info[1];
            if( ($width>$resize['width']) || ($height>$resize['height']) ){
                resize($uploadPath.$filename, $uploadPath.$filename, $resize['width'], $resize['height'], 100);
            }
            $info = getimagesize($uploadPath.$filename);
            print_r($info);
     
            
        }
        return array('fileName' => $filename);
    }
}


function checkType($fileName, $fileType){
    include_once('/home/imoby/domains/app.imoby.nl/public_html/application/config/mimes.php');
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $mimeTypes = $mimes[$ext];
    if(!is_array($mimeTypes)) {
        return false;
    }
    return false;
}


function makeDirectory($uploadPath){
    return (is_dir($uploadPath)) ?  true : mkdir($uploadPath, 0777);
}


function resize($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
{
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    #assuming the mime type is correct
    switch ($imgtype) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source_image);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source_image);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source_image);
            break;
        default:
            die('Invalid image type.');
    }

    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);


    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed

    $x_ratio = $tn_w / $src_w;
    $y_ratio = $tn_h / $src_h;

    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
        $new_w = $src_w;
        $new_h = $src_h;
    } elseif (($x_ratio * $src_h) < $tn_h) {
        $new_h = ceil($x_ratio * $src_h);
        $new_w = $tn_w;
    } else {
        $new_w = ceil($y_ratio * $src_w);
        $new_h = $tn_h;
    }

    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    $backgroundColor = imagecolorallocate($final, 0, 0, 0);
    imagefill($final, 0, 0, $backgroundColor);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    #if we need to add a watermark
    if ($wmsource) {
        #find out what type of image the watermark is
        $info    = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $watermark = imagecreatefromjpeg($wmsource);
                break;
            case 'image/gif':
                $watermark = imagecreatefromgif($wmsource);
                break;
            case 'image/png':
                $watermark = imagecreatefrompng($wmsource);
                break;
            default:
                die('Invalid watermark type.');
        }

        #if we're adding a watermark, figure out the size of the watermark
        #and then place the watermark image on the bottom right of the image
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

    }
    if (imagejpeg($final, $destination, $quality)) {
        return true;
    }
    return false;
}



function factuurItems($factuurItems){
    $selectbox = '<select class="factuurItems" name="factuurItem[]" style="width:100%;"><option value="">Selecteer</option>';
    if(count($factuurItems)){   
        foreach($factuurItems as $item){
            $selectbox .= '<option value="'.$item->item_id.'">'.$item->item_text.'</option>';
        }
    }
    $selectbox .= '<option value="anders">Anders</option></select>';
    return $selectbox;
}
function onderhoudType($type=false){
    $onderhoudtypes = array('APK', 'Grote onderhoudsbeurt', 'Kleine onderhoudsbeurt', 'Autobanden', 'Schadeherstel', 'Airco check', 'Overige onderhoud');
    $selectbox = '<select class="onderhoudType" name="onderhoudType" id="onderhoudType" ><option value="">Selecteer</option>';
    if(count($onderhoudtypes)){   
        foreach($onderhoudtypes as $item){
            $selectbox .= '<option value="'.$item.'">'.$item.'</option>';
        }
    }
    $selectbox .= '</select>';
    return $selectbox;
}

function truncateText($text, $type, $max){
    $shortText = false;
    if( ($type=='characters') && (is_numeric($max)) ){
        $charCount = strlen($text);
        if($charCount>$max){
            $shortText = substr($text, 0, $max);
        }
    }
    
    if( ($type=='words') && (is_numeric($max)) ){
        $tmpText = str_replace("\n", "\n ", $text);
        $wordCount = count(explode(' ',$tmpText));
        if($wordCount>$max){
            $shortText = implode(' ', array_slice(explode(' ', $tmpText), 0, $max));
        }
    }
    if( ($type=='lines') && (is_numeric($max)) ){
        $lineCount = count(explode("\n",$text));   
        if($lineCount>$max){
            $shortText = implode("\n", array_slice(explode("\n", $text), 0, $max));
        }
    }
    return ($shortText) ? '<span class="shortDescription">'.$shortText.' <span class="readMore">...(Lees meer)</span></span> <span class="longDescription">'.$text.'<span class="readLess">(Lees minder)</span></span>' : $text;
}
