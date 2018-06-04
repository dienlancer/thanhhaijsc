<?php
/*
Plugin Name: com_product
Plugin URI: http://cloudbeauty.vn
Description: Xay dung shopping don gian WP
Author: laptrinhtainhatui
Version: 1.0
Author URI: http://cloudbeauty.vn
*/
ob_start();
require_once 'define.php';
require_once PLUGIN_PATH . DS .  'includes'. DS .'Controller.php';
global $zController,$zendvn_sp_settings;
$zController = new zController();
$zendvn_sp_settings = get_option('zendvn_sp_setting',array());
if(!class_exists('HtmlControl')){
	require_once PLUGIN_PATH . DS . 'includes'. DS .'html.php';
}
if(is_admin()){
	require_once 'backend.php';
	new Backend();
}else{		
	require_once 'frontend.php';
	new Frontend();
	
}
require_once PLUGIN_PATH . DS . 'metabox'. DS .'post-metabox.php';
new PostMetabox();



