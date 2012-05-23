<?php
class app_exporter_ao_db_VereadoresNomeParlamentar{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}

	public function getByIdVereador($id){
		$id=(int) $id;
		$id = (empty($id)) ? -1 : $id;
		$lista = array();
		$query = "SELECT
			id_vereador,
			nome_parlamentar
			FROM vereadores_nome_parlamentar
			WHERE id_vereador = ?
			";
		$stmt = $this->dataBase->conn->execute($query,$id);
		if (!$stmt){
			var_dump($id);
			print $this->dataBase->conn->ErrorMsg();
		}
		else {
			while ($l = $stmt->FetchRow()) {
				$objbean = new app_exporter_bean_db_VereadoresNomeParlamentar();
				$objbean->nome_parlamentar = $l['nome_parlamentar'];
				$objbean->id_vereador = $l['id_vereador'];
				$lista[] = $objbean;
			}
		}
		return $lista;
	}
}
