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
if(!empty($instance['item_id'])){
	$arrItemID=explode(",",$instance["item_id"]);
	$title=$instance["title"];
	$description=$instance["description"];
	$position=$instance["position"];
	if(count($arrItemID) > 0){
		switch ($position) {
			case "slideshow":			
			?>
			<div>
				<script type="text/javascript" language="javascript">        
					jQuery(document).ready(function(){
						jQuery(".slick-slideshow").slick({
							dots: true,
							autoplay:true,
							arrows:false,
							adaptiveHeight:true,
							loop:true
						});  
					});     
				</script>
				<div class="slick-slideshow">
					<?php 
					foreach ($arrItemID as $key => $value){
						if(!empty($value)){
							$args = array(  		
								'p' => 	(int)@$value,			
								'post_type' => 'banner'
							);	
							$the_query = new WP_Query($args);	
							if($the_query->have_posts()){
								while ($the_query->have_posts()) {
									$the_query->the_post();		
									$post_id=$the_query->post->ID;
									$alt=get_post_meta($post_id,"alt",true);
									$link_web=get_post_meta($post_id,"url",true);
									$featureImg=get_the_post_thumbnail_url($post_id, 'full');
									?>
									<div><a href="<?php echo $link_web; ?>" target="_blank"><img alt="<?php echo $alt; ?>" src="<?php echo $featureImg; ?>" /></a></div>  
									<?php
								}
								wp_reset_postdata();  
							}	
						}					
					}				
					?>				
				</div>
			</div>			
			<?php
			break;	
			case "banner-page":		
			foreach ($arrItemID as $key => $value) {
				if(!empty($value)){
					$args = array(  		
						'p' => 	(int)@$value,			
						'post_type' => 'page'
					);			
					$the_query = new WP_Query($args);		
					if($the_query->have_posts()){		
						?>
						<div class="logo-banner">
							<div class="container">
								<?php 
								while ($the_query->have_posts()) {
									$the_query->the_post();		
									$post_id=$the_query->post->ID;							
									$permalink=get_the_permalink($post_id);
									$title=get_the_title($post_id);
									$excerpt=get_post_meta($post_id,"intro",true);
									$excerpt=substr($excerpt, 0,300).'...';			
									$featureImg=get_the_post_thumbnail_url($post_id, 'full');
									?>
									<div><center><img src="<?php echo site_url("wp-content/uploads/logo-banner.png"); ?>" /></center></div>
									<div class="lobo-banner-title"><center><?php echo $title; ?></center></div>
									<div class="logo-banner-excerpt"><center><?php echo $excerpt; ?></center></div>
									<?php
								}
								wp_reset_postdata();  
								?>      		
							</div>										
						</div>				
						<?php						
					}
				}				
			}
			break;
			case "search-food":
			case "our-menu":	
			case "popular-dishes":	
			case "reservation":	
			case "our-gallery":
			case "our-blog":
			foreach ($arrItemID as $key => $value) {
				if(!empty($value)){
					$args = array(  		
						'p' => 	(int)@$value,			
						'post_type' => 'page'
					);			
					$the_query = new WP_Query($args);		
					if($the_query->have_posts()){		
						?>
						<div class="container padding-top-45">
							<?php
							 while ($the_query->have_posts()){
							 	$the_query->the_post();		
							 	$post_id=$the_query->post->ID;							
							 	$permalink=get_the_permalink($post_id);
							 	$title=get_the_title($post_id);
							 	$excerpt=get_post_meta($post_id,"intro",true);
							 	$excerpt=substr($excerpt, 0,300).'...';			
							 	$featureImg=get_the_post_thumbnail_url($post_id, 'full');
							 	?>
							 	<div class="search-food-title"><center><?php echo $title; ?></center></div>
							 	<div class="search-food-excerpt margin-top-15"><center><?php echo $excerpt ?></center></div>							 				 
							 	<?php
							 }
							 wp_reset_postdata();  
							?>
						</div>	
						<?php						
					}
				}				
			}
			break;
			case "introduce":	
			foreach ($arrItemID as $key => $value) {
				if(!empty($value)){
					$args = array(  		
						'p' => 	(int)@$value,			
						'post_type' => 'page'
					);			
					$the_query = new WP_Query($args);		
					if($the_query->have_posts()){								
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
							<div class="about-us margin-top-45">
								<div class="container">
									<div class="col-lg-8">
										<h3 class="about-us-title">
											<?php echo $title; ?>
										</h3>
										<div class="about-us-excerpt"><?php echo $excerpt; ?></div>
										<hr class="about-us-hr" />
										<div class="about-us-content margin-top-45"><?php echo $content; ?></div>
										<div class="about-us-readmore margin-top-45"><a href="<?php echo $permalink; ?>">Xem thêm<i class="icofont icofont-curved-double-right"></i></a></div>
									</div>
									<div class="col-lg-4"><center><img src="<?php echo $featureImg; ?>" /></center></div>
									<div class="clr"></div>
								</div>
							</div>
							<?php
						}	
						wp_reset_postdata();  					
					}
				}				
			}
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
					foreach ($arrItemID as $key => $value){
						if(!empty($value)){
							$args = array(  		
								'p' => 	(int)@$value,			
								'post_type' => 'zaproduct'
							);			
							$the_query = new WP_Query($args);	
							if($the_query->have_posts()){
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
							}	
						}
					}
					?>								
				</div>						
			</div>			
			<?php	
			break;
			case "gallery-image":						
			?>
			<div class="container margin-top-15">
				<?php 
				$k=1;
				foreach ($arrItemID as $key => $value){
					if(!empty($value)){
						$args = array(  		
							'p' => 	(int)@$value,			
							'post_type' => 'banner'
						);	
						$the_query = new WP_Query($args);	
						if($the_query->have_posts()){
							while ($the_query->have_posts()) {
								$the_query->the_post();		
								$post_id=$the_query->post->ID;
								$alt=get_post_meta($post_id,"alt",true);
								$link_web=get_post_meta($post_id,"url",true);
								$featureImg=get_the_post_thumbnail_url($post_id, 'full');
								?>
								<div class="col-xs-4">
									<div class="relative liverpool margin-top-30">
										<div><center><img src="<?php echo $featureImg; ?>"></center></div>			
										<div class="youtube"></div>		
										<div class="youtube-img">
											<div><a data-fancybox="gallery"  href="<?php echo $featureImg; ?>"><i class="icofont icofont-plus-circle"></i></a></div>		
										</div>									
									</div>								
								</div>  
								<?php
							}
							wp_reset_postdata();  
						}	
					}
					if($k%3==0 || $k==count($arrItemID)){
						echo '<div class="clr"></div>';
					}	
					$k++;				
				}				
				?>
				<div class="about-us-readmore-2 margin-top-45">
					<center>
						<a href="javascript:void(0);">Xem thêm<i class="icofont icofont-curved-double-right"></i></a>
					</center>
				</div>	
			</div>
			<?php
			break;
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
					foreach ($arrItemID as $key => $value) {
						if(!empty($value)){
							$args = array(  		
								'p' => 	(int)@$value,			
								'post_type' => 'post'
							);			
							$the_query = new WP_Query($args);		
							if($the_query->have_posts()){								
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
							}
						}				
					}
					?>
				</div>
			</div>
			<?php
			break;
			case 'email-subscribe-introduce':
			foreach ($arrItemID as $key => $value) {
				if(!empty($value)){
					$args = array(  		
						'p' => 	(int)@$value,			
						'post_type' => 'page'
					);			
					$the_query = new WP_Query($args);		
					if($the_query->have_posts()){								
						while ($the_query->have_posts()){
							$the_query->the_post();		
							$post_id=$the_query->post->ID;							
							$permalink=get_the_permalink($post_id);
							$title=get_the_title($post_id);
							$excerpt=get_post_meta($post_id,"intro",true);
							$excerpt=substr($excerpt, 0,100).'...';			
							$featureImg=get_the_post_thumbnail_url($post_id, 'full');
							?>
							<div class="email-intro"><?php echo $excerpt; ?></div>
							<?php
						}
						wp_reset_postdata();  									
					}
				}				
			}
			break;
			case "working-time":
			case "copyright":
			foreach ($arrItemID as $key => $value) {
				if(!empty($value)){
					$args = array(  		
						'p' => 	(int)@$value,			
						'post_type' => 'page'
					);			
					$the_query = new WP_Query($args);		
					if($the_query->have_posts()){		
						
							 while ($the_query->have_posts()){
							 	$the_query->the_post();		
							 	$post_id=$the_query->post->ID;							
							 	$permalink=get_the_permalink($post_id);
							 	$title=get_the_title($post_id);
							 	$excerpt=get_post_meta($post_id,"intro",true);
							 	$excerpt=substr($excerpt, 0,99999).'...';			
							 	$content=get_the_content($post_id);        
							 	$featureImg=get_the_post_thumbnail_url($post_id, 'full');
							 	echo $content;
							 }
							 wp_reset_postdata();  
								
					}
				}				
			}
			break;
		}
	}	
}
?>






