<?php
class app_importer_domain_ProjetosAssuntos {
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
		//$url = 'http://www2.camara.sp.gov.br/projetos/assunto.txt';
		$url = './dadosExt/assunto.txt';
		echo "import ProjetosAssuntos\n";
		echo "url: $url \n";
		$this->import($url);
		echo "\nfim\n";
	}
	
	public function import($url){
		/*
		$projetosAoDb = new app_importer_ao_db_Projetos();
		$projetosBeanDb = new app_importer_bean_db_Projetos();
		
		
		
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		
		$i = 0;
		$handle = fopen($url,'r');
		$arrayErroVereador = array();
		$arrayErroProjetos = array();
		while (($data = fgetcsv($handle,0,'#')) !== FALSE) {
			if ((!empty($data[3]) && $i!=0)){
				$projetosBeanDb->id = 0;
				$projetosBeanDb->tipo_projeto = strtoupper(utf8_encode($data[0]));
				$projetosBeanDb->numero_projeto = strtoupper(utf8_encode($data[1]));
				$projetosBeanDb->data_projeto = strtoupper(utf8_encode($data[2]));
				
				$vereadorBeanDb->id = 0;
				$vereadorBeanDb = $vereadorAoDb->getByNomeFix($data[3]);

				$projetosAoDb->getByTipoNumData($projetosBeanDb);
				
				if ($vereadorBeanDb->id != 0 && $projetosBeanDb->id != 0){
					$projetosAutoresBeanDb->id = 0;
					$projetosAutoresBeanDb->id_projeto = $projetosBeanDb->id;
					$projetosAutoresBeanDb->id_vereador = $vereadorBeanDb->id;
					$projetosAutoresAoDb->upsert($projetosAutoresBeanDb);
				} else if ($projetosBeanDb->id == 0){
					$nome = strtoupper(utf8_encode($data[0]));
					$nome .= "-".strtoupper(utf8_encode($data[1]));
					$nome .= "-".strtoupper(utf8_encode($data[2]));
					$arrayErroProjetos[$nome] = "ERRO";
				} else {
					$nome = strtoupper(utf8_encode($data[3]));
					$arrayErroVereador[$nome] = "ERRO";
				}
			}
			$i++;
		}
		fclose ($handle);
		if (count($arrayErroVereador) > 0){
			ksort($arrayErroVereador);
			echo "Vereadores não encontrados: \n";
			foreach($arrayErroVereador as $k => $v){
				echo " - ".$k."\n";
			}
		}
		
		if (count($arrayErroProjetos) > 0){
			ksort($arrayErroProjetos);
			echo "Projetos não encontrados: \n";
			foreach($arrayErroProjetos as $k => $v){
				echo " - ".$k."\n";
			}
		}
		*/
	}
}
