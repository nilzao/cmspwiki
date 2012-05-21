<?php
class app_exporter_ao_db_Projetos{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}
	
	public function getByIdVereador($id){
		$lista = array();
		$query = "SELECT 
				projetos.id,
				projetos.tipo_projeto,
				projetos.numero_projeto,
				projetos.data_projeto,
				projetos.ementa,
				projetos.tipo_norma,
				projetos.numero_norma,
				projetos.data_norma,
				YEAR(projetos.data_projeto) as ano_projeto
				 FROM projetos
				LEFT JOIN projetos_autores 
				    ON (projetos_autores.id_projeto = projetos.id)
				WHERE projetos_autores.id_vereador = ?
				ORDER BY projetos.tipo_projeto,ano_projeto,projetos.numero_projeto
				";
		$stmt = $this->dataBase->conn->execute($query,$id);
		if (!$stmt){
			var_dump($id);
			print $this->dataBase->conn->ErrorMsg();
		}
		else {
			while ($l = $stmt->FetchRow()) {
				$objbean = new app_exporter_bean_db_Projetos();
				$objbean->id = $l['id'];
				$objbean->tipo_projeto = $l['tipo_projeto'];
				$objbean->numero_projeto = $l['numero_projeto'];
				$objbean->setDataProjeto($l['data_projeto']);
				$objbean->ementa = $l['ementa'];
				$objbean->tipo_norma = $l['tipo_norma'];
				$objbean->numero_norma = $l['numero_norma'];
				$objbean->setDataNorma($l['data_norma']);
				$objbean->ano_projeto = $l['ano_projeto'];
				$lista[] = $objbean;
			}
		}
		return $lista;
	}
}
