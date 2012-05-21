<?php
class app_exporter_domain_Vereadores {
	private static $instance;
	private function __construct(){
	}
	
	public static function getInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function handle(){
		$this->indexHandler();
	}
	
	public function indexHandler(){
		echo "export Vereadores\n";
		$gabineteAoDb = new app_exporter_ao_db_Gabinetes();
		$vereadorAoDb = new app_exporter_ao_db_Vereadores();
		$vereadorVereancaAoDb = new app_exporter_ao_db_VereadoresVereancas();
		//tel camara: (11) 3396-4000
		$lista = $gabineteAoDb->getAll();
		foreach($lista as $gab){
			print_r($gab);
			$vereadorBeanDb = $vereadorAoDb->getById($gab->id_vereador);
			print_r($vereadorBeanDb);
			$vereadorVereancaBeanDb = $vereadorVereancaAoDb->getByIdVereador($vereadorBeanDb->id);
			print_r($vereadorVereancaBeanDb);
			die();
		}
		echo "\nfim\n";
	}
}
