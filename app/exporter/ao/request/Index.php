<?php
class app_exporter_ao_request_Index {
	private $bean;

	private static $instance;
	
	private function __construct(){
		$this->bean = new app_exporter_bean_request_Index();
		$this->setBeanFromRequest();
		$this->setBeanFromShell();
	}

	public static function getInstance() {
        if(!isset(self::$instance)) {
        	self::$instance = new self();
        }
        return self::$instance;
	}
	
	private function setBeanFromRequest(){
		$this->bean->setVarSample(knl_lib_Registry::getRequestKey('myvar'));
	}
	
	private function setBeanFromShell(){
		if (knl_lib_ShellArgs::getInstance()->isSetShellArgs()){
			$this->bean->setVarSample(knl_lib_Registry::getShellArg(3));
		}
	}
	
	public function getBean(){
		return $this->bean;
	}
}
