<?php

/**
 * BuddyPress Members Visual Composer
 *
 * @since 1.0
 */

vc_map( 
	array(
		"name" => __("BP Members Carousel"),
		"base" => "gears_bp_members_carousel",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/gears-icon.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Type"),
					"admin_label" => true,
					"param_name" => "type",
					"value" => array(
							'Active' => 'active',
							'Newest' => 'newest',
							'Popular' => 'popular',
							'Online' => 'online',
							'Alphabetical' => 'alphabetical',
							'Random' => 'random'
						),
					"description" => __("The type of members you want to display.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Max"),
					"param_name" => "max_item",
					"value" => 10,
					"description" => __("The number of members you want to display.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Max Slide"),
					"param_name" => "max_slides",
					"value" => 7,
					"description" => __("Maximum number of item to display in slides.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Min Slide"),
					"param_name" => "min_slides",
					"value" => 1,
					"description" => __("Minimum number of item to display in slides. Applies to mobile.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Slide Margin"),
					"param_name" => "margin",
					"value" => 40,
					"description" => __("The spacing for each item in the carousel.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Item Width"),
					"param_name" => "item_width",
					"value" => 228,
					"description" => sprintf(__("The width of each item in the slide. Recommended maximum width is '%s'"), BP_AVATAR_FULL_WIDTH)
				)
			)
	)
);
?>