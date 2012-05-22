<?php
error_reporting(E_ALL | E_STRICT);
function __autoloadKnl($className){
	if(substr($className,0,4)=='knl_') {
    	$location = 'knl/'.str_replace("_","/",substr($className,4)).".php";
        if(file_exists($location)) {
            require_once($location);
        } else {
            throw new Exception("Class $className not found");
        }
    }
	if(substr($className,0,4)=='app_') {
    	$location = 'app/'.str_replace("_","/",substr($className,4)).".php";
        if(file_exists($location)) {
            require_once($location);
        } else {
            throw new Exception("Class $className not found");
        }
    }
}
spl_autoload_register('__autoloadKnl');
$path = './libext/adodb5'. PATH_SEPARATOR ."./libext/phpmailer". PATH_SEPARATOR ."./libext/snoopy";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
header( 'Content-type: text/html; charset=utf-8' );
//date_default_timezone_set(knl_lib_Config::getInstance()->getTimezone());
require_once("adodb.inc.php");
$shell = (isset($argv)) ? $argv : array();
knl_lib_ShellArgs::getInstance()->setShellArgs($shell);
knl_controller_FrontController::dispatch();
