<?php
include('libext/fixstr/removeacentos.php');
class app_importer_lib_FixVereadorNome {
	public static function fixNome($str) {
		$str = (string) $str;
		$str = (empty($str)) ? "VARIAVEL VAZIA" : $str;
		$str = removeAcentos($str);
		$str = strtoupper($str);
		$str = trim($str);
		$str = str_replace(" ","_", $str);
		$str = str_replace("__","_", $str);
		return $str;
	}
}
