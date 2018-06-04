<?php
class AdminBannerController{		
	private $_metabox_id="zendvn-sp-banner";
	private $_prefix_id="zendvn-sp-banner-";	
	private $_prefix_key="_zendvn_sp_banner_";
	public function __construct(){
		global $zController;				
		preg_match('#(?:.+\/)(.+)#', $_SERVER['SCRIPT_NAME'],$matches);
		$phpFile = $matches[1];
		if($zController->getParams("post_type")=="banner"){			
			if($phpFile == 'edit.php'){				
				add_action('manage_banner_posts_custom_column', array($this,'display_value_column'),10,2);
				add_filter('manage_edit-banner_sortable_columns', array($this,'sortable_cols'));
				add_action('pre_get_posts', array($this,'modify_query'));
				add_action('restrict_manage_posts', array($this,'category_banner_list'));
			}			
		}				
	}
	public function category_banner_list(){
		global $zController;
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All ZA Category"),
			'taxonomy'			=> 'category_banner',
			'name'				=> 'category_banner',
			'orderby'			=> 'name',
			'selected'			=> $zController->getParams('category_banner'),
			'hierarchical'		=> true,
			'depth'				=> 3,
			'show_count'		=> true,
			'hide_empty'		=> true,
			
		));
	}
	public function modify_query($query){
		global $zController;
		if($zController->getParams('orderby') == ''){
			$query->set('orderby','ID');
			$query->set('order','DESC');
		}
		
		$orderby = $query->get('orderby');
		
		if($orderby == 'view'){
			$query->set('meta_key',$this->create_key('view'));
			$query->set('orderby','meta_value_num');
		}
		
		
		if($zController->getParams('category_banner') > 0){
			
			$tax_query = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category_banner',
					'field'		=> 'term_id',
					'terms'		=> $zController->getParams('category_banner'),
				));
			$query->set('tax_query',$tax_query);
		}
		
	}
	public function sortable_cols($columns){		
		$columns['id'] 		= 'ID';
		$columns['view'] 	= 'view';
		return $columns;
	}
	public function display_value_column($column,$post_id){		
		if($column == 'id'){
			echo $post_id;
		}
		if($column == 'view'){
			$view  = get_post_meta($post_id, $this->create_key('view'),true);
			if($view == null){
				update_post_meta($post_id, $this->create_key('view'), 0);
				echo '0';
			}else{
				echo $view;
			}
			
		}		
		if($column == 'category'){
			echo get_the_term_list($post_id, 'category_banner','', ', ');
		}
	}
	public function add_column($columns){		
		$newArr = array();
		foreach ($columns as $key => $title){
			$newArr[$key] = $title;
			if($key == 'author'){
				$newArr['category'] = __('Category');
			}
		}
		
		$new_columns = array(
			'view'=> __('View'),
			'id' => __('ID')
		);
		$newArr = array_merge($newArr,$new_columns);
		return $newArr;
	}
	
}