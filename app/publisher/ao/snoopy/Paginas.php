<?php
class app_publisher_ao_snoopy_Paginas extends app_publisher_ao_snoopy_SnoopyParent{
	public function __construct(){
		parent::__construct();
	}
	
	public function publish(app_publisher_bean_snoopy_Paginas $objbean){
		$this->edit($objbean->pagina, $objbean->texto);
	}
}
