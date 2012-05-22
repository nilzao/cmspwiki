<?php
class app_publisher_lib_Snoopy {
	public $snoopy;
	private static $instance;
	
	private function __construct(){
		$this->setSnoopy();
	}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function setSnoopy(){
		if(empty($this->snoopy)){
			$this->snoopy = new Snoopy();
			$this->snoopy->curl_path = app_publisher_lib_Config::getInstance()->getCurlPath();
		}
	}
}
