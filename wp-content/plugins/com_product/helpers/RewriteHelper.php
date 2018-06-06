<?php
class RewriteHelper{
	
	public function __construct($options = array()){
		add_action('init', array($this,'add_tags_rule'));
		register_deactivation_hook($options['file'], array($this,'plugin_deactivation'));
	}	
	public function plugin_deactivation(){
		flush_rewrite_rules(false);
	}		
	public function add_tags_rule(){
		add_rewrite_tag('%zaproduct%', '([^/]+)');
		add_permastruct('zaproduct', 'chi-tiet-san-pham/%zaproduct%.html');		
		add_rewrite_tag('%za_category%', '([^/]+)');
		add_permastruct('za_category', 'loai-san-pham/%za_category%.html');		
		flush_rewrite_rules(false);
	}
	
	
}