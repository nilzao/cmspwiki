<?php
class app_importer_bean_db_VereadoresNomeFix {
	public $id;
	public $id_vereador;
	public $nome_errado;
	
	public function setNomeErrado($str){
		$str = app_importer_lib_FixVereadorNome::fixNome($str);
		$this->nome_errado = $str;
	}
}
