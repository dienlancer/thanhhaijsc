<?php
class CreatePage{
	
	private $_templatePage;
	
	public function __construct(){		
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {
			// 4.6 and older
			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_template' )
			);
		} else {
			// Add a filter to the wp 4.7 version attributes metabox
			add_filter(
				'theme_page_templates', array( $this, 'add_new_template' )
			);
		}
		
		add_filter('wp_insert_post_data', array($this,'register_template'));
		
		add_filter(
			'template_include', 
			array( $this, 'view_project_template') 
		);

		
		$this->_templatePage = array(					
					'zcart.php' => 'Giỏ hàng',
					'register-member.php' => 'Đăng ký thành viên',
					'account.php' => 'Tài khoản',
					'checkout.php' => 'Thanh toán',
					'login-checkout.php' => 'Đăng nhập thanh toán',
					'finished-checkout.php' => 'Hoàn tất thanh toán',
					'login.php' => 'Đăng nhập',
					'security.php' => 'Bảo mật',
					'history.php' => 'Lịch sử giao dịch',
					'zshopping.php' => 'Hiển thị tất cả chuyên mục sản phẩm',
					'contact.php' => 'Liên hệ',
					'search.php' => 'Tìm kiếm',					
					'reservation.php' => 'Đặt bàn',
				);	
	}
	
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->_templatePage );
		return $posts_templates;
	}
	
	public function register_template($attrs){
		//echo '<br/>' . __METHOD__;
		
		$cache_key = 'page_templates-' . md5(get_theme_root() . '/' . get_stylesheet());
		
		$templates = wp_get_theme()->get_page_templates();
		
		if ( empty( $templates ) ) {
			$templates = array();
		} 
		
		wp_cache_delete($cache_key,'themes');
		
		$templates = array_merge($templates,$this->_templatePage);
		
		wp_cache_add($cache_key, $templates,'themes', 1800);
		
		return $attrs;
	}
	
	public function view_project_template( $template ) {
		
		// Get global post
		global $post;
		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}
		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->templates[get_post_meta( 
			$post->ID, '_wp_page_template', true 
		)] ) ) {
			return $template;
		} 
		$file = plugin_dir_path( __FILE__ ). get_post_meta( 
			$post->ID, '_wp_page_template', true
		);
		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}
		// Return template
		return $template;
	}
}