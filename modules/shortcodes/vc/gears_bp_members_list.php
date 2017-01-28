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
		"icon" => plugins_url('../../../assets/images/bp-members-list.png', __FILE__),
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
					"description" => __("Select what type of members you want to display.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Max", "gears"),
					"param_name" => "max_item",
					"value" => 10,
					"description" => __("How many members you want to display.", "gears")
				)
			)
	)
);
?>
