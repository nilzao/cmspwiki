<?php
class app_importer_bean_db_GabinetesDespesasTipo {
	public $id;
	public $descricao;
	
	public function getDescricao(){
		return (string) $this->descricao;
	}
}
