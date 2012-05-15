<?php
abstract class knl_lib_Registry {
	/**
	 * 
	 * Return value from $argv shell
	 * @param int $argnum
	 */
	public static function getShellArg($argnum){
	  	$shell = knl_lib_ShellArgs::getInstance();
	  	return $shell->getShellArg($argnum);
	}
	/**
	 * 
	 * Return value from $_GET[$key]
	 * @param string/int $key
	 */
	public static function getGetKey($key){
	  	$request = knl_lib_Request::getInstance();
	  	return $request->getGet($key);
 	}
 	/**
	 * 
	 * Return value from $_POST[$key]
	 * @param string/int $key
	 */
	public static function getPostKey($key){
	  	$request = knl_lib_Request::getInstance();
	  	return $request->getPost($key);
 	}
 	/**
	 * 
	 * Return value from $_REQUEST[$key]
	 * @param string/int $key
	 */
	public static function getRequestKey($key){
	  	$request = knl_lib_Request::getInstance();
	  	return $request->getRequest($key);
 	}
	/**
	 * 
	 * Return value from $_SESSION[$key]
	 * @param string/int $key
	 */
	public static function getSessionKey($key){
		$session = knl_lib_Session::getInstance();
		return $session->getSessionKey($key);
	}
	/**
	 * 
	 * Return value from $_FILES[$key]
	 * @param string/int $key
	 * @return array
	 */
	public static function getFilesKey($key){
	  	$files = knl_lib_Files::getInstance();
	  	return $files->getFilesKey($key);
	}
}
