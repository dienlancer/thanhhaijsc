<?php get_header(); ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php"; ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; ?>
<div class="container margin-top-15">
	<div class="row">
		<div class="col-lg-3">
			<div class="col-left">
				<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "manufacturer-sidebar.php"; ?>
			</div>			
		</div>
		<div class="col-lg-9">
			<?php get_template_part("loop","za-category"); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
<?php wp_footer();?>