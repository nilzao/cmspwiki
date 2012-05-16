<?php
class app_importer_lib_FixDataToUnix {
	public static function fixData($str){
		$str = (string) $str;
		$str = trim($str);
		$str = (empty($str)) ? "00000000" : $str;
		$str = str_replace("/","", $str);
		$str = str_replace(".","", $str);
		$str = str_replace(",","", $str);
		$str = str_replace("O","0", $str);
		$str = str_replace("o","0", $str);
		$str = str_replace("l","1", $str);
		$str = str_replace("L","1", $str);
		$str = str_replace("I","1", $str);
		try {
			$date = DateTime::createFromFormat("dmY",
						$str,
						new DateTimeZone(
								app_importer_lib_Config::getInstance()->get_timezone()));
		} catch (Exception $e) {
			echo "\n".$e->getMessage()."\n";
			$date = new DateTime('01-01-1800');
		}
		$str = $date->format('Y-m-d');
		return $str;
	}
}
