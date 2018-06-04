<?php
class Backend{
	
	private $_menuSlug = 'zendvn-sp-manager';
	
	private $_page = '';
	
	public function __construct(){
		global $zController;
		if(isset($_GET['page'])) $this->_page = $_GET['page'];		
		add_action('admin_menu', array($this,'menus'));
		if(
			
			$this->_page == 'zendvn-sp-manager-invoice'			|| 
			$this->_page == 'zendvn-sp-manager-setting' 		|| 			
			$this->_page == 'zendvn-sp-manager-user'
		){
			add_action('admin_init', array($this,'do_output_buffer'));
		}
		add_action('admin_enqueue_scripts', array($this,'add_css_file'));		
		add_action('admin_enqueue_scripts', array($this,'add_js_file'));
		$zController->getHelper("CreatePage");
	}
	

	public function do_output_buffer(){
		ob_start();
	}
	
	public function add_css_file(){		
		wp_register_style('product',PLUGIN_URL . "public/backend/css/product.css",array(),'1.0');
		wp_enqueue_style('product');
		wp_enqueue_style('thickbox');
	}
	public function add_js_file(){
		wp_register_script("multi-media-button",PLUGIN_URL . "public/backend/js/multi-media-button.js" ,array(),null,false);
		wp_enqueue_script("multi-media-button");	
		wp_enqueue_media();
		wp_register_script("single-media-button",PLUGIN_URL . "public/backend/js/single-media-button.js" ,array(),null,false);
		wp_enqueue_script("single-media-button");	
		wp_enqueue_script('media-upload');
	}
	public function menus(){
		add_menu_page('Shopping', 'Shopping', 'manage_options', $this->_menuSlug,
						array($this,'dispatch_function'),'',3);

		add_submenu_page($this->_menuSlug, 'Dashboard', 'Dashboard', 'manage_options', 
						$this->_menuSlug ,array($this,'dispatch_function'));				
						
						
		add_submenu_page($this->_menuSlug, 'Invoice', 'Invoice', 'manage_options',
						$this->_menuSlug . '-invoice',array($this,'dispatch_function'));

		add_submenu_page($this->_menuSlug, 'Setting', 'Setting', 'manage_options',
						$this->_menuSlug . '-setting',array($this,'dispatch_function'));		

		add_submenu_page($this->_menuSlug, 'User', 'User', 'manage_options',
						$this->_menuSlug . '-user',array($this,'dispatch_function'));	
	}	
	public function dispatch_function(){		
		global $zController;
		$page = $this->_page;
		switch ($page) {
			case 'zendvn-sp-manager-setting':
				$zController->getController('/backend','AdminSettingController');
				break;		
			case 'zendvn-sp-manager-invoice':
				$zController->getController('/backend','AdminInvoiceController');
			break;						
			case 'zendvn-sp-manager-user':
				$zController->getController('/backend','AdminUserController');
			break;
			default:				
				break;
		}		
	}
}

















