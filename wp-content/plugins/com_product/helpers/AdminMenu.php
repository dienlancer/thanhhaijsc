<?php
class AdminMenu{
	
	public function __construct(){
		add_action('admin_menu', array($this,'modify_admin_menus'));
		if(isset($_GET['post_type']) && $_GET['post_type'] == 'zaproduct'){
			add_action('admin_enqueue_scripts', array($this,'add_js'));
		}
	}
	
	public function add_js(){		
		wp_register_script("admin_menu",PLUGIN_URL . "public/backend/js/admin_menu.js" ,array('jquery'),'1.0',true);
		wp_enqueue_script("admin_menu");	
	}

	function modify_admin_menus(){
	
		global $menu, $submenu;
	
		$zendvn_sp_manager = $submenu['zendvn-sp-manager'];
		foreach ($zendvn_sp_manager as $key => $val){
			if($val[2] == 'zendvn-sp-manager-categories'){
				$zendvn_sp_manager[$key][2] = 'edit-tags.php?taxonomy=za_category&post_type=zaproduct';
			}
				
			if($val[2] == 'zendvn-sp-manager-products'){
				$zendvn_sp_manager[$key][2] = 'edit.php?post_type=zaproduct';
			}
		}
		$submenu['zendvn-sp-manager'] = $zendvn_sp_manager;
		remove_menu_page('edit.php?post_type=zaproduct');
	}
	
	
}