<?php 
get_header(); 
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php";
require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; 

global $zController,$zendvn_sp_settings;    
$vHtml=new HtmlControl();    
$width=$zendvn_sp_settings["product_width"];    
$height=$zendvn_sp_settings["product_height"];    
$width_thumbnail=$width/5;
$height_thumbnail=$height/5;
$post_id=0;
$term_id=0;
?>
<div class="col-right">
    <div class="container margin-top-15">   
        <?php 
        $the_query=$wp_query;
        if($the_query->have_posts()){
            while ($the_query->have_posts()){
                $the_query->the_post();                            
                $post_id=$the_query->post->ID; 
                $title=get_the_title($post_id);  
                $permalink=get_the_permalink($post_id);      
                $term = wp_get_object_terms( $post_id,  'za_category' );   
                $term_id=$term[0]->term_id;                          
                $term_name=$term[0]->name;
                $term_slug=$term[0]->slug;
                $featured_img=get_the_post_thumbnail_url($post_id, 'full');        
                $thumbnail=$vHtml->getSmallImage($featured_img);      
                $sku=get_post_meta($post_id,"sku",true);
                $price=get_post_meta($post_id,"price",true);
                $sale_price=get_post_meta($post_id,"sale_price",true);        
                $html_price='';   
                if((int)@$price > 0){
                    if((int)@$sale_price > 0){              
                        $price_off_html='<div class="riu"><div>Giá niêm yết : </div><div class="detail-price-off">'.$vHtml->fnPrice($price).' đ</div></div>' ;                 
                        $price_on_html ='<div class="riu"><div>Giá bán : </div><div class="detail-price-on">'.$vHtml->fnPrice($sale_price).' đ</div></div>';                                       
                        $html_price=$price_off_html . $price_on_html ;              
                    }else{
                        $html_price='<div class="riu"><div>Giá bán : </div><div class="detail-price-on">'.$vHtml->fnPrice($price).' đ</div></div>' ;                  
                    }
                }else{
                    $html_price='<div class="riu"><div>Giá : </div><div class="detail-price-on">LIÊN HỆ</div></div>' ;
                }                                  
                $intro=get_post_meta($post_id,"intro",true);
                $technical=get_post_meta($post_id,"technical",true);
                $video_id=get_post_meta($post_id,"video_id",true);
                $content=get_the_content($post_id);  
                $source_manufacturer = wp_get_object_terms($post_id,  'za_manufacturer' );                      
                $manufacturer_name='';
                $manufacturer_link='';
                if(count($source_manufacturer) > 0){
                    $manufacturer_name=$source_manufacturer[0]->name;
                    $manufacturer_link=get_term_link($source_manufacturer[0],'za_manufacturer');                            
                }        
                ?>
                <div class="row"> 
                    <div class="col-lg-6">
                        <div>
                            <center><img class="zoom" src="<?php echo $thumbnail; ?>" data-zoom-image="<?php echo $featured_img; ?>" /></center>
                        </div>
                    </div>       
                    <div class="col-lg-6">
                        <form  method="post"  class="frm" name="frm">
                            <h1 class="category-title">
                                <div>Trang chủ</div>
                                <div class="margin-left-5"><i class="fas fa-angle-right"></i></div>
                                <div class="margin-left-5"><?php echo $term_name; ?></div>
                            </h1>
                            <h2 class="product-intro"><?php echo $intro; ?></h2>
                            <div class="product-title margin-top-10"><?php echo $title; ?></div>
                            <?php echo $html_price; ?>
                            <div class="product-title margin-top-10"><span class="manufacturer-title">HÃNG SẢN XUẤT : </span><?php echo $manufacturer_name; ?></div>
                            <div class="riu margin-top-15">
                                <div><input type="text" name="quantity" value="1" class="quantity" onkeypress="return isNumberKey(event);" /></div>
                                <div class="bellesa-cart margin-left-5">
                                    <?php 
                                    if((int)@$price > 0){
                                        ?>
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-alert-add-cart" onclick="javascript:addToCart(<?php echo $post_id; ?>,document.getElementsByName('quantity')[0].value);" >THÊM VÀO GIỎ HÀNG</a>
                                        <?php
                                    }else{
                                        ?>
                                        <a href="<?php echo site_url('lien-he'); ?>" >LIÊN HỆ</a>
                                        <?php
                                    }
                                    ?>                                    
                                </div>                                
                            </div>
                        </form>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <script type="text/javascript" language="javascript">
                            function openCity(evt, cityName) {    
                                var i, tabcontent, tablinks;
                                tabcontent = document.getElementsByClassName("tabcontent");
                                for (i = 0; i < tabcontent.length; i++) {
                                    tabcontent[i].style.display = "none";
                                }   
                                tablinks = document.getElementsByClassName("tablinks");
                                for (i = 0; i < tablinks.length; i++) {
                                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                                }   
                                document.getElementById(cityName).style.display = "block";
                                evt.currentTarget.className += " active";
                            }
                            jQuery(document).ready(function(){
                                jQuery("#description").show();
                                jQuery("div.tab > button.tablinks:first-child").addClass('active');
                            });
                        </script>
                        <div class="tab">
                            <button class="tablinks h-title" onclick="openCity(event, 'description')">Mô tả</button>
                            <button class="tablinks h-title" onclick="openCity(event, 'technical')">Thông số kỹ thuật</button>               
                            <button class="tablinks h-title" onclick="openCity(event, 'video')">Video</button>

                            <button class="tablinks h-title" onclick="openCity(event, 'comments')">Bình luận</button>                                                                 
                        </div>
                        <div id="description" class="tabcontent">
                         <?php echo $content; ?>
                        </div>
                        <div id="technical" class="tabcontent">
                        <?php echo $technical; ?>
                        </div>
                        <div id="video" class="tabcontent">
                        <?php 
                        if(!empty($video_id)){
                            ?>
                            <center><iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video_id; ?>?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></center>
                            <?php 
                        }
                        ?>
                        </div>      
                        <div id="comments" class="tabcontent">
                            <div class="fb-comments" data-href="<?php echo $permalink; ?>" data-numposts="10"></div>
                        </div>
                    </div>
                </div>       
                <?php  
            }
            wp_reset_postdata(); 
        }
        ?>  
        <div class="row">
            <div class="col-lg-12">
                <div class="related-product">SẢN PHẨM DÀNH RIÊNG CHO BẠN</div>
                <?php                 
                $args2 = array(
                    'post_type' => 'zaproduct',  
                    'orderby' => 'id',
                    'order'   => 'DESC',     
                    'post__not_in'=>array($post_id),                                   
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'za_category',
                            'field'    => 'term_id',
                            'terms'    => array($term_id),                                  
                        ),
                    ),
                );                     
                $the_query2 = new WP_Query( $args2 );
                if($the_query2->have_posts()){
                    ?>
                    <div>
                        <script type="text/javascript" language="javascript">
                            jQuery(document).ready(function(){
                                jQuery(".product-for-you").owlCarousel({
                                    autoplay:true,                    
                                    loop:true,
                                    margin:10,                        
                                    nav:false,            
                                    mouseDrag: true,
                                    touchDrag: true,                                
                                    responsiveClass:true,
                                    responsive:{
                                        0:{
                                            items:1
                                        },
                                        600:{
                                            items:5
                                        },
                                        1000:{
                                            items:5
                                        }
                                    }
                                });                                         
                            });                
                        </script>
                        <div class="owl-carousel product-for-you owl-theme">
                            <?php 
                            while ($the_query2->have_posts()) {
                                $the_query2->the_post();
                                $post_id2=$the_query2->post->ID;                                                                        
                                $permalink2=get_the_permalink($post_id2);
                                $title2=get_the_title($post_id2);
                                $featured_img2=get_the_post_thumbnail_url($post_id2, 'full');   
                                $thumbnail2=$vHtml->getSmallImage($featured_img2);
                                $sku2=get_post_meta($post_id2,"sku",true);
                                $price2=get_post_meta($post_id2,"price",true);
                                $sale_price2=get_post_meta($post_id2,"sale_price",true);                                            
                                $html_price2='';                     
                                if((int)@$sale_price2 > 0){              
                                    $price2_off_html='<div class="price-off">'.$vHtml->fnPrice($price2).' đ</div>' ;                 
                                    $price2_on_html ='<div class="price-on">'.$vHtml->fnPrice($sale_price2).' đ</div>';                                     
                                    $html_price2=$price2_off_html . $price2_on_html ;              
                                }else{
                                    $html_price2='<div class="price-on">'.$vHtml->fnPrice($price2).' đ</div>' ;                  
                                }       
                                $intro2=get_post_meta($post_id2,"intro",true);
                                $source_manufacturer2 = wp_get_object_terms($post_id2,  'za_manufacturer' );                        
                                $manufacturer_name2='';
                                $manufacturer_link2='';
                                if(count($source_manufacturer2) > 0){
                                    $manufacturer_name2=$source_manufacturer2[0]->name;
                                    $manufacturer_link2=get_term_link($source_manufacturer2[0],'za_manufacturer');                          
                                }
                                ?>
                                <div class="box-product">
                                    <div class="box-product-img">
                                        <center><a href="<?php echo $permalink2; ?>"><img src="<?php echo $thumbnail2; ?>" alt="<?php echo $title2; ?>"></a></center>
                                    </div>
                                    <div class="manufacturer-name margin-top-10"><a href="<?php echo $manufacturer_link2; ?>"><?php echo $manufacturer_name2; ?></a></div>
                                    <div class="box-product-title margin-top-10"><a href="<?php echo $permalink2; ?>" title="<?php echo $title2; ?>" ><b><?php echo $title2; ?></b></a></div>
                                    <div class="margin-top-10"><?php echo $sku2; ?></div>
                                    <div class="box-product-intro margin-top-10">
                                        <?php echo $intro2; ?>
                                    </div>
                                    <?php echo $html_price2; ?>
                                </div>
                                <?php
                            }
                            wp_reset_postdata(); 
                            ?>
                        </div>
                    </div>
                    <?php                            
                }
                ?>
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
<?php
get_footer();
wp_footer();
?>            
