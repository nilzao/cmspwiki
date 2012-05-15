<?php
class app_importer_ao_db_Gabinetes{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}

	public function upsert(app_importer_bean_db_Gabinetes $objmodel){
		if ($objmodel->id == 0){
			$array = array($objmodel->id_vereador,
						   $objmodel->num_gabinete,
						   $objmodel->ramal,
						   $objmodel->fax,
						   $objmodel->sala);
			$query = "INSERT INTO gabinetes
			(id_vereador,num_gabinete,ramal,fax,sala)
			VALUES (?,?,?,?,?)";
			$stmt = $this->dataBase->conn->prepare($query);
			$stmt = $this->dataBase->conn->execute($stmt,$array);
			if (!$stmt){
				print_r($objmodel);
				print $this->dataBase->conn->ErrorMsg();
			}
			$objmodel->id=$this->dataBase->conn->Insert_ID();
		}
		/* else {
			$query = "UPDATE carimbo_cred SET
			id_carimbo='{$objmodel->get_id_carimbo()}',id_knl_usuario='{$objmodel->get_id_knl_usuario()}',id_knl_grupo='{$objmodel->get_id_knl_grupo()}',perm_usuario='{$objmodel->get_perm_usuario()}',perm_grupo='{$objmodel->get_perm_grupo()}',perm_outros='{$objmodel->get_perm_outros()}'
			WHERE id = ?";
			$stmt = $this->conn->prepare($query);
			$stmt = $this->conn->execute($stmt,$objmodel->get_id());
		}*/
		return $objmodel;
	}
	
	public function getByNumGab($num){
		$query = "SELECT id,id_vereador,num_gabinete,ramal,fax,sala
				FROM gabinetes
				WHERE num_gabinete = ?";
		$stmt = $this->dataBase->conn->execute($query,$num);
		$gabineteBeanDb = new app_importer_bean_db_Gabinetes();
		if (!$stmt){
			var_dump($num);
			print $this->dataBase->conn->ErrorMsg();
		}
		else if($l = $stmt->FetchRow()) {
			$gabineteBeanDb->id = $l['id'];
			$gabineteBeanDb->id_vereador = $l['id_vereador'];
			$gabineteBeanDb->num_gabinete = $l['num_gabinete'];
			$gabineteBeanDb->ramal = $l['ramal'];
			$gabineteBeanDb->fax = $l['fax'];
			$gabineteBeanDb->sala = $l['sala'];
		}
		return $gabineteBeanDb;
	}
}
