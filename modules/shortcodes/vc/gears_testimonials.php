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
		"icon" => plugins_url('../../../assets/images/gears-icon.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array()
	)
);
?>
