<?php
class app_importer_ao_db_GabinetesDespesasEmpresas{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}

	public function upsert(app_importer_bean_db_GabinetesDespesasEmpresas $objmodel){
		if ($objmodel->id == 0){
			$array = array($objmodel->getCnpj(),$objmodel->getRazaoSocial());
			$query = "INSERT INTO gabinetes_despesas_empresas
			(cnpj,razao_social)
			VALUES (?,?)";
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
	
	public function getByCnpj($str){
		$str = (string) $str;
		if (empty($str)){
			$str = "00000000000000";
		}
		$query = "SELECT id,cnpj,razao_social FROM gabinetes_despesas_empresas
				WHERE cnpj = ?";
		$stmt = $this->dataBase->conn->execute($query,$str);
		$gabineteDespesaEmpresaBeanDb = new app_importer_bean_db_GabinetesDespesasEmpresas();
		$gabineteDespesaEmpresaBeanDb->id = 0;
		if (!$stmt){
			echo "erro getByCnpj\n";
			var_dump($str);
			print $this->dataBase->conn->ErrorMsg();
		}
		else if ($l = $stmt->FetchRow()){
			$gabineteDespesaEmpresaBeanDb->id = $l['id'];
			$gabineteDespesaEmpresaBeanDb->cnpj = $l['cnpj'];
			$gabineteDespesaEmpresaBeanDb->razao_social = $l['razao_social'];
		}
		return $gabineteDespesaEmpresaBeanDb;
	}
	
	public function truncate(){
		$query = "TRUNCATE gabinetes_despesas_empresas";
		$stmt = $this->dataBase->conn->execute($query);
		if (!$stmt){
			print $this->dataBase->conn->ErrorMsg();
			return false;
		}
		return true;
	}
}
