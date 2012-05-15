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
	
	public function getByNomeFix($nome){
		$nome = app_importer_lib_FixVereadorNome::fixNome($nome);
		$query = "SELECT vereadores.id,vereadores.nome,vereadores.id_out from vereadores
			LEFT JOIN vereadores_nome_fix ON(vereadores.id=vereadores_nome_fix.id_vereador)
			WHERE vereadores_nome_fix.nome_errado = ?";
		$stmt = $this->dataBase->conn->execute($query,$nome);
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorBeanDb->id = 0;
		if (!$stmt){
			var_dump($nome);
			print $this->dataBase->conn->ErrorMsg();
		}
		else if ($l = $stmt->FetchRow()) {
			$vereadorBeanDb->id = $l['id'];
			$vereadorBeanDb->id_out = $l['id_out'];
			$vereadorBeanDb->nome = $l['nome'];
		}
		return $vereadorBeanDb;
	}
}
