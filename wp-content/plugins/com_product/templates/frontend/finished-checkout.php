<?php get_header(); ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php"; ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; ?>
<div class="container margin-top-15">
    <div class="row">        
        <div class="col-lg-12">
            <div>  
                <?php   
                $pageIDLoginCheckout = $zController->getHelper('GetPageId')->get('_wp_page_template','login-checkout.php'); 
                $pageIDzcart = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');    
                $permarlinkLoginCheckout = get_permalink($pageIDLoginCheckout);            
                $permarlinkZCart = get_permalink($pageIDzcart);
                $ssValueUser="userlogin";
                $ssValueCart="zcart";
                $ssUser       = $zController->getSession('SessionHelper',"vmuser",$ssValueUser);
                $ssCart        = $zController->getSession('SessionHelper',"vmart",$ssValueCart);    
                $arrUser = @$ssUser->get($ssValueUser)['user_info']; 
                $arrCart = $ssCart->get($ssValueCart)['cart'];     
                $result=true;      
                if(count($arrUser) == 0)        {
                    wp_redirect($permarlinkLoginCheckout); 
                    $result=false;
                }           
                if(count($arrCart) == 0){        
                    wp_redirect($permarlinkZCart);
                    $result=false;
                }   
                if($result==true){
                    $ssValueCart="zcart";
                    $ssCart        = $zController->getSession('SessionHelper',"vmart",$ssValueCart);     
                    $ssCart->reset();   
                }   
                ?>
                <div class="comproduct35">Thanh toán thành công</div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<?php wp_footer();?>