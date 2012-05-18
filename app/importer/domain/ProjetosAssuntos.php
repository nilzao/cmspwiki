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
		$projetosBeanDb = new app_importer_bean_db_Projetos();
		$projetosAssuntosBeanDb = new app_importer_bean_db_ProjetosAssuntos();
		
		$projetosAoDb = new app_importer_ao_db_Projetos();
		$projetosAssuntosAoDb = new app_importer_ao_db_ProjetosAssuntos();
		
		$projetosAssuntosAoDb->truncate();
		
		$i = 0;
		$handle = fopen($url,'r');
		$arrayErroProjetos = array();
		
		while (($data = fgetcsv($handle,0,'#',"\x01")) !== FALSE) {
			if ($i!=0 && count($data) == 4){
				$projetosBeanDb->id = 0;
				$projetosBeanDb->tipo_projeto = strtoupper(utf8_encode($data[0]));
				$projetosBeanDb->numero_projeto = strtoupper(utf8_encode($data[1]));
				$projetosBeanDb->data_projeto = strtoupper(utf8_encode($data[2]));

				$projetosAoDb->getByTipoNumData($projetosBeanDb);
				
				if ($projetosBeanDb->id == 0){
					$nome = strtoupper(utf8_encode($data[0]));
					$nome .= "-".strtoupper(utf8_encode($data[1]));
					$nome .= "-".strtoupper(utf8_encode($data[2]));
					$arrayErroProjetos[$nome] = "ERRO";
				} else {
					$projetosAssuntosBeanDb->id = 0;
					$projetosAssuntosBeanDb->id_projeto = $projetosBeanDb->id;
					$projetosAssuntosBeanDb->assunto_descricao = strtoupper(utf8_encode($data[3]));
					//print_r($projetosAssuntosBeanDb);
					$projetosAssuntosAoDb->upsert($projetosAssuntosBeanDb);
				}
			}
			$i++;
		}
		fclose ($handle);
		if (count($arrayErroProjetos) > 0){
			ksort($arrayErroProjetos);
			echo "Projetos não encontrados: \n";
			foreach($arrayErroProjetos as $k => $v){
				echo " - ".$k."\n";
			}
		}
	}
}
