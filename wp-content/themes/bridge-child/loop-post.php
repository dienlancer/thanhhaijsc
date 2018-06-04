<?php 
$term=array();
$taxonomy='';
$meta_key='';
$vHtml=new HtmlControl();
$width=intval(get_option('thumbnail_size_w'));	
$height=intval(get_option('thumbnail_size_h'));	
if(have_posts()){
	while (have_posts()) {
		the_post();                     
		$post_id= get_the_id();        
		$title=get_the_title($post_id);             
		$excerpt=get_post_meta($post_id,"intro",true);  
		$content=get_the_content($post_id);       	
		$post_type=get_query_var('post_type'); 				
		if(empty($post_type)){
			$term = wp_get_object_terms( $post_id,  'category' );  
			$post_type='post';	
			$meta_key="_zendvn_sp_post_";		
		}else{			
			$term = wp_get_object_terms( $post_id,  'category_product' );  			
			$meta_key="_zendvn_sp_product_";
		}							
		if(count($term)>0){
			$taxonomy=$term[0]->taxonomy;
		}			
		$data_picture = get_post_meta($post_id,$meta_key.'img-url',true);  
		$data_ordering = get_post_meta($post_id,$meta_key.'img-ordering',true);		
		$source=array_combine($data_ordering, $data_picture);
		ksort($source);				
		$count_view_post=get_post_meta( $post_id, $meta_key . 'count_view_post', true );           
		$count  =   0;	
		if(!empty($count_view_post)){
			$count  =   (int)$count_view_post;                
		}			
		$count++;        
		update_post_meta($post_id, $meta_key . 'count_view_post', $count);		
		$date_post= get_the_date( 'd/m/Y', $post_id );		
		?>
		<div>
			<div class="vc_column_container vc_col-sm-6">
				<div class="box-image"><center><img class="zoom-img" src="<?php the_post_thumbnail_url( 'thumbnail' ); ?>" data-zoom-image="<?php the_post_thumbnail_url( 'full' ); ?>" /></center></div>
				<?php 
				if(count($source) > 0){					
					?>
					<div class="margin-top-5">						
						<script type="text/javascript" language="javascript">
							jQuery(document).ready(function(){
								jQuery(".prodetail").owlCarousel({
									autoplay:false,                    
									loop:true,
									margin:2,                        
									nav:true,            
									mouseDrag: true,
									touchDrag: true,                                
									responsiveClass:true,
									responsive:{
										0:{
											items:1
										},
										600:{
											items:1
										},
										1000:{
											items:6
										}
									}
								});
								var chevron_left='<i class="fa fa-chevron-left"></i>';
								var chevron_right='<i class="fa fa-chevron-right"></i>';
								jQuery("div.prodetail div.owl-prev").html(chevron_left);
								jQuery("div.prodetail div.owl-next").html(chevron_right);
							});                
						</script>
						<div class="owl-carousel prodetail owl-theme">
							<?php 
							foreach($source as $key => $value){                                            
								$small_img=$vHtml->getResizedImg($value,$width,$height);	
								$full_img=$value;					
								?>
								<div class="pdetail-chipu">									
									<a href="javascript:void(0);" onclick="changeImage('<?php echo $small_img ?>','<?php echo $full_img; ?>');"><img  src="<?php echo $small_img; ?>" width="<?php echo (int)$width/5; ?>" /></a>                                        
								</div>
								<?php                                    
							}                           
							?>        
						</div>

					</div>					
					<?php
				}
				?>						
			</div>
			<div class="vc_column_container vc_col-sm-6">
				<div class="margin-left-15">
					<h1 class="ewoowjrjlkr"><?php echo $title; ?></h1>
					<div class="margin-top-15 justify jquikkdfk">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>				
					</div>
					<div class="margin-top-15">
						<ul class="wqoriworew">
							<li><span><a href="javascript:void(0);"><i class="far fa-thumbs-up"></i>&nbsp;Thích</a></span></li>
							<li><span>Lượt xem: <?php echo $count; ?></span></li>
							<li><span>Ngày đăng: <?php echo $date_post; ?></span></li>
						</ul>
					</div>			
					<div class="margin-top-15 qrjrqkewr">
						Liên hệ
					</div>
					<div class="margin-top-15 justify">
						<?php echo $excerpt; ?>
					</div>
					<div class="margin-top-15 jfkeireiuree">
						<a href="/lien-he">Mua ngay</a>
					</div>			
				</div>				
			</div>
			<div class="clr"></div>
		</div>	
		<div class="margin-top-15">
			<script type="text/javascript" language="javascript">
				function openCity(evt, cityName) {    
					var i, tabcontent, tablinks;
					tabcontent = document.getElementsByClassName("tabcontent");
					for (i = 0; i < tabcontent.length; i++) {
						tabcontent[i].style.display = "none";
					}   
					tablinks = document.getElementsByClassName("tablinks");
					for (i = 0; i < tablinks.length; i++) {
						tablinks[i].className = tablinks[i].className.replace(" active", "");
					}   
					document.getElementById(cityName).style.display = "block";
					evt.currentTarget.className += " active";
				}
				jQuery(document).ready(function(){
					jQuery("#thong-tin").show();
					jQuery("div.tab > button.tablinks:first-child").addClass('active');
				});
			</script>       
			<div class="tab">
				<button class="tablinks h-title" onclick="openCity(event, 'thong-tin')">Thông tin</button>				              
				<div class="clr"></div>           
			</div>
			<div id="thong-tin" class="tabcontent">
				<div class="margin-top-15">
					<?php
					if(!empty($content)){
						echo $content; 
					}                
					?>                   
				</div>
			</div>				
		</div>
		<hr class="duong-ngang">
		<div class="margin-top-10">
			<div class="related-news">
				<b>Tin liên quan</b>
			</div>
			<div class="related-news-right">
				<?php 
				$arrID=array(); 
				if(count($term) > 0){
					foreach ($term as $key => $value) {
						$arrID[]=$value->term_id;
					}
				}    
				$args = array(
					'post_type' => $post_type,  
					'orderby' => 'date',
					'order'   => 'DESC',  
					'posts_per_page' => 10,        
					'post__not_in'=>array($post_id),
					'tax_query' => array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'term_id',
							'terms'    => $arrID,                   
						),
					),
				);     
				$the_query=new WP_Query($args);  
				if($the_query->have_posts()){
					?>
					<ul class="related-articles">
						<?php 
						while ($the_query->have_posts()){
							$the_query->the_post();
							$postID=$the_query->post->ID;
							$title=get_the_title($postID);
							$permalink=get_the_permalink($postID);
							$featureImg=get_the_post_thumbnail_url($postID, 'full');
							?>
							<li>                                              
								<a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
							</li>
							<?php
						}
						?>
					</ul>
					<?php					
				}
				?>
			</div>
			<div class="clr"></div>
		</div>
		<?php 
	}
	wp_reset_postdata();   
	?>
	<script language="javascript" type="text/javascript">		
		jQuery('.zoom-img').elevateZoom({
			zoomType: "inner",
			cursor: "crosshair",
			zoomWindowFadeIn: 500,
			zoomWindowFadeOut: 750
		}); 
		function changeImage(small_img,full_img){    
			var image_detail=jQuery(".box-image");
			var imghtml='<center><img class="zoom-img" src="'+small_img+'" data-zoom-image="'+full_img+'"></center>';        
			jQuery(image_detail).empty();
			jQuery(image_detail).append(imghtml);
			jQuery('.zoom-img').elevateZoom({
				zoomType: "inner",
				cursor: "crosshair",
				zoomWindowFadeIn: 500,
				zoomWindowFadeOut: 750
			});
		}    
	</script>
	<?php 
}
?>
