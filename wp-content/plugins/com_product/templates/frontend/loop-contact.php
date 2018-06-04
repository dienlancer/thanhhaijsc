<?php 
global $zendvn_sp_settings;
$map_url=$zendvn_sp_settings['ban_do'];
?>
<div class="tina relative">    
    <div class="oppo">
        <div class="relative">
            <div class="nina">
                <?php 
                if(have_posts()){                                   
                    while (have_posts()) {
                        the_post();                                                                                     
                        the_title();
                    }
                    wp_reset_postdata();                                
                }
                ?>            
            </div>
            <div class="tma"></div>
        </div>            
    </div>    
    <div>
        <script type="text/javascript" language="javascript">        
            jQuery(document).ready(function(){
                jQuery(".linda").slick({
                    dots: true,
                    autoplay:true,
                    arrows:false,
                    adaptiveHeight:true,
                    loop:true
                });  
            });     
        </script>
        <div class="linda">
            <div class="lumberjack">                            
                <img src="<?php echo site_url('wp-content/uploads/banner-top.jpg'); ?>" />                               
            </div>
        </div>
    </div>       
</div> 
<div class="hexa padding-top-5 padding-bottom-15">
    <div class="container">
        <div class="row">                
            <div class="col-lg-4 no-padding-left">
                <form method="post" name="frm" action="" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="contact" />                    
                            <?php wp_nonce_field("contact",'security_code',true);?>   
                            <?php 
                            $data=array();   
                            $error=$zController->_data["error"];
                            $success=$zController->_data["success"];                           
                            if(count($zController->_data["data"]) > 0){
                                $data=$zController->_data["data"];                  
                            }
                            if(count($error) > 0 || count($success) > 0){
                                ?>
                                <div class="form-group alert">
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
                            <div class="margin-top-5"><input type="input" class="form-control" name="fullname" placeholder="Họ và tên" /></div>
                            <div class="margin-top-5"><input type="input" class="form-control" name="email" placeholder="Email" /></div>
                            <div class="margin-top-5"><input type="input" class="form-control" name="mobile" placeholder="Điện thoại"/></div>
                            <div class="margin-top-5"><input type="input" class="form-control" name="title" placeholder="Chủ đề" /></div>
                            <div class="margin-top-5"><input type="input" class="form-control" name="address" placeholder="Địa chỉ" /></div>
                            <div class="margin-top-5"><textarea name="content" class="form-control" placeholder="Nội dung"></textarea></div>
                            <div class="margin-top-5">
                                <input type="submit" name="btnSend" class="btn btn-default" value="Gửi" />                    
                            </div>              
                        </form>                            
            </div>
            <div class="col-lg-8 no-padding-left">
                <?php 
                $args = array(          
                    'name' => 'thong-tin-lien-he',
                    'post_type'=>'page'
                );
                $the_query = new WP_Query($args);       
                if($the_query->have_posts()){                                   
                    while ($the_query->have_posts()) {
                        $the_query->the_post();     
                        $post_id=$the_query->post->ID;                          
                        $permalink=get_the_permalink($post_id);
                        $title=get_the_title($post_id);
                        $content=get_the_content( $post_id );
                        $excerpt=substr(get_the_excerpt( $post_id ), 0,200).'...';          
                        $featureImg=wp_get_attachment_url(get_post_thumbnail_id($post_id));                     
                        echo $content;
                    }
                    wp_reset_postdata();                                
                }
                ?>                      
            </div>
            <div class="clr"></div>        
        </div>  
        <div class="row margin-top-15">
            <iframe src="<?php echo $map_url; ?>" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>                
    </div>
</div>