<?php
class AdminProductController{		
	private $_metabox_id="zendvn-sp-zaproduct";
	private $_prefix_id="zendvn-sp-zaproduct-";	
	private $_prefix_key="_zendvn_sp_zaproduct_";
	public function __construct(){
		global $zController;		
		$model = $zController->getModel("/backend","AdminProductModel");
		add_action('init',array($model,'create'));	
		preg_match('#(?:.+\/)(.+)#', $_SERVER['SCRIPT_NAME'],$matches);
		$phpFile = $matches[1];
		if($zController->getParams("post_type")=="zaproduct"){
			if($phpFile == 'post.php' || $phpFile == 'post-new.php'){
				add_action("add_meta_boxes",array($this,"display"));								
				if($zController->isPost()){
					add_action("save_post",array($this,"save"));
				}
			}
			if($phpFile == 'edit.php'){
				add_filter('manage_posts_columns', array($this,'add_column'));
				add_action('manage_zaproduct_posts_custom_column', array($this,'display_value_column'),10,2);
				add_filter('manage_edit-zaproduct_sortable_columns', array($this,'sortable_cols'));
				add_action('pre_get_posts', array($this,'modify_query'));
				add_action('restrict_manage_posts', array($this,'za_category_list'));
			}			
		}				
	}
	public function za_category_list(){
		global $zController;
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All ZA Category"),
			'taxonomy'			=> 'za_category',
			'name'				=> 'za_category',
			'orderby'			=> 'name',
			'selected'			=> $zController->getParams('za_category'),
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
		
		
		if($zController->getParams('za_category') > 0){
			
			$tax_query = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'za_category',
					'field'		=> 'term_id',
					'terms'		=> $zController->getParams('za_category'),
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
			echo get_the_term_list($post_id, 'za_category','', ', ');
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
	public function display(){
		add_meta_box($this->_metabox_id,"Images of product",array($this,"thumbnail"),"zaproduct");
		add_meta_box($this->_metabox_id."-detail","Detail",array($this,"detail"),"zaproduct");
	}
	public function save($post_id){

		global $zController,$zendvn_sp_settings;	
		$width=$zendvn_sp_settings["product_width"];	
		$height=$zendvn_sp_settings["product_height"];			
		$arrParam = $zController->getParams();
		$wpnonce_name = $this->_metabox_id . '-nonce';
		$wpnonce_action = $this->_metabox_id;
		$thumbnail_id 	= get_post_thumbnail_id($post_id);	
		$featureImg=wp_get_attachment_image_src($thumbnail_id,"single-post-thumbnail");	
		$imgThumbnailHelper=$zController->getHelper("ImgThumbnail");			
		if(count($featureImg)>0){						
			$imgThumbnailHelper->resizeImage($featureImg[0],$width,$height);
		}		
		if(count($arrParam[$this->create_id('img-url')]) > 0){			
			foreach ($arrParam[$this->create_id('img-url')] as $key => $value) {				
				if(!empty($value)){
					$imgThumbnailHelper->resizeImage($value,$width,$height);
				}
			}
		}		
		
		//zendvn-sp-zsproduct-nonce
		if(!isset($arrParam[$wpnonce_name])) return $post_id;
		
		if(!wp_verify_nonce($arrParam[$wpnonce_name],$wpnonce_action)) return $post_id;
		
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		
		if(!current_user_can('edit_post')) return $post_id;
		
		$arrData =  array(			
			'img-ordering' 	=> array_map('absint',$arrParam[$this->create_id('img-ordering')]),
			'img-url' 		=> $arrParam[$this->create_id('img-url')],					
			'price' 		=> filter_var($arrParam[$this->create_id('price')],FILTER_VALIDATE_FLOAT),
			'sale_price' 	=> filter_var($arrParam[$this->create_id('sale_price')],FILTER_VALIDATE_FLOAT),			
			
		);
		if(!isset($arrParam['save'])){
			$arrData['view'] = 0;
		}
		foreach ($arrData as $key => $val){
			update_post_meta($post_id, $this->create_key($key), $val);
		}				
	}
	public function detail(){
		global $zController , $post ;
		$vHtml=new HtmlControl(); 
		wp_nonce_field($this->_metabox_id,$this->_metabox_id . "-nonce");	
			
		// Tạo phần tử chứa giá
		$inputID = $this->create_id("price");
		$inputName = $this->create_id("price");
		$inputValue = get_post_meta($post->ID,$this->create_key("price"),true);
		$inputValue=filter_var($inputValue,FILTER_VALIDATE_FLOAT);
		$label='<label><b>Price</b></label>';
		$textbox=$vHtml->cmsTextbox($inputID,$inputName,"", $inputValue);
		$html='<div class="form-field">'.$label.'<br/>'.$textbox.'</div>';
		echo $html;		
		// tạo phần tử chứa giá khuyến mãi
		$inputID = $this->create_id("sale_price");
		$inputName = $this->create_id("sale_price");
		$inputValue = get_post_meta($post->ID,$this->create_key("sale_price"),true);
		$inputValue=filter_var($inputValue,FILTER_VALIDATE_FLOAT);
		$label='<label><b>Sale price</b></label>';
		$textbox=$vHtml->cmsTextbox($inputID,$inputName,"", $inputValue);
		$html='<div class="form-field">'.$label.'<br/>'.$textbox.'</div>';
		echo $html;	
		
	}
	public function thumbnail(){
		global $zController;
		wp_nonce_field($this->_metabox_id,$this->_metabox_id . "-nonce");
		$zController->_data["controller"]=$this;
		$zController->getView("/backend/product/thumbnail.php");
	}
	public function create_id($val){
		return $this->_prefix_id . $val;
	}
	public function create_key($val){
		return $this->_prefix_key . $val;
	}
}