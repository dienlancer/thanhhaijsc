<?php 
get_header();
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php";
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; 
global $zController;
$vHtml=new HtmlControl();  
$page_id_login_checkout = $zController->getHelper('GetPageId')->get('_wp_page_template','login-checkout.php'); 
$page_id_zcart = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');    
$page_id_register_member = $zController->getHelper('GetPageId')->get('_wp_page_template','register-member.php');  
$register_member_link = get_permalink($page_id_register_member);
$permarlink_login_checkout = get_permalink($page_id_login_checkout);            
$permarlink_zcart = get_permalink($page_id_zcart);
$ssValueCart='zcart';
$ssCart        = $zController->getSession('SessionHelper',"vmart",$ssValueCart);    
$arrCart = $ssCart->get($ssValueCart)['cart'];     
if(count($arrCart) == 0){        
    wp_redirect($permarlink_zcart);
} 
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
                <table  class="com_product16" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>    
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng giá</th>        
                        </tr>
                    </thead>
                    <tbody>
                        <?php       
                        foreach ($arrCart as $key => $value) {    
                            $product_id=$value["product_id"];           
                            $product_name=$value["product_name"];
                            $product_link=get_the_permalink($value["product_id"]);
                            $product_quantity=$value["product_quantity"];
                            $product_price=$value["product_price"];
                            $product_total_price=$value["product_total_price"];
                            $totalPrice+=(float)$product_total_price;
                            $totalQuantity+=(float)$product_quantity;
                            ?>
                            <tr>

                                <td class="com_product20 td-left"><a href="<?php echo $product_link ?>"><?php echo $product_name; ?></a></td>
                                <td align="right" class="com_product21"><?php echo $vHtml->fnPrice($product_price) . ' đ'; ?></td>
                                <td align="center" class="com_product22"><?php echo $product_quantity; ?></td>
                                <td align="right" class="com_product23"><?php echo $vHtml->fnPrice($product_total_price) . ' đ'; ?></td>            
                            </tr>
                            <?php
                        } 
                        ?>                  
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                Tổng cộng
                            </td>
                            <td align="center"><?php echo $totalQuantity; ?></td>
                            <td align="right"><?php echo $vHtml->fnPrice($totalPrice) . ' đ'; ?></td>

                        </tr>
                    </tfoot>
                </table>       
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php                                                                             
                    if(count(@$zController->_data["data"]) > 0){
                        $data=@$zController->_data["data"];                  
                    }
                    $msg=@$zController->_data["msg"];  
                    $checked=@$zController->_data["checked"];   
                    if(count(@$msg) > 0){
                        $type_msg='';                   
                        if((int)@$checked == 1){                            
                            $type_msg='note-success';
                        }else{
                            $type_msg='note-danger';
                        }
                        ?>
                        <div class="note <?php echo $type_msg; ?>" >
                            <ul>
                                <?php 
                                foreach (@$msg as $key => $value) {
                                    ?>
                                    <li><?php echo $value; ?></li>
                                    <?php
                                }
                                ?>                              
                            </ul>   
                        </div>      
                        <?php
                    }   
                    ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <form method="post" name="frmRegisterMember">  
                    <input type="hidden" name="action" value="register-checkout" />
                    <?php wp_nonce_field("register-checkout",'security_code',true);?> 
                    <table class="com_product30" border="0" width="90%" cellpadding="0" cellspacing="0">    
                        <thead><tr><th>Thanh toán không tài khoản ?</th></tr></thead>                      
                        <tbody>        
                            <tr>
                                <td class="td-right">Tài khoản</td>
                                <td><input type="text" name="username" value="<?php echo @$data["username"]; ?>" /></td>        
                            </tr>       
                            <tr>
                                <td class="td-right">Mật khẩu</td>
                                <td><input type="password" name="password" value="<?php echo @$data["password"]; ?>" /></td>        
                            </tr>
                            <tr>
                                <td class="td-right">Xác nhận mật khẩu</td>
                                <td><input type="password" name="password_confirmed" value="<?php echo @$data["password_confirmed"]; ?>" /></td>        
                            </tr>               
                            <tr>
                                <td class="td-right">Email</td>
                                <td><input type="text" name="email" value="<?php echo @$data["email"]; ?>" /></td>                   
                            </tr>                     
                            <tr>
                                <td class="td-right">Tên</td>
                                <td><input type="text" name="fullname" value="<?php echo @$data["fullname"]; ?>" /></td>            
                            </tr>
                            <tr>
                                <td class="td-right">Địa chỉ</td>
                                <td><input type="text" name="address" value="<?php echo @$data["address"]; ?>" /></td>            
                            </tr>                
                            <tr>
                                <td class="td-right">Phone</td>
                                <td><input type="text" name="phone" value="<?php echo @$data["phone"]; ?>" /></td>            
                            </tr>                                                        
                            <tr>           
                                <td></td>
                                <td class="com_product31" class="td-right">

                                    <div class="btn-dang-ky"><a href="javascript:void(0);" onclick="document.forms['frmRegisterMember'].submit();" >Đăng ký</a></div>
                                </td>                      
                            </tr> 
                        </tbody>    
                    </table>   
                </form>
            </div>
            <div class="col-lg-4">
                <form method="post" name="frmLogin">
                    <input type="hidden" name="action" value="login-checkout" />
                    <?php wp_nonce_field("login-checkout",'security_code',true);?>  
                    <table class="com_product30" border="0" width="100%" cellpadding="0" cellspacing="0">
                        <thead><tr><th class="td-left">Đăng nhập thanh toán</th></tr></thead>   
                        <tbody>
                            <tr>
                                <td colspan="2"><input type="text" name="username" value=""></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="password" name="password" value=""></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="ritae">
                                        <div class="btn-dang-ky"><a href="javascript:void(0);" onclick="document.forms['frmLogin'].submit();" >Đăng nhập</a></div>
                                        <div class="btn-dang-ky margin-left-15"><a href="<?php echo $register_member_link; ?>" class="com_product32">Đăng ký</a></div>
                                    </div>                                    
                                </td>
                            </tr>               
                        </tbody>    

                    </table>       
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
get_footer(); 
wp_footer();
?>