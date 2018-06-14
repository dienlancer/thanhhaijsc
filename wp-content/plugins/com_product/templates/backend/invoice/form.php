<?php 

	global $zController,$zendvn_sp_settings;	
	
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
	$lbl 	= 'Invoice';			
	$lblCode 	= 	@$zController->_data['code'];
	$lblCreatedDate 	=$zController->getHelper('DateTimeConverter')->datetimeConverterVn(@$zController->_data['created_date']) 	;
	
	$inputEmail 	= '<input type="text"  name="email" class="regular-text" value="'.sanitize_text_field(@$zController->_data['email']).'" />';
	$inputFullname 	='<input type="text"  name="fullname" class="regular-text" value="'.sanitize_text_field(@$zController->_data['fullname']).'" />';
	$inputAddress 	='<input type="text"  name="address" class="regular-text" value="'.sanitize_text_field(@$zController->_data['address']).'" />';
	$inputPhone 	='<input type="text"  name="phone" class="regular-text" value="'.sanitize_text_field(@$zController->_data['phone']).'" />';
	$inputNote 	='<textarea type="text"  name="note" class="regular-text" rows="10" >'.sanitize_text_field(@$zController->_data['note']).'</textarea>';
	
	$lblPaymentMethodTitle=@$zController->_data["payment_method_title"];
	$lblQuantity 	= number_format(@$zController->_data['quantity'],0,",",".")	;
	$lblTotalPrice 	=$vHtml->fnPrice(@$zController->_data['total_price']) 	;	
	$arrStatus              =   array(-1 => '- Select status -', 1 => 'Hiển thị', 0 => 'Ẩn');  
	$ddlStatus              =   $vHtml->cmsSelectbox("status","status","form-control",$arrStatus,(int)@$zController->_data['status'],"");
	// lấy danh sách chi tiết đơn hàng
	$invoiceDetailModel=$zController->getModel("/backend","AdminInvoiceModel");
	$arrInvoiceDetail=$invoiceDetailModel->getInvoiceDetail();		

	$payment_method_id=(int)@$zController->_data["payment_method_id"];	
		$payment_method_data=array();
		$args=array(
			"p"=>$payment_method_id,
			"post_type"=>"payment_method"
		);
		$the_query = new WP_Query( $args );
	    if($the_query->have_posts()){
	        while ($the_query->have_posts()) {
	            $the_query->the_post();
	            $post_id=$the_query->post->ID;
	            $title=get_the_title($post_id);
	            $content=get_the_content($post_id);	            
	            $payment_method_data["id"]=$post_id;
	            $payment_method_data["title"]=$title;
	            $payment_method_data["content"]=$content;	            
	        }
	        wp_reset_postdata();    
	    }

?>
<div class="wrap">
	<h1><?php echo $lbl;?></h1>
	<?php echo $msg;?>
	<form method="post" action="" id="<?php echo $page;?>"
		enctype="multipart/form-data">
		<input name="action" value="<?php echo $action;?>" type="hidden">				
		<?php wp_nonce_field($action,'security_code',true);?>				
		<table class="content-form">
				<tr>
					<td scope="row" align="right">
						<label><i><b>Mã đơn hàng :</b></i></label>
					</td>
					<td><?php echo $lblCode;?></td>
				</tr>	
				<tr>
					<td scope="row" align="right">
						<label><i><b>Ngày đặt hàng :</b></i></label>
					</td>
					<td><?php echo $lblCreatedDate;?></td>
				</tr>					
				<tr>
					<td scope="row" align="right">
						<label><i><b>Email :</b></i></label>
					</td>
					<td><?php echo $inputEmail;?></td>
				</tr>
				<tr>
					<td scope="row" align="right">
						<label><i><b>Họ tên :</b></i></label>
					</td>
					<td><?php echo $inputFullname;?></td>
				</tr>
				<tr>
					<td scope="row" align="right">
						<label><i><b>Địa chỉ :</b></i></label>
					</td>
					<td><?php echo $inputAddress;?></td>
				</tr>
				<tr>
					<td scope="row" align="right">
						<label><i><b>Phone :</b></i></label>
					</td>
					<td><?php echo $inputPhone;?></td>
				</tr>				
				<tr>
					<td scope="row" align="right" style="vertical-align: top;">
						<label><i><b>Ghi chú :</b></i></label>
					</td>
					<td><?php echo $inputNote;?></td>
				</tr>
				<tr>
					<td scope="row" align="right">
						<label><i><b>Phương thức thanh toán :</b></i></label>
					</td>
					<td><?php echo $payment_method_data["title"];?></td>
				</tr>
				<tr>
					<td scope="row" align="right">
						<label><i><b>Nội dung thanh toán :</b></i></label>
					</td>
					<td><?php echo $payment_method_data["content"];?></td>
				</tr>
				<tr>
					<td scope="row" align="right">
						<label><i><b>Số lượng :</b></i></label>
					</td>
					<td><b><?php echo $lblQuantity;?></b>&nbsp;sản phẩm</td>
				</tr>	
				<tr>
					<td scope="row" align="right">
						<label><i><b>Thành tiền :</b></i></label>
					</td>
					<td><?php echo $lblTotalPrice . ' đ';?></td>
				</tr>											
				<tr>
					<td scope="row" align="right">
						<label><i><b>Trạng thái giao hàng :</b></i></label>
					</td>
					<td><?php echo $ddlStatus;?></td>
				</tr>							
		</table>		
		<p class="submit">
			<input name="submit" id="submit" class="button button-primary" value="Save Changes" type="submit">
		</p>
	</form>
	<div>
		<table width="100%" id="com_product16" class="com_product16">
			<thead>
				<tr>
					<th>Mã</th>
					<th>Tên sp</th>
					<th>Hình</th>
					<th>Giá</th>
					<th>Số lượng</th>
					<th>Thành tiền</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$width=$zendvn_sp_settings["product_width"];	
		$height=$zendvn_sp_settings["product_height"];		
			foreach ($arrInvoiceDetail as $key => $value) {
				$product_sku=$value["product_sku"];
				$product_name=$value["product_name"];
				$product_image=$value["product_image"];
				$newFileUrl=wp_upload_dir()["url"] . DS . $width . "x" . $height . "-" . $product_image; 
				$product_price=$vHtml->fnPrice(@$value["product_price"]) ;
				$product_quantity=number_format($value["product_quantity"],0,",",".") ;
				$product_total_price=$vHtml->fnPrice(@$value["product_total_price"]);
			 	?>
			 	<tr>
					<td><?php echo $product_sku; ?></td>
					<td><?php echo $product_name; ?></td>
					<td align="center"><img  src="<?php echo $newFileUrl; ?>" width="84" height="112" /></td>
					<td align="right"><?php echo $product_price; ?></td>
					<td align="right"><?php echo $product_quantity; ?></td>
					<td align="right"><?php echo $product_total_price; ?></td>
				</tr>
			 	<?php
			 } 
			?>				
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" align="center"><b>Tổng cộng</b></td>
					<td align="right"><?php echo $lblQuantity; ?></td>
					<td align="right"><?php echo $lblTotalPrice; ?></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
