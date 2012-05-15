<?php
class app_importer_lib_Config {
	private static $instance;
	private $dbhost;
	private $dbuser;
	private $dbpassword;
	private $dbname;
	private $dbdebug;
	private $dbdriver;
	private $timezone;
	
	private function __construct(){}
	
	public static function getInstance(){
		if (!isset(self::$instance)){
  			self::$instance = new self();
	  	}
	  	self::$instance->dbhost = "localhost";
		self::$instance->dbuser = "root";
		self::$instance->dbpassword = "123";
		self::$instance->dbname = "cmsptmp";
		self::$instance->dbdebug = false;
		self::$instance->dbdriver = 'mysqli';
		self::$instance->timezone = 'America/Sao_Paulo';
		date_default_timezone_set(self::$instance->timezone);
	  	return self::$instance;
	}
	
	public function get_dbhost(){
		return $this->dbhost;
	}
	
	public function get_dbuser(){
		return $this->dbuser;
	}
	
	public function get_dbpassword(){
		return $this->dbpassword;
	}
	
	public function get_dbname(){
		return $this->dbname;
	}
	
	public function get_dbdebug(){
		return $this->dbdebug;
	}
	
	public function get_dbdriver(){
		return $this->dbdriver;
	}
	
	public function get_timezone(){
		return $this->timezone;
	}
}
