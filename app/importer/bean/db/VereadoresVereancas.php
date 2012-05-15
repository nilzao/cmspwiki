<?php
class app_importer_bean_db_VereadoresVereancas {
	public $id;
	public $id_vereador;
	public $id_vereador_anterior;
	public $data_ini;
	public $data_fim;
	public $situacao;
	public $partido;
	public $partido_obs;
	public $obs;
	
	public function getData_ini(){
		$date = app_importer_lib_FixDataToUnix::fixData($this->data_ini);
		return $date;
	}
	
	public function getData_fim(){
		$date = app_importer_lib_FixDataToUnix::fixData($this->data_fim);
		return $date;
	}
}
