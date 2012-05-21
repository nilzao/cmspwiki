<?php
class app_exporter_ao_db_GabinetesFuncionarios{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
		
	}
	
	public function getByIdGab($id){
		$lista = array();
		$query = "SELECT 
				gabinetes_funcionarios.id,
				gabinetes_funcionarios.id_gabinete,
				gabinetes_funcionarios.nome,
				gabinetes_funcionarios.cargo
				FROM gabinetes_funcionarios
				LEFT JOIN gabinetes 
				    ON (gabinetes.id = gabinetes_funcionarios.id_gabinete)
				WHERE gabinetes.id = ?
				";
		$stmt = $this->dataBase->conn->execute($query,$id);
		if (!$stmt){
			var_dump($id);
			print $this->dataBase->conn->ErrorMsg();
		}
		else {
			while ($l = $stmt->FetchRow()) {
				$objbean = new app_exporter_bean_db_GabinetesFuncionarios();
				$objbean->id = $l['id'];
				$objbean->id_gabinete = $l['id_gabinete'];
				$objbean->nome = ucwords(mb_strtolower($l['nome'],'UTF-8'));
				$objbean->cargo = ucfirst(mb_strtolower($l['cargo'],'UTF-8'));
				$lista[] = $objbean;
			}
		}
		return $lista;
	}
}
