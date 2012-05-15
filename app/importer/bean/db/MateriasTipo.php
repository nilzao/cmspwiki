<?php
class app_importer_bean_db_MateriasTipo {
	public $id;
	public $codigo;
	public $abreviacao;
	public $descricao;
	
	public function getAbreviacao(){
		return (string) $this->abreviacao;
	}
	
	public function getDescricao(){
		return (string) $this->descricao;
	}
}
