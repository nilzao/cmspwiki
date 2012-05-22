<?php
class app_publisher_controller_Index{
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function dispatch(){
		$bean = app_publisher_ao_request_Index::getInstance()->getBean();
		app_publisher_domain_Index::getInstance()->handle($bean);
	}
}
