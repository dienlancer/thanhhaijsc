<?php get_header(); ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php"; ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; ?>
<div class="container margin-top-15">
    <div class="row">
        <div class="col-lg-3">
            
                <?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "manufacturer-sidebar.php"; ?>
              
        </div>
        <div class="col-lg-9">
            <div class="col-right">     
                <?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "loop-za-category.php"; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<?php wp_footer();?>