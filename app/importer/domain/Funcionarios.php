<?php
/*
query p/ ranking
SELECT vereadores.nome,SUM(1) as qtd FROM `gabinetes_funcionarios`
left join gabinetes on (gabinetes.id = gabinetes_funcionarios.id_gabinete)
left join vereadores on (gabinetes.id_vereador = vereadores.id)
GROUP BY id_gabinete
ORDER BY `qtd` DESC
*/
class app_importer_domain_Funcionarios {
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
		//$url = 'http://www2.camara.sp.gov.br/funcionarios/CMSP-XML-Funcionarios.xml';
		$url = './dadosExt/CMSP-XML-Funcionarios.xml';
		$this->import($url);
		echo "\nfim\n\n";
	}
	
	public function import($url){
		$xmlObj = simplexml_load_file($url);
		
		$gabineteFuncionarioAoDb = new app_importer_ao_db_GabinetesFuncionarios();
		$gabineteFuncionarioBeanDb = new app_importer_bean_db_GabinetesFuncionarios();
		
		$gabineteAoDb = new app_importer_ao_db_Gabinetes();
		$gabineteBeanDb = new app_importer_bean_db_Gabinetes();
		
		foreach ($xmlObj->Funcionario as $funcionario) {
			$strCentoCusto = (string) $funcionario->Centro_de_Custos;
			$strCentoCusto = strtoupper($strCentoCusto);
			if (substr_count($strCentoCusto,"VEREADOR") > 0){
				$num_gab = preg_replace ( '/[^0-9]/', '', $strCentoCusto);
				$gabineteBeanDb = $gabineteAoDb->getByNumGab($num_gab);
				
				$gabineteFuncionarioBeanDb->id = 0;
				$gabineteFuncionarioBeanDb->id_gabinete = $gabineteBeanDb->id;
				$gabineteFuncionarioBeanDb->nome = (string) $funcionario->Nome_Servidor;
				$gabineteFuncionarioBeanDb->cargo = (string) $funcionario->Descricao_Cargo;
				
				$gabineteFuncionarioAoDb->upsert($gabineteFuncionarioBeanDb);
			}
		}
	}
}
