<?php
class app_importer_domain_Vereadores {
	private static $instance;
	private $beanRequest;
	private function __construct(){}
  
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
		//$url = 'http://www2.camara.sp.gov.br/Dados_abertos/vereador/vereador.txt';
		$url = './dadosExt/vereador.txt';
		echo "import Vereadores\n";
		echo "url: $url \n";
		$this->import($url);
		echo "\nfim\n";
	}
	
	private function import($url){
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorVereancasBeanDb = new app_importer_bean_db_VereadoresVereancas();
		$vereadorNomeFixBeanDb = new app_importer_bean_db_VereadoresNomeFix();
		$vereadorNomeParlamentarBeanDb = new app_importer_bean_db_VereadoresNomeParlamentar();
		
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorNomeFixAoDb = new app_importer_ao_db_VereadoresNomeFix();
		$vereadorNomeParlamentarAoDb = new app_importer_ao_db_VereadoresNomeParlamentar();
		
		$vereadorAoDb->truncate();
		$vereadorNomeFixAoDb->truncate();
		$vereadorNomeParlamentarAoDb->truncate();
		
		$arrayErroVereador = array();
		$i = 0;
		$handle = fopen($url,'r');
		
		while (!feof($handle)) {
			if ($dataStr = fgets($handle)) {
				$data = explode('#', $dataStr);
				if ($i!= 0 && count($data) == 8){
					$registroStr = utf8_encode($data[0]);
					$nomeCompletoStr = utf8_encode($data[1]);
					$nomesParlamentaresStr = utf8_encode($data[2]);
					
					$nomesParlamentaresArray = explode('%', $nomesParlamentaresStr);
					
					$vereadorBeanDb->id = 0;
					$vereadorBeanDb->id_out = $registroStr;
					$vereadorBeanDb->nome = $nomeCompletoStr;
					$vereadorAoDb->upsert($vereadorBeanDb);
					
					$vereadorNomeFixBeanDb->id = 0;
					$vereadorNomeFixBeanDb->setNomeErrado($nomeCompletoStr);
					$vereadorNomeFixBeanDb->id_vereador = $vereadorBeanDb->id;
					$vereadorNomeFixAoDb->upsert($vereadorNomeFixBeanDb);
					
					
					if (count($nomesParlamentaresArray) > 0 && !empty($nomesParlamentaresArray[0])){
						foreach($nomesParlamentaresArray as $v){
							$vereadorNomeParlamentarBeanDb->id = 0;
							$vereadorNomeParlamentarBeanDb->id_vereador = $vereadorBeanDb->id;
							$vereadorNomeParlamentarBeanDb->nome_parlamentar = $v;
							$vereadorNomeParlamentarAoDb->upsert($vereadorNomeParlamentarBeanDb);
							
							$vereador2BeanDb = $vereadorAoDb->getByNomeFix($v);
							if ($vereador2BeanDb->id == 0){
								$vereadorNomeFixBeanDb->id = 0;
								$vereadorNomeFixBeanDb->setNomeErrado($v);
								$vereadorNomeFixBeanDb->id_vereador = $vereadorBeanDb->id;
								$vereadorNomeFixAoDb->upsert($vereadorNomeFixBeanDb);
							} else if($vereador2BeanDb->id != $vereadorBeanDb->id){
								$arrayErroVereador[$vereador2BeanDb->id] = "[".$v .
										"] x [".$vereador2BeanDb->nome."]";
							}
						}
					}
				}
				$i++;
			}
		}
		if (count($arrayErroVereador) > 0){
			echo "Conflito de nomes parlamentares:\n";
			foreach($arrayErroVereador as $k => $v){
				echo " - ".$k." - ".$v."\n";
			}
		}
		echo "\nimport Vereancias:\n";
		$this->importVereancas($url);
	}
	
	private function importVereancas($url){
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorAnteriorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorVereancasBeanDb = new app_importer_bean_db_VereadoresVereancas();
		
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorVereancasAoDb = new app_importer_ao_db_VereadoresVereancas();
		$vereadorVereancasAoDb->truncate();
		
		$arrayErroVereador = array();
		$i = 0;
		$handle = fopen($url,'r');
		
		while (!feof($handle)) {
			if ($dataStr = fgets($handle)) {
				$data = explode('#', $dataStr);
				if ($i!= 0 && count($data) == 8){
					$registroStr = utf8_encode($data[0]);
					$nomeCompletoStr = utf8_encode($data[1]);
					$vereancasStr = utf8_encode($data[6]);
					
					$vereadorBeanDb = $vereadorAoDb->getByNomeFix($nomeCompletoStr);
					$vereadorVereancasBeanDb->id_vereador = $vereadorBeanDb->id;
					
					$vereancasArray = explode('%',$vereancasStr);
					if (count($vereancasArray) > 0 && !empty($vereancasArray[0])){
						$arrayCampoVereanca = array('i'=>'data_ini',
								'f'=>'data_fim',
								's'=>'situacao',
								'p'=>'partido',
								'b'=>'vereador_anterior',
								'c'=>'partido_obs',
								'd'=>'obs');
						foreach($vereancasArray as $v){
							if (!empty($v)){
								$v = str_replace('^i', "i", $v);
								$detalheVereancasArray = explode('^',$v);
								$vereadorVereancasBeanDb->id = 0;
								$vereadorVereancasBeanDb->data_ini = '';
								$vereadorVereancasBeanDb->data_fim = '';
								$vereadorVereancasBeanDb->obs = '';
								$vereadorVereancasBeanDb->partido = '';
								$vereadorVereancasBeanDb->partido_obs = '';
								
								foreach($detalheVereancasArray as $v2){
									$key = substr($v2, 0,1);
									if ($key != 'b'){
										$vereadorVereancasBeanDb->$arrayCampoVereanca[$key] = substr($v2,1);
									} else {
										$vereadorAnteriorStr = substr($v2,1);
										$vereadorAnteriorBeanDb = 
											$vereadorAoDb->getByNomeFix($vereadorAnteriorStr);
										$id_vereador_anterior = $vereadorAnteriorBeanDb->id;
										$vereadorVereancasBeanDb->
											id_vereador_anterior = $id_vereador_anterior;
										if ($id_vereador_anterior == 0){
											$arrayErroVereador[$vereadorAnteriorStr] = "ERRO";
										}
									}
								}
								$vereadorVereancasAoDb->upsert($vereadorVereancasBeanDb);
							}
						}
					}
				}
				$i++;
			}
		}
		if (count($arrayErroVereador) > 0){
			echo "Vereadores anteriores não encontrados:\n";
			foreach($arrayErroVereador as $k => $v){
				echo " - [".$k."]\n";
			}
		}
	}
	
	public function validaNome($nomeVereador){
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorBeanDb = $vereadorAoDb->getByNomeFix($nomeVereador);
		if ($vereadorBeanDb->id == 0){
			return false;
		}
		return true;
	}
}
