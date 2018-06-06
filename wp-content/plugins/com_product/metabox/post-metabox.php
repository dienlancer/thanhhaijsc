<?php
class PostMetabox{
	private $_metabox_id="zendvn-sp-post";
	private $_prefix_id="zendvn-sp-post-";	
	private $_prefix_key="_zendvn_sp_post_";
	public function __construct(){
		global $zController;
		preg_match('#(?:.+\/)(.+)#', $_SERVER['SCRIPT_NAME'],$matches);
		$phpFile = $matches[1];		
		$post_type=$zController->getParams("post_type");
		if($post_type != 'zaproduct' && $post_type != 'page'){
			if($phpFile == 'post.php' || $phpFile == 'post-new.php'){				
				add_action("add_meta_boxes",array($this,"display"));								
				if($zController->isPost()){
					add_action("save_post",array($this,"save"));
				}
			}
		}							
	}
	public function display(){
		add_meta_box($this->_metabox_id,"Chi tiết",array($this,"displayDetail"),"post");		
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
		// Tạo phần tử chứa nickname
		$inputID = $this->create_id("nickname");
		$inputName = $this->create_id("nickname");
		$inputValue = get_post_meta($post->ID,$this->create_key("nickname"),true);				
		$html		='<div><b>Nickname</b></div><div>'.$vHtml->cmsTextbox($inputID,$inputName,"form-control", $inputValue).'</div>' ;		
		echo $html;
		// Tạo phần tử chứa giá
		$inputID = $this->create_id("price");
		$inputName = $this->create_id("price");
		$inputValue = get_post_meta($post->ID,$this->create_key("price"),true);				
		$html		='<div><b>Price</b></div><div>'.$vHtml->cmsTextbox($inputID,$inputName,"form-control", $inputValue).'</div>' ;		
		echo $html;
		// Tạo phần tử chứa videoclip
		$inputID = $this->create_id("video-clip");
		$inputName = $this->create_id("video-clip");
		$inputValue = get_post_meta($post->ID,$this->create_key("video-clip"),true);		
		$html		='<div><b>Video</b></div><div>'.$vHtml->cmsTextarea($inputID,$inputName,"widefat",$inputValue,8,120).'</div>' ;
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
					'intro' 	=> trim($arrParam[$this->create_id('intro')])	,
					'nickname' 	=> trim($arrParam[$this->create_id('nickname')])	,
					'price' 	=> trim($arrParam[$this->create_id('price')])	,		
					'video-clip' 	=> trim($arrParam[$this->create_id('video-clip')])	,				
					
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