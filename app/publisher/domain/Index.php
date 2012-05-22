<?php
class app_publisher_domain_Index {
	private static $instance;
	private $beanIndex;
	private function __construct(){}
  
	public static function getInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance; 
	}

	public function handle(app_publisher_bean_request_Index $beanIndex){
		$this->indexHandler();
		
	}
	
	public function indexHandler(){
		app_publisher_domain_Vereadores::getInstance()->handle();
	}
}
