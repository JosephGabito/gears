<?php

/**
 * BuddyPress Groups List
 *
 * @since 4.1.1
 */

// [gears_recent_posts posts_per_page=”3” ignore_sticky_posts=”true”]

vc_map(
	array(
		"name" => __("Gears Portfolio"),
		"base" => "gears_portfolio",
		"class" => "",
		"admin_label" => true,
		"icon" => plugins_url('../../../assets/images/portfolio.png', __FILE__),
		"category" => __('Gears'),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("ID", "gears"),
					"param_name" => "id",
					"value" => "",
					"description" => __("Add your custom ID.", "gears")
				),
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Columns", "gears"),
					"param_name" => "columns",
                    "value" => array(
							__('3', "gears") => '3',
							__('1', "gears") => '1',
							__('2', "gears") => '2',
							__('3', "gears") => '3',
							__('4', "gears") => '4',
							__('5', "gears") => '5',
							__('6', "gears") => '6'
						),
					"description" => __("Choose number of columns to display.", "gears")
				),
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Style", "gears"),
					"param_name" => "style",
                    "value" => array(
							__('Grid', "gears") => 'grid',
							__('Wide', "gears") => 'wide',
							__('Border', "gears") => 'border',
							__('Classic', "gears") => 'classic',
							__('Modern', "gears") => 'modern',
							__('Minimalist', "gears") => 'minimalist',
							__('Masonry Grid', "gears") => 'masonry-grid',
							__('Masonry Wide', "gears") => 'masonry-wide',
							__('Masonry Border', "gears") => 'masonry-border',
							__('Masonry Classic', "gears") => 'masonry-classic',
							__('Masonry Modern', "gears") => 'masonry-modern',
							__('Masonry Minimalist', "gears") => 'masonry-minimalist'

						),
					"description" => __("Choose the style for the column to be display.", "gears")
				),
				array(
					"type" => "textfield",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Posts Per Page", "gears"),
					"param_name" => "posts_per_page",
					"value" => absint( get_option( 'posts_per_page' ) ),
					"description" => __("Number of items to display.", "gears")
				),
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Sort By", "gears"),
					"param_name" => "sort",
                    "value" => array(
							__('Ascending', "gears") => 'asc',
							__('Descending', "gears") => 'desc',
							__('Alphabetical', "gears") => 'alphabetical',
							__('Random', "gears") => 'random'
						),
					"description" => __("Choose the sorting of the items.", "gears")
				),
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Show Category", "gears"),
					"param_name" => "show_category",
                    "value" => array(
							__('True', "gears") => 'true',
							__('False', "gears") => 'false'
						),
					"description" => __("Do you want to display the category of each item.", "gears")
				),
				array(
					"type" => "dropdown",
					"holder" => "",
					"class" => "",
					"admin_label" => true,
					"heading" => __("Tile Layout", "gears"),
					"param_name" => "tile_layout",
                    "value" => array(
							__('True', "gears") => 'true',
							__('False', "gears") => 'false'
						),
					"description" => __("Do you want to display the category of each item.", "gears")
				)
			)
	)
);
?>
