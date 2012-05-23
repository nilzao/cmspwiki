<?php $viewArray = $viewLoader->getVar('viewArray');
$nomeVereador = $viewArray->vereador->nome;
$nomeVereadorFix = app_importer_lib_FixVereadorNome::fixNome($nomeVereador);
$nomeVereadorFix = strtolower($nomeVereadorFix);
$nomeVereadorFix = ucfirst($nomeVereadorFix);
	
$vereancas = $viewArray->vereancas[0];
$situacao = $vereancas->situacao;
$partido = $vereancas->partido;
$dataIni = $vereancas->data_ini;
$dataFim = $vereancas->data_fim;
	
$nomeVereadorAnterior = $viewArray->vereador_anterior->nome;
	
$gabinete = $viewArray->gabinete;
$gabNum = $gabinete->num_gabinete;
$gabTel = $gabinete->telefone;
$gabRamal = $gabinete->ramal;
$gabFax = $gabinete->fax;
$gabSala = $gabinete->fax;
?>
<div style="float: right;">
{| align=right style="margin-left: 15px; text-align: center; border:1px solid #ADA268; padding:1px; font-size: 90%; width: 190px;background-color:white" class="box noprint"
|-
|<div style="text-align:center;padding:0px; background-color:#ADA268;font-size:14px;">'''[[<?php echo $nomeVereador; ?>]]'''</div>
<div style="margin: 2px 0px;">[[Arquivo:<?php echo $nomeVereadorFix; ?>.jpg|190px]]</div>
<div style="background-color:#E0DABF;">

<div class="NavFrame" style="border:1px;background-color:#ADA268;padding: 0px;">
<div style="background-color:#ADA268;border:1px solid #ADA268;padding: 0px 0px 0px 4px; font-size: 105%; text-align:left;margin:1px;">'''<font color="white"><?php echo $situacao;?></font>'''</div></div>

<div class="NavFrame" style="border:0px; background-color:#E0DABF;padding: 0px;">
<div class="NavHead" style="border:0px; padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE"><b>'''Início [[Mandato]]:
<?php echo $dataIni;?>'''</b></div>
</div>

<div class="NavFrame" style="border:0px;background-color:#E0DABF;padding: 1px;">
<div class="NavHead" style="border:0px solid #FFF5EE;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE"><b>Partido: [[<?php echo $partido; ?>]]</b></div>
</div>

<div class="NavFrame" style="border:0px;background-color:#E0DABF;padding: 1px;">
<div class="NavHead" style="border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE"><b>Antecessor: [[<?php echo $nomeVereadorAnterior;?>]]</b></div>
<div class="NavContent" style="display:none;text-align:left;margin:0px 1px;border:none;text-wight:bold; ">
</div></div>

<div class="NavFrame" style="border:0px;background-color:#E0DABF;padding: 1px;">
<div class="NavHead" style="border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:0px;color:black;background-color:#FFF5EE"><b>[[Gabinete]]: [[<?php echo $gabNum; ?>° gabinete]]</b></div>
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
== Mandatos ==
=== 29/03/2011 CMSP===
<?php echo $nomeVereador; ?>, cumpre o mandato na [[Câmara Municipal de São Paulo]] desde <?php echo $dataIni; ?> Filiado ao [[<?php echo $partido; ?>]] na posição de <?php echo $situacao; ?>.

===== Orçamentos para o gabinete =====
<?php echo $nomeVereador; ?> é o atual reponsável pelo <?php echo $gabNum; ?>º gabinete da [[Câmara Municipal de São Paulo]].
======Resumo dos [[gastos de gabinete]] no mandato entre 01/2009 a 02/2012 ======
<?php 
$arrayTitulo = array("'''Tipo de despesa'''"=>"","'''Valor'''"=>"align=\"right\" | R$ "); 
$arrayNomes = array("descricao","total");
$tabela = new app_publisher_view_wiki_hlp_Tabela($arrayTitulo, $viewArray->despesas,$arrayNomes);
echo $tabela->getWikiStr();
?>
O vereador '''<?php echo $nomeVereador; ?>''', é o '''<?php echo $viewArray->ranking_total->posicao; ?>º''' colocado entre os [[vereadores|55 vereadores]] no [[ranking de gastos com gabinete]].
======Relação de funcionários ligados ao <?php echo $gabNum; ?>º gabinete======
<?php 
$arrayTitulo = array("'''Nome'''"=>"","'''Cargo'''"=>"");
$arrayNomes = array("nome","cargo");
$tabela = new app_publisher_view_wiki_hlp_Tabela($arrayTitulo, $viewArray->funcionarios,$arrayNomes);
echo $tabela->getWikiStr();
?>
=====Votações=====

Total de votações nominais em matérias pelo vereador '''<?php echo $nomeVereador; ?>'''
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
