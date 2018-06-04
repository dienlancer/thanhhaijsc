<?php
class AdminUserController{
	private $_page = '';
	public function __construct(){		
		$this->dispatch_function();
	}		
	public function dispatch_function(){
		global $zController;		
		$action = $zController->getParams('action');
		switch ($action){
			case 'add'		: $this->add(); break;
			case 'edit'		: $this->edit(); break;
			case 'delete'	: $this->delete(); break;
			case 'active'	: 
			case 'inactive'	:
							  $this->status(); break;
							
			default			: $this->display(); break;
		}
	}
	
	public function display(){
		global $zController;
		if($zController->getParams('action') == -1){
			$url = $this->createUrl();
			wp_redirect($url);
		}
		$zController->getView('/backend/user/display.php');
	}
	
	public function createUrl(){
		global $zController;		
		$url = 'admin.php?page=' . $zController->getParams('page');
		if($zController->getParams('filter_status') != '0'){
			$url .= '&filter_status=' . $zController->getParams('filter_status');
		}		
		if(mb_strlen($zController->getParams('s'))){
			$url .= '&s=' . $zController->getParams('s');
		}		
		return $url;
	}
	

	public function add(){		
		global $zController;
		if(strcmp($_SERVER['REQUEST_METHOD'], 'POST')==0){
			$model = $zController->getModel('/backend','AdminUserModel');
			$model->save_item();
			$url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=1';
			wp_redirect($url); 
		}
		$zController->getView('/backend/user/form.php');
	}
	
	public function edit(){
		global $zController;
		if(strcmp($_SERVER['REQUEST_METHOD'],'POST')!=0){
			$model = $zController->getModel('/backend','AdminUserModel');			
			$data=array();
			$data = $model->getItem();				
			$zController->_data = $data;				
		}else{
			$model = $zController->getModel('/backend','AdminUserModel');
			$model->save_item();
			$url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=1';
			wp_redirect($url); 
		}
		$zController->getView('/backend/user/form.php');
	}
	
	public function delete(){		
		global $zController;		
		$arrParam = $zController->getParams();
		if(!is_array($arrParam['id'])){
			$action 	= 'delete_id_' . $arrParam['id'];
			check_admin_referer($action,'security_code');
		}else{
			wp_verify_nonce('_wpnonce');
		}
		$model = $zController->getModel('/backend','AdminUserModel');
		$model->deleteItem();
		$paged = max(1,$arrParam['paged']);
		$url = 'admin.php?page=' . $_REQUEST['page']. '&msg=1';
		wp_redirect($url);
	}
	
	public function status(){
		global $zController;
		$arrParam = $zController->getParams();		
		if(!is_array($arrParam['id'])){
			$action 	= $arrParam['action'] . '_id_' . $arrParam['id'];
			check_admin_referer($action,'security_code');
		}else{
			wp_verify_nonce('_wpnonce');
		}
		$model = $zController->getModel('/backend','AdminUserModel');
		$model->changeStatus();
		$paged = max(1,$arrParam['paged']);
		$url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
		wp_redirect($url);		
	}
	
	public function no_access(){

	}
}