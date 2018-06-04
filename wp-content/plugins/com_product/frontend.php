<?php
class Frontend{	
	public function __construct(){
		global $zController;
		//add_action('init', array($zController->getModel("/backend","AdminCategoryModel"),'create'));
		//add_action('init', array($zController->getModel("/backend","AdminProductModel"),'create'));				
		add_filter('template_include', array($this,'load_template'));			
		add_action('init', array($this,'do_output_buffer'));				
	}	
	public function do_output_buffer(){
		ob_start();
	}	
	public function load_template($templates){
		global $wp_query, $post;
		if(is_page() == 1){
			$page_template = get_post_meta($post->ID,'_wp_page_template', true);			
			$file = PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . $page_template;						
			if(file_exists($file)){
				return $file;
			}
		}
		if(get_query_var('za_category') != ''){
			$file = PLUGIN_PATH  . "templates" . DS . "frontend" . DS . 'za-category.php';
			if(file_exists($file)){
				return $file;
			}			
		}
		if(get_query_var('zaproduct') != ''){
			$file = PLUGIN_PATH  . "templates" . DS . "frontend" . DS . 'zaproduct.php';
			if(file_exists($file)){			
				return $file;
			}
		}
		return $templates;
	}
}
