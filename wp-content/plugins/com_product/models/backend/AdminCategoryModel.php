<?php
class AdminCategoryModel{
	public function __construct(){
		
	}
	public function create(){
	
		$labels = array(
				'name'				=> 'Danh mục sản phẩm',
				'singular' 			=> 'Danh mục sản phẩm',
				'menu_name'			=> 'za_category',				
				'edit_item'			=> 'Chỉnh sửa',
				'update_item'		=> 'Cập nhật',
				'add_new_item'		=> 'Thêm mới',
				'search_items'		=> 'Tìm kiếm',
				'popular_items'		=> 'Item đang được sử dụng',
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