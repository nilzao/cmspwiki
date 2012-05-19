<?php
require_once('libext/fixstr/removeacentos.php');
class app_importer_lib_FixVotacaoNome {
	public static function fixNome($str) {
		$str = (string) $str;
		$str = (empty($str)) ? "VARIAVEL VAZIA" : $str;
		$str = removeAcentos($str);
		$str = strtoupper($str);
		$str = trim($str);		
		$arrayErrado = array(' ','.','-','(',')','º','ª',',');
		$arrayCerto = array('_' ,'' ,'' ,'' ,'','O','A','_');
		$str = str_replace($arrayErrado, $arrayCerto, $str);
		$str = str_replace("__","_", $str);
		$str = str_replace("__","_", $str);
		$str = str_replace("__","_", $str);
		$str = str_replace("__","_", $str);
		$str = str_replace("PROJETO_DE_LEI_NO","PL",$str);
		$str = str_replace("PL_NO","PL",$str);
		return $str;
	}
}
