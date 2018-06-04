<?php
class Module{	
	private $_module_options = array();	
	public function __construct(){		
		$this->_module_options = array(																				
					"loadModuleArticle" 					=> true,	
					"loadModuleProduct" 					=> true,	
					"loadModuleBanner" 					=> true,	
					"loadModuleItem" 				=> true,				
					"loadModuleCommon" 				=> true,									
				);		
		foreach ($this->_module_options as $key => $val){	
			if($val == true){
				add_action('widgets_init',array($this,$key));
			}
		}
	}			
	public function loadModuleArticle(){
		require_once PLUGIN_PATH . DS . 'module'. DS .'module-article.php';		
		register_widget('ModuleArticle');
	}
	public function loadModuleProduct(){
		require_once PLUGIN_PATH . DS . 'module'. DS .'module-product.php';		
		register_widget('ModuleProduct');
	}
	public function loadModuleBanner(){
		require_once PLUGIN_PATH . DS . 'module'. DS .'module-banner.php';		
		register_widget('ModuleBanner');
	}
	public function loadModuleItem(){
		require_once PLUGIN_PATH . DS . 'module'. DS .'module-item.php';		
		register_widget('ModuleItem');
	}
	public function loadModuleCommon(){
		require_once PLUGIN_PATH . DS . 'module'. DS .'module-common.php';		
		register_widget('ModuleCommon');
	}
}