<?php 
global $zController,$zendvn_sp_settings;
$vHtml=new HtmlControl();   
$pageIDShopping = $zController->getHelper('GetPageId')->get('_wp_page_template','zshopping.php');   
    $permarlinkShopping = get_permalink($pageIDShopping);  
$ssName="vmart";
$ssValue="zcart";
$ssCart     = $zController->getSession('SessionHelper',$ssName,$ssValue);
$arrCart = @$ssCart->get($ssValue)["cart"]; 

if(count($arrCart)>0){
	?>
	<form name="frm" method="post">
		<input type="hidden" name="action" value="update-cart" />
		<?php wp_nonce_field("update-cart",'security_code',true);?>
		<h3 class="mamboitaliano">Giỏ hàng</h3>
		<div class="margin-top-15">
			<table id="com_product16" class="com_product16" cellpadding="0" cellspacing="0" width="100%">
				<thead>
					<tr>	
						<th>Sản phẩm</th>
						<th>Giá</th>
						<th>Số lượng</th>
						<th>Tổng giá</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php	
					$totalPrice=0;
					foreach ($arrCart as $key => $value) {	
						$product_id=$value["product_id"];			
						$product_name=$value["product_name"];
						$product_link=get_the_permalink($value["product_id"]);
						$product_quantity=$value["product_quantity"];
						$product_price=$value["product_price"];
						$product_total_price=$value["product_total_price"];
						$totalPrice+=(float)$product_total_price;
						$linkDelete="index.php?action=delete&id=".$product_id;
						?>
						<tr>

							<td class="com_product20"><a href="<?php echo $product_link ?>"><?php echo $product_name; ?></a></td>
							<td align="right" class="com_product21"><?php echo $vHtml->fnPrice($product_price) ; ?></td>
							<td align="center" class="com_product22"><input type="text" onkeypress="return isNumberKey(event)" value="<?php echo $product_quantity; ?>" size="4" class="com_product19" name="quantity[<?php echo $product_id; ?>]">		
							</td>
							<td align="right" class="com_product23"><?php echo $vHtml->fnPrice($product_total_price) ; ?></td>
							<td align="center" class="com_product24"><a onclick="return xacnhanxoa('Bạn có chắc chắn muốn xóa ?');" href="<?php echo $linkDelete; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
						</tr>
						<?php
					} 
					?>					
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3">
							<a href="index.php?action=delete-all" class="com_product28">Xóa giỏ hàng</a>
							<input type="submit" name="btn_update_cart" class="com_product25" value="Cập nhật" />							
							<a href="<?php echo $permarlinkShopping; ?>" class="com_product27">Tiếp tục mua hàng</a>
							<a href="index.php?action=checkout" class="com_product29">Thanh toán</a>

						</td>

						<td align="right"><?php echo $vHtml->fnPrice($totalPrice)  ; ?></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</form>
	<?php
}else{
	?>
	<table id="com_product16" class="com_product16" cellpadding="0" cellspacing="0" width="100%">
		<thead>
			<tr>					
				<th>Giỏ hàng rỗng</th>
			</tr>
		</thead>
	</table>
	<?php
}
?>	



