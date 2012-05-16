<?php
class app_importer_lib_FixDataToBr {
	public static function fixData($str){
		$str = (string) $str;
		$str = trim($str);
		$str = (empty($str)) ? "0000-00-00" : $str;
		$str = str_replace("/","-", $str);
		$str = str_replace(",","-", $str);
		$str = str_replace(".","-", $str);
		$str = str_replace(" ","-", $str);
		try {
			$date = DateTime::createFromFormat("Y-m-d", $str,new DateTimeZone(app_importer_lib_Config::getInstance()->get_timezone()));
		} catch (Exception $e) {
			echo "\n".$e->getMessage()."\n";
			$date = new DateTime('01-01-1800');
		}
		$str = $date->format('d/m/Y');
		return $str;
	}
}
