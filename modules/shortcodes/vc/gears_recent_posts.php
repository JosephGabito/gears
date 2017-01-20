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
		"icon" => plugins_url('../../../assets/images/recent-post.png', __FILE__),
		"category" => __('Gears'),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Number of Post(s)", "gears"),
					"param_name" => "posts_per_page",
					"value" => 3,
					"description" => __("Enter the maximum number of post(s).", "gears")
				)
			)
	)
);
?>
