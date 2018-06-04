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
		$tableUser = $wpdb->prefix . 'shk_user';	
		$tableInvoice = $wpdb->prefix . 'shk_invoice';
		$tableInvoiceDetail = $wpdb->prefix . 'shk_invoice_detail';
		$username=$_POST["hiddenUsername"];		
		$email=$_POST["email"];
	    $fullname=$_POST["fullname"];
	    $address=$_POST["address"];
	    $phone=$_POST["phone"];
	    $mobilephone=$_POST["mobilephone"];
	    $fax=$_POST["fax"];   	
	    $payment_method_id=$_POST["payment_method"];
	    $user_id =(int)$_POST["user_id"];  	
	    $totalQuantity=(int)$_POST["total_quantity"];
	    $totalPrice=(float)$_POST["total_price"];
	    $invoice_code=$vHtml->randomString(10);	    
	    $created_date=date("Y-m-d H:i:s",time());
	    $status=0;
		$query = "UPDATE {$tableUser} set `email` = %s, `fullname` = %s, `address` = %s, `phone` = %s, `mobilephone` = %s , `fax` = %s where `id` = %d ";
		$info = $wpdb->prepare($query,$email,$fullname,$address,$phone,$mobilephone,$fax,$user_id
			);
		$wpdb->query($info);	

		$query = "INSERT INTO {$tableInvoice} (
			`code`,
			  `user_id`,
			  `created_date`,
			  `username`,  
			  `email`,
			  `fullname`,
			  `address`,
			  `phone`,
			  `mobilephone`,
			  `fax`,
			  `payment_method_id`,
			  `quantity`,
			  `total_price`,
			  `status`
		) VALUES
(
			  %s,
			  %d,
			  %s,
			  %s,  
			  %s,
			  %s,
			  %s,
			  %s,
			  %s,
			  %s,
			  %d,
			  %d,
			  %f,
			  %d
		)";		
		$info = $wpdb->prepare($query,
			  $invoice_code,
			  $user_id,		
			  $created_date,	  
			  $username,  
			  $email,
			  $fullname,
			  $address,
			  $phone,
			  $mobilephone,
			  $fax,
			  $payment_method_id,
			  $totalQuantity,
			  $totalPrice,
			  $status
			);						
		$wpdb->query($info);	
			
		$sql = "SELECT max(p.id)  as invoice_id  FROM {$tableInvoice} p" ;
		$result = $wpdb->get_results($sql,ARRAY_A);	
		$invoice_id=(int)$result[0]["invoice_id"];
		
		$ssName="vmart";
		$ssValue="zcart";
		$ss     = $zController->getSession('SessionHelper',$ssName,$ssValue);
		$ssCart = $ss->get($ssValue);       		
		$arrSS=$ssCart["cart"];
		
		foreach ($arrSS as $key => $value) {
			$product_id=(int)$value["product_id"];
			$product_code=$value["product_code"];
			$product_name=$value["product_name"];			
			$product_image=$value["product_image"];			
			$product_price=(float)$value["product_price"];			
			$product_quantity=(int)$value["product_quantity"];			
			$product_total_price=(float)$value["product_total_price"];			
			$query = "INSERT INTO {$tableInvoiceDetail} (
				  `invoice_id`,
				  `product_id`,
				  `product_code`,
				  `product_name`,  
				  `product_image`,  
				  `product_price`,  
				  `product_quantity`,  
				  `product_total_price`
			)  VALUES (
					%d,
				  %d,
				  %s,
				  %s,  
				  %s,  
				  %f,  
				  %d,  
				  %f
			)";
			$info = $wpdb->prepare($query,

				$invoice_id,
  $product_id,
  $product_code,
  $product_name,  
  $product_image,  
  $product_price,  
  $product_quantity,  
  $product_total_price

				);
			$wpdb->query($info);
		}
	}
}