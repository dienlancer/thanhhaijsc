<?php 
global $zController,$zendvn_sp_settings,$wpdb;
$vHtml=new HtmlControl();    
$position=$instance["position"];
switch ($position) {
	case "right-col":		
	$args=array(
		'post_type'=>'post',
		'orderby'=>'date',
		'order'=>'DESC',
		'posts_per_page'=>4
	);				
	$the_query=new WP_Query($args);
	if($the_query->have_posts()){
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$post_id=$the_query->post->ID;
			$title=get_the_title($post_id);
			$permalink=get_the_permalink($post_id);
			$featureImg=get_the_post_thumbnail_url($post_id, 'full');
			?>
			<div class="margin-top-15">
								<div class="col-lg-4 no-padding"><center><a href="<?php echo $permalink; ?>"><img src="<?php echo $featureImg; ?>"></a></center></div>
								<div class="col-lg-8 no-padding-right">
									<div class="product-home-title">
										<a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
									</div>									
								</div>		
								<div class="clr"></div>						
							</div>
			<?php 
		}
	}
	break;				
}
?>






