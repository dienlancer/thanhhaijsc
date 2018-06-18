<?php           
            global $zController,$zendvn_sp_settings;    
            $vHtml=new HtmlControl();   
            $productModel=$zController->getModel("/frontend","ProductModel");           
            
            $totalItemsPerPage=4;
            $pageRange=10;
            $currentPage=1;                                           
            $args=array(
                'post_type' => 'zaproduct',
                'orderby'=>'id',
                'order'=>'DESC'
            );                    
            if(!empty(get_query_var('za_category'))){
                $args = array(
                    'post_type' => 'zaproduct',  
                    'orderby' => 'id',
                    'order'   => 'DESC',                                                  
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'za_category',
                            'field'    => 'slug',
                            'terms'    => array(get_query_var('za_category')),                                  
                        ),
                    ),
                ); 
            }  
            if(!empty(get_query_var('za_manufacturer'))){
                $args = array(
                    'post_type' => 'zaproduct',  
                    'orderby' => 'id',
                    'order'   => 'DESC',                                                  
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'za_manufacturer',
                            'field'    => 'slug',
                            'terms'    => array(get_query_var('za_manufacturer')),                                  
                        ),
                    ),
                ); 
            }           
            $q='';
            $za_category_id=0;
            if(isset($_POST['q'])){
                $q=trim($_POST['q']);
            }    
            if(isset($_POST['za_category_id'])){
                $za_category_id=(int)@$_POST['za_category_id'];
            }               
            if(!empty(@$q) && (int)@$za_category_id > 0){
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
                }elseif((int)@$za_category_id > 0){
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
            $price='';
            $source_price=array();
            if(isset($_POST['list_price'])){
            	$price=@$_POST['list_price'];
            }
            if(!empty(@$price)){            	
            	$source_price=explode('-', @$price);
            	$source_price2=$source_price;
            	if(count(@$source_price)== 1){
            		$source_price2=array(1,@$source_price[0]);
            	}
            	$args = array(
            		'post_type' => 'zaproduct',            		
            		'orderby'=>'id',
            		'order'=>'DESC',
            		'meta_query' => array(
            			array(
            				'key'     => 'price',
            				'value'   => $source_price2,
            				'type' => 'numeric',
            				'compare' => 'BETWEEN'
            			),
            		),
            	);
            }                                             
            $the_query = new WP_Query( $args );                       
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
                echo '<form  method="post"  class="frm" name="frm">';
                echo '<input type="hidden" name="filter_page" value="1" />';
                echo '<input type="hidden" name="za_category_id" value="'.@$za_category_id.'" />';
                echo '<input type="hidden" name="q" value="'.@$q.'" />';  
                echo '<input type="hidden" name="list_price" value="'.@$price.'" />';                
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
                    if((int)@$price > 0){
                    	if((int)@$sale_price > 0){              
                    		$price_off_html='<div class="price-off">'.$vHtml->fnPrice($price).' đ</div>' ;                 
                    		$price_on_html ='<div class="price-on">'.$vHtml->fnPrice($sale_price).' đ</div>';                                       
                    		$html_price=$price_off_html . $price_on_html ;              
                    	}else{
                    		$html_price='<div class="price-on">'.$vHtml->fnPrice($price).' đ</div>' ;                  
                    	}
                    }else{
                    	$html_price='<div class="price-on">LIÊN HỆ</div>' ;                  
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
                    <div class="col-sm-3">
                        <div class="box-product">
                            <div class="box-product-img bg-slider">
                                <center><a href="<?php echo @$permalink; ?>"><img src="<?php echo @$thumbnail; ?>" alt="<?php echo @$title; ?>"></a></center>
                                <?php 
                                if((int)@$sale_price > 0){
                                	?>
                                	<div class="sale"><img src="<?php echo site_url('wp-content/uploads/sale.png'); ?>"></div>
                                	<?php
                                }
                                ?>                                
                            </div>
                            <?php 
                            if(!empty(@$manufacturer_link) && !empty(@$manufacturer_name)){
                            	?>
                            	<div class="manufacturer-name margin-top-10"><a href="<?php echo @$manufacturer_link; ?>"><?php echo @$manufacturer_name; ?></a></div>
                            	<?php
                            }
                            ?>                            
                            <div class="box-product-title margin-top-10"><a href="<?php echo @$permalink; ?>" title="<?php echo @$title; ?>" ><b><?php echo @$title; ?></b></a></div>
                            <?php 
                            if(!empty(@$sku)){
                            	?>
                            	<div class="margin-top-10"><?php echo @$sku; ?></div>   
                            	<?php
                            }                            
                            if(!empty(@$intro)){
                            	?>
                            	<div class="box-product-intro margin-top-10">
                            		<?php echo $intro; ?>
                            	</div>                       
                            	<?php
                            }												
                            echo @$html_price; 
                            ?>                 
                            <div class="thia margin-top-10">
                            	<?php 
                            	if((int)@$price > 0){
                            		?>
                            		<a href="javascript:void(0);" data-toggle="modal" data-target="#modal-alert-add-cart" onclick="javascript:addToCart(<?php echo @$post_id; ?>,1);" >
                            			<img  src="<?php echo site_url('wp-content/uploads/mua-ngay.png'); ?>">                           
                            		</a>
                            		<?php
                            	}else{
                            		?>
                            		<a href="<?php echo site_url('lien-he'); ?>" >
                            			<img  src="<?php echo site_url('wp-content/uploads/mua-ngay.png'); ?>">                           
                            		</a>
                            		<?php
                            	}
                            	?>                                
                            </div>
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