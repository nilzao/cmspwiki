<?php
class app_importer_bean_request_FrontController {
	private $controller;
	private $domain;
	
	public function setDomain($var){
		$this->domain = $var;
	}
	
	public function setController($var){
		$this->controller = $var;
	}
	
	public function getDomain(){
		return $this->domain;
	}
	
	public function getController(){
		return $this->controller;
	}
}
