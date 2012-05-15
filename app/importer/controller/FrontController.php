<?php
class app_importer_controller_FrontController {
	private static $instance;
	
	private function __construct(){}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function dispatch(){
		$aoReqFrontController = app_importer_ao_request_FrontController::getInstance();
		$beanReqFrontController = $aoReqFrontController->getBean();
		$domain = $beanReqFrontController->getController();
		$controller = $beanReqFrontController->getController();
		$controller = ($controller != '') ? $controller : 'Index';
		$class2Call = 'app_importer_controller_'.$controller;
		@$objCtrl = call_user_func($class2Call.'::getInstance');
		$objCtrl->dispatch();
	}
}
