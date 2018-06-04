<?php

if(!function_exists('qode_video_box_styles')) {

    function qode_video_box_styles() {

		$circle_selector = '.qode_video_box .qode_video_image .qode_video_box_button';
		$circle_hover_selector = '.qode_video_box .qode_video_image:hover .qode_video_box_button';
		$icon_selector = '.qode_video_box .qode_video_image .qode_video_box_button_arrow';
		$icon_hover_selector = '.qode_video_box .qode_video_image:hover .qode_video_box_button_arrow';

        $circle_color = qode_options()->getOptionValue('video_box_circle_color');
        if(!empty($circle_color)) {
			echo qode_dynamic_css($circle_selector, array('background-color' => $circle_color));
        }

        $circle_hover_color = qode_options()->getOptionValue('video_box_circle_hover_color');
        if(!empty($circle_hover_color)) {
			echo qode_dynamic_css($circle_hover_selector, array('background-color' => $circle_hover_color));
        }

        $icon_color = qode_options()->getOptionValue('video_box_icon_color');
        if(!empty($icon_color)) {
			echo qode_dynamic_css($icon_selector, array('border-left-color' => $icon_color));
        }

        $icon_hover_color = qode_options()->getOptionValue('video_box_icon_hover_color');
        if(!empty($icon_hover_color)) {
			echo qode_dynamic_css($icon_hover_selector, array('border-left-color' => $icon_hover_color));
        }

    }

    add_action('qode_style_dynamic', 'qode_video_box_styles');
}
