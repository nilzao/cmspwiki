<?php
class app_importer_controller_Funcionarios{
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function dispatch(){
		//$bean = app_importer_ao_request_Vereadores::getInstance()->getBean();
		//app_importer_domain_Vereadores::getInstance()->handle($bean);
		app_importer_domain_Funcionarios::getInstance()->handle();
	}
}
