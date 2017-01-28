<?php

/**
 * BuddyPress Groups List
 *
 * @since 1.0
 */

// [gears_bp_groups_grid type=”” max_item=”” size=””]

vc_map(
	array(
		"name" => __("BP Groups List"),
		"base" => "gears_bp_groups_list",
		"class" => "",
		"admin_label" => true,
		"icon" => plugins_url('../../../assets/images/bp-groups-list.png', __FILE__),
		"category" => __('Gears'),
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
					"description" => __("Select what type of members you want to display.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Max", "gears"),
					"param_name" => "max_item",
					"value" => 12,
					"description" => __("How many members you want to display.", "gears")
				)
			)
	)
);
?>
