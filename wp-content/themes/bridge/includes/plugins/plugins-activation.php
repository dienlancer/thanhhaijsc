<?php

if(!function_exists('qode_register_theme_included_plugins')) {

	/**
	 * Registers theme required and optional plugins. Hooks to tgmpa_register hook
	 */

	function qode_register_theme_included_plugins()	{

		$plugins = array(
			array(
				'name'					=>  esc_html__('WPBakery Visual Composer', 'qode'),
				'slug'					=> 'js_composer',
				'source'				=> get_template_directory() . '/plugins/js_composer.zip', // The plugin source
				'required'				=> true,
				'version'				=> '5.4.4',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> '',
			),
			array(
				'name'     				=> esc_html__('LayerSlider WP', 'qode'),
				'slug'     				=> 'LayerSlider',
				'source'   				=> get_template_directory() . '/plugins/layersliderwp-6.6.4.installable.zip',
				'required' 				=> true,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			),
			array(
				'name'     				=> esc_html__('Revolution Slider', 'qode'),
				'slug'     				=> 'revslider',
				'source'   				=> get_template_directory() . '/plugins/revslider.zip',
				'required' 				=> false,
				'version' 				=> '5.4.6.3.1',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			),
			array(
				'name'					=> esc_html__('Envato Wordpress Toolkit', 'qode'),
				'slug'					=> 'envato-wordpress-toolkit',
				'source'				=> get_template_directory() . '/plugins/envato-wordpress-toolkit.zip',
				'required'				=> true,
				'version'				=> '',
				'force_activation'		=> false,
				'force_deactivation'	=> false,
				'external_url'			=> '',
			),
			array(
				'name'     				=> esc_html__('Timetable Responsive Schedule For WordPress', 'qode'),
				'slug'     				=> 'timetable',
				'source'   				=> get_template_directory() . '/plugins/timetable.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			),
			array(
				'name'        		=> esc_html__('Wp Job Manager', 'qode'),
				'slug'        		=> 'wp-job-manager',
				'required'          => false,
				'external_url'  	=> 'https://wordpress.org/plugins/wp-job-manager/',
			),
			array(
				'name'     				=> esc_html__('Qode Instagram Widget', 'qode'),
				'slug'     				=> 'qode-instagram-widget',
				'source'   				=> get_template_directory() . '/plugins/qode-instagram-widget.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			),
			array(
				'name'     				=> esc_html__('Qode Twitter Feed', 'qode'),
				'slug'     				=> 'qode-twitter-feed',
				'source'   				=> get_template_directory() . '/plugins/qode-twitter-feed.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			),
			array(
				'name'     				=> esc_html__('Quick Links', 'qode'),
				'slug'     				=> 'qode-quick-links',
				'source'   				=> get_template_directory() . '/plugins/qode-quick-links.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> '',
			),
			array(
				'name'     				=> esc_html__('Qode Listing', 'qode'),
				'slug'     				=> 'qode-listing',
				'source'   				=> get_template_directory() . '/plugins/qode-listing.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> '',
			),
			array(
				'name'     				=> esc_html__('Qode News', 'qode'),
				'slug'     				=> 'qode-news',
				'source'   				=> get_template_directory() . '/plugins/qode-news.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> '',
			),
			array(
				'name'     				=> esc_html__('Qode Restaurant', 'qode'),
				'slug'     				=> 'qode-restaurant',
				'source'   				=> get_template_directory() . '/plugins/qode-restaurant.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> '',
			),
			array(
				'name'     				=> esc_html__('Qode Membership', 'qode'),
				'slug'     				=> 'qode-membership',
				'source'   				=> get_template_directory() . '/plugins/qode-membership.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> '',
			)
		);


		$config = array(
			'domain'			=> 'qode',
			'default_path'		=> '',
			'parent_slug'		=> 'themes.php',
			'capability'		=> 'edit_theme_options',
			'menu'				=> 'install-required-plugins',
			'has_notices'		=> true,
			'is_automatic'		=> false,
			'message'			=> '',
			'strings'			=> array(
				'page_title'						=> esc_html__('Install Required Plugins', 'qode'),
				'menu_title'						=> esc_html__('Install Plugins', 'qode'),
				'installing'						=> esc_html__('Installing Plugin: %s', 'qode'),
				'oops'								=> esc_html__('Something went wrong with the plugin API.', 'qode'),
				'notice_can_install_required'		=> _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'qode'),
				'notice_can_install_recommended'	=> _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'qode'),
				'notice_cannot_install'				=> _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'qode'),
				'notice_can_activate_required'		=> _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'qode'),
				'notice_can_activate_recommended'	=> _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'qode'),
				'notice_cannot_activate'			=> _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'qode'),
				'notice_ask_to_update'				=> _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'qode'),
				'notice_cannot_update'				=> _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'qode'),
				'install_link'						=> _n_noop('Begin installing plugin', 'Begin installing plugins', 'qode'),
				'activate_link'						=> _n_noop('Activate installed plugin', 'Activate installed plugins', 'qode'),
				'return'							=> esc_html__('Return to Required Plugins Installer', 'qode'),
				'plugin_activated'					=> esc_html__('Plugin activated successfully.', 'qode'),
				'complete'							=> esc_html__('All plugins installed and activated successfully. %s', 'qode'),
				'nag_type'							=> 'updated'
			)
		);
		tgmpa($plugins, $config);
	}

	add_action( 'tgmpa_register', 'qode_register_theme_included_plugins' );
}