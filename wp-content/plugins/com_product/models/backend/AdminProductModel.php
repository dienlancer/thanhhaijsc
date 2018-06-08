<?php
class AdminProductModel{	
	public function __construct(){

	}
	public function create(){		
		$labels = array(
				'name' 				=> 'Sản phẩm',
				'singular_name' 	=> 'Sản phẩm',
				'menu_name'			=> 'Sản phẩm',
				'name_admin_bar' 	=> 'Sản phẩm',
				'add_new'			=> 'Thêm mới',
				'add_new_item'		=> 'Thêm mới',
				'search_items' 		=> 'Tìm kiếm',
				'not_found'			=> 'No products found',
				'not_found_in_trash'=> 'No products found in Trash',
				'view_item' 		=> 'Xem',
				'edit_item'			=> 'Chỉnh sửa',
				);
		$args = array(
				'labels'               => $labels,
				'description'          => 'Show product list',
				'public'               => true,
 				'hierarchical'         => true,
 				'show_in_nav_menus'    => true,
 				'show_in_admin_bar'    => true,
 				'menu_position'        => 5,
 				'capability_type'      => 'post',
 				'supports'             => array('title' ,'editor','author','custom-fields' ,'comments','thumbnail'),
 				'taxonomies'           => array('za_category','za_manufacturer'),
 				'has_archive'          => true,
 				'rewrite'              => array('slug'=>'zaproduct'),
 				'_edit_link'           => 'post.php?&post_type=zaproduct&post=%d',
		);		
		register_post_type('zaproduct',$args);
		flush_rewrite_rules(false);
	}
	
}