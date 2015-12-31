<?php

/**
 * BuddyPress Groups Grid
 *
 * @since 1.0
 */
 
// [gears_bp_groups_grid type=”” max_item=”” size=””]

vc_map( 
	array(
		"name" => __("BP Groups Grid"),
		"base" => "gears_bp_groups_grid",
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
					"description" => __("Select what type of members you want to display.")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Max"),
					"param_name" => "max_item",
					"value" => 12,
					"description" => __("How many members you want to display.")
				),
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Columns"),
					"param_name" => "columns",
					"value" => array(
							'4' => '3',
							'2' => '2',
							'3' => '4',
							'6' => '6'
						),
					"description" => __("Select the number of columns.")
				)
			)
	)
);
?>