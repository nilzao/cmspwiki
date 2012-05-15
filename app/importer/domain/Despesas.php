<?php
class app_importer_domain_Despesas {
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
		
		//formato antigo:
		$arrayUrlOld = array();
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200708.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200709.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200710.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200711.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200712.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200801.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200802.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200803.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200804.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200805.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200806.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200807.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200808.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200809.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200810.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200811.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200812.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200901.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200902.xml';
		$arrayUrlOld[] = 'http://www2.camara.sp.gov.br/SAEG/200903.xml';
		//fim formato antigo
		
		$arrayUrl = array();
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200904.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200905.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200906.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200907.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200908.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200909.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200910.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200911.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/200912.xml';
		
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201001.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201002.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201003.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201004.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201005.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201006.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201007.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201008.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201009.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201010.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201011.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201012.xml';
		
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201101.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201102.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201103.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201104.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201105.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201106.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201107.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201108.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201109.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201110.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201111.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201112.xml';
		
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201201.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SAEG/201202.xml';
		/*
		foreach($arrayUrl as $url){
			echo $url."<br/>\n";
			$this->verificaVereadorXml($url);
		}
		*/
		
		foreach($arrayUrlOld as $url){
			echo $url."<br/>\n";
			$this->import($url,false);
		}
		
		foreach($arrayUrl as $url){
			echo $url."<br/>\n";
			$this->import($url);
		}		
		
		echo "fim";
	}
	
	/*
	 * import($url,false) para formato xml até 200903
	 * import($url) para formato xml a partir de 200904
	 */
	public function import($url,$default = true){
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$gabineteDespesaTipoAoDb =  new app_importer_ao_db_GabinetesDespesasTipo();
		$gabineteDespesaEmpresaAoDb =  new app_importer_ao_db_GabinetesDespesasEmpresas();
		$gabineteDespesaAoDb =  new app_importer_ao_db_GabinetesDespesas();
		
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorBeanDb->id = 0;
		
		$gabineteDespesaTipoBeanDb = new app_importer_bean_db_GabinetesDespesasTipo();
		$gabineteDespesaTipoBeanDb->id = 0;
		
		$gabineteDespesaEmpresaBeanDb = new app_importer_bean_db_GabinetesDespesasEmpresas();
		$gabineteDespesaEmpresaBeanDb->id = 0;
		
		$gabineteDespesaBeanDb = new app_importer_bean_db_GabinetesDespesas();
		
		$gabineteDespesaEmpresaBeanDb =
			$gabineteDespesaEmpresaAoDb->
				getByCnpj($gabineteDespesaEmpresaBeanDb->getCnpj());
		$gabineteDespesaEmpresaAoDb->upsert($gabineteDespesaEmpresaBeanDb);
		$gabineteDespesaEmpresaBeanDb =
			$gabineteDespesaEmpresaAoDb->
		getByCnpj($gabineteDespesaEmpresaBeanDb->getCnpj());
				
		$xmlObj = simplexml_load_file($url);
		foreach ($xmlObj->LIST_G_DEPUTADO->G_DEPUTADO as $g_vereador) {
			$id_vereador = 0;
			$vereadorBeanDb = $vereadorAoDb->getByNomeFix($g_vereador->NM_DEPUTADO);
			$id_vereador = $vereadorBeanDb->id;
				
			foreach($g_vereador->LIST_G_TIPO_DESPESA->G_TIPO_DESPESA as $g_tipo_despesa) {
				if (!substr_count((string)$g_tipo_despesa->NM_TIPO_DESPESA, 'TOTAL') > 0 
					&& (substr_count($g_vereador->NM_DEPUTADO, "LIDERANÇA") < 1)
					&& (substr_count($g_vereador->NM_DEPUTADO, "CÂMARA MUNICIPAL DE SÃO PAULO") < 1)) {
					$gabineteDespesaTipoBeanDb = 
						$gabineteDespesaTipoAoDb->getByDescricao((string) $g_tipo_despesa->NM_TIPO_DESPESA);
					$gabineteDespesaTipoAoDb->upsert($gabineteDespesaTipoBeanDb);
					
					if ($default){
						foreach($g_tipo_despesa->LIST_G_BENEFICIARIO->G_BENEFICIARIO as $g_beneficiario){
							if (0 < (float) $g_beneficiario->VL_DESP){
								$gabineteDespesaEmpresaBeanDb->cnpj = $g_beneficiario->NR_CNPJ;
								$gabineteDespesaEmpresaBeanDb =
									$gabineteDespesaEmpresaAoDb->
										getByCnpj($gabineteDespesaEmpresaBeanDb->getCnpj());
								$gabineteDespesaEmpresaBeanDb->cnpj = $g_beneficiario->NR_CNPJ;
								$gabineteDespesaEmpresaBeanDb->razao_social = 
									$g_beneficiario->NM_BENEFICIARIO;
								$gabineteDespesaEmpresaAoDb->upsert($gabineteDespesaEmpresaBeanDb);
								
								$gabineteDespesaBeanDb->id = 0;
								$gabineteDespesaBeanDb->id_vereador = $id_vereador;
								$gabineteDespesaBeanDb->id_gabinete_despesa_tipo =
								$gabineteDespesaTipoBeanDb->id;
								$gabineteDespesaBeanDb->id_gabinete_despesa_empresa =
								$gabineteDespesaEmpresaBeanDb->id;
								$gabineteDespesaBeanDb->mes = (int) $g_tipo_despesa->NR_MES_REF;
								$gabineteDespesaBeanDb->ano = (int) $g_tipo_despesa->NR_ANO_REF;
								$gabineteDespesaBeanDb->valor = (string) $g_beneficiario->VL_DESP;
									
								$gabineteDespesaAoDb->upsert($gabineteDespesaBeanDb);
							}
						}
					} else if (0 < (float) $g_tipo_despesa->VL_DESP){
						//print_r($g_tipo_despesa);
						$gabineteDespesaBeanDb->id = 0;
						$gabineteDespesaBeanDb->id_vereador = $id_vereador;
						$gabineteDespesaBeanDb->id_gabinete_despesa_tipo =
							$gabineteDespesaTipoBeanDb->id;
						$gabineteDespesaBeanDb->id_gabinete_despesa_empresa =
							$gabineteDespesaEmpresaBeanDb->id;
						$gabineteDespesaBeanDb->mes = (int) $g_tipo_despesa->NR_MES_REF;
						$gabineteDespesaBeanDb->ano = (int) $g_tipo_despesa->NR_ANO_REF;
						$gabineteDespesaBeanDb->valor = (string) $g_tipo_despesa->VL_DESP;
							
						$gabineteDespesaAoDb->upsert($gabineteDespesaBeanDb);
					}
				}
			}
		}
	}
	
	
	public function verificaVereadorXml($url){
		$xmlObj = simplexml_load_file($url);
		$arrayOutros = array('CÂMARA MUNICIPAL DE SÃO PAULO');
		foreach ($xmlObj->LIST_G_DEPUTADO->G_DEPUTADO as $g_vereador) {
			if (!in_array($g_vereador->NM_DEPUTADO, $arrayOutros)
				&& (substr_count($g_vereador->NM_DEPUTADO, "LIDERANÇA") < 1)
				&& !app_importer_domain_Vereadores::getInstance()->validaNome($g_vereador->NM_DEPUTADO)){
				echo $g_vereador->NM_DEPUTADO." - ERRO $url\n";
			}
		}
	}
}
