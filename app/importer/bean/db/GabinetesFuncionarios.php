<?php
class app_importer_bean_db_GabinetesFuncionarios {
	public $id;
	public $id_gabinete;
	public $nome;
	public $cargo;
	
	public function getNome(){
		return (string) $this->nome;
	}
	
	public function getCargo(){
		return (string) $this->cargo;
	}
}
