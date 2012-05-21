<?php
class app_exporter_bean_db_Projetos {
	public $id;
	public $tipo_projeto;
	public $numero_projeto;
	public $data_projeto;
	public $ementa;
	public $tipo_norma;
	public $numero_norma;
	public $data_norma;
	public $ano_projeto;
	
	public function setDataProjeto($str){
		$str = app_importer_lib_FixDataToBr::fixData($str);
		$this->data_projeto = $str;
	}
	
	public function setDataNorma($str){
		$str = app_importer_lib_FixDataToBr::fixData($str);
		$this->data_norma = $str;
	}
	
	public function getDataProjeto(){
		$date = app_importer_lib_FixDataToUnix::fixData($this->data_projeto);
		return $date;
	}
	
	public function getDataNorma(){
		$date = app_importer_lib_FixDataToUnix::fixData($this->data_norma);
		return $date;
	}
}
