<?php
class app_importer_bean_db_GabinetesDespesas {
	public $id;
	public $id_vereador;
	public $id_gabinete_despesa_tipo;
	public $id_gabinete_despesa_empresa;
	public $ano;
	public $mes;
	public $valor;
	
	public function getValor(){
		$valor = (string) $this->valor;
		$valor = str_replace(',', '.', $valor);
		//$valor = number_format($valor,2);
		return (float) $valor;
	}
}
