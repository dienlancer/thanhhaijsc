<?php
class ProductController{	
	private $_errors = array();	
	private $_data = array();	
	public function __construct(){	
		$this->dispath_function();
	}	
	public function dispath_function(){
		global $zController;
		$action = $zController->getParams('action');		
		switch ($action){									
			case "update-cart"			: 	$this->updateCart();break;			
			case "delete"				: 	$this->deleteCart();break;			
			case "delete-all"			: 	$this->deleteAll();break;
			case "register-member"		: 	$this->registerMember();break;
			case "change-info"			: 	$this->changeInfo();break;
			case "login"				: 	$this->login();break;
			case "logout"				:	$this->logout();break;
			case "checkout"				:	$this->checkout();break;
			case "confirm-checkout"		:	$this->confirmCheckout();break;
			case "register-checkout"	:	$this->registerCheckout();break;
			case "login-checkout"		:	$this->loginCheckout();break;
			case "change-password"		:	$this->changePassword();break;
			case "booking"				:	$this->booking();break;
			case "reservation"			:	$this->reservation();break;
			case "contact"				:	$this->contact();break;
		}		
	}		
	public function updateCart(){		
		global $zController;	
		if($zController->isPost()){
			$action = $zController->getParams('action');		
			if(check_admin_referer($action,'security_code')){
				$arrQTY=$_POST["quantity"];		
				$ssName="vmart";
				$ssValue="zcart";				
				$ssCart 	= $zController->getSession('SessionHelper',$ssName,$ssValue);
				$arrCart = @$ssCart->get($ssValue);		
				foreach ($arrCart as $key => $value) {		
					$product_quantity=(int)$arrQTY[$key];
					$product_price = (float)$arrCart[$key]["product_price"];
					$product_total_price=$product_quantity * $product_price;
				 	$arrCart[$key]["product_quantity"]=$product_quantity;
				 	$arrCart[$key]["product_total_price"]=$product_total_price;
				}
				foreach ($arrCart as $key => $value) {
					$product_quantity=(int)$arrCart[$key]["product_quantity"];
					if($product_quantity==0)
						unset($arrCart[$key]);
				}
				$cart=$arrCart;
				$ssCart->set($ssValue,$cart);
				if(empty($arrCart))
					$ssCart->reset();
				$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');	
				$permarlink = get_permalink($pageID);
				wp_redirect($permarlink);
			}						
		}				
	}	
	public function deleteCart(){
		global $zController;	
		$id=(int)($zController->getParams("id"));								
		$ssName="vmart";
		$ssValue="zcart";				
		$ssCart 	= $zController->getSession('SessionHelper',$ssName,$ssValue);
		$arrCart = @$ssCart->get($ssValue);	
		unset($arrCart[$id]);				
		$cart=$arrCart;
		$ssCart->set($ssValue,$cart);
		if(empty($arrCart))
			$ssCart->reset();
		$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');	
		$permarlink = get_permalink($pageID);
		wp_redirect($permarlink);
	}	
	public function deleteAll(){
		global $zController;				
		$ssName="vmart";
		$ssValue="zcart";				
		$ssCart 	= $zController->getSession('SessionHelper',$ssName,$ssValue);				
		$ssCart->reset();		
		$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');	
		$permarlink = get_permalink($pageID);
		wp_redirect($permarlink);
	}
	public function registerMember(){
		global $zController,$wpdb;		
		$checked=1;
		$msg=array();
		$data=array();							
		if($zController->isPost()){				
			$action = @$zController->getParams('action');					
			if(check_admin_referer(@$action,'security_code')){	
				$data=@$_POST;
				$username=@$_POST["username"];
				$password=@$_POST["password"] ;
				$password_confirmed=@$_POST["password_confirmed"] ;
				$email=@$_POST["email"] ;		
				$fullname=@$_POST["fullname"];	
				$address=@$_POST["address"];
				$phone=@$_POST["phone"];			
				$tbuser = $wpdb->prefix . 'shk_user';				
				if(mb_strlen(@$username) < 6){
					$msg["username"] = 'Username phải từ 6 ký tự trở lên';
					$data["username"] = "";	
					$checked=0;
				}elseif(!preg_match("#^[a-z_][a-z0-9_\.\s]{4,31}$#",  mb_strtolower(trim(@$username),'UTF-8')   )){
					$msg["username"] = 'Username không hợp lệ';
					$data["username"] = "";	
					$checked=0;
				}else{
					$query =" 
					SELECT u.id
					FROM 
					{$tbuser} u
					WHERE lower(trim(u.username)) = '".mb_strtolower(trim(@$username),'UTF-8')."'
					";					
					$lst = $wpdb->get_results($query,ARRAY_A);		
					if(count(@$lst) > 0){
						$msg["username"] = 'Username đã tồn tại';
						$data["username"] = '';
						$checked=0;
					}
				}	
				if(mb_strlen(@$password) < 10 ){
					$msg["password"] = "Mật khẩu tối thiểu phải 10 ký tự";
					$data['password']='';
					$data['password_confirmed']='';
					$checked = 0;                
				}else{
					if(strcmp(@$password, @$password_confirmed) !=0 ){
						$msg["password"] = "Xác nhận mật khẩu không trùng khớp";
						$data['password']='';
						$data['password_confirmed']='';
						$checked = 0;                  
					}
				}  
				if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",  mb_strtolower(trim(@$email),'UTF-8')  )){
					$msg["email"] = 'Email không hợp lệ';
					$data["email"] = '';
					$checked=0;
				}else{
						
					$query ="SELECT u.id
					FROM 
					`".$tbuser."` u
					WHERE lower(trim(u.email)) = '".mb_strtolower(trim(@$email),'UTF-8')."'
					";								
					$lst = $wpdb->get_results($query,ARRAY_A);		
					if(count($lst) > 0){
						$msg["email"] = 'Email đã tồn tại';
						$data["email"] = '';
						$checked=0;
					}
				}								
				if(mb_strlen($fullname) < 15){
					$msg["fullname"] = 'Tên công ty phải từ 15 ký tự trở lên';    
					$data['fullname']='';        
					$checked = 0;
				}else{
								
					$query ="SELECT u.id
					FROM 
					`".$tbuser."` u
					WHERE lower(trim(u.fullname)) = '".mb_strtolower(trim(@$fullname),'UTF-8')."'
					";								
					$lst = $wpdb->get_results($query,ARRAY_A);		
					if(count($lst) > 0){
						$msg["fullname"] = 'Họ tên đã tồn tại';
						$data["fullname"] = '';
						$checked=0;
					}
				}
				if(mb_strlen($address) < 15){
					$msg["address"] = 'Địa chỉ phải từ 15 ký tự trở lên';      
					$data['address']='';      
					$checked = 0;
				}   
				if(mb_strlen($phone) < 10){
					$msg["phone"] = 'Điện thoại công ty phải từ 10 ký tự trở lên';   
					$data['phone']='';         
					$checked = 0;
				}else{							
					$query ="SELECT u.id
					FROM 
					`".$tbuser."` u
					WHERE lower(trim(u.phone)) = '".mb_strtolower(trim(@$phone),'UTF-8')."'
					";								
					$lst = $wpdb->get_results($query,ARRAY_A);		
					if(count($lst) > 0){
						$msg["phone"] = 'Số điện thoại đã tồn tại';
						$data["phone"] = '';
						$checked=0;
					}
				}													
				if((int)@$checked==1){
					$table = $wpdb->prefix . 'shk_user';	
					$query = "INSERT INTO {$table} (`username`, `password`,`email`, `fullname`, `address`, `phone`,`status`) VALUES
					(%s,%s,%s,%s,%s,%s,%d)";
					$info = $wpdb->prepare($query,
						$username,md5($password),$email,$fullname,$address,$phone,1
					);				
					$wpdb->query($info);		
					$model = $zController->getModel("/frontend","UserModel");
					$info=$model->getUserByUsername($username);					
					$id=(int)$info[0]["id"];	
					$ssName="vmuser";
					$ssValue="userlogin";
					$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);		
					$ssUser->reset();					
					$user=array("username" => $username,"id"=>$id);
					$ssUser->set($ssValue,$user);	
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','account.php');	
					echo '<script language="javascript" type="text/javascript">alert("Đăng ký thành công")</script';
					$permarlink = get_permalink($pageID);
					wp_redirect($permarlink);				
				}
			}
		}	
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;			
	}
	public function changeInfo(){
		global $zController,$wpdb;		
		$checked=1;
		$msg=array();
		$data=array();							
		if($zController->isPost()){				
			$action = @$zController->getParams('action');					
			if(check_admin_referer(@$action,'security_code')){	
				$data=@$_POST;
				$id=(int)(@$_POST["id"]);					
				$email=@$_POST["email"] ;		
				$fullname=@$_POST["fullname"];	
				$address=@$_POST["address"];
				$phone=@$_POST["phone"];			
				$tbuser = $wpdb->prefix . 'shk_user';											
				if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",  mb_strtolower(trim(@$email),'UTF-8')  )){
					$msg["email"] = 'Email không hợp lệ';
					$data["email"] = '';
					$checked=0;
				}else{						
					$query ="SELECT u.id
					FROM 
					`".$tbuser."` u
					WHERE lower(trim(u.email)) = '".mb_strtolower(trim(@$email),'UTF-8')."' and u.id != '".$id."'
					";								
					$lst = $wpdb->get_results($query,ARRAY_A);		
					if(count($lst) > 0){
						$msg["email"] = 'Email đã tồn tại';
						$data["email"] = '';
						$checked=0;
					}
				}								
				if(mb_strlen(@$fullname) < 15){
					$msg["fullname"] = 'Tên công ty phải từ 15 ký tự trở lên';    
					$data['fullname']='';        
					$checked = 0;
				}else{
								
					$query ="SELECT u.id
					FROM 
					`".$tbuser."` u
					WHERE lower(trim(u.fullname)) = '".mb_strtolower(trim(@$fullname),'UTF-8')."' and u.id != '".$id."'
					";								
					$lst = $wpdb->get_results($query,ARRAY_A);		
					if(count($lst) > 0){
						$msg["fullname"] = 'Họ tên đã tồn tại';
						$data["fullname"] = '';
						$checked=0;
					}
				}
				if(mb_strlen(@$address) < 15){
					$msg["address"] = 'Địa chỉ phải từ 15 ký tự trở lên';      
					$data['address']='';      
					$checked = 0;
				}   
				if(mb_strlen(@$phone) < 10){
					$msg["phone"] = 'Điện thoại công ty phải từ 10 ký tự trở lên';   
					$data['phone']='';         
					$checked = 0;
				}else{							
					$query ="SELECT u.id
					FROM 
					`".$tbuser."` u
					WHERE lower(trim(u.phone)) = '".mb_strtolower(trim(@$phone),'UTF-8')."' and u.id != '".$id."'
					";								
					$lst = $wpdb->get_results($query,ARRAY_A);		
					if(count($lst) > 0){
						$msg["phone"] = 'Số điện thoại đã tồn tại';
						$data["phone"] = '';
						$checked=0;
					}
				}													
				if((int)@$checked==1){
					$table = $wpdb->prefix . 'shk_user';						
					$query = "UPDATE {$table} set `email` = %s, `fullname` = %s, `address` = %s, `phone` = %s where `id` = %d ";
					$info = $wpdb->prepare($query,$email,$fullname,$address,$phone,$id);			
					$wpdb->query($info);		
					$model = $zController->getModel("/frontend","UserModel");
					$info=$model->getUserById($id);									
					$username=@$info[0]["username"];
					$ssName="vmuser";
					$ssValue="userlogin";
					$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);		
					$ssUser->reset();					
					$user=array("username" => $username,"id"=>$id);
					$ssUser->set($ssValue,$user);	
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','account.php');	
					echo '<script language="javascript" type="text/javascript">alert("Cập nhật thành công")</script';
					$permarlink = get_permalink($pageID);
					wp_redirect($permarlink);				
				}
			}
		}	
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;							
	}
	public function changePassword(){
		global $zController;
		$checked=1;
		$msg=array();
		$data=array();
		
		if($zController->isPost()){		
			$action = $zController->getParams('action');		
			if(check_admin_referer($action,'security_code')){	
				$data=$_POST;
				$id=(int)$_POST["id"];
				$username=$_POST["username"];
				$password=mb_strtolower($_POST["password"],'UTF-8') ;
                $password_confirmed=mb_strtolower($_POST["password_confirmed"],'UTF-8') ;     
                if(mb_strlen($password) < 6){
                  $msg["password"] = 'Mật khẩu phải từ 6 ký tự trở lên';
                  $data["password"] = "";
                  $data["password_confirmed"] = ""; 
                  $checked=0;
                }
                if(strcmp($password, $password_confirmed)!=0){
                  $msg["password_confirmed"] = 'Mật khẩu và mật khẩu xác nhận phải trùng khớp';
                  $data["password_confirmed"] = "";   
                  $checked=0;
                }    
                if((int)@$checked==1){
                   	$model = $zController->getModel("/frontend","UserModel");
					$model->update_password();        
					$ssName="vmuser";
					$ssValue="userlogin";
					$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);			
					$user=array("username" => $username,"id"=>$id);
					$ssUser->set($ssValue,$user);	
					$checked['success']='Cập nhật thành công'; 					                                              
                }                   
			}
		}			
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;				
	}
	public function login(){	
		global $zController;					
		$checked=1;
		$msg=array();
		$data=array();
			
		if($zController->isPost()){	
			$action = $zController->getParams('action');
			if(check_admin_referer($action,'security_code')){
				$data=$_POST;
				$username=trim($_POST["username"]);		
				$password=md5($_POST["password"]);					
				$model = $zController->getModel("/frontend","UserModel");		 
				if($model->checkLogin($username,$password)){					
					$info=$model->getUserByUsername($username);
					$id=(int)$info[0]["id"];	
					$ssName="vmuser";
					$ssValue="userlogin";
					$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);			
					$user=array("username" => $username,"id"=>$id);
					$ssUser->set($ssValue,$user);	
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','account.php');		
					$permarlink = get_permalink($pageID);							
					wp_redirect($permarlink);					
				}else{
					$msg["exception_error"]='Đăng nhập không thành công'; 		
				}	
			}					
		}			
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;					
	}	
	public function logout(){
		global $zController;					
		$ssName="vmuser";
		$ssValue="userlogin";
		$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);	
		$ssUser->reset();
		wp_redirect(site_url());			
	}
	public function checkout(){
		global $zController;	
		$permarlink="";
		$pageID=0;				
		$ssName="vmuser";
		$ssValue="userlogin";
		$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);	
		$arrUser 	= @$ssUser->get($ssValue);	
		if(empty($arrUser)){
			$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','login-checkout.php');	
		}
		else{
			$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','checkout.php');	
		}
		$permarlink = get_permalink($pageID);			
		wp_redirect($permarlink);				
	}
	public function confirmCheckout(){
		global $zController,$wpdb;		
		$checked=1;
		$msg=array();
		$data=array();
		
		if($zController->isPost()){
			$action = $zController->getParams('action');
			if(check_admin_referer($action,'security_code')){	
				$data=$_POST;
				$email 					=		mb_strtolower(trim($_POST["email"]),'UTF-8') ;	
				$payment_method			=		mb_strtolower(trim($_POST["payment_method"]),'UTF-8');	
				if(empty($email)){
                  $msg["email"] 	= 		'Xin vui lòng nhập email';
                  $data["email"] 	= 		"";                  
                  $checked=0;
                }
                if((int)$payment_method==0){
                  $msg["payment_method"] 	= 'Xin vui lòng nhập phương thức thanh toán';
                  $data["payment_method"] 	= "";                  
                  $checked=0;
                }
				// kiểm tra email hợp lệ			
				if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",$email )){
					$msg["email"] 	= 'Email không hợp lệ';
					$data["email"] 	= '';
					$checked=0;
				}								
				$id=(int)($_POST["user_id"]);
				$tbuser = $wpdb->prefix . 'shk_user';			
				$query ="SELECT u.id
						FROM 
						`".$tbuser."` u
						WHERE lower(trim(u.email)) = '".$email."' and u.id != '".$id."'
					";								
				$lst = $wpdb->get_results($query,ARRAY_A);		
				if(count($lst) > 0){
					$msg["email"] = 'Email đã tồn tại';
					$data["email"] = '';
					$checked=0;
				}					
				if((int)@$checked==1){
					$invoiceModel = $zController->getModel("/frontend","InvoiceModel");		 
					$invoiceModel->createBill();				
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','finished-checkout.php');	
					$permarlink = get_permalink($pageID);										
					wp_redirect($permarlink);	
				}						
			}
		}	
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;			
	}
	public function registerCheckout(){
		global $zController,$wpdb;		
		$checked=1;
		$msg=array();
		$data=array();
			
		if($zController->isPost()){		
			$action = $zController->getParams('action');		
			if(check_admin_referer($action,'security_code')){	
				$data=$_POST;
				$email=trim($_POST["email"]) ;
				$username=trim($_POST["username"]) ;
				$password=$_POST["password"] ;
				$password_confirmed=$_POST["password_confirmed"] ;						
				if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",mb_strtolower($email,"UTF-8")  )){
					$msg["email"] = 'Email không hợp lệ';
					$data["email"] = '';
					$checked=0;
				}
				if(!preg_match("#^[a-z_][a-z0-9_\.\s]{4,31}$#",mb_strtolower($username,'UTF-8') )){
					$msg["username"] = 'Username không hợp lệ';
					$data["username"] = "";	
					$checked=0;
				}
				if(mb_strlen($password) < 6){
					$msg["password"] = 'Mật khẩu phải từ 6 ký tự trở lên';
					$data["password"] = "";
					$data["password_confirmed"] = "";	
					$checked=0;
				}
				if(strcmp($password, $password_confirmed)!=0){
					$msg["password_confirmed"] = 'Mật khẩu và mật khẩu xác nhận phải trùng nhau';
					$data["password_confirmed"] = "";		
					$checked=0;
				}			
				$tbuser = $wpdb->prefix . 'shk_user';			
				$query ="SELECT u.id
						FROM 
						`".$tbuser."` u
						WHERE lower(trim(u.email)) = '".mb_strtolower($email,'UTF-8')."'
					";								
				$lst = $wpdb->get_results($query,ARRAY_A);		
				if(count($lst) > 0){
					$msg["email"] = 'Email đã tồn tại';
					$data["email"] = '';
					$checked=0;
				}
				$query =" 
						SELECT u.id
						FROM 
						`".$tbuser."` u
						WHERE lower(trim(u.username)) = '".mb_strtolower($username,'UTF-8')."'
					";					
				$lst = $wpdb->get_results($query,ARRAY_A);		
				if(count($lst) > 0){
					$msg["username"] = 'Username đã tồn tại';
					$data["username"] = '';
					$checked=0;
				}				
				if((int)@$checked==1){					
					$model = $zController->getModel("/frontend","UserModel");
					$model->save_item();
					$username=trim($_POST["username"]);	
					$info=$model->getUserByUsername($username);					
					$id=(int)$info[0]["id"];	
					$ssName="vmuser";
					$ssValue="userlogin";
					$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);			
					$user=array("username" => $username,"id"=>$id);
					$ssUser->set($ssValue,$user);
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','checkout.php');	
					$permarlink = get_permalink($pageID);									
					wp_redirect($permarlink);				
				}
			}
		}
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;			
	}
	public function loginCheckout(){			
		global $zController;	
		$checked=1;
		$msg=array();
		$data=array();
					
		if($zController->isPost()){	
			$action = $zController->getParams('action');
			if(check_admin_referer($action,'security_code')){
				$data=$_POST;
				$username=trim($_POST["username"]);		
				$password=md5($_POST["password"]);					
				$model = $zController->getModel("/frontend","UserModel");		 
				if($model->checkLogin($username,$password)){			
					$info=$model->getUserByUsername($username);
					$id=(int)$info[0]["id"];	
					$ssName="vmuser";
					$ssValue="userlogin";
					$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);			
					$user=array("username" => $username,"id"=>$id);
					$ssUser->set($ssValue,$user);
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','checkout.php');	
					$permarlink = get_permalink($pageID);	
					wp_redirect($permarlink);												
				}else{					
					$msg["exception_error"]='Đăng nhập không thành công'; 			
				}	
			}					
		}		
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;					
	}		
	public function contact(){
		global $zController,$wpdb;		
		$checked=1;
		$msg=array();
		$data=array();
			
		if($zController->isPost()){
			$action = $zController->getParams('action');			
			if(check_admin_referer($action,'security_code')){				
				$data=$_POST;
				
				$fullname 			=	trim(@$_POST["fullname"]);
				$email 				=	trim(@$_POST['email']);		
				$mobile 			=	trim(@$_POST['mobile']);
				$title 				=	trim(@$_POST['title']);
				$address 			=	trim(@$_POST['address']);
				$content 			=	trim(@$_POST["content"]);				

				if(mb_strlen($fullname) < 6){
					$msg["fullname"] = 'Họ tên phải chứa từ 6 ký tự trở lên';
					$data["fullname"] = "";					
					$checked=0;
				}
				if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",$email )){
					$msg["email"] = 'Email không hợp lệ';
					$data["email"] = '';
					$checked=0;
				}
				if(mb_strlen($mobile) < 10){
					$msg["mobile"] = 'Số điện thoại không hợp lệ';
					$data["mobile"] = "";					
					$checked=0;
				}
				if(empty($title)){
					$msg["title"] = 'Tiêu đề không hợp lệ';
					$data["title"] = "";					
					$checked=0;
				}		
				if(empty($address)){
					$msg["address"] = 'Địa chỉ không hợp lệ';
					$data["address"] = "";					
					$checked=0;
				}		
				if((int)@$checked==1){
					$data=array();
					$option_name = 'zendvn_sp_setting';
					$data = get_option('zendvn_sp_setting',array());				
					$smtp_host		= 	@$data['smtp_host'];
					$smtp_port		=	@$data['smtp_port'];
					$smtp_auth		=	@$data['smtp_auth'];
					$encription		=	@$data['encription'];
					$smtp_username	=	@$data['smtp_username'];
					$smtp_password	=	@$data['smtp_password'];		
					$email_to		=	@$data['email_to'];
					$contacted_name	=	@$data['contacted_name'];	
					$filePhpMailer=PLUGIN_PATH . "scripts" . DS . "phpmailer" . DS . "PHPMailerAutoload.php"	;
					require_once $filePhpMailer;		        
					$mail = new PHPMailer;      
					$mail->CharSet = "UTF-8";   
					$mail->isSMTP();             
					$mail->SMTPDebug = 2;
					$mail->Debugoutput = 'html';
					$mail->Host = @$smtp_host;
					$mail->Port = @$smtp_port;
					$mail->SMTPSecure = @$encription;
					$mail->SMTPAuth = (int)@$smtp_auth;
					$mail->Username = @$smtp_username;
					$mail->Password = @$smtp_password;
					$mail->setFrom(@$email, $fullname);
					$mail->addAddress(@$email_to, @$contacted_name);
					$mail->Subject = 'Thông tin liên lạc từ khách hàng '.$fullname.' - '.$mobile ;  
					$html_content='';     
					$html_content .='<table border="1" cellspacing="5" cellpadding="5">';
					$html_content .='<thead>';
					$html_content .='<tr>';
					$html_content .='<th colspan="2"><h3>Thông tin liên lạc từ khách hàng '.$fullname.'</h3></th>';
					$html_content .='</tr>';
					$html_content .='</thead>';
					$html_content .='<tbody>';

					$html_content .='<tr><td>Họ và tên</td><td>'.$fullname.'</td></tr>';
					$html_content .='<tr><td>Email</td><td>'.$email.'</td></tr>';
					$html_content .='<tr><td>Mobile</td><td>'.$mobile.'</td></tr>';
					$html_content .='<tr><td>Tiêu đề</td><td>'.$title.'</td></tr>';
					$html_content .='<tr><td>Địa chỉ</td><td>'.$address.'</td></tr>';
					$html_content .='<tr><td>Nội dung</td><td>'.$content.'</td></tr>';					

					$html_content .='</tbody>';
					$html_content .='</table>';												
					$mail->msgHTML($html_content);
					if ($mail->send()) {               	
						$checked['success']='Gửi thông tin hoàn tất'; 
						echo '<script language="javascript" type="text/javascript">alert("Gửi thông tin hoàn tất");</script>'; 
					}
					else{
						$msg["exception_error"]='Quá trình gửi dữ liệu gặp sự cố'; 
						echo '<script language="javascript" type="text/javascript">alert("Có sự cố trong quá trình gửi dữ liệu");</script>'; 
					}	
				}else{
					echo '<script language="javascript" type="text/javascript">alert("Vui lòng nhập đúng dữ liệu");</script>'; 
				}										
			}
		}			
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;			
	}
	public function booking(){
		global $zController,$wpdb;		
		$checked=1;
		$msg=array();
		$data=array();
			
		if($zController->isPost()){
			$action = $zController->getParams('action');			
			if(check_admin_referer($action,'security_code')){				
				$data=$_POST;
				
				$fullname 			=	trim(@$_POST["fullname"]);
				$email 				=	trim(@$_POST['email']);		
				$mobile 			=	trim(@$_POST['mobile']);
				$datebooking 		=	trim(@$_POST['datebooking']);
				$timebooking 		=	trim(@$_POST['timebooking']);
				$number_person 		=	trim(@$_POST["number_person"]);				

				if(mb_strlen($fullname) < 6){
					$msg["fullname"] = 'Họ tên phải chứa từ 6 ký tự trở lên';
					$data["fullname"] = "";					
					$checked=0;
				}
				if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",$email )){
					$msg["email"] = 'Email không hợp lệ';
					$data["email"] = '';
					$checked=0;
				}
				if(mb_strlen($mobile) < 10){
					$msg["mobile"] = 'Số điện thoại không hợp lệ';
					$data["mobile"] = "";					
					$checked=0;
				}
				if(empty($datebooking)){
					$msg["datebooking"] = 'Ngày đặt bàn không hợp lệ';
					$data["datebooking"] = "";					
					$checked=0;
				}
				if(empty($timebooking)){
					$msg["timebooking"] = 'Thời gian đặt bàn không hợp lệ';
					$data["timebooking"] = "";					
					$checked=0;
				}
				if((int)@$number_person == 0){
					$msg["number_person"] = 'Vui lòng chọn số lượng người tham dự';
					$data["number_person"] = "";					
					$checked=0;
				}				
				if((int)@$checked==1){
					$data=array();
					$option_name = 'zendvn_sp_setting';
					$data = get_option('zendvn_sp_setting',array());				
					$smtp_host		= 	@$data['smtp_host'];
					$smtp_port		=	@$data['smtp_port'];
					$smtp_auth		=	@$data['smtp_auth'];
					$encription		=	@$data['encription'];
					$smtp_username	=	@$data['smtp_username'];
					$smtp_password	=	@$data['smtp_password'];		
					$email_to		=	@$data['email_to'];
					$contacted_name	=	@$data['contacted_name'];	
					$filePhpMailer=PLUGIN_PATH . "scripts" . DS . "phpmailer" . DS . "PHPMailerAutoload.php"	;
					require_once $filePhpMailer;		        
					$mail = new PHPMailer;      
					$mail->CharSet = "UTF-8";   
					$mail->isSMTP();             
					$mail->SMTPDebug = 2;
					$mail->Debugoutput = 'html';
					$mail->Host = @$smtp_host;
					$mail->Port = @$smtp_port;
					$mail->SMTPSecure = @$encription;
					$mail->SMTPAuth = (int)@$smtp_auth;
					$mail->Username = @$smtp_username;
					$mail->Password = @$smtp_password;
					$mail->setFrom(@$email, $fullname);
					$mail->addAddress(@$email_to, @$contacted_name);
					$mail->Subject = 'Thông tin đặt bàn từ khách hàng '.$fullname.' - '.$mobile ;   
					$html_content='';     
					$html_content .='<table border="1" cellspacing="5" cellpadding="5">';
					$html_content .='<thead>';
					$html_content .='<tr>';
					$html_content .='<th colspan="2"><h3>Thông tin đặt bàn từ khách hàng '.$fullname.'</h3></th>';
					$html_content .='</tr>';
					$html_content .='</thead>';
					$html_content .='<tbody>';
					$html_content .='<tr><td>Họ và tên</td><td>'.$fullname.'</td></tr>';
					$html_content .='<tr><td>Email</td><td>'.$email.'</td></tr>';
					$html_content .='<tr><td>Mobile</td><td>'.$mobile.'</td></tr>';
					$html_content .='<tr><td>Ngày đặt</td><td>'.$datebooking.'</td></tr>';
					$html_content .='<tr><td>Vào lúc</td><td>'.$timebooking.'</td></tr>';
					$html_content .='<tr><td>Số lượng</td><td>'.$number_person.'</td></tr>';					
					$html_content .='</tbody>';
					$html_content .='</table>';							   				
					$mail->msgHTML($html_content);
					if ($mail->send()) {               	
						$checked['success']='Đặt bàn hoàn tất'; 
						echo '<script language="javascript" type="text/javascript">alert("Đặt bàn hoàn tất");</script>'; 
					}
					else{
						$msg["exception_error"]='Quá trình gửi dữ liệu gặp sự cố'; 
						echo '<script language="javascript" type="text/javascript">alert("Có sự cố trong quá trình gửi dữ liệu");</script>'; 
					}	
				}else{
					echo '<script language="javascript" type="text/javascript">alert("Vui lòng nhập đúng dữ liệu");</script>'; 
				}										
			}
		}			
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;			
	}
	public function reservation(){
		global $zController,$wpdb;		
		$checked=1;
		$msg=array();
		$data=array();
			
		if($zController->isPost()){
			$action = $zController->getParams('action');			
			if(check_admin_referer($action,'security_code')){				
				$data=$_POST;
				
				$fullname 			=	trim(@$_POST["fullname"]);
				$email 				=	trim(@$_POST['email']);		
				$mobile 			=	trim(@$_POST['mobile']);
				$datebooking 		=	trim(@$_POST['datebooking']);
				$timebooking 		=	trim(@$_POST['timebooking']);
				$number_person 		=	trim(@$_POST["number_person"]);
				$message 			=	trim(@$_POST["message"]);

				if(mb_strlen($fullname) < 6){
					$msg["fullname"] = 'Họ tên phải chứa từ 6 ký tự trở lên';
					$data["fullname"] = "";					
					$checked=0;
				}
				if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",$email )){
					$msg["email"] = 'Email không hợp lệ';
					$data["email"] = '';
					$checked=0;
				}
				if(mb_strlen($mobile) < 10){
					$msg["mobile"] = 'Số điện thoại không hợp lệ';
					$data["mobile"] = "";					
					$checked=0;
				}
				if(empty($datebooking)){
					$msg["datebooking"] = 'Ngày đặt bàn không hợp lệ';
					$data["datebooking"] = "";					
					$checked=0;
				}
				if(empty($timebooking)){
					$msg["timebooking"] = 'Thời gian đặt bàn không hợp lệ';
					$data["timebooking"] = "";					
					$checked=0;
				}
				if((int)@$number_person == 0){
					$msg["number_person"] = 'Vui lòng chọn số lượng người tham dự';
					$data["number_person"] = "";					
					$checked=0;
				}				
				if((int)@$checked==1){
					$data=array();
					$option_name = 'zendvn_sp_setting';
					$data = get_option('zendvn_sp_setting',array());				
					$smtp_host		= 	@$data['smtp_host'];
					$smtp_port		=	@$data['smtp_port'];
					$smtp_auth		=	@$data['smtp_auth'];
					$encription		=	@$data['encription'];
					$smtp_username	=	@$data['smtp_username'];
					$smtp_password	=	@$data['smtp_password'];		
					$email_to		=	@$data['email_to'];
					$contacted_name	=	@$data['contacted_name'];	
					$filePhpMailer=PLUGIN_PATH . "scripts" . DS . "phpmailer" . DS . "PHPMailerAutoload.php"	;
					require_once $filePhpMailer;		        
					$mail = new PHPMailer;      
					$mail->CharSet = "UTF-8";   
					$mail->isSMTP();             
					$mail->SMTPDebug = 2;
					$mail->Debugoutput = 'html';
					$mail->Host = @$smtp_host;
					$mail->Port = @$smtp_port;
					$mail->SMTPSecure = @$encription;
					$mail->SMTPAuth = (int)@$smtp_auth;
					$mail->Username = @$smtp_username;
					$mail->Password = @$smtp_password;
					$mail->setFrom(@$email, $fullname);
					$mail->addAddress(@$email_to, @$contacted_name);
					$mail->Subject = 'Thông tin đặt bàn từ khách hàng '.$fullname.' - '.$mobile ;   
					$html_content='';     
					$html_content .='<table border="1" cellspacing="5" cellpadding="5">';
					$html_content .='<thead>';
					$html_content .='<tr>';
					$html_content .='<th colspan="2"><h3>Thông tin đặt bàn từ khách hàng '.$fullname.'</h3></th>';
					$html_content .='</tr>';
					$html_content .='</thead>';
					$html_content .='<tbody>';
					$html_content .='<tr><td>Họ và tên</td><td>'.$fullname.'</td></tr>';
					$html_content .='<tr><td>Email</td><td>'.$email.'</td></tr>';
					$html_content .='<tr><td>Mobile</td><td>'.$mobile.'</td></tr>';
					$html_content .='<tr><td>Ngày đặt</td><td>'.$datebooking.'</td></tr>';
					$html_content .='<tr><td>Vào lúc</td><td>'.$timebooking.'</td></tr>';
					$html_content .='<tr><td>Số lượng</td><td>'.$number_person.'</td></tr>';	
					$html_content .='<tr><td>Message</td><td>'.$message.'</td></tr>';					
					$html_content .='</tbody>';
					$html_content .='</table>';							   				
					$mail->msgHTML($html_content);
					if ($mail->send()) {               	
						$checked['success']='Đặt bàn hoàn tất'; 
					}
					else{
						$msg["exception_error"]='Quá trình gửi dữ liệu gặp sự cố'; 
					}	
				}										
			}
		}			
		$zController->_data["data"] = $data;
		$zController->_data["msg"] = $msg;			
		$zController->_data["checked"] = $checked;			
	}
}