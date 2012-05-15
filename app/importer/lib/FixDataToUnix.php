<?php
class app_importer_lib_FixDataToUnix {
	public static function fixData($str){
		$str = (string) $str;
		$str = trim($str);
		$str = (empty($str)) ? "00/00/0000" : $str;
		$str = str_replace("/","-", $str);
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
