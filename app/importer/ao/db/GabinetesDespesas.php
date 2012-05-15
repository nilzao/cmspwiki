<?php
class app_importer_ao_db_GabinetesDespesas{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
		
	}
	
	public function upsert(app_importer_bean_db_GabinetesDespesas $objmodel){
		if ($objmodel->id == 0){
			$array = array($objmodel->id_vereador,
						   $objmodel->id_gabinete_despesa_tipo,
						   $objmodel->id_gabinete_despesa_empresa,
						   $objmodel->mes,
						   $objmodel->ano,
						   $objmodel->getValor());
			$query = "INSERT INTO gabinetes_despesas
			(id_vereador,id_gabinete_despesa_tipo,id_gabinete_despesa_empresa,mes,ano,valor)
			VALUES (?,?,?,?,?,?)";
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
}
