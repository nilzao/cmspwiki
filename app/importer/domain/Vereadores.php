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

	/*
	public function handle(app_importer_bean_request_Vereadores $beanRequest){
		$this->beanRequest = $beanRequest;
		$metodo = $this->beanRequest->getVarSample();
		if (method_exists($this,$metodo)){
			$this->$metodo();
		} else {
			$this->indexHandler();
		}
	}
	*/
	public function handle(){
		$this->indexHandler();
	}
	
	/*
	public function indexHandler(){
		$beanView = new app_importer_bean_view_Index();
		$beanView->setVarSample($this->beanIndex->getVarSample());
		
		$aoView = app_importer_ao_view_Index::getInstance($beanView);
		$vl = knl_lib_ViewLoader::getInstance();
		$vl->setVar('viewArray',$aoView->getViewArray());
		$vl->display('app/importer','index');
	}
	*/
	public function indexHandler(){
		//
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
	
	private function importVereadoresJson(){
		$json = file_get_contents('./dadosExt/vereadores.json');
		$vereadoresArray = json_decode($json);
		
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorBeanDb->id = 0;
		$vereadorBeanDb->id_out = 0;
		$vereadorBeanDb->nome = '';
		
		$vereadorNomeFixBeanDb = new app_importer_bean_db_VereadoresNomeFix();
		$vereadorNomeFixBeanDb->id = 0;
		$vereadorNomeFixBeanDb->id_vereador = 0;
		$vereadorNomeFixBeanDb->nome_errado = '';
		
		$vereadorNomeParlamentarBeanDb = new app_importer_bean_db_VereadoresNomeParlamentar();
		$vereadorNomeParlamentarBeanDb->id = 0;
		$vereadorNomeParlamentarBeanDb->id_vereador = 0;
		$vereadorNomeParlamentarBeanDb->nome_parlamentar = '';
		
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorNomeFixAoDb = new app_importer_ao_db_VereadoresNomeFix();
		$vereadorNomeParlamentarAoDb = new app_importer_ao_db_VereadoresNomeParlamentar();
		
		foreach($vereadoresArray as $k => $vereador){
			$vereadorBeanDb->id = 0;
			$vereadorBeanDb->id_out = $vereador->id;
			$vereadorBeanDb->nome = $vereador->nome;
			$vereadorAoDb->upsert($vereadorBeanDb);
				
			$vereadorNomeFixBeanDb->nome_errado = app_importer_lib_FixVereadorNome::fixNome($vereador->nome);
			$vereadorNomeFixBeanDb->id_vereador = $vereadorBeanDb->id;
			$vereadorNomeFixBeanDb->id = 0;
			$vereadorNomeFixAoDb->upsert($vereadorNomeFixBeanDb);
		
			foreach($vereador->nomes_parlamentar as $nome_parl){
				if(!empty($nome_parl)){
					$vereadorNomeParlamentarBeanDb->id = 0;
					$vereadorNomeParlamentarBeanDb->id_vereador = $vereadorBeanDb->id;
					$vereadorNomeParlamentarBeanDb->nome_parlamentar = $nome_parl;
					$vereadorNomeParlamentarAoDb->upsert($vereadorNomeParlamentarBeanDb);
						
					$vereadorNomeFixBeanDb->nome_errado = app_importer_lib_FixVereadorNome::fixNome($nome_parl);
					$vereadorNomeFixBeanDb->id = 0;
					$vereadorNomeFixAoDb->upsert($vereadorNomeFixBeanDb);
				}
			}
		}
	}
	
	private function importVereadoresVereancasJson(){
		$json = file_get_contents('./dadosExt/vereadores.json');
		$vereadoresArray = json_decode($json);
		
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorBeanDb->id = 0;
		$vereadorBeanDb->id_out = 0;
		$vereadorBeanDb->nome = '';
		
		$vereadorAnteriorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorAnteriorBeanDb->id = 0;
		$vereadorAnteriorBeanDb->id_out = 0;
		$vereadorAnteriorBeanDb->nome = '';
		
		$vereadorVereancasBeanDb = new app_importer_bean_db_VereadoresVereancas();
		$vereadorVereancasBeanDb->id = 0;
		$vereadorVereancasBeanDb->id_vereador = 0;
		$vereadorVereancasBeanDb->id_vereador_anterior = 0;
		$vereadorVereancasBeanDb->data_ini = '';
		$vereadorVereancasBeanDb->data_fim = '';
		$vereadorVereancasBeanDb->situacao = '';
		$vereadorVereancasBeanDb->partido = '';
		$vereadorVereancasBeanDb->partido_obs = '';
		$vereadorVereancasBeanDb->obs = '';
		
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorVereancasAoDb = new app_importer_ao_db_VereadoresVereancas();
		
		foreach($vereadoresArray as $k => $vereador){
			$vereadorBeanDb = $vereadorAoDb->getByNomeFix($vereador->nome);
			
			foreach($vereador->vereancas as $vereancas){
				$id_vereador_anterior = 0;
				$vereadorAnteriorBeanDb = $vereadorAoDb->getByNomeFix($vereancas->vereador_anterior);
				$id_vereador_anterior = $vereadorAnteriorBeanDb->id;
				
				$vereadorVereancasBeanDb->id = 0;
				$vereadorVereancasBeanDb->id_vereador = $vereadorBeanDb->id;
				$vereadorVereancasBeanDb->id_vereador_anterior = $id_vereador_anterior;
				$vereadorVereancasBeanDb->data_ini = $vereancas->data_inicio;
				$vereadorVereancasBeanDb->data_fim = $vereancas->data_fim;
				$vereadorVereancasBeanDb->situacao = $vereancas->situacao;
				$vereadorVereancasBeanDb->partido = $vereancas->partido;
				$vereadorVereancasBeanDb->partido_obs = $vereancas->partido_obs;
				$vereadorVereancasBeanDb->obs = $vereancas->obs;
				
				$vereadorVereancasAoDb->upsert($vereadorVereancasBeanDb);
			}
		}
		echo "\n\nfim\n";
	}
}
