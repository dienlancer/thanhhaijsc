<?php
class AdminCategoryModel{
	public function __construct(){
		
	}
	public function create(){
	
		$labels = array(
				'name'				=> 'ZCategory',
				'singular' 			=> 'ZCategory',
				'menu_name'			=> 'zcategory',				
				'edit_item'			=> 'Edit zcategory',
				'update_item'		=> 'Update zcategory',
				'add_new_item'		=> 'Add new zcategory',
				'search_items'		=> 'Search categories',
				'popular_items'		=> 'Categories are using',
				'separate_items_with_commas' => 'Separate tags with commas 123',
				'choose_from_most_used' => 'Choose from the most used tags 123',
				'not_found'			=> 'No book category found',
	
		);
		$args = array(
				'labels' 				=> $labels,
				'public'				=> true,
				'show_tagcloud'			=> true,
				'hierarchical'			=> true,
				'show_admin_column'		=> false,
				'query_var'				=> true,
				'rewrite'				=> array('slug' => 'za_category'),
		);
		register_taxonomy('za_category', 'zaproduct',$args);
		flush_rewrite_rules(false);
	}
	
}