<?php

/**
 * BuddyPress Groups Carousel
 *
 * @since 1.0
 */
 
// [gears_bp_groups_carousel type=’active’ max_item =’10’ max_slides=’7’ min_slides=’1’ item_width=’100’] 

vc_map( 
	array(
		"name" => __("BP Groups Carousel 2"),
		"base" => "gears_bp_groups_carousel_2",
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
					"param_name" => "type",
					"value" => array(
							'Active' => 'active',
							'Newest' => 'newest',
							'Popular' => 'popular',
							'Alphabetical' => 'alphabetical',
							'Most Forum Topics' => 'most-forum-topics',
							'Most Forum Posts' => 'most-forum-posts',
							'Random' => 'random'
						),
					"description" => __("The type of members you want to display.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Max"),
					"param_name" => "max_item",
					"value" => 12,
					"description" => __("The number of members you want to display.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Max Slides"),
					"param_name" => "max_slides",
					"value" => 7,
					"description" => __("The maximum number of item to show per slide.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Min Slides"),
					"param_name" => "min_slides",
					"value" => 1,
					"description" => __("The minimum number of item to show per slide.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Slide Margin"),
					"param_name" => "slide_margin",
					"value" => 20,
					"description" => __("The spacing for each item in the carousel.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Item Width"),
					"param_name" => "item_width",
					"value" => '223',
					"description" => sprintf(__("The width of each item (ex. '223'). Recommended maximum width '%s'"),BP_AVATAR_FULL_WIDTH)
				)
			)
	)
);
?>