<?php
class app_importer_lib_FixDataToUnix {
	public static function fixData($str){
		$str = (string) $str;
		$str = trim($str);
		$str = (empty($str)) ? "0000-00-00" : $str;
		$str = str_replace("/","-", $str);
		$str = str_replace(".","-", $str);
		$str = str_replace(",","-", $str);
		$str = str_replace("O","0", $str);
		$str = str_replace("o","0", $str);
		try {
			$date = new DateTime($str);
		} catch (Exception $e) {
			echo "\n".$e->getMessage()."\n";
			$date = new DateTime('01-01-1800');
		}
		$str = $date->format('Y-m-d');
		return $str;
	}
}
