<?php
class app_importer_bean_db_GabinetesDespesasEmpresas {
	public $id;
	public $cnpj;
	public $razao_social;
	
	public function getCnpj(){
		$cnpj = (string) $this->cnpj;
		$cnpj  = preg_replace ( '/[^0-9]/', '', $cnpj);
		if (empty($cnpj)){
			$this->cnpj = "00000000000000";
			$this->razao_social = "SEM CNPJ";
			$cnpj = "00000000000000";
		}
		return $cnpj;
	}
	
	public function getRazaoSocial(){
		return (string) $this->razao_social;
	}
}
