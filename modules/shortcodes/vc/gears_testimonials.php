<?php

/**
 * Gears Testimonials
 * Sample Shortcode: [gears_testimonial]
 *
 * @since 4.1.1
 */

vc_map(
	array(
		"name" => __("Gears Testimonials Carousel"),
		"base" => "gears_testimonials",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/testimonial.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Number of Testimonials", "gears"),
					"param_name" => "posts_per_page",
					"value" => 3,
					"description" => __("The total number of testimonials shown in the carousel.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Slide Margin", "gears"),
					"param_name" => "slide_margin",
					"value" => 20,
					"description" => __("The amount of spaces between each item. Do not append units like 'px' or 'em'. Sizes' units are automatically converted to pixels.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Maximum Slides", "gears"),
					"param_name" => "max_slides",
					"value" => 7,
					"description" => __("The maximum number of items per slide. May not respect the slide margin.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Minimum Slides", "gears"),
					"param_name" => "min_slides",
					"value" => 2,
					"description" => __("The minimum number of items per slide. May not respect the slide margin.", "gears")
				),

				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Item Width", "gears"),
					"param_name" => "item_width",
					"value" => 434,
					"description" => __("The width of each item. Do not append units like 'px' or 'em'. Sizes' units are automatically converted to pixels. For best result, assign 380 or more.", "gears")
				),
			)
	)
);
?>
