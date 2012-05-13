<?php header( 'Content-type: text/html; charset=utf-8' );?>
<pre>
<?php
require_once('connect.php');
require_once('removeAcentos.php');

$query = "SELECT * FROM parlamentar order by nome asc";
$rsVereadores = mysql_query($query);
$wikiStr = '';
while ($vereador = mysql_fetch_object($rsVereadores)){
	$vereadorNomeFile = str_replace(' ', '_', $vereador->nome);
	$vereadorNomeFile = strtolower($vereadorNomeFile);
	$vereadorNomeFile = ucfirst($vereadorNomeFile);
	$vereadorNomeFile = removeAcentos($vereadorNomeFile);
	$wikiStr .= '[[Arquivo:'.$vereadorNomeFile.'.jpg|'.$vereador->nome.']]'."\n";
	$wikiStr .= '== Mandatos ==
===2009-2012 CMSP===
'.$vereador->nome.', cumpre o mandato de vereador da [[Câmara Municipal de São Paulo]] no período de 1º de janeiro de 2009 a 31 de dezembro de 2012. Filiado ao [['.$vereador->partido.']].
===== Orçamentos para o gabinete =====';
	$wikiStr .="
======Resumo dos [[gastos de gabinete]] no mandato entre 01/2009 a 02/2012 ======
{| border=1
|-
|  '''Tipo de despesa''' || '''Valor'''
";
	$query = "SELECT despesatipo.descricao,SUM(despesa.valor) as totalgasto FROM despesa
	LEFT JOIN despesatipo ON (despesa.despesatipo_id = despesatipo.id)
	WHERE parlamentar_id = ".$vereador->id."
	GROUP BY despesatipo_id
	ORDER BY despesatipo.descricao";
	$rsDespesas = mysql_query($query);
	$totalDespesas = 0;
	while ($despesas = mysql_fetch_object($rsDespesas)){
		$despesasMoeda = number_format($despesas->totalgasto,2,',','.');
		$wikiStr .="|-
| ".$despesas->descricao."|| R$ ".$despesasMoeda."
";
		$totalDespesas = $totalDespesas  + $despesas->totalgasto;
	}
	$wikiStr .="|-
| '''Total''' || '''R$ ".number_format($totalDespesas,2,',','.')."'''
|}";
	
	$query = "SELECT ranking FROM ranking_gastos WHERE id_parlamentar = ".$vereador->id;
	$rsRank = mysql_query($query);
	$rank = mysql_fetch_object($rsRank);
	
	$wikiStr .= "
O vereador '''".$vereador->nome."''', é o '''".$rank->ranking."º''' colocado entre os [[vereadores|55 vereadores]] no [[ranking de gastos com gabinete]].";
			
	$wikiStr .="
======Relação de funcionários ligados ao gabinete do vereador======
{| border=1
|-
| '''Nome''' || '''Cargo'''";

	$query = "SELECT funcionario.nome,funcionario.cargo FROM funcionario
	LEFT JOIN gabinete ON (gabinete.num_ordem = funcionario.gabinete)
	WHERE gabinete.id_parlamentar = ".$vereador->id."
	ORDER BY funcionario.nome";
	$rsFuncionarios = mysql_query($query);
	while($funcionario = mysql_fetch_object($rsFuncionarios)){
		$wikiStr .= "
|- 
| ".$funcionario->nome." || ".$funcionario->cargo;
	}
	$wikiStr .= '
|}';

	$wikiStr .= "
====Sessões Plenárias====

===== Índice de presença em sessões plenárias e extraordinárias =====
O vereador '''".$vereador->nome."''' compareceu em '''[[sessões ordinárias presentes|x%]]''' das [[sessões ordinárias]] desde início do mandato. E em '''[[sessões extraordinárias presentes|x%]]''' das [[sessões extraordinárias]]. Com um total de '''[[sessões totais|x%]]''' de presença nas [[sessões]]. '''X%''' das [[sessões que faltou|faltas]] foram [[sessões justificadas|justificadas]].

O vereador '''".$vereador->nome."''' é o '''X''' colocado entre os [[vereadores|55 vereadores]] no [[ranking de presença]] nas [[sessões]].

=====Votações=====
[[Matérias votadas pelo vereador '''".$vereador->nome."''']]

[[votados sim|X% sim]], [[votados não|X%não]], [[abstendidos|X%abstenção]], [[não votados|X%obstruções]]
====Matérias propostas====
=====Matéra tipo 1=====
=====Matéra tipo 2=====
=====Matéra tipo 3=====
====Nota====
O conteúdo deste mandato foi gerado pela ferramenta [[CMSPWiki]], com base nos dados disponibilizados pela [[Câmara Municipal de São Paulo]], durante o 1° Hackathon - Desafio de dados abertos da Maratona Hacker da Câmara Municipal de São Paulo.
	
";

	$wikiStr .= "\n\n\n\n\n<hr/>\n\n\n\n";
}

echo $wikiStr;

mysql_close($conn);
?>

</pre>