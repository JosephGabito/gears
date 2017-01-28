<?php
/**
 * Fancy Counters Visual Composer Mapping.
 *
 * @since  4.1.1
 * @package gears\modules\shortcodes\vc
 * @author  joseph g.
 */
if ( ! defined( 'ABSPATH') ) exit;

/*
	'value' => 1000,
	'symbol' => '',
	'unit' => '%',
	'description' => __('This is a text that you can use to explain what this counter is all about.', 'gears'),
	'style' => 'solid', // or transparent
	'color' => '#444',
	'background_color' => '#eee',
	'border_color' => '#222',
 */

vc_map(
	array(
		"name" => __("Gears Counters"),
		"base" => "gears_counter",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/gears-icon.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
			// Value
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => true,
				"heading" => __("Value", "gears"),
				"param_name" => "value",
				"value" => 1000,
				"description" => __("Enter the value of the counter shortcode..", "gears")
			),
			// Symbol
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Symbol", "gears"),
				"param_name" => "symbol",
				"value" => '$',
				"description" => __("Enter the symbol of the counter shortcode.", "gears")
			),
			// Unit
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Unit", "gears"),
				"param_name" => "unit",
				"value" => '%',
				"description" => __("The unit of the counter shortcode.", "gears")
			),
			// Description
			array(
				"type" => "textarea",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Description", "gears"),
				"param_name" => "description",
				"value" => '',
				"description" => __('This is a text that you can use to explain what this counter is all about.', 'gears'),
			),
			// Style
			array(
				"type" => "dropdown",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Style", "gears"),
				"param_name" => "style",
				"description" => __("Select a style. Could either be solid or transparent.", "gears"),
				"value" => array(
						__('Solid', 'gears') => 'solid',
						__('Transparent', 'gears') => 'transparent',
					),
			),
			// Color
			array(
				"type" => "colorpicker",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Color", "gears"),
				"param_name" => "color",
				"description" => __("The foreground color for this counter shortcode.", "gears"),
				"value" => '#444444',
			),
			// Background Color
			array(
				"type" => "colorpicker",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Background Color", "gears"),
				"param_name" => "background_color",
				"value" => '#eeeeee',
				"description" => __("The background fill for the counter shortcode.", "gears"),
			),
			// Border Color
			array(
				"type" => "colorpicker",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Border Color", "gears"),
				"param_name" => "border_color",
				"value" => '#222222',
				"description" => __("The border color for this counter shortcode.", "gears")
			),
		)
	)
);