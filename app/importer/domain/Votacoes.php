<?php
class app_importer_domain_Votacoes {
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
		$arrayUrl[] = './dadosExt/Votacoes_2010.xml';
		$arrayUrl[] = './dadosExt/Votacoes_2011.xml';
		$arrayUrl[] = './dadosExt/Votacoes_2012.xml';
		$this->verificaVereadorXml
			($arrayUrl[2]);
	}
	
	public function verificaVereadorXml($url){
		$xmlObj = simplexml_load_file($url);
		foreach ($xmlObj->Votacao as $votacao) {
			foreach($votacao->Vereador as $vereador){
				if (!app_importer_domain_Vereadores::getInstance()->validaNome($vereador['NomeParlamentar'])){
					echo $vereador['NomeParlamentar']." - ERRO \n";
				}
			}
		}
		echo "\nfim\n";
	}
}
