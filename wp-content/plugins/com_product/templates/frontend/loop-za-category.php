<?php           
            global $zController,$zendvn_sp_settings;    
            $vHtml=new HtmlControl();   
            $productModel=$zController->getModel("/frontend","ProductModel");           
            
            $totalItemsPerPage=4;
            $pageRange=10;
            $currentPage=1;  
            $q='';
            $za_category_id=0;
            if(isset($_POST['q'])){
                $q=trim($_POST['q']);
            }    
            if(isset($_POST['za_category_id'])){
                $za_category_id=(int)@$_POST['za_category_id'];
            }
            $the_query=$wp_query;
            $args = array();
            if(!empty(@$q) && $za_category_id > 0){
                $args = array(
                    'post_type' => 'zaproduct',  
                    'orderby' => 'id',
                    'order'   => 'DESC',  
                    's' => $q,                                  
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'za_category',
                            'field'    => 'term_id',
                            'terms'    => array($za_category_id),                                   
                        ),
                    ),
                );
            }else{
                if(!empty(@$q)){
                    $args = array(
                        'post_type' => 'zaproduct',  
                        'orderby' => 'id',
                        'order'   => 'DESC',  
                        's' => $q                        
                    );
                }elseif($za_category_id > 0){
                    $args = array(
                        'post_type' => 'zaproduct',  
                        'orderby' => 'id',
                        'order'   => 'DESC',               
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'za_category',
                                'field'    => 'term_id',
                                'terms'    => array($za_category_id),                                   
                            ),
                        ),
                    );
                }
            }
            if(count($args) > 0){
                $the_query = new WP_Query( $args );
            }            
            if(!empty(@$_POST["filter_page"]))          {
                $currentPage=@$_POST["filter_page"];  
            }            
            if(!empty(@$zendvn_sp_settings["product_number"])){
                $totalItemsPerPage=(int)@$zendvn_sp_settings["product_number"];        
            }
            $productModel->setWpQuery($the_query);   
            $productModel->setPerpage($totalItemsPerPage);        
            $productModel->prepare_items();               
            $totalItems= $productModel->getTotalItems();               
            $arrPagination=array(
                "totalItems"=>$totalItems,
                "totalItemsPerPage"=>$totalItemsPerPage,
                "pageRange"=>$pageRange,
                "currentPage"=>$currentPage   
            );    
            $pagination=$zController->getPagination("Pagination",$arrPagination); 
            if($the_query->have_posts()){       
                $k=0;
                echo '<form  method="post"  class="frm col-right" name="frm">';
                echo '<input type="hidden" name="filter_page" value="1" />';
                echo '<input type="hidden" name="za_category_id" value="'.@$za_category_id.'" />';
                echo '<input type="hidden" name="q" value="'.@$q.'" />';
                ?>
                <div class="row">
                    <div class="col-lg-12">                     
                        <h1 class="category-title">
                            <div>Trang chủ</div>
                            <div class="margin-left-5"><i class="fas fa-angle-right"></i></div>
                            <div class="margin-left-5"><?php single_cat_title(); ?></div>
                        </h1>
                    </div>
                </div>
                <?php
                while ($the_query->have_posts()){
                    $the_query->the_post();
                    $post_id=$the_query->post->ID;                                                                      
                    $permalink=get_the_permalink($post_id);
                    $title=get_the_title($post_id);
                    $featured_img=get_the_post_thumbnail_url($post_id, 'full'); 
                    $thumbnail=$vHtml->getSmallImage($featured_img);
                    $price=get_post_meta($post_id,"price",true);
                    $sale_price=get_post_meta($post_id,"sale_price",true);
                    $sku=get_post_meta($post_id,"sku",true);
                    $html_price='';                     
                    if((int)@$sale_price > 0){              
                        $price_off_html='<div class="price-off">'.$vHtml->fnPrice($price).' đ</div>' ;                 
                        $price_on_html ='<div class="price-on">'.$vHtml->fnPrice($sale_price).' đ</div>';                                       
                        $html_price=$price_off_html . $price_on_html ;              
                    }else{
                        $html_price='<div class="price-on">'.$vHtml->fnPrice($price).' đ</div>' ;                  
                    }       
                    $intro=get_post_meta($post_id,"intro",true);
                    $source_manufacturer = wp_get_object_terms($post_id,  'za_manufacturer' );                      
                    $manufacturer_name='';
                    $manufacturer_link='';
                    if(count($source_manufacturer) > 0){
                        $manufacturer_name=$source_manufacturer[0]->name;
                        $manufacturer_link=get_term_link($source_manufacturer[0],'za_manufacturer');                            
                    }
                    if($k%4 == 0){
                        echo '<div class="row">';
                    }
                    ?>
                    <div class="col-lg-3">
                        <div class="box-product">
                            <div class="box-product-img">
                                <center><a href="<?php echo $permalink; ?>"><img src="<?php echo $thumbnail; ?>" alt="<?php echo $title; ?>"></a></center>
                            </div>
                            <div class="manufacturer-name margin-top-10"><a href="<?php echo $manufacturer_link; ?>"><?php echo $manufacturer_name; ?></a></div>
                            <div class="box-product-title margin-top-10"><a href="<?php echo $permalink; ?>" title="<?php echo $title; ?>" ><b><?php echo $title; ?></b></a></div>
                            <div class="margin-top-10"><?php echo $sku; ?></div>                            
                            <?php echo $html_price; ?>
                        </div>
                    </div>          
                    <?php
                    $k++;
                    if($k%4==0 || $k == $the_query->post_count){
                        echo '</div>';
                    }               
                }
                wp_reset_postdata();    
                echo $pagination->showPagination();
                echo '</form>';     
            }       
            ?>