<?php
class app_publisher_ao_snoopy_SnoopyParent {
	protected $wikiRoot;
	protected $apiUrl;
	protected $conn;
	
	protected function __construct(){
		$this->wikiRoot = app_publisher_lib_Config::getInstance()->getWikiRoot();
		$this->apiUrl = app_publisher_lib_Config::getInstance()->getApiUrl();
		$this->conn = app_publisher_lib_Snoopy::getInstance(); 
	}
	
	private function getToken($pagStr){
		$query_vars['action'] = "query";
		$query_vars['prop'] = "info";
		$query_vars['intoken'] = "edit";
		$query_vars['titles'] = $pagStr;
		$query_vars['indexpageids'] = "";
		$query_vars['format'] = "php";
		$this->conn->snoopy->submit($this->apiUrl,$query_vars);
		$response = unserialize($this->conn->snoopy->results);
		$page_id = $response['query']['pageids'][0];
		$token = $response['query']['pages'][$page_id]['edittoken'];
		return $token;
	}
	
	protected function edit($tituloStr,$textoStr){
		$token = $this->getToken($tituloStr);
		$edit_vars['action'] = "edit";
		$edit_vars['title'] = $tituloStr;
		$edit_vars['text'] = $textoStr;
		$edit_vars['token'] = $token;
		$edit_vars['format'] = 'php';
		
		$this->conn->snoopy->submit($this->apiUrl,$edit_vars);
		$response = unserialize($this->conn->snoopy->results);
	}
}
