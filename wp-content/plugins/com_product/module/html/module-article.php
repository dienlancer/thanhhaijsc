<?php 
global $zController,$zendvn_sp_settings,$wpdb;
$vHtml=new HtmlControl();
$email_to=$zendvn_sp_settings['email_to'];
$address=$zendvn_sp_settings['address'];
$website=$zendvn_sp_settings['website'];
$telephone=$zendvn_sp_settings['telephone'];
$contaced_name=$zendvn_sp_settings['contacted_name'];
$facebook_url=$zendvn_sp_settings['facebook_url'];
$twitter_url=$zendvn_sp_settings['twitter_url'];
$google_plus=$zendvn_sp_settings['google_plus'];
$youtube_url=$zendvn_sp_settings['youtube_url'];
$instagram_url=$zendvn_sp_settings['instagram_url'];
$pinterest_url=$zendvn_sp_settings['pinterest_url'];     
$width=$zendvn_sp_settings["product_width"];    
$height=$zendvn_sp_settings["product_height"];      
$post_meta_key = "_zendvn_sp_post_";
$page_meta_key = "_zendvn_sp_page_";
$product_meta_key = "_zendvn_sp_post_";
$page_id_zshopping = $zController->getHelper('GetPageId')->get('_wp_page_template','zshopping.php');
$zshopping_link = get_permalink($page_id_zshopping);
$title=$instance["title"];
$description=$instance["description"];
$category_id=$instance["category_id"];
$items_per_page=$instance["items_per_page"];
$position=$instance["position"];
$arrID=array(); 
$term=array();
$term_link="";
$term_link_1="";
$term_link_2="";
if((int)@$category_id==0){
	$terms = get_terms( array(
		'taxonomy' => 'category',
		'hide_empty' => false,  ) );	
	if(count($terms) > 0){
		foreach ($terms as $key => $value) {
			$arrID[]=$value->term_id;
		}
	}
	$term_link_1=$zshopping_link;		
}else{
	$arrID[]=(int)@$category_id;
}		
$args = array(
	'post_type' => 'post',  
	'orderby' => 'date',
	'order'   => 'DESC',  
	'posts_per_page' => $items_per_page,        								
	'tax_query' => array(
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => $arrID,									
		),
	),
);    	
$the_query=new WP_Query($args);	
if($the_query->have_posts()){
	switch ($position) {
		case "blog":
		?>
		<div class="container margin-top-45">
			<script type="text/javascript" language="javascript">
				jQuery(document).ready(function(){
					jQuery(".blog").owlCarousel({
						autoplay:false,                    
						loop:true,
						margin:25,                        
						nav:true,            
						mouseDrag: false,
						touchDrag: false,                                
						responsiveClass:true,
						responsive:{
							0:{
								items:1
							},
							600:{
								items:3
							},
							1000:{
								items:3
							}
						}
					});
					var chevron_left='<i class="fa fa-chevron-left"></i>';
					var chevron_right='<i class="fa fa-chevron-right"></i>';
					jQuery("div.blog div.owl-prev").html(chevron_left);
					jQuery("div.blog div.owl-next").html(chevron_right);
				});                
			</script>
			<div class="owl-carousel blog owl-theme">	
				<?php 
				while ($the_query->have_posts()){
					$the_query->the_post();		
					$post_id=$the_query->post->ID;							
					$permalink=get_the_permalink($post_id);
					$title=get_the_title($post_id);
					$excerpt=get_post_meta($post_id,"intro",true);
					$excerpt=substr($excerpt, 0,300).'...';			
					$content=get_the_content($post_id);
					$featureImg=get_the_post_thumbnail_url($post_id, 'full');							
					?>
					<div class="main-blog-box">
						<div class="blog-box-img">
							<center>
								<figure>
									<a href="<?php echo $permalink; ?>"><img src="<?php echo $featureImg; ?>" /></a>
								</figure>
							</center>
						</div>
						<div class="blog-box padding-left-15 padding-right-15 padding-top-15 padding-bottom-15">
							<h3 class="blog-title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h3>
							<div class="margin-top-15 blog-excerpt"><?php echo $excerpt; ?></div>
							<div class="about-us-readmore-2 margin-top-15">											
								<a href="<?php echo $permalink; ?>">Xem thêm<i class="icofont icofont-curved-double-right"></i></a>
							</div>
						</div>										
					</div>
					<?php
				}
				wp_reset_postdata();  
				?>
			</div>
		</div>
		<?php
		break;
	}
}
?>






