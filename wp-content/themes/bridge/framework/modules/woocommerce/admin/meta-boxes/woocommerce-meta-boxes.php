<?php

if(!function_exists('qode_map_woocommerce_meta')) {
    function qode_map_woocommerce_meta() {
        $woocommerce_meta_box = qode_add_meta_box(
            array(
                'scope' => array('product'),
                'title' => esc_html__('Qode General', 'qode'),
                'name' => 'product_general'
            )
        );

		qode_add_meta_box_field(array(
			'name'        => 'qode_product_list_masonry_layout',
			'type'        => 'selectblank',
			'label'       => esc_html__('Dimensions for Product List Masonry', 'qode'),
			'description' => esc_html__('Choose image layout when it appears in Qode Product List - Masonry shortcode', 'qode'),
			'parent'      => $woocommerce_meta_box,
			'options'     => array(
				"default" => "Default",
				"large-width-height" => "Large Width"
			)
		));

    }
	
    add_action('qode_meta_boxes_map', 'qode_map_woocommerce_meta', 99);
}