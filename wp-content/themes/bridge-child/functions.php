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
	wp_register_style( 'bootstrap_css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css' ,array(),false,'all' );
	wp_enqueue_style( 'bootstrap_css' );
	wp_register_script('bootstrap_js',get_stylesheet_directory_uri() . '/js/bootstrap.min.js',array(),false,false);
	wp_enqueue_script('bootstrap_js');
	/* end bootstrap */
	/* begin elevatezoom */
	wp_register_script('elevatezoom',get_stylesheet_directory_uri() . '/js/jquery.elevatezoom-3.0.8.min.js',array('jquery'),'1.0',false);
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
   remove_menu_page( 'wpseo_dashboard' ); 
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
}
/* end fanpage */
/* begin category product menu */
add_shortcode('category_product_sc','showCategoryProductMenu');
function showCategoryProductMenu(){	
	$args = array( 
		'menu'              => '', 
		'container'         => '', 
		'container_class'   => '', 
		'container_id'      => '', 
		'menu_class'        => 'category-product-menu', 
		'menu_id'           => '', 
		'echo'              => true, 
		'fallback_cb'       => 'wp_page_menu', 
		'before'            => '', 
		'after'             => '', 
		'link_before'       => '', 
		'link_after'        => '', 
		'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',  
		'depth'             => 3, 
		'walker'            => '', 
		'theme_location'    => 'category-product-menu' 
	);
	?>
	<div class="categoryproductmnsc">
		<div class="container">
			<div class="row">
				<div class="col-lg-12"><?php wp_nav_menu($args); ?></div>
			</div>
		</div>		
	</div>
	<?php	
}
/* end category product menu */
/* begin navbar */
add_shortcode('nav_bar','showNavbar');
function showNavbar(){
	?>
	<div class="nav_bar">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div class="canon">
						<div class="fata">
							<i><span></span><span></span><span></span></i>
						</div>
						<div class="margin-left-15"><b>Danh mục sản phẩm</b></div>						
					</div>
				</div>
				<div class="col-lg-9"></div>
			</div>
		</div>
	</div>
	<?php
}
/* end navbar */
/* begin search right */
add_shortcode('search_right','showSearchRight');
function showSearchRight(){
	$terms = get_terms( array(
		'taxonomy' => 'category_product',
		'hide_empty' => false,  ) );	
	$source_category=array();
	$source_category[]=array('id'=>0,'name'=>'Tất cả danh mục');
	foreach ($terms as $key => $value) {
		$source_category[]=array('id'=>$value->term_id,'name'=>$value->name);
	}		
	?>	
	<div class="row">
		<div class="col-lg-6">
			<form name="frm-search" method="POST" class="ritae" action="/tim-kiem-du-an">
				<div>
					<select name="category_product" class="xima">
						<?php 
						foreach ($source_category as $key => $value) {						
							echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
						}
						?>
					</select>
				</div>
				<div>
					<input type="text" name="q" class="lina" placeholder="Bạn cần gì hôm nay ?">
				</div>
				<div class="oppo">
					<a href="javascript:void(0);" onclick="document.forms['frm-search'].submit();"><i class="fa fa-search" aria-hidden="true"></i></a>
				</div>	
			</form>
		</div>
		<div class="col-lg-2">
			<a class="kitae" href="javascript:void(0);">
				<div class="icon-header"><i class="fas fa-cart-arrow-down"></i></div>
				<div class="gian-ho"><font color="#ffffff">Giỏ hàng</font></div>
			</a>
		</div>
		<div class="col-lg-4">
			<div class="lexa">
				<div class="icon-header"><i class="fas fa-phone"></i></div>
				<div>
					<div><font color="#ffffff">1900.1267</font></div>
					<div><font color="#ffffff">Hotline mua hàng</font></div>
				</div>
			</div>	
		</div>
	</div>	
	<?php
}
/* end search right */
