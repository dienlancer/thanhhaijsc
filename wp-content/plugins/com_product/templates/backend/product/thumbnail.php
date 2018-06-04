<?php
global $zController, $post;
$controller = $zController->_data['controller'];
$vHtml=new HtmlControl(); 
$width=500;	
$height=400;		
$width=$width/4;
$height=$height/4;
$inputID 	= $controller->create_id('button');
$inputName 	= $controller->create_id('button');
$inputValue = translate('Media Library Image');
$arr 		= array('class' =>'button-secondary','id' => $inputID);
$options	= array('type'=>'button');
$btnMedia='<a onclick="openMedia(this);" class="button button-primary button-large" href="javascript:void(0);">Add Media</a>';
echo $btnMedia;
$arrOrdering = get_post_meta($post->ID, $controller->create_key('img-ordering'),true);
$arrPicture = get_post_meta($post->ID, $controller->create_key('img-url'),true);
?>
<div class="show-images">
	<?php 
	if(count($arrPicture) > 0){
		for($i=0; $i<count($arrPicture); $i++){
			?>
	<div class="box-content">
		<div><img src="<?php echo $arrPicture[$i];?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"/></div>
		<div><a class="remove-img">Remove</a></div>
		<div><input value="<?php echo $arrOrdering[$i];?>" class="ordering" name="zendvn-sp-zaproduct-img-ordering[]" type="text"></div>
		<div><input name="zendvn-sp-zaproduct-img-url[]" value="<?php echo $arrPicture[$i];?>" type="hidden"></div>		
	</div>
	<?php 
		}
	}
	?>
	<div class="clr"></div>
</div>




















