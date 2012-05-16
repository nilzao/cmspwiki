<?php
class app_importer_domain_MateriasTipo {
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
		echo "materias\n";
		$url = 'http://www2.camara.sp.gov.br/projetos/tipo_materia_legislativa.xml';
		$this->import($url);
		echo "\nfim\n\n";
	}
	
	public function import($url){
		$materiasTipoAoDb = new app_importer_ao_db_MateriasTipo();
		$materiasTipoAoDb->truncate();
		
		$materiasTipoBeanDb = new app_importer_bean_db_MateriasTipo();
		$xmlObj = simplexml_load_file($url);
			foreach($xmlObj->TIPO_MATERIA_LEGISLATIVA as $tipo_materia){
				$materiasTipoBeanDb->id = 0;
				$materiasTipoBeanDb->descricao = $tipo_materia->TXT_MTRA_LEGL;
				$materiasTipoBeanDb->codigo = $tipo_materia->COD_MTRA_LEGL;
				$materiasTipoBeanDb->abreviacao = $tipo_materia->SGL_MTRA_LEGL;
				$materiasTipoAoDb->upsert($materiasTipoBeanDb);
			}
	}
}
