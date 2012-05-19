<?php
class app_importer_domain_Votacoes {
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
		/*
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SIP/BaixarXML.aspx?arquivo=Votacoes_2010.xml';
		$arrayUrl[] = '.http://www2.camara.sp.gov.br/SIP/BaixarXML.aspx?arquivo=Votacoes_2011.xml';
		$arrayUrl[] = 'http://www2.camara.sp.gov.br/SIP/BaixarXML.aspx?arquivo=Votacoes_2012.xml';
		*/
		$arrayUrl[] = './dadosExt/Votacoes_2010.xml';
		$arrayUrl[] = './dadosExt/Votacoes_2011.xml';
		$arrayUrl[] = './dadosExt/Votacoes_2012.xml';
		
		$vereadorVotacaoAoDb = new app_importer_ao_db_VereadoresVotacoes();
		$votacaoTipoAoDb = new app_importer_ao_db_VotacoesTipo();
		$vereadorVotacaoAoDb->truncate();
		$votacaoTipoAoDb->truncate();
		
		echo "import Votacoes\n";
		foreach($arrayUrl as $url){
			echo "url: $url \n";
			$this->import($url);
		}
		echo "\nfim\n";
	}
	
	public function import($url){
		$xmlObj = simplexml_load_file($url);
		
		$vereadorAoDb = new app_importer_ao_db_Vereadores();
		$vereadorVotacaoAoDb = new app_importer_ao_db_VereadoresVotacoes();
		$votacaoTipoAoDb = new app_importer_ao_db_VotacoesTipo();
		
		$vereadorBeanDb = new app_importer_bean_db_Vereadores();
		$vereadorVotacaoBeanDb = new app_importer_bean_db_VereadoresVotacoes();
		$votacaoTipoBeanDb = new app_importer_bean_db_VotacoesTipo();
		$arrayErroVereador = array();
		$i = 0;
		
		foreach($xmlObj as $votacao){
			$attributes = $votacao->attributes();
			$projetoBeanDb = $this->getProjetoBeanDb($attributes['Materia'],$attributes['TipoVotacao']);
			if ($projetoBeanDb->id != 0){
				foreach($votacao->Vereador as $vereador){
					$vereadorBeanDb->id == 0;
					$vereadorBeanDb = $vereadorAoDb->getByNomeFix($vereador['NomeParlamentar']);
					if ($vereadorBeanDb->id == 0){
						$nomeVereador = (string) $vereador['NomeParlamentar'];
						$arrayErroVereador[$nomeVereador] = "ERRO";
					}
					$votacaoTipoBeanDb->id = 0;
					$votacaoTipoBeanDb = $votacaoTipoAoDb->getByDescricaoFix($vereador['Voto']);
					
					$vereadorVotacaoBeanDb->id = 0;
					$vereadorVotacaoBeanDb->id_vereador = $vereadorBeanDb->id;
					$vereadorVotacaoBeanDb->id_projeto = $projetoBeanDb->id;
					$vereadorVotacaoBeanDb->id_votacao_tipo = $votacaoTipoBeanDb->id;
					
					$vereadorVotacaoAoDb->upsert($vereadorVotacaoBeanDb);
				}
			}
		}
		if (count($arrayErroVereador) > 0){
			ksort($arrayErroVereador);
			echo "Vereadores não encontrados: \n";
			foreach($arrayErroVereador as $k => $v){
				echo " - [".$k."]\n";
			}
		}
	}
	
	private function getProjetoBeanDb($materiaStr,$tipoVotacao){
		$projetoBeanDb = new app_importer_bean_db_Projetos();
		$materia = app_importer_lib_FixVotacaoNome::fixNome($materiaStr);
		if ($tipoVotacao != 'Simbólica'
				&& substr_count($materia, 'VARIAVEL_VAZIA') == 0
				&& substr_count($materia, 'ADIAM') == 0
				&& substr_count($materia, 'ENCERR') == 0
				&& substr_count($materia, 'INV') == 0
				&& substr_count($materia, 'PAPEIS') == 0
				&& substr_count($materia, 'REQUER') == 0
				&& substr_count($materia, 'SUSP') == 0
				&& substr_count($materia, 'ELEICAO') == 0
				&& substr_count($materia, 'EMENDA') == 0
				&& substr_count($materia, 'SUBSTITUTIVO') == 0
				&& substr_count($materia, 'SUB_N') == 0
				&& substr_count($materia, 'INCLU') == 0
				&& substr_count($materia, 'MANUT') == 0
				&& substr_count($materia, 'SUBISTITUTIVO') == 0
				&& substr_count($materia, 'RELATORIO') == 0
				&& substr_count($materia, 'DOCREC') == 0
				&& substr_count($materia, 'SUBIST_') == 0
				&& substr_count($materia, 'SUBAO_') == 0
				&& substr_count($materia, 'REDUCAO') == 0
				&& substr_count($materia, 'ORDEM_CRONOLOGICA') == 0
				&& substr_count($materia, 'PARECER') == 0
				&& substr_count($materia, 'VETO') == 0){
			$posFim = strpos($materia, '/');
			$strTmp = substr($materia, $posFim);
			$posFimTmp = strpos($strTmp, '_');
			if ($posFimTmp != 0){
				$materia = substr($materia, 0,$posFim + $posFimTmp);
			}
			$materia = str_replace('/', '_', $materia);
			$materia = str_replace('__', '_', $materia);
			$materia = explode('_', $materia);
			if ($materia[2] < 2000){
				$materia[2] = $materia[2] + 2000;
			}
			$projetoBeanDb->id = 0;
			$projetoBeanDb->tipo_projeto = $materia[0];
			$projetoBeanDb->numero_projeto = $materia[1];
			$ano = $materia[2];
			
			$projetoAoDb = new app_importer_ao_db_Projetos();
			$projetoBeanDb = $projetoAoDb->getByTipoNumAno($projetoBeanDb, $ano);
		}
		return $projetoBeanDb;
	}
	
	public function verificaVereadorXml($url){
		$xmlObj = simplexml_load_file($url);
		foreach ($xmlObj->Votacao as $votacao) {
			foreach($votacao->Vereador as $vereador){
				if (!app_importer_domain_Vereadores::getInstance()->validaNome($vereador['NomeParlamentar'])){
					echo "[".$vereador['NomeParlamentar']."] - ERRO \n";
				}
			}
		}
	}
}
