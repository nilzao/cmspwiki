<?php
class app_importer_domain_Presencas {
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
		$this->verificaVereadorXml
			('http://www2.camara.sp.gov.br/SIP/BaixarXML.aspx?arquivo=Presencas_2012_05_10_[0].xml');
	}
	
	public function verificaVereadorXml($url){
		$xmlObj = simplexml_load_file($url);
		foreach ($xmlObj->Presencas->Vereador as $vereador) {
			if (!app_importer_domain_Vereadores::getInstance()->validaNome($vereador['NomeParlamentar'])){
				echo $vereador['NomeParlamentar']." - ERRO";
			}
			echo "\n";
		}
	}
}
