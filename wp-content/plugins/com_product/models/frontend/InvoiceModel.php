<?php
class InvoiceModel{	
	public function getLst(){	
		global $wpdb;
		$table = $wpdb->prefix . 'shk_country';	
		$sql = "SELECT p.id  , p.country_name , p.country_slug , p.country_status FROM {$table} p where p.country_status = 1  order by p.country_name ASC " ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function getLstInvoiceByUserID($id){	
		global $wpdb;
		$tbInvoice = $wpdb->prefix . 'shk_invoice';			
		$sql = "SELECT i.* 
				FROM `".$tbInvoice."` i 				
				 where i.user_id = ".$id ;				
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function getInvoiceDetailById($id){	
		global $wpdb,$zController;		
		$table = $wpdb->prefix . 'shk_invoice_detail';	
		$sql = "SELECT i.* FROM {$table} i where i.invoice_id =   " . $id ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function getUserByUsername($username){	
		global $wpdb,$zController;		
		$table = $wpdb->prefix . 'shk_user';	
		$sql = "SELECT u.* FROM {$table} u where u.username =  '".$username."' " ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function checkLogin(){	
		global $wpdb,$zController;
		$log=false;
		$username=trim($_POST["txtUsernameLogin"]);		
		$password=md5($_POST["txtPasswordLogin"]);		
		$table = $wpdb->prefix . 'shk_user';	
		$sql = "SELECT u.* FROM {$table} u where u.username =  '".$username."' and  u.password = '".$password."' " ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		if(count($result)>0)
			$log=true;		
		return $log;
	}
	public function createBill(){		
		global $zController, $wpdb;		
		$vHtml=new HtmlControl(); 		 
		
	}
}