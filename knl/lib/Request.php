<?php
class knl_lib_Request {
    private static $instance;

    private function __construct(){}
    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
	public function getGet($key){
	  	$var = isset($_GET[$key]) ? $_GET[$key] : '';
	  	return $var; 
	}

	public function getPost($key){
	  	$var = isset($_POST[$key]) ? $_POST[$key] : '';
	  	return $var; 
	}
	
	public function getRequest($key){
	  	$var = isset($_REQUEST[$key]) ? $_REQUEST[$key] : '';
	  	return $var; 
	}
}
