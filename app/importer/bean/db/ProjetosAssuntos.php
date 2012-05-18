<?php
class app_importer_bean_db_ProjetosAssuntos {
	public $id;
	public $id_projeto;
	public $assunto_descricao;
	
	public function getAssuntoDescricao(){
		return (string) $this->assunto_descricao;
	}
}
