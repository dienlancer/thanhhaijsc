<div>    
    <?php    
    if(have_posts()){
            while (have_posts()) {
                the_post();
                echo '<h3 class="mamboitaliano">'.get_the_title().'</h3>';
            }
            wp_reset_postdata();
        } 
    global $zController,$zendvn_sp_settings;    
    $vHtml=new HtmlControl();        
    $pageIDLoginCheckout = $zController->getHelper('GetPageId')->get('_wp_page_template','login-checkout.php'); 
    $pageIDzcart = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');    
    $permarlinkLoginCheckout = get_permalink($pageIDLoginCheckout);            
    $permarlinkZcart = get_permalink($pageIDzcart);
    $ssValueCart="zcart";    
    $ssCart        = $zController->getSession('SessionHelper',"vmart",$ssValueCart);    
    $arrCart = $ssCart->get($ssValueCart)["cart"];     

    if(count($arrCart) == 0){        
        wp_redirect($permarlinkZcart);
    }

    $data=array();   
    $error=$zController->_data["error"];
    $success=$zController->_data["success"];                           
    if(count($zController->_data["data"]) > 0){
        $data=$zController->_data["data"];                  
    }

    $totalPrice=0;
    $totalQuantity=0;
    $page_id_register_member = $zController->getHelper('GetPageId')->get('_wp_page_template','register-member.php');  
    $register_member_link = get_permalink($page_id_register_member);

    ?>
    <div>
        <?php         
        if(count($error) > 0 || count($success) > 0){
            ?>
            <div class="alert">
                <?php                                           
                if(count($error) > 0){
                    ?>
                    <ul class="comproduct33">
                        <?php 
                        foreach ($error as $key => $value) {
                            ?>
                            <li><?php echo $value; ?></li>
                            <?php
                        }
                        ?>                              
                    </ul>
                    <?php
                }
                if(count($success) > 0){
                    ?>
                    <ul class="comproduct50">
                        <?php 
                        foreach ($success as $key => $value) {
                            ?>
                            <li><?php echo $value; ?></li>
                            <?php
                        }
                        ?>                              
                    </ul>
                    <?php
                }
                ?>                                              
            </div>              
            <?php
        }
        ?>              
        <table id="com_product16" class="com_product16" cellpadding="0" cellspacing="0" width="100%">
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

                        <td class="com_product20"><a href="<?php echo $product_link ?>"><?php echo $product_name; ?></a></td>
                        <td align="right" class="com_product21"><?php echo $vHtml->fnPrice($product_price); ?></td>
                        <td align="center" class="com_product22"><?php echo $product_quantity; ?></td>
                        <td align="right" class="com_product23"><?php echo $vHtml->fnPrice($product_total_price); ?></td>            
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
                    <td align="right"><?php echo $vHtml->fnPrice($totalPrice); ?></td>

                </tr>
            </tfoot>
        </table>       
        <div>
            <div class="col-md-8">

                <form method="post" name="frmRegisterMember">   
                <input type="hidden" name="action" value="register-checkout" />
                                    <?php wp_nonce_field("register-checkout",'security_code',true);?>              
                    <table id="com_product30" class="com_product30" border="0" width="100%" cellpadding="0" cellspacing="0">  
                        <thead><tr><th>Thanh toán không tài khoản ?</th></tr></thead>                    
                        <tbody>        
                            <tr>
                                <td align="right"><b><i>Tài khoản :</i></b></td>
                                <td><input type="text" name="username" value="<?php echo @$data["username"]; ?>" /></td>        
                            </tr>       
                            <tr>
                                <td align="right"><b><i>Mật khẩu :</i></b></td>
                                <td><input type="password" name="password" value="<?php echo @$data["password"]; ?>" /></td>        
                            </tr>
                            <tr>
                                <td align="right"><b><i>Xác nhận mật khẩu :</i></b></td>
                                <td><input type="password" name="password_confirm" value="<?php echo @$data["password_confirm"]; ?>" /></td>        
                            </tr>               
                            <tr>
                                <td align="right"><b><i>Email :</i></b></td>
                                <td><input type="text" name="email" value="<?php echo @$data["email"]; ?>" /></td>                   
                            </tr>                     
                            <tr>
                                <td align="right"><b><i>Tên :</i></b></td>
                                <td><input type="text" name="fullname" value="<?php echo @$data["fullname"]; ?>" /></td>            
                            </tr>
                            <tr>
                                <td align="right"><b><i>Địa chỉ :</i></b></td>
                                <td><input type="text" name="address" value="<?php echo @$data["address"]; ?>" /></td>            
                            </tr>                
                            <tr>
                                <td align="right"><b><i>Phone :</i></b></td>
                                <td><input type="text" name="phone" value="<?php echo @$data["phone"]; ?>" /></td>            
                            </tr>
                            <tr>
                                <td align="right"><b><i>Mobile phone :</i></b></td>
                                <td><input type="text" name="mobilephone" value="<?php echo @$data["mobilephone"]; ?>" /></td>            
                            </tr>
                            <tr>
                                <td align="right"><b><i>Fax :</i></b></td>
                                <td><input type="text" name="fax" value="<?php echo @$data["fax"]; ?>" /></td>            
                            </tr>   
                            <tr>           
                                <td></td>
                                <td class="com_product31" align="right">
                                    <input name="btnRegisterMember" type="submit" class="com_product32" value="Đăng ký" />
                                                            
                                </td>                      
                            </tr> 
                        </tbody>    
                    </table>
                </form>
            </div>
            <div class="col-md-4">
                <form method="post" name="frmLogin">
                    <input type="hidden" name="action" value="login-checkout" />
                                    <?php wp_nonce_field("login-checkout",'security_code',true);?>              
                    <table id="com_product30" class="com_product30" border="0" width="100%" cellpadding="0" cellspacing="0">
                        <thead><tr><th>Đăng nhập thanh toán</th></tr></thead>   
                        <tbody>
                            <tr>
                                <td colspan="2"><input type="text" name="username" value=""></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="password" name="password" value=""></td>
                            </tr>
                            <tr>
                                <td>
                                    <button type="submit" name="btnCheckLogin" class="com_product32">Đăng nhập</button>&nbsp;&nbsp;
                                    <a href="<?php echo $register_member_link; ?>" class="com_product32">Đăng ký</a>
                                    
                                </td>
                            </tr>               
                        </tbody>    

                    </table>    
                </form>
            </div>
            <div class="clr"></div>
        </div>
    </div>
</div>