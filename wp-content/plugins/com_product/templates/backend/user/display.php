<?php 
	global $zController;
	$tblCategory = $zController->getModel('/backend','AdminUserModel');	
	$tblCategory->prepare_items();	
	$lbl = 'User';	
	$page = $zController->getParams('page');	
	$linkAdd = admin_url('admin.php?page=' . $page . '&action=add') ;
	$lblAdd = 'Add';
	
	if($zController->getParams('msg') == 1){
		$msg .='<div class="updated"><p>Update finish</p></div>';
	}	
?>
<div class="wrap">
	<h1><?php echo esc_html__($lbl);?>
		<a href="<?php echo esc_url($linkAdd);?>" class="add-new-h2"><?php echo esc_html__($lblAdd);?></a>
	</h1>
	<?php echo $msg;?>
	<form action="" method="post" name="<?php echo $page;?>" id="<?php echo $page;?>">
	<?php $tblCategory->search_box('search', 'search_id');?>
	<?php $tblCategory->display();?>
	</form>
</div>