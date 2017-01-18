<?php

/**
 * BuddyPress Members Carousel 2 Visual Composer
 *
 * @since 2.0
 */

// [gears_bp_groups_carousel_2 type=’active’ max_item =’10’ max_slides=’7’ min_slides=’1’ item_width=’100’]

vc_map(
	array(
		"name" => __("BP Members Carousel 2"),
		"base" => "gears_bp_members_carousel_2",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/bp-members-carousel-2.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Type", "gears"),
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
					"heading" => __("Slide Margin", "gears"),
					"param_name" => "slide_margin",
					"value" => 20,
					"description" => __("The spacing for each item in the carousel.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Item Width", "gears"),
					"param_name" => "item_width",
					"value" => 320,
					"description" => sprintf(__("The width of each item in the slide. Recommended maximum width is '%s'", "gears"), 320)
				)
			)
	)
);
?>
