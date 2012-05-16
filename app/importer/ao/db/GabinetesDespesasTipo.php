<?php
class app_importer_ao_db_GabinetesDespesasTipo{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}

	public function upsert(app_importer_bean_db_GabinetesDespesasTipo $objmodel){
		if ($objmodel->id == 0){
			$array = array($objmodel->getDescricao());
			$query = "INSERT INTO gabinetes_despesas_tipo
			(descricao)
			VALUES (?)";
			$stmt = $this->dataBase->conn->prepare($query);
			$stmt = $this->dataBase->conn->execute($stmt,$array);
			if (!$stmt){
				echo "erro upsert\n";
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
	
	public function getByDescricao($str){
		$query = "SELECT id,descricao FROM gabinetes_despesas_tipo
				WHERE descricao = ?";
		$stmt = $this->dataBase->conn->execute($query,$str);
		$gabineteDespesaTipoBeanDb = new app_importer_bean_db_GabinetesDespesasTipo();
		$gabineteDespesaTipoBeanDb->id = 0;
		$gabineteDespesaTipoBeanDb->descricao = $str;
		if (!$stmt){
			echo "erro getByDescricao\n";
			var_dump($str);
			print $this->dataBase->conn->ErrorMsg();
		}
		else if ($l = $stmt->FetchRow()){
			$gabineteDespesaTipoBeanDb->id = $l['id'];
			$gabineteDespesaTipoBeanDb->descricao = $l['descricao'];
		}
		return $gabineteDespesaTipoBeanDb;
	}
	
	public function truncate(){
		$query = "TRUNCATE gabinetes_despesas_tipo";
		$stmt = $this->dataBase->conn->execute($query);
		if (!$stmt){
			print $this->dataBase->conn->ErrorMsg();
			return false;
		}
		return true;
	}
}
