<?php
class app_importer_ao_db_VotacoesTipo{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
		
	}
	
	public function upsert(app_importer_bean_db_VotacoesTipo $objmodel){
		if ($objmodel->id == 0){
			$array = array($objmodel->descricao,
						   $objmodel->descricao_fix);
			$query = "INSERT INTO votacoes_tipo
			(descricao,descricao_fix)
			VALUES (?,?)";
			$stmt = $this->dataBase->conn->prepare($query);
			$stmt = $this->dataBase->conn->execute($stmt,$array);
			if (!$stmt){
				print_r($objmodel);
				print $this->dataBase->conn->ErrorMsg();
			}
			$objmodel->id = $this->dataBase->conn->Insert_ID();
		}
		return $objmodel;
	}
	
	public function getByDescricaoFix($nome){
		$nome = app_importer_lib_FixVereadorNome::fixNome($nome);
		$query = "SELECT id,descricao,descricao_fix
				  FROM votacoes_tipo
				  WHERE descricao_fix = ?";
		$stmt = $this->dataBase->conn->execute($query,$nome);
		$objmodel = new app_importer_bean_db_VotacoesTipo();
		$objmodel->id = 0;
		if (!$stmt){
			var_dump($nome);
			print $this->dataBase->conn->ErrorMsg();
		}
		else if ($l = $stmt->FetchRow()) {
			$objmodel->id = $l['id'];
			$objmodel->descricao = $l['descricao'];
			$objmodel->descricao_fix = $l['descricao_fix'];
		}
		return $objmodel;
	}
	
	public function truncate(){
		$query = "TRUNCATE votacoes_tipo";
		$stmt = $this->dataBase->conn->execute($query);
		if (!$stmt){
			print $this->dataBase->conn->ErrorMsg();
			return false;
		}
		$this->fill();
		return true;
	}
	
	public function fill(){
		$objmodel = new app_importer_bean_db_VotacoesTipo();
		$objmodel->id = 0;
		$objmodel->descricao = 'Sim';
		$objmodel->descricao_fix = 'SIM';
		$this->upsert($objmodel);

		$objmodel->id = 0;
		$objmodel->descricao = 'Não';
		$objmodel->descricao_fix = 'NAO';
		$this->upsert($objmodel);
		
		$objmodel->id = 0;
		$objmodel->descricao = 'Obstrução';
		$objmodel->descricao_fix = 'NAO_VOTOU';
		$this->upsert($objmodel);
		
		$objmodel->id = 0;
		$objmodel->descricao = 'Abstenção';
		$objmodel->descricao_fix = 'ABSTENCAO';
		$this->upsert($objmodel);
	}
}
