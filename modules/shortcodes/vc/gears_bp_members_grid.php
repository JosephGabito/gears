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
		"icon" => plugins_url('../../../assets/images/bp-members-grid.png', __FILE__),
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
				),
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Columns", "gears"),
					"param_name" => "columns",
					"value" => array(
						__('3 Columns', 'gears') => '3-columns',
						__('2 Columns', 'gears') => '2-columns',
						__('4 Columns', 'gears') => '4-columns',
						__('6 Columns', 'gears') => '6-columns',
					),
					"description" => __("Select the number of columns.", "gears")
				)
			)
	)
);
?>
