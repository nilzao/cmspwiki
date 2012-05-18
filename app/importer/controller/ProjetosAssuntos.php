<?php
class app_importer_controller_ProjetosAssuntos{
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function dispatch(){
		app_importer_domain_ProjetosAssuntos::getInstance()->handle();
	}
}
