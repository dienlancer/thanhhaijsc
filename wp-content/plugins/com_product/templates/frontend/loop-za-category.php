<?php 
$product_meta_key = "_zendvn_sp_zaproduct_";                   
global $zController,$zendvn_sp_settings;
$vHtml=new HtmlControl();

$productModel=$zController->getModel("/frontend","ProductModel"); 
/* begin load config contact */
$width=$zendvn_sp_settings["product_width"];    
$height=$zendvn_sp_settings["product_height"];      
$product_number=$zendvn_sp_settings["product_number"];
/* end load config contact */

$the_query=$wp_query;

            // begin phân trang
$totalItemsPerPage=0;
$pageRange=10;
$currentPage=1; 
if(!empty($zendvn_sp_settings["product_number"])){
    $totalItemsPerPage=$product_number;        
}
if(!empty(@$_POST["filter_page"]))          {
    $currentPage=@$_POST["filter_page"];  
}
$productModel->setWpQuery($the_query);   
$productModel->setPerpage($totalItemsPerPage);        
$productModel->prepare_items();               
$totalItems= $productModel->getTotalItems();   
$the_query=$productModel->getItems();                
$arrPagination=array(
  "totalItems"=>$totalItems,
  "totalItemsPerPage"=>$totalItemsPerPage,
  "pageRange"=>$pageRange,
  "currentPage"=>$currentPage   
);    
$pagination=$zController->getPagination("Pagination",$arrPagination);
?>
<form  method="post"  class="frm" name="frm">
    <input type="hidden" name="filter_page" value="1" />
    <h3 class="mamboitaliano"><i class="icofont icofont-spoon-and-fork"></i><span><?php single_cat_title(); ?></span></h3>     
    <div>
        <?php
        if($the_query->have_posts()){
            $k=1;
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
                ?>
                <div class="box-product">
                	<div class="box-product-img">
                		<center><a href="<?php echo $permalink; ?>"><img src="<?php echo $thumbnail; ?>" alt="<?php echo $title; ?>"></a></center>
                	</div>
                	<div class="manufacturer-name margin-top-10"><a href="<?php echo $manufacturer_link; ?>"><?php echo $manufacturer_name; ?></a></div>
                	<div class="box-product-title margin-top-10"><a href="<?php echo $permalink; ?>" title="<?php echo $title; ?>" ><b><?php echo $title; ?></b></a></div>
                	<div class="margin-top-10"><?php echo $sku; ?></div>
                	<div class="box-product-intro margin-top-10">
                		<?php echo $intro; ?>
                	</div>
                	<?php echo $html_price; ?>
                </div>
                <?php
                if($k%3==0 || $k==$the_query->post_count){
                    echo '<div class="clr"></div>';
                }   
                $k++;
            }            
        }
        ?>
    </div>
    <div>
        <?php echo $pagination->showPagination();            ?>
        <div class="clr"></div>
    </div>
</form>