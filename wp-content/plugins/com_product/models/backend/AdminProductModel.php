<?php
class AdminProductModel{	
	public function __construct(){

	}
	public function create(){		
		$labels = array(
				'name' 				=> 'ZA Product',
				'singular_name' 	=> 'ZA Product',
				'menu_name'			=> 'ZA Product',
				'name_admin_bar' 	=> 'ZA Product',
				'add_new'			=> 'Add ZA Product',
				'add_new_item'		=> 'Add New ZA Product',
				'search_items' 		=> 'Search ZA Product',
				'not_found'			=> 'No products found',
				'not_found_in_trash'=> 'No products found in Trash',
				'view_item' 		=> 'View product',
				'edit_item'			=> 'Edit product',
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
 				'taxonomies'           => array('za_category'),
 				'has_archive'          => true,
 				'rewrite'              => array('slug'=>'zaproduct'),
 				'_edit_link'           => 'post.php?&post_type=zaproduct&post=%d',
		);		
		register_post_type('zaproduct',$args);
		flush_rewrite_rules(false);
	}
	
}