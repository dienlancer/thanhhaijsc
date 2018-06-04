<?php
class PageMetabox{
	private $_metabox_id="zendvn-sp-page";
	private $_prefix_id="zendvn-sp-page-";	
	private $_prefix_key="_zendvn_sp_page_";
	public function __construct(){
		global $zController;
		preg_match('#(?:.+\/)(.+)#', $_SERVER['SCRIPT_NAME'],$matches);
		$phpFile = $matches[1];		
		$post_type=$zController->getParams("post_type");
		if($post_type != 'zaproduct'){
			if($phpFile == 'post.php' || $phpFile == 'post-new.php'){				
				add_action("add_meta_boxes",array($this,"display"));								
				if($zController->isPost()){
					add_action("save_post",array($this,"save"));
				}
			}
		}							
	}
	public function display(){
		add_meta_box($this->_metabox_id,"Chi tiết",array($this,"displayDetail"),"page");		
	}
	public function displayDetail(){
		global $zController , $post ;
		$vHtml=new HtmlControl(); 
		wp_nonce_field($this->_metabox_id,$this->_metabox_id . "-nonce");
		// Tạo phần tử chứa giới thiệu sơ bộ
		$inputID = $this->create_id("intro");
		$inputName = $this->create_id("intro");
		$inputValue = get_post_meta($post->ID,$this->create_key("intro"),true);		
		$html		='<div><b>Giới thiệu</b></div><div>'.$vHtml->cmsTextarea($inputID,$inputName,"widefat",$inputValue,8,120).'</div>' ;
		echo $html;			
	}
	public function save($post_id){

		global $zController,$zendvn_sp_settings;			
		$arrParam = $zController->getParams();
		$wpnonce_name = $this->_metabox_id . '-nonce';
		$wpnonce_action = $this->_metabox_id;		
		
		//zendvn-sp-zsproduct-nonce
		if(!isset($arrParam[$wpnonce_name])) return $post_id;
		
		if(!wp_verify_nonce($arrParam[$wpnonce_name],$wpnonce_action)) return $post_id;
		
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		
		if(!current_user_can('edit_post')) return $post_id;
				
		$arrData =  array(
					'intro' 	=> trim($arrParam[$this->create_id('intro')])					
					
				);
		if(!isset($arrParam['save'])){
			$arrData['view'] = 0;
		}
		foreach ($arrData as $key => $val){
			update_post_meta($post_id, $this->create_key($key), $val);
		}				
	}
	public function create_id($val){
		return $this->_prefix_id . $val;
	}
	public function create_key($val){
		return $this->_prefix_key . $val;
	}
}