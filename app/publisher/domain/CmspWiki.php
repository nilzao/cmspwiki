<?php
class app_publisher_domain_CmspWiki {
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
		echo "publish CmspWiki\n";
		$this->publish();
		echo "\nfim\n";
	}
	
	private function publish(){
		$paginaAoSnoopy = new app_publisher_ao_snoopy_Paginas();
		$paginaBeanSnoopy = new app_publisher_bean_snoopy_Paginas();
		$viewLoader = knl_lib_ViewLoader::getInstance();
		$paginaBeanSnoopy->pagina = "CMSPWiki";
		$paginaBeanSnoopy->texto = $viewLoader->display('app/publisher', 'cmspwiki',false);
		$paginaAoSnoopy->publish($paginaBeanSnoopy);
	}
}
