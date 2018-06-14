<?php 
get_header();
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php";
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; 
global $zController;
$vHtml=new HtmlControl();  

$page_id_zcart = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');          
$permarlink_zcart = get_permalink(@$page_id_zcart);
$ssValueCart="zcart";
$ssCart        = $zController->getSession('SessionHelper',"vmart",$ssValueCart);    
$arrCart = @$ssCart->get($ssValueCart)['cart'];   
if(count(@$arrCart) == 0){
    wp_redirect($permarlink_zcart);
} 
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
$total_price=0;
$total_quantity=0;
$data=array();
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
                <table class="com_product16" cellpadding="0" cellspacing="0" width="100%">
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
                            $total_price+=(float)$product_total_price;
                            $total_quantity+=(float)$product_quantity;
                            ?>
                            <tr>
                                <td class="com_product20 td-left"><a href="<?php echo $product_link ?>"><?php echo $product_name; ?></a></td>
                                <td align="right" class="com_product21"><?php echo $vHtml->fnPrice($product_price).' đ' ; ?></td>
                                <td align="center" class="com_product22"><?php echo ($product_quantity) ; ?></td>
                                <td align="right" class="com_product23"><?php echo $vHtml->fnPrice($product_total_price).' đ' ; ?></td>            
                            </tr>
                            <?php
                        } 
                        ?>                  
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="td-left">
                                <b>Tổng cộng</b>
                            </td>
                            <td align="center"><?php echo ($total_quantity) ; ?></td>
                            <td align="right"><?php echo $vHtml->fnPrice($total_price) . ' đ' ; ?></td>

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
        <form method="post" name="frm">                         
            <input type="hidden" name="action" value="confirmed-checkout" />
            <input type="hidden" name="total_price" value="<?php echo @$total_price; ?>" />
            <input type="hidden" name="total_quantity" value="<?php echo @$total_quantity; ?>" />                    
            <?php wp_nonce_field("confirmed-checkout",'security_code',true);?>                 
            <div class="row">
                <div class="col-lg-6">
                    <table class="com_product30" border="0" width="90%" cellpadding="0" cellspacing="0"> 
                        <thead><tr><th colspan="2" class="td-left">Thông tin khách hàng</th></tr></thead>                   
                        <tbody>                                                        
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
                                <td class="td-right vep">Ghi chú</td>
                                <td class="td-left"><textarea name="note" cols="65" rows="5"><?php echo @$data["note"]; ?></textarea></td>            
                            </tr>                                                                                    
                        </tbody>    
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="com_product30" border="0" cellpadding="0" cellspacing="0">   
                        <thead><tr><th class="td-left">Hình thức thanh toán</th></tr></thead>     
                        <tbody>        
                            <tr>
                                <td class="td-left"><font color="red"><b><i>Vui lòng chọn một hình thức thanh toán *</i></b></font></td>                    
                            </tr>                                               
                            <tr>
                                <td>
                                    <select class="form-control" name="payment_method_id" onchange="changePaymentMethod(this.value);">
                                        <?php 
                                        foreach ($lstPaymentMethod as $key => $value) {
                                            $payment_method_id=$value["id"];
                                            $title=$value["title"];
                                            if((int)@$data["payment_method_id"] == (int)@$payment_method_id)
                                                echo '<option selected value="'.$payment_method_id.'">'.$title.'</option>';                               
                                            else
                                                echo '<option          value="'.$payment_method_id.'">'.$title.'</option>';                               
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
                                    <div class="btn-dang-ky"><a href="javascript:void(0);" onclick="document.forms['frm'].submit();" >Thanh toán</a></div>

                                </td>                      
                            </tr> 
                        </tbody>    
                    </table>
                </div>
            </div>
        </form>
    </div>
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
<?php 
get_footer(); 
wp_footer();
?>