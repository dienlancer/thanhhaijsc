<?php 
if(have_posts()){
    while (have_posts()) {
        the_post();                     
        $post_id= get_the_id();
        $permalink=get_the_permalink($post_id);
        $title=get_the_title($post_id);                
        $excerpt=get_post_meta($post_id,"intro",true);        
        $content=get_the_content($post_id);        
        $featured_img=get_the_post_thumbnail_url($post_id, 'full');       
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
            <?php echo $content; ?>
        </div>
        <?php
    }
    wp_reset_postdata();    
}
?>