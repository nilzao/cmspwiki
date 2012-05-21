<?php
class app_exporter_domain_Index {
	private static $instance;
	private $beanIndex;
	private function __construct(){}
  
	public static function getInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance; 
	}

	public function handle(app_exporter_bean_request_Index $beanIndex){
		$this->beanIndex = $beanIndex;
		$metodo = $this->beanIndex->getVarSample();
		if (method_exists($this,$metodo)){
			$this->$metodo();
		} else {
			$this->indexHandler();
		}
	}
	
	public function indexHandler(){
		$beanView = new app_exporter_bean_view_Index();
		$beanView->setVarSample($this->beanIndex->getVarSample());
		
		$aoView = app_exporter_ao_view_Index::getInstance($beanView);
		$vl = knl_lib_ViewLoader::getInstance();
		$vl->setVar('viewArray',$aoView->getViewArray());
		$vl->display('app/exporter','index');
	}
}
