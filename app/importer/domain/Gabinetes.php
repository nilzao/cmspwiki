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
		$this->import($url);
	}
	
	public function import($url){
		$url = '';
		$xmlObj = simplexml_load_file($url);
		$gabineteAoDb = new app_importer_ao_db_Gabinetes();
		$gabineteBeanDb = new app_importer_bean_db_Gabinetes();
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		
		foreach($xmlObj as $vereador){
			$vereadorBeanDb = $vereadorAoDb->getByNomeFix($vereador->NOME_PARLAMENTAR);
			$vereador_id = $vereadorBeanDb->id;
			
			$gabineteBeanDb->id = 0;
			$gabineteBeanDb->id_vereador = $vereador_id;
			$gabineteBeanDb->num_gabinete = (int) $vereador->GV;
			$gabineteBeanDb->ramal = (string) $vereador->RAMAL;
			$gabineteBeanDb->fax = (string) $vereador->FAX;
			$gabineteBeanDb->sala = (string) $vereador->SALA;
			
			$gabineteAoDb->upsert($gabineteBeanDb);
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
