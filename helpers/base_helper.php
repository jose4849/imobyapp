<?php
if(!function_exists('date_diff')){
	function date_diff($date1,$date2) {
		$diff = abs(strtotime($date2) - strtotime($date1));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		return $days;		
	}
}

/**
 * Convert String date to date
 * @access public
 * @param $date_string date as string
 * @param $show_time if set as true then it show time
 */
if(!function_exists('string_to_date')){
    function string_to_date($date_string,$show_time=true){
        $times_tamp = strtotime($date_string);
        if($show_time){
            return date('d-m-Y',$times_tamp);
        }else{
            return date('F j, Y',$times_tamp);
        }
    }
}
?>