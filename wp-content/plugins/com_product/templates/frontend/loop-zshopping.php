<?php 
global $zController,$zendvn_sp_settings;    
$vHtml=new HtmlControl();
$data = get_terms( array(
                          'taxonomy' => 'za_category',
                          'hide_empty' => false,  ) );
?>
<form  method="post"  class="frm" name="frm">
    <input type="hidden" name="filter_page" value="1" /> 
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
    <div class="container margin-bottom-15">
        <div>
            <?php 
        if(count($data) > 0){
            $k=1  ; 
            foreach ($data as $key => $value) {
                $term = get_term( $value,'za_category');  
                $id=$term->term_id;
                $title=$term->name;    
                $slug=$term->slug;             
                $permalink=get_term_link($term,'za_category');                    
                $excerpt=$term->description;   
                $excerpt=substr($excerpt, 0,100).'...';       
                $featureImg = get_field( 'image',$term);                     
                ?>
                <div class="col-sm-3 no-padding-left">
                    <div class="margin-top-15">
                        <div><center><a href="<?php echo $permalink; ?>"><figure><img src="<?php echo $featureImg['url']; ?>" /></figure></a></center></div>
                        <div class="product-article">
                            <div class="product-home-title margin-top-15"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></div>
                            <div class="article-home-excerpt margin-top-15"><?php echo $excerpt; ?></div>
                            <div class="about-us-readmore-2 margin-top-20"><a href="<?php echo $permalink; ?>">Xem thêm<i class="icofont icofont-curved-double-right"></i></a></div>        
                            <div class="clr"></div>
                        </div>                                           
                    </div>                        
                </div>
                <?php
                if($k%4 ==0 || $k==count($data)){
                    echo '<div class="clr"></div>';
                }
                $k++;
            }
        }
        ?>
        </div>        
    </div>
</form>