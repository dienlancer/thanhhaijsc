<?php get_header(); ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php"; ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; ?>
<div class="container margin-top-15">
    <div class="row">        
        <div class="col-lg-12">
            <div>  
    <?php   
    $vHtml=new HtmlControl();
    $width=$zendvn_sp_settings["product_width"];
    $height=$zendvn_sp_settings["product_height"];
    $ssName="vmuser";
    $ssValue="userlogin";
    $ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);
    $arrUser = @$ssUser->get($ssValue);
    if(count($arrUser) == 0){
        wp_redirect($permarlinkLogin);
    }
    $user_id=$arrUser["id"];
    $model=$zController->getModel("/frontend","InvoiceModel");
    $arr_invoice=$model->getLstInvoiceByUserID($user_id);   
    $data = $zController->getHelper('DataConverter')->convertInvoiceToArrayData($arr_invoice);
        
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
    ?>
    <table  class="com_product16" cellpadding="0" cellspacing="0" width="100%">
    <thead>
    <tr>    
        <th>Mã đơn hàng</th>
        <th>Ngày tạo</th>
        <th>Username</th>
        <th>Họ tên</th>
        <th>Điện thoại</th>
        <th>Mobile phone</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
        <th>Trạng thái giao hàng</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php 
        
        for ($i=0; $i < count($data); $i++) { 
            $id = $data[$i]["id"];
            $quantity=$data[$i]["quantity"];
            $total_price_text=$data[$i]["total_price_text"];
            $total_price=$data[$i]["total_price"];
            $code=$data[$i]["code"];
            $lnk_image= wp_upload_dir()["url"] . "/" .  $width . "x" . $height . '-' ;            
            
            $status="";
            switch ($data[$i]["status"]) {
                case 1:
                    $status='<img src="'.PLUGIN_URL . "/public/backend/images/active.png".'" />' ;
                    break;
                case 0:
                    $status='<img src="'.PLUGIN_URL . "/public/backend/images/inactive.png".'" />' ;
                    break;          
            }
            ?>
            <tr>
                <td><?php echo $code; ?></td>
                <td><?php echo $data[$i]["created_date"]; ?></td>
                <td><?php echo $data[$i]["username"]; ?></td>
                <td><?php echo $data[$i]["fullname"]; ?></td>
                <td><?php echo $data[$i]["phone"]; ?></td>
                <td><?php echo $data[$i]["mobilephone"]; ?></td>
                <td align="center"><?php echo $quantity; ?></td>
                <td align="right"><?php echo $total_price_text; ?></td>
                <td align="center"><?php echo $status; ?></td>
                <td align="center"><a  data-toggle="modal" data-target="#modal-history-invoice" href="javascript:void(0);" onclick="showLstInvoiceDetail('<?php echo $lnk_image ;  ?>',<?php echo $id; ?>,<?php echo $quantity ?>,<?php echo $total_price; ?>);">Xem</a></td>
            </tr>
            <?php
        }
        ?>                              
    </tbody>    
</table>
 </div>

</div>

        </div>
    </div>
</div>
<?php get_footer(); ?>
<?php wp_footer();?>