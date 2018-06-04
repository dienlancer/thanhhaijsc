<?php
class zController{	
	public $_error = array();	
	public $_data = array();
	public $_success=array();
	public function __construct($options = array()){
		
	}
	
	public function isPost(){
		$flag = ($_SERVER['REQUEST_METHOD']=='POST') ? true:false;
		return $flag;
	}
	
	public function getParams($name = null){		
		if(empty($name)){
			return $_REQUEST;
		}else{
			$val = (isset($_REQUEST[$name]))?$_REQUEST[$name]:'';
			return $val;
		}
	}
	
	public function getConfig($filename = ''){
	
		$obj = new stdClass();
	
		$file =  PLUGIN_PATH . DS . "configs" . DS . $filename . '.php';
	
		if(file_exists($file)){
			require_once $file;
			$controllerName =  $filename ;
			$obj = new $controllerName ();
		}
		return $obj;
	}
	
	public function getController($dir="",$filename=""){		
		$obj = new stdClass();		
		$file =  PLUGIN_PATH . DS . "controllers" . DS . $dir . DS . $filename . '.php';				
		if(file_exists($file)){
			require_once $file;
			$controllerName =  $filename ;	
			$obj = new $controllerName ();			
		}
		return $obj;
	}
	
	public function getModel($dir="",$filename=""){		
		$obj = new stdClass();		
		$file =  PLUGIN_PATH . DS . "models" . DS . $dir . DS . $filename . '.php';		
		if(file_exists($file)){			
			require_once $file;
			$modelName =  $filename ;
			$obj = new $modelName ();
		}

		return $obj;
	}
	
	public function getHelper($filename = ''){
		$obj = new stdClass();		
		$file =  PLUGIN_PATH . DS . "helpers" . DS . $filename . '.php';		
		if(file_exists($file)){
			require_once $file;
			$helperName =  $filename ;
			$obj = new $helperName ();			
		}
		return $obj;
	}
	public function getSession($filename = '',$name=null,$value=null){

		$obj = new stdClass();
		
		$file =  PLUGIN_PATH . DS . "helpers" . DS . $filename . '.php';		
		
		if(file_exists($file)){
			require_once $file;
			$helperName =  $filename ;
			$obj = new $helperName ($name,$value);
		}
		return $obj;
	}
	public function getPagination($filename = '',$options=array()){

		$obj = new stdClass();
		
		$file =  PLUGIN_PATH . DS . "helpers" . DS . $filename . '.php';		
		
		if(file_exists($file)){
			require_once $file;
			$helperName =  $filename ;
			$obj = new $helperName ($options);
		}
		return $obj;
	}
	public function getView($filename =""){		
		$file =  PLUGIN_PATH . DS . "templates"  . DS . $filename;			
		if(file_exists($file)){
			require_once $file;		
		}
	}	
}