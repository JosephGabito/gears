<?php

/**
 * BuddyPress Members Visual Composer
 *
 * @since 1.0
 */

vc_map(
	array(
		"name" => __("Pricing Table"),
		"base" => "gears_pricing_table",
		"class" => "",
		"admin_label" => true,
		"icon" => "test",
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/pricing.png', __FILE__),
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
					"value" => '',
					"description" => __("Enter the title want. Example 'Basic Membership'.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Price Label", "gears"),
					"param_name" => "price_label",
					"value" => '0.00',
					"description" => __("The pricing of this services/products offered. Example '$10.00/Month'.", "gears")
				),
				// Currency.
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Price Currency", "gears"),
					"param_name" => "price_currency",
					"value" => '$',
					"description" => __("The currency of the price. Example, '$'.", "gears")
				),
				// Pricing Type.
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Price Type Text", "gears"),
					"param_name" => "payment_type_text",
					"value" => __('Per Month', 'gears'),
					"description" => __("For example: 'Per Month', 'Per Year', or 'Annually'.", "gears")
				),
				// Button Link.
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Button Link", "gears"),
					"param_name" => "button_link",
					"value" => '',
					"description" => __("The link where you want to redirect the user after clicking the pricing table button.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Button Label", "gears"),
					"param_name" => "button_label",
					"value" => '',
					"description" => __("Add label to your button. Example 'Buy' or 'Purchase'.", "gears")
				),
				array(
					"type" => "exploded_textarea",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Features/Services Offered", "gears"),
					"param_name" => "features",
					"value" => 'Service1,Service2,!Not Available Service',
					"description" => __("List all the services you offer in this product/item/services (separate it by a newline). Prepend '!' in text to indicate the feature which is not available. Example 'Free Swag, !24/7 Customer Support'", "gears")
				),
				array(
					"type" => "checkbox",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Make this popular", "gears"),
					"param_name" => "popular",
					"value" => array(
						__('Yes, make this item popular.', "gears") => 'true'
					),
					"description" => __("Tick the checkbox to make this pricing popular. It will append a pretty nice star in the title.", "gears")
				)
			)
	)
);
?>
