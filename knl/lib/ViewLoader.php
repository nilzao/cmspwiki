<?php
class knl_lib_ViewLoader {
    private static $instance;
    private $vars = array();    
    private function __construct() {}
    public static function getInstance() {
       if(!isset(self::$instance)) {
           self::$instance = new self();
       }
       return self::$instance;
    }
    
	public function setVar($name, $var) {
		$this->vars[$name] = $var;
	}
    
	public function getVar($name, $error=true) {
		if(isset($this->vars[$name])) {
			return $this->vars[$name];
		} else if($error) {
			throw new Exception("Var $name not defined!");
		}
	}
    
    public function isSetVar($name){
    	return isset($this->vars[$name]);
    }
    
    public function display($app,$view, $echo = true) {
		$viewLoader = $this;
		//$browser = class_detect_browser->method;
		$browser = 'w3c'; 
		ob_start();
		try {
			$pathView = $app.'/view/'.$browser.'/'.$view.'.php';
			unset($app);
			unset($browser);
			unset($view);
        	require($pathView);
        	$result = ob_get_clean(); 
        	if($echo){echo $result;} 
        	return $result;
        } catch(Exception $e) {
			ob_end_clean();
			print_r($e);
		}
    }
}
