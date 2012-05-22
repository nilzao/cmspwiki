<?php
class app_publisher_ao_view_Index {
	private static $instance;
	private $bean;
	private $viewArray;
	
	private function __construct(app_publisher_bean_view_Index $bean){
		$this->bean = $bean;
		$this->setViewArray();
	}

	public static function getInstance(app_publisher_bean_view_Index $bean) {
		if(!isset(self::$instance)) {
			self::$instance = new self($bean);
		}
		return self::$instance;
	}
	
	private function setViewArray(){
		$this->viewArray = array();
		$this->viewArray['someVar'] = $this->bean->getVarSample();
	}
	
	public function getBean(){
		return $this->bean;
	}
	
	public function getViewArray(){
		return $this->viewArray;
	}
}
