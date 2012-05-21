<?php
class app_exporter_ao_db_GabinetesDespesasResumo{
	private $dataBase;
	
	public function __construct() {
		$dataBase = app_importer_lib_DataBase::getInstance();
		$this->dataBase = $dataBase;
	}
	
	public function getByListId($arrayListId){
		$lista = array();
		$strBind = array_fill_keys($arrayListId, '?');
		$strBind = implode(',', $strBind);
		$query = "SELECT 
				gabinetes_despesas_tipo.descricao,
				SUM(gabinetes_despesas.valor) AS total
				FROM gabinetes_despesas
				LEFT JOIN gabinetes_despesas_tipo 
				    ON (gabinetes_despesas_tipo.id = 
				        gabinetes_despesas.id_gabinete_despesa_tipo)
				WHERE gabinetes_despesas.id_vereador IN (".$strBind.")
				AND gabinetes_despesas.ano BETWEEN 2009 AND 2012
				GROUP BY gabinetes_despesas.id_gabinete_despesa_tipo
				ORDER BY gabinetes_despesas_tipo.descricao
				";
		$stmt = $this->dataBase->conn->execute($query,$arrayListId);
		
		if (!$stmt){
			var_dump($num);
			print $this->dataBase->conn->ErrorMsg();
		}
		else {
			$totalTmp = 0;
			while ($l = $stmt->FetchRow()) {
				$totalTmp += $l['total'];
				$objbean = new app_exporter_bean_db_GabinetesDespesasResumo();
				$objbean->descricao = $l['descricao'];
				$objbean->setTotal($l['total']);
				$lista[] = $objbean;
			}
			$objbean = new app_exporter_bean_db_GabinetesDespesasResumo();
			$objbean->descricao = 'Total';
			$objbean->setTotal($totalTmp);
			$lista[] = $objbean;
		}
		return $lista;
	}
}
