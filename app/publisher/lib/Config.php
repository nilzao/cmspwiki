<?php
class app_publisher_lib_Config {
	private static $instance;
	private $curlPath;
	private $wikiRoot;
	private $apiUrl;
	
	private function __construct(){}
	
	public static function getInstance(){
		if (!isset(self::$instance)){
  			self::$instance = new self();
	  	}
	  	self::$instance->curlPath = "/usr/bin/curl";
		self::$instance->wikiRoot = "http://meuwiki.com.br/wiki/";
		self::$instance->apiUrl = self::$instance->wikiRoot."api.php";
	  	return self::$instance;
	}
	
	public function getCurlPath(){
		return $this->curlPath;
	}
	
	public function getWikiRoot(){
		return $this->wikiRoot;
	}
	
	public function getApiUrl(){
		return $this->apiUrl;
	}
	
}
