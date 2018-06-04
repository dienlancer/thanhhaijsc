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
$product_meta_key = "_zendvn_sp_zaproduct_";
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
		'taxonomy' => 'za_category',
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
	'post_type' => 'zaproduct',  
	'orderby' => 'date',
	'order'   => 'DESC',  
	'posts_per_page' => $items_per_page,        								
	'tax_query' => array(
		array(
			'taxonomy' => 'za_category',
			'field'    => 'term_id',
			'terms'    => $arrID,									
		),
	),
);    	
$the_query=new WP_Query($args);	
if($the_query->have_posts()){
	switch ($position) {
		case "all-menu":	
		case "breakfast-menu":	
		case "lunch-menu":	
		case "dinner-menu":	
		case "drink-menu":	
		case "others-menu":								
		$k=1;
		while ($the_query->have_posts()) {
			$the_query->the_post();		
			$post_id=$the_query->post->ID;							
			$permalink=get_the_permalink($post_id);
			$title=get_the_title($post_id);
			$excerpt=get_post_meta($post_id,"intro",true);
			$excerpt=substr($excerpt, 0,300).'...';			
			$featureImg=get_the_post_thumbnail_url($post_id, 'full');	
			$smallImg=$vHtml->getSmallImage($featureImg);
			$term = wp_get_object_terms( $post_id,  'za_category' );     
			$term_link_2=get_term_link($term[0],'za_category');		
			$price=get_post_meta($post_id,$product_meta_key."price",true);
			$sale_price=get_post_meta($post_id,$product_meta_key."sale_price",true);			
			$html_price='';						
			if((int)@$sale_price > 0){				
				$price_html ='<span class="price-regular">'.$vHtml->fnPrice($price).'</span>';
				$sale_price_html='<span class="price-sale">'.$vHtml->fnPrice($sale_price).'</span>' ;					
				$html_price='<div >'.$price_html.'</div><div >'.$sale_price_html.'</div>' ;				
			}else{
				$html_price='<span>'.$vHtml->fnPrice($price).'</span>' ;					
			}					
			?>
			<div class="col-lg-4">
				<div class="headhunter-menu">
					<div class="col-xs-4 no-padding locot">
						<div>
							<center><figure><a href="<?php echo $permalink; ?>"><img src="<?php echo $smallImg; ?>" /></a></figure></center>
						</div>
					</div>
					<div class="col-xs-8 no-padding">
						<div class="headhunter-box relative">
							<h3 class="headhunter-title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h3>							
							<div class="headhunter-price">
								<?php echo $html_price; ?>
							</div>							
							<div class="headhunter-cart"><center><a href="javascript:void(0);"><i class="icofont icofont-cart-alt"></i></a></center></div>
						</div>
					</div>
					<div class="clr"></div>
				</div>
			</div>
			<?php
			if($k%3==0 || $k==$the_query->post_count){
				echo '<div class="clr"></div>';
			}	
			$k++;	
		}
		wp_reset_postdata();  
		if((int)@$category_id == 0){
			$term_link=$term_link_1;
		}else{
			$term_link=$term_link_2;
		}
		?>
		<div class="about-us-readmore-2 margin-top-45"><center><a href="<?php echo $term_link; ?>">Xem thêm<i class="icofont icofont-curved-double-right"></i></a></center></div>
		<?php
		break;
		case "popular-product":					
		?>
		<div class="container margin-top-45">
			<script type="text/javascript" language="javascript">
				jQuery(document).ready(function(){
					jQuery(".popular-product").owlCarousel({
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
								items:1
							},
							1000:{
								items:5
							}
						}
					});
					var chevron_left='<i class="fa fa-chevron-left"></i>';
					var chevron_right='<i class="fa fa-chevron-right"></i>';
					jQuery("div.popular-product div.owl-prev").html(chevron_left);
					jQuery("div.popular-product div.owl-next").html(chevron_right);
				});                
			</script>
			<div class="owl-carousel popular-product owl-theme">		
				<?php 
				while ($the_query->have_posts()){
					$the_query->the_post();		
					$post_id=$the_query->post->ID;							
					$permalink=get_the_permalink($post_id);
					$title=get_the_title($post_id);
					$excerpt=get_post_meta($post_id,"intro",true);
					$excerpt=substr($excerpt, 0,300).'...';			
					$featureImg=get_the_post_thumbnail_url($post_id, 'full');	
					$smallImg=$vHtml->getSmallImage($featureImg);
					$term = wp_get_object_terms( $post_id,  'za_category' );     
					$term_link_2=get_term_link($term[0],'za_category');		
					$price=get_post_meta($post_id,$product_meta_key."price",true);
					$sale_price=get_post_meta($post_id,$product_meta_key."sale_price",true);			
					$html_price='';                     
					if((int)@$sale_price > 0){              
						$price_html ='<span class="price-regular tutu">'.$vHtml->fnPrice($price).'</span>';
						$sale_price_html='<span class="price-sale-nanim">'.$vHtml->fnPrice($sale_price).'</span>' ;                 
						$html_price='<div class="col-xs-6"><center>'.$price_html.'</center></div><div class="col-xs-6"><center>'.$sale_price_html.'</center></div><div class="clr"></div>' ;              
					}else{
						$html_price='<center><span class="tutu">'.$vHtml->fnPrice($price).'</span></center>' ;                  
					}  
					?>
					<div class="popular-product-box">
						<div class="popular-product-box-img">
							<center><figure><a href="<?php echo $permalink; ?>"><img src="<?php echo $smallImg; ?>" /></a></figure></center>
						</div>
						<h3 class="sigma padding-top-15"><center><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></center></h3>
						<div class="popular-product-price padding-top-15"><?php echo $html_price; ?></div>
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






