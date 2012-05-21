<?php
class app_exporter_bean_db_GabinetesDespesasResumo {
	public $descricao;
	public $total;
	
	public function setTotal($total){
		$this->total = number_format($total,2,',','.');
	}
}
