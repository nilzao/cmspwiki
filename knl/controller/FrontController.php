<?php
class knl_controller_FrontController{
	public static function dispatch(){
		$aoReqFrontController = knl_ao_request_FrontController::getInstance();
		$beanReqFrontController = $aoReqFrontController->getBean();
		$app = $beanReqFrontController->getApp();
		if (($app != '') && ($app != 'knl')){
			$class2Call = 'app_'.$app.'_controller_FrontController';
		} else {
			$controller = $beanReqFrontController->getController();
			$controller = ($controller != '') ? $controller : 'Index';
			$class2Call = 'knl_controller_'.$controller;
		}
		@$objCtrl = call_user_func($class2Call.'::getInstance');
		$objCtrl->dispatch();
	}
}
