<?php
class app_importer_ao_db_ProjetosAssuntos{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}
	
	public function upsert(app_importer_bean_db_ProjetosAssuntos $objmodel){
		if ($objmodel->id == 0){
			$array = array($objmodel->id_projeto,
						   $objmodel->getAssuntoDescricao());
			$query = "INSERT INTO projetos_assuntos
			(id_projeto,assunto_descricao)
			VALUES (?,?)";
			$stmt = $this->dataBase->conn->prepare($query);
			$stmt = $this->dataBase->conn->execute($stmt,$array);
			if (!$stmt){
				print_r($objmodel);
				print $this->dataBase->conn->ErrorMsg();
			}
			$objmodel->id=$this->dataBase->conn->Insert_ID();
		}
		return $objmodel;
	}
	
	public function truncate(){
		$query = "TRUNCATE projetos_assuntos";
		$stmt = $this->dataBase->conn->execute($query);
		if (!$stmt){
			print $this->dataBase->conn->ErrorMsg();
			return false;
		}
		return true;
	}
}
