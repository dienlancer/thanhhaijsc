<?php     
global $zController,$zendvn_sp_settings;
$vHtml=new HtmlControl();    
$pageIDLoginCheckout = $zController->getHelper('GetPageId')->get('_wp_page_template','login-checkout.php'); 
$pageIDzcart = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');    
$permarlinkLoginCheckout = get_permalink($pageIDLoginCheckout);            
$permarlinkZCart = get_permalink($pageIDzcart);
$ssValueUser="userlogin";
$ssValueCart="zcart";
$ssUser       = $zController->getSession('SessionHelper',"vmuser",$ssValueUser);
$ssCart        = $zController->getSession('SessionHelper',"vmart",$ssValueCart);    
$arrUser = @$ssUser->get($ssValueUser)["userInfo"]; 
$arrCart = $ssCart->get($ssValueCart)["cart"];   
if(count($arrUser) == 0){    
    wp_redirect($permarlinkLoginCheckout);    
}
if(count($arrCart) == 0){
    wp_redirect($permarlinkZCart);
}    

$id=$arrUser["id"];
$userModel=$zController->getModel("/frontend","UserModel"); 
$info=$userModel->getUserById($id);
$detail=$info[0];   

$payment=array(
    "thanh-toan-qua-ngan-hang",
    "thanh-toan-bang-tien-mat"
);
$lstPaymentMethod=array();
$lstPaymentMethod[]=array("id"=>0,"title"=>"","content"=>"");
foreach ($payment as $key => $value) {
    $args=array(
        "name"=>$value,
        "post_type"=>"payment_method"
    );
    $the_query = new WP_Query( $args );
    if($the_query->have_posts()){
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $post_id=$the_query->post->ID;
            $title=get_the_title($post_id);
            $content=get_the_content($post_id);
            $item=array();
            $item["id"]=$post_id;
            $item["title"]=$title;
            $item["content"]=$content;
            $lstPaymentMethod[]=$item;
        }
    }
}

 
$totalPrice=0;
$totalQuantity=0;
$data=array();   
$error=$zController->_data["error"];
$success=$zController->_data["success"];                           
if(count($zController->_data["data"]) > 0){
    $data=$zController->_data["data"];                  
}else{
    $data=$detail;
}
?>
<div>
    <?php                      
    if(have_posts()){
        while (have_posts()) {
            the_post();
            echo '<h3 class="mamboitaliano">'.get_the_title().'</h3>';
        }
        wp_reset_postdata();
    }                     
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
                    <td align="right" class="com_product21"><?php echo $vHtml->fnPrice($product_price) ; ?></td>
                    <td align="center" class="com_product22"><?php echo ($product_quantity) ; ?></td>
                    <td align="right" class="com_product23"><?php echo $vHtml->fnPrice($product_total_price) ; ?></td>            
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
                <td align="center"><?php echo ($totalQuantity) ; ?></td>
                <td align="right"><?php echo $vHtml->fnPrice($totalPrice) ; ?></td>

            </tr>
        </tfoot>
    </table>
    <form method="post" name="frm">
        <input type="hidden" name="user_id" value="<?php echo @$detail["id"]; ?>" />
                            <input type="hidden" name="hiddenUsername" value="<?php echo @$detail["username"]; ?>" />
                            <input type="hidden" name="total_price" value="<?php echo @$totalPrice; ?>" />
                            <input type="hidden" name="total_quantity" value="<?php echo @$totalQuantity; ?>" />
                            <input type="hidden" name="action" value="confirm-checkout" />                    
                            <?php wp_nonce_field("confirm-checkout",'security_code',true);?>                 
        <div class="col-md-6">
            <table id="com_product30" class="com_product30" border="0" cellpadding="0" cellspacing="0" width="100%">   
                <thead><tr><th>Thông tin khách hàng</th></tr></thead>     
                <tbody>        
                    <tr>
                        <td align="right"><b><i>Tài khoản :</i></b></td>
                        <td><?php echo @$detail["username"]; ?></td>        
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
                </tbody>    
            </table>
        </div>
        <div class="col-md-6">
            <table id="com_product30" class="com_product30" border="0" cellpadding="0" cellspacing="0">   
                <thead><tr><th>Hình thức thanh toán</th></tr></thead>     
                <tbody>        
                    <tr>
                        <td align="left"><font color="red"><b><i>Vui lòng chọn một hình thức thanh toán *</i></b></font></td>                    
                    </tr>                                               
                    <tr>
                        <td>
                            <select class="form-control" name="payment_method" onchange="changePaymentMethod(this.value);">
                                <?php 
                                foreach ($lstPaymentMethod as $key => $value) {
                                    $id=$value["id"];
                                    $title=$value["title"];
                                    if((int)@$data["payment_method"] == (int)@$id)
                                        echo '<option selected value="'.$id.'">'.$title.'</option>';                               
                                    else
                                        echo '<option          value="'.$id.'">'.$title.'</option>';                               
                                }                            
                                ?>                                                    
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="payment_method_content"></span></td>
                    </tr>
                    <tr>                               
                        <td class="com_product31" align="right">
                            <input name="btnChangeInfo" type="submit" class="com_product32" value="Thanh toán" />
                                                
                        </td>                      
                    </tr> 
                </tbody>    
            </table>
        </div> 
        <div class="clr"></div>   
    </form>
</div>
<script type="text/javascript">
    function changePaymentMethod(payment_method_id) {
        var dataObj = {
            "action"    : "load_payment_method_info",
            "payment_method_id"     : payment_method_id,                    
            "security"  : security_code
        };
        jQuery.ajax({
            url         : ajaxurl,
            type        : "POST",
            data        : dataObj,
            dataType    : "json",
            success     : function(data, status, jsXHR){
                jQuery("span.payment_method_content").empty();                
                if(data != null){
                    jQuery("span.payment_method_content").append(data.content);
                }               
            }
        });
    }
</script>


