<?php
class app_importer_lib_FixDataToUnix {
	public static function fixData($str){
		$str = (string) $str;
		$str = trim($str);
		$str = (empty($str)) ? "00/00/0000" : $str;
		$str = str_replace("/","-", $str);
		$str = str_replace("O","0", $str);
		$str = str_replace("o","0", $str);
		$str = str_replace("l","1", $str);
		$str = str_replace("L","1", $str);
		$str = str_replace("I","1", $str);
		try {
			$date = new DateTime($str);
		} catch (Exception $e) {
			echo $e->getMessage();
			exit(1);
		}
		$str = $date->format('Y-m-d');
		return $str;
	}
}
