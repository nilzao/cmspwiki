<?php
class app_exporter_bean_db_VereadoresVereancas {
	public $id;
	public $id_vereador;
	public $id_vereador_anterior;
	public $nome_vereador_anterior;
	public $data_ini;
	public $data_fim;
	public $situacao;
	public $partido;
	public $partido_obs;
	public $obs;
	
	public function setDataIni($date){
		$this->data_ini = app_importer_lib_FixDataToBr::fixData($date);
	}
	
	public function setDatafim($date){
		$this->data_fim = app_importer_lib_FixDataToBr::fixData($date);
	}
}
