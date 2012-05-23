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
		$this->export();
		echo "\nfim\n";
	}
	
	private function export(){
		$gabineteAoDb = new app_exporter_ao_db_Gabinetes();
		$vereadorAoDb = new app_exporter_ao_db_Vereadores();
		$projetosAoDb = new app_exporter_ao_db_Projetos();
		$vereadorVereancaAoDb = new app_exporter_ao_db_VereadoresVereancas();
		$votacaoResumo = new app_exporter_ao_db_VereadoresVotacaoResumo();
		$gabineteFuncionariosAoDb = new app_exporter_ao_db_GabinetesFuncionarios();
		$gabineteDespesasResumoAoDb = new app_exporter_ao_db_GabinetesDespesasResumo();
		$rankingVereadorAoDb = new app_exporter_ao_db_Rankings();
		
		$listaNomes = array();
		$lista = $gabineteAoDb->getAll();

		foreach($lista as $gab){
			$jsonArray = array();
			$jsonArray['gabinete'] = $gab;
			$vereadorBeanDb = $vereadorAoDb->getById($gab->id_vereador);
			
			$jsonArray['vereador'] = $vereadorBeanDb;
			$vereadorVereancaArrayBeanDb = $vereadorVereancaAoDb->getByIdVereador($vereadorBeanDb->id);
			$jsonArray['vereancas'] = $vereadorVereancaArrayBeanDb;
			$jsonArray['resumo_votos'] = $votacaoResumo->getByIdVereador($vereadorBeanDb->id);
			$jsonArray['funcionarios'] = $gabineteFuncionariosAoDb->getByIdGab($gab->id);
			$jsonArray['materias'] = $projetosAoDb->getByIdVereador($vereadorBeanDb->id);
			
			$arrayIdVereadores = array($vereadorBeanDb->id);
			$jsonArray['despesas'] =
				$gabineteDespesasResumoAoDb->getByListId($arrayIdVereadores);
			
			$jsonStr = json_encode($jsonArray)."\n";
			
			$nomeVereador = app_importer_lib_FixVereadorNome::fixNome($vereadorBeanDb->nome);
			$nomeVereador = strtolower($nomeVereador);
			$nomeVereador = ucfirst($nomeVereador).'_'.$vereadorBeanDb->id;
			$listaNomes[] = $nomeVereador;
			file_put_contents('./dadosJson/'.$nomeVereador.'.json', $jsonStr);
		}
		$jsonStr = '';
		$jsonStr = json_encode($listaNomes);
		file_put_contents('./dadosJson/vereadores_arquivos.json', $jsonStr);
	}
}
