function xacnhanxoa(msg){if(window.confirm(msg)){return true;}return false;}
function changePage(page,ctrl){
	jQuery('input[name=filter_page]').val(page);
	jQuery(ctrl).closest('form')[0].submit();	
}
function isNumberKey(evt){var hopLe=true;var charCode=(evt.which)?evt.which:event.keyCode;if(charCode>31&&(charCode<48||charCode>57))hopLe=false;return hopLe;}

function addToCart(product_id,quantity){
	var id = product_id;						
	var dataObj = {
		"action"	: "add_to_cart",
		"id"		: id,		
		"quantity"	: quantity,		
		"security"  : security_code
	};		
	jQuery.ajax({
		url			: ajaxurl,
		type		: "POST",
		data		: dataObj,
		dataType	: "json",
		success		: function(data, status, jsXHR){
			var thong_bao='Sản phẩm đã được thêm vào trong <a href="'+data.permalink+'" class="comproduct49" >giỏ hàng</a> ';				
			jQuery(".cart-total").empty();			
			jQuery("div.modal-add-cart div.modal-body").empty();		
			jQuery(".cart-total").text(data.total_quantity);			
			var html_thong_bao='<center>'+thong_bao+'</center>';
			jQuery("div.modal-add-cart div.modal-body").append(html_thong_bao);			
		}
	});
}