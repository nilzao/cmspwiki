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
		$paginaAoSnoopy = new app_publisher_ao_snoopy_Paginas();
		$paginaBeanSnoopy = new app_publisher_bean_snoopy_Paginas();
		$paginaBeanSnoopy->pagina = "zzz";
		$paginaBeanSnoopy->texto = "wiki full!";
		
		$paginaAoSnoopy->publish($paginaBeanSnoopy);
	}
}
