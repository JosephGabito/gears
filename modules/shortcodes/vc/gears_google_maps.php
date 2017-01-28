<?php
/**
 * Google Map Shortcode Visual Composer Mapping.
 *
 * @since  4.1.1
 * @package gears\modules\shortcodes\vc
 * @author  joseph g.
 */
if ( ! defined( 'ABSPATH') ) exit;

$geo_tool_uri = "http://www.mapcoordinates.net/en";

vc_map(
	array(
		"name" => __("Gears Google Map"),
		"base" => "gears_google_map",
		"class" => "",
		"admin_label" => true,
		"category" => __('Gears'),
		"icon" => plugins_url('../../../assets/images/gears-icon.png', __FILE__),
		'admin_enqueue_js' => array(),
		'admin_enqueue_css' => array(),
		"params" => array(
			// Map Height
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Map Height", "gears"),
				"param_name" => "map_height",
				"value" => '450',
				"description" => __("Enter the height of the map. Value will be automatically converted to pixels (px)", "gears")
			),
			// Marker Title.
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => true,
				"heading" => __("Marker Title", "gears"),
				"param_name" => "marker_title",
				"value" => __("Type your info bubble title here. For example, 'Our Office'.", "gears"),
				"description" => __("The title of the marker's info bubble.", "gears")
			),
			// Marker Description.
			array(
				"type" => "textarea",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Marker Description", "gears"),
				"param_name" => "marker_description",
				"value" => __("Type your info bubble description here. You can usually explain what this place is all about.", "gears"),
				"description" => __("The description of the marker's info bubble.", "gears")
			),
			// Latitude.
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => true,
				"heading" => __("Latitude", "gears"),
				"param_name" => "latitude",
				"value" => '-37.817214',
				"description" => sprintf( __("The latitude of the place. Replace the default latitude value with your own address' latitude. %s to know the latitude of your address.", "gears"), '<a href="'.esc_url( $geo_tool_uri ).'" title="'.__('Discover Address Latitude', 'gears').'">' . __('Click here', 'gears') . '</a>')
			),
			// Longitude.
			array(
				"type" => "textfield",
				"holder" => "",
				"class" => "",
				"admin_label" => true,
				"heading" => __("Longitude", "gears"),
				"param_name" => "longitude",
				"value" => '-144.955925',
				"description" => sprintf( __("The longitude of the place. Replace the default longitude value with your own address' longitude. %s to know the longitude of your address.", "gears"), '<a href="'.esc_url( $geo_tool_uri ).'" title="'.__('Discover Address Longitude', 'gears').'">' . __('Click here', 'gears') . '</a>')
			),
			// Zoom Level
			array(
				"type" => "dropdown",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Zoom Level", "gears"),
				"param_name" => "zoom_level",
				"description" => __( 'Select the default zoom level ranging from 10 to 20.', 'gears' ),
				"value" => array(10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20)
			),
			// Infowindow
			array(
				"type" => "dropdown",
				"holder" => "",
				"class" => "",
				"admin_label" => false,
				"heading" => __("Info Window", "gears"),
				"param_name" => "infowindow_open",
				"description" => __( 'Do you want the info bubble window to open by default.', 'gears' ),
				"value" => array(
						__( 'No', 'gears' ) => 0,
						__( 'Yes', 'gears' ) => 1,
					)
			)
		)
	)
);