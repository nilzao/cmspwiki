<?php
class app_importer_domain_Index {
	private static $instance;
	private $beanIndex;
	private function __construct(){}
  
	public static function getInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance; 
	}

	public function handle(app_importer_bean_request_Index $beanIndex){
		$this->indexHandler();
	}
	
	public function indexHandler(){
		app_importer_domain_Vereadores::getInstance()->handle();
		app_importer_domain_Gabinetes::getInstance()->handle();
		app_importer_domain_Projetos::getInstance()->handle();
		app_importer_domain_MateriasTipo::getInstance()->handle();
		app_importer_domain_Despesas::getInstance()->handle();
		app_importer_domain_Funcionarios::getInstance()->handle();
		app_importer_domain_ProjetosAutores::getInstance()->handle();
		app_importer_domain_ProjetosAssuntos::getInstance()->handle();
	}
}
