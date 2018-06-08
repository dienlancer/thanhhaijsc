<?php
class AdminManufacturerController{
 	private $_prefix_name = 'zendvn-sp-zamanufacturer';	
	private $_prefix_id   = 'zendvn-sp-zamanufacturer-';	
	public function __construct(){		
		global $zController;		
		$model = $zController->getModel("/backend","AdminManufacturerModel");
		add_action('init',array($model,'create'));				
	}
	
 } 
?>