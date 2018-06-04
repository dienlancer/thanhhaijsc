<?php
class SessionHelper{
	public $_ssName;	
	public function __construct($name=null,$value=null){		
		$this->_ssName = 'ss_' . md5(get_bloginfo('wpurl') . $name . ZENDVN_SP_PLUGIN_NAME . ZENDVN_SP_PLUGIN_VERSION);		  
		if(!isset($_SESSION[$this->_ssName])){
			$_SESSION[$this->_ssName] = array();
		}else{
			if(isset($_SESSION[$this->_ssName][$value]["timeout"])){
				if($_SESSION[$this->_ssName][$value]["timeout"] + 216000 < time()){
					$this->reset();
				}
			}			
		}		
	}
	public function set($name = null, $value = null){
		if($name != null || !empty($name)){
			$_SESSION[$this->_ssName][$name] = $value;
			$_SESSION[$this->_ssName][$name]["timeout"]=time();
		}
	}
	public function get($name = null){
		if($name == null){
			return $_SESSION[$this->_ssName];
		}else{
			return (!isset($_SESSION[$this->_ssName][$name])) ? array() : $_SESSION[$this->_ssName][$name];
		}
	}
	public function reset(){
		unset($_SESSION[$this->_ssName]) ;
	}
}