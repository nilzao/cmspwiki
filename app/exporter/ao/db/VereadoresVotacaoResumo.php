<?php
class app_exporter_ao_db_VereadoresVotacaoResumo{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}

	public function getByIdVereador($id){
		$lista = array();
		$query = "SELECT 
				votacoes_tipo.descricao_fix,
				SUM(1) AS total
				FROM  `vereadores` 
				LEFT JOIN vereadores_votacoes ON ( vereadores_votacoes.id_vereador = vereadores.id ) 
				LEFT JOIN projetos ON ( projetos.id = vereadores_votacoes.id_projeto ) 
				LEFT JOIN votacoes_tipo ON ( votacoes_tipo.id = vereadores_votacoes.id_votacao_tipo ) 
				WHERE vereadores.id = ?
				GROUP BY votacoes_tipo.id
				ORDER BY total DESC
				";
		$stmt = $this->dataBase->conn->execute($query,$id);
		if (!$stmt){
			var_dump($id);
			print $this->dataBase->conn->ErrorMsg();
		}
		else {
			while ($l = $stmt->FetchRow()) {
				$objbean = new app_exporter_bean_db_VereadoresVotacaoResumo();
				$objbean->tipo_voto = strtolower($l['descricao_fix']);
				$objbean->total = $l['total'];
				$lista[] = $objbean; 
			}
		}
		return $lista;
	}
}
