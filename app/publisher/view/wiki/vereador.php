<?php
$viewArray = $viewLoader->getVar('viewArray');
$nomeVereador = $viewArray->vereador->nome;
$nomeVereadorFix = app_importer_lib_FixVereadorNome::fixNome($nomeVereador);
$nomeVereadorFix = strtolower($nomeVereadorFix);
$nomeVereadorFix = ucfirst($nomeVereadorFix);
	
$vereancas = $viewArray->vereancas[0];
$situacao = $vereancas->situacao;
$partido = $vereancas->partido;

$gabinete = $viewArray->gabinete;
$gabNum = $gabinete->num_gabinete;
$gabTel = $gabinete->telefone;
$gabRamal = $gabinete->ramal;
$gabFax = $gabinete->fax;
$gabSala = $gabinete->sala;
?>
<div style="float: right;">
{| align=right style="margin-left: 15px; text-align: center; border:1px solid #ADA268; padding:1px; font-size: 90%; width: 190px;background-color:white" class="box noprint"
|-
|<div style="text-align:center;padding:0px; background-color:#ADA268;font-size:14px;">'''[[<?php echo $nomeVereador; ?>]]'''</div>
<div style="margin: 2px 0px;">[[Arquivo:<?php echo $nomeVereadorFix; ?>.jpg|190px]]</div>
<div style="background-color:#E0DABF;">

<div class="NavFrame" style="border:1px;background-color:#ADA268;padding: 0px;">
<div style="background-color:#ADA268;border:1px solid #ADA268;padding: 0px 0px 0px 4px; font-size: 105%; text-align:left;margin:1px;">'''<font color="white"><?php echo $situacao;?></font>'''</div></div>

<div class="NavFrame" style="border:0px;background-color:#E0DABF;padding: 1px;">
<div class="NavHead" style="border:0px solid #FFF5EE;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE"><b>Partido: [[<?php echo $partido; ?>]]</b></div>
</div>

<div class="NavFrame" style="border:0px;background-color:#E0DABF;padding: 1px;">
<div class="NavHead" style="border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:0px;color:black;background-color:#FFF5EE"><b>[[<?php echo $gabNum; ?>° gabinete]] - Sala: <?php echo $gabSala;?></b></div>
<div class="NavContent" style="display:none;text-align:left;margin:0px 1px;border:none;text-wight:bold; ">
</div></div>

<div class="NavFrame" style="border:0px;background-color:#E0DABF;padding: 1px;">
<div class="NavHead" style="border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE"><b>telefone: <?php echo $gabTel; ?> ramal: <?php echo $gabRamal; ?></b></div>
<div class="NavContent" style="display:none;text-align:left;margin:0px 1px;border:none;text-wight:bold; ">
</div></div>

<div class="NavFrame" style="border:0px;background-color:#E0DABF;padding: 1px;">
<div class="NavHead" style="border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE"><b>fax: <?php echo $gabFax; ?></b></div>
<div class="NavContent" style="display:none;text-align:left;margin:0px 1px;border:none;text-wight:bold; ">
</div></div>

</div>
|}
</div>
<?php if (count($viewArray->nomes_parlamentar)): ?>
== Nomes Parlamentares ==
<?php foreach($viewArray->nomes_parlamentar as $nomeParlamentar): ?>
<?php echo $nomeParlamentar->nome_parlamentar;?>


<?php endforeach; ?>
<?php endif; ?>

== Mandatos ==
=== 01/01/2009 a 31/12/2012 CMSP===
==== Vereanças ====
<?php foreach($viewArray->vereancas as $vereanca): ?>
Período: <?php echo $vereanca->data_ini; ?> - <?php echo $vereanca->data_fim; ?>


Situação: <?php echo $vereanca->situacao; ?>


Partido: <?php echo $vereanca->partido; ?>


<?php if (!empty($vereanca->nome_vereador_anterior)): ?>
Vereador anterior: <?php echo $vereanca->nome_vereador_anterior; ?>


<?php endif; ?>
<?php echo $vereanca->partido_obs; ?>


<?php echo $vereanca->obs; ?>


<?php endforeach; ?>
==== Orçamentos para o gabinete ====
<?php echo $nomeVereador; ?> é o atual reponsável pelo <?php echo $gabNum; ?>º gabinete da [[Câmara Municipal de São Paulo]].
=====Resumo dos gastos do <?php echo $situacao; ?> =====
Valores de Janeiro de 2009 até Fevereiro de 2012
<?php 
$arrayTitulo = array("'''Tipo de despesa'''"=>"","'''Valor'''"=>"align=\"right\" | R$ "); 
$arrayNomes = array("descricao","total");
$tabela = new app_publisher_view_wiki_hlp_Tabela($arrayTitulo, $viewArray->despesas,$arrayNomes);
echo $tabela->getWikiStr();
?>
=====Relação de funcionários ligados ao <?php echo $gabNum; ?>º gabinete=====
<?php 
$arrayTitulo = array("'''Nome'''"=>"","'''Cargo'''"=>"");
$arrayNomes = array("nome","cargo");
$tabela = new app_publisher_view_wiki_hlp_Tabela($arrayTitulo, $viewArray->funcionarios,$arrayNomes);
echo $tabela->getWikiStr();
?>
====Votações====

Total de votações nominais em matérias pelo <?php echo $situacao; ?> '''<?php echo $nomeVereador; ?>'''
<?php 
$arrayTitulo = array("'''Tipo de voto'''"=>"","'''Quantidade'''"=>" align=\"right\" | ");
$arrayNomes = array("tipo_voto","total");
$tabela = new app_publisher_view_wiki_hlp_Tabela($arrayTitulo, $viewArray->resumo_votos,$arrayNomes);
echo $tabela->getWikiStr();
?>
==Matérias propostas==

<?php 
foreach($viewArray->materias as $materia){
	echo "[[".$materia->tipo_projeto."-".
	$materia->numero_projeto."/".
	$materia->ano_projeto."]] -> ".$materia->ementa."\n\n";
}
?>
==Nota==
Este conteúdo foi gerado pela ferramenta [[CMSPWiki]], com base nos dados disponibilizados 
pela [[Câmara Municipal de São Paulo]], durante o 1° Hackathon - Desafio de dados abertos 
da Maratona Hacker da Câmara Municipal de São Paulo.
