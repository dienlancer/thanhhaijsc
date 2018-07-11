
<div class="bg-slider">
    <div>
        <script type="text/javascript" language="javascript">
            jQuery(document).ready(function(){
                jQuery(".banner").owlCarousel({
                    autoplay:true,                    
                    loop:true,
                    margin:0,                        
                    nav:false,            
                    mouseDrag: true,
                    touchDrag: true,                                
                    responsiveClass:true,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:1
                        },
                        1000:{
                            items:1
                        }
                    }
                });

            });                
        </script>
        <div class="owl-carousel banner owl-theme">
            <?php 
            $slug='banner-home';
            if(!empty(get_query_var('za_category'))){
                $slug=get_query_var('za_category');
            }            
            $source_slug=array($slug);
            $args = array(
                'post_type' => 'zabanner',  
                'orderby' => 'id',
                'order'   => 'DESC',                                                  
                'tax_query' => array(
                    array(
                        'taxonomy' => 'za_banner',
                        'field'    => 'slug',
                        'terms'    => $source_slug,                                  
                    ),
                ),
            ); 
            $the_query = new WP_Query( $args );
            if($the_query->have_posts()){
                while ($the_query->have_posts()){
                    $the_query->the_post();
                    $post_id=$the_query->post->ID;  
                    $featured_img=get_the_post_thumbnail_url($post_id, 'full'); 
                    ?>
                    <div><img src="<?php echo $featured_img; ?>"></div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="categoryproductmnsc">
        <div class="vc_row wpb_row section vc_row-fluid grid_section">
            <div class="section_inner clearfix">
                <div class="section_inner_margin clearfix">
                    <div class="wpb_column vc_column_container vc_col-sm-3">
                        <div class="vc_column-inner">
                            <?php 
                            $args = array( 
                                'menu'              => '', 
                                'container'         => '', 
                                'container_class'   => '', 
                                'container_id'      => '', 
                                'menu_class'        => 'category-product-menu', 
                                'menu_id'           => '', 
                                'echo'              => true, 
                                'fallback_cb'       => 'wp_page_menu', 
                                'before'            => '', 
                                'after'             => '', 
                                'link_before'       => '', 
                                'link_after'        => '', 
                                'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',  
                                'depth'             => 3, 
                                'walker'            => '', 
                                'theme_location'    => 'category-product-menu' 
                            );
                            wp_nav_menu($args); 
                            ?>
                        </div>                            
                    </div>
                    <div class="wpb_column vc_column_container vc_col-sm-9"></div>
                </div>                
            </div>
        </div>      
    </div>
</div>
