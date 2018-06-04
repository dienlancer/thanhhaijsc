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
		add_meta_box($this->_metabox_id,"Thumbnail",array($this,"displayThumbnail"),"post");		
	}
	public function displayThumbnail(){
		global $zController, $post;
		wp_nonce_field($this->_metabox_id,$this->_metabox_id . "-nonce");				
		$vHtml=new HtmlControl(); 
		$width=intval(get_option('thumbnail_size_w'));	
		$height=intval(get_option('thumbnail_size_h'));		
		$width=$width/4;
		$height=$height/4;		
		$btnMedia='<a onclick="openMedia(this,\''.$this->_prefix_id.'\');" class="button button-primary button-large" href="javascript:void(0);">Add Media</a>';
		echo $btnMedia;
		$data_ordering = get_post_meta($post->ID,$this->create_key('img-ordering'),true);  
		$data_picture = get_post_meta($post->ID,$this->create_key('img-url'),true);		
		$source=array_combine($data_ordering, $data_picture);
		ksort($source);					
		?>		
		<div class="show-images">
			<?php 
			$k=1;
			if(count($source) > 0){
				foreach($source as $key => $value){
					?>
					<div class="box-img">
						<div class="baramen">
							<div><img src="<?php echo $value;?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"/></div>
							<div><center><a class="remove-img" href="javascript:void(0);" onclick="zendvn_sp_remove_image(this);">Remove</a></center></div>
							<div><center><input value="<?php echo $key;?>" class="ordering" name="<?php echo $this->_prefix_id; ?>img-ordering[]" type="text"></center></div>
							<div><input name="<?php echo $this->_prefix_id; ?>img-url[]" value="<?php echo $value;?>" type="hidden"></div>		
						</div>						
					</div>
					<?php
					if($k%4==0 || count($source) == $k){
						echo '<div class="clr"></div>';
					} 
					$k++;
				}
			}
			?>			
		</div>
		<?php
	}
	public function save($post_id){
		global $zController;	
		$width=intval(get_option('thumbnail_size_w'));	
		$height=intval(get_option('thumbnail_size_h'));				
		$arrParam = $zController->getParams();
		$wpnonce_name = $this->_metabox_id . '-nonce';
		$wpnonce_action = $this->_metabox_id;							
		if(!isset($arrParam[$wpnonce_name])) return $post_id;		
		if(!wp_verify_nonce($arrParam[$wpnonce_name],$wpnonce_action)) return $post_id;		
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;		
		if(!current_user_can('edit_post')) return $post_id;		
		$arrData =  array(			
			'img-ordering' 	=> array_map('absint',$arrParam[$this->create_id('img-ordering')]),
			'img-url' 		=> $arrParam[$this->create_id('img-url')],											
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