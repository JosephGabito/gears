<?php
/**
 * BuddyPress Groups Carousel
 *
 * @since 1.0
 */

// [gears_bp_groups_carousel type=’active’ max_item =’10’ max_slides=’7’ min_slides=’1’ item_width=’100’]

vc_map(
	array(
		"name" => __("BP Groups Carousel"),
		"base" => "gears_bp_groups_carousel",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/bp-groups-carousel.png', __FILE__),
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
							__('Alphabetical', "gears") => 'alphabetical',
							__('Most Forum Topics', "gears") => 'most-forum-topics',
							__('Most Forum Posts', "gears") => 'most-forum-posts',
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
					"value" => 12,
					"description" => __("The number of members you want to display.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Max Slides", "gears"),
					"param_name" => "max_slides",
					"value" => 7,
					"description" => __("The maximum number of item to show per slide.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Min Slides", "gears"),
					"param_name" => "min_slides",
					"value" => 1,
					"description" => __("The minimum number of item to show per slide.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Slide Margin", "gears"),
					"param_name" => "slide_margin",
					"value" => 0,
					"description" => __("The spacing for each item in the carousel.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Item Width", "gears"),
					"param_name" => "item_width",
					"value" => '223',
					"description" => sprintf(__("The width of each item (ex. '223'). Recommended maximum width '%s'", "gears"),BP_AVATAR_FULL_WIDTH)
				)
			)
	)
);
?>
