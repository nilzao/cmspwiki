<?php
class app_exporter_ao_db_Rankings{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}

	public function upsert(app_exporter_bean_db_Rankings $objbean){
		if ($objbean->id == 0){
			$arrayBind = array($objbean->id_vereador,
							$objbean->id_ranking_tipo,
							$objbean->posicao);
			$query = "INSERT INTO rankings
			(id_vereador,id_ranking_tipo,posicao)
			VALUES (?,?,?)";
			$stmt = $this->dataBase->conn->prepare($query);
			$stmt = $this->dataBase->conn->execute($stmt,$arrayBind);
			if (!$stmt){
				print_r($objbean);
				print $this->dataBase->conn->ErrorMsg();
			}
			$objbean->id=$this->dataBase->conn->Insert_ID();
		}
		else {
			$arrayBind = array($objbean->id_vereador,
								$objbean->id_ranking_tipo,
								$objbean->posicao,
								$objbean->id);
			$query = "UPDATE rankings SET
				id_vereador = ?,
				id_ranking_tipo = ?,
				posicao = ?
				WHERE id = ?";
			$stmt = $this->dataBase->conn->prepare($query);
			$stmt = $this->dataBase->conn->execute($stmt,$arrayBind);
		}
		return $objbean;
	}
	
	public function getByIdVereador($id,$tipo = 0){
		$objbean = new app_exporter_bean_db_Rankings();
		$arrayBind = array($id,$tipo);
		$query = "SELECT 
				id,
				id_vereador,
				id_ranking_tipo,
				posicao
				FROM rankings
				WHERE id_vereador = ?
				AND id_ranking_tipo = ?
				";
		$stmt = $this->dataBase->conn->execute($query,$arrayBind);
		if (!$stmt){
			var_dump($id);
			print $this->dataBase->conn->ErrorMsg();
		}
		
		else if ($l = $stmt->FetchRow()) {
			$objbean->id = $l['id'];
			$objbean->id_vereador = $l['id_vereador'];
			$objbean->id_ranking_tipo = $l['id_ranking_tipo'];
			$objbean->posicao = $l['posicao'];
		}
		return $objbean;
	}
		
	public function truncate(){
		$query = "TRUNCATE rankings";
		$stmt = $this->dataBase->conn->execute($query);
		if (!$stmt){
			print $this->dataBase->conn->ErrorMsg();
			return false;
		}
		return true;
	}
}
