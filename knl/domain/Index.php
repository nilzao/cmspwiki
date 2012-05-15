<?php
class knl_domain_Index {
	private static $instance;
	private $beanIndex;
	private function __construct(){}
  
	public static function getInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance; 
	}

	public function handle(knl_bean_request_Index $beanIndex){
		$this->beanIndex = $beanIndex;
		$metodo = $this->beanIndex->getVarSample();
		if (method_exists($this,$metodo)){
			$this->$metodo();
		} else {
			$this->indexHandler();
		}
	}
	
	public function indexHandler(){
		$vl = knl_lib_ViewLoader::getInstance();
		$vl->setVar('someVar',$this->beanIndex->getVarSample());
		$vl->display('knl','index');
	}
}
