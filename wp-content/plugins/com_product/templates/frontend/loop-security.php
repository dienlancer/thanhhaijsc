<div>  
    <?php
    if(have_posts()){
        while (have_posts()) {
            the_post();
            echo '<h3 class="mamboitaliano">'.get_the_title().'</h3>';
        }
        wp_reset_postdata();
    }
    $vHtml=new HtmlControl();
    $pageIDLogin = $zController->getHelper('GetPageId')->get('_wp_page_template','login.php');   
    $permarlinkLogin = get_permalink($pageIDLogin);  
    $ssName="vmuser";
    $ssValue="userlogin";
    $id=0;
    $ssUser     = $zController->getSession('SessionHelper',$ssName,$ssValue);
    $arrUser = @$ssUser->get($ssValue)["userInfo"];
    if(count($arrUser) == 0){
        wp_redirect($permarlinkLogin);
    }

    $id=$arrUser["id"];
    $userModel=$zController->getModel("/frontend","UserModel"); 
    $info=$userModel->getUserById($id);
    $detail=$info[0];
    $data=array();   
    $error=$zController->_data["error"];
    $success=$zController->_data["success"];                           
    if(count($zController->_data["data"]) > 0){
        $data=$zController->_data["data"];                  
    }else{
        $data=$detail;
    }
        ?>
        <form method="post" name="frm" class="margin-top-15"> 
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" name="username" value="<?php echo $detail["username"]; ?>" />
                            <input type="hidden" name="action" value="change-password" />                    
                            <?php wp_nonce_field("change-password",'security_code',true);?> 
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
            <table id="com_product30" class="com_product30" border="0" width="90%" cellpadding="0" cellspacing="0">                   
                <tbody>        
                    <tr>
                        <td align="right">Tài khoản</td>
                        <td><?php echo $data["username"]; ?></td>        
                    </tr>                           
                    <tr>
                        <td align="right">Mật khẩu</td>
                        <td><input type="password" name="password" /></td>        
                    </tr>
                    <tr>
                        <td align="right">Xác nhận mật khẩu</td>
                        <td><input type="password" name="password_confirm" /></td>        
                    </tr>   
                    <tr>           
                        <td></td>
                        <td class="com_product31" align="right">
                            <input name="btnChangeInfo" type="submit" class="com_product32" value="Cập nhật" />
                                              
                        </td>                       
                    </tr> 
                </tbody>    
            </table>
        </form>
     
</div>
