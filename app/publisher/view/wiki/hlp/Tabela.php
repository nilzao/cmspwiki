<?php
class app_publisher_view_wiki_hlp_Tabela {
	private $wikiStr;
	
	public function __construct($arrayTitulo,$arrayDados,$arrayNomes){
		$qtdColunas = count($arrayTitulo);
		$this->wikiStr = "{| border=1\n|-\n|";
		$arrayTmp = array();
		$arrayLayout = array();
		foreach($arrayTitulo as $k=>$v){
			$arrayTmp[] = $k;
			$arrayLayout[] = $v;
		}
		$this->wikiStr .= implode(' || ', $arrayTmp)."\n";
		
		foreach($arrayDados as $v){
			$arrayTmp = array();
			for ($i=0;$i<$qtdColunas;$i++){
				$attrib = $arrayNomes[$i];
				$arrayTmp[] = $arrayLayout[$i].$v->$attrib;
			}
			$this->wikiStr .= "|-\n| ".implode(' || ', $arrayTmp)."\n";
		}
		
		$this->wikiStr .= "|}\n";
	}
	
	public function getWikiStr(){
		return $this->wikiStr;
	}
}
