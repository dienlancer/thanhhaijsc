<?php get_header(); ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php"; ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; ?>
<div class="margin-top-15">
    <div class="vc_row wpb_row section vc_row-fluid grid_section">
        <div class="section_inner clearfix">
            <div class="section_inner_margin clearfix">
                <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner">  
                        <?php                   
                        $page_id_zcart = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');                    
                        $permarlink_zcart = get_permalink($page_id_zcart);                
                        $ssValueCart="zcart";                
                        $ssCart        = $zController->getSession('SessionHelper',"vmart",$ssValueCart);                    
                        $arrCart = @$ssCart->get($ssValueCart)['cart'];                     
                        if(count($arrCart) == 0){        
                            wp_redirect($permarlink_zcart);                   
                        }   
                        $ssValueCart="zcart";
                        $ssCart        = $zController->getSession('SessionHelper',"vmart",$ssValueCart);     
                        $ssCart->reset();    
                        ?>
                        <div class="note note-success">Thanh toán thành công</div>
                    </div>
                </div>
            </div>            
        </div>
    </div>    
</div>
<?php get_footer(); ?>
<?php wp_footer();?>