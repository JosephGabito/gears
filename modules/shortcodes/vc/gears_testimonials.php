<?php

/**
 * Gears Testimonials
 * Sample Shortcode: [gears_login]
 *
 * @since 4.1.1
 */

vc_map(
	array(
		"name" => __("Gears Testimonials"),
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
					"heading" => __("Title", "gears"),
					"param_name" => "title",
					"value" => __('Members Activity Stream'),
					"description" => __("Leave blank to disable widget title.", "gears")
				)
			)
	)
);
?>
