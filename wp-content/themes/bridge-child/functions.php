<?php

// enqueue the child theme stylesheet

function wp_schools_enqueue_scripts() {
	/* begin fontawesome */
	wp_register_style( 'fontawesome', get_stylesheet_directory_uri() . '/web-fonts-with-css/css/fontawesome-all.min.css' ,array(),false,'all' );
	wp_enqueue_style( 'fontawesome' );
	/* end fontawesome */
	/* begin owlcarousel */
	wp_register_style( 'owlcarousel_css', get_stylesheet_directory_uri() . '/owlcarousel/assets/owl.carousel.min.css' ,array(),false,'all' );
	wp_enqueue_style( 'owlcarousel_css' );
	wp_register_script('owlcarousel_js',get_stylesheet_directory_uri() . '/owlcarousel/owl.carousel.min.js',array(),false,false);
	wp_enqueue_script('owlcarousel_js');
	/* end owlcarousel */
	/* begin bootstrap */
	wp_register_style( 'bootstrap_css', get_stylesheet_directory_uri() . '/css/bootstrap.css' ,array(),false,'all' );
	wp_enqueue_style( 'bootstrap_css' );
	wp_register_script('bootstrap_js',get_stylesheet_directory_uri() . '/js/bootstrap.js',array(),false,false);
	wp_enqueue_script('bootstrap_js');
	/* end bootstrap */
	/* begin elevatezoom */
	wp_register_script('elevatezoom',get_stylesheet_directory_uri() . '/js/jquery.elevatezoom-3.0.8.min.js',array(),false,false);
	wp_enqueue_script('elevatezoom');	
	/* end elevatezoom */
	/* begin youtube */	
	wp_register_script('jquery_modal_video',get_stylesheet_directory_uri() . '/youtube/jquery-modal-video.min.js',array(),false,false);
	wp_enqueue_script('jquery_modal_video');
	wp_register_script('modal_video_js',get_stylesheet_directory_uri() . '/youtube/modal-video.min.js',array(),false,false);
	wp_enqueue_script('modal_video_js');
	wp_register_style( 'modal_video_css', get_stylesheet_directory_uri() . '/youtube/modal-video.min.css' ,array(),false,'all'  );
	wp_enqueue_style( 'modal_video_css' );
	/* end youtube */
	/* begin tab */
	wp_register_style( 'tab_css', get_stylesheet_directory_uri() . '/css/tab.css' ,array(),false,'all'  );
	wp_enqueue_style( 'tab_css' );
	/* end tab */	
	/* begin custom js */
	wp_register_script('customy_js',get_stylesheet_directory_uri() . '/js/custom.js',array(),false,false);
	wp_enqueue_script('customy_js');
	/* end custom js */
	/* begin style */
	wp_register_style( 'product', get_stylesheet_directory_uri() . '/css/product.css',array(),false,'all'   );
	wp_enqueue_style( 'product' );
	/* end style */	
	/* begin style */
	wp_register_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css',array(),false,'all'   );
	wp_enqueue_style( 'childstyle' );
	/* end style */	
}
function do_output_buffer(){
		ob_start();
}
add_action( 'wp_enqueue_scripts', 'wp_schools_enqueue_scripts', 11);
add_action('init', 'do_output_buffer');
/* begin menu */
add_action('init', 'zendvn_theme_register_menus');
function zendvn_theme_register_menus(){
	register_nav_menus(
		array(									
			'category-product-menu' 			=> __('CategoryProductMenu'),			
		)
	);
}
/* end menu */
/* begin ẩn menu */
function vnkings_admin_menus() {   
   remove_menu_page( 'edit.php?post_type=portfolio_page' ); 
   remove_menu_page( 'edit.php?post_type=testimonials' ); 
   remove_menu_page( 'edit.php?post_type=slides' ); 
   remove_menu_page( 'edit.php?post_type=carousels' ); 
   remove_menu_page( 'edit.php?post_type=masonry_gallery' ); 
   remove_menu_page( 'edit-comments.php' ); 
   remove_menu_page( 'tools.php' );     
   remove_menu_page( 'edit.php?post_type=acf' );   
   remove_menu_page( 'vc-general' );    
}
add_action( 'admin_menu', 'vnkings_admin_menus' );
/* end ẩn menu */
/* begin fanpage */
add_action('wp_footer', 'script_fanpage');
function script_fanpage(){
	$strScript='<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = \'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.11&appId=206740246563578\';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));</script>';
	echo $strScript;
	$modal='<div class="modal fade modal-add-cart" id="modal-alert-add-cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header relative">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">

      </div>      
    </div>
  </div>
</div>  
';
	echo $modal;
	$tawk_to='<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src=\'https://embed.tawk.to/5b23257f61a2e64e5fb57e1f/default\';
s1.charset=\'UTF-8\';
s1.setAttribute(\'crossorigin\',\'*\');
s0.parentNode.insertBefore(s1,s0);
})();
</script>';
	echo $tawk_to;
}
/* end fanpage */

