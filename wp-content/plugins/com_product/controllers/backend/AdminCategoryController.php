<?php
class AdminCategoryController{
 	private $_prefix_name = 'zendvn-sp-zacategory';	
	private $_prefix_id   = 'zendvn-sp-zacategory-';	
	public function __construct(){
		global $zController;		
		$model = $zController->getModel("/backend","AdminCategoryModel");
		add_action('init',array($model,'create'));				
	}
	
 } 
?>