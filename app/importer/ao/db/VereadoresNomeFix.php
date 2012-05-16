<?php
class app_importer_ao_db_VereadoresNomeFix{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
		
	}
	
	public function upsert(app_importer_bean_db_VereadoresNomeFix $objmodel){
		if ($objmodel->id == 0){
			$array = array($objmodel->id_vereador,$objmodel->nome_errado);
			$query = "INSERT INTO vereadores_nome_fix
			(id_vereador,nome_errado)
			VALUES (?,?)";
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
	
	public function truncate(){
		$query = "TRUNCATE vereadores_nome_fix";
		$stmt = $this->dataBase->conn->execute($query);
		if (!$stmt){
			print $this->dataBase->conn->ErrorMsg();
			return false;
		}
		return true;
	}
	
}