/* begin navbar */
add_shortcode('nav_bar','showNavbar');
function showNavbar(){
	require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php";	
}
/* end navbar */

/* begin search right */
add_shortcode('search_right','showSearchRight');
function showSearchRight(){
	global $zController, $zendvn_sp_settings;		
	$zController->getController("/frontend","ProductController");
	$telephone=$zendvn_sp_settings['telephone'];
	$terms = get_terms( array(
		'taxonomy' => 'za_category',
		'hide_empty' => false, 
		'parent' => 0 ) );	
	$source_category=array();
	$source_category[]=array('id'=>0,'name'=>'Tất cả danh mục');
	foreach ($terms as $key => $value) {
		$source_category[]=array('id'=>$value->term_id,'name'=>$value->name);
	}
	$page_id_cart = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php'); 
	$page_id_search = $zController->getHelper('GetPageId')->get('_wp_page_template','search.php');  
	$cart_link=get_permalink($page_id_cart );		
	$search_link = get_permalink($page_id_search); 
	$q='';
	$za_category_id=0;
	if(isset($_POST['q'])){
		$q=trim($_POST['q']);
	}    
	if(isset($_POST['za_category_id'])){
		$za_category_id=(int)@$_POST['za_category_id'];
	}	
	?>	
	<div class="row">
		<div class="col-lg-6">
			<form name="frm-search" method="POST" class="ritae" action="<?php echo $search_link; ?>">
				<div>
					<select name="za_category_id" class="xima">
						<?php 
						foreach ($source_category as $key => $value) {		
							if((int)@$value['id'] == (int)@$za_category_id){
								echo '<option selected value="'.$value['id'].'">'.$value['name'].'</option>';
							}else{
								echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
							}											
						}
						?>
					</select>
				</div>
				<div>
					<input type="text" name="q" class="lina" value="<?php echo $q; ?>" placeholder="Bạn cần gì hôm nay ?">
				</div>
				<div class="oppo">
					<a href="javascript:void(0);" onclick="document.forms['frm-search'].submit();"><i class="fa fa-search" aria-hidden="true"></i></a>
				</div>	
			</form> 
		</div>
		<div class="col-lg-2">
			<a class="kitae margin-left-15" href="<?php echo $cart_link; ?>">
				<div class="icon-header"><i class="fas fa-cart-arrow-down"></i></div>
				<div class="gian-ho"><font color="#ffffff">Giỏ hàng</font></div>
			</a>
		</div>
		<div class="col-lg-4">
			<div class="lexa">
				<div class="icon-header"><i class="fas fa-phone"></i></div>
				<div>
					<div><font color="#ffffff"><?php echo $telephone; ?></font></div>
					<div><font color="#ffffff">Hotline mua hàng</font></div>
				</div>
			</div>	
		</div>
	</div>	
	<?php
}
/* end search right */
/* begin banner */
add_shortcode('banner','loadBanner');
function loadBanner(){
	require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; 
}
/* end banner */
/* begin category homepage */
add_shortcode('category_home','loadCategoryHome');
function loadCategoryHome($attrs){		
	$term_slug=$attrs['cat'];
	$term = get_term_by('slug', $term_slug, 'za_category');	
	$term_link= get_term_link($term,'za_category');		
	$source_term_id=array($term->term_id);
	$alias='category-home-'.$term_slug;
	$alias_ads='category-home-ads-'.$term_slug;
	$source_manufacturer_slug=explode(',', $attrs['manufacturer']);	
	$source_ads=explode(',', $attrs['ads']);	
	$vHtml=new HtmlControl();	
	?>
	<div class="container">
		<div class="row">
			<div class="col-lg-12"> 
				<div class="category-home-box">
					<div class="row">
						<div class="col-lg-3"><div class="kep" style="background-color: <?php echo @$attrs['color_bar']; ?>" ></div></div>
						<div class="col-lg-9"></div>
					</div>
					<div class="row margin-top-10">
						<div class="col-lg-3"><h2 class="category-home-title"><a href="<?php echo $term_link; ?>"><?php echo $term->name; ?></a></h2></div>
						<div class="col-lg-9">							
							<div class="gakake">
								<?php 
								foreach ($source_manufacturer_slug as $key => $value) {
									$row_term = get_term_by('slug', $value, 'za_manufacturer');	
									$row_term_link= get_term_link($row_term,'za_manufacturer');		
									?>
									<div class="row-manufacturer"><a href="<?php echo $row_term_link; ?>"><?php echo $row_term->name; ?></a></div>
									<?php
								}
								?>
								<div class="view-all-category">
									<a href="<?php echo $term_link; ?>">
										<div class="labalaba">
											<div>Xem tất cả các sản phẩm</div>
											<div class="margin-left-5"><i class="fas fa-angle-right"></i></div>
										</div>										
									</a>
								</div>
							</div>
						</div>
					</div>					
					<div class="row margin-top-10">
						<div class="col-lg-3">
							<div>
								<script type="text/javascript" language="javascript">
									jQuery(document).ready(function(){
										jQuery(".<?php echo $alias_ads; ?>").owlCarousel({
											autoplay:true,                    
											loop:true,
											margin:0,                        
											nav:false,            
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
													items:1
												}
											}
										});											
									});                
								</script>
								<div class="owl-carousel <?php echo $alias_ads; ?> owl-theme">
									<?php 
									foreach ($source_ads as $key => $value) {
										?>
										<div><img src="<?php echo site_url('wp-content/uploads/'.$value); ?>"></div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<div class="col-lg-9">
							<?php 
							$args = array(
								'post_type' => 'zaproduct',  
								'orderby' => 'id',
								'order'   => 'DESC',  
								'posts_per_page' => 8,        								
								'tax_query' => array(
									array(
										'taxonomy' => 'za_category',
										'field'    => 'term_id',
										'terms'    => $source_term_id,									
									),
								),
							); 
							$the_query=new WP_Query($args);								
							if($the_query->have_posts()){
								?>
								<div>
									<script type="text/javascript" language="javascript">
										jQuery(document).ready(function(){
											jQuery(".<?php echo $alias; ?>").owlCarousel({
												autoplay:true,                    
												loop:true,
												margin:10,                        
												nav:false,            
												mouseDrag: true,
												touchDrag: true,                                
												responsiveClass:true,
												responsive:{
													0:{
														items:1
													},
													600:{
														items:4
													},
													1000:{
														items:4
													}
												}
											});
											var chevron_left='<i class="fa fa-chevron-left"></i>';
											var chevron_right='<i class="fa fa-chevron-right"></i>';
											jQuery("div.<?php echo $alias; ?> div.owl-prev").html(chevron_left);
											jQuery("div.<?php echo $alias; ?> div.owl-next").html(chevron_right);
										});                
									</script>
									<div class="owl-carousel <?php echo $alias; ?> owl-theme">
										<?php 
										while ($the_query->have_posts()){
											$the_query->the_post();
											$post_id=$the_query->post->ID;																		
											$permalink=get_the_permalink($post_id);
											$title=get_the_title($post_id);
											$featured_img=get_the_post_thumbnail_url($post_id, 'full');	
											$thumbnail=$vHtml->getSmallImage($featured_img);
											$sku=get_post_meta($post_id,"sku",true);
											$price=get_post_meta($post_id,"price",true);
											$sale_price=get_post_meta($post_id,"sale_price",true);											
											$html_price='';                     
											if((int)@$price > 0){
												if((int)@$sale_price > 0){              
													$price_off_html='<div class="price-off">'.$vHtml->fnPrice($price).' đ</div>' ;                 
													$price_on_html ='<div class="price-on">'.$vHtml->fnPrice($sale_price).' đ</div>';                                       
													$html_price=$price_off_html . $price_on_html ;              
												}else{
													$html_price='<div class="price-on">'.$vHtml->fnPrice($price).' đ</div>' ;                  
												}
											}else{
												$html_price='<div class="price-on">LIÊN HỆ</div>' ;                  
											}        	
											$intro=get_post_meta($post_id,"intro",true);
											$source_manufacturer = wp_get_object_terms($post_id,  'za_manufacturer' );     					
											$manufacturer_name='';
											$manufacturer_link='';
											if(count($source_manufacturer) > 0){
												$manufacturer_name=$source_manufacturer[0]->name;
												$manufacturer_link=get_term_link($source_manufacturer[0],'za_manufacturer');							
											}
											?>
											<div class="box-product">
												<div class="box-product-img bg-slider">
													<center><a href="<?php echo @$permalink; ?>"><img src="<?php echo @$thumbnail; ?>" alt="<?php echo @$title; ?>"></a></center>
													<?php 
													if((int)@$sale_price > 0){
														?>
														<div class="sale"><img src="<?php echo site_url('wp-content/uploads/sale.png'); ?>"></div>
														<?php
													}
													?>                                
												</div>
												<?php 
												if(!empty(@$manufacturer_link) && !empty(@$manufacturer_name)){
													?>
													<div class="manufacturer-name margin-top-10"><a href="<?php echo @$manufacturer_link; ?>"><?php echo @$manufacturer_name; ?></a></div>
													<?php
												}
												?>       
												<div class="box-product-title margin-top-10"><a href="<?php echo @$permalink; ?>" title="<?php echo @$title; ?>" ><b><?php echo @$title; ?></b></a></div>
												<?php 
												if(!empty(@$sku)){
													?>
													<div class="margin-top-10"><?php echo @$sku; ?></div>   
													<?php
												}                            
												if(!empty(@$intro)){
													?>
													<div class="box-product-intro margin-top-10">
														<?php echo $intro; ?>
													</div>                       
													<?php
												}												
												echo @$html_price; 
												?>            
												<div class="thia margin-top-10">
													<?php 
													if((int)@$price > 0){
														?>
														<a href="javascript:void(0);" data-toggle="modal" data-target="#modal-alert-add-cart" onclick="javascript:addToCart(<?php echo @$post_id; ?>,1);" >
															<img  src="<?php echo site_url('wp-content/uploads/mua-ngay.png'); ?>">                           
														</a>
														<?php
													}else{
														?>
														<a href="<?php echo site_url('lien-he'); ?>" >
															<img  src="<?php echo site_url('wp-content/uploads/mua-ngay.png'); ?>">                           
														</a>
														<?php
													}
													?>                                
												</div>
											</div>
											<?php
										}
										wp_reset_postdata();  
										?>	
									</div>
								</div>
								<?php								
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<?php 
}
/* end category homepage */
/* begin manufacturer_page */
add_shortcode('manufacturer_page','loadManufacturerPage');
function loadManufacturerPage($attrs){
	$item=$attrs['item'];
	$source_slug=explode(',', $item);	
	$k=0;
	foreach ($source_slug as $key => $value) {
		$term = get_term_by('slug', $value, 'za_manufacturer');	
		$term_link= get_term_link($term,'za_manufacturer');		
		$source_image= get_field( 'image','za_manufacturer_'. $term->term_id )	;		
		$image=$source_image['sizes']['large'];
		if($k%3==0){
			echo '<div class="row">';
		}
		?>
		<div class="col-lg-4"><div class="margin-top-15"><a href="<?php echo $term_link; ?>"><img src="<?php echo $image; ?>" /></a></div></div>
		<?php
		$k++;
		if($k%3==0 || $k==count($source_slug)){
			echo '</div>';
		}
	}			
}
/* end manufacturer_page */
/* begin tin tuc */
add_shortcode('news','loadNews');
function loadNews(){
	global $zController,$zendvn_sp_settings;    
	$vHtml=new HtmlControl();
	$productModel=$zController->getModel("/frontend","ProductModel"); 
	$args = array(
		'post_type' => 'post',  
		'orderby' => 'id',
		'order'   => 'DESC'     										
	);  
	$the_query = new WP_Query( $args );
	$totalItemsPerPage=0;
	$pageRange=10;
	$currentPage=1; 
	$totalItemsPerPage=9;
	if(!empty(@$_POST["filter_page"]))          {
		$currentPage=@$_POST["filter_page"];  
	}
	if(!empty(@$zendvn_sp_settings["article_number"])){
    	$totalItemsPerPage=(int)@$zendvn_sp_settings["article_number"];        
	}
	$productModel->setWpQuery($the_query);   
	$productModel->setPerpage($totalItemsPerPage);        
	$productModel->prepare_items();               
	$totalItems= $productModel->getTotalItems();               
	$arrPagination=array(
		"totalItems"=>$totalItems,
		"totalItemsPerPage"=>$totalItemsPerPage,
		"pageRange"=>$pageRange,
		"currentPage"=>$currentPage   
	);    
	$pagination=$zController->getPagination("Pagination",$arrPagination); 
	if($the_query->have_posts()){		
		$k=0;
		echo '<form  method="post"  class="frm tilan" name="frm">';		
		echo '<input type="hidden" name="filter_page" value="1" />';
		?>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="single-title">TIN TỨC</h1>
			</div>
		</div>
		<?php
		while ($the_query->have_posts()){
			$the_query->the_post();     
			$post_id=$the_query->post->ID;                          
			$permalink=get_the_permalink($post_id);
			$title=get_the_title($post_id);
			$excerpt=get_post_meta($post_id,"intro",true);
			$excerpt=substr($excerpt, 0,300).'...';         
			$content=get_the_content($post_id);
			$thumbnail=get_the_post_thumbnail_url($post_id, 'thumbnail');   
			?>
			<div class="margin-top-15">
				<div class="row">
					<div class="col-lg-2"><a href="<?php echo $permalink; ?>"><img src="<?php echo $thumbnail; ?>" /></a></div>
					<div class="col-lg-10">
						<h2 class="box-featured-article-title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h2>
						<div class="margin-top-15"><?php echo $excerpt; ?></div>
						<div class="box-featured-article-readmore">
							<a href="<?php echo $permalink; ?>">
								<div class="lialo">
									<div><i class="fas fa-arrow-circle-right"></i></div>
									<div class="margin-left-5">Xem thêm</div>
								</div>									
							</a>
						</div>
					</div>
				</div>
			</div>			
			<?php 		
		}
		wp_reset_postdata();  	
		echo $pagination->showPagination();
		echo '</form>';		
	}		
}
/* end tin tuc */