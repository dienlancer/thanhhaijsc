<?php 
get_header(); 
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php";
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; 
?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="tilan"><?php get_template_part("loop","single"); ?></div>
		</div>
	</div>
</div>
<?php
get_footer();
wp_footer();
?>            
