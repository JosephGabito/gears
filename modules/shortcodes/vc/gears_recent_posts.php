<?php

/**
 * BuddyPress Groups List
 *
 * @since 4.1.1
 */

// [gears_recent_posts posts_per_page=”3” ignore_sticky_posts=”true”]

vc_map(
	array(
		"name" => __("Gears Recent Post"),
		"base" => "gears_recent_posts",
		"class" => "",
		"admin_label" => true,
		"icon" => plugins_url('../../../assets/images/gears-icon.png', __FILE__),
		"category" => __('Gears'),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Type", "gears"),
					"param_name" => "posts_per_page",
					"value" => 12,
					"description" => __("Declare the number of members you want to display.", "gears")
				),
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Ignore Sticky Posts", "gears"),
					"param_name" => "ignore_sticky_posts",
                    "value" => array(
							__('True', "gears") => 'true',
							__('False', "gears") => 'false'
						),
					"description" => __("Do you want to ignore sticky posts.", "gears")
				)
			)
	)
);
?>
