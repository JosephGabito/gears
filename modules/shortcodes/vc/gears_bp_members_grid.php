<?php

/**
 * BuddyPress Members Grid Visual Composer
 *
 * @since 1.0
 */
//[gears_bp_members_grid type="alphabetical" max_item="12" size="2"]
vc_map( 
	array(
		"name" => __("BP Members Grid"),
		"base" => "gears_bp_members_grid",
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