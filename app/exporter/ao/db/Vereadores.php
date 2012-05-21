<?php
class app_exporter_ao_db_Vereadores{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}

	public function getById($id){
		$objbean = new app_exporter_bean_db_Vereadores();
		$query = "SELECT 
				id,id_out,nome
				FROM vereadores 
				WHERE id = ?
				";
		$stmt = $this->dataBase->conn->execute($query,$id);
		if (!$stmt){
			var_dump($id);
			print $this->dataBase->conn->ErrorMsg();
		}
		
		else if ($l = $stmt->FetchRow()) {
			$objbean->id = $l['id'];
			$objbean->id_out = $l['id_out'];
			$objbean->nome = $l['nome'];
		}
		return $objbean;
	}
}
