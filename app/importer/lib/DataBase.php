<?php
class app_importer_lib_DataBase {
	public $conn;
	private static $instance;
	
	private function __construct(){
		$this->setDataBase();
	}
	
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function setDataBase(){
		if(empty($this->conn)){
			$dbhost = app_importer_lib_Config::getInstance()->get_dbhost();
			$dbuser = app_importer_lib_Config::getInstance()->get_dbuser();
			$dbpassword = app_importer_lib_Config::getInstance()->get_dbpassword();
			$dbname = app_importer_lib_Config::getInstance()->get_dbname();
			$this->conn = NewADOConnection(app_importer_lib_Config::getInstance()->get_dbdriver());
			$this->conn->Connect($dbhost,$dbuser,$dbpassword,$dbname);
			$this->conn->EXECUTE("set names 'utf8'");
			$this->conn->debug = app_importer_lib_Config::getInstance()->get_dbdebug();
		}
	} 
	
	public function getConn() {
		$this->conn;
	}
}
