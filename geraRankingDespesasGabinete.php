<pre>
<?php
require_once('connect.php');
mysql_query("TRUNCATE ranking_gastos");
$query = "SELECT * FROM parlamentar order by nome asc";
$rsVereadores = mysql_query($query);
while ($vereador = mysql_fetch_object($rsVereadores)){
	$query = "SELECT despesatipo.descricao,SUM(despesa.valor) as totalgasto FROM despesa
		LEFT JOIN despesatipo ON (despesa.despesatipo_id = despesatipo.id)
		WHERE parlamentar_id = ".$vereador->id."
		GROUP BY despesatipo_id
		ORDER BY despesatipo.descricao";
	$rsDespesas = mysql_query($query);
	$totalDespesas = 0;
	while ($despesas = mysql_fetch_object($rsDespesas)){
		$totalDespesas = $totalDespesas  + $despesas->totalgasto;
	}
	$query = "INSERT INTO ranking_gastos
	(id_parlamentar,valor)
	VALUES
	(".$vereador->id.",".$totalDespesas.")";
	mysql_query($query);
	//echo $vereador->id." - ".$totalDespesas."\n\n";
	
}
$query = "SELECT * FROM ranking_gastos order by valor desc";
$rsGastos = mysql_query($query);
$posicao = 1;
while($gasto = mysql_fetch_object($rsGastos)){
	$query = "UPDATE ranking_gastos SET ranking = ".$posicao++."
	WHERE id = ".$gasto->id;
	mysql_query($query);
}
?>
</pre>