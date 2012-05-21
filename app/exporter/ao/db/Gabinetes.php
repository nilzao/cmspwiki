<?php
class app_exporter_ao_db_Gabinetes{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}
	
	public function getAll(){
		$lista = array();
		$query = "SELECT 
				gabinetes.id,
				gabinetes.id_vereador,
				gabinetes.num_gabinete,
				gabinetes.ramal,
				gabinetes.fax,
				gabinetes.sala
				FROM gabinetes
				LEFT JOIN vereadores ON ( vereadores.id = gabinetes.id_vereador ) 
				ORDER BY vereadores.nome";
		$stmt = $this->dataBase->conn->execute($query);
		
		if (!$stmt){
			var_dump($num);
			print $this->dataBase->conn->ErrorMsg();
		}
		else {
			while ($l = $stmt->FetchRow()) {
				$objbean = new app_exporter_bean_db_Gabinetes();
				$objbean->id = $l['id'];
				$objbean->id_vereador = $l['id_vereador'];
				$objbean->num_gabinete = $l['num_gabinete'];
				$objbean->ramal = $l['ramal'];
				$objbean->telefone = '(11) 3396-4000';
				$objbean->fax = $l['fax'];
				$objbean->sala = $l['sala'];
				$lista[] = $objbean;
			}
		}
		return $lista;
	}
}
