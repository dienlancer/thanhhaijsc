<?php
class ModuleItem extends WP_Widget {

	public function __construct() {		
		$id_base = 'module-item';
		$name	= 'ModuleItem';
		$widget_options = array(
					'classname' => 'module-item',
					'description' => 'ModuleItem'
				);
		$control_options = array('width'=>'350px');
		parent::__construct($id_base, $name,$widget_options, $control_options);	
	}	
	public function widget( $args, $instance ) {			
		extract($args);		
		$title = apply_filters('widget_title', $instance['title']);			
		echo $before_widget;
		echo $before_title . $title . $after_title;				 
		require PLUGIN_PATH . DS . 'module'. DS .'html'. DS .'module-item.php';		
		echo $after_widget;						
	}
	
	public function update( $new_instance, $old_instance ) {			 
		$instance = $old_instance;		
		$instance['title'] 		= strip_tags($new_instance['title']);				
		$instance['item_id'] 	= $new_instance['item_id'];					
		$instance['position'] 	= $new_instance['position'];		
		return $instance;
	}
	
	public function form( $instance ) {	
		$vHtml = new HtmlControl();

		$inputID 	= $this->get_field_id('title');
		$inputName 	= $this->get_field_name('title');
		$inputValue = @$instance['title'];
		$class = array("widefat");
		$html		= $vHtml->label('Title',array('for'=>$inputID))
					. $vHtml->cmsTextbox($inputID,$inputName,"widefat",$inputValue);
		echo $vHtml->pTag($html);			
			
		$inputID 	= $this->get_field_id('item_id');
		$inputName 	= $this->get_field_name('item_id');
		$inputValue = @$instance['item_id'];
		$class = array("widefat");
		$html		= $vHtml->label('ItemID',array('for'=>$inputID))
					. $vHtml->cmsTextbox($inputID,$inputName,"widefat",$inputValue);
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

