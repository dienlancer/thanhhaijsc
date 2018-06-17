<div class="col-left">
<?php 
                $k=0;
                $source_term = get_terms([
                    'taxonomy' => 'za_manufacturer',
                    'hide_empty' => false,
                ]);                                    
                foreach ($source_term as $key => $value) {
                    $term_link= get_term_link($value,'za_manufacturer');
                    $source_image= get_field( 'image','za_manufacturer_'. $value->term_id ) ;       
                    $image=$source_image['sizes']['large'];
                    if($k%3==0){
                        echo '<div class="row">';
                    }
                    ?>
                    <div class="col-lg-4"><div class="margin-top-15"><a href="<?php echo $term_link; ?>"><img src="<?php echo $image; ?>" /></a></div></div>
                    <?php
                    $k++;
                    if($k%3==0 || $k==count($source_term)){
                        echo '</div>';
                    }
                }
                ?>
</div>
<div class="col-left margin-top-15">
    <div class="filter-by-price">LỌC SẢN PHẨM THEO GIÁ</div>
    <div class="margin-top-15">
        <select name="ddlPrice">
            <option value="20000000-30000000">Từ 20.000.000 đến 30.000.000</option>
            <option value="10000000-20000000">Từ 10.000.000 đến 20.000.000</option>
            <option value="5000000-10000000">Từ 5.000.000 đến 10.000.000</option>
            <option value="1000000-5000000">Từ 1000.0000 đến 5.000.000</option>
            <option value="1000000">Dưới 1 triệu</option>
        </select>
    </div>
</div>                