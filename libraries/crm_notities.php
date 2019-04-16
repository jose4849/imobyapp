<?php

class testlib {
    private $test;

	function __construct($test) {
		log_message('debug', 'Unzip Class Initialized');
        $this->test = $test;
	}

    function setTest($test){
        $this->test = $test;
    }
    
    function getTest(){
        return $this->test;
    }
    
}