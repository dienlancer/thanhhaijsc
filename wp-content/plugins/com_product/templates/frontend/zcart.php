<?php 
get_header();
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php";
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; 
global $zController;
$vHtml=new HtmlControl();  
$ssName="vmart";
$ssValue="zcart";
$ssCart     = $zController->getSession('SessionHelper',$ssName,$ssValue);
$arrCart = @$ssCart->get($ssValue)['cart']; 
?>
<div class="siman">  
    <div class="container">
        <div class="row">        
            <div class="col-lg-12">
                <h1>
                    <?php 
                    if(have_posts()){
                        while (have_posts()) {
                            the_post();
                            echo '<h1 class="category-title">'.get_the_title().'</h1>';
                        }
                        wp_reset_postdata();
                    }
                    ?>
                </h1>
                <form method="post" name="frm" class="margin-top-15">    
                    <input type="hidden" name="action" value="update-cart" />
                    <?php                     
                    wp_nonce_field("update-cart",'security_code',true);                                                                
                    ?>                    
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
get_footer(); 
wp_footer();
?>