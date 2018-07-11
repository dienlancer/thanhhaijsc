<?php 
$post_id=0;
$term_id=0;
if(have_posts()){
    ?>
    <div class="box-news">
        <div class="vc_row wpb_row section vc_row-fluid grid_section">
            <div class="section_inner clearfix">
                <div class="section_inner_margin clearfix">
                    <div class="wpb_column vc_column_container vc_col-lg-12">
                        <div class="vc_column-inner">
                            <?php 
                        while (have_posts()) {
                            the_post();                     
                            $post_id= get_the_id();
                            $permalink=get_the_permalink($post_id);
                            $title=get_the_title($post_id);                
                            $excerpt=get_post_meta($post_id,"intro",true);                       
                            $featured_img=get_the_post_thumbnail_url($post_id, 'full'); 
                            $term = wp_get_object_terms( $post_id,  'category' );                           
                            if($term != null){
                                $term_id=$term[0]->term_id;                          
                                $term_name=$term[0]->name;
                                $term_slug=$term[0]->slug;           
                            }                                
                            ?>
                            <h1 class="single-title"><?php echo $title; ?></h1>
                            <?php 
                            if(!empty($excerpt)){
                                ?>
                                <div class="margin-top-15 content-align intro">
                                    <?php echo $excerpt; ?>
                                </div>
                                <?php
                            }
                            ?>        
                            <div class="margin-top-15 content-align">
                                <?php the_content(); ?>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();    
                        ?>
                        </div>                        
                    </div>
                </div>
                <?php 
                $args2 = array(
                    'post_type' => 'post',  
                    'orderby' => 'id',
                    'order'   => 'DESC',     
                    'post__not_in'=>array($post_id),                                                      
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => array($term_id),                                  
                        ),
                    ),
                );                     
                $the_query2 = new WP_Query( $args2 );   
                if($the_query2->have_posts()){
                    ?>
                    <div class="section_inner_margin clearfix">
                        <div class="wpb_column vc_column_container vc_col-lg-12">
                            <div class="vc_column-inner">
                                <div class="related-news">Tin liên quan</div>
                                <div class="related-news-lst">
                                    <ul>
                                        <?php 
                                        while ($the_query2->have_posts()) {
                                            $the_query2->the_post();                     
                                            $post_id2= get_the_id();
                                            $permalink2=get_the_permalink($post_id2);
                                            $title2=get_the_title($post_id2);
                                            ?>
                                            <li><a href="<?php echo $permalink2; ?>"><?php echo $title2; ?></a></li>
                                            <?php              
                                        }
                                        wp_reset_postdata();    
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }                   
                ?> 
            </div>
        </div>        
    </div>  
<?php    
}
?>