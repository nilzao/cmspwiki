<?php
class app_importer_bean_db_Projetos {
	public $id;
	public $tipo_projeto;
	public $numero_projeto;
	public $data_projeto;
	public $ementa;
	public $tipo_norma;
	public $numero_norma;
	public $data_norma;
	
	public function getDataProjeto(){
		$date = app_importer_lib_FixDataToUnix::fixData($this->data_projeto);
		return $date;
	}
	
	public function getDataNorma(){
		$date = app_importer_lib_FixDataToUnix::fixData($this->data_norma);
		return $date;
	}
}
