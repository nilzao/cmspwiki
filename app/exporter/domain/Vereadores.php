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
		$projetosAoDb = new app_exporter_ao_db_Projetos();
		$vereadorVereancaAoDb = new app_exporter_ao_db_VereadoresVereancas();
		//tel camara: (11) 3396-4000
		$lista = $gabineteAoDb->getAll();
		$jsonArray = array();
		$i = 0;
		foreach($lista as $gab){
			$jsonArray[$i]['gabinete'] = $gab;
			$vereadorBeanDb = $vereadorAoDb->getById($gab->id_vereador);
			$jsonArray[$i]['vereador'] = $vereadorBeanDb;
			$vereadorVereancaArrayBeanDb = $vereadorVereancaAoDb->getByIdVereador($vereadorBeanDb->id);
			$jsonArray[$i]['vereancas'] = $vereadorVereancaArrayBeanDb;
			if (!empty($vereadorVereancaArrayBeanDb) 
				&& !empty($vereadorVereancaArrayBeanDb[0])
				&& !empty($vereadorVereancaArrayBeanDb[0]->id_vereador_anterior) ){
				$jsonArray[$i]['vereador_anterior'] = 
					$vereadorAoDb->getById($vereadorVereancaArrayBeanDb[0]->id_vereador_anterior);
			}
			
			$jsonArray[$i]['materias'] = $projetosAoDb->getByIdVereador($vereadorBeanDb->id);
			
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
