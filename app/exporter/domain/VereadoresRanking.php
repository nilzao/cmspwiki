<?php
class app_exporter_domain_VereadoresRanking {
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
		$rankingAoDb = new app_exporter_ao_db_Rankings();
		echo "export VereadoresRanking\n";
		$rankingAoDb->truncate();
		$this->setRankingTotalGastosGabinete();
		$this->exportRankingTotalGastosGabinete();
		echo "\nfim\n";
	}
	
	private function exportRankingTotalGastosGabinete(){
		
	}
	
	private function setRankingTotalGastosGabinete(){
		$gabineteAoDb = new app_exporter_ao_db_Gabinetes();
		$vereadorAoDb = new app_exporter_ao_db_Vereadores();
		$vereadorVereancaAoDb = new app_exporter_ao_db_VereadoresVereancas();
		$rankingAoDb = new app_exporter_ao_db_Rankings();
		$rankingBeanDb = new app_exporter_bean_db_Rankings();
		
		$gabineteDespesasResumoAoDb = new app_exporter_ao_db_GabinetesDespesasResumo();
		
		$lista = $gabineteAoDb->getAll();
		$arrayTmp = array();
		
		foreach($lista as $gab){
			$vereadorBeanDb = $vereadorAoDb->getById($gab->id_vereador);
			$arrayIdVereadores = $vereadorAoDb->getAllAnteriores($vereadorBeanDb->id);
			$id = $vereadorBeanDb->id;
			$despesas = $gabineteDespesasResumoAoDb->getByListId($arrayIdVereadores);
			$despesas = end($despesas);
			$arrayTmp[$id] = str_replace('.', '', $despesas->total);
			$arrayTmp[$id] = (float) str_replace(',', '.', $arrayTmp[$id]);
		}
		arsort($arrayTmp);
		$i = 1;
		foreach($arrayTmp as $k => $v){
			$rankingBeanDb->id = 0;
			$rankingBeanDb->id_ranking_tipo = 0;
			$rankingBeanDb->id_vereador = $k;
			$rankingBeanDb->posicao = $i;
			$i++;
			$rankingAoDb->upsert($rankingBeanDb);
		}
	}
}
