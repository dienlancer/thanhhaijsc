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
			case "confirmed-checkout"		:	$this->confirmedCheckout();break;
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
				$arrCart = @$ssCart->get($ssValue)['cart'];		
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
				$cart['cart']=$arrCart;		
				$ssCart->set($ssValue,$cart);
				if(count($arrCart)==0){					
					$ssCart->reset();
				}
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
		$arrCart = @$ssCart->get($ssValue)['cart'];	
		unset($arrCart[$id]);				
		$cart['cart']=$arrCart;
		$ssCart->set($ssValue,$cart);
		if(count($arrCart)==0){					
			$ssCart->reset();
		}
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
				$username=trim(@$_POST["username"]);
				$password=@$_POST["password"] ;
				$password_confirmed=@$_POST["password_confirmed"] ;
				$email=trim(@$_POST["email"]) ;		
				$fullname=trim(@$_POST["fullname"]);	
				$address=trim(@$_POST["address"]);
				$phone=trim(@$_POST["phone"]);			
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
					$msg["fullname"] = 'Họ tên phải từ 15 ký tự trở lên';    
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
					$query = "INSERT INTO {$tbuser} (`username`, `password`,`email`, `fullname`, `address`, `phone`,`status`) VALUES
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
					$user=array("user_info"=>array("username" => $username,"id"=>$id));
					$ssUser->set($ssValue,$user);	
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','account.php');						
					$permarlink = get_permalink($pageID);					
					$msg['success']='<span>Đăng ký tài khoản thành công.</span><span class="margin-left-5">Vui lòng xem thông tin tài khoản </span>  <span class="tai-dai"><a href="'.$permarlink.'">tại đây</a></span>';
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
				$email=trim(@$_POST["email"]) ;		
				$fullname=trim(@$_POST["fullname"]);	
				$address=trim(@$_POST["address"]);
				$phone=trim(@$_POST["phone"]);			
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
					$msg["fullname"] = 'Họ tên phải từ 15 ký tự trở lên';    
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
					$query = "UPDATE {$tbuser} set `email` = %s, `fullname` = %s, `address` = %s, `phone` = %s where `id` = %d ";
					$info = $wpdb->prepare($query,$email,$fullname,$address,$phone,$id);			
					$wpdb->query($info);		
					$model = $zController->getModel("/frontend","UserModel");
					$info=$model->getUserById($id);									
					$username=@$info[0]["username"];
					$ssName="vmuser";
					$ssValue="userlogin";
					$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);		
					$ssUser->reset();					
					$user=array("user_info"=>array("username" => $username,"id"=>$id));
					$ssUser->set($ssValue,$user);	
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','account.php');						
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
		global $zController,$wpdb;		
		$checked=1;
		$msg=array();
		$data=array();							
		if($zController->isPost()){				
			$action = @$zController->getParams('action');					
			if(check_admin_referer(@$action,'security_code')){	
				$data=@$_POST;
				$id=(int)(@$_POST["id"]);			
				$password=@$_POST["password"] ;
				$password_confirmed=@$_POST["password_confirmed"] ;				
				$tbuser = $wpdb->prefix . 'shk_user';								
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
				if((int)@$checked==1){					
					$query = "UPDATE {$tbuser} set `password` = %s where `id` = %d ";
					$info = $wpdb->prepare($query,md5($password),$id);								
					$wpdb->query($info);							
					$msg['success']='<span>Cập nhật mật khẩu thành công</span>';
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
					$user=array("user_info"=>array("username" => $username,"id"=>$id));
					$ssUser->set($ssValue,$user);	
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','account.php');		
					$permarlink = get_permalink($pageID);							
					wp_redirect($permarlink);					
				}else{
					$msg["exception_error"]='Đăng nhập không thành công'; 	
					$checked=0;	
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
		$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','checkout.php');
		$permarlink = get_permalink($pageID);					
		wp_redirect($permarlink);				
	}
	public function confirmedCheckout(){
		global $zController,$wpdb;	
		$vHtml=new HtmlControl(); 	
		$checked=1;
		$msg=array();
		$data=array();			
		$total_price=0;
		$total_quantity=0;				
		if($zController->isPost()){				
			$action = @$zController->getParams('action');					
			if(check_admin_referer(@$action,'security_code')){	
				$data 					=	@$_POST;								
				$email 					=	trim(@$_POST["email"]) ;	
				$fullname 				=	trim(@$_POST['fullname']);
				$address 				=	trim(@$_POST['address']);
				$phone 					=	trim(@$_POST['phone']);
				$note					=	trim(@$_POST['note']);
				$payment_method_id		=	trim(@$_POST["payment_method_id"]);		
				$total_price 			=	(float)@$_POST['total_price'];
				$total_quantity 			=	(float)@$_POST['total_quantity'];									
				if(!preg_match("#^[a-z][a-z0-9_\.]{4,31}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#",  mb_strtolower(trim(@$email),'UTF-8')  )){
					$msg["email"] = 'Email không hợp lệ';
					$data["email"] = '';
					$checked=0;
				}					
				if(mb_strlen(@$fullname) < 15){
					$msg["fullname"] = 'Họ tên phải từ 15 ký tự trở lên';    
					$data['fullname']='';        
					$checked = 0;
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
				}
				if((int)@$payment_method_id==0){
                  $msg["payment_method_id"] 	= 'Xin vui lòng chọn phương thức thanh toán';
                  $data["payment_method_id"] 	= 0;                  
                  $checked=0;
                }												
		        if((int)@$checked==1){									                	
                	$tableInvoice 		= $wpdb->prefix . 'shk_invoice';
                	$tableInvoiceDetail = $wpdb->prefix . 'shk_invoice_detail';
                	$invoice_code=$vHtml->randomString(10);	    
                	$created_date=date("Y-m-d H:i:s",time());
                	$status=0;                	                	                	                                	
                	$query = "INSERT INTO {$tableInvoice} (
                	`code`,                	
                	`created_date`,                	
                	`email`,
                	`fullname`,
                	`address`,
                	`phone`,	
                	`note`,		  
                	`payment_method_id`,
                	`quantity`,
                	`total_price`,
                	`status`
                	) VALUES
                	(
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
	                	$created_date,	  	                	
	                	$email,
	                	$fullname,
	                	$address,
	                	$phone,			 
	                	$note, 
	                	$payment_method_id,
	                	$total_quantity,
	                	$total_price,
	                	$status
	                );						
	                $wpdb->query($info);	

	                $sql = "SELECT max(p.id)  as invoice_id  FROM {$tableInvoice} p" ;
	                $result = $wpdb->get_results($sql,ARRAY_A);	
	                $invoice_id=(int)@$result[0]["invoice_id"];

	                $ssName="vmart";
	                $ssValue="zcart";
	                $ss     = $zController->getSession('SessionHelper',$ssName,$ssValue);
	                $arrCart = $ss->get($ssValue)['cart'];       			                
					$tr_cart='';	 					      
	                foreach ($arrCart as $key => $value) {
						$product_id=(int)@$value["product_id"];
						$product_sku=@$value["product_sku"];
						$product_name=@$value["product_name"];			
						$product_image=@$value["product_image"];			
						$product_price=(float)@$value["product_price"];			
						$product_quantity=(int)@$value["product_quantity"];			
						$product_total_price=(float)@$value["product_total_price"];							
						$tr_cart .='<tr>';
							$tr_cart .='<td>'.$product_sku.'</td>';
							$tr_cart .='<td>'.$product_name.'</td>';                          
							$tr_cart .='<td align="right">'.$vHtml->fnPrice($product_price).' đ</td>';
							$tr_cart .='<td align="right">'.$product_quantity.'</td>';
							$tr_cart .='<td align="right">'.$vHtml->fnPrice($product_total_price).' đ</td>';
							$tr_cart .='</tr>';  		
						$query = "INSERT INTO {$tableInvoiceDetail} (
							  `invoice_id`,
							  `product_id`,
							  `product_sku`,
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
							  $product_sku,
							  $product_name,  
							  $product_image,  
							  $product_price,  
							  $product_quantity,  
							  $product_total_price
							);
						$wpdb->query($info);
					}
					$file_php_mailer=PLUGIN_PATH . "scripts" . DS . "phpmailer" . DS . "PHPMailerAutoload.php"	;
					require_once $file_php_mailer;
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
					$contacted_name = 	@$data['contacted_name'];	
					/* begin phương thức thanh toán */
					$payment_method_name='';
					$payment_method_content='';
					$args=array(
						"p"=>$payment_method_id,
						"post_type"=>"payment_method"
					);
					$the_query = new WP_Query( $args );
					if($the_query->have_posts()){
						while ($the_query->have_posts()) {
							$the_query->the_post();
							$payment_method_id=$the_query->post->ID;
							$payment_method_name=get_the_title($payment_method_id);
							$payment_method_content=get_the_content($payment_method_id);	            												
						}
						wp_reset_postdata();    
					}		
					$ordered_date= $zController->getHelper('DateTimeConverter')->datetimeConverterVn($created_date);
					/* end phương thức thanh toán */		
					$mail = new PHPMailer(true);
					$mail->SMTPDebug = 0;                           
					$mail->isSMTP();     
					$mail->CharSet = "UTF-8";          
					$mail->Host = $smtp_host; 
					$mail->SMTPAuth = $smtp_auth;                         
					$mail->Username = $smtp_username;             
					$mail->Password = $smtp_password;             
					$mail->SMTPSecure = $encription;                       
					$mail->Port = $smtp_port;                            
					$mail->setFrom('dienit02@gmail.com', get_bloginfo( 'name' ));
					$mail->addAddress($email_to, $contacted_name);
					$mail->addAddress($email, $fullname);   
					$mail->Subject = 'Thông tin đặt hàng từ '.$fullname.' - '.$phone ;   
					
					$html_content='';     
					$html_content .='<div><center><h2>THÔNG TIN KHÁCH HÀNG</h2></center</div>';   
					$html_content .='<table border="1"  cellspacing="5" cellpadding="5" width="100%">';					
					$html_content .='<tbody>';
					$html_content .='<tr><td width="20%">Mã số đơn hàng</td><td width="80%">'.$invoice_code.'</td></tr>';
					$html_content .='<tr><td>Ngày đặt hàng</td><td>'.$ordered_date.'</td></tr>';
					$html_content .='<tr><td>Họ và tên</td><td>'.$fullname.'</td></tr>';
					$html_content .='<tr><td>Email</td><td>'.$email.'</td></tr>';
					$html_content .='<tr><td>Điện thoại</td><td>'.$phone.'</td></tr>';      
					$html_content .='<tr><td>Phương thức thanh toán</td><td>'.$payment_method_name.'</td></tr>';      
					$html_content .='<tr><td>Nội dung thanh toán</td><td>'.$payment_method_content.'</td></tr>';              
					$html_content .='<tr><td>Địa chỉ</td><td>'.$address.'</td></tr>';
					$html_content .='<tr><td>Nội dung</td><td>'.$note.'</td></tr>';   
					$html_content .='<tr><td>Số lượng</td><td>'.$total_quantity.'</td></tr>';   
					$html_content .='<tr><td>Thành tiền</td><td>'.$vHtml->fnPrice($total_price).' đ</td></tr>';          
					$html_content .='</tbody>';
					$html_content .='</table>';  
					$html_content .='<div style="margin-top:20px"><center><h2>DANH SÁCH MẶT HÀNG</h2></center</div>';   
					$html_content .='<table border="1" cellspacing="5"  cellpadding="5" width="100%">';
					$html_content .='<thead>';
					$html_content .='<tr>';
					$html_content .='<th>Mã sản phẩm</th>';
					$html_content .='<th>Tên sản phẩm</th>';              
					$html_content .='<th>Đơn giá</th>';
					$html_content .='<th>Số lượng đặt mua</th>';
					$html_content .='<th>Tổng giá</th>';
					$html_content .='</tr>';
					$html_content .='</thead>';
					$html_content .='<tbody>';
					$html_content .=$tr_cart;
					$html_content .='</tbody>';
					$html_content .='</table>';                                 
					$mail->msgHTML($html_content);
					$mail->Send();                     					
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
			$action = @$zController->getParams('action');					
			if(check_admin_referer(@$action,'security_code')){	
				$data=@$_POST;
				$username=trim(@$_POST["username"]);
				$password=@$_POST["password"] ;
				$password_confirmed=@$_POST["password_confirmed"] ;
				$email=trim(@$_POST["email"]) ;		
				$fullname=trim(@$_POST["fullname"]);	
				$address=trim(@$_POST["address"]);
				$phone=trim(@$_POST["phone"]);			
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
					$msg["fullname"] = 'Họ tên phải từ 15 ký tự trở lên';    
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
					$query = "INSERT INTO {$tbuser} (`username`, `password`,`email`, `fullname`, `address`, `phone`,`status`) VALUES
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
					$user=array("user_info"=>array("username" => $username,"id"=>$id));
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
					$user=array("user_info"=>array("username" => $username,"id"=>$id));
					$ssUser->set($ssValue,$user);	
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','checkout.php');	
					$permarlink = get_permalink($pageID);							
					wp_redirect($permarlink);					
				}else{
					$msg["exception_error"]='Đăng nhập không thành công'; 	
					$checked=0;	
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
					$file_php_mailer=PLUGIN_PATH . "scripts" . DS . "phpmailer" . DS . "PHPMailerAutoload.php"	;
					require_once $file_php_mailer;		        
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
					$file_php_mailer=PLUGIN_PATH . "scripts" . DS . "phpmailer" . DS . "PHPMailerAutoload.php"	;
					require_once $file_php_mailer;		        
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
					$file_php_mailer=PLUGIN_PATH . "scripts" . DS . "phpmailer" . DS . "PHPMailerAutoload.php"	;
					require_once $file_php_mailer;		        
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