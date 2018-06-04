<?php
class ModuleArticle extends WP_Widget {

	public function __construct() {		
		$id_base = 'module-article';
		$name	= 'ModuleArticle';
		$widget_options = array(
					'classname' => 'module-article',
					'description' => 'ModuleArticle'
				);
		$control_options = array('width'=>'350px');
		parent::__construct($id_base, $name,$widget_options, $control_options);	
	}	
	public function widget( $args, $instance ) {			
		extract($args);		
		$title = apply_filters('widget_title', $instance['title']);			
		echo $before_widget;
		echo $before_title . $title . $after_title;				 
		require PLUGIN_PATH . DS . 'module'. DS .'html'. DS .'module-article.php';		
		echo $after_widget;						
	}
	
	public function update( $new_instance, $old_instance ) {			 
		$instance = $old_instance;		
		$instance['title'] 				= strip_tags($new_instance['title']);		
		$instance['category_id'] 		= strip_tags($new_instance['category_id']);		
		$instance['items_per_page'] 	= $new_instance['items_per_page'];		
		$instance['description'] 		= $new_instance['description'];					
		$instance['position'] 			= $new_instance['position'];		
		return $instance;
	}
	
	public function form( $instance ) {	
		global $zController;
		$vHtml = new HtmlControl();

		$inputID 	= $this->get_field_id('title');
		$inputName 	= $this->get_field_name('title');
		$inputValue = @$instance['title'];
		$class = array("widefat");
		$html		= $vHtml->label('Title',array('for'=>$inputID))
					. $vHtml->cmsTextbox($inputID,$inputName,"widefat",$inputValue);
		echo $vHtml->pTag($html);			
			
		$inputID 	= $this->get_field_id('category_id');
		$inputName 	= $this->get_field_name('category_id');
		$inputValue = @$instance['category_id'];				
		$args = array(
				'show_option_all'    => translate('All category'),
				'show_option_none'   => '',
				'orderby'            => 'ID',
				'order'              => 'ASC',
				'show_count'         => 1,
				'hide_empty'         => 1,
				'child_of'           => 0,
				'exclude'            => '',
				'echo'               => 0,
				'selected'           => $inputValue,
				'hierarchical'       => 1,
				'name'               => $inputName,
				'id'                 => $inputID,
				'class'              => 'widefat',
				'depth'              => 0,
				'tab_index'          => 0,
				'taxonomy'           => 'category',
				'hide_if_empty'      => false,
		);				
		$html		= $vHtml->label(translate('Categories'),array('for'=>$inputID))
						. wp_dropdown_categories($args);
		echo $vHtml->pTag($html);

		$inputID 	= $this->get_field_id('items_per_page');
		$inputName 	= $this->get_field_name('items_per_page');
		$inputValue = @$instance['items_per_page'];
		$class = array("widefat");
		$html		= $vHtml->label('Số phần tử lấy ra',array('for'=>$inputID))
					. $vHtml->cmsTextbox($inputID,$inputName,"widefat",$inputValue);
		echo $vHtml->pTag($html);	

		$inputID 	= $this->get_field_id('description');
		$inputName 	= $this->get_field_name('description');
		$inputValue = @$instance['description'];
		$class = array("widefat");
		$html		= $vHtml->label('Description',array('for'=>$inputID))
					. '<br/><textarea id="'.$inputID.'" cols="50" rows="10" name="'.$inputName.'">'.$inputValue.'</textarea>';
		echo $vHtml->pTag($html);	

		$inputID 	= $this->get_field_id('position');
		$inputName 	= $this->get_field_name('position');
		$inputValue = @$instance['position'];
		$class = array("widefat");
		$html		= $vHtml->label('Position',array('for'=>$inputID))
					. $vHtml->cmsTextbox($inputID,$inputName,"widefat",$inputValue);
		echo $vHtml->pTag($html);		
	}
}

