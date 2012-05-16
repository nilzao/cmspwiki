<?php
class app_importer_domain_Gabinetes {
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
		$url = 'http://www2.camara.sp.gov.br/Dados_abertos/vereador/Lista_Vereadores.xml';
		echo "import Gabinetes\n";
		echo "url: $url \n";
		$this->import($url);
		echo "\nfim\n";
	}
	
	public function import($url){
		$xmlObj = simplexml_load_file($url);
		$gabineteAoDb = new app_importer_ao_db_Gabinetes();
		$gabineteBeanDb = new app_importer_bean_db_Gabinetes();
		$gabineteAoDb->truncate();
		
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$arrayErroVereador = array();
		
		foreach($xmlObj as $vereador){
			$vereadorBeanDb = $vereadorAoDb->getByNomeFix($vereador->NOME_PARLAMENTAR);
			$vereadorBeanDb->id;
			
			if ($vereadorBeanDb->id != 0){
				$gabineteBeanDb->id = 0;
				$gabineteBeanDb->id_vereador = $vereadorBeanDb->id;
				$gabineteBeanDb->num_gabinete = (int) $vereador->GV;
				$gabineteBeanDb->ramal = (string) $vereador->RAMAL;
				$gabineteBeanDb->fax = (string) $vereador->FAX;
				$gabineteBeanDb->sala = (string) $vereador->SALA;
				$gabineteAoDb->upsert($gabineteBeanDb);
			} else {
				$nome = (string) $vereador->NOME_PARLAMENTAR;
				$arrayErroVereador[$nome] = "ERRO";
			}
		}
		if (count($arrayErroVereador) > 0){
			ksort($arrayErroVereador);
			echo "Vereadores não encontrados: \n";
			foreach($arrayErroVereador as $k => $v){
				echo " - ".$k."\n";
			}
		}
	}
	
	public function verificaVereadorXml($url){
		$xmlObj = simplexml_load_file($url);
		foreach ($xmlObj as $vereador) {
			echo $vereador->NOME_PARLAMENTAR;
			if (!app_importer_domain_Vereadores::getInstance()->validaNome($vereador->NOME_PARLAMENTAR)){
				echo " - ERRO";
			}
			echo "\n";
		}
	}
}
