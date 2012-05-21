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
		$jsonStr = '';
		$gabineteAoDb = new app_exporter_ao_db_Gabinetes();
		$vereadorAoDb = new app_exporter_ao_db_Vereadores();
		$vereadorVereancaAoDb = new app_exporter_ao_db_VereadoresVereancas();
		//tel camara: (11) 3396-4000
		$lista = $gabineteAoDb->getAll();
		$jsonArray = array();
		$i = 0;
		foreach($lista as $gab){
			//print_r($gab);
			$jsonArray[$i]['gabinete'] = $gab;
			$vereadorBeanDb = $vereadorAoDb->getById($gab->id_vereador);
			//print_r($vereadorBeanDb);
			$jsonArray[$i]['vereador'] = $vereadorBeanDb;
			$vereadorVereancaBeanDb = $vereadorVereancaAoDb->getByIdVereador($vereadorBeanDb->id);
			//print_r($vereadorVereancaBeanDb);
			$jsonArray[$i]['vereancas'] = $vereadorVereancaBeanDb;
			
			if (!empty($vereadorVereancaBeanDb) 
				&& !empty($vereadorVereancaBeanDb[0])
				&& !empty($vereadorVereancaBeanDb[0]->id_vereador_anterior) ){
				$jsonArray[$i]['vereador_anterior'] = 
					$vereadorAoDb->getById($vereadorVereancaBeanDb[0]->id_vereador_anterior);
			}
			
			
			
			//print_r($jsonArray);
			$jsonStr .= json_encode($jsonArray)."\n";
			
			$i++;
			
			//echo $jsonStr;
			$arrayResult = json_decode($jsonStr);
			print_r($arrayResult);
			die();
		}
		echo "\nfim\n";
	}
}
