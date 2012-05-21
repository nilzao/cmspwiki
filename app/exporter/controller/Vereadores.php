<?php
class app_exporter_controller_Vereadores{
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function dispatch(){
		app_exporter_domain_Vereadores::getInstance()->handle();
	}
}
