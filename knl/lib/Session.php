<?php

class knl_lib_Session {
	private static $instance;

    private function __construct(){
    	session_start();
    }

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
	}
	
	public function getSessionKey($key){
		$var = isset($_SESSION[$key]) ? $_SESSION[$key] : '';
	  	return $var;
	}
	
	public function setSession($key,$var){
		$_SESSION[$key] = $var;
	}
	
    public function killSession(){
    	foreach($_SESSION as $key => $var){
    		unset($_SESSION[$key]);
    	}
    	session_destroy();
    }
}
