<?php 
$meta_key = "_zendvn_sp_zaproduct_";                   
global $zController,$zendvn_sp_settings;    
$vHtml=new HtmlControl();    
/* begin load config contact */
$width=$zendvn_sp_settings["product_width"];    
$height=$zendvn_sp_settings["product_height"];    
$width_thumbnail=$width/5;
$height_thumbnail=$height/5;  
$email_to=$zendvn_sp_settings['email_to'];
$address=$zendvn_sp_settings['address'];
$website=$zendvn_sp_settings['website'];
$telephone=$zendvn_sp_settings['telephone'];
$contaced_name=$zendvn_sp_settings['contacted_name'];
$facebook_url=$zendvn_sp_settings['facebook_url'];
$twitter_url=$zendvn_sp_settings['twitter_url'];
$google_plus=$zendvn_sp_settings['google_plus'];
$youtube_url=$zendvn_sp_settings['youtube_url'];
$instagram_url=$zendvn_sp_settings['instagram_url'];
$pinterest_url=$zendvn_sp_settings['pinterest_url'];     

/* end load config contact */
$term_slug='';
$the_query=$wp_query;
$post_id=0;
if($the_query->have_posts()){
    while ($the_query->have_posts()){
        $the_query->the_post();                            
        $post_id=$the_query->post->ID;                                             
        $permalink=get_the_permalink($post_id);                    
        $title=get_the_title($post_id);                            
        $content=get_the_content($post_id);        
        $arrPicture=array();
        $featureImg=get_the_post_thumbnail_url($post_id, 'full');        
        $small_img=$vHtml->getSmallImage($featureImg);            
        $term = wp_get_object_terms( $post_id,  'za_category' );                    
        $term_name=$term[0]->name;
        $term_slug=$term[0]->slug;
        $product_code=get_post_meta( $post_id,'code', true );        
        $price_text="";
        $sale_price_text="";
        $price=get_post_meta( $post_id, $meta_key . 'price', true );            
        $sale_price=get_post_meta( $post_id, $meta_key . 'sale_price', true );           
        if(!empty($price)){
            $price_text='<div class="bellesa-price">'.$vHtml->fnPrice($price).'</div>';
        }
        if(!empty($sale_price)){
            $sale_price_text='<div class="bellesa-sale-price">'.$vHtml->fnPrice($sale_price).'</div>';
        }        
            ?>
            <form  method="post"  class="frm" name="frm">                
                <h3 class="mamboitaliano"><?php echo $term_name; ?></h3>
                <div class="margin-top-15">
                    <div class="col-sm-4">
                        <div>
                            <center><img class="zoom" src="<?php echo $small_img; ?>" data-zoom-image="<?php echo $featureImg; ?>" /></center>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div>
                            <h3 class="bellesa-product-detail-title"><?php echo $title; ?></h3>
                            <div class="bellesa-zaproduct">                                    
                                <ul>
                                    <li><a href="javascript:void(0;)"><i class="fa fa-star"></i></a></li>
                                    <li><a href="javascript:void(0;)"><i class="fa fa-star"></i></a></li>
                                    <li><a href="javascript:void(0;)"><i class="fa fa-star"></i></a></li>
                                    <li><a href="javascript:void(0;)"><i class="fa fa-star"></i></a></li>
                                    <li><a href="javascript:void(0;)"><i class="fa fa-star-o"></i></a></li>
                                </ul>                                   
                            </div>
                            <?php echo $price_text; ?>
                            <?php echo $sale_price_text; ?>
                            <div class="bellesa-cart">
                                <ul class="inline-block">
                                    <li>
                                        <input type="text" name="quantity" value="1" class="quantity" onkeypress="return isNumberKey(event);" />
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-alert-add-cart" onclick="javascript:addToCart(<?php echo $post_id; ?>,document.getElementsByName('quantity')[0].value);" >Add to cart</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="bellesa-hr margin-top-15"></div>
                            <div class="bellesa-detail">
                                <?php echo $content; ?>
                            </div>
                            <div class="bellesa-hr margin-top-15"></div>
                            <div class="share-product">Share this product</div>
                            <div class="bellesa-social margin-top-5">
                                <ul class="inline-block social">
                                    <li><a href="<?php echo $facebook_url; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="<?php echo $twitter_url; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="<?php echo $instagram_url; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                    <li><a href="<?php echo $google_plus; ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                    <li><a href="<?php echo $linkedin_url; ;?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <script language="javascript" type="text/javascript">
                    jQuery('.zoom').elevateZoom({
                        zoomType: "inner",
                        cursor: "crosshair",
                        zoomWindowFadeIn: 500,
                        zoomWindowFadeOut: 750
                    });
                </script>  
            </form>            
            <?php
        }
    }
?>
