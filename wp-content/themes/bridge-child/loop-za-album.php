<?php 
$term=array();
if(have_posts()){
	while (have_posts()) {
		the_post();                     
		$post_id= get_the_id();        
		$title=get_the_title($post_id);             
		$excerpt=get_post_meta($post_id,"intro",true);        
		$content=get_the_content($post_id);       
		?>
			<div class="iewrqyriqwrw"><h1><center><?php echo $title; ?></center></h1></div>
		<?php				
		echo '<div class="margin-top-30">'.$content.'</div>' ;
	}	
}
?>
