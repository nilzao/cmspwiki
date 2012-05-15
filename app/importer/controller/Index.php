<?php
class app_importer_controller_Index{
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function dispatch(){
		$bean = app_importer_ao_request_Index::getInstance()->getBean();
		app_importer_domain_Index::getInstance()->handle($bean);
	}
}
