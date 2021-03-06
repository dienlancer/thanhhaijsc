<?php 

	global $zController;	
	$msg = '';
	if(count($zController->_error)>0){
		$msg .= '<div class="error"><ul>';		
		foreach ($zController->_error as $key => $val){
			$msg .= '<li>' . $val . '</li>';
		}
		$msg .= '</ul></div>';
	}		
	$vHtml = new HtmlControl();	
	$page 	= $zController->getParams('page');		
	$action = ($zController->getParams('action') != '')? $zController->getParams('action'):'add';		
	$lbl 	= 'User';				
	$lblUsername 	=sanitize_text_field(@$zController->_data['username']);	
	$inputPassword 	='<input type="password" id="password" name="password" class="regular-text" value="" />';	
	$lblEmail 	=sanitize_text_field(@$zController->_data['email']);	
	$inputFullname 	='<input type="text"  name="fullname" class="regular-text" value="'.sanitize_text_field(@$zController->_data['fullname']).'" />';
	$inputAddress 	='<input type="text"  name="address" class="regular-text" value="'.sanitize_text_field(@$zController->_data['address']).'" />';
	$inputPhone 	='<input type="text"  name="phone" class="regular-text" value="'.sanitize_text_field(@$zController->_data['phone']).'" />';
	
	
		
	$arrStatus              =   array(-1 => '- Select status -', 1 => 'Hiển thị', 0 => 'Ẩn');  
	$ddlStatus              =   $vHtml->cmsSelectbox("status","status","form-control",$arrStatus,(int)@$zController->_data['status'],"");

	$id='';
	if(count($zController->_data) > 0){
		if(!empty($zController->_data['id'])){
			$id=(int)$zController->_data['id'];
		}
	}
	$inputID                =   '<input type="hidden" name="id" id="id" value="'.@$id.'" />'; 
	$action					=	'<input name="action" value="'.$action.'" type="hidden">				';
?>
<div class="wrap">
	<h1><?php echo $lbl;?></h1>
	<?php echo $msg;?>
	<form method="post" action="" id="<?php echo $page;?>"
		enctype="multipart/form-data">
		<?php echo $inputID; ?>
		<?php echo $action; ?>						
		<?php wp_nonce_field($action,'security_code',true);?>				
		<table class="content-form">
				<tr>
					<td scope="row"><b><i><label>Username</label></i></b></td>
					<td><?php echo $lblUsername;?></td>
				</tr>
				<tr>
					<td scope="row"><b><i><label>Password</label></i></b></td>
					<td><?php echo $inputPassword;?></td>
				</tr>				
				<tr>
					<td scope="row"><b><i><label>Email</label></i></b></td>
					<td><?php echo $lblEmail;?></td>
				</tr>					
				<tr>
					<td scope="row" valign="top"><b><i><label>Fullname</label></i></b></td>
					<td><?php echo $inputFullname;?></td>
				</tr>
				<tr>
					<td scope="row" valign="top"><b><i><label>Address</label></i></b></td>
					<td><?php echo $inputAddress;?></td>
				</tr>
				<tr>
					<td scope="row" valign="top"><b><i><label>Phone</label></i></b></td>
					<td><?php echo $inputPhone;?></td>
				</tr>				
				<tr>
					<td scope="row"><b><i><label>Status</label></i></b></td>
					<td><?php echo $ddlStatus;?></td>
				</tr>							
		</table>		
		<p class="submit">
			<input name="submit" id="submit" class="button button-primary" value="Save Changes" type="submit">
		</p>
	</form>	
</div>
