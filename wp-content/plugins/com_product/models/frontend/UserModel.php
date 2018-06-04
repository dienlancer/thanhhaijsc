<?php
class UserModel{		
	public function getUserByUsername($username){	
		global $wpdb,$zController;		
		$table = $wpdb->prefix . 'shk_user';	
		$sql = "SELECT u.* FROM {$table} u where u.username =  '".$username."' " ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function getUserById($id){	
		global $wpdb,$zController;		
		$id=(int)($id);
		$table = $wpdb->prefix . 'shk_user';	
		$sql = "SELECT u.* FROM {$table} u where u.id =  " . $id ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function checkLogin($username,$password){	
		global $wpdb,$zController;
		$log=false;		
		$table = $wpdb->prefix . 'shk_user';	
		$sql = "SELECT u.* FROM {$table} u where u.username =  '".$username."' and  u.password = '".$password."' " ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		if(count($result)>0)
			$log=true;		
		return $log;
	}
	public function update_password(){		
		global $zController, $wpdb;		 
		$table = $wpdb->prefix . 'shk_user';		    
	    $password=md5($_POST["password"]) ; 
	    $id=$_POST["id"];  	     
		$query = "UPDATE {$table} set `password` = %s where `id` = %d ";
		$info = $wpdb->prepare($query,$password,$id);				
		$wpdb->query($info);		
	}
	public function update_item(){		
		global $zController, $wpdb;		 
		$table = $wpdb->prefix . 'shk_user';		
		$id=$_POST["id"];  			
		$password=md5($_POST["password"]) ;
		$email=trim($_POST["email"]);
	    $fullname=trim($_POST["fullname"]);
	    $address=trim($_POST["address"]);
	    $phone=trim($_POST["phone"]);
	    $mobilephone=trim($_POST["mobilephone"]);
	    $fax=trim($_POST["fax"]);   		    
	    if(!empty($_POST["password"])){
	    	$query = "UPDATE {$table} set `password`= %s , `email` = %s, `fullname` = %s, `address` = %s, `phone` = %s, `mobilephone` = %s , `fax` = %s where `id` = %d ";
		$info = $wpdb->prepare($query,$password,$email,$name,$address,$phone,$mobilephone,$fax,$id
			);
	    }else{
	    	$query = "UPDATE {$table} set `email` = %s, `fullname` = %s, `address` = %s, `phone` = %s, `mobilephone` = %s , `fax` = %s where `id` = %d ";
		$info = $wpdb->prepare($query,$email,$fullname,$address,$phone,$mobilephone,$fax,$id
			);
	    }						
		$wpdb->query($info);		
	}
	public function save_item(){		
		global $zController, $wpdb;		 
		$table = $wpdb->prefix . 'shk_user';	
		$username=trim($_POST["username"]);
		$password=md5($_POST["password"]) ;
		$email=trim($_POST["email"]);
	    $fullname=trim($_POST["fullname"]);
	    $address=trim($_POST["address"]);
	    $phone=trim($_POST["phone"]);
	    $mobilephone=trim($_POST["mobilephone"]);
	    $fax=trim($_POST["fax"]);  
	    $status=1;
	    $sort_order=1;
	    
		$query = "INSERT INTO {$table} (`username`, `password`,`email`, `fullname`, `address`, `phone`, `mobilephone`, `fax`,`status`,`sort_order`) VALUES
(%s,%s,%s,%s,%s,%s,%s,%s,%d,%d)";
		$info = $wpdb->prepare($query,
			$username,$password,$email,$fullname,$address,$phone,$mobilephone,$fax,$status,$sort_order
			);				
		$wpdb->query($info);		
	}
}