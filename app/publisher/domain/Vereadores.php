<?php
class app_publisher_domain_Vereadores {
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
		$rankingAoDb = new app_exporter_ao_db_Rankings();
		echo "publish Vereadores\n";
		$this->publish();
		echo "\nfim\n";
	}
	
	private function publish(){
		//precisa refatorar isso, criar ao para json, bean para json, array mais simples p/ view
		$paginaAoSnoopy = new app_publisher_ao_snoopy_Paginas();
		$paginaBeanSnoopy = new app_publisher_bean_snoopy_Paginas();
		
		$jsonListaVereadores = file_get_contents('./dadosJson/vereadores_arquivos.json');
		$arrayListaVereadores = json_decode($jsonListaVereadores);
		$arrayVereadoresNome = array();
		foreach($arrayListaVereadores as $v){
			$jsonVereador = file_get_contents('./dadosJson/'.$v.'.json');
			$arrayVereador = json_decode($jsonVereador);
			$arrayVereadoresNome[] = $arrayVereador->vereador->nome;
			
			$viewLoader = knl_lib_ViewLoader::getInstance();
			$viewLoader->setVar('viewArray', $arrayVereador);
			
			$paginaBeanSnoopy->pagina = $arrayVereador->vereador->nome;
			$paginaBeanSnoopy->texto = $viewLoader->display('app/publisher', 'vereador',false);
			//$paginaAoSnoopy->publish($paginaBeanSnoopy);
		}
		$viewLoader->setVar('viewArray', $arrayVereadoresNome);
		$paginaBeanSnoopy->pagina = "Vereadores";
		$paginaBeanSnoopy->texto = $viewLoader->display('app/publisher', 'listavereador',false);
		$paginaAoSnoopy->publish($paginaBeanSnoopy);
	}
}
