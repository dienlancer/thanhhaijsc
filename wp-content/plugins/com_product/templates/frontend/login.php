<?php 
get_header();
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php";
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; 
global $zController;
$vHtml=new HtmlControl();  
$page_id = $zController->getHelper('GetPageId')->get('_wp_page_template','account.php');   
$permalink = get_permalink($page_id);           
$ssName="vmuser";
$ssValue="userlogin";
$ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);
$arrUser = @$ssUser->get($ssValue);
if(count(@$arrUser) > 0){
    wp_redirect(@$permalink);
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
                <form method="post" name="frm" class="margin-top-15">    
                    <input type="hidden" name="action" value="login" />
                    <?php                     
                    wp_nonce_field("login",'security_code',true);                                            
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
                    <table class="com_product30" border="0" width="90%" cellpadding="0" cellspacing="0">                   
                        <tbody>        
                            <tr>
                                <td>Username</td>
                                <td><input type="text" name="username" value="<?php echo @$data["username"]; ?>"></td>
                            </tr>
                            <tr>
                                <td>Mật khẩu</td>
                                <td><input type="password" name="password" value="<?php echo @$data["password"]; ?>"></td>
                            </tr>                                                 
                            <tr>           
                                <td></td>
                                <td class="com_product31" class="td-right">
                                    <div class="btn-dang-ky"><a href="javascript:void(0);" onclick="document.forms['frm'].submit();" >Cập nhật</a></div>

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