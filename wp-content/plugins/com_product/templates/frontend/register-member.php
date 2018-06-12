<?php 
get_header();
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php";
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; 
global $zController;
$vHtml=new HtmlControl();
$zController->getController("/frontend","ProductController");
$disabled_status='';
$register_status='onclick="document.forms[\'frm\'].submit();"';
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
                    <input type="hidden" name="action" value="register-member" />      
                    <?php                     
                    wp_nonce_field("register-member",'security_code',true);                        
                    $data=array();   
                    if(count(@$zController->_data["data"]) > 0){
                        $data=@$zController->_data["data"];                  
                    }
                    $msg=@$zController->_data["msg"];  
                    $checked=@$zController->_data["checked"];   
                    if(count(@$msg) > 0){
                        $type_msg='';                   
                        if((int)@$checked == 1){     
                            $disabled_status='disabled';
                            $register_status='';                       
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
                    <table class="com_product30" border="0" width="90%" cellpadding="0" cellspacing="0">                   
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
                                    
<div class="btn-dang-ky"><a href="javascript:void(0);" <?php echo $register_status; ?> >Đăng ký</a></div>
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