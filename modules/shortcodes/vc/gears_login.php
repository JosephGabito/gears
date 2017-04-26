<?php

/**
 * Gears Login Visual Composer
 * Sample Shortcode: [gears_login]
 *
 * @since 4.1.1
 */

vc_map(
	array(
		"name" => __("Gears Login"),
		"base" => "gears_login",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/login.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		'params' => array(
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => true,
				"heading" => __("ID", "gears"),
				"param_name" => "id",
				"value" => "",
				"description" => __("If you are hooking the form through JS, you can add a custom element ID here.", "gears")
			),
		)
	)
);
?>
