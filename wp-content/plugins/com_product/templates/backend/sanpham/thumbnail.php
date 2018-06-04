<?php
global $zController, $post,$zendvn_sp_settings;
$controller = $zController->_data['controller'];
$vHtml=new HtmlControl(); 
$width=$zendvn_sp_settings["product_width"];	
$height=$zendvn_sp_settings["product_height"];		
$width=$width/4;
$height=$height/4;
$inputID 	= $controller->create_id('button');
$inputName 	= $controller->create_id('button');
$inputValue = translate('Media Library Image');
$arr 		= array('class' =>'button-secondary','id' => $inputID);
$options	= array('type'=>'button');
$btnMedia='<button id="'.$inputID.'" name="'.$inputName.'">MediaButton</button>';
echo $btnMedia;
$arrOrdering = get_post_meta($post->ID, $controller->create_key('img-ordering'),true);
$arrPicture = get_post_meta($post->ID, $controller->create_key('img-url'),true);
?>
<div id="zendvn-sp-zaproduct-show-images">
	<?php 
	if(count($arrPicture) > 0){
		for($i=0; $i<count($arrPicture); $i++){
			?>
			<div class="content-img">
				<img
				src="<?php echo $arrPicture[$i];?>"
				width="<?php echo $width; ?>" height="<?php echo $height; ?>">
				<div>
					<a class="remove-img">Remove</a>
				</div>
				<div class="div-ordering">
					<input value="<?php echo $arrOrdering[$i];?>" class="ordering"
					name="zendvn-sp-sanpham-img-ordering[]" type="text"> <input
					name="zendvn-sp-sanpham-img-url[]"
					value="<?php echo $arrPicture[$i];?>"
					type="hidden">
				</div>
			</div>
			<?php 
		}
	}
	?>
	<div class="clr"></div>
</div>




















