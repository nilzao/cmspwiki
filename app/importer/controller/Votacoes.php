<?php
class app_importer_controller_Votacoes{
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function dispatch(){
		app_importer_domain_Votacoes::getInstance()->handle();
	}
}
