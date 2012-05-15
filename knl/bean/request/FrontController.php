<?php
class knl_bean_request_FrontController {
	private $controller;
	private $app;
	
	public function setApp($var){
		$this->app = $var;
	}
	
	public function setController($var){
		$this->controller = $var;
	}
	
	public function getApp(){
		return $this->app;
	}
	
	public function getController(){
		return $this->controller;
	}
}
?>