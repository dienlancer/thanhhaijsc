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