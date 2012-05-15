<?php
class app_importer_domain_Projetos {
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
		$this->verificaVereadorTxt
			('./dadosExt/autor.txt');
	}
	
	public function verificaVereadorTxt($url){
		$i = 0;
		$handle = fopen($url,'r');
		$arrayOutros = array('E OUTROS',
							 'EXECUTIVO',
							 'MESA DA CAMARA MUNICIPAL DE SAO PAULO',
							 'ASSOCIACAO DE COMISSARIOS DE VOO DO BRASIL',
							 'ADMINISTRACAO PUBLICA',
							 'POLITICA URBANA,METROPOLITANA,MEIO AMB.',
							 'COLETA ASSINATURAS PRIV.CMTC-PAS.PUBLICO',
							 'TRIBUNAL DE CONTAS DO MUNICIPIO',
							 'ASSEMBLEIA MUNICIPAL CONSTITUINTE',
							 'LIDERANCA DAS BANCADAS',
							 'CONSTITUICAO E JUSTICA',
							 'EDUCACAO, CULTURA E ESPORTES',
							 'CPI-TRIBUNAL DE CONTAS DO MUNICIPIO',
							 'SAUDE, PROMOCAO SOCIAL E TRABALHO',
							 'DEMOCRATAS',
							 'FINANCAS E ORCAMENTO');
		$arrayErros = array();
		while (($data = fgetcsv($handle,0,'#')) !== FALSE) {
			if(!empty($data[3]) 
					&& $i!=0 
					&& !in_array($data[3], $arrayOutros)
					&& (substr_count($data[3], "COMISSAO") < 1)
					&& (substr_count($data[3], "PARTIDO") < 1)
					&& (substr_count($data[3], "PART.") < 1)){
				//echo $data[3];
				if (!app_importer_domain_Vereadores::getInstance()->validaNome($data[3])){
					//echo $data[3]." - ERRO";
					$arrayErros[$data[3]] = 'ERRO';
				}
			}
			$i++;
		}
		print_r($arrayErros);
		fclose ($handle);
	}
}
