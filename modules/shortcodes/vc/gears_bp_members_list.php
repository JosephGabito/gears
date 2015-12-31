<?php

/**
 * BuddyPress Members Grid Visual Composer
 * Sample Shortcode: [gears_bp_groups_list type="popular" max_item="16"]
 *
 * @since 1.0
 */

vc_map( 
	array(
		"name" => __("BP Members List"),
		"base" => "gears_bp_members_list",
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
							'Online' => 'online',
							'Alphabetical' => 'alphabetical',
							'Random' => 'random'
						),
					"description" => __("Select what type of members you want to display.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Max"),
					"param_name" => "max_item",
					"value" => 10,
					"description" => __("How many members you want to display.")
				)
			)
	)
);
?>