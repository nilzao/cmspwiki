<?php
class app_importer_ao_db_Projetos{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}
	
	public function upsert(app_importer_bean_db_Projetos $objmodel){
		if ($objmodel->id == 0){
			$array = array($objmodel->tipo_projeto,
						   $objmodel->numero_projeto,
						   $objmodel->getDataProjeto(),
						   $objmodel->ementa,
						   $objmodel->tipo_norma,
						   $objmodel->numero_norma,
						   $objmodel->getDataNorma());
			$query = "INSERT INTO projetos
			(tipo_projeto,numero_projeto,data_projeto,ementa,tipo_norma,numero_norma,data_norma)
			VALUES (?,?,?,?,?,?,?)";
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
	
	public function getByTipoNumData(app_importer_bean_db_Projetos $objmodel){
		$array = array($objmodel->tipo_projeto,
					   $objmodel->numero_projeto,
					   $objmodel->getDataProjeto());
		$query = "SELECT 
			id,tipo_projeto,numero_projeto,data_projeto,
			ementa,tipo_norma,numero_norma,data_norma
		 	FROM projetos WHERE 
			tipo_projeto = ? 
			AND numero_projeto = ?
			AND data_projeto = ?";
		$stmt = $this->dataBase->conn->execute($query,$array);
		$objmodel->id = 0;
		if (!$stmt){
			var_dump($nome);
			print $this->dataBase->conn->ErrorMsg();
		}
		else if ($l = $stmt->FetchRow()) {
			$objmodel->id = $l['id'];
			$objmodel->tipo_projeto = $l['tipo_projeto'];
			$objmodel->numero_projeto = $l['numero_projeto'];
			$objmodel->setDataProjeto($l['data_projeto']);
			$objmodel->ementa = $l['ementa'];
			$objmodel->tipo_norma = $l['tipo_norma'];
			$objmodel->numero_norma = $l['numero_norma'];
			$objmodel->setDataNorma($l['data_norma']);
		}
		return $objmodel;
	}
	
	public function getByTipoNumAno(app_importer_bean_db_Projetos $objmodel,$ano){
		$array = array($objmodel->tipo_projeto,
				$objmodel->numero_projeto,
				$ano.'-01-01',
				$ano.'-12-31');
		$query = "SELECT
		id,tipo_projeto,numero_projeto,data_projeto,
		ementa,tipo_norma,numero_norma,data_norma
		FROM projetos WHERE
		tipo_projeto = ?
		AND numero_projeto = ?
		AND data_projeto BETWEEN ? AND ?";
		$stmt = $this->dataBase->conn->execute($query,$array);
		$objmodel->id = 0;
		if (!$stmt){
			var_dump($objmodel);
			print $this->dataBase->conn->ErrorMsg();
		}
		else if ($l = $stmt->FetchRow()) {
			$objmodel->id = $l['id'];
			$objmodel->tipo_projeto = $l['tipo_projeto'];
			$objmodel->numero_projeto = $l['numero_projeto'];
			$objmodel->setDataProjeto($l['data_projeto']);
			$objmodel->ementa = $l['ementa'];
			$objmodel->tipo_norma = $l['tipo_norma'];
			$objmodel->numero_norma = $l['numero_norma'];
			$objmodel->setDataNorma($l['data_norma']);
		}
		return $objmodel;
	}
	
	public function truncate(){
		$query = "TRUNCATE projetos";
		$stmt = $this->dataBase->conn->execute($query);
		if (!$stmt){
			print $this->dataBase->conn->ErrorMsg();
			return false;
		}
		return true;
	}
}
