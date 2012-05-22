<?php
class app_publisher_domain_Vereadores {
	private static $instance;
	private function __construct(){
	}
	
	public static function getInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function handle(){
		$this->indexHandler();
	}
	
	public function indexHandler(){
		$rankingAoDb = new app_exporter_ao_db_Rankings();
		echo "publish Vereadores\n";
		$this->publish();
		echo "\nfim\n";
	}
	
	private function publish(){
		//precisa refatorar isso, criar view para wiki, ao para json, bean para json
		$paginaAoSnoopy = new app_publisher_ao_snoopy_Paginas();
		$paginaBeanSnoopy = new app_publisher_bean_snoopy_Paginas();
		
		$jsonListaVereadores = file_get_contents('./dadosJson/vereadores_arquivos.json');
		$arrayListaVereadores = json_decode($jsonListaVereadores);
		//print_r($arrayListaVereadores);
		
		foreach($arrayListaVereadores as $v){
			$jsonVereador = file_get_contents('./dadosJson/'.$v.'.json');
			$arrayVereador = json_decode($jsonVereador);
			$arrayVereador = $arrayVereador[0];
			unset($arrayVereador->materias);
			//unset($arrayVereador->despesas);
			unset($arrayVereador->funcionarios);
			unset($arrayVereador->resumo_votos);
			
			$nomeVereador = $arrayVereador->vereador->nome;
			$nomeVereadorFix = app_importer_lib_FixVereadorNome::fixNome($nomeVereador);
			$nomeVereadorFix = strtolower($nomeVereadorFix);
			$nomeVereadorFix = ucfirst($nomeVereadorFix);
			
			$vereancas = $arrayVereador->vereancas[0];
			$partido = $vereancas->partido;
			$dataIni = $vereancas->data_ini;
			$dataFim = $vereancas->data_fim;
			
			$nomeVereadorAnterior = $arrayVereador->vereador_anterior->nome;
			
			$gabinete = $arrayVereador->gabinete;
			$gabNum = $gabinete->num_gabinete;
			$gabTel = $gabinete->telefone;
			$gabRamal = $gabinete->ramal;
			$gabFax = $gabinete->fax;
			$gabSala = $gabinete->fax;
			//print_r($arrayVereador);
			
			$paginaBeanSnoopy->pagina = $arrayVereador->vereador->nome;
			$paginaBeanSnoopy->texto = '';
			$paginaBeanSnoopy->texto .= "
<div style=\"float: right;\">
{| align=right style=\"margin-left: 15px; text-align: center; border:1px solid #ADA268; padding:1px; font-size: 90%; width: 190px;background-color:white\" class=\"box noprint\"
|-
|<div style=\"text-align:center;padding:0px; background-color:#ADA268;font-size:14px;\">'''[[".$nomeVereador."]]'''</div>
<div style=\"margin: 2px 0px;\">[[Arquivo:".$nomeVereadorFix.".jpg|190px]]</div>
<div style=\"background-color:#E0DABF;\">

<div class=\"NavFrame\" style=\"border:1px;background-color:#ADA268;padding: 0px;\">
<div style=\"background-color:#ADA268;border:1px solid #ADA268;padding: 0px 0px 0px 4px; font-size: 105%; text-align:left;margin:1px;\">'''<font color=\"white\">Vereador</font>'''</div></div>

<div class=\"NavFrame\" style=\"border:0px; background-color:#E0DABF;padding: 0px;\">
<div class=\"NavHead\" style=\"border:0px; padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE\"><b>'''[[Mandato]]:
".$dataIni." a ".$dataFim."'''</b></div>
</div>

<div class=\"NavFrame\" style=\"border:0px;background-color:#E0DABF;padding: 1px;\">
<div class=\"NavHead\" style=\"border:0px solid #FFF5EE;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE\"><b>Partido: [[".$partido."]]</b></div>
</div>

<div class=\"NavFrame\" style=\"border:0px;background-color:#E0DABF;padding: 1px;\">
<div class=\"NavHead\" style=\"border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE\"><b>Antecessor: [[".$nomeVereadorAnterior."]]</b></div>
<div class=\"NavContent\" style=\"display:none;text-align:left;margin:0px 1px;border:none;text-wight:bold; \">
</div></div>

<div class=\"NavFrame\" style=\"border:0px;background-color:#E0DABF;padding: 1px;\">
<div class=\"NavHead\" style=\"border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:0px;color:black;background-color:#FFF5EE\"><b>[[Gabinete]]: [[".$gabNum."° gabinete]]</b></div>
<div class=\"NavContent\" style=\"display:none;text-align:left;margin:0px 1px;border:none;text-wight:bold; \">
</div></div>

<div class=\"NavFrame\" style=\"border:0px;background-color:#E0DABF;padding: 1px;\">
<div class=\"NavHead\" style=\"border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE\"><b>telefone: ".$gabTel." ramal: ".$gabRamal."</b></div>
<div class=\"NavContent\" style=\"display:none;text-align:left;margin:0px 1px;border:none;text-wight:bold; \">
</div></div>

<div class=\"NavFrame\" style=\"border:0px;background-color:#E0DABF;padding: 1px;\">
<div class=\"NavHead\" style=\"border:0px solid #E0DABF;padding: 0px 0px 0px 4px; font-size: 100%; text-align:left;margin:1px;color:black;background-color:#FFF5EE\"><b>fax: ".$gabFax."</b></div>
<div class=\"NavContent\" style=\"display:none;text-align:left;margin:0px 1px;border:none;text-wight:bold; \">
</div></div>

</div>
|}
</div>
";
			$paginaBeanSnoopy->texto .= "
== Mandatos ==
=== ".$dataIni." - ".$dataFim." CMSP===
".$nomeVereador.", cumpre o mandato de vereador da [[Câmara Municipal de São Paulo]] no período de ".$dataIni." - ".$dataFim.". Filiado ao [[".$partido."]].
";
			$paginaBeanSnoopy->texto .= "
===== Orçamentos para o gabinete =====
".$nomeVereador." é o atual reponsável pelo ".$gabNum."º gabinete da [[Câmara Municipal de São Paulo]].
======Resumo dos [[gastos de gabinete]] no mandato entre 01/2009 a 02/2012 ======
";
			$paginaBeanSnoopy->texto .= "
{| border=1
|-
|  '''Tipo de despesa''' || align=\"right\" | '''Valor'''
";
			foreach($arrayVereador->despesas as $desp){
				$paginaBeanSnoopy->texto .="|-
| ".$desp->descricao."|| align=\"right\" | R$ ".$desp->total."\n";
			}
			$paginaBeanSnoopy->texto .= "\n|}";
			
			//$paginaBeanSnoopy->texto .= "xxx";
			
			$paginaBeanSnoopy->texto .= "

			
wiki full!
";
			
			//print_r($paginaBeanSnoopy);
			$paginaAoSnoopy->publish($paginaBeanSnoopy);
			die();
		}
		
		
	}
}
