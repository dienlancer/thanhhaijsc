<?php
class AdminSettingController{
	
	public function __construct(){
		$this->display();				
	}
	
	public function display(){
		global $zController;
		if($zController->isPost()){
			$zendvn_sp_setting = $zController->getParams('zendvn_sp_setting');
			update_option('zendvn_sp_setting', $zendvn_sp_setting,'yes');			
			$url = 'admin.php?page=' . $zController->getParams('page') . '&msg=1';
			wp_redirect($url);
		}
		$zController->getView('/backend/setting/display.php');
	}

}