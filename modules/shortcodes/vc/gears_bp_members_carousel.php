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
		"icon" => plugins_url('../../../assets/images/bp-members-carousel.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Type", "gears"),
					"admin_label" => true,
					"param_name" => "type",
					"value" => array(
							__('Active', "gears") => 'active',
							__('Newest', "gears") => 'newest',
							__('Popular', "gears") => 'popular',
							__('Online', "gears") => 'online',
							__('Alphabetical', "gears") => 'alphabetical',
							__('Random', "gears") => 'random'
						),
					"description" => __("The type of members you want to display.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Max", "gears"),
					"param_name" => "max_item",
					"value" => 10,
					"description" => __("The number of members you want to display.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Max Slide", "gears"),
					"param_name" => "max_slides",
					"value" => 7,
					"description" => __("Maximum number of item to display in slides.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Min Slide", "gears"),
					"param_name" => "min_slides",
					"value" => 1,
					"description" => __("Minimum number of item to display in slides. Applies to mobile.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Slide Margin", "gears"),
					"param_name" => "margin",
					"value" => 40,
					"description" => __("The spacing for each item in the carousel.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"admin_label" => true,
					"heading" => __("Item Width", "gears"),
					"param_name" => "item_width",
					"value" => 228,
					"description" => sprintf(__("The width of each item in the slide. Recommended maximum width is '%s'", "gears"), BP_AVATAR_FULL_WIDTH)
				)
			)
	)
);
?>
