<?php
class AdminManufacturerModel{
	public function __construct(){		
	}
	public function create(){
	
		$labels = array(
				'name'				=> 'Hãng sản xuất',
				'singular' 			=> 'Hãng sản xuất',
				'menu_name'			=> 'za_manufacturer',				
				'edit_item'			=> 'Chỉnh sửa',
				'update_item'		=> 'Cập nhật',
				'add_new_item'		=> 'Thêm mới',
				'search_items'		=> 'Tìm kiếm',
				'popular_items'		=> 'Phần tử đang được sử dụng',
				'separate_items_with_commas' => 'Separate tags with commas 123',
				'choose_from_most_used' => 'Choose from the most used tags 123',
				'not_found'			=> 'No book manufacturer found',
	
		);
		$args = array(
				'labels' 				=> $labels,
				'public'				=> true,
				'show_tagcloud'			=> true,
				'hierarchical'			=> true,
				'show_admin_column'		=> false,
				'query_var'				=> true,
				'rewrite'				=> array('slug' => 'za_manufacturer'),
		);
		register_taxonomy('za_manufacturer', 'zaproduct',$args);
		flush_rewrite_rules(false);
	}
	
}